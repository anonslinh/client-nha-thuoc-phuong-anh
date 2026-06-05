@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <div>
                <h4 class="mb-1 card-title">Danh sách bệnh - {{ $category->name }}</h4>
                <div class="text-muted">
                    {{ $category->type == 1 ? 'Bệnh theo mùa' : 'Bệnh theo đối tượng' }}
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCreate">
                    <i class="ti ti-plus me-1"></i> Thêm bệnh
                </button>
                <a href="{{ route('catalog_v1.diseases.categories') }}" class="btn btn-danger">Quay lại</a>
            </div>
        </div>
        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('catalog_v1.diseases.items',$category->id) }}" method="get" class="row">
                <div class="col-md-4 mb-2">
                    <input name="key_search" class="form-control" placeholder="Tìm tiêu đề, mô tả ngắn..."
                           value="{{ request('key_search') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
                    <a href="{{ route('catalog_v1.diseases.items',$category->id) }}" class="btn btn-danger">Hủy</a>
                </div>
            </form>

            <div class="row mt-3">
                @forelse($listData as $row)
                    @php
                        $avatar = $row->avatar ? (\Illuminate\Support\Str::startsWith($row->avatar,'http') ? $row->avatar : asset($row->avatar)) : null;
                        $banner = $row->banner ? (\Illuminate\Support\Str::startsWith($row->banner,'http') ? $row->banner : asset($row->banner)) : null;
                    @endphp

                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="card h-100 shadow-sm border-0" style="border-radius:18px; overflow:hidden;">
                            @if($banner)
                                <img src="{{ $banner }}" style="width:100%; height:170px; object-fit:cover;">
                            @else
                                <div style="height:170px; background:linear-gradient(90deg,#67d5ec,#42b6d0);"></div>
                            @endif

                            <div class="card-body">
                                <div class="d-flex gap-3 mb-3">
                                    @if($avatar)
                                        <img src="{{ $avatar }}" style="width:56px;height:56px;border-radius:12px;object-fit:cover;">
                                    @endif
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">{{ $row->title }}</h5>
                                        <div class="small text-muted">
                                            Ngày đăng: {{ $row->posted_at ? \Carbon\Carbon::parse($row->posted_at)->format('d/m/Y H:i') : '-' }}
                                        </div>
                                    </div>
                                </div>

                                <p class="text-muted mb-3" style="min-height:64px;">{{ $row->short_description }}</p>

                                <div class="mb-3">
                                    <span class="badge {{ $row->status==1?'bg-success':'bg-danger' }}">{{ $row->status==1?'Hiện':'Ẩn' }}</span>
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('catalog_v1.diseases.items.show',[$category->id,$row->id]) }}"
                                       target="_blank"
                                       class="btn btn-primary btn-sm">
                                        Xem chi tiết
                                    </a>

                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$row->id}}">
                                        Sửa
                                    </button>

                                    <a href="{{ route('catalog_v1.diseases.items.destroy',[$category->id,$row->id]) }}"
                                       class="btn btn-danger btn-sm btn-sa-confirm">
                                        Xóa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalUpdate{{$row->id}}" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                            <form action="{{ route('catalog_v1.diseases.items.update',[$category->id,$row->id]) }}" method="post" class="modal-content" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title">Cập nhật bệnh</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label class="form-label">Tiêu đề</label>
                                        <input class="form-control" name="title" value="{{ $row->title }}" required>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Mô tả ngắn</label>
                                        <textarea class="form-control" name="short_description" style="height:120px">{{ $row->short_description }}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Avatar (upload hoặc link)</label>
                                            <input type="file" class="form-control mb-2" name="avatar">
                                            <input class="form-control" name="avatar" value="{{ $row->avatar }}" placeholder="Hoặc dán link/path">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Banner (upload hoặc link)</label>
                                            <input type="file" class="form-control mb-2" name="banner">
                                            <input class="form-control" name="banner" value="{{ $row->banner }}" placeholder="Hoặc dán link/path">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Ngày đăng</label>
                                            <input type="datetime-local" class="form-control" name="posted_at"
                                                   value="{{ $row->posted_at ? \Carbon\Carbon::parse($row->posted_at)->format('Y-m-d\TH:i') : '' }}">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Status</label>
                                            <select class="form-control" name="status">
                                                <option value="1" {{ $row->status==1?'selected':'' }}>Hiện</option>
                                                <option value="0" {{ $row->status==0?'selected':'' }}>Ẩn</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Nội dung (CKEditor)</label>
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
        <form action="{{ route('catalog_v1.diseases.items.store',$category->id) }}" method="post" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title">Thêm bệnh</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label">Tiêu đề</label>
                    <input class="form-control" name="title" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Mô tả ngắn</label>
                    <textarea class="form-control" name="short_description" style="height:120px"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Avatar (upload hoặc link)</label>
                        <input type="file" class="form-control mb-2" name="avatar">
                        <input class="form-control" name="avatar" placeholder="Hoặc dán link/path">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Banner (upload hoặc link)</label>
                        <input type="file" class="form-control mb-2" name="banner">
                        <input class="form-control" name="banner" placeholder="Hoặc dán link/path">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Ngày đăng</label>
                        <input type="datetime-local" class="form-control" name="posted_at" value="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status">
                            <option value="1" selected>Hiện</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label">Nội dung (CKEditor)</label>
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