<?php


namespace App\Http\Controllers\Admin;

use App\Models\HistoryPointEvent;
use App\Models\ProductsEvent;
use App\Services\KiotVietService;
use Illuminate\Support\Facades\Http;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Customer;


class SyncController extends HelperAdminController
{
    protected $kiotVietService;

    public function __construct(KiotVietService $kiotVietService) {
        $this->kiotVietService = $kiotVietService;
    }

    /**
     * Đồng bộ danh sách chi nhánh cửa hàng
    */
    public function syncBranches(){
        try{
            $accessToken = $this->kiotVietService->getAccessToken();

            $retailer = $this->kiotVietService->getRetailer();

            $response = Http::withHeaders([
                'Retailer'      => $retailer,
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->get('https://public.kiotapi.com/branches?pageSize=100');

            if ($response->failed()) {
                return response()->json(['error' => 'Không thể lấy dữ liệu từ KiotViet'], 500);
            }
            $branches = $response->json()['data'] ?? [];

            foreach ($branches as $branchData) {
                Branch::updateOrCreate(
                    ['kiotviet_id' => $branchData['id']],
                    [
                        'branch_name'    => $branchData['branchName'],
                        'address'        => $branchData['address'],
                        'location_name'  => $branchData['locationName'],
                        'ward_name'      => $branchData['wardName'],
                        'contact_number' => $branchData['contactNumber'],
                        'retailer_id'    => $branchData['retailerId'],
                        'email'          => $branchData['email'] ?? null,
                        'modified_date'  => @$branchData['modifiedDate'],
                        'created_date'   => @$branchData['createdDate'],
                    ]
                );
            }

            return back()->with(['success' => 'Đồng bộ chi nhánh thành công!']);

        }catch (\Exception $exception){
            return back()->with(['error' => 'Lỗi! Liên hệ với bộ phân CSKH.']);
        }
    }

    /**
     * Đồng bộ danh sách nhân viên tại cửa hàng
    */
    public function syncEmployees(){
        try{
            $accessToken = $this->kiotVietService->getAccessToken();
            $retailer = $this->kiotVietService->getRetailer();

            $response = Http::withHeaders([
                'Retailer'      => $retailer,
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->get('https://public.kiotapi.com/users?pageSize=100');

            if ($response->failed()) {
                return response()->json(['error' => 'Không thể lấy dữ liệu từ KiotViet'], 500);
            }
            $employeesData = $response->json()['data'] ?? [];
            foreach ($employeesData as $employeeData) {
                Employee::updateOrCreate(
                    ['kiotviet_id' => $employeeData['id']],
                    [
                        'user_name'    => $employeeData['userName'],
                        'given_name'   => $employeeData['givenName'],
                        'address'      => $employeeData['address'] ?? null,
                        'mobile_phone' => $employeeData['mobilePhone'] ?? null,
                        'retailer_id'  => $employeeData['retailerId'],
                        'created_date' => $employeeData['createdDate'],
                    ]
                );
            }
            return back()->with(['success' => 'Đồng bộ nhân viên thành công!']);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Lỗi! Liên hệ với bộ phân CSKH.']);
        }
    }

    /**
     * Đồng bộ danh sách khách hàng
    */
    public function syncCustomers(){
        try{
            $pageSize = 100; // Số lượng tối đa mỗi lần gọi API
            $currentItem = 0; // Bắt đầu từ khách hàng đầu tiên
            $totalFetched = 0;

            do {
                // Gọi API lấy danh sách khách hàng
                $accessToken = $this->kiotVietService->getAccessToken();

                $retailer = $this->kiotVietService->getRetailer();

                $response = Http::withHeaders([
                    'Retailer'      => $retailer,
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type'  => 'application/json',
                ])->get("https://public.kiotapi.com/customers?orderDirection=Desc&includeTotal=true&pageSize=$pageSize&currentItem=$currentItem");

                $data = $response->json();

                // Kiểm tra xem có dữ liệu không
                if (!isset($data['data']) || empty($data['data'])) {
                    break; // Dừng lại nếu không còn dữ liệu
                }

                // Lưu danh sách khách hàng vào database
                foreach ($data['data'] as $customer) {

                    $existingCustomer = Customer::where('kiotviet_id', $customer['id'])->first();

                    // Tính toán điểm thực tế
                    $kiotvietRewardPoint = $customer['rewardPoint'] ?? 0;
                    $usedPoints = $existingCustomer->used_points ?? 0;

                    // Điểm thực tế = điểm từ KiotViet - điểm đã dùng + điểm thưởng từ đánh giá
                    $actualRewardPoint = max($kiotvietRewardPoint - $usedPoints , 0);

                    Customer::updateOrCreate(
                        ['kiotviet_id' => $customer['id']], // Khóa chính để kiểm tra trùng
                        [
                            'code' => $customer['code'] ?? null,
                            'name' => $customer['name'],
                            'contact_number' => $customer['contactNumber'] ?? null,
                            'address' => $customer['address'] ?? null,
                            'retailer_id' => $customer['retailerId'],
                            'branch_id' => $customer['branchId'],
                            'location_name' => $customer['locationName'] ?? null,
                            'ward_name' => $customer['wardName'] ?? null,
                            'modified_date' => $customer['modifiedDate'] ?? null,
                            'created_date' => $customer['createdDate'] ?? null,
                            'type' => $customer['type'] ?? 0,
                            'organization' => $customer['organization'] ?? null,
                            'comments' => $customer['comments'] ?? null,
                            'debt' => $customer['debt'] ?? 0,
                            'total_invoiced' => $customer['totalInvoiced'] ?? 0,
                            'total_revenue' => $customer['totalRevenue'] ?? 0,
                            'total_point' => $customer['totalPoint'] ?? 0,
                            'kiotviet_reward_point' => $kiotvietRewardPoint,
                            'used_points'    => $usedPoints,
                            'reward_point'   => $actualRewardPoint, // Cập nhật điểm thực tế
                        ]
                    );
                }

                // Cập nhật chỉ số để lấy trang tiếp theo
                $totalFetched += count($data['data']);
                $currentItem += $pageSize;

            } while (count($data['data']) === $pageSize); // Lặp cho đến khi hết dữ liệu

            return "Đồng bộ xong, tổng khách hàng đã lấy: $totalFetched";
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Đồng bộ hoá đơn hàng cho khách hàng
    */
    public function syncInvoices(){
        try{

            $accessToken = $this->kiotVietService->getAccessToken();

            $retailer = $this->kiotVietService->getRetailer();

            $response = Http::withHeaders([
                'Retailer'      => $retailer,
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->get("https://public.kiotapi.com/invoices?customerIds=36031005&currentItem=0&pageSize=100");

            if ($response->failed()) {
                return response()->json(['error' => 'Không thể lấy dữ liệu từ KiotViet'], 500);
            }
            $customerIds = Customer::whereNotNull('kiotviet_id')->pluck('kiotviet_id')->toArray();
            if (empty($customerIds)) {
                return response()->json(['message' => 'Không có khách hàng nào để đồng bộ'], 400);
            }
            // Chia nhóm 5000 khách hàng một lần
            $chunks = array_chunk($customerIds, 100);
            foreach ($chunks as $group) {
                $this->fetchAndStoreInvoices($group);
            }

            return response()->json(['message' => 'Đồng bộ hóa đơn thành công'], 200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Lưu danh sách đơn hàng
    */
    private function fetchAndStoreInvoices($customerIds)
    {
        $accessToken = $this->kiotVietService->getAccessToken();

        $retailer = $this->kiotVietService->getRetailer();

        $response = Http::withHeaders([
            'Retailer'      => $retailer,
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type'  => 'application/json',
        ])->get("https://public.kiotapi.com/invoices?customerIds=36031005&currentItem=0&pageSize=100");

        if ($response->failed()) {
            return response()->json(['error' => 'Không thể lấy dữ liệu từ KiotViet'], 500);
        }

        $invoices = $response->json()['data'] ?? [];
        dd($response);

        foreach ($invoices as $invoiceData) {
            // Lưu vào bảng invoices
            $invoice = Invoice::updateOrCreate(
                ['kiotviet_id' => $invoiceData['id']],
                [
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
                    'order_code' => $invoiceData['orderCode'] ?? null,
                    'total' => $invoiceData['total'],
                    'total_payment' => $invoiceData['totalPayment'],
                    'discount' => $invoiceData['discount'] ?? 0,
                    'status' => $invoiceData['status'],
                    'status_value' => $invoiceData['statusValue'],
                    'using_cod' => $invoiceData['usingCod'],
                    'description' => $invoiceData['description'] ?? '',
                ]
            );

            // Gọi API để lấy chi tiết hóa đơn
            $this->fetchAndStoreInvoiceDetails($invoiceData['id'], $invoice->id);
        }
    }

    private function fetchAndStoreInvoiceDetails($kiotvietInvoiceId, $localInvoiceId)
    {
        $url = "https://public.kiotapi.com/invoices/{$kiotvietInvoiceId}";

        $accessToken = $this->getAccessToken();
        if (!$accessToken) return;

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$accessToken}",
            'Retailer' => config('kiotviet.retailer'),
        ])->get($url);

        if ($response->failed()) {
            \Log::error("Lỗi khi lấy chi tiết hóa đơn", ['invoice_id' => $kiotvietInvoiceId]);
            return;
        }

        $invoiceDetails = $response->json()['invoiceDetails'] ?? [];

        foreach ($invoiceDetails as $detail) {
            InvoiceDetail::updateOrCreate(
                ['kiotviet_id' => $detail['id']],
                [
                    'invoice_id' => $localInvoiceId,
                    'product_code' => $detail['productCode'] ?? null,
                    'product_name' => $detail['productName'],
                    'quantity' => $detail['quantity'],
                    'price' => $detail['price'],
                    'total' => $detail['total'],
                    'discount' => $detail['discount'] ?? 0,
                ]
            );
        }
    }

    /**
     * Lấy danh sách nhóm hàng
     **/
    public function getCategories ()
    {
        $token = $this->kiotVietService->getAccessToken();
        $endpoint = 'https://public.kiotapi.com/categories';
        $pageSize = 100;
        $response = Http::withHeaders([
            'Retailer' => $this->kiotVietService->getRetailer(),
            'Authorization' => 'Bearer ' . $token,
        ])->get($endpoint,[
            'pageSize' => $pageSize,
        ]);
        $categories  = $response->json();
        $categories = collect($categories['data']);
        return $categories;
    }
    /**
     * Chi tiết sản phẩm KiotViet
     **/
    public function detailProductKiotViet ($productID)
    {
        $token = $this->kiotVietService->getAccessToken();
        $endpoint = 'https://public.kiotapi.com/products/'.$productID;
        $response = Http::withHeaders([
            'Retailer' => $this->kiotVietService->getRetailer(),
            'Authorization' => 'Bearer ' . $token,
        ])->get($endpoint);
        $product = $response->json();
        return $product;
    }
    /**
     * Đồng bộ điểm theo sự kiện
    **/
    public function SynchronizePoint ($customerID, $events)
    {
        $token = $this->kiotVietService->getAccessToken();
        $endpoint = 'https://public.kiotapi.com/invoices?fromPurchaseDate='.$events->time_start.'&toPurchaseDate='.$events->time_end.'&customerIds='.$customerID.'&pageSize=100';
        $response = Http::withHeaders([
            'Retailer' => $this->kiotVietService->getRetailer(),
            'Authorization' => 'Bearer ' . $token,
        ])->get($endpoint);
        $listInvoice = $response->json();
        if (!empty($listInvoice) && !empty($listInvoice['data'])){
            $index = ceil($listInvoice['total'] / $listInvoice['pageSize']);
            $this->updatePointCustomer($listInvoice['data'], $customerID, $events);
            if ($index > 1){
                for ($i = 2; $i <= $index; $i++){
                    $currentItem = $i*100;
                    $endpoint = 'https://public.kiotapi.com/invoices?fromPurchaseDate='.$events->time_start.'&toPurchaseDate='.$events->time_end.'&customerIds='.$customerID.'&pageSize=100&currentItem='.$currentItem;
                    $response = Http::withHeaders([
                        'Retailer' => $this->kiotVietService->getRetailer(),
                        'Authorization' => 'Bearer ' . $token,
                    ])->get($endpoint);
                    $dataInvoice = $response->json();
                    if (!empty($dataInvoice) && !empty($dataInvoice['data'])){
                        $this->updatePointCustomer($dataInvoice['data'],$customerID, $events);
                    }
                }
            }
        }
        return true;
    }

    /**
     * Cập nhật điểm khách hàng theo data hóa đơn
    **/
    protected function updatePointCustomer ($listInvoice, $customerID, $events)
    {
        $totalPoint = 0;
        foreach ($listInvoice as $invoice){
            if ($invoice['statusValue'] == 'Hoàn thành'){
                foreach ($invoice['invoiceDetails'] as $invoiceDetail){
                    $check = HistoryPointEvent::where('customer_id', $customerID)->where('code_order', $invoice['code'])
                        ->where('product_id', $invoiceDetail['productId'])->exists();
                    $point = ProductsEvent::where('events_id', $events->id)->where('product_id', $invoiceDetail['productId'])->first();
                    if (!$check && !empty($point)){
                        $pointEvents = $point->point * $invoiceDetail['quantity'];
                        $totalPoint += $pointEvents;
                        $historyPoint = new HistoryPointEvent([
                            'customer_id' => $customerID,
                            'title' => 'Tích điểm sự kiện: '.$events->title,
                            'code_order' => $invoice['code'],
                            'product_id' => $invoiceDetail['productId'],
                            'product_code' => $invoiceDetail['productCode'],
                            'product_name' => $invoiceDetail['productName'],
                            'point' => $pointEvents,
                            'type' => 1
                        ]);
                        $historyPoint->save();
                    }
                }
            }
        }
        $customer = Customer::where('kiotviet_id', $customerID)->first();
        $customer->total_point_event = $customer->total_point_event + $totalPoint;
        $customer->save();
        return true;
    }
}
