<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\CategoryV1;
use App\Models\MainCategoryV1;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MainCategoryV1Controller extends Controller
{
    public function index(Request $request)
    {
        $q = MainCategoryV1::query()
            ->orderBy('sort_order')
            ->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where('name', 'like', "%{$key}%");
        }

        $listData = $q->paginate(20);

        $ids = $listData->pluck('id')->all();
        $countMap = [];
        if (!empty($ids)) {
            $countMap = CategoryV1::query()
                ->selectRaw('id_main_category_v1, COUNT(*) as c')
                ->whereIn('id_main_category_v1', $ids)
                ->groupBy('id_main_category_v1')
                ->pluck('c', 'id_main_category_v1')
                ->toArray();
        }

        return view('admin.catalog_v1.main_categories.index', compact('listData', 'countMap'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sort_order' => 'required|integer',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
        ];

        if ($request->hasFile('img')) {
            $data['img'] = $this->saveUploaded($request->file('img'), 'upload/catalog/main-categories');
        } else {
            $data['img'] = $request->get('img');
        }

        MainCategoryV1::create($data);

        return redirect()->back()->with('success', 'Thêm danh mục cha thành công');
    }

    public function update(Request $request, $id)
    {
        $row = MainCategoryV1::findOrFail($id);

        $request->validate([
            'sort_order' => 'required|integer',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
        ];

        if ($request->hasFile('img')) {
            $data['img'] = $this->saveUploaded($request->file('img'), 'upload/catalog/main-categories');
        } else {
            if ($request->filled('img')) {
                $data['img'] = $request->get('img');
            }
        }

        $row->update($data);

        return redirect()->back()->with('success', 'Cập nhật danh mục cha thành công');
    }

    public function destroy($id)
    {
        CategoryV1::where('id_main_category_v1', $id)->update([
            'id_main_category_v1' => null
        ]);

        MainCategoryV1::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Xóa danh mục cha thành công');
    }

    public function categories(Request $request, $id)
    {
        $mainCategory = MainCategoryV1::findOrFail($id);

        $q = CategoryV1::query()
            ->where('id_main_category_v1', $id)
            ->orderBy('sort_order')
            ->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where('name', 'like', "%{$key}%");
        }

        $listData = $q->paginate(20);

        return view('admin.catalog_v1.main_categories.categories', compact('mainCategory', 'listData'));
    }

    public function attachPage(Request $request, $id)
    {
        $mainCategory = MainCategoryV1::findOrFail($id);

        $q = CategoryV1::query()->orderBy('sort_order')->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where('name', 'like', "%{$key}%");
        }

        $listData = $q->paginate(24);

        $currentIds = CategoryV1::where('id_main_category_v1', $id)->pluck('id')->all();
        $currentMap = array_fill_keys($currentIds, true);

        $allMainCategories = MainCategoryV1::query()
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->get()
            ->keyBy('id');

        return view('admin.catalog_v1.main_categories.attach', compact(
            'mainCategory',
            'listData',
            'currentMap',
            'allMainCategories'
        ));
    }

    public function attachStore(Request $request, $id)
    {
        $mainCategory = MainCategoryV1::findOrFail($id);

        $categoryIds = $request->get('category_ids', []);

        if (!is_array($categoryIds) || count($categoryIds) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất 1 danh mục con.');
        }

        CategoryV1::whereIn('id', $categoryIds)->update([
            'id_main_category_v1' => $mainCategory->id
        ]);

        return redirect()->back()->with('success', 'Đã gán danh mục con vào danh mục cha thành công');
    }

    public function detachCategories(Request $request, $id)
    {
        $mainCategory = MainCategoryV1::findOrFail($id);

        $categoryIds = $request->get('category_ids', []);

        if (!is_array($categoryIds) || count($categoryIds) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất 1 danh mục để gỡ.');
        }

        CategoryV1::where('id_main_category_v1', $mainCategory->id)
            ->whereIn('id', $categoryIds)
            ->update([
                'id_main_category_v1' => null
            ]);

        return redirect()->back()->with('success', 'Đã gỡ danh mục con khỏi danh mục cha');
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