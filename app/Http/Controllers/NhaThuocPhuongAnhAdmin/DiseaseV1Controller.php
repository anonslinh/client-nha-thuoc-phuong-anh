<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\DiseaseCategoryV1;
use App\Models\DiseaseV1;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiseaseV1Controller extends Controller
{
    // ================= CATEGORY =================

    public function categories(Request $request)
    {
        $q = DiseaseCategoryV1::query()->orderBy('type')->orderBy('sort_order')->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where('name', 'like', "%{$key}%");
        }

        if ($request->filled('type')) {
            $q->where('type', $request->type);
        }

        $listData = $q->paginate(20);

        $ids = $listData->pluck('id')->all();
        $countMap = [];
        if (!empty($ids)) {
            $countMap = DiseaseV1::query()
                ->selectRaw('id_category, COUNT(*) as c')
                ->whereIn('id_category', $ids)
                ->groupBy('id_category')
                ->pluck('c', 'id_category')
                ->toArray();
        }

        return view('admin.catalog_v1.diseases.categories', compact('listData', 'countMap'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'type' => 'required|in:1,2',
        ]);

        $data = [
            'name' => $request->name,
            'short_description' => $request->short_description,
            'type' => $request->type,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->saveUploaded($request->file('avatar'), 'upload/catalog/diseases/avatar');
        } else {
            $data['avatar'] = $request->get('avatar');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->saveUploaded($request->file('banner'), 'upload/catalog/diseases/banner');
        } else {
            $data['banner'] = $request->get('banner');
        }

        DiseaseCategoryV1::create($data);

        return redirect()->back()->with('success', 'Thêm hạng mục bệnh thành công');
    }

    public function updateCategory(Request $request, $id)
    {
        $row = DiseaseCategoryV1::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'type' => 'required|in:1,2',
        ]);

        $data = [
            'name' => $request->name,
            'short_description' => $request->short_description,
            'type' => $request->type,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->saveUploaded($request->file('avatar'), 'upload/catalog/diseases/avatar');
        } else {
            if ($request->filled('avatar')) $data['avatar'] = $request->get('avatar');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->saveUploaded($request->file('banner'), 'upload/catalog/diseases/banner');
        } else {
            if ($request->filled('banner')) $data['banner'] = $request->get('banner');
        }

        $row->update($data);

        return redirect()->back()->with('success', 'Cập nhật hạng mục bệnh thành công');
    }

    public function destroyCategory($id)
    {
        DiseaseV1::where('id_category', $id)->delete();
        DiseaseCategoryV1::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Xóa hạng mục bệnh thành công');
    }

    // ================= ITEMS =================

    public function items(Request $request, $category_id)
    {
        $category = DiseaseCategoryV1::findOrFail($category_id);

        $q = DiseaseV1::query()
            ->where('id_category', $category_id)
            ->orderByDesc('posted_at')
            ->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where(function ($qq) use ($key) {
                $qq->where('title', 'like', "%{$key}%")
                   ->orWhere('short_description', 'like', "%{$key}%");
            });
        }

        $listData = $q->paginate(15);

        return view('admin.catalog_v1.diseases.items', compact('category', 'listData'));
    }

    public function storeItem(Request $request, $category_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $data = [
            'id_category' => $category_id,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'content' => $request->content,
            'status' => $request->status ?? 1,
            'posted_at' => $request->posted_at ?: now(),
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->saveUploaded($request->file('avatar'), 'upload/catalog/diseases/item-avatar');
        } else {
            $data['avatar'] = $request->get('avatar');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->saveUploaded($request->file('banner'), 'upload/catalog/diseases/item-banner');
        } else {
            $data['banner'] = $request->get('banner');
        }

        DiseaseV1::create($data);

        return redirect()->back()->with('success', 'Thêm bệnh thành công');
    }

    public function updateItem(Request $request, $category_id, $id)
    {
        $row = DiseaseV1::where('id_category', $category_id)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $data = [
            'title' => $request->title,
            'short_description' => $request->short_description,
            'content' => $request->content,
            'status' => $request->status ?? 1,
            'posted_at' => $request->posted_at ?: now(),
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->saveUploaded($request->file('avatar'), 'upload/catalog/diseases/item-avatar');
        } else {
            if ($request->filled('avatar')) $data['avatar'] = $request->get('avatar');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->saveUploaded($request->file('banner'), 'upload/catalog/diseases/item-banner');
        } else {
            if ($request->filled('banner')) $data['banner'] = $request->get('banner');
        }

        $row->update($data);

        return redirect()->back()->with('success', 'Cập nhật bệnh thành công');
    }

    public function destroyItem($category_id, $id)
    {
        DiseaseV1::where('id_category', $category_id)->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Xóa bệnh thành công');
    }

    public function showItem($category_id, $id)
    {
        $category = DiseaseCategoryV1::findOrFail($category_id);

        $item = DiseaseV1::where('id_category', $category_id)
            ->where('id', $id)
            ->firstOrFail();

        return view('admin.catalog_v1.diseases.item_preview', compact('category', 'item'));
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