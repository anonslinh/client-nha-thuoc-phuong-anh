@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Danh sách sản phẩm được tích điểm <span class="text-danger">Tổng: {{$listProduct->total()}} sản phẩm</span></h4>
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

        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Cài đặt tích điểm sản phẩm theo danh mục</span></h4>
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
                <div class="col-12 p-0 mt-4">
                    <form action="{{route('config.add-product')}}" method="post" class="row m-0">
                        @csrf
                        <div class="col-md-4 mb-2">
                            <select class="form-control" name="category" required>
                                <option value="">Chọn danh mục</option>
                                @foreach($category as $item)
                                    <option value="{{$item['id'].','.$item['retailer']}}">{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <input name="point" type="number" min="1" required class="form-control" placeholder="Số điểm được cộng">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-success">Cài đặt</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{route('config.list-product')}}" method="get" class="row">
                    <div class="col-md-4 mb-2">
                        <input name="key_search" class="form-control" placeholder="Tên, mã sản phẩm" value="">
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="category_id" class="form-control">
                            <option value="">Chọn danh mục</option>
                            @foreach($category as $item)
                                <option value="{{$item['id']}}" @if(request()->get('category_id') == $item['id']) selected @endif>{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <button class="btn btn-primary" style="margin-right: 10px">Tìm kiếm</button>
                        <a href="{{route('config.list-product')}}" class="btn btn-danger" style="margin-right: 10px">Hủy</a>
                        <a href="{{route('config.excel-product')}}" class="btn btn-danger align-self-end">
                            <i class="ti ti-transition-right me-1 fs-4"></i>Xuất Excel</a>
                    </div>
                </form>
                <form action="{{route('config.import-product')}}" method="post" class="row mt-4" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-4">
                        <input type="file" class="form-control" name="file" required="">
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
                            <th>Mã Sản Phẩm</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Số điểm</th>
                            <th>***</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listProduct->total() > 0)
                            @foreach($listProduct as $key => $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->code}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->point}}</td>
                                    <td>
                                        <a href="{{route('config.delete-product',$item->id)}}" class="btn btn-danger btn-sa-confirm">
                                            Xóa
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5"><p class="m-0 text-danger text-center">Không có dữ liệu</p></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 d-flex justify-content-center">{{$listProduct->appends(request()->all())->links('pagination')}}</div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('input[name="type_point"]').click(function () {
            $('input[name="type_point"]').prop('checked', false);
            $(this).prop('checked', true);
            $.ajax({
                url: "{{route('config.change-type-point')}}",
                type: "post",
                data: {"value" : $(this).val()},
                dataType: "json",
                success: function (data) {
                    setTimeout(function () {
                        location.reload();
                    }, 300);
                }
            })
        });
    </script>
@endsection
