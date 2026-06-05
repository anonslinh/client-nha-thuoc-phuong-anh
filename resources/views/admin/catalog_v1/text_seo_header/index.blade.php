@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <h4 class="mb-0 card-title">Thông tin nổi bật</h4>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCreate">
                <i class="ti ti-plus me-1"></i> Thêm mới
            </button>
        </div>
        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('catalog_v1.text_seo_header.index') }}" method="get" class="row">
                <div class="col-md-4 mb-2">
                    <input name="key_search" class="form-control" placeholder="Tìm tiêu đề, mô tả..."
                           value="{{ request('key_search') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
                    <a href="{{ route('catalog_v1.text_seo_header.index') }}" class="btn btn-danger">Hủy</a>
                </div>
            </form>

            <div class="row mt-3">
                @forelse($listData as $row)
                    @php
                        $banner = $row->banner ? (\Illuminate\Support\Str::startsWith($row->banner,'http') ? $row->banner : asset($row->banner)) : null;
                        $count = $countMap[$row->id] ?? 0;
                    @endphp

                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="card h-100 shadow-sm border-0" style="border-radius:18px; overflow:hidden;">
                            @if($banner)
                                <img src="{{ $banner }}" style="width:100%; height:180px; object-fit:cover;">
                            @else
                                <div style="height:180px; background:linear-gradient(90deg,#67d5ec,#42b6d0);"></div>
                            @endif

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h5 class="mb-1">{{ $row->seo_title }}</h5>
                                    <span class="badge bg-secondary">Sort: {{ $row->sort_order }}</span>
                                </div>

                                <p class="text-muted mb-3" style="min-height:60px;">
                                    {{ \Illuminate\Support\Str::limit($row->seo_description, 120) }}
                                </p>

                                <div class="mb-3 d-flex flex-wrap gap-2">
                                    <span class="badge {{ $row->has_product_list == 1 ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $row->has_product_list == 1 ? 'Có sản phẩm' : 'Không kèm sản phẩm' }}
                                    </span>

                                    @if($row->has_product_list == 1)
                                        <span class="badge bg-primary">SP: {{ $count }}</span>
                                    @endif
                                </div>

                                @if($row->see_more_link)
                                    <div class="small text-primary mb-3">
                                        Link: {{ \Illuminate\Support\Str::limit($row->see_more_link, 50) }}
                                    </div>
                                @endif

                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('catalog_v1.text_seo_header.show',$row->id) }}" target="_blank" class="btn btn-primary btn-sm">
                                        Xem chi tiết
                                    </a>

                                    @if($row->has_product_list == 1)
                                        <a href="{{ route('catalog_v1.text_seo_header.products',$row->id) }}" class="btn btn-info btn-sm">
                                            Sản phẩm
                                        </a>
                                    @endif

                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$row->id}}">
                                        Sửa
                                    </button>

                                    <a href="{{ route('catalog_v1.text_seo_header.destroy',$row->id) }}" class="btn btn-danger btn-sm btn-sa-confirm">
                                        Xóa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalUpdate{{$row->id}}" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                            <form action="{{ route('catalog_v1.text_seo_header.update',$row->id) }}" method="post" class="modal-content" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title">Cập nhật thông tin nổi bật</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label class="form-label">Tiêu đề</label>
                                        <input class="form-control" name="seo_title" value="{{ $row->seo_title }}" required>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Mô tả ngắn</label>
                                        <textarea class="form-control" name="seo_description" style="height:120px">{{ $row->seo_description }}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">Có kèm danh sách sản phẩm?</label>
                                            <select class="form-control" name="has_product_list">
                                                <option value="0" {{ $row->has_product_list == 0 ? 'selected' : '' }}>Không</option>
                                                <option value="1" {{ $row->has_product_list == 1 ? 'selected' : '' }}>Có</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">Sort order</label>
                                            <input class="form-control" name="sort_order" value="{{ $row->sort_order }}" required>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">Link xem thêm</label>
                                            <input class="form-control" name="see_more_link" value="{{ $row->see_more_link }}">
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Banner (upload hoặc link)</label>
                                        <input type="file" class="form-control mb-2" name="banner">
                                        <input class="form-control" name="banner" value="{{ $row->banner }}" placeholder="Hoặc dán link/path">
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Thông tin bài viết (CKEditor)</label>
                                        <textarea class="form-control ckeditor-area" name="article_content" style="height:300px">{{ $row->article_content }}</textarea>
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
        <form action="{{ route('catalog_v1.text_seo_header.store') }}" method="post" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title">Thêm thông tin nổi bật</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label">Tiêu đề</label>
                    <input class="form-control" name="seo_title" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Mô tả ngắn</label>
                    <textarea class="form-control" name="seo_description" style="height:120px"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Có kèm danh sách sản phẩm?</label>
                        <select class="form-control" name="has_product_list">
                            <option value="0" selected>Không</option>
                            <option value="1">Có</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Sort order</label>
                        <input class="form-control" name="sort_order" value="0" required>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Link xem thêm</label>
                        <input class="form-control" name="see_more_link" placeholder="https://...">
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label">Banner (upload hoặc link)</label>
                    <input type="file" class="form-control mb-2" name="banner">
                    <input class="form-control" name="banner" placeholder="Hoặc dán link/path">
                </div>

                <div class="mb-2">
                    <label class="form-label">Thông tin bài viết (CKEditor)</label>
                    <textarea class="form-control ckeditor-area" name="article_content" style="height:300px"></textarea>
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