@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h4>Cập nhật chương trình: {{$program->title}}</h4></div>
            <div class="card-body">
                <form action="{{route('program.update',$program->id)}}" method="post" class="w-100" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">Tiêu đề</label>
                        <input name="title" value="{{$program->title}}" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Poster(Tỷ lệ 2:1 2000x1000)</label>
                        <input name="thumbnail" class="form-control" type="file" accept="image/*">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label d-block">Hình ảnh(Tỷ lệ 1:1 1000x1000)</label>
                        <div class="d-flex flex-wrap" style="margin: 10px 0">
                            @foreach($program->images as $value)
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
                    <div class="form-group mb-3">
                        <label class="form-label">Link chuyển hướng (Không bắt buộc)</label>
                        <input name="join_link" value="{{$program->join_link}}" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Chi nhánh</label>
                        <select name="branch_id" class="form-control">
                            <option value="">Áp dụng cho tất cả chi nhánh</option>
                            @foreach($branches as $branch)
                                <option @if($branch->kiotviet_id == $program->branch_id) selected @endif value="{{$branch->kiotviet_id}}">{{$branch->branch_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Thời gian bắt đầu</label>
                        <input name="start_date" value="{{date_format(date_create($program->start_date), 'Y-m-d')}}" class="form-control" type="date" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Thời gian kết thúc</label>
                        <input name="end_date" class="form-control" value="{{date_format(date_create($program->end_date), 'Y-m-d')}}" type="date" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea id="mymce" name="description">{!! $program->description !!}</textarea>
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
