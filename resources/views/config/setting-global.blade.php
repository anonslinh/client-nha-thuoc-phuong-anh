@extends('Layout.index')
@section('style')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round2 {
            border-radius: 34px;
        }

        .slider.round2:before {
            border-radius: 50%;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Cài đặt chung</h4>
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
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $index = 1; @endphp
                    @foreach($listData as $key => $item)
                        @php $index += 1; @endphp
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item->title}}</td>
                            <td>{{$item->comment}}</td>
                            <td>
                                <button type="button" class="btn mb-1 px-4 fs-4  bg-info-subtle text-info" data-bs-toggle="modal" data-bs-target="#contact-modal-{{$item->id}}" data-bs-whatever="@getbootstrap">
                                    Sửa
                                </button>
                                <div class="modal fade" id="contact-modal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel1">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title" id="exampleModalLabel1">
                                                    {{$item->title}}
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{route('config.update-setting-global',$item->id)}}" method="post" enctype="multipart/form-data" class="modal-content">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="recipient-name">Nội dung:</label>
                                                        <input type="text" class="form-control" name="comment" value="{{$item->comment}}"/>
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
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>{{$index}}</td>
                        <td>Trả dữ liệu đơn hàng</td>
                        <td>Hệ thống sẽ trả dữ liệu đơn hàng cho khách hàng khi bạn bật tính năng và tự động trả rỗng khi bạn tắt tính năng</td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" name="type_invoice" @if($type_invoice == 1) checked @endif value="2">
                                <span class="slider round2"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>Hình thức tính điểm</td>
                        <td>Tính năng không tính điểm cho khách hàng khi mua hàng có sử dụng mã
                            voucher hoặc giảm giá sản phẩm (Lưu ý: Hình thức này chỉ hoạt động khi ápp dụng <span class="fw-bolder">Tích điểm theo từng sản phẩm</span> )</td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" name="calculator_point" @if($calculator_point == 1) checked @endif>
                                <span class="slider round2"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>{{$index + 2}}</td>
                        <td>Tùy chọn xuất mã QR khi đổi quà</td>
                        <td>Tính năng chọn hình thức xuất mã QR khi đổi quà: Bật khi sử dụng mã lịch sử đổi quà để thuận tiện ghi chú và đối soát kế toán và Tăt khi sử dụng mã sản phẩm để nhân viên bán hàng quét lấy hàng nhanh</td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" name="gift_code" @if($giftCode == 1) checked @endif>
                                <span class="slider round2"></span>
                            </label>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Hình thức tích điểm</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a class="text-muted text-decoration-none d-flex align-items-center">
                                        Thời gian tích điểm:
                                        <input name="time_point" class="form-control" style="max-width: 200px" value="{{date_format(date_create($timePoint), 'Y-m-d H:i:s')}}" type="datetime-local">
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
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Hình thức</th>
                        <th>Mô tả</th>
                        <th>Ví dụ</th>
                        <th>***</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="align-middle">1</td>
                            <td class="align-middle">Tích điểm theo hóa đơn</td>
                            <td class="align-middle">Cộng điểm dựa trên tổng giá trị đơn hàng . Tỷ lệ điểm do shop cài đặt (vd: 1% hoặc 1.000đ = 1 điểm).</td>
                            <td class="align-middle">Khách mua đơn 500.000đ → Tích 1% → Nhận 5 điểm.</td>
                            <td class="align-middle">
                                <label class="switch">
                                    <input type="checkbox" name="type_point" @if($type_point == 1) checked @endif value="1">
                                    <span class="slider round2"></span>
                                </label>
                            </td>
                        </tr>
                    <tr>
                        <td class="align-middle">2</td>
                        <td class="align-middle">Tích điểm theo từng sản phẩm</td>
                        <td class="align-middle">Cộng điểm theo từng sản phẩm. Shop cài đặt số điểm riêng cho mỗi sản phẩm, khách mua sản phẩm nào nhận điểm sản phẩm đó.</td>
                        <td class="align-middle">
                            <p class="m-0">- Sản phẩm A: 10 điểm.</p>
                            <p class="m-0">- Sản phẩm B: 5 điểm.</p>
                            <p class="m-0">Khách mua 2 A + 1 B → Nhận 25 điểm.</p>
                        </td>
                        <td class="align-middle">
                            <label class="switch">
                                <input type="checkbox" name="type_point" @if($type_point == 2) checked @endif value="2">
                                <span class="slider round2"></span>
                            </label>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('input[name="type_point"]').click(function () {
            $('input[name="type_point"]').prop('checked', false);
            $(this).prop('checked', true);
            $.ajax({
                url: "{{route('config.change-type-point')}}",
                type: "post",
                data: {"value" : $(this).val()},
                dataType: "json",
                success: function (data) {
                    setTimeout(function () {
                        location.reload();
                    }, 300);
                }
            })
        });
        $('input[name="time_point"]').change(function () {
            $.ajax({
                url: "{{route('config.set-time-point')}}",
                type: "post",
                data: {"value" : $(this).val()},
                dataType: "json",
                success: function (data) {
                    console.log(data);
                }
            })
        });
        $('input[name="type_invoice"]').click(function () {
            var data = {};
            data['type'] = 'invoice';
            setTypeSetting(data);
        });
        $('input[name="calculator_point"]').click(function () {
            var data = {};
            data['type'] = 'calculator_point';
            setTypeSetting(data);
        });
        $('input[name="gift_code"]').click(function () {
            var data = {};
            data['type'] = 'gift_code';
            setTypeSetting(data);
        });
        function setTypeSetting(data) {
            $.ajax({
                url: "{{route('config.set-type-invoice')}}",
                type: "post",
                data: data,
                dataType: "json",
                success: function (data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection
