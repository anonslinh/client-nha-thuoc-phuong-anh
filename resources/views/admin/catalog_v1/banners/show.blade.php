@extends('Layout.index')

@section('content')
<div class="container-fluid">
    @php
        $image = $item->image ? (\Illuminate\Support\Str::startsWith($item->image,'http') ? $item->image : asset($item->image)) : null;
    @endphp

    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <div>
                <h4 class="mb-1 card-title">Chi tiết banner</h4>
                <div class="text-muted">{{ $item->title }}</div>
            </div>
            <a href="{{ route('catalog_v1.banners.index') }}" class="btn btn-danger">
                Quay lại
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:20px; overflow:hidden;">
        @if($image)
            <img src="{{ $image }}" style="width:100%; height:360px; object-fit:cover;">
        @else
            <div style="height:360px; background:linear-gradient(90deg,#67d5ec,#42b6d0);"></div>
        @endif

        <div class="card-body p-4 p-lg-5">
            <div class="mb-3">
                <h2 class="mb-2">{{ $item->title ?: 'Không có tiêu đề' }}</h2>
                <div class="small text-muted">
                    Sort: {{ $item->sort_order }} |
                    Trạng thái:
                    <span class="badge {{ $item->type_hide == 1 ? 'bg-success' : 'bg-danger' }}">
                        {{ $item->type_hide == 1 ? 'Hiện' : 'Ẩn' }}
                    </span>
                </div>
            </div>

            @if($item->link_web)
                <div class="mb-4">
                    <a href="{{ $item->link_web }}" target="_blank" class="btn btn-primary">
                        Xem link web
                    </a>
                </div>
            @endif

            <div class="article-content" style="font-size:16px; line-height:1.8;">
                {!! $item->content !!}
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