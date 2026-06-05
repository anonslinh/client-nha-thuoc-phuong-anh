<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use App\Models\PrescriptionRequestV1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebsitePrescriptionRequestV1Controller extends Controller
{
    public function index(Request $request)
    {
        $guestCheckoutInfo = session('guest_checkout_info', [
            'customer_name'  => '',
            'customer_phone' => '',
            'customer_email' => '',
            'province_name'  => 'Cao Bằng',
            'district_name'  => '',
            'ward_name'      => '',
            'address_detail' => '',
        ]);

        $customerAddress = $this->buildAddressFromGuestInfo($guestCheckoutInfo);
        $customerPhone = trim((string) ($guestCheckoutInfo['customer_phone'] ?? ''));

        $requests = collect();

        if ($customerPhone !== '') {
            $requests = PrescriptionRequestV1::query()
                ->where('customer_phone', $customerPhone)
                ->orderByDesc('id')
                ->limit(20)
                ->get()
                ->map(function ($item) {
                    $statusMeta = $this->getStatusMeta((int) $item->status);

                    $item->status_label = $statusMeta['label'];
                    $item->status_class = $statusMeta['class'];
                    $item->image_url = $this->formatImageUrl($item->prescription_image);
                    $item->created_at_format = optional($item->created_at)->format('d/m/Y H:i');
                    $item->confirmed_at_format = optional($item->confirmed_at)->format('d/m/Y H:i');
                    $item->processed_at_format = optional($item->processed_at)->format('d/m/Y H:i');

                    return $item;
                });
        }

        $summary = [
            'total' => $requests->count(),
            'pending' => $requests->where('status', 0)->count(),
            'confirmed' => $requests->where('status', 1)->count(),
            'processed' => $requests->where('status', 2)->count(),
        ];

        return view('website.prescription-request-v1.index', compact(
            'guestCheckoutInfo',
            'customerAddress',
            'customerPhone',
            'requests',
            'summary'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_address' => ['nullable', 'string'],
            'prescription_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'prescription_content' => ['nullable', 'string'],
            'note' => ['nullable', 'string'],
        ], [
            'customer_name.required' => 'Vui lòng nhập họ và tên.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'prescription_image.image' => 'File đơn thuốc phải là hình ảnh.',
            'prescription_image.mimes' => 'Ảnh đơn thuốc chỉ hỗ trợ jpg, jpeg, png, webp.',
            'prescription_image.max' => 'Ảnh đơn thuốc tối đa 5MB.',
        ]);

        $validator->after(function ($validator) use ($request) {
            $hasImage = $request->hasFile('prescription_image');
            $hasContent = trim((string) $request->input('prescription_content')) !== '';

            if (!$hasImage && !$hasContent) {
                $validator->errors()->add(
                    'prescription_content',
                    'Vui lòng upload ảnh đơn thuốc hoặc nhập nội dung thuốc cần mua.'
                );
            }
        });

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imagePath = null;

        if ($request->hasFile('prescription_image')) {
            $imagePath = $request->file('prescription_image')->store('prescription_requests_v1', 'public');
            $imagePath = 'storage/' . $imagePath;
        }

        $customerAddress = trim((string) $request->customer_address);

        PrescriptionRequestV1::query()->create([
            'request_code' => $this->generateRequestCode(),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $customerAddress,
            'prescription_image' => $imagePath,
            'prescription_content' => $request->prescription_content,
            'note' => $request->note,
            'status' => 0,
        ]);

        session([
            'guest_checkout_info' => [
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => session('guest_checkout_info.customer_email', ''),
                'province_name'  => session('guest_checkout_info.province_name', 'Cao Bằng'),
                'district_name'  => session('guest_checkout_info.district_name', ''),
                'ward_name'      => session('guest_checkout_info.ward_name', ''),
                'address_detail' => $customerAddress ?: session('guest_checkout_info.address_detail', ''),
            ]
        ]);

        return redirect()
            ->route('website.prescription_request_v1.index')
            ->with('success', 'Yêu cầu mua thuốc của bạn đã được gửi thành công. Dược sĩ Nhà thuốc Phương Anh sẽ liên hệ lại trong thời gian sớm nhất.');
    }

    protected function buildAddressFromGuestInfo(array $guestCheckoutInfo): string
    {
        return trim(implode(', ', array_filter([
            $guestCheckoutInfo['address_detail'] ?? '',
            $guestCheckoutInfo['ward_name'] ?? '',
            $guestCheckoutInfo['district_name'] ?? '',
            $guestCheckoutInfo['province_name'] ?? 'Cao Bằng',
        ])));
    }

    protected function generateRequestCode(): string
    {
        do {
            $code = 'DTH' . now()->format('ymdHis') . rand(10, 99);
        } while (PrescriptionRequestV1::query()->where('request_code', $code)->exists());

        return $code;
    }

    protected function getStatusMeta(int $status): array
    {
        return match ($status) {
            0 => [
                'label' => 'Chưa xác nhận',
                'class' => 'is-pending',
            ],
            1 => [
                'label' => 'Đã xác nhận',
                'class' => 'is-confirmed',
            ],
            2 => [
                'label' => 'Đã xử lý',
                'class' => 'is-processed',
            ],
            default => [
                'label' => 'Đang cập nhật',
                'class' => 'is-default',
            ],
        };
    }

    protected function formatImageUrl(?string $path): string
    {
        if (!$path) {
            return asset('assets/images/no-image.png');
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }
}