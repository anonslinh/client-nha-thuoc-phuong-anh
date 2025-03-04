<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zalo\Zalo;
use Zalo\ZaloEndPoint;

class LoginZaloController extends Controller
{
    public function loginZalo ()
    {
        $codeVerifier = 'aX9OS2Lserixux39wUJUJ6tIO5TnFhgggg5I7A3gSE7';
        $codeChallenge = rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');
        $config = array(
            'app_id' => '2308972398308356836',
            'app_secret' => 'zr540EK1ugQ42NkTBNE1'
        );
        $zalo = new Zalo($config);
        $helper = $zalo -> getRedirectLoginHelper();
        $callbackUrl = "https://chipchipluxury.winwingroup.vn/zalo";
        $state = "state";
        $loginUrl = $helper->getLoginUrl($callbackUrl, $codeChallenge, $state);
        return redirect()->to($loginUrl);
    }

    public function zaloUser (Request $request)
    {
        $code = $request->get('code');
        $codeVerifier = 'aX9OS2Lserixux39wUJUJ6tIO5TnFhgggg5I7A3gSE7';
        $codeChallenge = rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');
        $codeCheck = $request->get('code_challenge');
        if ($codeChallenge != $codeCheck){
            return back()->with(['error' => 'Đã có lỗi xảy ra.Vui lòng kiểm tra lại']);
        }
        $config = array(
            'app_id' => '2308972398308356836',
            'app_secret' => 'zr540EK1ugQ42NkTBNE1'
        );
        $zalo = new Zalo($config);
        $helper = $zalo->getRedirectLoginHelper();
        $zaloToken = $helper->getZaloToken($code);
        $accessToken = $zaloToken->getAccessToken();
        $params = ['fields' => 'id,name,picture,phone'];
        $response = $zalo->get(ZaloEndPoint::API_GRAPH_ME, $accessToken, $params);
        $result = $response->getDecodedBody();
        dd($result);
    }
}
