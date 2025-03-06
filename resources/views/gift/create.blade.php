@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Thêm quà tặng</h4>
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
                <form action="{{route('gift.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tên</label>
                        <input class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mã</label>
                        <input class="form-control" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hình ảnh</label>
                        <input class="form-control" type="file" accept="image/png" name="image" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Điểm quy đổi</label>
                        <input class="form-control" name="point" type="number" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hạng thẻ</label>
                        <select name="rank_id" class="form-control">
                            <option value="">Áp dụng cho tất cả hạng thẻ</option>
                            @foreach($rank as $rankItem)
                                <option value="{{$rankItem->id}}">{{$rankItem->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea id="mymce" name="description" class="form-control" rows="4"></textarea>
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
