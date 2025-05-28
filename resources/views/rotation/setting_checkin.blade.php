@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Cài đặt vòng quay checkin</h4>
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
                <form action="{{route('rotation.gift_checkin.create_setting')}}" method="post" class="row">
                    @csrf
                    <div class="col-lg-4 col-12">
                        <label>Tiêu đề</label>
                        <input name="title" value="{{$setting->title??''}}" class="form-control" required>
                    </div>
                    <div class="col-lg-4 col-12">
                        <label>Thời gian bắt đầu</label>
                        <input name="time_start" value="{{$setting->time_start??''}}" type="date" class="form-control" required>
                    </div>
                    <div class="col-lg-4 col-12">
                        <label>Thời gian kết thúc</label>
                        <input name="time_end" value="{{$setting->time_end??''}}" type="date" class="form-control" required>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="d-flex align-items-center">
                            <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-success d-flex align-items-center" style="margin-right: 15px">
                                <i class="ti ti-send fs-4 me-2"></i>
                                Cập nhật
                            </button>
                            <a class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-danger d-flex align-items-center btn-sa-confirm"
                                href="{{route('rotation.delete')}}">
                                <i class="ti ti-send fs-4 me-2"></i>
                                Xóa Qùa Tặng
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Cài đặt giao diện vòng quay checkin</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-body py-3 table-responsive">
            <table class="table table-border text-nowrap">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Backgroup</th>
                        <th>Ảnh vòng quay</th>
                        <th>Màu nút button</th>
                        <th>Màu ô quà tặng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img src="{{$setting->logo??''}}" style="width: 150px"/>
                        </td>
                        <td>
                            <img src="{{$setting->background??''}}" style="width: 150px"/>
                        </td>
                        <td>
                            <img src="{{$setting->rotation??''}}" style="width: 150px"/>
                        </td>
                        <td>
                            <button class="btn" style="background: {{$setting->color_button??''}}"></button>
                        </td>
                        <td>
                            <button class="btn" style="background: {{$setting->color_gift??''}}"></button>
                        </td>
                        <td>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCreate">Cập nhật</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modalCreate" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Cập nhật giao diện vòng quay
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('rotation.gift_checkin.create_setting')}}" method="post" class="modal-content" enctype="multipart/form-data">
                    @csrf
                    <input name="title" value="{{$setting->title??''}}" hidden/>
                    <input name="time_start" value="{{$setting->time_start??''}}" hidden/>
                    <input name="time_end" value="{{$setting->time_end??''}}" hidden/>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label class="form-label">Logo(Tỷ lệ 2:1 1200x600px)</label>
                            <input class="form-control" type="file" accept="image/*" name="logo">
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Ảnh nền (Tỷ lệ như màn hình điện thoại)</label>
                            <input class="form-control" type="file" accept="image/*" name="background">
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Ảnh vòng quay</label>
                            <input class="form-control" type="file" accept="image/*" name="rotation">
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Màu nút button</label>
                            <input class="form-control" type="color" value="{{$interface_rotation->color_button??''}}" name="color_button">
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Màu ô quà tặng</label>
                            <input class="form-control" type="color" value="{{$interface_rotation->color_gift??''}}" name="color_gift">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button class="btn btn-primary">Xác nhận</button>
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
        var html = '<div class="col-lg-6 col-12 mt-2 item-rule">\n' +
            '                                <div class="row">\n' +
            '                                    <div class="col-6">\n' +
            '                                        <label>Giá trị đơn hàng từ (vnđ)</label>\n' +
            '                                        <input name="data[1][money_invoice_1]" type="number" class="form-control money_invoice_1" required value="0">\n' +
            '                                    </div>\n' +
            '                                    <div class="col-6">\n' +
            '                                        <label>Giá trị đơn hàng đến (vnđ)</label>\n' +
            '                                        <input name="data[1][money_invoice_2]" type="number" class="form-control money_invoice_2" required>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                            </div>';
        $(".btnAddRule").click(function () {
            $(".list-rule").append(html);
            updateNameMoneyInvoice();
        });
        function updateNameMoneyInvoice() {
            for (var i = 0 ; i < $(".list-rule .item-rule").length; i++){
                var name_money_1 = 'data['+i+'][money_invoice_1]';
                var name_money_2 = 'data['+i+'][money_invoice_2]';
                $(".list-rule .item-rule").eq(i).find(".money_invoice_1").attr('name', name_money_1);
                $(".list-rule .item-rule").eq(i).find(".money_invoice_2").attr('name', name_money_2);
            }
        }
    </script>
@endsection
