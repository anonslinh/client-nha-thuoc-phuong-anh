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
                        <label class="form-label">Hình ảnh(Tỷ lệ 1:1 1000x1000px)</label>
                        <input class="form-control" type="file" accept="image/png" name="image">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Loại quà</label>
                        <select name="type" class="form-control" required>
                            <option value="1" @if($gift->type == 1) selected @endif>Quà tặng</option>
                            <option value="2" @if($gift->type == 2) selected @endif>Voucher</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Điểm quy đổi</label>
                        <input class="form-control" value="{{$gift->point}}" name="point" type="number" min="0" required>
                    </div>
                    <div class="mb-3 data-account @if($gift->type == 1) d-none @endif">
                        <label class="form-label">Mã phát hành voucher theo tài khoản</label>
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên chi nhánh</th>
                                    <th>Mã phát hành</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($account_branches as $key => $value)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$value->code}}</td>
                                        <td>
                                            <input name="voucher[{{$key}}][code]" value="{{$value->code}}" hidden>
                                            <input name="voucher[{{$key}}][release_code]" type="text" value="{{$value->release_code??''}}" class="form-control releaseCode">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                     </div>
                    <div class="mb-3 data-branch @if($gift->type == 2) d-none @endif">
                        <label class="form-label">Cấu hình theo chi nhánh:</label>
                        <div class="list-branch">
                            <div class="row" style="margin-bottom: 15px">
                                <div class="col-md-4 mb-2">
                                    <input class="form-control" name="quantity_setup" placeholder="Số lương quà tặng" type="number">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <button class="btn btn-primary btnAddAll" type="button">Áp dụng cho tất cả</button>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <button class="btn btn-primary btnAddProduct" type="button">Đồng bộ với cửa hàng kiotviet</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
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
                                                <input  value="{{$item->kiotviet_id}}" hidden class="kiotviet_id">
                                                <input name="branch[{{$key}}][id]" value="{{$item->id}}" hidden>
                                                <input name="branch[{{$key}}][quantity]" type="number" value="{{$item->quantity}}" class="form-control quantity">
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
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
            $(".btnAddProduct").click(function () {
                var product_code = $('input[name="code"]').val();
                if (product_code === ''){
                    Swal.fire(
                        "Thất bại",
                        "Vui lòng điền mã quà tặng",
                        "error"
                    );
                }else{
                    $.ajax({
                        url : "{{route('gift.detail-product')}}",
                        data:{'product_code' : product_code},
                        type: "post",
                        dataType: "json",
                        success: function (data) {
                            if(data.status){
                                for (var i = 0; i < data.data.length; i++){
                                    var branchId = data.data[i].branchId;
                                    var quantity = data.data[i].quantity;
                                    $("tbody tr").each(function () {
                                        var kiotviet_id = $(this).find('input.kiotviet_id').val();
                                        if (branchId == kiotviet_id){
                                            $(this).find('input.quantity').val(quantity);
                                        }
                                    });
                                }
                            }
                        }
                    })
                }
            });
            $('select[name="type"]').change(function () {
                var type = $(this).val();
                if (parseInt(type) == 2){
                    $(".data-account").removeClass('d-none');
                    $(".data-branch").addClass('d-none');
                }else{
                    $(".data-account").addClass('d-none');
                    $(".data-branch").removeClass('d-none');
                }
            });
        });
    </script>
@endsection
