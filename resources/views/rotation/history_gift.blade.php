@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Danh sách khách hàng trúng quà: {{$totalGift}}</h4>
                        <a href="{{route('rotation.export-history-exchange-gift')}}" class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-danger d-flex align-items-center">
                            <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                            Xuất excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{route('rotation.history-exchange-gift')}}" method="get" class="row">
                    <div class="col-md-4 mb-2">
                        <select name="rule_rotation_id" class="form-control">
                            <option value="">Giá trị đơn hàng</option>
                            @foreach($rule_rotation as $value)
                                <option value="{{$value->id}}" @if($value->id == request()->get('rule_rotation_id')) selected @endif>{{$value->money_invoice_1.'-'.$value->money_invoice_2}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <input name="key_search" value="{{request()->get('key_search')}}" class="form-control" placeholder="Tìm theo tên, sđt khách hàng, tên - mã phần quà">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-success" style="margin-right: 15px">Tìm kiếm</button>
                        <a href="{{route('rotation.history-exchange-gift')}}" class="btn btn-danger">Hủy</a>
                    </div>
                </form>
                <div class="mt-4 table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Thông tin KH</th>
                            <th>Thông tin Quà</th>
                            <th>Mã hóa đơn</th>
                            <th>Chi nhánh</th>
                            <th>Thời gian</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listData->total() > 0)
                            @foreach($listData as $key => $value)
                                <tr>
                                    <td class="align-middle">{{ ($listData->currentPage() - 1) * $listData->perPage() + $key + 1 }}</td>
                                    <td class="align-middle">
                                        <p class="m-0">Tên: {{$value->name_customer}}</p>
                                        <p class="m-0">SĐT: {{$value->phone_customer}}</p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="m-0">Tên quà: {{$value->name_gift}}</p>
                                        <p class="m-0">Mã quà: {{$value->code_gift}}</p>
                                        <img src="{{$value->image_gift}}" style="width: 100px">
                                    </td>
                                    <td class="align-middle">{{$value->invoice_code}}</td>
                                    <td class="align-middle">{{$value->branch_name}}</td>
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
