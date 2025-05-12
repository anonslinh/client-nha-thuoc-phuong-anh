@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Danh sách khách hàng đổi quà</h4>
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
                <form action="{{route('customer.exchange-gift')}}" method="get" class="d-flex">
                    <div class="col-3" style="margin-right: 15px">
                        <input name="key_search" class="form-control"
                               placeholder="Tìm theo tên, số điện thoại ..."
                               value="{{request()->get('key_search')}}"
                        >
                    </div>
                    <div class="col-2" style="margin-right: 15px">
                        <select name="status" class="form-control">
                            <option value="">Trạng thái</option>
                            <option value="pending" @if(request()->get('status') == 'pending') selected @endif>Chưa sử dụng</option>
                            <option value="completed" @if(request()->get('status') == 'completed') selected @endif>Đã sử dụng</option>
                            <option value="cancelled" @if(request()->get('status') == 'cancelled') selected @endif>Đã hủy</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                    <a href="{{route('customer.exchange-gift')}}" style="margin-right: 15px" class="btn btn-danger">Hủy</a>
                    <a href="{{route('customer.export-exchange-gift')}}" class="btn btn-warning">Xuất Excel</a>
                </form>
                <table class="table table-bordered mt-4">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Hình ảnh</th>
                        <th>Khách hàng</th>
                        <th>Trạng thái</th>
                        <th>Điểm quy đổi</th>
                        <th>Hoàn Điểm</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($listData->total() > 0)
                        @foreach($listData as $key => $value)
                            <tr>
                                <td class="align-middle">{{$key + 1}}</td>
                                <td class="align-middle">
                                    <p class="m-0">Tên: {{$value->name}}</p>
                                    <p class="m-0">Mã: {{$value->exchange_code}}</p>
                                    <p class="m-0">Barcode: {{$value->code}}</p>
                                </td>
                                <td class="align-middle">
                                    <img src="{{$value->image}}" style="width: 100px">
                                </td>
                                <td class="align-middle">
                                    <p class="m-0">Tên: {{$value->name_customer}}</p>
                                    <p class="m-0">SĐT: {{$value->contact_phone}}</p>
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
                                <td class="align-middle">{{$value->points_used}}</td>
                                <td class="align-middle">
                                    @if($value->status == 'pending')
                                        <a href="{{route('customer.exchange-gift-return',$value->id)}}" class="btn btn-warning">Hoàn điểm</a>
                                    @endif
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
@endsection
