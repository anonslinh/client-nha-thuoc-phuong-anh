<?php


namespace App\Http\Controllers\Admin;

use App\Models\AccountBranches;
use App\Models\ExchangeGiftEvent;
use App\Models\GiftEvent;
use App\Models\HistoryPointEvent;
use App\Models\PersonalAccessTokens;
use App\Models\ProductsEvent;
use App\Models\ProductsModel;
use App\Models\QuantityGiftEvents;
use App\Services\KiotVietService;
use Carbon\Carbon;
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

            $personalAccessTokens = PersonalAccessTokens::whereNotNull('retailer')->get();
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
                        return back()->with(['error' => 'Không thể lấy dữ liệu từ KiotViet']);
                    }

                    // Kiểm tra xem có dữ liệu không
                    $branches = $response->json()['data'] ?? [];
                    if (!isset($branches) || empty($branches)) {
                        break; // Dừng lại nếu không còn dữ liệu
                    }

                    Branch::where('account_code', $personalAccessToken->access_token_code)
                        ->update(['is_active' => false]);

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
                                'is_active'      => true,
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
            $personalAccessTokens = PersonalAccessTokens::whereNotNull('retailer')->get();
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
                        return back()->with(['error' => 'Không thể lấy dữ liệu từ KiotViet']);
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
    public function getCategories ($currentItem = 0)
    {
        $token = $this->kiotVietService->getAccessToken();
        $endpoint = 'https://public.kiotapi.com/categories';
        $pageSize = 100;
        $response = Http::withHeaders([
            'Retailer' => $this->kiotVietService->getRetailer(),
            'Authorization' => 'Bearer ' . $token,
        ])->get($endpoint,[
            'pageSize' => $pageSize,
            'currentItem' => $currentItem
        ]);
        $categories  = $response->json();
//        $categories = collect($categories['data']);
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
//    /**
//     * Đồng bộ điểm theo sự kiện
//    **/
//    public function SynchronizePoint ($customerID, $product)
//    {
//        $token = $this->kiotVietService->getAccessToken();
//        $endpoint = 'https://public.kiotapi.com/invoices?fromPurchaseDate='.$product->created_at.'&toPurchaseDate='.Carbon::now('Asia/Ho_Chi_Minh').'&customerIds='.$customerID.'&pageSize=100';
//        $response = Http::withHeaders([
//            'Retailer' => $this->kiotVietService->getRetailer(),
//            'Authorization' => 'Bearer ' . $token,
//        ])->get($endpoint);
//        $listInvoice = $response->json();
//        if (!empty($listInvoice) && !empty($listInvoice['data'])){
//            $index = ceil($listInvoice['total'] / $listInvoice['pageSize']);
//            $this->updatePointCustomer($listInvoice['data'], $customerID, $product);
//            if ($index > 1){
//                for ($i = 2; $i <= $index; $i++){
//                    $currentItem = $i*100;
//                    $endpoint = 'https://public.kiotapi.com/invoices?fromPurchaseDate='.$product->created_at.'&toPurchaseDate='.Carbon::now('Asia/Ho_Chi_Minh').'&customerIds='.$customerID.'&pageSize=100&currentItem='.$currentItem;
//                    $response = Http::withHeaders([
//                        'Retailer' => $this->kiotVietService->getRetailer(),
//                        'Authorization' => 'Bearer ' . $token,
//                    ])->get($endpoint);
//                    $dataInvoice = $response->json();
//                    if (!empty($dataInvoice) && !empty($dataInvoice['data'])){
//                        $this->updatePointCustomer($dataInvoice['data'],$customerID, $product);
//                    }
//                }
//            }
//        }
//        return true;
//    }

    /**
     * Cập nhật điểm khách hàng theo data hóa đơn
    **/
    protected function updatePointCustomer ($listInvoice, $customerID, $product)
    {
        $totalPoint = 0;
        $usePoint = 0;
        $listGiftCode = GiftEvent::where('active', 1)->pluck('code')->toArray();
        foreach ($listInvoice as $invoice){
            if ($invoice['statusValue'] == 'Hoàn thành'){
                foreach ($invoice['invoiceDetails'] as $invoiceDetail){
                    $check = HistoryPointEvent::where('customer_id', $customerID)->where('code_order', $invoice['code'])
                        ->where('product_id', $invoiceDetail['productId'])->exists();
                    if (!$check){
                        if ($product->code == $invoiceDetail['productCode']){
                            $pointEvents = $product->point * $invoiceDetail['quantity'];
                            $totalPoint += $pointEvents;
                            $historyPoint = new HistoryPointEvent([
                                'customer_id' => $customerID,
                                'title' => 'Tích điểm mua sản phẩm: '.$product->name,
                                'code_order' => $invoice['code'],
                                'product_id' => $invoiceDetail['productId'],
                                'product_code' => $invoiceDetail['productCode'],
                                'product_name' => $invoiceDetail['productName'],
                                'point' => $pointEvents,
                                'type' => 1
                            ]);
                            $historyPoint->save();
                        }else if (in_array($invoiceDetail['productCode'], $listGiftCode)){
                            if ($invoiceDetail['price'] == $invoiceDetail['discount']){
                                $gift = GiftEvent::where('code', $invoiceDetail['productCode'])->first();
                                $pointGift = $gift->point * $invoiceDetail['quantity'];
                                $usePoint += $pointGift;
                                $historyPoint = new HistoryPointEvent([
                                    'customer_id' => $customerID,
                                    'title' => 'Đổi quà tặng: '.$gift->name,
                                    'code_order' => $invoice['code'],
                                    'product_id' => $invoiceDetail['productId'],
                                    'product_code' => $invoiceDetail['productCode'],
                                    'product_name' => $invoiceDetail['productName'],
                                    'point' => $pointGift,
                                    'type' => 2
                                ]);
                                $historyPoint->save();
                                $exchange = new ExchangeGiftEvent([
                                    'customer_id' => $customerID,
                                    'gift_id' => $gift->id,
                                    'name_gift' => $gift->name,
                                    'image_gift' => $gift->image,
                                    'code_gift' => $gift->code,
                                    'barcode_gift' => $gift->barcode ?? null,
                                    'point' => $gift->point,
                                    'quantity' => $invoiceDetail['quantity'],
                                    'status' => 2,
                                    'branch_id' => $invoice['branchId']
                                ]);
                                $exchange->save();
                                $branch = Branch::where('kiotviet_id', $invoice['branchId'])->first();
                                if (isset($branch)){
                                    $quantityGift = QuantityGiftEvents::where('gift_events_id', $gift->id)->where('branch_id', $branch->id)->first();
                                    if (isset($quantityGift)){
                                        $quantityGift->quantity = $quantityGift->quantity - $invoiceDetail['quantity'];
                                        $quantityGift->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $customer = Customer::where('kiotviet_id', $customerID)->first();
        $customer->total_point_event = $customer->total_point_event + $totalPoint;
        $customer->used_point_event = $customer->used_point_event + $usePoint;
        $customer->save();
        return true;
    }
    /**
     * Lấy voucher campeign theo mã phát hành và tài khoản kiotviet
     */
    public function dataReleaseCode($array_release_code){
        try{
            $data_return = [];
            foreach ($array_release_code as $item){

                $tokens = $this->kiotVietService->getAccessTokenAllBranches($item['code']);
                $accessToken = $tokens->access_token;
                $retailer = $tokens->retailer;

                $pageSize = 100; // Số lượng tối đa mỗi lần gọi API
                $currentItem = 0; // Bắt đầu từ khách hàng đầu tiên

                $voucher_campaign_id = null;
                do{
                    $response = Http::withHeaders([
                        'Retailer'      => $retailer,
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type'  => 'application/json',
                    ])->get($this->urlKiotViet['url_voucher_campaign']."pageSize=$pageSize&currentItem=$currentItem");

                    if ($response->failed()) {
                        return back()->with(['error' => 'Không thể lấy dữ liệu từ KiotViet']);
                    }

                    // Kiểm tra xem có dữ liệu không
                    $responseData = $response->json()['data'] ?? [];
                    if (!isset($responseData) || empty($responseData)) {
                        break; // Dừng lại nếu không còn dữ liệu
                    }

                    foreach ($responseData as $responseItem) {
                        if ($item['release_code'] == $responseItem['code']){
                            $voucher_campaign_id = $responseItem['id'];
                            break;
                        }
                    }

                    // Cập nhật chỉ số để lấy trang tiếp theo
                    $currentItem += $pageSize;

                } while (count($responseData) === $pageSize); // Lặp cho đến khi hết dữ liệu

                $item['voucher_campaign_id'] = $voucher_campaign_id;
                if (!empty($voucher_campaign_id)){
                    array_push($data_return, $item);
                }
            }
            return $data_return;
        }catch (\Exception $exception){
            dd($exception);
        }
    }

    /**
     * Lấy danh sách danh mục sản phẩm kiotviet
    **/
    public function listCategories ()
    {
        $listData = [];
        $personalAccessTokens = PersonalAccessTokens::whereNotNull('retailer')->get();
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
                ])->get($this->urlKiotViet['url_category']."pageSize=$pageSize&currentItem=$currentItem");

                if ($response->failed()) {
                    break;
                }
                $responseData = $response->json()['data'] ?? [];
                if (!isset($responseData) || empty($responseData)) {
                    break; // Dừng lại nếu không còn dữ liệu
                }
                foreach ($responseData as $item){
                    $dataItem = [
                        'name' => $item['categoryName'],
                        'id' => $item['categoryId'],
                        'retailer' => $retailer
                    ];
                    $listData[] = $dataItem;
                }
                $currentItem += $pageSize;
            }while (count($responseData) === $pageSize);
        }
        return $listData;
    }
}
