@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Danh sách khách hàng</h4>
                    <form action="{{route('events.list-customer')}}" method="get" class="w-75 d-flex justify-content-end align-items-center">
                        <input name="key_search" class="form-control"
                               placeholder="Tìm theo tên, số điện thoại ..."
                               value="{{request()->get('key_search')}}"
                               style="max-width: 200px;margin-right: 15px">
                        <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                        <a href="{{route('events.list-customer')}}" class="btn btn-danger">Hủy</a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Điểm sự kiện</th>
                        <th>***</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($listData->total() > 0)
                        @foreach($listData as $key => $value)
                            <tr>
                                <td class="align-middle">{{$key + 1}}</td>
                                <td class="align-middle">
                                    <p class="m-0"><span class="text-danger">Tên:</span> {{$value->name}}</p>
                                    <p class="m-0"><span class="text-success">SĐT:</span> {{$value->contact_number}}</p>
                                    <p class="m-0"><span class="text-warning">Mã KH:</span> {{$value->code}}</p>
                                </td>
                                <td class="align-middle">
                                    <p class="m-0">{{$value->total_point_event - $value->used_point_event}}</p>
                                </td>
                                <td class="align-middle">

                                    <div class="modal fade" id="modalUpdate{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <form action="{{route('events.customer.update-point')}}" method="post" class="modal-content">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật điểm cho khách hàng: {{$value->name}}</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group mb-2">
                                                        <input hidden name="customer_id" value="{{$value->id}}">
                                                        <label>Loại hình</label>
                                                        <select name="type" class="form-control">
                                                            <option value="1">Cộng điểm</option>
                                                            <option value="2">Trừ điểm</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Số điểm</label>
                                                        <input class="form-control" name="point" type="number" min="0" required>
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
                                                <button class="dropdown-item btn-update-point" value="{{$value->kiotviet_id}}">Đồng bộ điểm</button>
                                            </li>
                                            <li>
                                                <button data-bs-toggle="modal" data-bs-target="#modalUpdate{{$value->id}}" class="dropdown-item">Sửa điểm</button>
                                            </li>
                                            <li>
                                                <a class="dropdown-item " href="{{route('events.history-point', ['key_search' => $value->kiotviet_id])}}">Lịch sử điểm</a>
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
            </div>
            <div class="d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
           $(".btn-update-point").click(function () {
               $(".loading").addClass("active");
               let data = {};
               data['customer_id'] = $(this).val();
               $.ajax({
                   url: "{{route('events.update-point')}}",
                   data: data,
                   type: "post",
                   dataType: "json",
                   success: function (data) {
                       $(".loading").removeClass("active");
                       Swal.fire(
                           "Thành công",
                           "Đồng bộ điểm lên hệ thống thành công",
                           "success"
                       );
                   },
                   error: function (data) {
                       $(".loading").removeClass("active");
                       Swal.fire(
                           "Thất bại",
                           data.msg,
                           "error"
                       );
                   }
               })
           });
        });
    </script>
@endsection
