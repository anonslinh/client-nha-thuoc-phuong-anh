<?php


namespace App\Http\Controllers\API;
use App\Models\Branch;
use App\Models\CustomerPointLog;
use App\Models\DailyActivitySummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\GiftExchanges;
use App\Models\GiftInventories;
use App\Models\Gift;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class GiftExchangesController extends HelperApiController
{
    /**
     * Đổi điểm thành quà tặng
    */
    public function exchangeGift(Request $request)
    {
        DB::beginTransaction();
        try {

            // Validate dữ liệu đầu vào
            $validatedData = $request->validate([
                'phone' => ['required', 'regex:/^(0[1-9][0-9]{8,9}|84[1-9][0-9]{8,9})$/'],
                'gift_id' => ['required', 'exists:gifts,id'], // Đảm bảo gift_id tồn tại
                'branch_id' => ['required', 'exists:branches,id'], // Đảm bảo branch_id tồn tại
            ], [
                'branch_id.required' => 'Mã chi nhánh là bắt buộc.',
                'branch_id.exists' => 'Chi nhánh không tồn tại.',
                'gift_id.required' => 'Mã quà tặng là bắt buộc.',
                'gift_id.exists' => 'Quà tặng không tồn tại.',
                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại không hợp lệ.',
            ]);

            $quantity = 1;
            // Kiểm tra sản phẩm còn hàng không
            if (!GiftInventories::checkStock($validatedData['gift_id'], $validatedData['branch_id'], $quantity)) {
                return response()->json(['status' => false, 'message' => 'Sản phẩm đã hết hàng'], 200);
            }

            // Trừ tồn kho
            if (!GiftInventories::reduceStock($validatedData['gift_id'], $validatedData['branch_id'], $quantity)) {
                return response()->json(['status' => false, 'message' => 'Không đủ số lượng trong kho'], 200);
            }

            $phone = $this->normalizePhone($validatedData['phone']);

            // Đồng bộ hóa hóa đơn của khách hàng trước khi tiếp tục
            $this->syncCustomerInvoices($phone);


            // Lấy thông tin khách hàng
            $customer = Customer::where('contact_number', $phone)->first();

            //Ghi log đếm số lượng đổi quà đổi voucher
            DailyActivitySummary::logAction($customer ? $customer->kiotviet_id : null, 'redeem_gift_voucher');

            if (!$customer) {
                return response()->json(['status' => false, 'message' => 'Không đủ điểm để đổi quà'], 200);
            }

            // Lấy thông tin quà tặng
            $gift = Gift::find($validatedData['gift_id']);
            if (!$gift) {
                return response()->json(['status' => false, 'message' => 'Quà tặng không tồn tại'], 200);
            }

            $pointsRequired = $gift->points_required;

            // Kiểm tra khách hàng có đủ điểm để đổi không
            if ($customer->reward_point < $pointsRequired) {
                return response()->json(['status' => false, 'message' => 'Không đủ điểm để đổi quà'], 200);
            }

            // Trừ điểm khách hàng
            $customer->decrement('reward_point', $pointsRequired);
            $customer->increment('used_points', $pointsRequired);

            //Lưu log số điểm đã dùng
            CustomerPointLog::updateUsedPoints($customer->kiotviet_id, $pointsRequired, 'increase');

            // Tạo mã đổi quà duy nhất
            $exchangeCode = 'GIFT' . strtoupper(Str::random(10));

            // Lưu giao dịch đổi quà
            $exchange = GiftExchanges::create([
                'customer_id' => $customer->kiotviet_id,
                'contact_phone' => $customer->contact_number,
                'gift_id' => $gift->id,
                'branch_id' => $validatedData['branch_id'] ?? null,
                'exchange_code' => $exchangeCode,
                'points_used' => $pointsRequired,
                'exchange_date' => now(),
                'status' => 'pending',
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Đổi quà thành công',
                'exchange_code' => $exchangeCode,
                'data' => $exchange
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json(['error' => $exception->errors()], 422);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Lỗi hệ thống', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Danh sách quà đã đổi theo số điện thoại
    */
    public function getGiftExchangesByPhone(Request $request){
        $perPage = $request->input('per_page', 10);

        $phone = $this->normalizePhone($request->phone);
        // Tìm khách hàng theo số điện thoại
        $customer = Customer::where('contact_number', $phone)->first();

        if (!$customer) {
            return response()->json(['status' => false, 'message' => 'Khách hàng không tồn tại', 'data' => []], 200);
        }

        // Lấy danh sách quà, ưu tiên quà đang "pending"
        $giftExchanges = GiftExchanges::where('customer_id', $customer->kiotviet_id)
            ->orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END")
            ->orderBy('exchange_date', 'desc')
            ->with('gift', 'branch')
            ->paginate($perPage);

        return response()->json(['status' => true, 'data' => $giftExchanges], 200);
    }

    /**
     * xác nhận quà đã đổi thành công
    */
    public function confirmGiftExchange(Request $request){

        $exchangeId = $request->exchange_id;

        $exchange = GiftExchanges::find($exchangeId);

        if (!$exchange) {
            return response()->json(['status' => false, 'message' => 'Mã đổi quà không tồn tại'], 404);
        }

        if ($exchange->status !== 'pending') {
            return response()->json(['status' => false, 'message' => 'Quà đã được xử lý, không thể xác nhận lại'], 400);
        }

        $exchange->update(['status' => 'completed']);

        return response()->json(['status' => true, 'message' => 'Xác nhận đổi quà thành công']);
    }

    /**
     * hủy đổi quà (hoàn lại điểm)
     */
    public function cancelGiftExchange(Request $request)
    {
        $exchangeId = $request->exchange_id;

        $exchange = GiftExchanges::find($exchangeId);

        if (!$exchange) {
            return response()->json(['status' => false, 'message' => 'Mã đổi quà không tồn tại'], 404);
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

            // Cộng thêm tồn kho khi huỷ không đổi
            $quantity = 1;
            if (!GiftInventories::restoreStock($exchange->gift_id, $exchange->branch_id, $quantity)) {
                return response()->json(['status' => false, 'message' => 'Không đủ số lượng trong kho'], 200);
            }
            // Cập nhật trạng thái quà tặng thành "cancelled"
            $exchange->update(['status' => 'cancelled']);

            DB::commit();

            return response()->json(['status' => true, 'message' => 'Hủy đổi quà thành công, điểm đã được hoàn lại']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại'], 500);
        }
    }

    /**
     * Danh sách chi nhánh
    */
    public function getBranches(Request $request){

        $branches = Branch::query();
        if (!empty($request->key_search)){
            $branches = $branches->where('branch_name', 'like', "%$request->key_search%");
        }
        $branches = $branches->get();
        return response()->json(['status' => true, 'data' => $branches], 200);
    }
    /**
     * Function kiểm tra kho quà tại chi nhánh
    */
    private function checkGiftStock($giftId, $branchId)
    {
        if (!$branchId) {
            return true; // Nếu không có chi nhánh, bỏ qua kiểm tra
        }

        $inventory = GiftInventories::where('gift_id', $giftId)
            ->where('branch_id', $branchId)
            ->first();

        if (!$inventory || $inventory->quantity <= 0) {
            return false; // Hết hàng tại chi nhánh
        }

        return true;
    }

    /**
     * Function trừ số lượng quà trong kho
    */
    private function deductGiftStock($giftId, $branchId)
    {
        if (!$branchId) {
            return; // Không có chi nhánh thì không cần trừ kho
        }

        GiftInventories::where('gift_id', $giftId)
            ->where('branch_id', $branchId)
            ->decrement('quantity', 1);
    }


}
