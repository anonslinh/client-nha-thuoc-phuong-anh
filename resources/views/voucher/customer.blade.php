@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Danh sách khách hàng đổi voucher</h4>
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
                <form action="{{route('customer.exchange-voucher')}}" method="get" class="row">
                    <div class="col-md-3 mb-2">
                        <input name="key_search" class="form-control"
                               placeholder="Tìm theo tên, số điện thoại ..."
                               value="{{request()->get('key_search')}}"
                        >
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="status" class="form-control">
                            <option value="">Trạng thái</option>
                            <option value="pending" @if(request()->get('status') == 'pending') selected @endif>Chưa sử dụng</option>
                            <option value="complete" @if(request()->get('status') == 'complete') selected @endif>Đã sử dụng</option>
                            <option value="cancel" @if(request()->get('status') == 'cancel') selected @endif>Đã hủy</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                        <a href="{{route('customer.exchange-voucher')}}" class="btn btn-danger">Hủy</a>
                    </div>
                </form>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tiêu đề</th>
                            <th>Khách hàng</th>
                            <th>Trạng thái</th>
                            <th>Giảm giá</th>
                            <th>Điểm quy đổi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listData->total() > 0)
                            @foreach($listData as $key => $value)
                                <tr>
                                    <td class="align-middle">{{$key + 1}}</td>
                                    <td class="align-middle">
                                        <p class="m-0">Tên: {{$value->title}}</p>
                                        <p class="m-0">Mã: {{$value->exchange_code}}</p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="m-0">Tên: {{$value->name_customer}}</p>
                                        <p class="m-0">SĐT: {{$value->phone_customer}}</p>
                                    </td>
                                    <td class="align-middle">
                                        @if($value->status == 'pending')
                                            <p class="m-0 text-primary">Chưa sử dụng</p>
                                            @elseif($value->status == 'completed')
                                            <p class="m-0 text-success">Đã sử dụng</p>
                                        @else
                                            <p class="m-0 text-danger">Đã hủy</p>
                                        @endif
                                    </td>
                                    <td class="align-middle">{{number_format($value->discount_amount)}}</td>
                                    <td class="align-middle">{{$value->points_used}}</td>
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
            </div>
            <div class="d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
        </div>
    </div>
@endsection
