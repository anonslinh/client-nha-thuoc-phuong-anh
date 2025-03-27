@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Video sản phẩm</h4>
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
                <a class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-danger mb-4 d-flex align-items-center" target="_blank" href="https://docs.google.com/document/d/1cIxb0Aq9xhZYYww8WDGT7lw4dAQD0klLfy31IL0HFlQ/edit?usp=sharing">Click vào đây để xem hướng dẫn lấy ID Video</a>
                <form action="{{route('product.video')}}" method="get" enctype="multipart/form-data" class="d-flex align-items-center">
                    <input name="key_search" value="{{request()->get('key_search')}}"
                           placeholder="Tìm kiếm theo tiêu đề hoặc ID video"
                           class="form-control" style="max-width: 250px; margin-right: 15px">
                    <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                    <a href="{{route('product.video')}}" class="btn btn-danger">Hủy</a>
                </form>
                <table class="mt-4 table table-bordered">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Video</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($listData->total() > 0)
                        @foreach($listData as $key => $value)
                            <tr>
                                <td class="align-middle">{{$key + 1}}</td>
                                <td class="align-middle">{{$value->title}}</td>
                                <td>
                                    <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-warning d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#showVideo{{$value->id}}">
                                        <i class="ti ti-send fs-4 me-2"></i>
                                        Xem video
                                    </button>
                                    <div class="modal fade" id="showVideo{{$value->id}}" tabindex="-1">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$value->id_video}}"
                                                        title="YouTube video player" frameborder="0"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                        allowfullscreen>
                                                </iframe>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($value->is_active == 1)
                                        <span class="text-success fw-bolder">Hiện</span>
                                    @else
                                        <span class="text-danger fw-bolder">Ẩn</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group">
                                        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Thao tác
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                            <li>
                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$value->id}}" href="javascript:void(0)">Sửa</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item btn-sa-confirm" href="{{route('product.video.delete', $value->id)}}">Xóa</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="modal fade" id="modalUpdate{{$value->id}}" tabindex="-1">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="exampleModalLabel1">
                                                        Video sản phẩm
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('product.video.update', $value->id) }}" method="post" enctype="multipart/form-data" class="modal-content">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Tiêu đề:</label>
                                                            <input type="text" class="form-control" name="title" value="{{$value->title}}"/>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="link" class="form-label">ID Video Youtube:</label>
                                                            <input type="text" class="form-control" name="id_video" value="{{$value->id_video}}" required/>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="link" class="form-label">Thứ tự hiển thị:</label>
                                                            <input type="number" class="form-control" name="index" value="{{$value->index}}"/>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="status" class="form-label">Trạng thái</label>
                                                            <select name="status" class="form-control">
                                                                <option value="active" @if($value->is_active == 1) selected @endif>Đang hoạt động</option>
                                                                <option value="inactive" @if($value->is_active == 0) selected @endif>Đang khoá</option>
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
                <div class="mt-4 d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalCreate" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="exampleModalLabel1">
                        Video sản phẩm
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('product.store-video') }}" method="post" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề:</label>
                            <input type="text" class="form-control" name="title"/>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">ID Video Youtube:</label>
                            <input type="text" class="form-control" name="id_video" required/>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Thứ tự hiển thị:</label>
                            <input type="number" class="form-control" name="index" value=""/>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Đang khoá</option>
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
