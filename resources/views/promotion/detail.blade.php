@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h4>Cập nhật khuyến mại: {{$promotion->title}}</h4></div>
            <div class="card-body">
                <form action="{{route('promotion.update',$promotion->id)}}" method="post" class="w-100" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">Tiêu đề</label>
                        <input name="title" value="{{$promotion->title}}" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label d-block">Hình ảnh</label>
                        <input name="image_path" class="form-control" type="file" accept="image/*">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Link chuyển hướng (Không bắt buộc)</label>
                        <input name="join_link" value="{{$promotion->join_link}}" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Thời gian bắt đầu</label>
                        <input name="start_date" value="{{date_format(date_create($promotion->start_date), 'Y-m-d')}}" class="form-control" type="date" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Thời gian kết thúc</label>
                        <input name="end_date" value="{{date_format(date_create($promotion->end_date), 'Y-m-d')}}" class="form-control" type="date" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Mô tả ngắn</label>
                        <textarea name="sub_title" class="form-control" rows="4" required>{{$promotion->sub_title}}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea id="mymce" name="description">{!! $promotion->description !!}</textarea>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-primary">Cập nhật</button>
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
