@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Danh sách khách hàng đổi quà</h5>
                    <form class="w-75 d-flex justify-content-end align-items-center" action="{{route('events.history-exchange-gift')}}">
                        <input name="key_search" value="{{request()->get('key_search')}}"
                               placeholder="Tìm kiếm theo tên, sđt, mã khách hàng hoặc quà tặng"
                               class="form-control" style="max-width: 250px;margin-right: 15px">
                        <button class="btn btn-primary" style="margin-right: 15px;">Tìm kiếm</button>
                        <a href="{{route('events.history-exchange-gift')}}" style="margin-right: 15px" class="btn btn-danger">Hủy</a>
                        <a href="{{route('events.export-history-exchange-gift')}}" class="btn btn-warning">Xuất Excel</a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <p class="text-danger fw-bolder">Tổng: {{$listData->total()}}</p>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Quà tặng</th>
                        <th>Hình ảnh</th>
                        <th>Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($listData->total() > 0)
                        @foreach($listData as $key => $value)
                            <tr>
                                <td class="align-middle">{{$key + 1}}</td>
                                <td class="align-middle">
                                    <p class="mb-1"><span class="text-danger">Mã:</span>{{$value->code}}</p>
                                    <p class="mb-1"><span class="text-warning">Tên:</span>{{$value->name}}</p>
                                    <p class="mb-1"><span class="text-success">SĐT:</span>{{$value->contact_number}}</p>
                                </td>
                                <td class="align-middle">
                                    <p class="mb-1"><span class="text-danger">Tên:</span>{{$value->name_gift}}</p>
                                    <p class="mb-1"><span class="text-warning">Mã :</span>{{$value->code_gift}}</p>
                                    <p class="mb-1"><span class="text-danger">Thời gian </span>{{date_format(date_create($value->created_at), 'H:i d/m/Y')}}</p>
                                    <p class="mb-1"><span class="text-info">Chi nhánh:  </span>{{$value->name_branch}}</p>
                                </td>
                                <td class="align-middle">
                                    <img src="{{$value->image_gift}}" style="max-width: 150px">
                                </td>
                                <td class="align-middle">
                                    @if($value->status == 1)
                                        <span class="text-primary">Chưa đổi quà</span>
                                        @elseif($value->status == 2)
                                        <span class="text-success">Đã đổi quà</span>
                                    @else
                                        <span class="text-danger">Đã hủy</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5">
                                <p class="m-0 text-danger text-center">Không có dữ liệu</p>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
