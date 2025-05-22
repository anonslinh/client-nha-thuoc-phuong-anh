@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Danh sách quà tặng theo sản phẩm : {{$product->name}}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{route('events.list-gift-product',$product->id)}}" method="get" class="row">
                    <div class="col-md-4 mb-2">
                        <input name="key_search" value="{{request()->get('key_search')}}" class="form-control" placeholder="Tìm kiếm tên hoặc mã quà tặng">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                        <a href="{{route('events.list-gift-product',$product->id)}}" class="btn btn-danger">Hủy</a>
                    </div>
                </form>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Hoán đổi</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listData->total() > 0)
                            @foreach($listData as $key => $value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <img src="{{$value->image}}" class="rounded-2" width="52" height="42">
                                            <div class="ms-3">
                                                <h6 class="fw-semibold mb-1">{{$value->name}}</h6>
                                                <span>Hạng thẻ: {{$value->name_rank??'Không áp dụng'}}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="align-middle">
                                        <h6>Số điểm: {{$value->points_required}}</h6>
                                        <span>Sản phẩm: 01</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{route('gift.detail', ['id' => $value->id])}}" class="btn btn-primary" style="margin-right: 15px">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                            </svg>
                                        </a>
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
