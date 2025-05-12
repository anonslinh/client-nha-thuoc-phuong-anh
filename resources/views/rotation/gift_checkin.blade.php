@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Danh sách quà tặng</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{route('rotation.gift_checkin.index')}}" method="get" class="d-flex align-items-center justify-content-end">
                    <input name="key_search" value="{{request()->get('key_search')}}" class="form-control" style="max-width: 200px;margin-right: 15px" placeholder="Tìm theo tên phần quà">
                    <button class="btn btn-success" style="margin-right: 15px">Tìm kiếm</button>
                    <a href="{{route('rotation.gift')}}" class="btn btn-danger">Hủy</a>
                </form>
                <div class="mt-4">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên / Hình ảnh</th>
                            <th>Mã</th>
                            <th>Tỷ lệ chúng thưởng</th>
                            <th>Số lượng</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listData->total() > 0)
                            @foreach($listData as $key => $value)
                                <tr>
                                    <td class="align-middle">{{$key + 1}}</td>
                                    <td class="align-middle">
                                        <p class="m-0">{{$value->title}}</p>
                                        <img src="{{$value->image}}" style="width: 150px">
                                    </td>
                                    <td class="align-middle">{{$value->code}}</td>
                                    <td class="align-middle">{{$value->percent * 100}}%</td>
                                    <td class="align-middle">{{$value->quantity}}</td>
                                    <td class="align-middle">
                                        <div class="btn-group">
                                            <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Thao tác
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                                <li>
                                                    <a class="dropdown-item" href="{{route('rotation.gift_checkin.detail',$value->id)}}">Sửa</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item btn-sa-confirm" href="{{route('rotation.gift_checkin.delete',$value->id)}}">Xóa</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
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
                    <div class="mt-4 d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="assets/libs/tinymce/tinymce.min.js"></script>
    <script src="assets/js/forms/tinymce-init.js"></script>
@endsection
