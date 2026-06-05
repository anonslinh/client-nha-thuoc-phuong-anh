<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use App\Models\OrderV1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebsiteMyOrderV1Controller extends Controller
{
    public function index(Request $request)
    {
        $guestCheckoutInfo = session('guest_checkout_info', []);
        $customerPhone = trim((string) ($guestCheckoutInfo['customer_phone'] ?? ''));
        $statusFilter = (string) $request->get('status', 'all');

        $orders = null;
        $stats = [
            'total' => 0,
            'processing' => 0,
            'completed' => 0,
            'cancelled' => 0,
        ];

        $filterOptions = [
            'all' => 'Tất cả',
            'new' => 'Mới tạo',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
        ];

        if ($customerPhone !== '') {
            $baseQuery = OrderV1::query()
                ->where('customer_phone', $customerPhone);

            $stats['total'] = (clone $baseQuery)->count();
            $stats['completed'] = (clone $baseQuery)->where('order_status', 6)->count();
            $stats['cancelled'] = (clone $baseQuery)->where('order_status', 7)->count();
            $stats['processing'] = (clone $baseQuery)->whereIn('order_status', [0, 1, 2, 3, 4, 5])->count();

            $ordersQuery = OrderV1::query()
                ->with(['items'])
                ->where('customer_phone', $customerPhone);

            switch ($statusFilter) {
                case 'new':
                    $ordersQuery->where('order_status', 0);
                    break;

                case 'processing':
                    $ordersQuery->whereIn('order_status', [1, 2, 3, 4]);
                    break;

                case 'shipping':
                    $ordersQuery->where('order_status', 5);
                    break;

                case 'completed':
                    $ordersQuery->where('order_status', 6);
                    break;

                case 'cancelled':
                    $ordersQuery->where('order_status', 7);
                    break;

                case 'all':
                default:
                    break;
            }

            $orders = $ordersQuery
                ->orderByDesc('created_at')
                ->paginate(10)
                ->withQueryString();

            $branchIds = collect($orders->items())
                ->pluck('id_branch_pickup')
                ->filter()
                ->unique()
                ->values()
                ->all();

            $branches = [];
            if (!empty($branchIds)) {
                $branches = DB::table('branches')
                    ->whereIn('id', $branchIds)
                    ->pluck('branch_name as name', 'id')
                    ->toArray();
            }

            $orders->getCollection()->transform(function ($order) use ($branches) {
                $statusMeta = $this->resolveOrderStatusMeta((int) $order->order_status);
                $paymentMeta = $this->resolvePaymentMethodMeta((int) $order->payment_method);
                $paymentStatusMeta = $this->resolvePaymentStatusMeta((int) $order->payment_status);

                $order->status_label = $statusMeta['label'];
                $order->status_class = $statusMeta['class'];

                $order->payment_method_label = $paymentMeta['label'];
                $order->payment_status_label = $paymentStatusMeta['label'];
                $order->payment_status_class = $paymentStatusMeta['class'];

                $order->receive_type_label = (int) $order->receive_type === 2
                    ? 'Nhận tại nhà thuốc'
                    : 'Giao tận nơi';

                $order->pickup_branch_name = !empty($order->id_branch_pickup)
                    ? ($branches[$order->id_branch_pickup] ?? ('Chi nhánh #' . $order->id_branch_pickup))
                    : null;

                $order->created_at_format = optional($order->created_at)->format('d/m/Y H:i');
                $order->total_amount_format = number_format((float) $order->total_amount, 0, ',', '.') . 'đ';
                $order->subtotal_amount_format = number_format((float) $order->subtotal_amount, 0, ',', '.') . 'đ';

                $order->delivery_address_text = trim(implode(', ', array_filter([
                    $order->address_detail,
                    $order->ward_name,
                    $order->district_name,
                    $order->province_name,
                ])));

                $order->items->transform(function ($item) {
                    $item->image_url = $this->formatImageUrl($item->product_image_snapshot);
                    $item->price_snapshot_format = number_format((float) $item->price_snapshot, 0, ',', '.') . 'đ';
                    $item->line_total_format = number_format((float) $item->line_total, 0, ',', '.') . 'đ';
                    return $item;
                });

                return $order;
            });
        }

        return view('website.my-order-v1.index', compact(
            'guestCheckoutInfo',
            'customerPhone',
            'statusFilter',
            'filterOptions',
            'stats',
            'orders'
        ));
    }

    protected function resolveOrderStatusMeta(int $status): array
    {
        return match ($status) {
            0 => ['label' => 'Mới tạo', 'class' => 'is-new'],
            1 => ['label' => 'Đã xác nhận', 'class' => 'is-confirmed'],
            2 => ['label' => 'Đang xử lý', 'class' => 'is-processing'],
            3 => ['label' => 'Chờ sync', 'class' => 'is-processing'],
            4 => ['label' => 'Đã sync', 'class' => 'is-processing'],
            5 => ['label' => 'Đang giao', 'class' => 'is-shipping'],
            6 => ['label' => 'Hoàn thành', 'class' => 'is-completed'],
            7 => ['label' => 'Đã hủy', 'class' => 'is-cancelled'],
            default => ['label' => 'Đang cập nhật', 'class' => 'is-default'],
        };
    }

    protected function resolvePaymentMethodMeta(int $method): array
    {
        return match ($method) {
            1 => ['label' => 'COD'],
            2 => ['label' => 'Chuyển khoản'],
            3 => ['label' => 'Thanh toán tại quầy'],
            default => ['label' => 'Chưa rõ'],
        };
    }

    protected function resolvePaymentStatusMeta(int $status): array
    {
        return match ($status) {
            0 => ['label' => 'Chưa thanh toán', 'class' => 'is-unpaid'],
            1 => ['label' => 'Đã thanh toán', 'class' => 'is-paid'],
            2 => ['label' => 'Thanh toán một phần', 'class' => 'is-partial'],
            3 => ['label' => 'Đã hoàn tiền', 'class' => 'is-refunded'],
            default => ['label' => 'Đang cập nhật', 'class' => 'is-unpaid'],
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