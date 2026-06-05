<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\PrescriptionRequestV1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PrescriptionRequestV1Controller extends Controller
{
    public function index(Request $request)
    {
        $query = PrescriptionRequestV1::query()
            ->leftJoin('branches', 'branches.id', '=', 'prescription_requests_v1.branch_id')
            ->select([
                'prescription_requests_v1.*',
                'branches.branch_name as branch_name',
            ]);

        if ($request->filled('keyword')) {
            $keyword = trim((string) $request->keyword);

            $query->where(function ($q) use ($keyword) {
                $q->where('prescription_requests_v1.request_code', 'like', '%' . $keyword . '%')
                    ->orWhere('prescription_requests_v1.customer_name', 'like', '%' . $keyword . '%')
                    ->orWhere('prescription_requests_v1.customer_phone', 'like', '%' . $keyword . '%')
                    ->orWhere('prescription_requests_v1.prescription_content', 'like', '%' . $keyword . '%')
                    ->orWhere('prescription_requests_v1.note', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('prescription_requests_v1.status', (int) $request->status);
        }

        if ($request->filled('branch_id')) {
            $query->where('prescription_requests_v1.branch_id', (int) $request->branch_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('prescription_requests_v1.created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('prescription_requests_v1.created_at', '<=', $request->date_to);
        }

        $requests = $query
            ->orderByDesc('prescription_requests_v1.id')
            ->paginate(20)
            ->withQueryString();

        $requests->getCollection()->transform(function ($item) {
            $statusMeta = $this->getStatusMeta((int) $item->status);

            $item->status_label = $statusMeta['label'];
            $item->status_class = $statusMeta['class'];
            $item->image_url = $this->formatImageUrl($item->prescription_image);
            $item->created_at_format = optional($item->created_at)->format('d/m/Y H:i');
            $item->confirmed_at_format = optional($item->confirmed_at)->format('d/m/Y H:i');
            $item->processed_at_format = optional($item->processed_at)->format('d/m/Y H:i');

            return $item;
        });

        $summary = [
            'total' => PrescriptionRequestV1::query()->count(),
            'pending' => PrescriptionRequestV1::query()->where('status', 0)->count(),
            'confirmed' => PrescriptionRequestV1::query()->where('status', 1)->count(),
            'processed' => PrescriptionRequestV1::query()->where('status', 2)->count(),
        ];

        $branches = DB::table('branches')
            ->select('id', 'branch_name')
            ->where(function ($q) {
                $q->whereNull('is_active')->orWhere('is_active', 1);
            })
            ->orderBy('branch_name', 'asc')
            ->get();

        $statusOptions = $this->getStatusOptions();

        return view('admin.catalog_v1.prescription_request_v1.index', compact(
            'requests',
            'summary',
            'branches',
            'statusOptions'
        ));
    }

    public function show($id)
    {
        $requestItem = PrescriptionRequestV1::query()
            ->leftJoin('branches', 'branches.id', '=', 'prescription_requests_v1.branch_id')
            ->select([
                'prescription_requests_v1.*',
                'branches.branch_name as branch_name',
            ])
            ->where('prescription_requests_v1.id', $id)
            ->firstOrFail();

        $statusMeta = $this->getStatusMeta((int) $requestItem->status);

        $requestItem->status_label = $statusMeta['label'];
        $requestItem->status_class = $statusMeta['class'];
        $requestItem->image_url = $this->formatImageUrl($requestItem->prescription_image);
        $requestItem->created_at_format = optional($requestItem->created_at)->format('d/m/Y H:i');
        $requestItem->updated_at_format = optional($requestItem->updated_at)->format('d/m/Y H:i');
        $requestItem->confirmed_at_format = optional($requestItem->confirmed_at)->format('d/m/Y H:i');
        $requestItem->processed_at_format = optional($requestItem->processed_at)->format('d/m/Y H:i');

        $branches = DB::table('branches')
            ->select('id', 'branch_name')
            ->where(function ($q) {
                $q->whereNull('is_active')->orWhere('is_active', 1);
            })
            ->orderBy('branch_name', 'asc')
            ->get();

        $statusOptions = $this->getStatusOptions();

        return view('admin.catalog_v1.prescription_request_v1.show', compact(
            'requestItem',
            'branches',
            'statusOptions'
        ));
    }

    public function update(Request $request, $id)
    {
        $requestItem = PrescriptionRequestV1::query()->findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys($this->getStatusOptions()))],
            'branch_id' => ['nullable', 'integer'],
            'created_order_id' => ['nullable', 'integer'],
            'admin_note' => ['nullable', 'string'],
            'pharmacist_response' => ['nullable', 'string'],
        ], [
            'status.required' => 'Vui lòng chọn trạng thái xử lý.',
        ]);

        DB::beginTransaction();

        try {
            $oldStatus = (int) $requestItem->status;
            $newStatus = (int) $validated['status'];

            $dataUpdate = [
                'status' => $newStatus,
                'branch_id' => !empty($validated['branch_id']) ? (int) $validated['branch_id'] : null,
                'created_order_id' => !empty($validated['created_order_id']) ? (int) $validated['created_order_id'] : null,
                'admin_note' => $validated['admin_note'] ?? null,
                'pharmacist_response' => $validated['pharmacist_response'] ?? null,
                'assigned_user_id' => auth()->id(),
            ];

            if ($newStatus === 1 && empty($requestItem->confirmed_at)) {
                $dataUpdate['confirmed_at'] = now();
            }

            if ($newStatus === 2 && empty($requestItem->processed_at)) {
                $dataUpdate['processed_at'] = now();

                if (empty($requestItem->confirmed_at)) {
                    $dataUpdate['confirmed_at'] = now();
                }
            }

            if ($newStatus === 0) {
                $dataUpdate['confirmed_at'] = null;
                $dataUpdate['processed_at'] = null;
            }

            $requestItem->update($dataUpdate);

            DB::commit();

            return redirect()
                ->route('prescription_request_v1.show', $requestItem->id)
                ->with('success', 'Cập nhật yêu cầu mua thuốc thành công.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Không thể cập nhật yêu cầu. ' . $e->getMessage());
        }
    }

    protected function getStatusOptions(): array
    {
        return [
            0 => 'Chưa xác nhận',
            1 => 'Đã xác nhận',
            2 => 'Đã xử lý',
        ];
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

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        return asset(ltrim($path, '/'));
    }
}