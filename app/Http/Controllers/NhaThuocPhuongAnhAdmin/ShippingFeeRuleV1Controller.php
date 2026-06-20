<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\ShippingFeeRuleV1;
use Illuminate\Http\Request;

class ShippingFeeRuleV1Controller extends Controller
{
    public function index(Request $request)
    {
        $listData = ShippingFeeRuleV1::query()
            ->orderBy('min_amount')
            ->orderBy('sort_order')
            ->get();

        return view('admin.catalog_v1.shipping_fee_rules.index', compact('listData'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        ShippingFeeRuleV1::create($data);

        return redirect()->back()->with('success', 'Thêm khoảng phí ship thành công');
    }

    public function update(Request $request, $id)
    {
        $row = ShippingFeeRuleV1::findOrFail($id);

        $data = $this->validateData($request);

        $row->update($data);

        return redirect()->back()->with('success', 'Cập nhật khoảng phí ship thành công');
    }

    public function destroy($id)
    {
        ShippingFeeRuleV1::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Xóa khoảng phí ship thành công');
    }

    private function validateData(Request $request): array
    {
        $validated = $request->validate([
            'min_amount' => ['required', 'numeric', 'min:0'],
            'max_amount' => ['nullable', 'numeric', 'gt:min_amount'],
            'fee' => ['required', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer'],
        ], [
            'min_amount.required' => 'Vui lòng nhập giá trị đơn hàng tối thiểu.',
            'max_amount.gt' => 'Giá trị tối đa phải lớn hơn giá trị tối thiểu.',
            'fee.required' => 'Vui lòng nhập phí ship (nhập 0 nếu miễn phí).',
        ]);

        return [
            'min_amount' => $validated['min_amount'],
            'max_amount' => $request->filled('max_amount') ? $validated['max_amount'] : null,
            'fee' => $validated['fee'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true) ? 1 : 0,
        ];
    }
}
