@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Lịch sử khách hàng tích điểm</h4>
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
                <form action="{{route('config.history-point')}}" method="get" class="row">
                    <div class="col-md-4 mb-2">
                        <input name="key_search" class="form-control" placeholder="Tìm kiếm" value="{{request()->get('key_search')}}">
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary" style="margin-right: 10px">Tìm kiếm</button>
                        <a href="{{route('config.history-point')}}" class="btn btn-danger" style="margin-right: 10px">Hủy</a>
                    </div>
                </form>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Khách hàng</th>
                            <th>Đơn hàng</th>
                            <th>Tiêu đề</th>
                            <th>Số điểm</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listData->total() > 0)
                            @foreach($listData as $key => $item)
                                <tr>
                                    <td class="align-middle">{{$key+1}}</td>
                                    <td class="align-middle">
                                        <p class="m-0"><span class="text-danger">Tên KH:</span>{{$item->name_customer}} </p>
                                        <p class="m-0"><span class="text-info">SĐT KH:</span>{{$item->phone_customer}} </p>
                                    </td>
                                    <td class="align-middle">{{$item->order_code}}</td>
                                    <td class="align-middle">{{$item->title}}</td>
                                    <td class="align-middle">{{$item->point}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5"><p class="m-0 text-danger text-center">Không có dữ liệu</p></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
            </div>
        </div>
    </div>
@endsection
