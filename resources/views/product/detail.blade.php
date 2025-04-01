@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Chi tiết sản phẩm</h4>
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
                <form action="{{route('events.update-product',$product->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tên </label>
                        <input class="form-control" name="name" value="{{$product->name}}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mã Sản phẩm <span class="text-danger">(Vui lòng điền đúng mã với kiotviet)</span></label>
                        <input class="form-control" name="code" value="{{$product->code}}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thương hiệu <span class="text-danger">(Bỏ qua nếu không có)</span></label>
                        <input class="form-control" name="trademark" value="{{$product->trademark}}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá bán</label>
                        <input class="form-control" name="price" value="{{$product->price}}" type="number">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hình ảnh</label>
                        <div class="row list-image">
                            @foreach($product['image'] as $k => $image)
                                <div class="col-3 mb-2 position-relative item-image">
                                    <input name="image_product[{{$k}}]" hidden value="{{$image}}" class="image-product">
                                    <button class="position-absolute delete-image p-0 bg-transparent d-flex justify-content-center align-items-center border-0 text-danger" style="width: 20px; height: 20px; top: 10px;right: 10px">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                    </button>
                                    <img src="{{$image}}" class="w-100">
                                </div>
                            @endforeach
                        </div>
                        <input class="form-control" type="file" accept="image/png" name="image[]" multiple>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Điểm quy đổi</label>
                        <select class="form-control" name="point" required>
                            @foreach($point as $item)
                                <option value="{{$item}}" @if($item == $product->point) selected @endif>SP tích {{$item}} điểm</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea id="mymce" name="description" class="form-control" rows="4">{!! $product->description !!}</textarea>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-primary">Cập nhật </button>
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
            $("button.delete-image").click(function () {
                $(this).parent().remove();
                let index = 0;
                for (var i = 0 ; i < $(".list-image .item-image").length; i++){
                    var name = 'image_product['+index+']';
                    $(".list-image .item-image").eq(i).find('input.image-product').attr('name', name);
                }
            });
        });
    </script>
@endsection
