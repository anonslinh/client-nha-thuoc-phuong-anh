<?php


namespace App\Http\Controllers\API;


use App\Models\DailyActivitySummary;
use App\Services\KiotVietService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
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

            $accessToken = $this->kiotVietService->getAccessToken();

            $retailer = $this->kiotVietService->getRetailer();

            $response = Http::withHeaders([
                'Retailer'      => $retailer,
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->get('https://public.kiotapi.com/customers', [
                'orderDirection' => 'Desc',
                'contactNumber' => $phone,
                'includeTotal' => 'true'
            ]);

            $customers = $response->json()['data'] ?? [];
            if (!$phone || empty($customers)) {
                return response()->json(['status' => false, 'data' => []], 200);
            }

            $customerId = $customers[0]['id'];

            $invoiceResponse = Http::withHeaders([
                'Retailer'      => $retailer,
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->get('https://public.kiotapi.com/invoices', [
                'orderDirection' => 'Desc',
                'customerIds' => $customerId,
                'pageSize' => '100'
            ]);

            $invoices = $invoiceResponse->json()['data'] ?? [];
            if (!$phone || empty($invoices)) {
                return response()->json(['status' => false, 'data' => []], 200);
            }

            foreach ($invoices as $invoiceData) {
                $existingInvoice = Invoice::where('kiotviet_id', $invoiceData['id'])->first();
                if (!$existingInvoice) {
                    $invoice = Invoice::create([
                        'kiotviet_id' => $invoiceData['id'],
                        'uuid' => $invoiceData['uuid'],
                        'code' => $invoiceData['code'],
                        'purchase_date' => $invoiceData['purchaseDate'],
                        'branch_id' => $invoiceData['branchId'],
                        'branch_name' => $invoiceData['branchName'],
                        'sold_by_id' => $invoiceData['soldById'],
                        'sold_by_name' => $invoiceData['soldByName'],
                        'customer_id' => $invoiceData['customerId'],
                        'customer_code' => $invoiceData['customerCode'],
                        'customer_name' => $invoiceData['customerName'],
                        'order_code' => $invoiceData['orderCode'],
                        'total' => $invoiceData['total'],
                        'total_payment' => $invoiceData['totalPayment'],
                        'status' => $invoiceData['status'],
                        'status_value' => $invoiceData['statusValue'],
                        'using_cod' => $invoiceData['usingCod'],
                        'created_date' => $invoiceData['createdDate']
                    ]);

                    foreach ($invoiceData['invoiceDetails'] as $detail) {
                        InvoiceDetail::create([
                            'invoice_id' => $invoice->id,
                            'product_id' => $detail['productId'],
                            'product_code' => $detail['productCode'],
                            'product_name' => $detail['productName'],
                            'category_id' => $detail['categoryId'],
                            'category_name' => $detail['categoryName'],
                            'trade_mark_id' => $detail['tradeMarkId'] ?? null,
                            'trade_mark_name' => $detail['tradeMarkName'] ?? null,
                            'quantity' => $detail['quantity'],
                            'price' => $detail['price'],
                            'discount' => $detail['discount'],
                            'use_point' => $detail['usePoint'],
                            'sub_total' => $detail['subTotal'],
                            'serial_numbers' => $detail['serialNumbers'] ?? null,
                            'return_quantity' => $detail['returnQuantity']
                        ]);
                    }
                }
            }

            $data = Invoice::leftJoin('invoice_ratings', 'invoices.kiotviet_id', '=', 'invoice_ratings.kiotviet_invoice_id')
                ->where('invoices.customer_id', $customerId)
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
