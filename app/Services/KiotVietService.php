<?php


namespace App\Services;

use App\Models\AccountBranches;
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
    }

    /**
     * Token kiotviet
    */
    public function getAccessToken(){
        try{
            $token = PersonalAccessTokens::where('access_token_code', 'KIOTVIET')->first();
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
            ['id' => 1, 'access_token_code' => 'KIOTVIET'],
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
}
