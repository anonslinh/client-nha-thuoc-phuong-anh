@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Cài đặt voucher</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a class="text-muted text-decoration-none d-flex">
                                        <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                    </a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    <button data-bs-toggle="modal" data-bs-target="#modalCreate" type="button" class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center">
                                        <i class="ti ti-send fs-4 me-2"></i>
                                        Thêm voucher
                                    </button>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{route('voucher.list-data')}}" method="get" class="d-flex">
                    <div class="col-md-3" style="margin-right: 15px">
                        <input name="key_search" value="{{request()->get('key_search')}}" class="form-control"
                               placeholder="Tìm kiếm theo tên"
                        >
                    </div>
                    <div class="col-md-3" style="margin-right: 15px">
                        <select name="rank_id" class="form-control">
                            <option value="">Hạng thành viên (Không áp dụng)</option>
                            @foreach($rank as $rankItem)
                                <option value="{{$rankItem->id}}" @if(request()->get('rank_id') == $rankItem->id) selected @endif>{{$rankItem->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                    <a href="{{route('voucher.list-data')}}" class="btn btn-danger">Hủy</a>
                </form>

                <table class="table table-bordered mt-4">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Số điểm</th>
                        <th>Ngày hết hạn</th>
                        <th>Tiền chiết khấu</th>
                        <th>Hạng thẻ</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($listData->total() > 0)
                        @foreach($listData as $key => $value)
                            <tr>
                                <td class="align-middle">{{$key + 1}}</td>
                                <td class="align-middle">
                                    <img src="{{$value->image}}" style="width: 100px">
                                    <p class="mb-0 mt-3">{{$value->title}}</p>
                                </td>
                                <td class="align-middle">{{$value->points_required}}</td>
                                <td class="align-middle">{{date_format(date_create($value->expiry_date), 'd/m/Y')}}</td>
                                <td class="align-middle">{{number_format($value->discount_amount)}}</td>
                                <td class="align-middle">
                                    <p class="m-0 text-danger">{{$value->rank_name}}</p>
                                </td>
                                <td class="align-middle">

                                    <div class="modal fade" id="modalUpdate{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <form action="{{route('voucher.update', $value->id)}}" method="post" enctype="multipart/form-data" class="modal-content">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật Voucher</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group mb-2">
                                                        <label>Tên</label>
                                                        <input class="form-control" name="name" value="{{$value->title}}" required>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Hình ảnh</label>
                                                        <img src="{{$value->image}}" style="width: 200px; margin: 10px 0">
                                                        <input class="form-control" type="file" accept="image/png" name="image">
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Điểm quy đổi</label>
                                                        <input class="form-control" name="points_required" value="{{$value->points_required}}" type="number" min="0" required>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Số tiền</label>
                                                        <input class="form-control" name="discount_amount" value="{{$value->discount_amount}}" type="number" min="0" required>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Ngày hết hạn</label>
                                                        <input class="form-control" name="expiry_date" value="{{$value->expiry_date}}" type="date" required>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Hạng thẻ</label>
                                                        <select name="rank_id" class="form-control">
                                                            <option value="">Không áp dụng</option>
                                                            @foreach($rank as $item)
                                                                <option value="{{$item->id}}" @if($value->membership_levels_id == $item->id) selected @endif>{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Mô tả</label>
                                                        <textarea name="description" class="form-control" rows="4">{{$value->description}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-primary">Xác nhận</button>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Hủy</button>
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
                                    <a class="btn btn-danger btn-sa-confirm" href="{{route('voucher.delete', $value->id)}}">
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
                                <p class="m-0 text-center text-danger">Không có dữ liệu</p>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-4">{{$listData->appends(request()->all())->links('pagination')}}</div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{route('voucher.store')}}" method="post" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tạo mới Voucher</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label>Tên</label>
                        <input class="form-control" name="name" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Hình ảnh</label>
                        <input class="form-control" type="file" accept="image/png" name="image" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Điểm quy đổi</label>
                        <input class="form-control" name="points_required" type="number" min="0" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Số tiền</label>
                        <input class="form-control" name="discount_amount" type="number" min="0" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Ngày hết hạn</label>
                        <input class="form-control" name="expiry_date" type="date" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Hạng thẻ</label>
                        <select name="rank_id" class="form-control">
                            <option value="">Không áp dụng</option>
                            @foreach($rank as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Xác nhận</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
@endsection
