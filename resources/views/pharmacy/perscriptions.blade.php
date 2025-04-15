@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Gửi đơn thuốc, hình ảnh: {{$total}}</h4>
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

                <form action="{{route('pharmacy.prescription')}}" method="get" class="d-flex">
                    <div class="col-md-4" style="margin-right: 10px">
                        <input name="key_search" class="form-control"
                               placeholder="Tên, SĐT, Địa chỉ"
                               value="{{request()->get('key_search')}}"
                        >
                    </div>

                    <button class="btn btn-primary" style="margin-right: 10px">Tìm kiếm</button>
                    <a href="{{route('pharmacy.prescription')}}" class="btn btn-danger" style="margin-right: 10px">Hủy</a>
                </form>

                <table class="table table-bordered mt-4">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>SĐT</th>
                        <th>Địa chỉ</th>
                        <th>Ngày gửi</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($listData->total() > 0)
                        @foreach($listData as $key => $value)
                            <tr>
                                <td>{{ ($listData->currentPage() - 1) * $listData->perPage() + $key + 1 }}</td>
                                <td>
                                    <h6>{{ $value->full_name }}</h6>
                                    @if($value->status == 'pending') <span>Chờ duyệt</span> @endif
                                    @if($value->status == 'processing') <span>Đang xử lý</span> @endif
                                    @if($value->status == 'done') <span>Hoàn tất</span> @endif
                                    @if($value->status == 'canceled') <span>Hủy</span> @endif
                                </td>
                                <td>{{ $value->phone }}</td>
                                <td>{{ $value->address }}</td>
                                <td>{{ $value->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{route('pharmacy.prescription-detail', ['id' => $value->id])}}" class="btn btn-primary">Xem thông tin</a>
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
@endsection
