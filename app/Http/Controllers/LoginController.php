<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\ModelDistributor;
use App\Models\PasswordResetToken;
use App\Models\RankDistributor;
use App\Models\User;
use App\Models\UserAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login ()
    {
        return view('login');
    }

    public function register ()
    {
        return view('register');
    }

    public function userRegister (Request $request)
    {
        try{
            $user = new User([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password'))
            ]);
            $user->save();
            return redirect()->route('login')->with(['success' => 'Đăng ký thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Đăng ký không thành công']);
        }
    }

    public function doLogin (Request $request)
    {
        $bodyData = $request->all();
        $dataAttemptAdmin = [
            'email' => $bodyData['email'],
            'password' => $bodyData['password'],
        ];
        if (Auth::guard('users')->attempt($dataAttemptAdmin, $request->get('remember', false))) {

            return redirect()->route('index');
        }
        return redirect()->route('login')->withErrors(['Tài khoản hoặc mật khẩu không chính xác']);
    }
}
