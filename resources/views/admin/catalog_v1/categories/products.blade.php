@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <div>
                <h4 class="mb-1 card-title">Sản phẩm của danh mục</h4>
                <div class="text-muted">{{ $category->name }}</div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('catalog_v1.categories.attach.products.page',$category->id) }}" class="btn btn-info">
                    Thêm sản phẩm
                </a>

                <a href="{{ route('catalog_v1.categories.attach.kiot.page',$category->id) }}" class="btn btn-warning">
                    Cài đặt Kiot
                </a>

                <a href="{{ route('catalog_v1.categories.sync.kiot',$category->id) }}" class="btn btn-warning">
                    Đồng bộ lại KiotViet
                </a>

                <a href="{{ route('catalog_v1.categories.index') }}" class="btn btn-danger">
                    Quay lại
                </a>
            </div>
        </div>

        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
    </div>

    @if(isset($syncMaps) && $syncMaps->count() > 0)
        <div class="card">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Danh mục KiotViet đang map</h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($syncMaps as $map)
                        <span class="badge bg-info-subtle text-info">
                            {{ $map->kiot_category_name ?: ('Kiot ID: '.$map->kiot_category_id) }}
                            @if($map->last_synced_at)
                                - {{ \Carbon\Carbon::parse($map->last_synced_at)->format('d/m/Y H:i') }}
                            @endif
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('catalog_v1.categories.products',$category->id) }}" method="get" class="row">
                <div class="col-md-4 mb-2">
                    <input name="key_search" class="form-control" placeholder="Tên, full name, code kiot..."
                           value="{{ request('key_search') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
                    <a href="{{ route('catalog_v1.categories.products',$category->id) }}" class="btn btn-danger">Hủy</a>
                </div>
            </form>

            <form method="post" action="{{ route('catalog_v1.categories.detach.products',$category->id) }}" id="detachForm">
                @csrf

                <div class="row mt-3">
                    @forelse($listData as $p)
                        @php
                            $img = $p->img_avatar;
                            $src = $img ? (\Illuminate\Support\Str::startsWith($img,'http') ? $img : asset($img)) : null;
                        @endphp

                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card h-100 shadow-sm border-0" style="border-radius:18px;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input rowCheck" type="checkbox" name="product_ids[]" value="{{ $p->id }}">
                                            <label class="form-check-label fw-semibold">Chọn</label>
                                        </div>

                                        @if($p->id_product_kiotviet)
                                            <span class="badge bg-info">Kiot</span>
                                        @else
                                            <span class="badge bg-secondary">Manual</span>
                                        @endif
                                    </div>

                                    <div class="d-flex gap-3">
                                        <div style="width:96px;flex:0 0 96px;">
                                            @if($src)
                                                <img src="{{ $src }}" style="width:96px;height:96px;object-fit:cover;border-radius:16px;">
                                            @else
                                                <div style="width:96px;height:96px;border-radius:16px;background:#f2f5f9;display:flex;align-items:center;justify-content:center;color:#999;">
                                                    No image
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex-grow-1">
                                            <h5 class="mb-1 fw-semibold">{{ $p->name }}</h5>
                                            <div class="small text-muted mb-1">{{ \Illuminate\Support\Str::limit($p->full_name, 70) }}</div>
                                            <div class="small text-muted mb-1">{{ $p->code_product_kiovet }}</div>
                                            <div class="text-primary fw-semibold">
                                                {{ $p->price ? number_format($p->price).'đ' : '-' }}
                                            </div>
                                            <div class="small text-success">
                                                Tồn: {{ is_null($p->quantity_stock) ? '-' : rtrim(rtrim(number_format((float)$p->quantity_stock, 2, '.', ''), '0'), '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-danger text-center">Chưa có sản phẩm nào</p>
                        </div>
                    @endforelse
                </div>

                @if($listData->count() > 0)
                    <button class="btn btn-danger">Gỡ sản phẩm đã chọn</button>
                @endif
            </form>

            <div class="d-flex justify-content-center mt-3">
                {{ $listData->appends(request()->all())->links('pagination') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(function(){
    $('#detachForm').on('submit', function(e){
        if($('.rowCheck:checked').length === 0){
            e.preventDefault();
            alert('Vui lòng chọn ít nhất 1 sản phẩm.');
        }
    });
});
</script>
@endsection