<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsiteGuestCustomerController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'  => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'province_name'  => ['nullable', 'string', 'max:255'],
            'district_name'  => ['nullable', 'string', 'max:255'],
            'ward_name'      => ['nullable', 'string', 'max:255'],
            'address_detail' => ['nullable', 'string'],
        ], [
            'customer_name.required'  => 'Vui lòng nhập họ và tên.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'customer_email.email'    => 'Email không đúng định dạng.',
        ]);

        session([
            'guest_checkout_info' => [
                'customer_name'  => $validated['customer_name'] ?? '',
                'customer_phone' => $validated['customer_phone'] ?? '',
                'customer_email' => $validated['customer_email'] ?? '',
                'province_name'  => $validated['province_name'] ?? 'Cao Bằng',
                'district_name'  => $validated['district_name'] ?? '',
                'ward_name'      => $validated['ward_name'] ?? '',
                'address_detail' => $validated['address_detail'] ?? '',
            ]
        ]);

        return back()->with('success', 'Đã lưu thông tin khách hàng.');
    }

    public function clear(Request $request)
    {
        $request->session()->forget('guest_checkout_info');

        return back()->with('success', 'Đã xóa thông tin khách hàng đã lưu.');
    }
}