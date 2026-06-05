@extends('Layout.index')

@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <div>
                <h4 class="mb-1 card-title">Preview bài viết</h4>
                <div class="text-muted">
                    Danh mục: {{ $category->name }}
                </div>
            </div>
            <a href="{{ route('catalog_v1.health_corner.articles', $category->id) }}" class="btn btn-danger">
                Quay lại
            </a>
        </div>
    </div>

    @php
        $avatar = $article->avatar ? (\Illuminate\Support\Str::startsWith($article->avatar,'http') ? $article->avatar : asset($article->avatar)) : null;
        $banner = $article->banner ? (\Illuminate\Support\Str::startsWith($article->banner,'http') ? $article->banner : asset($article->banner)) : null;
    @endphp

    <div class="card border-0 shadow-sm" style="border-radius:20px; overflow:hidden;">
        @if($banner)
            <img src="{{ $banner }}" style="width:100%; height:360px; object-fit:cover;">
        @else
            <div style="height:360px; background:linear-gradient(90deg,#67d5ec,#42b6d0);"></div>
        @endif

        <div class="card-body p-4 p-lg-5">
            <div class="d-flex align-items-center gap-3 mb-4">
                @if($avatar)
                    <img src="{{ $avatar }}" style="width:72px; height:72px; border-radius:16px; object-fit:cover;">
                @endif

                <div>
                    <div class="small text-muted mb-1">{{ $category->name }}</div>
                    <h2 class="mb-1">{{ $article->title }}</h2>
                    <div class="small text-muted">
                        Ngày đăng:
                        {{ $article->posted_at ? \Carbon\Carbon::parse($article->posted_at)->format('d/m/Y H:i') : '-' }}
                        |
                        Trạng thái:
                        <span class="badge {{ $article->status == 1 ? 'bg-success' : 'bg-danger' }}">
                            {{ $article->status == 1 ? 'Hiện' : 'Ẩn' }}
                        </span>
                    </div>
                </div>
            </div>

            @if($article->short_description)
                <div class="mb-4 p-3 rounded" style="background:#f8fafc; border-left:4px solid #0dcaf0;">
                    <div class="fw-semibold mb-2">Mô tả ngắn</div>
                    <div>{{ $article->short_description }}</div>
                </div>
            @endif

            <div class="article-content" style="font-size:16px; line-height:1.8;">
                {!! $article->content !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 12px 0;
    }

    .article-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 16px 0;
    }

    .article-content table td,
    .article-content table th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .article-content h1,
    .article-content h2,
    .article-content h3,
    .article-content h4 {
        margin-top: 18px;
        margin-bottom: 10px;
    }

    .article-content p {
        margin-bottom: 12px;
    }
</style>
@endsection