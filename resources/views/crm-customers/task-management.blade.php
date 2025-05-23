@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Chăm sóc khách hàng sau bán theo mã sản phẩm</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @if($listData) <label>Kết quả tìm kiếm: {{$listData->total()}}</label> @endif
                <form action="{{route('crm-customers.task-management')}}" method="get" class="d-flex">
                    <div class="col-md-2" style="margin-right: 15px">
                        <input name="key_search" class="form-control"
                               placeholder="Tìm theo tên, mã sản phẩm ..."
                               value="{{request()->get('key_search')}}"
                        >
                    </div>
                    <div class="col-md-2" style="margin-right: 15px">
                        <input type="number" name="from_days" class="form-control"
                               placeholder="Mua từ"
                               value="{{request()->get('from_days')}}"
                        >
                    </div>
                    <div class="col-md-2" style="margin-right: 15px">
                        <input type="number" name="to_days" class="form-control"
                               placeholder="Đến ngày"
                               value="{{request()->get('to_days')}}"
                        >
                    </div>
                    <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                    <a href="{{route('crm-customers.task-management')}}" style="margin-right: 15px" class="btn btn-danger">Hủy</a>
                    <a href="{{ route('crm-customers.export-task-management', ['key_search' => request('key_search'), 'from_days' => request('from_days'), 'to_days' => request('to_days')]) }}"
                       class="btn btn-danger align-self-end">
                        <i class="ti ti-transition-right me-1 fs-4"></i>Xuất Excel</a>
                </form>
                <table class="table table-bordered mt-4">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Sản phẩm</th>
                        <th>Đơn hàng</th>
                        <th>Ngày mua</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($listData && $listData->total() > 0)
                        @foreach($listData as $key => $value)
                            <tr>
                                <td class="align-middle">{{$key + 1}}</td>
                                <td class="align-middle">
                                    <a href="{{route('crm-customers.detail-customer', ['customer_id' => $value->customer_id])}}"><span>{{$value->customer_code}}</span><br></a>
                                    <span>{{$value->customer_name}}</span><br>
                                    <span class="text-info">{{$value->contact_number}}</span><br>
                                </td>
                                <td class="align-middle">
                                    <span>{{$value->product_name}}</span><br>
                                    <span>SKU: {{$value->product_code}}</span><br>
                                </td>
                                <td>
                                    <span>{{$value->branch_name}}</span><br>
                                    <span>{{$value->code}}</span><br>
                                    <span>SL: {{$value->quantity}}</span><br>
                                </td>
                                <td class="align-middle">
                                    <p class="m-0">{{date_format(date_create($value->purchase_date), 'h:s d/m/Y')}}</p>
                                    <span class="text-danger">Đã mua: {{$value->days_since_purchase}} ngày</span>
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
            @if($listData)
                <div class="d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
            @endif
        </div>
    </div>

@endsection
