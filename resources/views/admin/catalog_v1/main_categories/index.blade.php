@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <h4 class="mb-0 card-title">Danh mục cha</h4>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCreate">
                <i class="ti ti-plus me-1"></i> Thêm danh mục cha
            </button>
        </div>

        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('catalog_v1.main_categories.index') }}" method="get" class="row">
                <div class="col-md-4 mb-2">
                    <input name="key_search" class="form-control" placeholder="Tìm theo tên danh mục cha..."
                           value="{{ request('key_search') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
                    <a href="{{ route('catalog_v1.main_categories.index') }}" class="btn btn-danger">Hủy</a>
                </div>
            </form>

            <div class="row mt-3">
                @forelse($listData as $row)
                    @php
                        $img = $row->img ? (\Illuminate\Support\Str::startsWith($row->img,'http') ? $row->img : asset($row->img)) : null;
                        $count = $countMap[$row->id] ?? 0;
                    @endphp

                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="card h-100 shadow-sm border-0" style="border-radius:18px;">
                            <div class="card-body">
                                <div class="d-flex gap-3 mb-3">
                                    <div style="width:82px;flex:0 0 82px;">
                                        @if($img)
                                            <img src="{{ $img }}" style="width:82px;height:82px;object-fit:cover;border-radius:16px;">
                                        @else
                                            <div style="width:82px;height:82px;border-radius:16px;background:#f2f5f9;display:flex;align-items:center;justify-content:center;color:#999;">
                                                No image
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-grow-1">
                                        <h5 class="mb-1 fw-semibold">{{ $row->name ?: 'Danh mục cha' }}</h5>
                                        <div class="small text-muted mb-1">Sort: {{ $row->sort_order }}</div>
                                        <div class="small text-primary">Danh mục con: {{ $count }}</div>
                                    </div>
                                </div>

                                @if($row->description)
                                    <div class="text-muted small mb-3" style="line-height:1.7;">
                                        {{ \Illuminate\Support\Str::limit($row->description, 120) }}
                                    </div>
                                @endif

                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('catalog_v1.main_categories.categories',$row->id) }}" class="btn btn-primary btn-sm">
                                        DS danh mục con
                                    </a>

                                    <a href="{{ route('catalog_v1.main_categories.attach.page',$row->id) }}" class="btn btn-info btn-sm">
                                        Gán danh mục con
                                    </a>

                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$row->id}}">
                                        Sửa
                                    </button>

                                    <a href="{{ route('catalog_v1.main_categories.destroy',$row->id) }}" class="btn btn-danger btn-sm btn-sa-confirm">
                                        Xóa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalUpdate{{$row->id}}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <form action="{{ route('catalog_v1.main_categories.update',$row->id) }}" method="post" class="modal-content" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title">Cập nhật danh mục cha</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label class="form-label">Tên</label>
                                        <input class="form-control" name="name" value="{{ $row->name }}">
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Mô tả</label>
                                        <textarea class="form-control" name="description" style="height:120px">{{ $row->description }}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Ảnh (upload hoặc link)</label>
                                            <input type="file" class="form-control mb-2" name="img">
                                            <input class="form-control" name="img" value="{{ $row->img }}" placeholder="Hoặc dán link/path">
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Sort order</label>
                                            <input class="form-control" name="sort_order" value="{{ $row->sort_order }}" required>
                                        </div>
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
                        <p class="text-danger text-center">Không có dữ liệu</p>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center">
                {{ $listData->appends(request()->all())->links('pagination') }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <form action="{{ route('catalog_v1.main_categories.store') }}" method="post" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title">Thêm danh mục cha</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label">Tên</label>
                    <input class="form-control" name="name">
                </div>

                <div class="mb-2">
                    <label class="form-label">Mô tả</label>
                    <textarea class="form-control" name="description" style="height:120px"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Ảnh (upload hoặc link)</label>
                        <input type="file" class="form-control mb-2" name="img">
                        <input class="form-control" name="img" placeholder="Hoặc dán link/path">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label class="form-label">Sort order</label>
                        <input class="form-control" name="sort_order" value="0" required>
                    </div>
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