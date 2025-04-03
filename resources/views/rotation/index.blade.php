@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Cài đặt vòng quay may mắn</h4>
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
                <form action="{{route('rotation.create')}}" method="post" class="row">
                    @csrf
                    <div class="col-lg-4 col-12">
                        <label>Tiêu đề</label>
                        <input name="title" value="{{$rotation->title??''}}" class="form-control" required>
                    </div>
                    <div class="col-lg-4 col-12">
                        <label>Thời gian bắt đầu</label>
                        <input name="time_start" value="{{$rotation->time_start??''}}" type="date" class="form-control" required>
                    </div>
                    <div class="col-lg-4 col-12">
                        <label>Thời gian kết thúc</label>
                        <input name="time_end" value="{{$rotation->time_end??''}}" type="date" class="form-control" required>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="d-flex align-items-center">
                            <p class="mb-0 text-success fw-bolder" style="margin-right: 15px">Cấu hình giá trị đơn hàng: </p>
                            <button type="button" class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-danger d-flex align-items-center btnAddRule">
                                <i class="ti ti-send fs-4 me-2"></i>
                                Thêm giá trị đơn hàng
                            </button>
                        </div>
                        <div class="list-rule row mt-4">
                            @if(count($dataRule))
                                @foreach($dataRule as $key => $value)
                                    <div class="col-lg-6 col-12 item-rule">
                                        <input name="data[{{$key}}][rule_id]" hidden value="{{$value->id}}"/>
                                        <div class="row">
                                            <div class="col-6">
                                                <label>Giá trị đơn hàng từ (vnđ)</label>
                                                <input name="data[{{$key}}][money_invoice_1]" type="number" class="form-control money_invoice_1" required value="{{$value->money_invoice_1}}">
                                            </div>
                                            <div class="col-6">
                                                <label>Giá trị đơn hàng đến (vnđ)</label>
                                                <input name="data[{{$key}}][money_invoice_2]" type="number" class="form-control money_invoice_2" required value="{{$value->money_invoice_2}}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                <div class="col-lg-6 col-12 item-rule">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Giá trị đơn hàng từ (vnđ)</label>
                                            <input name="data[0][money_invoice_1]" type="number" class="form-control money_invoice_1" value="0">
                                        </div>
                                        <div class="col-6">
                                            <label>Giá trị đơn hàng đến (vnđ)</label>
                                            <input name="data[0][money_invoice_2]" type="number" class="form-control money_invoice_2" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 item-rule">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Giá trị đơn hàng từ (vnđ)</label>
                                            <input name="data[1][money_invoice_1]" type="number" class="form-control money_invoice_1" required value="0">
                                        </div>
                                        <div class="col-6">
                                            <label>Giá trị đơn hàng đến (vnđ)</label>
                                            <input name="data[1][money_invoice_2]" type="number" class="form-control money_invoice_2" required>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <p class="text-center mt-3">Ví dụ: Bạn đang có chương trình vòng quay cho khách hàng đơn từ 300k trở xuống và đơn trên 300k.
                            Bạn điền vào các ô lần lượt từ trái qua phải là: 0 - 300000 ; 300001 - số bất kỳ lớn hơn 300001  </p>
                    </div>
                    <div class="col-12">
                        <div class="d-flex align-items-center">
                            <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-success d-flex align-items-center" style="margin-right: 15px">
                                <i class="ti ti-send fs-4 me-2"></i>
                                Cập nhật
                            </button>
                            <a class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-danger d-flex align-items-center btn-sa-confirm" href="{{route('rotation.delete')}}">
                                <i class="ti ti-send fs-4 me-2"></i>
                                Reset
                            </a>
                        </div>
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
