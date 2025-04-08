@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Danh sách quà tặng vòng quay may mắn</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    @if(count($rule_rotation))
                                        <a href="{{route('rotation.gift.create')}}" type="button" class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-danger d-flex align-items-center">
                                            <i class="ti ti-send fs-4 me-2"></i>
                                            Thêm quà tặng
                                        </a>
                                        @else
                                        <a href="{{route('rotation.setting')}}" class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-danger d-flex align-items-center btnAddRule">
                                            <i class="ti ti-send fs-4 me-2"></i>
                                            Cài đặt vòng quay
                                        </a>
                                    @endif
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{route('rotation.gift')}}" method="get" class="d-flex align-items-center justify-content-end">
                    <select name="rule_rotation_id" class="form-control" style="max-width: 200px;margin-right: 15px">
                        <option value="">Giá trị đơn hàng</option>
                        @foreach($rule_rotation as $value)
                            <option value="{{$value->id}}" @if($value->id == request()->get('rule_rotation_id')) selected @endif>{{$value->money_invoice_1.'-'.$value->money_invoice_2}}</option>
                        @endforeach
                    </select>
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
                                                    <a class="dropdown-item" href="{{route('rotation.gift.detail',$value->id)}}">Sửa</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item btn-sa-confirm" href="{{route('rotation.delete-gift',$value->id)}}">Xóa</a>
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
    <div class="modal fade" id="modalCreate" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="exampleModalLabel1">
                        Cài đặt quà tặng
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rotation.create-gift') }}" method="post" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Tên quà:</label>
                            <input type="text" class="form-control" name="title"/>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Mã quà:</label>
                            <input type="text" class="form-control" name="code" required/>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Hình ảnh:</label>
                            <input type="file" accept="image/*" class="form-control" name="image" required/>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Số lượng:</label>
                            <input type="number" class="form-control" name="quantity" required/>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Tỷ lệ chúng thưởng: (Lưu ý: Tổng tỉ lệ chúng quà phải là 100%)</label>
                            <input type="number" class="form-control" name="percent" required/>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Nhóm giá trị đơn hàng:</label>
                            <select name="rule_rotation_id" class="form-control" required>
                                @foreach($rule_rotation as $rule)
                                    <option value="{{$rule->id}}">{{$rule->money_invoice_1.'-'.$rule->money_invoice_2}}</option>
                                @endforeach
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
@section('script')
    <script src="assets/libs/tinymce/tinymce.min.js"></script>
    <script src="assets/js/forms/tinymce-init.js"></script>
@endsection
