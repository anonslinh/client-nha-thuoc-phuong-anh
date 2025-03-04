@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card w-100">
            <div class="card-header">
                <h3>Thêm sản phẩm vào sự kiện: {{$events->title}}</h3>
            </div>
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{session('error')}}
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{session('success')}}
                </div>
            @endif
            <div class="card-header">
                <p class="fw-bolder">Cài đặt sản phẩm theo nhóm hàng</p>
                <form action="" id="addProduct" class="d-flex align-items-center">
                    <select class="form-control" name="categoryID" required style="border-radius: inherit;max-width: 250px;margin-right: 15px">
                        <option value="">Nhóm hàng</option>
                        @foreach($categories as $item)
                            <option value="{{$item['categoryId']}}" @if(request()->get('id_category') == $item['categoryId']) selected @endif>{{$item['categoryName']}}</option>
                        @endforeach
                    </select>
                    <input name="point_category" class="form-control" required type="number" style="max-width: 200px;margin-right: 15px" placeholder="Số điểm">
                    <button class="btn btn-primary">Cài đặt</button>
                </form>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end align-items-center">
                    <input name="events_id" value="{{$events->id}}" hidden>
                    <form action="{{route('events.add-product',$events->id)}}" class="d-flex justify-content-end align-items-center w-75">
                        <select class="form-control" name="id_category" style="border-radius: inherit;max-width: 250px;margin-right: 15px">
                            <option value="">Nhóm hàng</option>
                            @foreach($categories as $item)
                                <option value="{{$item['categoryId']}}" @if(request()->get('id_category') == $item['categoryId']) selected @endif>{{$item['categoryName']}}</option>
                            @endforeach
                        </select>
                        <input class="form-control" style="border-radius: inherit;max-width: 250px;margin-right: 15px" value="{{request()->get('key_search')}}"
                               placeholder="Tìm kiếm..." name="key_search">
                        <button class="btn btn-outline-success" style="border-radius: inherit;margin-right: 15px">Tìm kiếm</button>
                        <a href="{{route('events.add-product',$events->id)}}" style="border-radius: inherit" class="btn btn-outline-danger">Hủy</a>
                    </form>
                </div>
                <div class="mt-4">
                    <div class=table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="align-middle">Thông tin</th>
                                <th class="align-middle">Hình ảnh</th>
                                <th class="align-middle">Điểm</th>
                                <th class="align-middle">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paginator as $key => $value)
                                @php
                                    $check = \App\Models\ProductsEvent::where('events_id', $events->id)->where('product_id', $value['id'])->first();
                                @endphp
                                <tr>
                                    <td class="align-middle">
                                        <input hidden name="product_id" value="{{$value['id']}}">
                                        <p class="m-0"><span class="text-danger">ID:</span> {{$value['id']}}</p>
                                        <p class="m-0"><span class="text-danger">Mã:</span> {{$value['code']}}</p>
                                        <p class="m-0" style="max-width: 250px">Tên: {{$value['name']}}</p>
                                        <p class="m-0">Danh mục: {{$value['categoryName']}}</p>
                                    </td>
                                    <td class="align-middle">
                                        @if(isset($value['images']))
                                            <img src="{{$value['images'][0]}}" style="width: 100px">
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <input class="form-control" name="point" type="number" min="1" value="{{isset($check) ? $check->point : ''}}">
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-success btn-add-product">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            <button class="btn btn-primary btn-import">Lấy SP Đã Điền Điểm</button>
                        </div>
                        <div class="d-flex justify-content-end">{{$paginator->appends(request()->all())->links('pagination')}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(".btn-add-product").click(function () {
                $(".loading").addClass("active");
                let data = [];
                let dataProduct = {};
                var parent = $(this).closest('tr');
                dataProduct['product_id'] = parent.find('input[name="product_id"]').val();
                dataProduct['point'] = parent.find('input[name="point"]').val();
                data.push(dataProduct);
                let dataParam = {};
                dataParam['events_id'] = $('input[name="events_id"]').val();
                dataParam['products'] = data;
                addProduct(dataParam);
            });
            $(".btn-import").click(function () {
                $(".loading").addClass("active");
                let data = [];
                $("tbody tr").each(function () {
                   let dataProduct = {};
                   var point = $(this).find('input[name="point"]').val();
                   if (point != ''){
                       dataProduct['point'] = point;
                       dataProduct['product_id'] = $(this).find('input[name="product_id"]').val();
                       data.push(dataProduct);
                   }
                });
                let dataParam = {};
                dataParam['events_id'] = $('input[name="events_id"]').val();
                dataParam['products'] = data;
                addProduct(dataParam);
            });
            function addProduct(data) {
                $.ajax({
                    url: "{{route('events.create-product')}}",
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        $(".loading").removeClass("active");
                        if (data.status){
                            Swal.fire(
                                "Thành công",
                                data.msg,
                                "success"
                            );
                        }
                    },
                    error: function (data) {
                        $(".loading").removeClass("active");
                        Swal.fire(
                            "Thêm sản phẩm thất bại",
                            data.responseJSON.msg,
                            "error"
                        );
                    }
                })
            }
            $("#addProduct").submit(function (ev) {
                ev.preventDefault();
                $(".loading").addClass("active");
                let data = {};
                data['events_id'] = $('input[name="events_id"]').val();
                data['point'] = $('input[name="point_category"]').val();
                data['category_id'] = $('select[name="categoryID"]').val();
                $.ajax({
                    url: "{{route('events.create-product-with-category')}}",
                    data: data,
                    type: "post",
                    dataType: "json",
                    success: function (data) {
                        $(".loading").removeClass("active");
                        if (data.status){
                            Swal.fire(
                                "Thành công",
                                data.msg,
                                "success"
                            );
                        }
                    },
                    error: function () {
                        $(".loading").removeClass("active");
                        Swal.fire(
                            "Thêm sản phẩm thất bại",
                            "Đã có lỗi xảy ra.Vui lòng kiểm tra lại",
                            "error"
                        );
                    }
                })
            })
        });
    </script>
@endsection
