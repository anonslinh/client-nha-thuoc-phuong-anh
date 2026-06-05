@extends('Layout.index')

@section('content')
<div class="container-fluid">
    @php
        $banner = $item->banner ? (\Illuminate\Support\Str::startsWith($item->banner,'http') ? $item->banner : asset($item->banner)) : null;
    @endphp

    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <div>
                <h4 class="mb-1 card-title">Chi tiết thông tin nổi bật</h4>
                <div class="text-muted">{{ $item->seo_title }}</div>
            </div>
            <a href="{{ route('catalog_v1.text_seo_header.index') }}" class="btn btn-danger">
                Quay lại
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:20px; overflow:hidden;">
        @if($banner)
            <img src="{{ $banner }}" style="width:100%; height:360px; object-fit:cover;">
        @else
            <div style="height:360px; background:linear-gradient(90deg,#67d5ec,#42b6d0);"></div>
        @endif

        <div class="card-body p-4 p-lg-5">
            <div class="mb-3">
                <h2 class="mb-2">{{ $item->seo_title }}</h2>
                <div class="small text-muted">
                    Sort order: {{ $item->sort_order }} |
                    {{ $item->has_product_list == 1 ? 'Có sản phẩm kèm theo' : 'Không kèm sản phẩm' }}
                </div>
            </div>

            @if($item->seo_description)
                <div class="mb-4 p-3 rounded" style="background:#f8fafc; border-left:4px solid #0dcaf0;">
                    <div class="fw-semibold mb-2">Mô tả ngắn</div>
                    <div>{{ $item->seo_description }}</div>
                </div>
            @endif

            @if($item->see_more_link)
                <div class="mb-4">
                    <a href="{{ $item->see_more_link }}" target="_blank" class="btn btn-primary">
                        Xem thêm
                    </a>
                </div>
            @endif

            <div class="article-content mb-4" style="font-size:16px; line-height:1.8;">
                {!! $item->article_content !!}
            </div>

            @if($item->has_product_list == 1 && isset($maps) && count($maps) > 0)
                <hr>
                <h4 class="mb-3">Danh sách sản phẩm kèm theo</h4>

                <div class="row">
                    @foreach($maps as $map)
                        @php
                            $p = $productsMap[$map->product_id] ?? null;
                            $img = $p?->img_avatar;
                            $src = $img ? (\Illuminate\Support\Str::startsWith($img,'http') ? $img : asset($img)) : null;
                        @endphp
                        @if($p)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm" style="border-radius:16px;">
                                    <div class="card-body">
                                        @if($src)
                                            <img src="{{ $src }}" style="width:100%;height:180px;object-fit:cover;border-radius:14px;" class="mb-3">
                                        @endif

                                        <h6 class="fw-semibold mb-1">{{ $p->name }}</h6>
                                        <div class="small text-muted mb-2">{{ $p->full_name }}</div>
                                        <div class="text-primary fw-semibold">
                                            {{ $p->price ? number_format($p->price).'đ' : '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
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