<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureWebsiteCustomerLoggedIn
{
    /**
     * Chặn truy cập các trang yêu cầu đăng nhập khách hàng (OTP qua Zalo).
     * Không cho phép xem dữ liệu (đơn thuốc đã mua, điểm thưởng...) bằng cách
     * tự nhập số điện thoại của người khác khi chưa xác thực OTP.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('website_customer')->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Vui lòng đăng nhập để sử dụng tính năng này.',
                ], 401);
            }

            return redirect()
                ->route('index')
                ->with('error', 'Vui lòng đăng nhập để sử dụng tính năng này.')
                ->with('open_login_popup', true);
        }

        return $next($request);
    }
}
