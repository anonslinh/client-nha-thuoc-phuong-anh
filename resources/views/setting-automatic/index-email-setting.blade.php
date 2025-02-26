@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Cài đặt Email nhận thông báo tự đông</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a class="text-muted text-decoration-none d-flex">
                                        <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                    </a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalCreate">
                                        <i class="ti ti-send fs-4 me-2"></i>
                                        Thêm mới
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
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>STT</th>
{{--                        <th>Chi nhánh</th>--}}
                        <th>Thể loại</th>
                        <th>Email</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($listData->total() > 0)
                        @foreach($listData as $key => $value)
                            <tr>
                                <td>{{$key + 1}}</td>
{{--                                <td>--}}
{{--                                    <span>{{optional($value->branch)->branch_name}} </span><br>--}}
{{--                                </td>--}}
                                <td>
                                    @if($value->type == 'email_invoice') <span>Hoá đơn dưới 3 sao</span> @endif
                                    @if($value->type == 'email_employee') <span>Cảnh báo nhân viên</span> @endif
                                </td>
                                <td>{{$value->email}}</td>
                                <td>
                                    <div class="modal fade" id="modalUpdate{{$value->id}}" tabindex="-1" aria-labelledby="exampleModalLabel1">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="exampleModalLabel1">
                                                        Mini Games
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{route('setting-automatic.update-setting-email',$value->id)}}" method="post" enctype="multipart/form-data" class="modal-content">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="type" class="">Thể loại</label>
                                                            <select name="type" class="form-control">
                                                                <option {{ $value->type == 'email_invoice' ? 'selected' : '' }} value="email_invoice">Hoá đơn dưới 3 sao</option>
                                                                <option {{ $value->type == 'email_employee' ? 'selected' : '' }} value="email_employee">Cảnh báo nhân viên</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email" class="">Email</label>
                                                            <input type="email" class="form-control" name="email" value="{{ $value->email }}" required/>
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
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$value->id}}" style="margin-right: 15px">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                    </button>
                                    <a href="{{route('setting-automatic.destroy-setting-email',$value->id)}}" class="btn btn-danger btn-sa-confirm">
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
                            <td colspan="6">
                                <p class="m-0 text-danger text-center">Không có dữ liệu</p>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalCreate" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="exampleModalLabel1">
                        Email nhận thông báo tự đông
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('setting-automatic.store-setting-email') }}" method="post" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    <div class="modal-body">
{{--                        <div class="mb-3">--}}
{{--                            <label for="branch_id" class="">Chi nhánh</label>--}}
{{--                            <select name="branch_id" class="form-control">--}}
{{--                                <option value="">Tất cả cửa hàng</option>--}}
{{--                                @foreach($branches as $branch)--}}
{{--                                    <option value="{{ $branch->kiotviet_id }}" {{ old('branch_id') == $branch->kiotviet_id ? 'selected' : '' }}>--}}
{{--                                        {{ $branch->branch_name }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="mb-3">
                            <label for="type" class="">Thể loại</label>
                            <select name="type" class="form-control">
                                <option {{ old('branch_id') == 'email_invoice' ? 'selected' : '' }} value="email_invoice">Hoá đơn dưới 3 sao</option>
                                <option {{ old('branch_id') == 'email_employee' ? 'selected' : '' }} value="email_employee">Cảnh báo nhân viên</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required/>
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
