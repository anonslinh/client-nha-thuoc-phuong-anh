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
                    <a href="{{route('customer')}}" class="btn btn-danger">Hủy</a>
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
                        <input name="point" value="1" required min="1" type="number" class="form-control">
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
@endsection
