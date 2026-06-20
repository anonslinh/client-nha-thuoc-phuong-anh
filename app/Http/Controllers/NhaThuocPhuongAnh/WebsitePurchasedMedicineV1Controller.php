<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebsitePurchasedMedicineV1Controller extends Controller
{
    public function index(Request $request)
    {
        $guestCheckoutInfo = session('guest_checkout_info', []);

        // Route đã bị chặn bởi middleware website_customer.auth nên luôn có khách hàng đăng nhập tại đây.
        // Lấy SĐT từ tài khoản đã xác thực OTP, KHÔNG lấy từ input/URL để tránh xem được dữ liệu của người khác.
        $initialPhone = trim((string) (Auth::guard('website_customer')->user()->phone ?? ''));

        return view('website.purchased-medicine-v1.index', compact(
            'guestCheckoutInfo',
            'initialPhone'
        ));
    }
}