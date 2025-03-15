<?php


namespace App\Http\Controllers\API;


use App\Models\Customer;
use App\Models\DailyActivitySummary;
use App\Services\KiotVietService;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceRating;

class InvoicesController extends HelperApiController
{
    protected $kiotVietService;

    public function __construct(KiotVietService $kiotVietService) {
        $this->kiotVietService = $kiotVietService;
    }

    /**
     * Danh sách đơn hàng
     * $cutoffDate ngày hoá đơn được tính đánh giá
    */
    public function getInvoices(Request $request){
        try{
            $cutoffDate = optional($this->getKpiSetting())->cutoff_date ?? '2025-01-01';

            $perPage = $request->input('per_page', 10);

            $phone = $request->input('phone');

            $customer = Customer::where('contact_number', $phone)->first();

            if (!$phone || empty($customer)) {
                return response()->json(['status' => false, 'data' => []], 200);
            }

            $customerId = $customer->kiotviet_id; //Bảng invoid thêm contact_number sẽ where theo bảng đó

            $data = Invoice::leftJoin('invoice_ratings', 'invoices.kiotviet_id', '=', 'invoice_ratings.kiotviet_invoice_id')
                ->where('invoices.customer_id', $customerId) //Bảng invoid thêm contact_number sẽ where theo bảng đó
                ->select(
                    'invoices.*',
                    \DB::raw("IF(invoices.created_date < '$cutoffDate' OR invoice_ratings.kiotviet_invoice_id IS NOT NULL, true, false) as is_rated")
                )
                ->with('details')
                ->paginate($perPage);

            return response()->json(['status' => true, 'data' => $data]);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 200);
        }
    }

    /**
     * Đánh giá đơn hàng
    */
    public function invoiceRating(Request $request)
    {
        try {
            $validated = $request->validate([
                'kiotviet_invoice_id' => 'required|integer',
                'kiotviet_customer_id' => 'required|integer',
                'employee_id' => 'required|integer',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string'
            ]);

            // Gọi function createRating trong InvoiceRating để xử lý logic
            $rating = InvoiceRating::createRating($validated);

            //Ghi log đếm số lượng đánh giá đơn hàng
            DailyActivitySummary::logAction($request->kiotviet_customer_id, 'rate');

            //Gửi mail đánh giá đơn hàng nguy hiểm
            if ($rating->rating <= 2){
                $this->mailInvoice($rating->kiotviet_invoice_id);
            }

            return response()->json(['status' => true, 'message' => 'Đánh giá thành công', 'data' => $rating]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()], 200);
        }
    }


}
