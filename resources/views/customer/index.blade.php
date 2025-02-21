@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Danh sách khách hàng</h4>
                    <form action="{{route('customer')}}" method="get" class="w-75 d-flex justify-content-end align-items-center">
                        <input name="key_search" class="form-control"
                               placeholder="Tìm theo tên, số điện thoại ..."
                               value="{{request()->get('key_search')}}"
                               style="max-width: 200px;margin-right: 15px">
                        <select name="status" class="form-control" style="max-width: 200px;margin-right: 15px">
                            <option value="">Sắp xếp theo</option>
                            <option value="total_invoiced" @if(request()->get('sort') == 'total_invoiced') selected @endif>Tổng đơn hàng</option>
                            <option value="total_point" @if(request()->get('sort') == 'total_point') selected @endif>Tổng điểm</option>
                        </select>
                        <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                        <a href="{{route('customer')}}" class="btn btn-danger">Hủy</a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Mã </th>
                        <th>Địa chỉ</th>
                        <th>Điểm kiotviet</th>
                        <th>Điểm hệ thống</th>
                        <th>Điểm đã sử dụng</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($listData->total() > 0)
                        @foreach($listData as $key => $value)
                            <tr>
                                <td class="align-middle">{{$key + 1}}</td>
                                <td class="align-middle">
                                    <p class="m-0">Tên: {{$value->name}}</p>
                                    <p class="m-0">Số điện thoại: {{$value->contact_number}}</p>
                                </td>
                                <td class="align-middle">
                                    <p class="m-0">Mã: {{$value->code}}</p>
                                </td>
                                <td class="align-middle">
                                    <p class="m-0">{{$value->address}}</p>
                                </td>
                                <td class="align-middle">{{$value->kiotviet_reward_point}}</td>
                                <td class="align-middle">{{$value->kiotviet_reward_point - $value->used_points}}</td>
                                <td class="align-middle">{{$value->used_points}}</td>
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
