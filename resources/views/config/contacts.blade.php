@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Danh sách liên hệ & phản hồi</h4>
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
                        <th>icon</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listData as $key => $item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td><img src="{{$item->icon}}" style="width: 50px; height: auto"></td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->value}}</td>
                            <td>
                                <button type="button" class="btn mb-1 px-4 fs-4  bg-info-subtle text-info" data-bs-toggle="modal" data-bs-target="#contact-modal-{{$item->id}}" data-bs-whatever="@getbootstrap">
                                    Sửa
                                </button>
                                <div class="modal fade" id="contact-modal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel1">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title" id="exampleModalLabel1">
                                                    {{$item->name}}
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{route('config.contact-update',$item->id)}}" method="post" enctype="multipart/form-data" class="modal-content">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="">Tiêu đề:</label>
                                                        <input type="text" class="form-control" name="name" value="{{$item->name}}"/>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="">Nội dung:</label>
                                                        <input type="text" class="form-control" name="value" value="{{$item->value}}"/>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="d-block">Icon:</label>
                                                        <img src="{{$item->icon}}" style="width: 50px; height: auto; margin: 10px 0">
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
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
