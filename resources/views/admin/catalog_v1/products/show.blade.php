@extends('Layout.index')

@section('content')
<div class="container-fluid">
    @php
        $img = $product->img_avatar;
        $avatar = $img ? (\Illuminate\Support\Str::startsWith($img,'http') ? $img : asset($img)) : null;

        $categoryName = optional($categories->firstWhere('id', $product->id_category))->name;
        $tradeMarkName = optional($trademarks->firstWhere('id', $product->id_trade_mark))->name;
    @endphp

    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <div>
                <h4 class="mb-1 card-title">Chi tiết sản phẩm</h4>
                <div class="text-muted">
                    {{ $product->name ?? '-' }}
                </div>
            </div>
            <a href="{{ route('catalog_v1.products.index') }}" class="btn btn-danger">
                Quay lại
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:20px;">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    @if($avatar)
                        <img src="{{ $avatar }}" style="width:100%; max-width:420px; border-radius:18px; object-fit:cover;">
                    @else
                        <div style="width:100%;height:320px;border-radius:18px;background:#f2f5f9;display:flex;align-items:center;justify-content:center;color:#999;">
                            No image
                        </div>
                    @endif
                </div>

                <div class="col-lg-8">
                    <div class="mb-3">
                        <h2 class="mb-2">{{ $product->name ?? '-' }}</h2>
                        @if($product->full_name)
                            <div class="text-muted">{{ $product->full_name }}</div>
                        @endif
                    </div>

                    <div class="mb-3 d-flex flex-wrap gap-2">
                        @if($categoryName)
                            <span class="badge bg-primary-subtle text-primary">{{ $categoryName }}</span>
                        @endif
                        @if($tradeMarkName)
                            <span class="badge bg-info-subtle text-info">{{ $tradeMarkName }}</span>
                        @endif

                        @if($product->status == 1)
                            <span class="badge bg-success">Hiện</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif

                        @if($product->is_active === 1 || $product->is_active === '1')
                            <span class="badge bg-success-subtle text-success">Đang kinh doanh</span>
                        @elseif($product->is_active === 0 || $product->is_active === '0')
                            <span class="badge bg-danger-subtle text-danger">Ngừng bán</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <div class="fs-4 fw-bold text-primary">
                            {{ $product->price ? number_format($product->price).'đ' : '-' }}
                        </div>
                        @if($product->price_sale)
                            <div class="text-danger fw-semibold">
                                Giá sale: {{ number_format($product->price_sale) }}đ
                            </div>
                        @endif
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-2">
                            <div class="small text-muted">Kiot ID</div>
                            <div>{{ $product->id_product_kiotviet ?? '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="small text-muted">Mã Kiot</div>
                            <div>{{ $product->code_product_kiovet ?? '-' }}</div>
                        </div>
                    </div>

                    @if($product->description)
                        <div class="p-3 rounded" style="background:#f8fafc; border-left:4px solid #0dcaf0;">
                            <div class="fw-semibold mb-2">Mô tả</div>
                            <div style="line-height:1.8;">{!! nl2br(e($product->description)) !!}</div>
                        </div>
                    @endif
                </div>
            </div>

            @if($gallery->count() > 0)
                <hr>
                <h5 class="mb-3">Ảnh gallery</h5>
                <div class="row">
                    @foreach($gallery as $g)
                        @php
                            $gimg = $g->link_img ? (\Illuminate\Support\Str::startsWith($g->link_img,'http') ? $g->link_img : asset($g->link_img)) : null;
                        @endphp
                        @if($gimg)
                            <div class="col-md-3 col-6 mb-3">
                                <img src="{{ $gimg }}" style="width:100%; height:180px; object-fit:cover; border-radius:14px;">
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection