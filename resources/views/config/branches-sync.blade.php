@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Đồng bộ chi nhánh</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a class="text-muted text-decoration-none d-flex">
                                        <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                    </a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    <a href="{{route('config.branches-sync')}}" type="button" class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center">
                                        <i class="ti ti-send fs-4 me-2"></i>
                                        Đồng bộ ngay
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Danh sách chi nhánh: {{$totalBranches}}</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên cửa hàng</th>
                        <th>Địa chỉ</th>
                        <th>SĐT</th>
{{--                        <th>Email</th>--}}
                        <th>Ngày tạo</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listData as $key => $item)
                        <tr>
                            <td>{{ ($listData->currentPage() - 1) * $listData->perPage() + $key + 1 }}</td>
                            <td>{{$item->branch_name}}</td>
                            <td>{{$item->address}}</td>
                            <td>{{$item->contact_number}}</td>
{{--                            <td>{{$item->email}}</td>--}}
                            <td>{{$item->created_date}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
        </div>
    </div>
@endsection
