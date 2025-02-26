<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function login ()
    {
        return view('login');
    }
    public function forgotPassword ()
    {
        return view('authentication-forgot-password');
    }
    public function storeForgotPassword(Request $request){
        // Kiểm tra lỗi validation
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.exists' => 'Email này không tồn tại trong hệ thống.',
        ]);

        $email = $request->email;

        // Tạo token reset mật khẩu
        $token = Str::random(60);

        try {
            // Lưu token vào bảng password_resets
            PasswordResetToken::upsert([
                'email' => $email,
                'token' => Hash::make($token),
                'created_at' => now()
            ], ['email'], ['token', 'created_at']);

            // Gửi email đặt lại mật khẩu
            Mail::send('send-emails.forgot-password', ['token' => $token], function ($message) use ($email) {
                $message->to($email)->subject('Đặt lại mật khẩu của bạn');
            });

            return back()->with('success', 'Email đặt lại mật khẩu đã được gửi thành công! Vui lòng kiểm tra email của bạn.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại sau.']);
        }
    }

    public function showResetForm(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect()->route('login')->withErrors(['error' => 'Token không hợp lệ hoặc đã hết hạn.']);
        }

        return view('reset-password', compact('token'));
    }

    public function storeResetPassword(Request $request)
    {
        // Kiểm tra validation
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.exists' => 'Email này không tồn tại trong hệ thống.',
        ]);

        $tokenData = PasswordResetToken::where('email', $request->email)->first();

        // Kiểm tra token có hợp lệ không
        if (!$tokenData || !Hash::check($request->token, $tokenData->token)) {
            return redirect()->route('login')->withErrors(['error' => 'Token không hợp lệ hoặc đã hết hạn.']);
        }

        // Cập nhật mật khẩu cho user
        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        // Xóa token reset
        PasswordResetToken::where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Mật khẩu đã được cập nhật thành công. Vui lòng đăng nhập.');
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
