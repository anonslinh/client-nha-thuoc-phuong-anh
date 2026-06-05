<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\BlogPost;
use App\Models\BlogCategory;

class BlogPostController extends Controller
{
    private function uniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = Str::slug($baseSlug);
        if ($slug === '') $slug = 'bai-viet';

        $i = 1;
        $check = function ($s) use ($ignoreId) {
            $q = BlogPost::where('slug', $s);
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
        $status = $request->get('status'); // draft|published|archived
        $category = $request->get('category'); // id hoặc slug

        $query = BlogPost::query()->with('category');

        if ($kw !== '') {
            $query->where(function ($q) use ($kw) {
                $q->where('title', 'like', "%{$kw}%")
                  ->orWhere('slug', 'like', "%{$kw}%")
                  ->orWhere('excerpt', 'like', "%{$kw}%");
            });
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        if (!empty($category)) {
            if (is_numeric($category)) {
                $query->where('category_id', (int)$category);
            } else {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            }
        }

        $listData = $query
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(12)
            ->appends($request->all());

        $categories = BlogCategory::query()
            ->orderBy('name')
            ->get();

        return view('admin.blog.posts.index', compact('listData', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255',
            'category_id'      => 'nullable|integer|exists:blog_categories,id',
            'status'           => 'required|in:draft,published,archived',
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'thumbnail_url'    => 'nullable|string|max:500',
            'image_url'        => 'nullable|string|max:500',
            'seo_title'        => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
            'author_name'      => 'nullable|string|max:120',
            'published_at'     => 'nullable|date',
        ]);

        $slugBase = $data['slug'] ?? $data['title'];
        $data['slug'] = $this->uniqueSlug($slugBase);

        // published_at: nếu chọn published mà chưa set -> now
        if (($data['status'] ?? 'draft') === 'published') {
            if (empty($data['published_at'])) {
                $data['published_at'] = Carbon::now();
            }
        } else {
            // draft/archived thì cho phép null
            if (empty($data['published_at'])) $data['published_at'] = null;
        }

        BlogPost::create($data);

        return redirect()->back()->with('success', 'Tạo bài viết thành công!');
    }

    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255',
            'category_id'      => 'nullable|integer|exists:blog_categories,id',
            'status'           => 'required|in:draft,published,archived',
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'thumbnail_url'    => 'nullable|string|max:500',
            'image_url'        => 'nullable|string|max:500',
            'seo_title'        => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
            'author_name'      => 'nullable|string|max:120',
            'published_at'     => 'nullable|date',
        ]);

        $slugBase = $data['slug'] ?? $data['title'];
        $data['slug'] = $this->uniqueSlug($slugBase, (int)$post->id);

        if (($data['status'] ?? 'draft') === 'published') {
            if (empty($data['published_at'])) {
                $data['published_at'] = $post->published_at ?? Carbon::now();
            }
        } else {
            if (empty($data['published_at'])) $data['published_at'] = null;
        }

        $post->update($data);

        return redirect()->back()->with('success', 'Cập nhật bài viết thành công!');
    }

    public function toggle($id)
    {
        $post = BlogPost::findOrFail($id);

        if ($post->status === 'published') {
            $post->status = 'draft';
        } else {
            $post->status = 'published';
            if (!$post->published_at) $post->published_at = Carbon::now();
        }

        $post->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function delete($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();

        return redirect()->back()->with('success', 'Đã xoá bài viết!');
    }
}
