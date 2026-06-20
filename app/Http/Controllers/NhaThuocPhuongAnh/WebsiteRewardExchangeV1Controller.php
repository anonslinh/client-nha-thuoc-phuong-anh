<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebsiteRewardExchangeV1Controller extends Controller
{
    public function index(Request $request)
    {
        $guestCheckoutInfo = session('guest_checkout_info', []);
        $customer = Auth::guard('website_customer')->user();

        // Route đã bị chặn bởi middleware website_customer.auth nên luôn có khách hàng đăng nhập tại đây.
        // Lấy SĐT từ tài khoản đã xác thực OTP, KHÔNG lấy từ input/URL để tránh xem/đổi quà bằng SĐT người khác.
        $initialPhone = trim((string) ($customer->phone ?? ''));
        $initialName = trim((string) ($customer->name ?? ($guestCheckoutInfo['customer_name'] ?? '')));

        return view('website.reward-exchange-v1.index', compact(
            'guestCheckoutInfo',
            'initialPhone',
            'initialName'
        ));
    }
}