<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogPost extends Model
{
    protected $table = 'blog_posts';

    protected $fillable = [
        'category_id',
        'title', 'slug', 'excerpt', 'content',
        'thumbnail_url', 'image_url',
        'author_name',
        'seo_title', 'meta_description', 'meta_keywords',
        'view_count',
        'is_published', 'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        // route-model-binding theo slug
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag', 'blog_post_id', 'blog_tag_id');
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true)
                 ->whereNotNull('published_at')
                 ->where('published_at', '<=', now());
    }

    public function scopeSearch(Builder $q, ?string $keyword): Builder
    {
        $keyword = trim((string)$keyword);
        if ($keyword === '') return $q;

        return $q->where(function ($qq) use ($keyword) {
            $qq->where('title', 'like', "%{$keyword}%")
               ->orWhere('excerpt', 'like', "%{$keyword}%")
               ->orWhere('content', 'like', "%{$keyword}%");
        });
    }
}
