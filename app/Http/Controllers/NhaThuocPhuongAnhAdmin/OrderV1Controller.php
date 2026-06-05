<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\OrderStatusLogV1;
use App\Models\OrderV1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderV1Controller extends Controller
{
    public function index(Request $request)
    {
        $query = OrderV1::query()
            ->leftJoin('branches as pickup_branch', 'pickup_branch.id', '=', 'order_v1.id_branch_pickup')
            ->leftJoin('branches as process_branch', 'process_branch.id', '=', 'order_v1.id_branch_process')
            ->select([
                'order_v1.*',
                'pickup_branch.branch_name as pickup_branch_name',
                'process_branch.branch_name as process_branch_name',
            ])
            ->withCount(['items as total_items']);

        if ($request->filled('keyword')) {
            $keyword = trim((string) $request->keyword);

            $query->where(function ($q) use ($keyword) {
                $q->where('order_v1.order_code', 'like', '%' . $keyword . '%')
                    ->orWhere('order_v1.customer_name', 'like', '%' . $keyword . '%')
                    ->orWhere('order_v1.customer_phone', 'like', '%' . $keyword . '%')
                    ->orWhere('order_v1.customer_email', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('order_status')) {
            $query->where('order_v1.order_status', (int) $request->order_status);
        }

        if ($request->filled('sync_kiotviet_status')) {
            $query->where('order_v1.sync_kiotviet_status', (int) $request->sync_kiotviet_status);
        }

        if ($request->filled('payment_method')) {
            $query->where('order_v1.payment_method', (int) $request->payment_method);
        }

        if ($request->filled('payment_status')) {
            $query->where('order_v1.payment_status', (int) $request->payment_status);
        }

        if ($request->filled('receive_type')) {
            $query->where('order_v1.receive_type', (int) $request->receive_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('order_v1.created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('order_v1.created_at', '<=', $request->date_to);
        }

        $orders = $query
            ->orderByDesc('order_v1.id')
            ->paginate(20)
            ->withQueryString();

        $orders->getCollection()->transform(function ($order) {
            $statusMeta = $this->getOrderStatusMeta((int) $order->order_status);
            $syncMeta = $this->getSyncStatusMeta((int) $order->sync_kiotviet_status);
            $paymentStatusMeta = $this->getPaymentStatusMeta((int) $order->payment_status);

            $order->order_status_label = $statusMeta['label'];
            $order->order_status_class = $statusMeta['class'];

            $order->sync_status_label = $syncMeta['label'];
            $order->sync_status_class = $syncMeta['class'];

            $order->payment_status_label = $paymentStatusMeta['label'];
            $order->payment_status_class = $paymentStatusMeta['class'];

            $order->payment_method_label = $this->getPaymentMethodLabel((int) $order->payment_method);
            $order->receive_type_label = $this->getReceiveTypeLabel((int) $order->receive_type);

            $order->total_amount_format = number_format((float) $order->total_amount, 0, ',', '.') . 'đ';
            $order->created_at_format = optional($order->created_at)->format('d/m/Y H:i');

            return $order;
        });

        $summary = [
            'total' => OrderV1::count(),
            'new' => OrderV1::where('order_status', 0)->count(),
            'processing' => OrderV1::whereIn('order_status', [1, 2, 3, 4, 5])->count(),
            'completed' => OrderV1::where('order_status', 6)->count(),
            'sync_error' => OrderV1::where('sync_kiotviet_status', 3)->count(),
        ];

        $filterOptions = [
            'order_statuses' => $this->getOrderStatusOptions(),
            'sync_statuses' => $this->getSyncStatusOptions(),
            'payment_methods' => $this->getPaymentMethodOptions(),
            'payment_statuses' => $this->getPaymentStatusOptions(),
            'receive_types' => $this->getReceiveTypeOptions(),
        ];

        return view('admin.catalog_v1.order_v1.index', compact(
            'orders',
            'summary',
            'filterOptions'
        ));
    }

    public function show($id)
    {
        $order = OrderV1::query()
            ->with([
                'items' => function ($q) {
                    $q->orderBy('id', 'asc');
                },
                'statusLogs' => function ($q) {
                    $q->orderByDesc('id');
                },
                'syncLogs' => function ($q) {
                    $q->orderByDesc('id');
                }
            ])
            ->findOrFail($id);

        $branches = DB::table('branches')
            ->select('id', 'branch_name')
            ->orderBy('branch_name', 'asc')
            ->get();

        $branchMap = $branches->pluck('branch_name', 'id')->toArray();

        $order->order_status_label = $this->getOrderStatusMeta((int) $order->order_status)['label'];
        $order->order_status_class = $this->getOrderStatusMeta((int) $order->order_status)['class'];

        $order->sync_status_label = $this->getSyncStatusMeta((int) $order->sync_kiotviet_status)['label'];
        $order->sync_status_class = $this->getSyncStatusMeta((int) $order->sync_kiotviet_status)['class'];

        $order->payment_status_label = $this->getPaymentStatusMeta((int) $order->payment_status)['label'];
        $order->payment_status_class = $this->getPaymentStatusMeta((int) $order->payment_status)['class'];

        $order->payment_method_label = $this->getPaymentMethodLabel((int) $order->payment_method);
        $order->receive_type_label = $this->getReceiveTypeLabel((int) $order->receive_type);

        $order->pickup_branch_name = !empty($order->id_branch_pickup)
            ? ($branchMap[$order->id_branch_pickup] ?? ('Chi nhánh #' . $order->id_branch_pickup))
            : null;

        $order->process_branch_name = !empty($order->id_branch_process)
            ? ($branchMap[$order->id_branch_process] ?? ('Chi nhánh #' . $order->id_branch_process))
            : null;

        $order->subtotal_amount_format = number_format((float) $order->subtotal_amount, 0, ',', '.') . 'đ';
        $order->discount_amount_format = number_format((float) $order->discount_amount, 0, ',', '.') . 'đ';
        $order->shipping_fee_format = number_format((float) $order->shipping_fee, 0, ',', '.') . 'đ';
        $order->total_amount_format = number_format((float) $order->total_amount, 0, ',', '.') . 'đ';

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

        $order->statusLogs->transform(function ($log) {
            $log->from_status_label = !is_null($log->from_status)
                ? $this->getOrderStatusMeta((int) $log->from_status)['label']
                : 'Khởi tạo';
            $log->to_status_label = $this->getOrderStatusMeta((int) $log->to_status)['label'];
            $log->created_at_format = optional($log->created_at)->format('d/m/Y H:i');
            return $log;
        });

        $order->syncLogs->transform(function ($log) {
            $log->sync_type_label = (int) $log->sync_type === 1 ? 'Sync Order' : 'Sync Invoice';
            $log->status_label = (int) $log->status === 1 ? 'Thành công' : 'Thất bại';
            $log->status_class = (int) $log->status === 1 ? 'is-success' : 'is-danger';
            $log->created_at_format = optional($log->created_at)->format('d/m/Y H:i');
            return $log;
        });

        $formOptions = [
            'order_statuses' => $this->getOrderStatusOptions(),
            'sync_statuses' => $this->getSyncStatusOptions(),
            'payment_statuses' => $this->getPaymentStatusOptions(),
            'branches' => $branches,
        ];

        return view('admin.catalog_v1.order_v1.show', compact(
            'order',
            'formOptions'
        ));
    }

    public function update(Request $request, $id)
    {
        $order = OrderV1::findOrFail($id);

        $validated = $request->validate([
            'order_status' => ['required', Rule::in(array_keys($this->getOrderStatusOptions()))],
            'payment_status' => ['required', Rule::in(array_keys($this->getPaymentStatusOptions()))],
            'sync_kiotviet_status' => ['required', Rule::in(array_keys($this->getSyncStatusOptions()))],
            'requires_consult' => ['required', Rule::in(['0', '1'])],
            'id_branch_process' => ['nullable', 'integer'],
            'admin_note' => ['nullable', 'string'],
            'cancel_reason' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();

        try {
            $oldStatus = (int) $order->order_status;
            $newStatus = (int) $validated['order_status'];

            $dataUpdate = [
                'order_status' => $newStatus,
                'payment_status' => (int) $validated['payment_status'],
                'sync_kiotviet_status' => (int) $validated['sync_kiotviet_status'],
                'requires_consult' => (int) $validated['requires_consult'],
                'id_branch_process' => $validated['id_branch_process'] ?: null,
                'admin_note' => $validated['admin_note'] ?? null,
            ];

            if ($newStatus === 1 && empty($order->confirmed_at)) {
                $dataUpdate['confirmed_at'] = now();
                $dataUpdate['confirmed_by'] = auth()->id();
            }

            if ($newStatus === 7) {
                $dataUpdate['cancelled_at'] = now();
                $dataUpdate['cancelled_by'] = auth()->id();
                $dataUpdate['cancel_reason'] = $validated['cancel_reason'] ?? null;
            }

            $order->update($dataUpdate);

            if ($oldStatus !== $newStatus) {
                OrderStatusLogV1::create([
                    'id_order_v1' => $order->id,
                    'from_status' => $oldStatus,
                    'to_status' => $newStatus,
                    'note' => $validated['admin_note'] ?? null,
                    'changed_by' => auth()->id(),
                    'created_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('catalog_v1.admin.order_v1.show', $order->id)
                ->with('success', 'Cập nhật đơn hàng thành công.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Không thể cập nhật đơn hàng. ' . $e->getMessage());
        }
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

    protected function getOrderStatusOptions(): array
    {
        return [
            0 => 'Mới tạo',
            1 => 'Đã xác nhận',
            2 => 'Đang xử lý',
            3 => 'Chờ sync KiotViet',
            4 => 'Đã sync KiotViet',
            5 => 'Đang giao',
            6 => 'Hoàn thành',
            7 => 'Đã hủy',
        ];
    }

    protected function getSyncStatusOptions(): array
    {
        return [
            0 => 'Chưa sync',
            1 => 'Sẵn sàng sync',
            2 => 'Sync thành công',
            3 => 'Sync lỗi',
        ];
    }

    protected function getPaymentMethodOptions(): array
    {
        return [
            1 => 'COD',
            2 => 'Chuyển khoản',
            3 => 'Thanh toán tại quầy',
        ];
    }

    protected function getPaymentStatusOptions(): array
    {
        return [
            0 => 'Chưa thanh toán',
            1 => 'Đã thanh toán',
            2 => 'Thanh toán một phần',
            3 => 'Đã hoàn tiền',
        ];
    }

    protected function getReceiveTypeOptions(): array
    {
        return [
            1 => 'Giao tận nơi',
            2 => 'Nhận tại nhà thuốc',
        ];
    }

    protected function getOrderStatusMeta(int $status): array
    {
        return match ($status) {
            0 => ['label' => 'Mới tạo', 'class' => 'is-new'],
            1 => ['label' => 'Đã xác nhận', 'class' => 'is-confirmed'],
            2 => ['label' => 'Đang xử lý', 'class' => 'is-processing'],
            3 => ['label' => 'Chờ sync', 'class' => 'is-syncwait'],
            4 => ['label' => 'Đã sync', 'class' => 'is-synced'],
            5 => ['label' => 'Đang giao', 'class' => 'is-shipping'],
            6 => ['label' => 'Hoàn thành', 'class' => 'is-completed'],
            7 => ['label' => 'Đã hủy', 'class' => 'is-cancelled'],
            default => ['label' => 'Đang cập nhật', 'class' => 'is-default'],
        };
    }

    protected function getSyncStatusMeta(int $status): array
    {
        return match ($status) {
            0 => ['label' => 'Chưa sync', 'class' => 'is-default'],
            1 => ['label' => 'Sẵn sàng sync', 'class' => 'is-warning'],
            2 => ['label' => 'Sync thành công', 'class' => 'is-success'],
            3 => ['label' => 'Sync lỗi', 'class' => 'is-danger'],
            default => ['label' => 'Đang cập nhật', 'class' => 'is-default'],
        };
    }

    protected function getPaymentStatusMeta(int $status): array
    {
        return match ($status) {
            0 => ['label' => 'Chưa thanh toán', 'class' => 'is-warning'],
            1 => ['label' => 'Đã thanh toán', 'class' => 'is-success'],
            2 => ['label' => 'Thanh toán một phần', 'class' => 'is-info'],
            3 => ['label' => 'Đã hoàn tiền', 'class' => 'is-default'],
            default => ['label' => 'Đang cập nhật', 'class' => 'is-default'],
        };
    }

    protected function getPaymentMethodLabel(int $method): string
    {
        return $this->getPaymentMethodOptions()[$method] ?? 'Chưa rõ';
    }

    protected function getReceiveTypeLabel(int $type): string
    {
        return $this->getReceiveTypeOptions()[$type] ?? 'Đang cập nhật';
    }
}