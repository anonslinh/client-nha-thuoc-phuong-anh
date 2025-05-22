@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Thiết lập kết nối API KIOTVIET</h4>
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
                                <li class="breadcrumb-item" aria-current="page">
                                    <a class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center" target="_blank" href="https://www.kiotviet.vn/huong-dan-su-dung-kiotviet/thiet-lap-nang-cao/thiet-lap-ket-noi-api/">
                                        <i class="ti ti-send fs-4 me-2"></i>
                                        Tài liệu hướng dẫn kiotviet
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered text-nowrap">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã</th>
                        <th>KIOTVIET</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($listData->total() > 0)
                        @foreach($listData as $key => $value)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>
                                    <h6>{{$value->code}} </h6>
                                    <span>{{$value->name}}</span>
                                </td>
                                <td>
                                    <span>Tên kết nối: {{$value->retailer}}</span><br>
                                    <span>Client Id: {{$value->client_id}}</span><br>
                                    <span>Mã bảo mật: {{$value->client_secret}}</span>
                                </td>
                                <td>
                                    <div class="modal fade" id="modalUpdate{{$value->id}}" tabindex="-1" aria-labelledby="exampleModalLabel1">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="exampleModalLabel1">
                                                        Tài khoản Kiotviet
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{route('config.update-account-branches',$value->id)}}" method="post" enctype="multipart/form-data" class="modal-content">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="recipient-name" class="form-label">Tiêu đề:</label>
                                                            <input type="text" class="form-control" name="name" value="{{$value->name}}" required/>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Mã(tự đặt không trùng lặp)</label>
                                                            <input type="text" class="form-control" name="code" value="{{$value->code}}" readonly/>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Tên kết nối</label>
                                                            <input type="text" class="form-control" name="retailer" value="{{$value->retailer}}" required/>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Client Id</label>
                                                            <input type="text" class="form-control" name="client_id" value="{{$value->client_id}}" required/>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Mã bảo mật</label>
                                                            <input type="text" class="form-control" name="client_secret" value="{{$value->client_secret}}" required/>
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
                                    <a href="{{route('config.delete-account-branches',$value->id)}}" class="btn btn-danger btn-sa-confirm">
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
                        Tài khoản Kiotviet
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('config.store-account-branches') }}" method="post" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề:</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required/>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Mã(tự đặt không trùng lặp)</label>
                            <input type="text" class="form-control" name="code" value="{{ old('code') }}" required oninput="formatCodeInput(this)"/>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Tên kết nối</label>
                            <input type="text" class="form-control" name="retailer" value="{{ old('retailer') }}" required/>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Client Id</label>
                            <input type="text" class="form-control" name="client_id" value="{{ old('client_id') }}" required/>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Mã bảo mật</label>
                            <input type="text" class="form-control" name="client_secret" value="{{ old('client_secret') }}" required/>
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
    <script>
        function formatCodeInput(input) {
            let value = input.value;

            // Loại bỏ dấu tiếng Việt
            value = value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

            // Loại bỏ ký tự đặc biệt, chỉ giữ chữ cái và số
            value = value.replace(/[^a-zA-Z0-9]/g, "");

            // Chuyển thành chữ thường
            value = value.toLowerCase();

            input.value = value;
        }
    </script>
@endsection
