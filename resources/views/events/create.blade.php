@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Tạo sự kiện</h4>
            </div>
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{session('error')}}
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{session('success')}}
                </div>
            @endif
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
