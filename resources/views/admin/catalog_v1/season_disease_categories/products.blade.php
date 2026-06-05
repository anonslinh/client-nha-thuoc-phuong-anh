@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <div>
                <h4 class="mb-1 card-title">Sản phẩm trong hạng mục: <span class="text-primary">{{ $category->name }}</span></h4>
                <div class="text-muted">Quản trị danh sách sản phẩm theo từng bệnh theo mùa</div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('catalog_v1.season_disease_categories.attach.page',$category->id) }}" class="btn btn-info">Thêm sản phẩm</a>
                <a href="{{ route('catalog_v1.season_disease_categories.index') }}" class="btn btn-danger">Quay lại</a>
            </div>
        </div>
        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
    </div>

    <div class="row">
        @forelse($maps as $map)
            @php
                $p = $productsMap[$map->product_id] ?? null;
                $img = $p?->img_avatar;
                $src = $img ? (\Illuminate\Support\Str::startsWith($img,'http') ? $img : asset($img)) : null;
                $pname = $p?->name ?? $p?->full_name ?? ('#'.$map->product_id);
            @endphp

            <div class="col-md-6 col-xl-4 mb-4">
                <div class="card h-100 shadow-sm border-0" style="border-radius:18px;">
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <div style="width:96px; flex:0 0 96px;">
                                @if($src)
                                    <img src="{{ $src }}" style="width:96px;height:96px;border-radius:14px;object-fit:cover;">
                                @else
                                    <div style="width:96px;height:96px;border-radius:14px;background:#f0f3f7;display:flex;align-items:center;justify-content:center;color:#999;">
                                        No image
                                    </div>
                                @endif
                            </div>

                            <div class="flex-grow-1">
                                <h6 class="fw-semibold mb-1" style="line-height:1.4;">{{ $pname }}</h6>
                                <div class="small text-muted mb-1">Product ID: {{ $map->product_id }}</div>
                                <div class="small text-primary mb-1">Giá gốc: {{ $p?->price ? number_format($p->price).'đ' : '-' }}</div>
                                <div class="small text-success mb-1">Giá ưu đãi: {{ $map->sale_price ? number_format($map->sale_price).'đ' : '-' }}</div>
                                <div class="small text-muted mb-1">Đơn vị: {{ $map->unit ?? '-' }}</div>
                                <div class="small text-muted mb-1">Sort: {{ $map->sort_order }}</div>
                                <span class="badge {{ $map->status==1?'bg-success':'bg-danger' }}">{{ $map->status==1?'Hiện':'Ẩn' }}</span>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$map->id}}">
                                Cập nhật
                            </button>
                            <a href="{{ route('catalog_v1.season_disease_categories.product.destroy', [$category->id, $map->id]) }}"
                               class="btn btn-danger btn-sm btn-sa-confirm">
                                Xóa
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- update modal --}}
            <div class="modal fade" id="modalUpdate{{$map->id}}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form action="{{ route('catalog_v1.season_disease_categories.product.update', [$category->id, $map->id]) }}" method="post" class="modal-content">
                        @csrf
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title">Cập nhật sản phẩm trong hạng mục</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label class="form-label">Giá ưu đãi</label>
                                <input class="form-control" name="sale_price" value="{{ $map->sale_price }}">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Đơn vị tính</label>
                                <input class="form-control" name="unit" value="{{ $map->unit }}" placeholder="VD: hộp/chai/lọ/vỉ">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Sort order</label>
                                <input class="form-control" name="sort_order" value="{{ $map->sort_order }}">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="1" {{ $map->status==1?'selected':'' }}>Hiện</option>
                                    <option value="0" {{ $map->status==0?'selected':'' }}>Ẩn</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Hủy</button>
                            <button class="btn btn-primary">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-danger text-center">Chưa có sản phẩm trong hạng mục</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-2">
        {{ $maps->appends(request()->all())->links('pagination') }}
    </div>
</div>
@endsection