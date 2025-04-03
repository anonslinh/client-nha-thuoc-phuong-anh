@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Danh sách khách hàng trúng quà</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{route('rotation.history-exchange-gift')}}" method="get" class="d-flex align-items-center justify-content-end">
                    <select name="rule_rotation_id" class="form-control" style="max-width: 200px;margin-right: 15px">
                        <option value="">Giá trị đơn hàng</option>
                        @foreach($rule_rotation as $value)
                            <option value="{{$value->id}}" @if($value->id == request()->get('rule_rotation_id')) selected @endif>{{$value->money_invoice_1.'-'.$value->money_invoice_2}}</option>
                        @endforeach
                    </select>
                    <input name="key_search" value="{{request()->get('key_search')}}" class="form-control" style="max-width: 300px;margin-right: 15px" placeholder="Tìm theo tên, sđt khách hàng, tên - mã phần quà">
                    <button class="btn btn-success" style="margin-right: 15px">Tìm kiếm</button>
                    <a href="{{route('rotation.history-exchange-gift')}}" class="btn btn-danger">Hủy</a>
                </form>
                <div class="mt-4">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên KH</th>
                            <th>SĐT KH</th>
                            <th>Tên/Mã Quà</th>
                            <th>Hình ảnh</th>
                            <th>Thời gian</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listData->total() > 0)
                            @foreach($listData as $key => $value)
                                <tr>
                                    <td class="align-middle">{{$key + 1}}</td>
                                    <td class="align-middle">
                                        <p class="m-0">{{$value->name_customer}}</p>
                                    </td>
                                    <td class="align-middle">{{$value->phone_customer}}</td>
                                    <td class="align-middle">
                                        <p class="m-0">{{$value->name_gift}}</p>
                                        <p class="m-0">{{$value->code_gift}}</p>
                                    </td>
                                    <td class="align-middle"><img src="{{$value->image_gift}}" style="width: 100px"></td>
                                    <td class="align-middle">{{date_format(date_create($value->created_at), 'H:i d/m/Y')}}</td>
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
