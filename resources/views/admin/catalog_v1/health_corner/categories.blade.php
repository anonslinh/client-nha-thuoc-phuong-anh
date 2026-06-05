@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <h4 class="mb-0 card-title">Danh mục Góc sức khỏe</h4>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCreate">
                <i class="ti ti-plus me-1"></i> Thêm danh mục
            </button>
        </div>
        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('catalog_v1.health_corner.categories') }}" method="get" class="row">
                <div class="col-md-4 mb-2">
                    <input name="key_search" class="form-control" placeholder="Tìm theo tên danh mục..."
                           value="{{ request('key_search') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
                    <a href="{{ route('catalog_v1.health_corner.categories') }}" class="btn btn-danger">Hủy</a>
                </div>
            </form>

            <div class="table-responsive mt-3">
                <table class="table table-bordered text-nowrap">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên danh mục</th>
                            <th>Sort</th>
                            <th>Status</th>
                            <th>Bài viết</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($listData->total() > 0)
                        @foreach($listData as $k => $row)
                            @php $count = $countMap[$row->id] ?? 0; @endphp
                            <tr>
                                <td class="align-middle">{{ $k+1 }}</td>
                                <td class="align-middle"><b>{{ $row->name }}</b></td>
                                <td class="align-middle">{{ $row->sort_order }}</td>
                                <td class="align-middle">
                                    <span class="badge {{ $row->status==1?'bg-success':'bg-danger' }}">{{ $row->status==1?'Hiện':'Ẩn' }}</span>
                                </td>
                                <td class="align-middle"><span class="badge bg-primary">{{ $count }}</span></td>
                                <td class="align-middle">
                                    <a href="{{ route('catalog_v1.health_corner.articles',$row->id) }}" class="btn btn-primary btn-sm">Bài viết</a>
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$row->id}}">Sửa</button>
                                    <a href="{{ route('catalog_v1.health_corner.categories.destroy',$row->id) }}" class="btn btn-danger btn-sm btn-sa-confirm">Xóa</a>

                                    <div class="modal fade" id="modalUpdate{{$row->id}}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <form action="{{ route('catalog_v1.health_corner.categories.update',$row->id) }}" method="post" class="modal-content">
                                                @csrf
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title">Cập nhật danh mục</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-2">
                                                        <label class="form-label">Tên danh mục</label>
                                                        <input class="form-control" name="name" value="{{ $row->name }}" required>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label">Sort order</label>
                                                        <input class="form-control" name="sort_order" value="{{ $row->sort_order }}" required>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label">Status</label>
                                                        <select class="form-control" name="status">
                                                            <option value="1" {{ $row->status==1?'selected':'' }}>Hiện</option>
                                                            <option value="0" {{ $row->status==0?'selected':'' }}>Ẩn</option>
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
                        <tr><td colspan="6" class="text-danger text-center">Không có dữ liệu</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $listData->appends(request()->all())->links('pagination') }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form action="{{ route('catalog_v1.health_corner.categories.store') }}" method="post" class="modal-content">
            @csrf
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title">Thêm danh mục Góc sức khỏe</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label">Tên danh mục</label>
                    <input class="form-control" name="name" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Sort order</label>
                    <input class="form-control" name="sort_order" value="0" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Status</label>
                    <select class="form-control" name="status">
                        <option value="1" selected>Hiện</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Hủy</button>
                <button class="btn btn-primary">Tạo</button>
            </div>
        </form>
    </div>
</div>
@endsection