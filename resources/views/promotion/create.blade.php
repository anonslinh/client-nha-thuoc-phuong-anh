@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Thêm mới khuyến mại</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a class="text-muted text-decoration-none d-flex">
                                        <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{route('promotion.store')}}" method="post" class="w-100" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">Tiêu đề</label>
                        <input name="title" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Hình ảnh(Tỷ lệ 2:1 2000x1000)</label>
                        <input name="image_path" class="form-control" type="file" accept="image/*" multiple required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Link chuyển hướng (Không bắt buộc)</label>
                        <input name="join_link" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Thời gian bắt đầu</label>
                        <input name="start_date" class="form-control" type="date" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Thời gian kết thúc</label>
                        <input name="end_date" class="form-control" type="date" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Mô tả ngắn</label>
                        <textarea name="sub_title" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea id="mymce" name="description"></textarea>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-primary">Tạo mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="assets/libs/tinymce/tinymce.min.js"></script>
    <script src="assets/js/forms/tinymce-init.js"></script>
@endsection
