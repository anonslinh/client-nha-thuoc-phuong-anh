<?php


namespace App\Services;

use App\Models\AccountBranches;
use App\Models\Customer;
use App\Models\PersonalAccessTokens;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class KiotVietService
{
    protected $clientId;
    protected $clientSecret;
    protected $tokenUrl;

    public function __construct()
    {
        $this->clientId = env('KIOTVIET_CLIENT_ID');
        $this->clientSecret = env('KIOTVIET_CLIENT_SECRET');
        $this->tokenUrl = 'https://id.kiotviet.vn/connect/token';
        $this->retailer = env('RETAILER_KIOTVIET');
    }

    /**
     * Token kiotviet
    */
    public function getAccessToken(){
        try{
            $token = PersonalAccessTokens::where('access_token_code', $this->retailer)->first();
            if (!$token || Carbon::now()->greaterThan($token->expires_at)) {
                return $this->refreshToken();
            }

            return $token->access_token;

        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Gọi API lấy token mới
     */
    public function refreshToken()
    {
        $response = Http::asForm()->post($this->tokenUrl, [
            'scopes' => 'PublicApi.Access',
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);

        if ($response->failed()) {
            throw new \Exception('Lỗi khi lấy token từ KiotViet');
        }

        $data = $response->json();
        $expiresAt = Carbon::now()->addSeconds($data['expires_in']);

        PersonalAccessTokens::updateOrCreate(
            ['id' => 1, 'access_token_code' => $this->retailer],
            [
                'access_token' => $data['access_token'],
                'expires_at' => $expiresAt
            ]
        );

        return $data['access_token'];
    }
    /**
     * retailer
    */
    public function getRetailer(){
        try{
            $token = env('RETAILER_KIOTVIET');

            return $token;
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Danh sách url từ kiotviet
    */
    public function urlKiotviet(){
        $data_return = [
            'url_connect_token' => 'https://id.kiotviet.vn/connect/token', //Lấy AccessTokens
            'url_branches' => 'https://public.kiotapi.com/branches?', //Lấy danh sách chi nhánh
            'url_users' => 'https://public.kiotapi.com/users?', // Tài khoản nhân viên
            'url_customers' => 'https://public.kiotapi.com/customers?', //Khách hàng
            'url_invoices' => 'https://public.kiotapi.com/invoices?', //Danh sách hoá đơn
            'url_voucher_campaign' => 'https://public.kiotapi.com/vouchercampaign?', //Danh sách đợt phát hành voucher
            'url_voucher_created' => 'https://public.kiotapi.com/voucher', // Tạo mã voucher để sử dụng theo mã phát hành voucher
            'url_voucher_cancel' => 'https://public.kiotapi.com/voucher/cancel', // Huỷ voucher đã phát hành trên kiotviet
            'url_voucher_release' => 'https://public.kiotapi.com/voucher/release/give', // Phát hành voucher trên kiotviet
            'url_create_invoice' => 'https://public.kiotapi.com/orders', // Tạo hóa đơn
            'url_detail_product' => 'https://public.kiotapi.com/products/code/', //  Chi tiết sản phẩm theo mã
            'url_category' => 'https://public.kiotapi.com/categories?', // Danh sách danh mục
            'url_list_product' => 'https://public.kiotapi.com/products?', // Danh sách sản phẩm
        ];

        return $data_return;
    }

    /**
     * Token kiotviet mới
     */
    public function getAccessTokenAllBranches($access_token_code){
        try{
            $token = PersonalAccessTokens::where('access_token_code', $access_token_code)->first();
            if (!$token || Carbon::now()->greaterThan($token->expires_at)) {
                $accountBranches = AccountBranches::where('code', $access_token_code)->first();
                return $this->refreshTokenAllBranches($accountBranches->client_id, $accountBranches->client_secret,
                    $accountBranches->code, $accountBranches->retailer);
            }
            return $token;

        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Gọi API lấy token mới
     */
    public function refreshTokenAllBranches($clientId, $clientSecret, $access_token_code, $retailer)
    {

        $url_connect_token = $this->urlKiotViet();
        $response = Http::asForm()->post($url_connect_token['url_connect_token'], [
            'scopes'       => 'PublicApi.Access',
            'grant_type'   => 'client_credentials',
            'client_id'    => $clientId,
            'client_secret'=> $clientSecret,
        ]);

        if ($response->failed()) {
            throw new \Exception('Lỗi khi lấy token từ KiotViet');
        }

        $data = $response->json();
        $expiresAt = Carbon::now()->addSeconds($data['expires_in']);

        $personalAccessTokens = PersonalAccessTokens::updateOrCreate(
            ['access_token_code' => $access_token_code],
            [
                'access_token' => $data['access_token'],
                'retailer'     => $retailer,
                'expires_at'   => $expiresAt
            ]
        );

        return $personalAccessTokens;
    }

    /**
     * Lấy thông tin khách hàng
    **/
    public function getDataCustomer ($phone, $name)
    {
        $personalAccessTokens = PersonalAccessTokens::whereNotNull('retailer')->get();
        $customer = null;
        $accessToken = null;
        $retailer = null;
        foreach ($personalAccessTokens as $personalAccessToken){
            $tokens = $this->getAccessTokenAllBranches($personalAccessToken->access_token_code);
            $accessToken = $tokens->access_token;
            $retailer = $tokens->retailer;
            $response = Http::withHeaders([
                'Retailer'      => $retailer,
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->get($this->urlKiotviet()['url_customers']."orderDirection=Desc&includeTotal=true&contactNumber=$phone");

            $data = $response->json()['data'] ?? [];
            if (!empty($data)){
                $customer = $data[0];
                break;
            }
        }
        if (empty($customer)){
            if (empty($retailer)){
                $number = 10000 + Customer::max('id') + 1;
                $customer = [
                    'id' => $number,
                    'code' => 'KH'.$number,
                    'name' => $name??$phone,
                    'contactNumber' => $phone,
                    'address' => null,
                    'retailer_id' => 1,
                    'branchId' => 1
                ];
            }else{
                $branch = $response = Http::withHeaders([
                    'Retailer'      => $retailer,
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type'  => 'application/json',
                ])->get($this->urlKiotviet()['url_branches']);
                $branch = $branch->json()['data'][0];
                $response = Http::withHeaders([
                    'Retailer'      => $retailer,
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type'  => 'application/json',
                ])->post($this->urlKiotviet()['url_customers'], [
                    'contactNumber' => $phone,
                    'name' => $name??$phone,
                    'branchId' =>$branch['id']
                ]);
                $customer = $response->json()['data'] ?? [];
            }
        }
        return $customer;
    }

        /**
     * Tạo ra mã số theo id bản ghi
     */
    public function encodeId($id) {
        $length = 8;
        $characters = 'A7F2D9KQX8M1Z3R0PLNBV6E5H4CTWYGU';
        $base = strlen($characters);
        $str = '';
        $num = ($id * 54673181) % 1000000000;
        do {
            $str = $characters[$num % $base] . $str;
            $num = floor($num / $base);
        } while ($num > 0);
        return str_pad($str, $length, $characters[0], STR_PAD_LEFT);
    }
}
