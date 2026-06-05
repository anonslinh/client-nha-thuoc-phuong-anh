@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <h4 class="mb-0 card-title">Sản phẩm bán chạy</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('catalog_v1.best_sellers.attach.page') }}" class="btn btn-info">
                    <i class="ti ti-plus me-1"></i> Chọn sản phẩm
                </a>
            </div>
        </div>
        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{session('success')}}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{session('error')}}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive mt-2">
                <table class="table table-bordered text-nowrap">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Sản phẩm</th>
                            <th>Giá sale</th>
                            <th>Đơn vị</th>
                            <th>Sort</th>
                            <th>Status</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($listData->total() > 0)
                        @foreach($listData as $k => $row)
                            @php
                                $p = $productsMap[$row->product_id] ?? null;
                                $pname = $p->name ?? $p->full_name ?? ('#'.$row->product_id);
                                $img = $p->img_avatar ?? null;
                                $src = $img ? (\Illuminate\Support\Str::startsWith($img,'http') ? $img : asset($img)) : null;
                            @endphp
                            <tr>
                                <td class="align-middle">{{ $k+1 }}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($src)
                                            <img src="{{ $src }}" style="width:50px;height:50px;border-radius:10px;object-fit:cover;">
                                        @endif
                                        <div>
                                            <b>{{ $pname }}</b><br>
                                            <span class="text-muted">Product ID: {{ $row->product_id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">{{ $row->sale_price ? number_format($row->sale_price).'đ' : '-' }}</td>
                                <td class="align-middle">{{ $row->unit ?? '-' }}</td>
                                <td class="align-middle">{{ $row->sort_order }}</td>
                                <td class="align-middle">
                                    <span class="badge {{ $row->status==1?'bg-success':'bg-danger' }}">{{ $row->status==1?'ON':'OFF' }}</span>
                                </td>
                                <td class="align-middle">
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$row->id}}">Sửa</button>
                                    <a class="btn btn-danger btn-sm btn-sa-confirm" href="{{ route('catalog_v1.best_sellers.destroy',$row->id) }}">Xóa</a>

                                    <div class="modal fade" id="modalUpdate{{$row->id}}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <form method="post" class="modal-content" action="{{ route('catalog_v1.best_sellers.update',$row->id) }}">
                                                @csrf
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title">Cập nhật sản phẩm bán chạy</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-2">
                                                        <label class="form-label">Giá sale</label>
                                                        <input class="form-control" name="sale_price" value="{{ $row->sale_price }}">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label">Đơn vị</label>
                                                        <input class="form-control" name="unit" value="{{ $row->unit }}" placeholder="chai/lọ/vỉ/chiếc...">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label">Sort order</label>
                                                        <input class="form-control" name="sort_order" value="{{ $row->sort_order }}">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label">Status</label>
                                                        <select class="form-control" name="status">
                                                            <option value="1" {{ $row->status==1?'selected':'' }}>1</option>
                                                            <option value="0" {{ $row->status==0?'selected':'' }}>0</option>
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
                        @endforeach
                    @else
                        <tr><td colspan="7" class="text-danger text-center">Chưa có sản phẩm bán chạy</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $listData->appends(request()->all())->links('pagination') }}
            </div>
        </div>
    </div>
</div>
@endsection