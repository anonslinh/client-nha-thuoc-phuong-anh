<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\ProductV1;
use App\Models\TextSeoHeader;
use App\Models\TextSeoHeaderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TextSeoHeaderController extends Controller
{
    public function index(Request $request)
    {
        $q = TextSeoHeader::query()->orderBy('sort_order')->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where(function ($qq) use ($key) {
                $qq->where('seo_title', 'like', "%{$key}%")
                   ->orWhere('seo_description', 'like', "%{$key}%");
            });
        }

        $listData = $q->paginate(12);

        $ids = $listData->pluck('id')->all();
        $countMap = [];
        if (!empty($ids)) {
            $countMap = TextSeoHeaderProduct::query()
                ->selectRaw('header_id, COUNT(*) as c')
                ->whereIn('header_id', $ids)
                ->groupBy('header_id')
                ->pluck('c', 'header_id')
                ->toArray();
        }

        return view('admin.catalog_v1.text_seo_header.index', compact('listData', 'countMap'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'seo_title' => 'required|string|max:255',
            'sort_order' => 'required|integer',
        ]);

        $data = [
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'article_content' => $request->article_content,
            'has_product_list' => $request->has_product_list ?? 0,
            'sort_order' => $request->sort_order ?? 0,
            'see_more_link' => $request->see_more_link,
        ];

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->saveUploaded($request->file('banner'), 'upload/catalog/text-seo-header/banner');
        } else {
            $data['banner'] = $request->get('banner');
        }

        TextSeoHeader::create($data);

        return redirect()->back()->with('success', 'Thêm thông tin nổi bật thành công');
    }

    public function update(Request $request, $id)
    {
        $row = TextSeoHeader::findOrFail($id);

        $request->validate([
            'seo_title' => 'required|string|max:255',
            'sort_order' => 'required|integer',
        ]);

        $data = [
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'article_content' => $request->article_content,
            'has_product_list' => $request->has_product_list ?? 0,
            'sort_order' => $request->sort_order ?? 0,
            'see_more_link' => $request->see_more_link,
        ];

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->saveUploaded($request->file('banner'), 'upload/catalog/text-seo-header/banner');
        } else {
            if ($request->filled('banner')) {
                $data['banner'] = $request->get('banner');
            }
        }

        $row->update($data);

        return redirect()->back()->with('success', 'Cập nhật thông tin nổi bật thành công');
    }

    public function destroy($id)
    {
        TextSeoHeaderProduct::where('header_id', $id)->delete();
        TextSeoHeader::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Xóa thông tin nổi bật thành công');
    }

    public function show($id)
    {
        $item = TextSeoHeader::findOrFail($id);

        $maps = TextSeoHeaderProduct::where('header_id', $id)
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->get();

        $productIds = $maps->pluck('product_id')->all();
        $productsMap = [];
        if (!empty($productIds)) {
            $productsMap = ProductV1::whereIn('id', $productIds)->get()->keyBy('id');
        }

        return view('admin.catalog_v1.text_seo_header.show', compact('item', 'maps', 'productsMap'));
    }

    public function products($id)
    {
        $item = TextSeoHeader::findOrFail($id);

        $maps = TextSeoHeaderProduct::where('header_id', $id)
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->paginate(20);

        $productIds = $maps->pluck('product_id')->all();
        $productsMap = [];
        if (!empty($productIds)) {
            $productsMap = ProductV1::whereIn('id', $productIds)->get()->keyBy('id');
        }

        return view('admin.catalog_v1.text_seo_header.products', compact('item', 'maps', 'productsMap'));
    }

    public function attachPage(Request $request, $id)
    {
        $item = TextSeoHeader::findOrFail($id);

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

        $exists = TextSeoHeaderProduct::where('header_id', $id)->pluck('product_id')->all();
        $existMap = array_fill_keys($exists, true);

        return view('admin.catalog_v1.text_seo_header.attach', compact('item', 'listData', 'existMap'));
    }

    public function attachStore(Request $request, $id)
    {
        $item = TextSeoHeader::findOrFail($id);

        $productIds = $request->get('product_ids', []);
        $items = $request->get('items', []);

        if (!is_array($productIds) || count($productIds) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm.');
        }

        $created = 0;
        $updated = 0;

        foreach ($productIds as $pid) {
            $pid = (int)$pid;
            $sort = $items[$pid]['sort_order'] ?? 0;

            $row = TextSeoHeaderProduct::where('header_id', $id)->where('product_id', $pid)->first();

            if ($row) {
                $row->update([
                    'sort_order' => (int)$sort,
                    'status' => 1,
                ]);
                $updated++;
            } else {
                TextSeoHeaderProduct::create([
                    'header_id' => $id,
                    'product_id' => $pid,
                    'sort_order' => (int)$sort,
                    'status' => 1,
                ]);
                $created++;
            }
        }

        return redirect()->back()->with('success', "Đã thêm {$created} sản phẩm, cập nhật {$updated} sản phẩm.");
    }

    public function detachProducts(Request $request, $id)
    {
        $mapIds = $request->get('map_ids', []);

        if (!is_array($mapIds) || count($mapIds) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm để gỡ.');
        }

        TextSeoHeaderProduct::where('header_id', $id)->whereIn('id', $mapIds)->delete();

        return redirect()->back()->with('success', 'Đã gỡ sản phẩm khỏi thông tin nổi bật');
    }

    public function updateProductItem(Request $request, $id, $map_id)
    {
        $row = TextSeoHeaderProduct::where('header_id', $id)->where('id', $map_id)->firstOrFail();

        $row->update([
            'sort_order' => (int)($request->sort_order ?? 0),
            'status' => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Cập nhật sản phẩm thành công');
    }

    private function saveUploaded($file, $folder)
    {
        $folderPath = public_path($folder);

        if (!is_dir($folderPath)) {
            if (!mkdir($folderPath, 0775, true) && !is_dir($folderPath)) {
                throw new \Exception('Không tạo được thư mục: ' . $folderPath);
            }
        }

        if (!is_writable($folderPath)) {
            throw new \Exception('Thư mục không có quyền ghi: ' . $folderPath);
        }

        $name = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move($folderPath, $name);

        return $folder . '/' . $name;
    }
}