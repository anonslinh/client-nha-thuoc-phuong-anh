@extends('Layout.index')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Banner</h4>
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
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tiêu đề</th>
                            <th>Thời gian</th>
                            <th>Chi nhánh</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listData->total() > 0)
                            @foreach($listData as $key => $value)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{$value->image_url}}" class="rounded-2" width="52" height="42">
                                            <div class="ms-3">
                                                <h6 class="fw-semibold mb-1">{{$value->title}}</h6>
                                                @if($value->status == 'active') <span class="fw-normal">Đang hoạt động</span> @endif
                                                @if($value->status == 'inactive') <span class="fw-normal">Đang khoá</span>  @endif
                                            </div>
                                        </div>
                                    </td>
    {{--                                <td>{{$value->redirect_url}}</td>--}}
                                    <td>
                                        <span class="fw-normal">Bắt đầu: {{date_format(date_create($value->start_date), 'h:s d/m/Y')}}</span><br>
                                        <span>Kết thúc: {{date_format(date_create($value->end_date), 'h:s d/m/Y')}}</span>
                                    </td>
                                    <td>{{$value->branch_name}}</td>
                                    <td>
                                        <div class="modal fade" id="modalUpdate{{$value->id}}" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <form action="{{route('banner.update',$value->id)}}" method="post" class="modal-content" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-header d-flex align-items-center">
                                                        <h4 class="modal-title" id="myLargeModalLabel">
                                                            Cập nhật banner
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mb-2">
                                                            <label class="form-label">Tên</label>
                                                            <input class="form-control" value="{{$value->title}}" name="name" required>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label class="d-block form-label">Hình ảnh(Tỷ lệ 2:1 1200x600px)</label>
                                                            <img src="{{$value->image_url}}" style="width: 200px;margin: 10px 0">
                                                            <input class="form-control" type="file" accept="image/png" name="image">
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label class="form-label">Đường link</label>
                                                            <input class="form-control" value="{{$value->redirect_url}}" name="link">
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label class="form-label d-block">Chi nhánh</label>
                                                            <select name="branch_id[]" multiple class="form-control selectpicker">
                                                                @foreach($branches as $branch)
                                                                    @php
                                                                        $check = \App\Models\BannerBranch::where('banner_id', $value->id)->where('branch_id', $branch->id)->exists();
                                                                    @endphp
                                                                    <option @if($check) selected @endif value="{{$branch->id}}">{{$branch->branch_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label class="form-label">Thời gian bắt đầu hiển thị</label>
                                                            <input class="form-control" name="time_start" value="{{$value->start_date}}" type="datetime-local" required>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label class="form-label">Thời gian kết thúc</label>
                                                            <input class="form-control" name="time_end" value="{{$value->end_date}}" type="datetime-local" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-start" data-bs-dismiss="modal">
                                                            Hủy
                                                        </button>
                                                        <button class="btn btn-primary">Xác nhận</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$value->id}}" style="margin-right: 15px">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                            </svg>
                                        </button>
                                        <a href="{{route('banner.delete',$value->id)}}" class="btn btn-danger btn-sa-confirm">
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
                <form action="{{route('banner.store')}}" method="post" class="modal-content" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label class="form-label">Tên</label>
                            <input class="form-control" name="name" required>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Hình ảnh(Tỷ lệ 2:1 1200x600px)</label>
                            <input class="form-control" type="file" accept="image/*" name="image" required>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Đường link</label>
                            <input class="form-control" name="redirect_url">
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label d-block">Chi nhánh</label>
                            <select name="branch_id[]" multiple class="form-control selectpicker">
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">
                                        {{ $branch->branch_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Thời gian bắt đầu hiển thị</label>
                            <input class="form-control" name="time_start" type="datetime-local" required>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Thời gian kết thúc</label>
                            <input class="form-control" name="time_end" type="datetime-local" required>
                        </div>
                        <div class="mb-3">
                            <label for="status"  class="form-label">Trạng thái</label>
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
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

    <script>
        $('.selectpicker').selectpicker();
    </script>
@endsection
