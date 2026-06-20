<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use App\Models\WebsiteCustomerV1;
use App\Services\WebsiteCustomerOtpV1Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebsiteAuthV1Controller extends Controller
{
    public function sendOtp(Request $request, WebsiteCustomerOtpV1Service $otpService)
    {
        $request->validate([
            'phone' => ['required', 'string', 'regex:/^0[0-9]{9}$/'],
        ], [
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không hợp lệ (VD: 0912345678).',
        ]);

        $phone = $otpService->normalizePhone($request->phone);

        $result = $otpService->send($phone);

        if (!$result['status']) {
            return response()->json($result, 200);
        }

        $isNewCustomer = !WebsiteCustomerV1::query()->where('phone', $phone)->exists();

        return response()->json([
            'status' => true,
            'msg' => $result['msg'],
            'is_new_customer' => $isNewCustomer,
        ]);
    }

    public function verifyOtp(Request $request, WebsiteCustomerOtpV1Service $otpService)
    {
        $request->validate([
            'phone' => ['required', 'string'],
            'otp' => ['required', 'string', 'max:10'],
        ], [
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'otp.required' => 'Vui lòng nhập mã OTP.',
        ]);

        $phone = $otpService->normalizePhone($request->phone);

        $result = $otpService->verify($phone, $request->otp);

        if (!$result['status']) {
            return response()->json($result, 200);
        }

        $customer = WebsiteCustomerV1::query()->firstOrCreate(
            ['phone' => $phone],
            ['name' => $request->input('name'), 'is_active' => 1]
        );

        if ($request->filled('name') && empty($customer->name)) {
            $customer->update(['name' => $request->input('name')]);
        }

        $customer->update(['last_login_at' => now()]);

        Auth::guard('website_customer')->login($customer, true);

        $this->syncGuestSessionFromCustomer($customer);

        return response()->json([
            'status' => true,
            'msg' => 'Đăng nhập thành công.',
            'customer' => $this->formatCustomer($customer),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('website_customer')->user();

        if (!$customer) {
            return response()->json(['status' => false, 'msg' => 'Vui lòng đăng nhập trước.'], 401);
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'province_name' => ['nullable', 'string', 'max:255'],
            'district_name' => ['nullable', 'string', 'max:255'],
            'ward_name' => ['nullable', 'string', 'max:255'],
            'address_detail' => ['nullable', 'string'],
        ], [
            'customer_name.required' => 'Vui lòng nhập họ và tên.',
            'customer_email.email' => 'Email không đúng định dạng.',
        ]);

        $customer->update([
            'name' => $validated['customer_name'],
            'email' => $validated['customer_email'] ?? null,
            'province_name' => $validated['province_name'] ?? 'Cao Bằng',
            'district_name' => $validated['district_name'] ?? null,
            'ward_name' => $validated['ward_name'] ?? null,
            'address_detail' => $validated['address_detail'] ?? null,
        ]);

        $this->syncGuestSessionFromCustomer($customer);

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công.');
    }

    public function logout(Request $request)
    {
        Auth::guard('website_customer')->logout();

        $request->session()->forget('guest_checkout_info');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->back()->with('success', 'Đã đăng xuất.');
    }

    public function me(Request $request)
    {
        $customer = Auth::guard('website_customer')->user();

        if (!$customer) {
            return response()->json(['status' => false, 'logged_in' => false]);
        }

        return response()->json([
            'status' => true,
            'logged_in' => true,
            'customer' => $this->formatCustomer($customer),
        ]);
    }

    protected function syncGuestSessionFromCustomer(WebsiteCustomerV1 $customer): void
    {
        session([
            'guest_checkout_info' => [
                'customer_name'  => $customer->name ?? '',
                'customer_phone' => $customer->phone ?? '',
                'customer_email' => $customer->email ?? '',
                'province_name'  => $customer->province_name ?? 'Cao Bằng',
                'district_name'  => $customer->district_name ?? '',
                'ward_name'      => $customer->ward_name ?? '',
                'address_detail' => $customer->address_detail ?? '',
            ],
        ]);
    }

    protected function formatCustomer(WebsiteCustomerV1 $customer): array
    {
        return [
            'name' => $customer->name,
            'phone' => $customer->phone,
            'email' => $customer->email,
            'province_name' => $customer->province_name,
            'district_name' => $customer->district_name,
            'ward_name' => $customer->ward_name,
            'address_detail' => $customer->address_detail,
            'needs_profile' => empty($customer->name),
        ];
    }
}
