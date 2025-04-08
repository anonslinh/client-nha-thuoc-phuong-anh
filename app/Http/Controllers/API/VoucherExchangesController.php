<?php


namespace App\Http\Controllers\API;
use App\Models\DailyActivitySummary;
use App\Services\KiotVietService;
use Illuminate\Http\Request;
use App\Models\VoucherExchanges;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\CustomerPointLog;
use Illuminate\Support\Facades\Http;
use function Carbon\this;


class VoucherExchangesController extends HelperApiController
{
    protected $kiotVietService;
    protected $urlKiotViet;

    public function __construct(KiotVietService $kiotVietService) {
        $this->kiotVietService = $kiotVietService;
        $this->urlKiotViet = $kiotVietService->urlKiotviet();

    }

    /**
     * Đổi điểm thành voucher giảm giá
    */
    public function exchangeVoucher(Request $request)
    {
        DB::beginTransaction();

        try {

            // Validate đầu vào
            $validatedData = $request->validate([
                'phone' => ['required', 'regex:/^(0[1-9][0-9]{8,9}|84[1-9][0-9]{8,9})$/'],
                'voucher_id' => ['required', 'exists:vouchers,id'],
                'branch_id' => ['required', 'exists:branches,id'], // Đảm bảo branch_id tồn tại
                'account_code' => ['required', 'exists:account_branches,code'],
            ], [
                'branch_id.required' => 'Mã chi nhánh là bắt buộc.',
                'branch_id.exists' => 'Chi nhánh không tồn tại.',
                'voucher_id.required' => 'Mã voucher là bắt buộc.',
                'voucher_id.exists' => 'Voucher không tồn tại.',
                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại không hợp lệ.',
                'account_code.required' => 'Chọn cửa hàng là bắt buộc.',
                'account_code.exists' => 'Cửa hàng không tồn tại.',
            ]);

            $phone = $this->normalizePhone($validatedData['phone']);
            $voucherId = $validatedData['voucher_id'];

            // Lấy thông tin khách hàng
            $customer = Customer::where('contact_number', $phone)->first();

            //Ghi log đếm số lượng đổi quà đổi voucher
            DailyActivitySummary::logAction($customer ? $customer->kiotviet_id : null, 'redeem_gift_voucher');

            if (!$customer) {
                return response()->json(['status' => false, 'message' => 'Không đủ điểm để đổi voucher'], 200);
            }

            // Lấy thông tin voucher
            $voucher = Voucher::find($voucherId);
            if (!$voucher) {
                return response()->json(['status' => false, 'message' => 'Voucher không tồn tại'], 200);
            }

            //Tìm kiếm dữ liệu để tạo voucher trên kiotviet
            $release_code = null;
            $result = json_decode($voucher->release_code, true);
            for ($i = 0; $i < count($result); $i++) {
                if ($result[$i]['code'] === $request->account_code) {
                    $release_code = $result[$i];
                    break; // Dừng ngay khi tìm thấy
                }
            }
            //Kết thúc tìm kiếm dữ liệu

            $pointsRequired = $voucher->points_required;

            // Kiểm tra khách hàng có đủ điểm không
            if ($customer->reward_point < $pointsRequired) {
                return response()->json(['status' => false, 'message' => 'Không đủ điểm để đổi voucher'], 200);
            }

            // Trừ điểm khách hàng
            $customer->decrement('reward_point', $pointsRequired);
            $customer->increment('used_points', $pointsRequired);

            // Lưu log số điểm đã dùng
            CustomerPointLog::updateUsedPoints($customer->kiotviet_id, $pointsRequired, 'increase');

            // Tạo mã đổi voucher lấy từ kiotviet
            $exchangeCode = 'WIN' . strtoupper(Str::random(10)) . '.VC';

            $_dataPost = [
                'account_code' => $release_code['code'],
                'voucher_campaign_id' => $release_code['voucher_campaign_id'],
                'exchange_code' => $exchangeCode
            ];

            $_check_created_voucher = $this->createdVoucherKiotviet($_dataPost);
            if (empty($_check_created_voucher)){
                return response()->json(['status' => false, 'message' => 'Chúng tôi đang cập nhật hệ thống! Vui lòng thử lại sau.'], 200);
            }

            // Lưu vào bảng voucher_exchanges
            $exchange = VoucherExchanges::create([
                'customer_id' => $customer->kiotviet_id,
                'contact_phone' => $customer->contact_number,
                'voucher_id' => $voucherId,
                'branch_id' => $request->branch_id ?? null,
                'discount_amount' => $voucher->discount_amount,
                'exchange_code' => $exchangeCode,
                'points_used' => $pointsRequired,
                'exchange_date' => now(),
                'status' => 'pending',
                'account_code' => $release_code['code'],
                'release_code' => $release_code['release_code'],
                'voucher_campaign_id' => $release_code['voucher_campaign_id']
            ]);

            DB::commit();

            return response()->json(['status' => true, 'message' => 'Đổi voucher thành công', 'data' => $exchange], 200);

        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json(['error' => $exception->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Đổi voucher thất bại', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Tạo voucher dựa trên bản phát hành của
     * param account_code, voucher_campaign_id, exchange_code
    */
    public function createdVoucherKiotviet($dataPost){
        try{
            $tokens = $this->kiotVietService->getAccessTokenAllBranches($dataPost['account_code']);
            $accessToken = $tokens->access_token;
            $retailer = $tokens->retailer;
            $response = Http::withHeaders([
                'Retailer'      => $retailer,
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->post($this->urlKiotViet['url_voucher_created'], [
                'voucherCampaignId' => $dataPost['voucher_campaign_id'],
                'data' => [
                    ['code' => $dataPost['exchange_code']]
                ]
            ]);

            if ($response->failed()) {
                return false;
            }

            return true;
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * Huỷ phát hành voucher ở kiotviet
    */
    public function cancelVoucherKiotviet($dataPost){
        try{
            $tokens = $this->kiotVietService->getAccessTokenAllBranches($dataPost['account_code']);
            $accessToken = $tokens->access_token;
            $retailer = $tokens->retailer;
            $response = Http::withHeaders([
                'Retailer'      => $retailer,
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->post($this->urlKiotViet['url_voucher_cancel'], [
                'CampaignId' => $dataPost['voucher_campaign_id'],
                'Vouchers' => [
                    ['Code' => $dataPost['exchange_code']]
                ]
            ]);

            if ($response->failed()) {
                return false;
            }

            return true;
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * danh sách voucher đã đổi theo số điện thoại
    */
    public function getVouchersByPhone(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $phone = $this->normalizePhone($request->phone);

        $customer = Customer::where('contact_number', $phone)->first();
        if (!$customer) {
            return response()->json(['status' => true, 'message' => 'Khách hàng không tồn tại', 'data' => []], 200);
        }

        // Lấy danh sách voucher đã đổi, ưu tiên trạng thái pending
        $vouchers = VoucherExchanges::where('customer_id', $customer->kiotviet_id)
            ->orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END")
            ->orderBy('exchange_date', 'desc')
            ->with('voucher', 'branch')
            ->paginate($perPage);

        return response()->json(['status' => true, 'data' => $vouchers], 200);
    }

    /**
     * Hủy voucher và hoàn lại điểm
    */
    public function cancelVoucherExchange(Request $request)
    {
        $exchangeId = $request->exchange_id;

        $exchange = VoucherExchanges::find($exchangeId);

        if (!$exchange) {
            return response()->json(['status' => false, 'message' => 'Mã voucher không tồn tại'], 404);
        }

        if ($exchange->status !== 'pending') {
            return response()->json(['status' => false, 'message' => 'Không thể hủy vì quà đã đổi hoặc đã bị hủy trước đó'], 400);
        }

        $_dataPost = [
            'account_code' => $exchange->account_code,
            'voucher_campaign_id' => $exchange->voucher_campaign_id,
            'exchange_code' => $exchange->exchange_code
        ];

        $_check_created_voucher = $this->cancelVoucherKiotviet($_dataPost);
        if (empty($_check_created_voucher)){
            return response()->json(['status' => false, 'message' => 'Chúng tôi đang cập nhật hệ thống! Vui lòng thử lại sau.'], 200);
        }

        DB::beginTransaction();

        try {

            // Hoàn lại điểm cho khách hàng
            $customer = Customer::where('kiotviet_id', $exchange->customer_id)->first();
            if ($customer) {
                $customer->increment('reward_point', $exchange->points_used);
                $customer->decrement('used_points', $exchange->points_used);

                //Lưu log số điểm đã dùng
                CustomerPointLog::updateUsedPoints($customer->kiotviet_id, $exchange->points_used, 'decrease');
            }

            // Cập nhật trạng thái quà tặng thành "cancelled"
            $exchange->update(['status' => 'cancelled']);
            DB::commit();

            return response()->json(['status' => true, 'message' => 'Hủy voucher thành công'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Hủy voucher thất bại', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * xác nhận khách hàng đã nhận voucher
    */
    public function confirmVoucherExchange(Request $request)
    {
        $exchangeId = $request->exchange_id;

        $exchange = VoucherExchanges::find($exchangeId);

        if (!$exchange) {
            return response()->json(['status' => false, 'message' => 'Mã voucher không tồn tại'], 404);
        }

        if ($exchange->status !== 'pending') {
            return response()->json(['status' => false, 'message' => 'Voucher đã được xác nhận trước đó hoặc đã bị hủy.'], 400);
        }

        // Cập nhật trạng thái voucher
        $exchange->update(['status' => 'completed']);

        return response()->json(['status' => true, 'message' => 'Xác nhận đổi voucher thành công'], 200);
    }

}
