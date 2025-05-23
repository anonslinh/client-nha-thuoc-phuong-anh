@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Yêu cầu xuất hoá đơn: {{$totalData}}</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a class="text-muted text-decoration-none d-flex">
                                        <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">

                <form action="{{route('invoices-request.index')}}" method="get" class="row">
                    <div class="col-md-3 mb-2">
                        <label>Tìm kiếm</label>
                        <input name="key_search" class="form-control"
                               placeholder="Nhập thông tin tìm kiếm"
                               value="{{request()->get('key_search')}}"
                        >
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>Từ ngày</label>
                        <input name="from_date" class="form-control" type="datetime-local" value="{{ request()->get('from_date') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>Đến ngày</label>
                        <input name="to_date" class="form-control" type="datetime-local" value="{{ request()->get('to_date') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="all" {{ request()->get('status') == 'all' ? 'selected' : '' }}>Tất cả</option>
                            <option value="pending" {{ request()->get('status') == 'pending' ? 'selected' : '' }}>Chưa xử lý</option>
                            <option value="completed" {{ request()->get('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary" style="margin-right: 10px">Tìm kiếm</button>
                        <a href="{{route('invoices-request.index')}}" class="btn btn-danger" style="margin-right: 10px">Hủy</a>
                        <a href="{{ route(
                        'invoices-request.export',
                        [
                            'from_date' => request('from_date'),
                            'to_date' => request('to_date'),
                            'key_search' => request('key_search'),
                            'status' => request('status')
                        ]
                        )}}" class="btn btn-danger align-self-end">
                            <i class="ti ti-transition-right me-1 fs-4"></i>Xuất Excel</a>
                    </div>

                </form>
                <form action="{{route('invoices-request.import')}}" method="post" class="row mt-4" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-4 mb-2">
                        <input type="file" class="form-control" name="file" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary align-self-end"><i class="ti ti-transition-right me-1 fs-4"></i>Import Excel</button>
                    </div>
                </form>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã HĐ</th>
                            <th>Thông tin</th>
                            <th>Link giấy tờ</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listData->total() > 0)
                            @foreach($listData as $key => $value)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>
                                        <h6 class="fw-semibold mb-1">{{$value->invoice_code}}</h6>
                                        @if($value->status == 'pending') <span class="fw-normal">Chưa xử lý</span> @endif
                                        @if($value->status == 'completed') <span class="fw-normal">Hoàn thành</span>  @endif
                                    </td>
                                    <td>
                                        @if($value->type == 'personal') <span>Cá nhân</span><br> @endif
                                        @if($value->type == 'company') <span>Công ty</span><br> @endif

                                        @if($value->type == 'personal')
                                            <span>{{$value->name}}</span><br>
                                            <span>{{$value->phone}}</span>
                                        @endif

                                        @if($value->type == 'company')
                                            <span>MST: {{$value->tax_code}}</span><br>
                                            <span>{{$value->company_name}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($value->result_url))
                                            <a target="_blank" href="{{$value->result_url}}">Xem giấy tờ</a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('invoices-request.destroy',$value->id)}}" class="btn btn-danger btn-sa-confirm">
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
                </div>
                <div class="d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalCreate" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Banner
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('certificates.store')}}" method="post" class="modal-content" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label class="form-label">Tên sản phẩm</label>
                            <input class="form-control" {{ old('product_name') }} name="product_name" required>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Mã sản phẩm</label>
                            <input class="form-control" {{ old('product_code') }} name="product_code" required>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Lịnk giấy tờ</label>
                            <input class="form-control" {{ old('certificate_link') }} name="certificate_link" required>
                        </div>
                        <div class="mb-3">
                            <label for="status"  class="form-label">Trạng thái</label>
                            <select name="is_active" class="form-control">
                                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Đang hoạt động</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Đang khoá</option>
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
