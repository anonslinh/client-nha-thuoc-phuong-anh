@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Danh sách khách hàng</h4>
                    <form action="{{route('customer.exchange-gift')}}" method="get" class="w-75 d-flex justify-content-end align-items-center">
                        <input name="key_search" class="form-control"
                               placeholder="Tìm theo tên, số điện thoại ..."
                               value="{{request()->get('key_search')}}"
                               style="max-width: 200px;margin-right: 15px">
                        <select name="status" class="form-control" style="max-width: 200px;margin-right: 15px">
                            <option value="">Trạng thái</option>
                            <option value="pending" @if(request()->get('status') == 'pending') selected @endif>Chưa sử dụng</option>
                            <option value="complete" @if(request()->get('status') == 'complete') selected @endif>Đã sử dụng</option>
                            <option value="cancel" @if(request()->get('status') == 'cancel') selected @endif>Đã hủy</option>
                        </select>
                        <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                        <a href="{{route('customer.exchange-gift')}}" class="btn btn-danger">Hủy</a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Hình ảnh</th>
                        <th>Khách hàng</th>
                        <th>Trạng thái</th>
                        <th>Điểm quy đổi</th>
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
