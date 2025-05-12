@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="m-0">Lịch sử tích điểm</h4>
                    <form class="w-75 d-flex justify-content-end align-items-center"
                          action="{{route('events.history-point')}}">
                        <input name="key_search" value="{{request()->get('key_search')}}"
                               placeholder="Tìm kiếm theo tên, mã , khách hàng hoặc sảm phẩm"
                               class="form-control" style="max-width: 250px;margin-right: 15px">
                        <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                        <a href="{{route('events.history-point')}}" style="margin-right: 15px" class="btn btn-danger">Hủy</a>
                        <a href="{{route('events.export-history-point')}}" style="margin-right: 15px" class="btn btn-warning">Xuất Excel</a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Thông tin KH</th>
                        <th>Thông tin ĐH</th>
                        <th>Tiêu đề</th>
                        <th>Số điểm</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($listData->total() > 0)
                        @foreach($listData as $key => $value)
                            <tr>
                                <td class="align-middle">{{$key + 1}}</td>
                                <td class="align-middle">
                                    <p class="mb-1"><span class="text-danger">Mã KH:</span>{{$value->code_customer}}</p>
                                    <p class="mb-1"><span class="text-primary">ID KH:</span>{{$value->customer_id}}</p>
                                    <p class="mb-1"><span class="text-warning">Tên KH:</span>{{$value->name_customer}}</p>
                                    <p class="mb-1"><span class="text-success">SĐT KH:</span>{{$value->phone_customer}}</p>
                                </td>
                                @if($value->type == 1)
                                    <td class="align-middle">
                                        <p class="mb-1"><span class="text-danger">Mã ĐH:</span>{{$value->code_order}}</p>
                                        <p class="mb-1" style="max-width: 200px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><span class="text-warning">Tên SP:</span>{{$value->product_name}}</p>
                                        <p class="mb-1"><span class="text-success">Mã SP:</span>{{$value->product_code}}</p>
                                    </td>
                                @else
                                    <td class="align-middle">
                                        <p class="mb-1"><span class="text-danger">Mã GD:</span>{{$value->code_order}}</p>
                                        <p class="mb-1" style="max-width: 200px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><span class="text-warning">Tên Quà Tặng:</span>{{$value->product_name}}</p>
                                        <p class="mb-1"><span class="text-success">Mã Quà Tặng:</span>{{$value->product_code}}</p>
                                    </td>
                                @endif
                                <td class="align-middle">
                                    <p style="max-width: 200px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" class="m-0 @if($value->type == 1) text-success @else text-danger @endif">{{$value->title}}</p>
                                </td>
                                <td class="align-middle">
                                    @if($value->type == 1)
                                        <span class="text-success"> + {{$value->point}}</span>
                                        @else
                                        <span class="text-danger"> - {{$value->point}}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5">
                                <p class="m-0 text-center text-danger">Không có dữ liệu</p>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">{{$listData->appends(request()->all())->links('pagination')}}</div>
        </div>
    </div>
@endsection
