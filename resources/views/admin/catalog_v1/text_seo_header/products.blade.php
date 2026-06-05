@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <div>
                <h4 class="mb-1 card-title">Sản phẩm của thông tin nổi bật</h4>
                <div class="text-muted">{{ $item->seo_title }}</div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('catalog_v1.text_seo_header.attach.page',$item->id) }}" class="btn btn-info">Thêm sản phẩm</a>
                <a href="{{ route('catalog_v1.text_seo_header.index') }}" class="btn btn-danger">Quay lại</a>
            </div>
        </div>
        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('catalog_v1.text_seo_header.detach',$item->id) }}" id="detachForm">
                @csrf

                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:60px"><input type="checkbox" id="checkAll"></th>
                                <th>Sản phẩm</th>
                                <th>Sort</th>
                                <th>Status</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($maps as $map)
                            @php
                                $p = $productsMap[$map->product_id] ?? null;
                                $img = $p?->img_avatar;
                                $src = $img ? (\Illuminate\Support\Str::startsWith($img,'http') ? $img : asset($img)) : null;
                            @endphp
                            <tr>
                                <td class="text-center align-middle">
                                    <input type="checkbox" class="rowCheck" name="map_ids[]" value="{{ $map->id }}">
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($src)
                                            <img src="{{ $src }}" style="width:52px;height:52px;border-radius:12px;object-fit:cover;">
                                        @endif
                                        <div>
                                            <b>{{ $p?->name ?? '-' }}</b><br>
                                            <span class="text-muted">{{ $p?->full_name ?? '' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">{{ $map->sort_order }}</td>
                                <td class="align-middle">
                                    <span class="badge {{ $map->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $map->status == 1 ? 'ON' : 'OFF' }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$map->id}}">
                                        Sửa
                                    </button>

                                    <div class="modal fade" id="modalUpdate{{$map->id}}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <form class="modal-content" method="post" action="{{ route('catalog_v1.text_seo_header.product.update', [$item->id, $map->id]) }}">
                                                @csrf
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title">Cập nhật sản phẩm</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-2">
                                                        <label class="form-label">Sort order</label>
                                                        <input class="form-control" name="sort_order" value="{{ $map->sort_order }}">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label">Status</label>
                                                        <select class="form-control" name="status">
                                                            <option value="1" {{ $map->status==1?'selected':'' }}>1</option>
                                                            <option value="0" {{ $map->status==0?'selected':'' }}>0</option>
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
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-danger text-center">Chưa có sản phẩm</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <button class="btn btn-danger">Gỡ sản phẩm đã chọn</button>
            </form>

            <div class="d-flex justify-content-center mt-3">
                {{ $maps->appends(request()->all())->links('pagination') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(function(){
    $('#checkAll').on('change', function(){
        $('.rowCheck').prop('checked', $(this).is(':checked'));
    });

    $('#detachForm').on('submit', function(e){
        if($('.rowCheck:checked').length === 0){
            e.preventDefault();
            alert('Vui lòng chọn ít nhất 1 sản phẩm.');
        }
    });
});
</script>
@endsection