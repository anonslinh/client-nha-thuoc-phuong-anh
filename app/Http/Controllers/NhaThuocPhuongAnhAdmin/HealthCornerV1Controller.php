<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\HealthArticleCategoryV1;
use App\Models\HealthArticleV1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HealthCornerV1Controller extends Controller
{
    public function showArticle($category_id, $id)
    {
        $category = HealthArticleCategoryV1::findOrFail($category_id);

        $article = HealthArticleV1::where('id_category', $category_id)
            ->where('id', $id)
            ->firstOrFail();

        return view('admin.catalog_v1.health_corner.article_preview', compact('category', 'article'));
    }
    // ================== CATEGORY ==================

    public function categories(Request $request)
    {
        $q = HealthArticleCategoryV1::query()->orderBy('sort_order')->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where('name', 'like', "%{$key}%");
        }

        $listData = $q->paginate(20);

        $ids = $listData->pluck('id')->all();
        $countMap = [];
        if (!empty($ids)) {
            $countMap = HealthArticleV1::query()
                ->selectRaw('id_category, COUNT(*) as c')
                ->whereIn('id_category', $ids)
                ->groupBy('id_category')
                ->pluck('c', 'id_category')
                ->toArray();
        }

        return view('admin.catalog_v1.health_corner.categories', compact('listData', 'countMap'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'required|integer',
        ]);

        HealthArticleCategoryV1::create([
            'name' => $request->name,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Thêm danh mục bài viết thành công');
    }

    public function updateCategory(Request $request, $id)
    {
        $row = HealthArticleCategoryV1::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'required|integer',
        ]);

        $row->update([
            'name' => $request->name,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Cập nhật danh mục bài viết thành công');
    }

    public function destroyCategory($id)
    {
        HealthArticleV1::where('id_category', $id)->delete();
        HealthArticleCategoryV1::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Xóa danh mục bài viết thành công');
    }

    // ================== ARTICLES ==================

    public function articles(Request $request, $category_id)
    {
        $category = HealthArticleCategoryV1::findOrFail($category_id);

        $q = HealthArticleV1::query()
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

        return view('admin.catalog_v1.health_corner.articles', compact('category', 'listData'));
    }

    public function storeArticle(Request $request, $category_id)
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
            $data['avatar'] = $this->saveUploaded($request->file('avatar'), 'upload/catalog/health-corner/avatar');
        } else {
            $data['avatar'] = $request->get('avatar');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->saveUploaded($request->file('banner'), 'upload/catalog/health-corner/banner');
        } else {
            $data['banner'] = $request->get('banner');
        }

        HealthArticleV1::create($data);

        return redirect()->back()->with('success', 'Thêm bài viết thành công');
    }

    public function updateArticle(Request $request, $category_id, $id)
    {
        $row = HealthArticleV1::where('id_category', $category_id)->findOrFail($id);

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
            $data['avatar'] = $this->saveUploaded($request->file('avatar'), 'upload/catalog/health-corner/avatar');
        } else {
            if ($request->filled('avatar')) $data['avatar'] = $request->get('avatar');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->saveUploaded($request->file('banner'), 'upload/catalog/health-corner/banner');
        } else {
            if ($request->filled('banner')) $data['banner'] = $request->get('banner');
        }

        $row->update($data);

        return redirect()->back()->with('success', 'Cập nhật bài viết thành công');
    }

    public function destroyArticle($category_id, $id)
    {
        HealthArticleV1::where('id_category', $category_id)->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Xóa bài viết thành công');
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