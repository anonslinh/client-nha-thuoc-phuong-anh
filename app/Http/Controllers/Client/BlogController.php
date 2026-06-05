<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $categoryParam = $request->query('category'); // slug hoặc id
        $tagParam = $request->query('tag');           // slug hoặc id

        $query = BlogPost::query()
            ->published()
            ->with(['category', 'tags'])
            ->search($q);

        // Filter category
        $activeCategory = null;
        if ($categoryParam) {
            $activeCategory = BlogCategory::query()
                ->where('is_active', true)
                ->where(function ($qq) use ($categoryParam) {
                    $qq->where('slug', $categoryParam);
                    if (ctype_digit((string)$categoryParam)) $qq->orWhere('id', (int)$categoryParam);
                })
                ->first();

            if ($activeCategory) {
                $query->where('category_id', $activeCategory->id);
            }
        }

        // Filter tag
        $activeTag = null;
        if ($tagParam) {
            $activeTag = BlogTag::query()
                ->where(function ($qq) use ($tagParam) {
                    $qq->where('slug', $tagParam);
                    if (ctype_digit((string)$tagParam)) $qq->orWhere('id', (int)$tagParam);
                })
                ->first();

            if ($activeTag) {
                $query->whereHas('tags', function ($tq) use ($activeTag) {
                    $tq->where('blog_tags.id', $activeTag->id);
                });
            }
        }

        $posts = $query
            ->orderByDesc('published_at')
            ->paginate(8)
            ->withQueryString();

        // Sidebar data
        $categories = BlogCategory::query()
            ->where('is_active', true)
            ->withCount(['posts' => function ($q) {
                $q->published();
            }])
            ->orderBy('name')
            ->get();

        $recentPosts = BlogPost::query()
            ->published()
            ->select(['id', 'title', 'slug', 'published_at', 'created_at'])
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $tags = BlogTag::query()
            ->withCount(['posts' => function ($q) {
                $q->published();
            }])
            ->orderByDesc('posts_count')
            ->limit(20)
            ->get();

        // SEO
        $seoTitle = 'Bài viết | 1986Hotels';
        $seoDescription = 'Cập nhật bài viết, kinh nghiệm du lịch, tin tức và ưu đãi mới nhất từ 1986Hotels.';
        if ($activeCategory) {
            $seoTitle = $activeCategory->name . ' | 1986Hotels';
            $seoDescription = $activeCategory->description ?: $seoDescription;
        }
        if ($activeTag) {
            $seoTitle = 'Thẻ: ' . $activeTag->name . ' | 1986Hotels';
        }
        if ($q) {
            $seoTitle = 'Tìm kiếm: ' . Str::limit($q, 40) . ' | 1986Hotels';
        }

        return view('client.blog.index', compact(
            'posts',
            'categories',
            'recentPosts',
            'tags',
            'seoTitle',
            'seoDescription'
        ));
    }

    public function show(BlogPost $post)
    {
        // Nếu muốn ẩn bài chưa publish:
        if (!$post->is_published || !$post->published_at || $post->published_at->isFuture()) {
            abort(404);
        }

        $post->load(['category', 'tags']);
        $post->increment('view_count');

        $recentPosts = BlogPost::query()
            ->published()
            ->where('id', '!=', $post->id)
            ->select(['id', 'title', 'slug', 'published_at', 'created_at'])
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $categories = BlogCategory::query()
            ->where('is_active', true)
            ->withCount(['posts' => function ($q) {
                $q->published();
            }])
            ->orderBy('name')
            ->get();

        // Related: cùng category (nếu có) hoặc fallback
        $relatedQuery = BlogPost::query()->published()->where('id', '!=', $post->id);
        if ($post->category_id) {
            $relatedQuery->where('category_id', $post->category_id);
        }
        $relatedPosts = $relatedQuery->orderByDesc('published_at')->limit(6)->get();

        $canonical = route('client.blog.show', $post);

        return view('client.blog.show', compact(
            'post',
            'recentPosts',
            'categories',
            'relatedPosts',
            'canonical'
        ));
    }
}
