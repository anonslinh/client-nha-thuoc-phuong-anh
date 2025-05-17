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
                <form action="{{route('customer')}}" method="get" class="d-flex">
                    <div class="col-md-3" style="margin-right: 15px">
                        <input name="key_search" class="form-control"
                               placeholder="Tìm theo tên, số điện thoại ..."
                               value="{{request()->get('key_search')}}"
                        >
                    </div>
                    <div class="col-md-2" style="margin-right: 15px">
                        <select name="status" class="form-control">
                            <option value="">Sắp xếp theo</option>
                            <option value="total_invoiced" @if(request()->get('sort') == 'total_invoiced') selected @endif>Tổng đơn hàng</option>
                            <option value="total_point" @if(request()->get('sort') == 'total_point') selected @endif>Tổng điểm</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                    <a href="{{route('customer')}}" style="margin-right: 15px" class="btn btn-danger">Hủy</a>
                    <a href="{{route('customer.export')}}" class="btn btn-warning">Xuất Excel</a>
                </form>
                <table class="table table-bordered mt-4">
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
                                    <span>{{$value->code}}</span><br>
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
                        <tr>
                            <td colspan="6">
                                <p class="m-0 text-center text-danger">Không có dữ liệu</p>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
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
                    <div class="form-group" style="min-height: 300px">
                        <label class="mb-2">Quà tặng</label>
                        <select class="form-control selectpicker" name="gift_id" data-live-search="true" title="Chọn quà tặng">
                            @foreach ($listGift as $gift)
                                <option data-tokens="{{$gift->name}}" value="{{$gift->id}}">{{$gift->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="min-height: 250px">
                        <label class="mb-2">Chi nhánh</label>
                        <select class="form-control selectpicker" name="branch_id" data-live-search="true" title="Chọn chi nhánh">
                            @foreach ($branch as $item)
                                <option data-tokens="{{$item->branch_name}}" value="{{$item->id}}">{{$item->branch_name}}</option>
                            @endforeach
                        </select>
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
            $("#customer-gift-exchange").modal("show");
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
        })
    });
</script>
@endsection