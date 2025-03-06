@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Cài đặt tài khoản</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a href="{{route('index')}}" class="text-muted text-decoration-none d-flex">
                                        <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                    </a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">

                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <ul class="nav nav-pills user-profile-tab" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#pills-account" type="button" role="tab" aria-controls="pills-account" aria-selected="true">
                        <i class="ti ti-user-circle me-2 fs-6"></i>
                        <span class="d-none d-md-block">Tài khoản</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" id="pills-bills-tab" data-bs-toggle="pill" data-bs-target="#pills-bills" type="button" role="tab" aria-controls="pills-bills" aria-selected="false">
                        <i class="ti ti-article me-2 fs-6"></i>
                        <span class="d-none d-md-block">Danh sách tài khoản</span>
                    </button>
                </li>
            </ul>
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab" tabindex="0">
                        <div class="row justify-content-center">
                            <div class="col-lg-9 d-flex align-items-stretch">
                                <div class="card w-100 border position-relative overflow-hidden">
                                    <div class="card-body p-4">
                                        <h4 class="card-title">Đổi mật khẩu</h4>

                                        <form method="POST" action="{{ route('account-admin.change-password') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Mật khẩu hiện tại</label>
                                                <input type="password" class="form-control" name="current_password" required>
                                                @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Mật khẩu mới</label>
                                                <input type="password" class="form-control" name="new_password" required>
                                                @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nhập lại mật khẩu mới</label>
                                                <input type="password" class="form-control" name="confirm_password" required>
                                                @error('confirm_password') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="col-12 d-flex justify-content-end mt-4">
                                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9 d-flex align-items-stretch">
                                <div class="card w-100 border position-relative overflow-hidden">
                                    <div class="card-body p-4">
                                        <h4 class="card-title">Thêm tài khoản đăng nhập</h4>
                                        <form method="POST" action="{{ route('account-admin.add-user') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Nhân viên</label>
                                                    <select class="form-control" name="employee_kiotviet_id">
                                                        @foreach($employees as $employee)
                                                            <option value="{{$employee->kiotviet_id}}">{{$employee->user_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Cấp bậc</label>
                                                    <select class="form-control" name="role">
                                                        <option value="staff">Nhân viên</option>
                                                        <option value="manager">Quản lý</option>
                                                        <option value="manager">Quản trị viên</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" autocomplete="new-password" required>
                                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Mật khẩu</label>
                                                <input type="password" class="form-control" name="new_password" autocomplete="new-password" required>
                                                @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nhập lại mật khẩu</label>
                                                <input type="password" class="form-control" name="confirm_password" required>
                                                @error('confirm_password') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="col-12 d-flex justify-content-end mt-4">
                                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-bills" role="tabpanel" aria-labelledby="pills-bills-tab" tabindex="0">
                        <div class="row justify-content-center">
                            <div class="col-lg-9">
                                <div class="card border shadow-none">
                                    <div class="card-body p-4">
                                        <h4 class="card-title mb-3">Danh sách tài khoản</h4>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tài khoản</th>
                                                <th>Email</th>
                                                <th>Hành động</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($listData as $key => $value)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$value->name}}</td>
                                                    <td>{{$value->email}}</td>
                                                    <td>
                                                        @if($value->id != 1)
                                                            <a href="{{route('account-admin.delete-user',$value->id)}}" class="btn btn-danger btn-sa-confirm">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                                </svg>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
@endsection
