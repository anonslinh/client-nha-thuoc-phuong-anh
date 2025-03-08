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
                <form action="{{route('events.gift.update',$gift->id)}}" method="post" class="w-100" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tên</label>
                        <input class="form-control" value="{{$gift->name}}" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mã</label>
                        <input class="form-control" value="{{$gift->code}}" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hình ảnh</label>
                        <input class="form-control" type="file" accept="image/png" name="image">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Điểm quy đổi</label>
                        <input class="form-control" value="{{$gift->point}}" name="point" type="number" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cấu hình theo chi nhánh:</label>
                        <div class="list-branch">
                            <div class="d-flex align-items-center" style="margin-bottom: 15px">
                                <input class="form-control" name="quantity_setup" placeholder="Số lương quà tặng" type="number" style="max-width: 250px;margin-right: 15px">
                                <button class="btn btn-primary btnAddAll" type="button">Áp dụng cho tất cả</button>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên chi nhánh</th>
                                    <th>Địa chỉ</th>
                                    <th>Số lượng quà</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listBranch as $key => $item)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$item->branch_name}}</td>
                                        <td>{{$item->address.'-'.$item->ward_name.'-'.$item->location_name}}</td>
                                        <td>
                                            <input name="branch[{{$key}}][id]" value="{{$item->id}}" hidden>
                                            <input name="branch[{{$key}}][quantity]" type="number" value="{{$item->quantity}}" class="form-control quantity">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea id="mymce" name="description" class="form-control" rows="4">{{$gift->description}}</textarea>
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
