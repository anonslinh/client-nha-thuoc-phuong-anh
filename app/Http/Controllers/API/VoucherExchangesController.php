<?php


namespace App\Http\Controllers\API;
use App\Models\DailyActivitySummary;
use Illuminate\Http\Request;
use App\Models\VoucherExchanges;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\CustomerPointLog;


class VoucherExchangesController extends HelperApiController
{
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
            ], [
                'voucher_id.required' => 'Mã voucher là bắt buộc.',
                'voucher_id.exists' => 'Voucher không tồn tại.',
                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại không hợp lệ.',
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

            // Tạo mã đổi voucher
            $exchangeCode = 'VOUCHER' . strtoupper(Str::random(10));

            // Lưu vào bảng voucher_exchanges
            $exchange = VoucherExchanges::create([
                'customer_id' => $customer->kiotviet_id,
                'contact_phone' => $customer->contact_number,
                'voucher_id' => $voucherId,
                'branch_id' => $customer->branch_id ?? null,
                'discount_amount' => $voucher->discount_amount,
                'exchange_code' => $exchangeCode,
                'points_used' => $pointsRequired,
                'exchange_date' => now(),
                'status' => 'pending',
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
            ->with('voucher')
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
