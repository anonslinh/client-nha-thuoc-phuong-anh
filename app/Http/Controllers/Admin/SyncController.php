<?php


namespace App\Http\Controllers\Admin;

use App\Models\AccountBranches;
use App\Models\HistoryPointEvent;
use App\Models\PersonalAccessTokens;
use App\Models\ProductsEvent;
use App\Services\KiotVietService;
use Illuminate\Support\Facades\Http;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Customer;


class SyncController extends HelperAdminController
{
    protected $kiotVietService;
    protected $urlKiotViet;

    public function __construct(KiotVietService $kiotVietService) {
        $this->kiotVietService = $kiotVietService;
        $this->urlKiotViet = $kiotVietService->urlKiotviet();
    }

    /**
     * Đồng bộ danh sách chi nhánh cửa hàng
    */
    public function syncBranches(){
        try{

            $personalAccessTokens = PersonalAccessTokens::all();
            $totalFetched = 0;

            foreach ($personalAccessTokens as $personalAccessToken){

                $tokens = $this->kiotVietService->getAccessTokenAllBranches($personalAccessToken->access_token_code);
                $accessToken = $tokens->access_token;
                $retailer = $tokens->retailer;

                $pageSize = 100; // Số lượng tối đa mỗi lần gọi API
                $currentItem = 0; // Bắt đầu từ khách hàng đầu tiên

                do{

                    $response = Http::withHeaders([
                        'Retailer'      => $retailer,
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type'  => 'application/json',
                    ])->get($this->urlKiotViet['url_branches']."pageSize=$pageSize&currentItem=$currentItem");

                    if ($response->failed()) {
                        return response()->json(['error' => 'Không thể lấy dữ liệu từ KiotViet'], 500);
                    }

                    // Kiểm tra xem có dữ liệu không
                    $branches = $response->json()['data'] ?? [];
                    if (!isset($branches) || empty($branches)) {
                        break; // Dừng lại nếu không còn dữ liệu
                    }

                    foreach ($branches as $branchData) {
                        Branch::updateOrCreate(
                            ['kiotviet_id' => $branchData['id']],
                            [
                                'account_code'   => $personalAccessToken->access_token_code,
                                'branch_name'    => $branchData['branchName'],
                                'address'        => $branchData['address'],
                                'location_name'  => $branchData['locationName'],
                                'ward_name'      => $branchData['wardName'],
                                'contact_number' => $branchData['contactNumber'],
                                'retailer_id'    => $branchData['retailerId'],
                                'email'          => $branchData['email'] ?? null,
                                'modified_date'  => $branchData['modifiedDate'] ?? null,
                                'created_date'   => $branchData['createdDate'] ?? null,
                            ]
                        );
                    }

                    // Cập nhật chỉ số để lấy trang tiếp theo
                    $totalFetched += count($branches);
                    $currentItem += $pageSize;

                } while (count($branches) === $pageSize); // Lặp cho đến khi hết dữ liệu

            }
            return back()->with(['success' => "Đồng bộ chi nhánh thành công! $totalFetched"]);

        }catch (\Exception $exception){
            return back()->with(['error' => 'Lỗi! Liên hệ với bộ phân CSKH.']);
        }
    }

    /**
     * Đồng bộ danh sách nhân viên tại cửa hàng
    */
    public function syncEmployees(){
        try{
            $personalAccessTokens = PersonalAccessTokens::all();
            $totalFetched = 0;

            foreach ($personalAccessTokens as $personalAccessToken) {

                $tokens = $this->kiotVietService->getAccessTokenAllBranches($personalAccessToken->access_token_code);
                $accessToken = $tokens->access_token;
                $retailer = $tokens->retailer;

                $pageSize = 100; // Số lượng tối đa mỗi lần gọi API
                $currentItem = 0; // Bắt đầu từ khách hàng đầu tiên

                do{
                    $response = Http::withHeaders([
                        'Retailer'      => $retailer,
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type'  => 'application/json',
                    ])->get($this->urlKiotViet['url_users']."pageSize=$pageSize&currentItem=$currentItem");

                    if ($response->failed()) {
                        return response()->json(['error' => 'Không thể lấy dữ liệu từ KiotViet'], 500);
                    }

                    // Kiểm tra xem có dữ liệu không
                    $employeesData = $response->json()['data'] ?? [];
                    if (!isset($employeesData) || empty($employeesData)) {
                        break; // Dừng lại nếu không còn dữ liệu
                    }

                    foreach ($employeesData as $employeeData) {
                        Employee::updateOrCreate(
                            ['kiotviet_id' => $employeeData['id']],
                            [
                                'account_code'   => $personalAccessToken->access_token_code,
                                'user_name'    => $employeeData['userName'],
                                'given_name'   => $employeeData['givenName'],
                                'address'      => $employeeData['address'] ?? null,
                                'mobile_phone' => $employeeData['mobilePhone'] ?? null,
                                'retailer_id'  => $employeeData['retailerId'],
                                'created_date' => $employeeData['createdDate'],
                            ]
                        );
                    }

                    // Cập nhật chỉ số để lấy trang tiếp theo
                    $totalFetched += count($employeesData);
                    $currentItem += $pageSize;

                } while (count($employeesData) === $pageSize); // Lặp cho đến khi hết dữ liệu

            }

            return back()->with(['success' => "Đồng bộ nhân viên thành công! $totalFetched"]);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Lỗi! Liên hệ với bộ phân CSKH.']);
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
