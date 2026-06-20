<?php

namespace App\Services;

use App\Models\WebsiteCustomerOtpV1;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WebsiteCustomerOtpV1Service
{
    const OTP_LENGTH = 4;
    const OTP_TTL_MINUTES = 5;
    const RESEND_COOLDOWN_SECONDS = 60;
    const MAX_VERIFY_ATTEMPTS = 5;

    /**
     * Sinh OTP mới, gửi qua Zalo (API outtech.io.vn) và lưu lại để đối chiếu.
     */
    public function send(string $phone): array
    {
        $phone = $this->normalizePhone($phone);

        $lastOtp = WebsiteCustomerOtpV1::query()
            ->where('phone', $phone)
            ->orderByDesc('id')
            ->first();

        if ($lastOtp && $lastOtp->created_at && $lastOtp->created_at->diffInSeconds(now()) < self::RESEND_COOLDOWN_SECONDS) {
            $wait = self::RESEND_COOLDOWN_SECONDS - $lastOtp->created_at->diffInSeconds(now());

            return [
                'status' => false,
                'msg' => 'Vui lòng đợi ' . $wait . ' giây để gửi lại mã OTP.',
            ];
        }

        $otp = (string) random_int(1000, 9999);
        $trackingId = 'NTPA' . now()->format('ymdHis') . rand(100, 999);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'X-API-KEY' => config('services.outtech_otp.api_key'),
            ])
                ->withOptions(['verify' => !app()->environment('local')])
                ->timeout(15)
                ->post(config('services.outtech_otp.url'), [
                    'phone' => $phone,
                    'otp' => $otp,
                    'tracking_id' => $trackingId,
                ]);

            $result = $response->json();
        } catch (\Throwable $e) {
            return [
                'status' => false,
                'msg' => 'Không thể kết nối tới dịch vụ gửi OTP. Vui lòng thử lại sau.',
            ];
        }

        if (!($result['status'] ?? false)) {
            return [
                'status' => false,
                'msg' => $result['message'] ?? 'Không thể gửi OTP qua Zalo. Vui lòng thử lại sau.',
            ];
        }

        WebsiteCustomerOtpV1::query()->create([
            'phone' => $phone,
            'otp' => $otp,
            'tracking_id' => $trackingId,
            'expires_at' => now()->addMinutes(self::OTP_TTL_MINUTES),
        ]);

        return [
            'status' => true,
            'msg' => 'Đã gửi mã OTP qua Zalo, vui lòng kiểm tra.',
        ];
    }

    /**
     * Đối chiếu OTP khách nhập với OTP mới nhất còn hiệu lực của số điện thoại đó.
     */
    public function verify(string $phone, string $otp): array
    {
        $phone = $this->normalizePhone($phone);

        $record = WebsiteCustomerOtpV1::query()
            ->where('phone', $phone)
            ->whereNull('verified_at')
            ->orderByDesc('id')
            ->first();

        if (!$record) {
            return ['status' => false, 'msg' => 'Vui lòng yêu cầu gửi mã OTP trước.'];
        }

        if (now()->greaterThan($record->expires_at)) {
            return ['status' => false, 'msg' => 'Mã OTP đã hết hạn, vui lòng yêu cầu gửi lại.'];
        }

        if ($record->attempt_count >= self::MAX_VERIFY_ATTEMPTS) {
            return ['status' => false, 'msg' => 'Bạn đã nhập sai quá nhiều lần, vui lòng yêu cầu gửi lại mã OTP.'];
        }

        if (trim($otp) !== $record->otp) {
            $record->increment('attempt_count');

            return ['status' => false, 'msg' => 'Mã OTP không đúng, vui lòng thử lại.'];
        }

        $record->update(['verified_at' => now()]);

        return ['status' => true, 'msg' => 'Xác thực OTP thành công.'];
    }

    public function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (Str::startsWith($phone, '84')) {
            $phone = '0' . substr($phone, 2);
        }

        return $phone;
    }
}
