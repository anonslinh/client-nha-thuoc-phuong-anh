@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Danh sách khách hàng đăng ký mua sản phẩm</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{route('events.cart')}}" method="get" class="row">
                    <div class="col-md-4 mb-2">
                        <input name="key_search" value="{{request()->get('key_search')}}" class="form-control" placeholder="Tìm kiếm tên hoặc mã quà tặng">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                        <a href="{{route('events.cart')}}" class="btn btn-danger">Hủy</a>
                    </div>
                </form>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered text-nowrap table-hover">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên KH</th>
                            <th>Tên SP</th>
                            <th>Mã SP</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listData->total() > 0)
                            @foreach($listData as $key => $value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td class="align-middle">
                                        <p class="m-0"><span class="text-danger">Tên:</span> {{$value->name_customer}}</p>
                                        <p class="m-0"><span class="text-success">SĐT:</span> {{$value->phone}}</p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="m-0"><span class="text-danger">Tên:</span> {{$value->name_product}}</p>
                                        <img src="{{$value->image_product}}" class="rounded-2" width="52" height="42">
                                    </td>
                                    <td class="align-middle">
                                        {{$value->code_product}}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">
                                    <p class="text-danger m-0 text-center">Chưa có dữ liệu</p>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
            </div>
        </div>
    </div>
@endsection
