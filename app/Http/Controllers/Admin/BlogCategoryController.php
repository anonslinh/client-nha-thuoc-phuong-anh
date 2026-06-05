<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    private function uniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = Str::slug($baseSlug);
        if ($slug === '') $slug = 'chuyen-muc';

        $i = 1;
        $check = function ($s) use ($ignoreId) {
            $q = BlogCategory::where('slug', $s);
            if ($ignoreId) $q->where('id', '!=', $ignoreId);
            return $q->exists();
        };

        $final = $slug;
        while ($check($final)) {
            $final = $slug . '-' . $i;
            $i++;
        }
        return $final;
    }

    public function index(Request $request)
    {
        $kw = trim((string)$request->get('kw', ''));
        $status = $request->get('status'); // active|inactive

        $query = BlogCategory::query()->withCount('posts');

        if ($kw !== '') {
            $query->where(function ($q) use ($kw) {
                $q->where('name', 'like', "%{$kw}%")
                  ->orWhere('slug', 'like', "%{$kw}%");
            });
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $listData = $query->orderBy('name')->paginate(12)->appends($request->all());

        return view('admin.blog.categories.index', compact('listData'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:120',
            'slug'   => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name']);

        BlogCategory::create($data);

        return redirect()->back()->with('success', 'Tạo chuyên mục thành công!');
    }

    public function update(Request $request, $id)
    {
        $cat = BlogCategory::findOrFail($id);

        $data = $request->validate([
            'name'   => 'required|string|max:120',
            'slug'   => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name'], (int)$cat->id);

        $cat->update($data);

        return redirect()->back()->with('success', 'Cập nhật chuyên mục thành công!');
    }

    public function toggle($id)
    {
        $cat = BlogCategory::findOrFail($id);
        $cat->status = $cat->status === 'active' ? 'inactive' : 'active';
        $cat->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function delete($id)
    {
        $cat = BlogCategory::withCount('posts')->findOrFail($id);

        if (($cat->posts_count ?? 0) > 0) {
            return redirect()->back()->with('error', 'Không thể xoá: chuyên mục đang có bài viết!');
        }

        $cat->delete();

        return redirect()->back()->with('success', 'Đã xoá chuyên mục!');
    }
}
