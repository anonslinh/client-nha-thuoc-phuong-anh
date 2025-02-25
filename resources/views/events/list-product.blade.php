@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card w-100">
            <div class="card-header">
                <h3>Danh sách sản phẩm trong sự kiện</h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end align-items-center">
                    <form action="{{route('events.list-product')}}" class="d-flex justify-content-end align-items-center w-75">
                        <select class="form-control" name="events_id" style="border-radius: inherit;max-width: 250px;margin-right: 15px">
                            <option value="">Sự kiện</option>
                            @foreach($events as $item)
                                <option value="{{$item->id}}" @if(request()->get('events_id') == $item->id) selected @endif>{{$item->title}}</option>
                            @endforeach
                        </select>
                        <input class="form-control" style="border-radius: inherit;max-width: 250px;margin-right: 15px" value="{{request()->get('key_search')}}"
                               placeholder="Tìm kiếm..." name="key_search">
                        <button class="btn btn-outline-success" style="border-radius: inherit;margin-right: 15px">Tìm kiếm</button>
                        <a href="{{route('events.list-product')}}" style="border-radius: inherit" class="btn btn-outline-danger">Hủy</a>
                    </form>
                </div>
                <div class="mt-4">
                    <div class=table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="align-middle">Thông tin</th>
                                <th class="align-middle">Sự kiện</th>
                                <th class="align-middle">Điểm</th>
                                <th class="align-middle">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($listData as $key => $value)
                                <tr>
                                    <td class="align-middle">
                                        <p class="m-0"><span class="text-danger">ID:</span> {{$value->product_id}}</p>
                                        <p class="m-0"><span class="text-warning">Mã:</span> {{$value->product_code}}</p>
                                        <p class="m-0" style="max-width: 250px"><span class="text-success">Tên:</span> {{$value->name}}</p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="m-0 text-danger">{{$value->events}}</p>
                                    </td>
                                    <td class="align-middle">{{$value->point}}</td>
                                    <td class="align-middle">

                                        <div class="modal fade" id="modalUpdate{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form action="{{route('events.product.update',$value->id)}}" method="post" class="modal-content">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật điểm sản phẩm</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mb-2">
                                                            <label>Tên</label>
                                                            <p class="m-0 text-success">{{$value->name}}</p>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label>Mã</label>
                                                            <p class="m-0 text-success">{{$value->product_code}}</p>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label>Điểm quy đổi</label>
                                                            <input class="form-control" value="{{$value->point}}" name="point" type="number" min="0" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                        <button class="btn btn-primary">Xác nhận</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="btn-group">
                                            <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Thao tác
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                                <li>
                                                    <button data-bs-toggle="modal" data-bs-target="#modalUpdate{{$value->id}}" class="dropdown-item">Sửa điểm</button>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item btn-sa-confirm" href="{{route('events.product.delete', $value->id)}}">Xóa</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">{{$listData->appends(request()->all())->links('pagination')}}</div>
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
        });
    </script>
@endsection
