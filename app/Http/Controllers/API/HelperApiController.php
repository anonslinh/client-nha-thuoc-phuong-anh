<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerSyncLog;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\PersonalAccessTokens;
use Illuminate\Support\Facades\Http;
use App\Services\KiotVietService;
use App\Models\CustomerRank;
use App\Models\CustomerSpendingSummary;
use App\Models\MembershipLevel;
use Carbon\Carbon;

class HelperApiController extends Controller
{
    protected $kiotVietService;
    protected $urlKiotViet;

    public function __construct(KiotVietService $kiotVietService) {
        $this->kiotVietService = $kiotVietService;
        $this->urlKiotViet = $kiotVietService->urlKiotviet();

    }

    /**
     * Chuẩn hóa số điện thoại: Chuyển '84xxxxxxxxx' thành '0xxxxxxxxx'
     */
    public function normalizePhone($phone)
    {
        return preg_replace('/^84/', '0', $phone);
    }

    /**
     * Lấy thông tin khách hàng dựa trên số điện thoại.
     *
     * @param string $phone Số điện thoại khách hàng (có thể là 84xxxxxxxxx hoặc 0xxxxxxxxx)
     * @return Customer|null Trả về đối tượng Customer nếu tìm thấy, ngược lại trả về null
     */
    protected function getCustomerByPhone($phone)
    {
        // Chuẩn hóa số điện thoại: Nếu bắt đầu bằng '84', chuyển thành '0'
        $phone = preg_replace('/^84/', '0', $phone);

        // Tìm khách hàng có contact_number hợp lệ và khớp với số điện thoại
        return Customer::whereNotNull('contact_number') // Bỏ qua contact_number null
        ->where('contact_number', '!=', '') // Bỏ qua contact_number rỗng
        ->where('contact_number', $phone) // So khớp với số điện thoại đã chuẩn hóa
        ->first();
    }

    /**
     * Đồng bộ thông tin khách hàng và hoá đơn
     */
    public function syncCustomerInvoices($phone)
    {
        if (!$phone) {
            return response()->json(['status' => false, 'data' => []], 400);
        }

        try {
            $personalAccessTokens = PersonalAccessTokens::all();
            $firstCustomer = null;
            $totalInvoiced = 0;
            $totalRevenue = 0;
            $totalPoint = 0;
            $rewardPoint = 0;

            foreach ($personalAccessTokens as $personalAccessToken){

//                //Hard code du lieu test
//                if ($personalAccessToken->access_token_code == 'hmvietnam'){
//                    $phone = '0963119570';
//                }elseif ($personalAccessToken->access_token_code == 'hethongbabychipchip'){
//                    $phone = '0982375649';
//                }
//                else{
//                    $phone = '0981163959';
//                }

                $tokens = $this->kiotVietService->getAccessTokenAllBranches($personalAccessToken->access_token_code);
                $accessToken = $tokens->access_token;
                $retailer = $tokens->retailer;

                $customer = $this->fetchCustomerByPhone($phone, $accessToken, $retailer);
                if ($customer){
                    if (!$firstCustomer) {
                        $firstCustomer = $customer; // Chọn dữ liệu mặc định là token đầu tiên có dữ liệu
                    }

                    $this->customerSyncLogs($customer, $personalAccessToken);

                    // Cộng dồn các chỉ số
                    $totalInvoiced += $customer['totalInvoiced'] ?? 0;
                    $totalRevenue += $customer['totalRevenue'] ?? 0;
                    $totalPoint += $customer['totalPoint'] ?? 0;
                    $rewardPoint += $customer['rewardPoint'] ?? 0;
                }
            }
            if (!empty($firstCustomer)) {
                \DB::transaction(function () use ($firstCustomer, $totalInvoiced, $totalRevenue, $totalPoint, $rewardPoint, $phone) {
                    $this->syncCustomerData($firstCustomer, $totalInvoiced, $totalRevenue, $totalPoint, $rewardPoint);
                    $this->syncCustomerInvoicesData($phone, $firstCustomer);
                });
            }

            return response()->json(['status' => true, 'message' => 'Sync successful']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Lưu lại dữ liệu log khi đồng bộ khách hàng
    */
    public function customerSyncLogs($customer, $personalAccessToken){

//        $customer['contactNumber'] = '0981163959';//Hard code du lieu test
        CustomerSyncLog::updateOrCreate(
            ['phone' => $customer['contactNumber'], 'personal_access_token' => $personalAccessToken->access_token_code],
            [
                'phone'                => $customer['contactNumber'],
                'personal_access_token' => $personalAccessToken->access_token_code,
                'kiotviet_id'          => $customer['id'],
                'total_invoiced'       => $customer['totalInvoiced'] ?? 0,
                'total_revenue'        => $customer['totalRevenue'] ?? 0,
                'total_point'          => $customer['totalPoint'] ?? 0,
                'reward_point'         => $customer['rewardPoint'] ?? 0,
            ]
        );

    }

    /**
     * Lấy thông tin khách hàng từ KiotViet
     */
    private function fetchCustomerByPhone($phone, $accessToken, $retailer)
    {
        $response = Http::withHeaders([
            'Retailer'      => $retailer,
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type'  => 'application/json',
        ])->get($this->urlKiotViet['url_customers']."orderDirection=Desc&includeTotal=true&contactNumber=$phone");

        $data = $response->json()['data'] ?? [];
        return !empty($data) ? $data[0] : null;
    }

    /**
     * Đồng bộ thông tin khách hàng vào database
     */
    private function syncCustomerData($customer, $totalInvoiced, $totalRevenue, $totalPoint, $rewardPoint)
    {
        try{
            $existingCustomer = Customer::where('kiotviet_id', $customer['id'])->first();

            // Tính toán điểm thực tế
            $usedPoints = $existingCustomer->used_points ?? 0;

            // Điểm thực tế = điểm từ KiotViet - điểm đã dùng + điểm thưởng từ đánh giá
            $actualRewardPoint = max($rewardPoint - $usedPoints , 0);

//            $customer['contactNumber'] = '0981163959'; //Hard code du lieu test
            Customer::updateOrCreate(
                ['kiotviet_id' => $customer['id']],
                [
                    'code'           => $customer['code'] ?? null,
                    'name'           => $customer['name'],
                    'contact_number' => $customer['contactNumber'] ?? null,
                    'address'        => $customer['address'] ?? null,
                    'retailer_id'    => $customer['retailerId'],
                    'branch_id'      => $customer['branchId'],
                    'location_name'  => $customer['locationName'] ?? null,
                    'ward_name'      => $customer['wardName'] ?? null,
                    'modified_date'  => $customer['modifiedDate'] ?? null,
                    'created_date'   => $customer['createdDate'] ?? null,
                    'type'           => $customer['type'] ?? 0,
                    'organization'   => $customer['organization'] ?? null,
                    'comments'       => $customer['comments'] ?? null,
                    'debt'           => $customer['debt'] ?? 0,
                    'total_invoiced' => $totalInvoiced ?? 0,
                    'total_revenue'  => $totalRevenue ?? 0,
                    'total_point'    => $totalPoint ?? 0,
                    'kiotviet_reward_point' => $rewardPoint,
                    'used_points'    => $usedPoints,
                    'reward_point'   => $actualRewardPoint, // Cập nhật điểm thực tế
                ]
            );
        }catch (\Exception $exception){
            \Log::error('Lỗi xảy ra: ' . $exception->getMessage(), [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);;
        }
    }

    /**
     * Đồng bộ hóa đơn của khách hàng
     */
    private function syncCustomerInvoicesData($phone, $firstCustomer)
    {
        try{
            $customerSyncLogs = CustomerSyncLog::where('phone', $phone)
                ->whereHas('personalAccessToken')
                ->with(['personalAccessToken' => function ($query) {
                    $query->select('access_token_code', 'access_token', 'retailer');
                }])
                ->get();

            $lastDayOfYear = Carbon::now()->addDay()->toDateString(); // Ngày hôm nay + 1 ngày
            $firstDayOfYear = Carbon::now()->subYear()->addDay()->toDateString(); // Ngày hôm nay - 1 năm + 1 ngày

            foreach ($customerSyncLogs as $customerSyncLog){
                $pageSize = 100;
                $currentItem = 0;
                $tokens = $this->kiotVietService->getAccessTokenAllBranches($customerSyncLog->personal_access_token);
                $accessToken = $tokens->access_token;
                $retailer = $tokens->retailer;
                $customerId = $customerSyncLog->kiotviet_id;

                do {
                    $response = Http::withHeaders([
                        'Retailer'      => $retailer,
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type'  => 'application/json',
                    ])->get($this->urlKiotViet['url_invoices']."customerIds=$customerId&status=1&orderDirection=Desc&pageSize=$pageSize
                    &currentItem=$currentItem&fromPurchaseDate=$firstDayOfYear&toPurchaseDate=$lastDayOfYear");

                    $invoicesData = $response->json()['data'] ?? [];

                    if (empty($invoicesData)) {
                        break;
                    }

                    $this->storeInvoices($invoicesData, $customerSyncLog, $firstCustomer);

                    $currentItem += $pageSize;
                } while (count($invoicesData) === $pageSize);
            }
        }catch (\Exception $exception){
            \Log::error('Lỗi xảy ra: ' . $exception->getMessage(), [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }
    }

    /**
     * Lưu hóa đơn vào database
     */
    private function storeInvoices($invoicesData, $customerSyncLog, $firstCustomer)
    {
        try{
            foreach ($invoicesData as $invoiceData) {
                $invoice = Invoice::updateOrCreate(
                    [
                        'kiotviet_id' => $invoiceData['id'],
                        'contact_number'  => $customerSyncLog->phone,
                        'personal_access_token'  => $customerSyncLog->personal_access_token
                    ],
                    [
                        'uuid'            => $invoiceData['uuid'],
                        'code'            => $invoiceData['code'],
                        'purchase_date'   => $invoiceData['purchaseDate'],
                        'branch_id'       => $invoiceData['branchId'],
                        'branch_name'     => $invoiceData['branchName'],
                        'sold_by_id'      => $invoiceData['soldById'],
                        'sold_by_name'    => $invoiceData['soldByName'],
                        'customer_id'     => $invoiceData['customerId'],
                        'customer_code'   => $invoiceData['customerCode'],
                        'customer_name'   => $invoiceData['customerName'],
                        'order_code'      => $invoiceData['orderCode'],
                        'total'           => $invoiceData['total'],
                        'total_payment'   => $invoiceData['totalPayment'],
                        'status'          => $invoiceData['status'],
                        'status_value'    => $invoiceData['statusValue'],
                        'using_cod'       => $invoiceData['usingCod'],
                        'created_date'    => $invoiceData['createdDate'],
                        'contact_number'  => $customerSyncLog->phone,
                        'personal_access_token'  => $customerSyncLog->personal_access_token,
                    ]
                );

                $this->storeInvoiceDetails($invoice->id, $invoiceData['invoiceDetails']);
                // Nếu đơn hàng mới được tạo, gọi function tính hạng thẻ
                if ($invoice->wasRecentlyCreated) {
                    $this->updateMembershipTier($firstCustomer['id'], $invoiceData['totalPayment'], $invoiceData['createdDate'], $customerSyncLog->phone);
                }
            }
        }catch (\Exception $exception){
            \Log::error('Lỗi xảy ra: ' . $exception->getMessage(), [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }
    }

    /**
     * Lưu chi tiết hóa đơn vào database
     */
    private function storeInvoiceDetails($invoiceId, $invoiceDetails)
    {
        $details = array_map(function ($detail) use ($invoiceId) {
            return [
                'invoice_id'      => $invoiceId,
                'product_id'      => $detail['productId'],
                'product_code'    => $detail['productCode'],
                'product_name'    => $detail['productName'],
                'category_id'     => $detail['categoryId'],
                'category_name'   => $detail['categoryName'],
                'trade_mark_id'   => $detail['tradeMarkId'] ?? null,
                'trade_mark_name' => $detail['tradeMarkName'] ?? null,
                'quantity'        => $detail['quantity'],
                'price'           => $detail['price'],
                'discount'        => $detail['discount'],
                'use_point'       => $detail['usePoint'] ?? 0,
                'sub_total'       => $detail['subTotal'],
                'serial_numbers'  => $detail['serialNumbers'] ?? null,
                'return_quantity' => $detail['returnQuantity'],
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }, $invoiceDetails);

        InvoiceDetail::insert($details);
    }

    /**
     * Cập nhật hạng thẻ thành viên
    */
    private function updateMembershipTier($firstCustomerId, $amount, $createdDate, $phone)
    {
        try{
            $date = Carbon::parse($createdDate);
            $month = $date->month;
            $year  = $date->year;

            // Chỉ tính hóa đơn của năm hiện tại
            if ($year < now()->year) {
                return;
            }

            // Cập nhật tổng chi tiêu của khách hàng trong tháng hiện tại
            $spendingSummary = CustomerSpendingSummary::updateOrCreate(
                ['contact_number' => $phone, 'month' => $month, 'year' => $year],
                ['customer_id' => $firstCustomerId, 'total_spent' => \DB::raw("total_spent + $amount")]
            );

            // Lấy tổng chi tiêu sau cập nhật
            $totalSpent = $spendingSummary->fresh()->total_spent;

            // Lấy danh sách hạng thẻ (sắp xếp giảm dần theo spending_threshold)
            $membershipLevels = MembershipLevel::orderBy('spending_threshold', 'desc')->get();

            // Xác định hạng thẻ phù hợp
            $newRank = null;
            foreach ($membershipLevels as $level) {
                if ($totalSpent >= $level->spending_threshold) {
                    $newRank = $level->rank;
                    break;
                }
            }

            if (!$newRank) {
                return;
            }

            // Cập nhật hoặc tạo mới hạng thẻ trong customer_ranks
            CustomerRank::updateOrCreate(
                ['contact_number' => $phone],
                [
                    'customer_id' => $firstCustomerId,
                    'current_rank'    => $newRank,
                    'rank_start_date' => Carbon::create($year, $month, 1), // Đầu tháng
                    'rank_end_date'   => Carbon::create($year, $month, 1)->endOfMonth(), // Cuối tháng
                ]
            );
        }catch (\Exception $exception){
            \Log::error('Lỗi xảy ra: ' . $exception->getMessage(), [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }
    }
}
