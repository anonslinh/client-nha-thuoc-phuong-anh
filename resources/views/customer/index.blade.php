@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Danh sách khách hàng</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-danger d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#vertical-center-scroll-modal">
                                        <i class="ti ti-send fs-4 me-2"></i>
                                        Cộng điểm cho khách hàng
                                    </button>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{route('customer')}}" method="get" class="row">
                    <div class="col-md-3 mb-2">
                        <input name="key_search" class="form-control"
                               placeholder="Tìm theo tên, số điện thoại ..."
                               value="{{request()->get('key_search')}}"
                        >
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="status" class="form-control">
                            <option value="">Sắp xếp theo</option>
                            <option value="total_invoiced" @if(request()->get('sort') == 'total_invoiced') selected @endif>Tổng đơn hàng</option>
                            <option value="total_point" @if(request()->get('sort') == 'total_point') selected @endif>Tổng điểm</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                        <a href="{{route('customer')}}" style="margin-right: 15px" class="btn btn-danger">Hủy</a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-info mb-2" type="button" data-bs-toggle="modal" data-bs-target="#checkPointCustomer">Kiểm tra điểm và đổi quà hộ</button>
                        <a href="{{route('customer.export')}}" class="btn btn-warning" style="margin-right: 15px">Xuất Excel</a>
                    </div>
                </form>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Khách hàng</th>
                            <th>Tổng chi tiêu</th>
                            <th>Tổng đơn hàng</th>
                            <th>Điểm kiotviet</th>
                            <th>Điểm hệ thống</th>
                            <th>Đổi quà hộ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listData->total() > 0)
                            @foreach($listData as $key => $value)
                                <tr>
                                    <td class="align-middle">{{$key + 1}}</td>
                                    <td class="align-middle">
                                        <a href="{{route('crm-customers.detail-customer', ['customer_id' => $value->kiotviet_id])}}"><span>{{$value->code}}</span></a><br>
                                        <span>{{$value->name}} - {{$value->contact_number}}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span>{{number_format($value->total_revenue)}}đ</span>
                                    </td>
                                    <td class="align-middle">
                                        <p class="m-0">{{$value->total_orders}}</p>
                                    </td>
                                    <td class="align-middle">{{$value->kiotviet_reward_point}}</td>
                                    <td class="align-middle">{{$value->reward_point}}</td>
                                    <td class="align-middle">
                                        <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-danger d-flex align-items-center btnExchangeGift" value="{{$value->id}}">Đổi quà hộ</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                                <td colspan="6">
                                    <p class="m-0 text-center text-danger">Không có dữ liệu</p>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
        </div>
    </div>
    <div class="modal fade" id="vertical-center-scroll-modal" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{route('customer.plus-point')}}" method="post" class="modal-content">
                @csrf
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">Cộng điểm cho khách hàng</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="mb-2">Số điện thoại khách hàng</label>
                        <input name="phone" required class="form-control">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="mb-2">Tên khách hàng (Bỏ qua nếu đã có trên hệ thống)</label>
                        <input name="name" class="form-control">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="mb-2">Số điểm được cộng</label>
                        <input name="point" required type="number" class="form-control">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="mb-2">Ghi chú (Nếu có)</label>
                        <textarea name="note" rows="4" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-start" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button class="btn bg-success text-white  waves-effect text-start">
                        Cộng điểm
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="customer-gift-exchange" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{route('customer.exchange-code')}}" id="giftExchange" method="post" class="modal-content">
                @csrf
                <input name="customer_id" hidden/>
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">Đổi quà hộ cho khách hàng</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="mb-2">Quà tặng</label>
                        <input class="form-control" name="name_gift" placeholder="Nhập tên quà tặng"/>
                        <input name="gift_id" hidden/>
                        <ul class="list mb-0 p-0" style="height: 250px; overflow:auto">
                            @foreach ($listGift as $gift)
                                <li class="p-2 data-item-gift cursor-pointer" data-tokens="{{$gift->name}}" value="{{$gift->id}}">{{$gift->name}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group">
                        <label class="mb-2">Chi nhánh</label>
                        <input class="form-control" name="name_branch" placeholder="Nhập tên chi nhánh"/>
                        <input name="branch_id" hidden/>
                        <ul class="list mb-0 p-0" style="height: 250px; overflow:auto">
                            @foreach ($branch as $item)
                                <li class="p-2 data-item-branch cursor-pointer" data-tokens="{{$item->branch_name}}" value="{{$item->id}}">{{$item->branch_name}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-start" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button class="btn bg-success text-white  waves-effect text-start">
                        Xác nhận
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- // Modal đổi quà hộ cho khách hàng // --}}
    <div class="modal fade" id="checkPointCustomer" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">Kiểm tra điểm cho khách </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="mb-2">Số điện thoại khách hàng</label>
                        <input name="phone" maxlength="10" class="form-control">
                    </div>
                    <div class="form-group">
                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr>
                                    <th>Mã KH</th>
                                    <th>Tên KH</th>
                                    <th>Điểm KH</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="code-customer"></span></td>
                                    <td><span class="name-customer"></span></td>
                                    <td><span class="point-customer"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-start" data-bs-dismiss="modal">
                        Đóng
                    </button>
                    <button class="btn bg-success text-white  waves-effect text-start btnExchangeGift action-exchange-gift d-none">
                        Đổi quà hộ
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function () {
        $('.selectpicker').selectpicker();
        $(".btnExchangeGift").click(function(){
            var customer_id = $(this).val();
            $("#customer-gift-exchange input[name='customer_id']").val(customer_id);
            $("#checkPointCustomer").modal('hide');
            $("#customer-gift-exchange").modal("show");
        });
        $('#checkPointCustomer input[name="phone"]').keyup(function(){
            var length = $(this).val().length;
            if(length == 10){
                $(".loading").addClass('active');
                $.ajax({
                    url: window.location.origin + '/api/reward-point',
                    data:{"phone": $(this).val()},
                    dataType: "json",
                    type: "post",
                    success: function (data){
                        $(".loading").removeClass('active');
                        $("#checkPointCustomer .code-customer").text(data.membership_level.customer_code);
                        $("#checkPointCustomer .name-customer").text(data.membership_level.customer_name);
                        $("#checkPointCustomer .point-customer").text(data.data);
                        if(data.data > 0){
                            $("#checkPointCustomer .btnExchangeGift").val(data.membership_level.customer_id);
                            $("#checkPointCustomer .action-exchange-gift").removeClass('d-none');
                        }else{
                            $("#checkPointCustomer .action-exchange-gift").addClass('d-none');
                        }
                    }
                })
            }
        });
        $("#giftExchange").submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "post",
                data: $(this).serialize(),
                dataType: "json",
                success: function (data){
                    $("#customer-gift-exchange").modal("hide");
                    if(data.status){
                        Swal.fire({
                            type: "success",
                            title: data.msg,
                            text: "Mã đổi quà là: "+ data.exchange_code
                        });
                    }else{
                        Swal.fire({
                            type: "error",
                            title: "Đổi quà thất bại",
                            text: data.msg
                        });
                    }
                }
            })
        });
        $("#customer-gift-exchange input[name='name_gift']").on("keyup", function(){
            var searchText = $(this).val().toLowerCase();
            $(".data-item-gift").each(function(){
                var productName = $(this).attr('data-tokens').toLowerCase();
                $(this).toggle(productName.includes(searchText));
            });
        });
        $("#customer-gift-exchange input[name='name_branch']").on("keyup", function(){
            var searchText = $(this).val().toLowerCase();
            $(".data-item-branch").each(function(){
                var productName = $(this).attr('data-tokens').toLowerCase();
                $(this).toggle(productName.includes(searchText));
            });
        });
        $(".data-item-gift").click(function(){
            var id = $(this).attr('value');
            var name = $(this).attr('data-tokens');
            $("#customer-gift-exchange input[name='name_gift']").val(name);
            $("#customer-gift-exchange input[name='gift_id']").val(id);
        });
        $(".data-item-branch").click(function(){
            var id = $(this).attr('value');
            var name = $(this).attr('data-tokens');
            $("#customer-gift-exchange input[name='name_branch']").val(name);
            $("#customer-gift-exchange input[name='branch_id']").val(id);
        });
    });
</script>
@endsection
