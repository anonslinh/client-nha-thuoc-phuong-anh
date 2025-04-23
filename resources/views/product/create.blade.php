@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Thêm sản phẩm</h4>
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
                <form action="{{route('product_gift.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tên </label>
                        <input class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mã Sản phẩm <span class="text-danger">(Vui lòng điền đúng mã với kiotviet)</span></label>
                        <input class="form-control" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thương hiệu <span class="text-danger">(Bỏ qua nếu không có)</span></label>
                        <input class="form-control" name="trademark">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá bán</label>
                        <input class="form-control" name="price" type="number">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hình ảnh(Tỷ lệ 1:1 1000x1000px)</label>
                        <input class="form-control" type="file" accept="image/png" name="image[]" multiple required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Điểm quy đổi</label>
                        <select class="form-control" name="point" required>
                            @foreach($point as $item)
                                <option value="{{$item}}">SP tích {{$item}} điểm</option>
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
    <script>
        $(document).ready(function () {
            $('.btnAddAll').click(function () {
                var quantity = $('input[name="quantity_setup"]').val();
                if (quantity === '' || parseInt(quantity) < 1){
                    Swal.fire(
                        "Thất bại",
                        "Vui lòng điền số lương quà tặng",
                        "error"
                    );
                }else{
                    $("tbody tr").each(function () {
                        var input = $(this).find(".quantity");
                        input.val(quantity);
                    });
                }
            });
        });
    </script>
@endsection
