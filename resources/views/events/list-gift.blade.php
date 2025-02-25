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
                        <th>Số lượng</th>
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
                                <td class="align-middle">{{$value->point}}</td>
                                <td class="align-middle text-danger">{{$value->quantity}}</td>
                                <td class="align-middle">0</td>
                                <td class="align-middle">

                                    <div class="modal fade" id="modalUpdate{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <form action="{{route('events.gift.update',$value->id)}}" method="post" enctype="multipart/form-data" class="modal-content">
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
                                                        <label>Mã vạch</label>
                                                        <input class="form-control" value="{{$value->code}}" name="barcode">
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label class="d-block">Hình ảnh</label>
                                                        <img src="{{$value->image}}" style="width: 200px;margin: 10px 0">
                                                        <input class="form-control" type="file" accept="image/png" name="image">
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Điểm quy đổi</label>
                                                        <input class="form-control" value="{{$value->point}}" name="point" type="number" min="0" required>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Số lượng</label>
                                                        <input class="form-control" value="{{$value->quantity}}" name="quantity" type="number" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <button class="btn btn-primary">Xác nhận</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Thao tác
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                            <li>
                                                <button data-bs-toggle="modal" data-bs-target="#modalUpdate{{$value->id}}" class="dropdown-item">Sửa</button>
                                            </li>
                                            <li>
                                                <a class="dropdown-item btn-sa-confirm" href="{{route('events.gift.delete', $value->id)}}">Xóa</a>
                                            </li>
                                        </ul>
                                    </div>
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
                <form action="{{route('events.gift.store')}}" method="post" enctype="multipart/form-data" class="modal-content">
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
                            <label>Mã vạch</label>
                            <input class="form-control" name="barcode">
                        </div>
                        <div class="form-group mb-2">
                            <label>Hình ảnh</label>
                            <input class="form-control" type="file" accept="image/png" name="image" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Điểm quy đổi</label>
                            <input class="form-control" name="point" type="number" min="0" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Số lượng</label>
                            <input class="form-control" name="quantity" type="number" min="0" required>
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
