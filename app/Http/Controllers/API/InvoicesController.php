<?php


namespace App\Http\Controllers\API;


use App\Models\Customer;
use App\Models\DailyActivitySummary;
use App\Models\GeneralSettings;
use App\Models\SettingGlobal;
use App\Services\KiotVietService;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceRating;
use App\Models\ProductCertificate;
use App\Models\InvoiceRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

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
            $typeInvoice = GeneralSettings::where('code', 'invoice')->first()->value??1;
            $setting = SettingGlobal::where('code', 'invoices_request')->first(); // Thời gian cho phép xuất hoá đơn sau khi mua sản phẩm
            $_comment = optional($setting)->comment;
            $_time_invoices_request = is_numeric($_comment) ? (int) $_comment : 0;

            if (!$phone || !Invoice::where('contact_number', $phone)->exists()) {
                return response()->json(['status' => false, 'data' => []], 200);
            }
            if ($typeInvoice == 1){
                $data = Invoice::leftJoin('invoice_ratings', 'invoices.kiotviet_id', '=', 'invoice_ratings.kiotviet_invoice_id')
                    ->where('invoices.contact_number', $phone) //Bảng invoid thêm contact_number sẽ where theo bảng đó
                    ->select(
                        'invoices.*',
                        \DB::raw("IF(invoices.created_date < '$cutoffDate' OR invoice_ratings.kiotviet_invoice_id IS NOT NULL, true, false) as is_rated")
                    )
                    ->with('details')
                    ->orderBy('created_date', 'desc')
                    ->paginate($perPage);

                // Giấy Tờ Chứng Nhận
                $productCodes = collect($data->items())
                    ->flatMap(function($invoice) {
                        return $invoice->details;
                    })
                    ->pluck('product_code')
                    ->unique();

                $certificates = ProductCertificate::whereIn('product_code', $productCodes)
                    ->where('is_active', true)
                    ->pluck('certificate_link', 'product_code');

                foreach ($data as $invoice) {
                    foreach ($invoice->details as $detail) {
                        $detail->certificate = $certificates[$detail->product_code] ?? null;
                    }

                    $invoice->can_request_invoice = false;
                    $invoice->result_url = false;

                    // Kiểm tra đã có yêu cầu xuất hóa đơn chưa
                    $existingRequest = InvoiceRequest::where('invoice_id', $invoice->id)->first();

                    if ($existingRequest) {
                        // Đã có yêu cầu → luôn hiển thị nút và gắn trạng thái
                        $invoice->can_request_invoice = true;
                        $invoice->result_url = $existingRequest->result_url; // Có giá trị trả về mặc định là đã xong
                    } else {
                        // Chưa có yêu cầu → kiểm tra thời gian tạo hoá đơn
                        $createdAt = Carbon::parse($invoice->created_date);
                        if ($createdAt->diffInMinutes(now()) <= $_time_invoices_request) { // Chỉ được yêu cầu xuất hoá đơn trước 60 phút sau khi mua đơn hàng.
                            $invoice->can_request_invoice = true;
                        }
                    }
                }
            }else{
                $data = [];
            }

            return response()->json(['status' => true, 'data' => $data]);
        }catch (\Exception $exception){
            \Log::error('Lỗi khi lấy hóa đơn: ' . $exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 200);
        }
    }

    /**
     * Hoá đơn trong ngày hôm nay và chưa đánh giá hoá đơn
    */
    public function getTodayInvoices(Request $request)
    {
        try {
            $today = now()->format('Y-m-d');
            $phone = $request->input('phone');

            if (!$phone || !Invoice::where('contact_number', $phone)->exists()) {
                return response()->json(['status' => false, 'data' => []], 200);
            }

            $data = Invoice::leftJoin('invoice_ratings', 'invoices.kiotviet_id', '=', 'invoice_ratings.kiotviet_invoice_id')
                ->where('invoices.contact_number', $phone) //Bảng invoid thêm contact_number sẽ where theo bảng đó
                ->whereDate('invoices.created_date', $today)
                ->whereNull('invoice_ratings.kiotviet_invoice_id') // Chỉ lấy hóa đơn chưa đánh giá
                ->select(
                    'invoices.*',
                    \DB::raw("false as is_rated")
                )
                ->with('details')
                ->get();

            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $exception) {
            \Log::error('Lỗi khi lấy hóa đơn hôm nay: ' . $exception->getMessage());
            return response()->json(['status' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại.'], 500);
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

    /**
     * Yêu cầu xuất hoá đơn
     */
    public function storeInvoiceRequest(Request $request)
    {
        try {
            $validated = $request->validate([
                'invoice_id' => 'required|exists:invoices,id',
                'type' => ['required', Rule::in(['personal', 'company'])],
                'invoice_code' => 'required|string',

                // Chung
                'name' => 'nullable|string|required_if:type,personal',
                'phone' => 'nullable|string|required_if:type,personal',
                'address' => 'nullable|string',

                // Công ty
                'tax_code' => 'nullable|required_if:type,company',
                'company_name' => 'nullable|required_if:type,company',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 200);
        }
        $existingInvoice = Invoice::find($validated['invoice_id']);
        if (empty($existingInvoice)){
            return response()->json(['status' => false, 'msg' => 'Hoá đơn không tồn tại.'], 200);
        }
        $validated['email'] = $request->email;
        $validated['note'] = $request->note;
        $validated['status'] = 'pending';
        // ❗ Kiểm tra xem hóa đơn này đã được yêu cầu xuất chưa
        $existing = InvoiceRequest::where('invoice_id', $validated['invoice_id'])->first();
        if (!empty($existing)){
            return response()->json(['status' => false, 'msg' => 'Hoá đơn này đã được yêu cầu xuất trước đó.'], 200);
        }

        $invoiceRequest = InvoiceRequest::create($validated);

        return response()->json([
            'success' => true,
            'data' => $invoiceRequest,
            'msg' => 'Gửi yêu cầu thành công!'
        ], 200);
    }
    /**
     * Mua lại đơn hàng
    **/
    public function invoiceBuyAgain (Request $request)
    {
        try{
            $customer = Customer::where('contact_number', $request->get('phone'))->first();
            if (empty($customer)){
                return response()->json(['status' => false, 'msg' => 'Không tìm thấy đơn hàng. Vui lòng liên hệ với ZALO OA của doanh nghiệp để được hỗ trợ'], Response::HTTP_OK);
            }
            $invoice = Invoice::find($request->get('invoice_id'));
            if (empty($invoice)){
                return response()->json(['status' => false, 'msg' => 'Không tìm thấy đơn hàng. Vui lòng liên hệ với ZALO OA của doanh nghiệp để được hỗ trợ'], Response::HTTP_OK);
            }
            if ($invoice->total_payment < 1){
                return response()->json(['status' => false, 'msg' => 'Tạo đơn hàng thất bại. Vui lòng kiểm tra lại giá trị đơn hàng'], Response::HTTP_OK);
            }
            $invoiceDetail = $invoice->details;
            $orderDetail = [];
            foreach ($invoiceDetail as $key => $value){
                if ($key == 0){
                    $isMaster = true;
                }else{
                    $isMaster = false;
                }
                if ($value->price > 0){
                    $orderItem = [
                        'productId' => $value->product_id,
                        'productCode' => $value->product_code,
                        'productName' => $value->product_name,
                        'isMaster' => $isMaster,
                        'quantity' => $value->quantity,
                        'price' => $value->price,
                        'discount' => $value->discount
                    ];
                    $orderDetail[] = $orderItem;
                }
            }
            $customerOrder = [
                'id' => $customer->kiotviet_id,
                'code' => $customer->code,
                'name' => $customer->name,
                'contactNumber' => $customer->contact_number,
                'address' => $customer->address,
                'wardName' =>$customer->ward_name,
            ];
            $data = [
                'branchId' => $invoice->branch_id,
                'isApplyVoucher' => false,
                'discount' => $invoice->discount,
                'totalPayment' => $invoice->total_payment,
                'makeInvoice' => true,
                'orderDetails' => $orderDetail,
                'customer' => $customerOrder,
            ];
            $tokens = $this->kiotVietService->getAccessTokenAllBranches($invoice->personal_access_token);
            $accessToken = $tokens->access_token;
            $retailer = $tokens->retailer;
            $response = Http::withHeaders([
                'Retailer'      => $retailer,
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->post('https://public.kiotapi.com/orders',$data);
            $dataResponse = $response->json();
            return \response()->json(['status' => true, 'msg' => 'Đặt mua lại đơn hàng thành công. Nhân viên sẽ gọi điện xác nhận lại đơn hàng sớm. Cảm ơn quý khách đã tin dùng'], Response::HTTP_OK);
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }
}
