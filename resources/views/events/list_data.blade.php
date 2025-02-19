@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Danh sách sự kiện</h4>
                    <a href="{{route('events.create')}}" class="btn btn-primary">+ Tạo mới</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('events.list-data')}}" method="get" class="row">
                    <div class="col-3">
                        <label>Tìm theo tên sự kiện</label>
                        <input class="form-control" name="key_search" value="{{request()->get('key_search')}}">
                    </div>

                    <div class="col-3">
                        <label>Thời gian bắt đầu:</label>
                        <input name="time_start" type="date" value="{{request()->get('time_start')}}" class="form-control">
                    </div>
                    <div class="col-3">
                        <label>Thời gian kết thúc:</label>
                        <input name="time_end" type="date" value="{{request()->get('time_end')}}" class="form-control">
                    </div>
                    <div class="col-3">
                        <label class="text-white">Thao tác</label>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                            <a href="{{route('events.list-data')}}" class="btn btn-danger">Hủy</a>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered mt-4">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Hình ảnh</th>
                        <th>Số sản phẩm</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian kết thúc</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($listData->total() > 0)
                            @else
                            <tr>
                                <td colspan="7">
                                    <p class="text-danger text-center mb-0">Không có dữ liệu</p>
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
