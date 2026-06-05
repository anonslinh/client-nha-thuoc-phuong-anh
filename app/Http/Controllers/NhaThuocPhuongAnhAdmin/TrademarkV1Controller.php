<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\ProductV1;
use App\Models\TrademarkV1;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrademarkV1Controller extends Controller
{
    public function index(Request $request)
    {
        $q = TrademarkV1::query()->orderBy('sort_order');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where('name', 'like', "%{$key}%");
        }

        // count sản phẩm theo thương hiệu
        $q->select('trademark_v1.*')
          ->selectSub(
              ProductV1::selectRaw('COUNT(*)')
                  ->whereColumn('product_v1.id_trade_mark', 'trademark_v1.id'),
              'products_count'
          );

        $listData = $q->paginate(20);

        return view('admin.catalog_v1.trademarks.index', compact('listData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sort_order' => 'required|integer',
        ]);

        $data = $request->only(['name', 'description', 'note', 'sort_order', 'status']);

        // logo
        if ($request->hasFile('img')) {
            $data['img'] = $this->saveUploaded($request->file('img'), 'upload/catalog/trademarks');
        } else {
            $data['img'] = $request->get('img');
        }

        // banner
        if ($request->hasFile('banner')) {
            $data['banner'] = $this->saveUploaded($request->file('banner'), 'upload/catalog/trademarks/banner');
        } else {
            $data['banner'] = $request->get('banner');
        }

        TrademarkV1::create($data);

        return redirect()->back()->with('success', 'Thêm thương hiệu thành công');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sort_order' => 'required|integer',
        ]);

        $tm = TrademarkV1::findOrFail($id);

        $data = $request->only(['name', 'description', 'note', 'sort_order', 'status']);

        if ($request->hasFile('img')) {
            $data['img'] = $this->saveUploaded($request->file('img'), 'upload/catalog/trademarks');
        } else {
            if ($request->filled('img')) $data['img'] = $request->get('img');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->saveUploaded($request->file('banner'), 'upload/catalog/trademarks/banner');
        } else {
            if ($request->filled('banner')) $data['banner'] = $request->get('banner');
        }

        $tm->update($data);

        return redirect()->back()->with('success', 'Cập nhật thương hiệu thành công');
    }

    public function destroy($id)
    {
        ProductV1::where('id_trade_mark', $id)->update(['id_trade_mark' => null]);
        TrademarkV1::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Xóa thương hiệu thành công');
    }

    public function products(Request $request, $id)
    {
        $trademark = TrademarkV1::findOrFail($id);

        $q = ProductV1::query()->where('id_trade_mark', $id)->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where(function ($qq) use ($key) {
                $qq->where('name', 'like', "%{$key}%")
                   ->orWhere('full_name', 'like', "%{$key}%")
                   ->orWhere('code_product_kiovet', 'like', "%{$key}%");
            });
        }

        $listData = $q->paginate(20);

        return view('admin.catalog_v1.trademarks.products', compact('trademark', 'listData'));
    }

    public function attachPage(Request $request, $id)
    {
        $trademark = TrademarkV1::findOrFail($id);

        $q = ProductV1::query()
            ->where(function ($qq) use ($id) {
                $qq->whereNull('id_trade_mark')->orWhere('id_trade_mark', '!=', $id);
            })
            ->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where(function ($qq) use ($key) {
                $qq->where('name', 'like', "%{$key}%")
                   ->orWhere('full_name', 'like', "%{$key}%")
                   ->orWhere('code_product_kiovet', 'like', "%{$key}%");
            });
        }

        $listData = $q->paginate(50);

        return view('admin.catalog_v1.trademarks.attach', compact('trademark', 'listData'));
    }

    public function attachProducts(Request $request, $id)
    {
        $ids = $request->get('product_ids', []);
        if (!is_array($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm.');
        }

        ProductV1::whereIn('id', $ids)->update(['id_trade_mark' => $id]);

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào thương hiệu');
    }

    public function detachProducts(Request $request, $id)
    {
        $ids = $request->get('product_ids', []);
        if (!is_array($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm.');
        }

        ProductV1::where('id_trade_mark', $id)->whereIn('id', $ids)->update(['id_trade_mark' => null]);

        return redirect()->back()->with('success', 'Đã gỡ sản phẩm khỏi thương hiệu');
    }

    private function saveUploaded($file, $folder)
    {
        $folderPath = public_path($folder);
        if (!is_dir($folderPath)) @mkdir($folderPath, 0777, true);

        $name = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move($folderPath, $name);

        return $folder . '/' . $name;
    }
}