@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Danh sách khách hàng nhận quà checkin : {{$listData->total()}}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{route('rotation.history-exchange-gift')}}" method="get" class="row">
                    <div class="col-md-4 mb-2">
                        <select name="rule_rotation_id" class="form-control">
                            <option value="">Chi nhánh</option>
                            @foreach($branch as $value)
                                <option value="{{$value->id}}" @if($value->id == request()->get('branch_id')) selected @endif>{{$value->branch_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <input name="key_search" value="{{request()->get('key_search')}}" class="form-control" placeholder="Tìm theo tên, sđt khách hàng, tên - mã phần quà">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-success" style="margin-right: 15px">Tìm kiếm</button>
                        <a href="{{route('rotation.gift_checkin.exchange-gift')}}" style="margin-right: 15px" class="btn btn-danger">Hủy</a>
                        <a href="{{route('rotation.gift_checkin.export-exchange-gift')}}" class="btn btn-warning">Xuất Excel</a>
                    </div>
                </form>
                <div class="mt-4 table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Thông tin KH</th>
                            <th>Thông tin Quà</th>
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
                                        <p class="m-0">SĐT: {{$value->phone}}</p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="m-0">Tên quà: {{$value->gift_name}}</p>
                                        <p class="m-0">Mã quà: {{$value->gift_code}}</p>
                                        <img src="{{$value->gift_image}}" style="width: 100px">
                                    </td>
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
@endsection
@section('script')
    <script src="assets/libs/tinymce/tinymce.min.js"></script>
    <script src="assets/js/forms/tinymce-init.js"></script>
@endsection
