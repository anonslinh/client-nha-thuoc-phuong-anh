<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\ProductV1;
use App\Models\SeasonDiseaseCategoryProductV1;
use App\Models\SeasonDiseaseCategoryV1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeasonDiseaseCategoryV1Controller extends Controller
{
    public function index(Request $request)
    {
        $q = SeasonDiseaseCategoryV1::query()->orderBy('sort_order')->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where('name', 'like', "%{$key}%");
        }

        $listData = $q->paginate(20);

        $ids = $listData->pluck('id')->all();
        $countMap = [];
        if (!empty($ids)) {
            $countMap = SeasonDiseaseCategoryProductV1::query()
                ->selectRaw('category_id, COUNT(*) as c')
                ->whereIn('category_id', $ids)
                ->groupBy('category_id')
                ->pluck('c', 'category_id')
                ->toArray();
        }

        return view('admin.catalog_v1.season_disease_categories.index', compact('listData', 'countMap'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sort_order' => 'required|integer',
        ]);

        $data = $request->only(['name', 'description', 'content', 'sort_order', 'status']);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->saveUploaded($request->file('avatar'), 'upload/catalog/season-disease/avatar');
        } else {
            $data['avatar'] = $request->get('avatar');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->saveUploaded($request->file('banner'), 'upload/catalog/season-disease/banner');
        } else {
            $data['banner'] = $request->get('banner');
        }

        SeasonDiseaseCategoryV1::create($data);

        return redirect()->back()->with('success', 'Thêm hạng mục bệnh theo mùa thành công');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sort_order' => 'required|integer',
        ]);

        $row = SeasonDiseaseCategoryV1::findOrFail($id);

        $data = $request->only(['name', 'description', 'content', 'sort_order', 'status']);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->saveUploaded($request->file('avatar'), 'upload/catalog/season-disease/avatar');
        } else {
            if ($request->filled('avatar')) $data['avatar'] = $request->get('avatar');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->saveUploaded($request->file('banner'), 'upload/catalog/season-disease/banner');
        } else {
            if ($request->filled('banner')) $data['banner'] = $request->get('banner');
        }

        $row->update($data);

        return redirect()->back()->with('success', 'Cập nhật hạng mục bệnh theo mùa thành công');
    }

    public function destroy($id)
    {
        SeasonDiseaseCategoryProductV1::where('category_id', $id)->delete();
        SeasonDiseaseCategoryV1::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Xóa hạng mục bệnh theo mùa thành công');
    }

    public function products(Request $request, $id)
    {
        $category = SeasonDiseaseCategoryV1::findOrFail($id);

        $maps = SeasonDiseaseCategoryProductV1::query()
            ->where('category_id', $id)
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->paginate(20);

        $productIds = $maps->pluck('product_id')->all();
        $productsMap = [];
        if (!empty($productIds)) {
            $productsMap = ProductV1::whereIn('id', $productIds)->get()->keyBy('id');
        }

        return view('admin.catalog_v1.season_disease_categories.products', compact(
            'category', 'maps', 'productsMap'
        ));
    }

    public function attachPage(Request $request, $id)
    {
        $category = SeasonDiseaseCategoryV1::findOrFail($id);

        $q = ProductV1::query()->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where(function ($qq) use ($key) {
                $qq->where('name', 'like', "%{$key}%")
                    ->orWhere('full_name', 'like', "%{$key}%")
                    ->orWhere('code_product_kiovet', 'like', "%{$key}%");
            });
        }

        $listData = $q->paginate(24);

        $exists = SeasonDiseaseCategoryProductV1::where('category_id', $id)->pluck('product_id')->all();
        $existMap = array_fill_keys($exists, true);

        return view('admin.catalog_v1.season_disease_categories.attach', compact(
            'category', 'listData', 'existMap'
        ));
    }

    public function attachStore(Request $request, $id)
    {
        $category = SeasonDiseaseCategoryV1::findOrFail($id);

        $productIds = $request->get('product_ids', []);
        $items = $request->get('items', []); // items[product_id][sale_price|unit|sort_order]

        if (!is_array($productIds) || count($productIds) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm.');
        }

        $created = 0;
        $updated = 0;

        foreach ($productIds as $pid) {
            $pid = (int)$pid;

            $salePrice = $items[$pid]['sale_price'] ?? null;
            $unit = $items[$pid]['unit'] ?? null;
            $sort = $items[$pid]['sort_order'] ?? 0;

            $row = SeasonDiseaseCategoryProductV1::where('category_id', $id)->where('product_id', $pid)->first();

            if ($row) {
                $row->update([
                    'sale_price' => $salePrice,
                    'unit' => $unit,
                    'sort_order' => (int)$sort,
                    'status' => 1,
                ]);
                $updated++;
            } else {
                SeasonDiseaseCategoryProductV1::create([
                    'category_id' => $id,
                    'product_id' => $pid,
                    'sale_price' => $salePrice,
                    'unit' => $unit,
                    'sort_order' => (int)$sort,
                    'status' => 1,
                ]);
                $created++;
            }
        }

        return redirect()->back()->with('success', "Đã thêm {$created} sản phẩm, cập nhật {$updated} sản phẩm vào hạng mục.");
    }

    public function updateProductItem(Request $request, $id, $map_id)
    {
        $row = SeasonDiseaseCategoryProductV1::where('category_id', $id)->where('id', $map_id)->firstOrFail();

        $row->update([
            'sale_price' => $request->sale_price,
            'unit' => $request->unit,
            'sort_order' => (int)($request->sort_order ?? 0),
            'status' => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Cập nhật sản phẩm hạng mục thành công');
    }

    public function destroyProductItem($id, $map_id)
    {
        SeasonDiseaseCategoryProductV1::where('category_id', $id)->where('id', $map_id)->delete();
        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi hạng mục');
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