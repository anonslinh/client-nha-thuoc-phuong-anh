@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Cập nhật sự kiện</h4>
            </div>
            <div class="card-body">
                <form action="{{route('events.update',$events->id)}}" method="post" class="w-100" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label>Tiêu đề</label>
                        <input name="title" value="{{$events->title}}" class="form-control" required>
                    </div>
                    <div class="form-group mb-4">
                        <label>Hình ảnh</label>
                        <div class="d-flex flex-wrap" style="margin: 10px 0">
                            @foreach($events->images as $value)
                                <div class="position-relative" style="margin-right: 15px;margin-bottom: 15px">
                                    <button class="bg-transparent p-0 position-absolute border-0 btn-delete-image" type="button" value="{{$value}}" style="top: 0;right: 0;z-index: 10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#B8000B" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                                        </svg>
                                    </button>
                                    <img src="{{$value}}" style="width: 150px">
                                </div>
                            @endforeach
                        </div>
                        <input name="image_delete" hidden id="imageDeleteInput">
                        <input name="images[]" class="form-control" type="file" accept="image/*" multiple>
                    </div>
                    <div class="form-group mb-4">
                        <label>Thời gian bắt đầu</label>
                        <input name="start_date" class="form-control" value="{{$events->time_start}}" type="date" required>
                    </div>
                    <div class="form-group mb-4">
                        <label>Thời gian kết thúc</label>
                        <input name="end_date" class="form-control" value="{{$events->time_end}}" type="date" required>
                    </div>
                    <div class="form-group mb-4">
                        <label>Mô tả</label>
                        <textarea id="mymce" name="description">{!! $events->description !!}</textarea>
                    </div>
                    <div class="d-flex">
                        <a href="{{route('events.list-data')}}" class="btn btn-warning" style="margin-right: 15px">Quay lại</a>
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
    <script>
        $(document).ready(function () {
            $(".btn-delete-image").click(function () {
                var input = document.getElementById("imageDeleteInput");
                let imageId = $(this).val();
                let values = input.value ? input.value.split(",") : [];

                if (!values.includes(imageId.toString())) {
                    values.push(imageId);
                }

                input.value = values.join(",");
                $(this).parent().remove();
            });
        });
    </script>
@endsection
