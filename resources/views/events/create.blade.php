@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Tạo sự kiện</h4>
            </div>
            <div class="card-body">
                <form action="{{route('events.store')}}" method="post" class="w-100" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label>Tiêu đề</label>
                        <input name="title" class="form-control" required>
                    </div>
                    <div class="form-group mb-4">
                        <label>Hình ảnh</label>
                        <input name="images[]" class="form-control" type="file" accept="image/*" multiple required>
                    </div>
                    <div class="form-group mb-4">
                        <label>Thời gian bắt đầu</label>
                        <input name="start_date" class="form-control" type="date" required>
                    </div>
                    <div class="form-group mb-4">
                        <label>Thời gian kết thúc</label>
                        <input name="end_date" class="form-control" type="date" required>
                    </div>
                    <div class="form-group mb-4">
                        <label>Mô tả</label>
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
