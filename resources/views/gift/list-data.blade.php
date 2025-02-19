@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="p-0">Danh sách quà tặng</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">+ Tạo mới</button>
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
                    <button class="btn btn-success" style="margin-right: 15px">Tìm kiếm</button>
                    <a href="{{route('index')}}" class="btn btn-danger">Hủy</a>
                </form>
                <table class="table table-bordered mt-4 table-hover">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Điểm quy đổi</th>
                        <th>Hạng thẻ</th>
{{--                        <th>Trạng thái</th>--}}
                        <th>Khách hàng đổi</th>
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
{{--                                <td class="align-middle">--}}
{{--                                    <label class="switch">--}}
{{--                                        <input type="checkbox" checked>--}}
{{--                                        <span class="slider round"></span>--}}
{{--                                    </label>--}}
{{--                                </td>--}}
                                <td class="align-middle">0</td>
                                <td class="align-middle">

                                    <div class="modal fade" id="modalUpdate{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <form action="{{route('gift.update',$value->id)}}" method="post" enctype="multipart/form-data" class="modal-content">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật quà tặng</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group mb-2">
                                                        <label>Tên</label>
                                                        <input class="form-control" value="{{$value->name}}" name="name" required>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Mã</label>
                                                        <input class="form-control" value="{{$value->code}}" name="code" required>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label class="d-block">Hình ảnh</label>
                                                        <img src="{{$value->image}}" style="width: 200px;margin: 10px 0">
                                                        <input class="form-control" type="file" accept="image/png" name="image">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Điểm quy đổi</label>
                                                        <input class="form-control" value="{{$value->points_required}}" name="point" type="number" min="0" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Hạng thẻ</label>
                                                        <select name="rank_id" class="form-control">
                                                            <option value="">Không áp dụng</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <button class="btn btn-primary">Xác nhận</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <button data-bs-toggle="modal" data-bs-target="#modalUpdate{{$value->id}}" class="btn btn-primary" style="margin-right: 15px">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                    </button>
                                    <a class="btn btn-danger btn-sa-confirm" href="{{route('gift.delete', $value->id)}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
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
                <div class="d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button class="btn btn-primary">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
