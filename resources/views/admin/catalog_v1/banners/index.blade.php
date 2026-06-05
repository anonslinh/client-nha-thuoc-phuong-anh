@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <h4 class="mb-0 card-title">Quản lý banner</h4>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCreate">
                <i class="ti ti-plus me-1"></i> Thêm banner
            </button>
        </div>
        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('catalog_v1.banners.index') }}" method="get" class="row">
                <div class="col-md-4 mb-2">
                    <input name="key_search" class="form-control" placeholder="Tìm tiêu đề banner..."
                           value="{{ request('key_search') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <select name="type_hide" class="form-control">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="1" {{ request('type_hide') == '1' ? 'selected' : '' }}>Hiện</option>
                        <option value="0" {{ request('type_hide') == '0' ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>
                <div class="col-md-5 mb-2">
                    <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
                    <a href="{{ route('catalog_v1.banners.index') }}" class="btn btn-danger">Hủy</a>
                </div>
            </form>

            <div class="row mt-3">
                @forelse($listData as $row)
                    @php
                        $image = $row->image ? (\Illuminate\Support\Str::startsWith($row->image,'http') ? $row->image : asset($row->image)) : null;
                    @endphp

                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="card h-100 shadow-sm border-0" style="border-radius:18px; overflow:hidden;">
                            @if($image)
                                <img src="{{ $image }}" style="width:100%; height:190px; object-fit:cover;">
                            @else
                                <div style="height:190px; background:linear-gradient(90deg,#67d5ec,#42b6d0);"></div>
                            @endif

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h5 class="mb-1">{{ $row->title ?: 'Không có tiêu đề' }}</h5>
                                    <span class="badge bg-secondary">Sort: {{ $row->sort_order }}</span>
                                </div>

                                <div class="mb-2">
                                    <span class="badge {{ $row->type_hide == 1 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $row->type_hide == 1 ? 'Hiện' : 'Ẩn' }}
                                    </span>
                                </div>

                                @if($row->link_web)
                                    <div class="small text-primary mb-3">
                                        {{ \Illuminate\Support\Str::limit($row->link_web, 60) }}
                                    </div>
                                @endif

                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('catalog_v1.banners.show',$row->id) }}" target="_blank" class="btn btn-primary btn-sm">
                                        Xem chi tiết
                                    </a>

                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$row->id}}">
                                        Sửa
                                    </button>

                                    <a href="{{ route('catalog_v1.banners.destroy',$row->id) }}" class="btn btn-danger btn-sm btn-sa-confirm">
                                        Xóa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalUpdate{{$row->id}}" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                            <form action="{{ route('catalog_v1.banners.update',$row->id) }}" method="post" class="modal-content" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title">Cập nhật banner</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Tiêu đề</label>
                                            <input class="form-control" name="title" value="{{ $row->title }}">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Trạng thái hiển thị</label>
                                            <select class="form-control" name="type_hide">
                                                <option value="1" {{ $row->type_hide == 1 ? 'selected' : '' }}>Hiện</option>
                                                <option value="0" {{ $row->type_hide == 0 ? 'selected' : '' }}>Ẩn</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Sort order</label>
                                            <input class="form-control" name="sort_order" value="{{ $row->sort_order }}" required>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Link web</label>
                                        <input class="form-control" name="link_web" value="{{ $row->link_web }}">
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Ảnh banner (upload hoặc link)</label>
                                        <input type="file" class="form-control mb-2" name="image">
                                        <input class="form-control" name="image" value="{{ $row->image }}" placeholder="Hoặc dán link/path">
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Thông tin chi tiết banner (CKEditor)</label>
                                        <textarea class="form-control ckeditor-area" name="content" style="height:300px">{{ $row->content }}</textarea>
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
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <form action="{{ route('catalog_v1.banners.store') }}" method="post" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title">Thêm banner</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Tiêu đề</label>
                        <input class="form-control" name="title">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Trạng thái hiển thị</label>
                        <select class="form-control" name="type_hide">
                            <option value="1" selected>Hiện</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Sort order</label>
                        <input class="form-control" name="sort_order" value="0" required>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label">Link web</label>
                    <input class="form-control" name="link_web" placeholder="https://...">
                </div>

                <div class="mb-2">
                    <label class="form-label">Ảnh banner (upload hoặc link)</label>
                    <input type="file" class="form-control mb-2" name="image">
                    <input class="form-control" name="image" placeholder="Hoặc dán link/path">
                </div>

                <div class="mb-2">
                    <label class="form-label">Thông tin chi tiết banner (CKEditor)</label>
                    <textarea class="form-control ckeditor-area" name="content" style="height:300px"></textarea>
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

@section('script')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.ckeditor-area').forEach(function(el){
        if (!el.dataset.ckeditorInit) {
            ClassicEditor.create(el).catch(error => console.error(error));
            el.dataset.ckeditorInit = '1';
        }
    });
});
</script>
@endsection