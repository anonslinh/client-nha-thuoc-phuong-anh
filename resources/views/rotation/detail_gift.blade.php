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
                <form action="{{route('rotation.update-gift',$gift->id)}}" method="post" class="w-100" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Tên quà:</label>
                        <input type="text" class="form-control" value="{{$gift->title}}" name="title"/>
                    </div>
                    <div class="mb-3">
                        <label for="link" class="form-label">Mã quà:</label>
                        <input type="text" class="form-control" value="{{$gift->code}}" name="code" required/>
                    </div>
                    <div class="mb-3">
                        <label for="link" class="form-label">Hình ảnh:</label>
                        <img src="{{$gift->image}}" style="width: 150px;margin-bottom: 10px">
                        <input type="file" accept="image/*" class="form-control" name="image"/>
                    </div>
                    <div class="mb-3">
                        <label for="link" class="form-label">Tỷ lệ chúng thưởng: (Lưu ý: Tổng tỉ lệ chúng quà phải là 100%)</label>
                        <input type="number" class="form-control" name="percent" value="{{$gift->percent * 100}}" required/>
                    </div>
                    <div class="mb-3">
                        <label for="link" class="form-label">Nhóm giá trị đơn hàng:</label>
                        <select name="rule_rotation_id" class="form-control" required>
                            @foreach($rule_rotation as $rule)
                                <option value="{{$rule->id}}" @if($rule->id == $gift->rule_rotation_id) selected @endif>{{$rule->money_invoice_1.'-'.$rule->money_invoice_2}}</option>
                            @endforeach
                        </select>
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
                                            <input name="branch[{{$key}}][quantity]" type="number" value="{{$item->quantity_gift}}" class="form-control quantity">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
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
