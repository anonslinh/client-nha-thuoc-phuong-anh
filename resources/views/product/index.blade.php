@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card w-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-4 mb-sm-0 card-title">Mua là có quà </h4>
                    @if(count($point))
                        <a href="{{route('events.product.create')}}" class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center">
                            <i class="ti ti-send fs-4 me-2"></i>
                            Thêm mới
                        </a>
                        @else
                        <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalAlert">
                            <i class="ti ti-send fs-4 me-2"></i>
                            Thêm mới
                        </button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="">
                    <form action="{{route('events.list-product')}}" class="row">
                        <div class="col-md-3 mb-2">
                            <select class="form-control" name="point" style="border-radius: inherit;">
                                <option value="">Tất cả</option>
                                @foreach($point as $item)
                                    <option value="{{$item}}" @if(request()->get('point') == $item) selected @endif>SP tích {{$item}} điểm</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <input class="form-control" style="border-radius: inherit;" value="{{request()->get('key_search')}}"
                               placeholder="Tìm kiếm..." name="key_search">
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-success" style="border-radius: inherit; margin-right:15px">Tìm kiếm</button>
                            <a href="{{route('events.list-product')}}" style="border-radius: inherit" class="btn btn-outline-danger">Hủy</a>
                        </div>
                    </form>
                </div>
                <div class="mt-4">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap">
                            <thead>
                            <tr>
                                <th class="align-middle">Tên / Mã SP</th>
                                <th class="align-middle">Hình ảnh</th>
                                <th class="align-middle">Điểm</th>
                                <th class="align-middle">Trạng thái</th>
                                <th class="align-middle">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($listProduct->total() > 0)
                                @foreach($listProduct as $key => $value)
                                    <tr>
                                        <td class="align-middle">
                                            <p class="m-0" style="max-width: 250px"><span class="text-success">Tên:</span> {{$value->name}}</p>
                                            <p class="m-0"><span class="text-warning">Mã:</span> {{$value->code}}</p>
                                        </td>
                                        <td class="align-middle">
                                            <div id="carouselExampleControls" class="carousel slide carousel-dark" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach($value['image'] as $k => $image)
                                                    <div class="carousel-item @if($k == 0) active @endif">
                                                        <img src="{{$image}}" class="d-block" style="width: 200px" alt="matdash-img" />
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">{{$value->point}}</td>
                                        <td class="align-middle">
                                            @if($value->is_active == 1) <span class="text-success">Hoạt động</span> @else <span class="text-danger">ẨN</span> @endif
                                        </td>
                                        <td class="align-middle">
                                            <div class="btn-group">
                                                <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Thao tác
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                                    <li>
                                                        <a href="{{route('events.detail-product',$value->id)}}" class="dropdown-item text-info">Chi tiết</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-success" href="{{route('events.list-gift-product', $value->id)}}">Xem quà tặng</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger btn-sa-confirm" href="{{route('events.product.delete', $value->id)}}">Xóa</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5"><p class="text-danger text-center">Không có dữ liệu</p> </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">{{$listProduct->appends(request()->all())->links('pagination')}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAlert" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title w-100 text-center" id="exampleModalLabel1">
                        Bạn chưa tạo quà tặng
                    </h4>
                </div>
                <div class="modal-body">
                    <p class="text-danger text-center fw-bolder" style="font-size: 20px">Vui lòng tạo quà tặng để tiếp tục</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <a href="{{route('events.gift.create')}}" class="btn btn-primary">Tạo quà tặng</a>
                </div>
            </div>
        </div>
    </div>
@endsection
