@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <h4 class="mb-0 card-title">Bệnh theo mùa</h4>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCreate">
                <i class="ti ti-plus me-1"></i> Thêm hạng mục
            </button>
        </div>
        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('catalog_v1.season_disease_categories.index') }}" method="get" class="row">
                <div class="col-md-4 mb-2">
                    <input name="key_search" class="form-control" placeholder="Tìm theo tên hạng mục..."
                           value="{{ request('key_search') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
                    <a href="{{ route('catalog_v1.season_disease_categories.index') }}" class="btn btn-danger">Hủy</a>
                </div>
            </form>

            <div class="row mt-3">
                @forelse($listData as $row)
                    @php
                        $avatar = $row->avatar ? (\Illuminate\Support\Str::startsWith($row->avatar,'http') ? $row->avatar : asset($row->avatar)) : null;
                        $banner = $row->banner ? (\Illuminate\Support\Str::startsWith($row->banner,'http') ? $row->banner : asset($row->banner)) : null;
                        $count = $countMap[$row->id] ?? 0;
                    @endphp

                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm h-100 border-0" style="border-radius:18px; overflow:hidden;">
                            @if($banner)
                                <img src="{{ $banner }}" style="width:100%; height:160px; object-fit:cover;">
                            @else
                                <div style="height:160px; background:linear-gradient(90deg,#67d5ec,#42b6d0);"></div>
                            @endif

                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    @if($avatar)
                                        <img src="{{ $avatar }}" style="width:56px;height:56px;border-radius:50%;object-fit:cover;">
                                    @endif
                                    <div>
                                        <h5 class="mb-1">{{ $row->name }}</h5>
                                        <div class="small text-muted">Sort: {{ $row->sort_order }} | SP: {{ $count }}</div>
                                    </div>
                                </div>

                                <p class="text-muted mb-3" style="min-height:48px;">{{ $row->description }}</p>

                                <div class="mb-3">
                                    <span class="badge {{ $row->status==1?'bg-success':'bg-danger' }}">{{ $row->status==1?'Hiện':'Ẩn' }}</span>
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('catalog_v1.season_disease_categories.attach.page',$row->id) }}" class="btn btn-info btn-sm">Thêm sản phẩm</a>
                                    <a href="{{ route('catalog_v1.season_disease_categories.products',$row->id) }}" class="btn btn-primary btn-sm">DS sản phẩm</a>
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$row->id}}">Sửa</button>
                                    <a href="{{ route('catalog_v1.season_disease_categories.destroy',$row->id) }}" class="btn btn-danger btn-sm btn-sa-confirm">Xóa</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Update modal --}}
                    <div class="modal fade" id="modalUpdate{{$row->id}}" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                            <form action="{{ route('catalog_v1.season_disease_categories.update',$row->id) }}" method="post" class="modal-content" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title">Cập nhật hạng mục bệnh theo mùa</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Tên hạng mục</label>
                                            <input class="form-control" name="name" value="{{ $row->name }}">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Sort order</label>
                                            <input class="form-control" name="sort_order" value="{{ $row->sort_order }}" required>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Status</label>
                                            <select class="form-control" name="status">
                                                <option value="1" {{ $row->status==1?'selected':'' }}>Hiện</option>
                                                <option value="0" {{ $row->status==0?'selected':'' }}>Ẩn</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Mô tả ngắn</label>
                                        <textarea class="form-control" name="description" style="height:120px">{{ $row->description }}</textarea>
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

                                    <div class="mb-2">
                                        <label class="form-label">Content (CKEditor)</label>
                                        <textarea class="form-control ckeditor-area" name="content" style="height:260px">{{ $row->content }}</textarea>
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
                        <p class="text-center text-danger m-0">Không có dữ liệu</p>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center">
                {{ $listData->appends(request()->all())->links('pagination') }}
            </div>
        </div>
    </div>
</div>

{{-- Create modal --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <form action="{{ route('catalog_v1.season_disease_categories.store') }}" method="post" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title">Thêm hạng mục bệnh theo mùa</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Tên hạng mục</label>
                        <input class="form-control" name="name">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Sort order</label>
                        <input class="form-control" name="sort_order" value="0" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status">
                            <option value="1" selected>Hiện</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label">Mô tả ngắn</label>
                    <textarea class="form-control" name="description" style="height:120px"></textarea>
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

                <div class="mb-2">
                    <label class="form-label">Content (CKEditor)</label>
                    <textarea class="form-control ckeditor-area" name="content" style="height:260px"></textarea>
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