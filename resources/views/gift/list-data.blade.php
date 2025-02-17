@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="p-0">Danh sách quà tặng</h4>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreate">+ Tạo mới</button>
                </div>
            </div>
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                {{session('error')}}
            </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{session('success')}}
                </div>
            @endif
            <div class="card-body">
                <form action="{{route('index')}}" method="get" class="d-flex justify-content-end">
                    <input name="key_search" value="{{request()->get('key_search')}}" class="form-control" style="max-width: 250px;margin-right: 15px" placeholder="Tìm kiếm tên hoặc mã quà tặng">
                    <button class="btn btn-success">Tìm kiếm</button>
                </form>
                <table class="table table-bordered mt-4 table-hover">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Số điểm quy đổi</th>
                        <th>Hạng thẻ</th>
                        <th>Trạng thái</th>
                        <th>Số khách hàng đổi</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($listData->total() > 0)
                        @foreach($listData as $key => $value)
                            <tr>
                                <td class="align-middle">{{$key + 1}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{$value->image}}" style="width: 50px; height: 50px; border-radius: 50px;object-fit: cover;margin-right: 15px">
                                        <p class="mb-0">{{$value->name}}</p>
                                    </div>
                                </td>
                                <td class="align-middle">{{$value->points_required}}</td>
                                <td class="align-middle text-danger">{{$value->name_rank??'Không áp dụng'}}</td>
                                <td class="align-middle">
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="align-middle">0</td>
                                <td class="align-middle">{{$value->points_required}}</td>
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
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form action="{{route('gift.store')}}" method="post" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Tạo mới quà tặng</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label>Tên</label>
                            <input class="form-control" name="name" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Mã</label>
                            <input class="form-control" name="code" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Hình ảnh</label>
                            <input class="form-control" type="file" accept="image/png" name="image" required>
                        </div>
                        <div class="form-group">
                            <label>Điểm quy đổi</label>
                            <input class="form-control" name="point" type="number" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Hạng thẻ</label>
                            <select name="rank_id" class="form-control">
                                <option value="">Không áp dụng</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button class="btn btn-primary">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
