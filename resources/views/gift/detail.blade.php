@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Cài quà tặng</h4>
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
                <form action="{{route('gift.update',$value->id)}}" method="post" class="w-100" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <label>Tên</label>
                        <input class="form-control" value="{{$value->name}}" name="name" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Mã</label>
                        <input class="form-control" value="{{$value->code}}" name="code" required>
                    </div>
                    <div class="form-group mb-2">
                        <label class="d-block">Hình ảnh</label>
                        <img src="{{$value->image}}" style="width: 200px;margin: 10px 0">
                        <input class="form-control" type="file" accept="image/png" name="image">
                    </div>
                    <div class="form-group mb-2">
                        <label>Điểm quy đổi</label>
                        <input class="form-control" value="{{$value->points_required}}" name="point" type="number" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Hạng thẻ</label>
                        <select name="rank_id" class="form-control">
                            <option value="">Không áp dụng</option>
                            @foreach($rank as $rankItem)
                                <option value="{{$rankItem->id}}" @if($rankItem->id == $value->rank_id) selected @endif>{{$rankItem->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label>Mô tả</label>
                        <textarea id="mymce" name="description" class="form-control" rows="4">{{$value->description}}</textarea>
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
