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
                <form action="{{route('product.gift.list-gift',$product->id)}}" method="get" class="d-flex">
                    <input name="key_search" value="{{request()->get('key_search')}}" class="form-control" style="max-width: 250px;margin-right: 15px" placeholder="Tìm kiếm tên hoặc mã quà tặng">
                    <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                    <a href="{{route('product.gift.list-gift',$product->id)}}" class="btn btn-danger">Hủy</a>
                </form>
                <table class="table table-bordered mt-4 table-hover">
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
{{--                                    <a class="btn btn-danger btn-sa-confirm" href="{{route('gift.delete', $value->id)}}">--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">--}}
{{--                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>--}}
{{--                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>--}}
{{--                                        </svg>--}}
{{--                                    </a>--}}
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
                <div class="d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
            </div>
        </div>
    </div>
@endsection
