<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCodeV1;
use Illuminate\Http\Request;

class DiscountCodeV1Controller extends Controller
{
    public function index(Request $request)
    {
        $q = DiscountCodeV1::query()->orderBy('id', 'desc');

        if ($request->filled('type')) {
            $q->where('type', (int) $request->type);
        }

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where(function ($qq) use ($key) {
                $qq->where('code', 'like', "%{$key}%")
                    ->orWhere('title', 'like', "%{$key}%");
            });
        }

        $listData = $q->paginate(20)->withQueryString();

        return view('admin.catalog_v1.discount_codes.index', compact('listData'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        DiscountCodeV1::create($data);

        return redirect()->back()->with('success', 'Thêm mã giảm giá thành công');
    }

    public function update(Request $request, $id)
    {
        $row = DiscountCodeV1::findOrFail($id);

        $data = $this->validateData($request, $row->id);

        $row->update($data);

        return redirect()->back()->with('success', 'Cập nhật mã giảm giá thành công');
    }

    public function destroy($id)
    {
        DiscountCodeV1::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Xóa mã giảm giá thành công');
    }

    private function validateData(Request $request, $ignoreId = null): array
    {
        $validated = $request->validate([
            'type' => ['required', 'in:1,2'],
            'code' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:discount_codes_v1,code' . ($ignoreId ? ",{$ignoreId}" : '')],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'discount_type' => ['required', 'in:1,2'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'max_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['nullable', 'integer', 'min:1'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
        ], [
            'code.required' => 'Vui lòng nhập mã.',
            'code.unique' => 'Mã này đã tồn tại.',
            'code.alpha_dash' => 'Mã chỉ gồm chữ, số, gạch ngang/gạch dưới, không dấu cách.',
            'title.required' => 'Vui lòng nhập tên hiển thị.',
            'discount_value.required' => 'Vui lòng nhập giá trị giảm.',
        ]);

        return [
            'type' => (int) $validated['type'],
            'code' => strtoupper(trim($validated['code'])),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'discount_type' => (int) $validated['discount_type'],
            'discount_value' => $validated['discount_value'],
            'max_discount_amount' => $request->filled('max_discount_amount') ? $validated['max_discount_amount'] : null,
            'min_order_amount' => $validated['min_order_amount'] ?? 0,
            'quantity' => $request->filled('quantity') ? $validated['quantity'] : null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'is_active' => $request->boolean('is_active', true) ? 1 : 0,
        ];
    }
}
