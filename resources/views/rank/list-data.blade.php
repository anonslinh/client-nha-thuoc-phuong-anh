@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Hạng thẻ</h4>
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
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên hạng thẻ</th>
                        <th>Ảnh nền</th>
                        <th>Mức chi tiêu</th>
                        <th>SL khách hàng</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listData as $key => $value)
                        <tr>
                            <td class="align-middle">{{$key + 1}}</td>
                            <td class="align-middle">{{$value->name}}</td>
                            <td class="align-middle">
                                <img src="{{$value->image}}" style="width: 100px">
                            </td>
                            <td class="align-middle">{{number_format($value->spending_threshold)}}</td>
                            <td class="align-middle">{{number_format($value->total_customer)}}</td>
                            <td class="align-middle">

                                <div class="modal fade" id="modalUpdate{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <form action="{{route('rank.update',$value->id)}}" method="post" enctype="multipart/form-data" class="modal-content">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật hạng thành viên</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group mb-2">
                                                    <label class="form-label">Tên</label>
                                                    <input class="form-control" value="{{$value->name}}" name="name" required>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label class="form-label">Ảnh nền</label>
                                                    <input class="form-control" type="file" accept="image/png" name="image">
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label class="form-label">Mức chi tiêu</label>
                                                    <input class="form-control" type="number" value="{{$value->spending_threshold}}" name="spending_threshold" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                <button class="btn btn-primary">Xác nhận</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$value->id}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
