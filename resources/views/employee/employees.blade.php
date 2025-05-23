@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Danh sách nhân viên: {{$totalEmployees}}</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a class="text-muted text-decoration-none d-flex">
                                        <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                    </a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    <a href="{{route('config.employees-sync')}}" type="button" class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center">
                                        <i class="ti ti-send fs-4 me-2"></i>
                                        Đồng bộ nhân viên
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
                <form action="{{route('employees.employees')}}" method="get" class="row">
                    <div class="col-md-3 mb-2">
                        <input name="key_search" class="form-control"
                               placeholder="Tìm nhân viên"
                               value="{{request()->get('key_search')}}"
                        >
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="sort_kpi" class="form-control">
                            <option value="all" {{ request()->get('sort_kpi') == 'all' ? 'selected' : '' }}>Sắp xếp điểm</option>
                            <option value="high" {{ request()->get('sort_kpi') == 'high' ? 'selected' : '' }}>Điểm cao</option>
                            <option value="low" {{  request()->get('sort_kpi') == 'low' ? 'selected' : '' }}>Điểm thấp</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="sort_ratings" class="form-control">
                            <option value="all" {{ request()->get('sort_ratings') == 'all' ? 'selected' : '' }}>Sắp xếp đánh giá</option>
                            <option value="high" {{ request()->get('sort_ratings') == 'high' ? 'selected' : '' }}>Điểm cao</option>
                            <option value="low" {{  request()->get('sort_ratings') == 'low' ? 'selected' : '' }}>Điểm thấp</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="filter_kpi" class="form-control">
                            <option value="all" {{ request()->get('filter_kpi') == 'all' ? 'selected' : '' }}>Điểm mặc định</option>
                            <option value="30_50" {{ request()->get('filter_kpi') == '30_50' ? 'selected' : '' }}>30 - 50 điểm (Cảnh báo, cần cải thiện)</option>
                            <option value="50_70" {{ request()->get('filter_kpi') == '50_70' ? 'selected' : '' }}>50 - 70 điểm (Mức trung bình)</option>
                            <option value="70_90" {{ request()->get('filter_kpi') == '70_90' ? 'selected' : '' }}>70 - 90 điểm (Đạt yêu cầu)</option>
                            <option value="90_120" {{ request()->get('filter_kpi') == '90_120' ? 'selected' : '' }}>90 - 120 điểm (Tốt & Xuất sắc)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary" style="margin-right: 10px">Tìm kiếm</button>
                        <a href="{{route('employees.employees')}}" class="btn btn-danger" style="margin-right: 10px">Hủy</a>
                        <a href="{{ route('employees.export-employees',
                     ['key_search' => request('key_search'), 'sort_kpi' => request('sort_kpi'), 'sort_ratings' => request('sort_ratings'),
                      'filter_kpi' => request('filter_kpi')]) }}" class="btn btn-danger align-self-end">
                        <i class="ti ti-transition-right me-1 fs-4"></i>Xuất Excel</a>
                    </div>
                </form>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tài khoản</th>
                            <th>Điểm số trong tháng</th>
                            <th>Đánh giá nguy hiểm</th>
    {{--                        <th>⭐⭐⭐⭐⭐</th>--}}
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listData as $key => $item)
                            <tr>
                                <td>{{ ($listData->currentPage() - 1) * $listData->perPage() + $key + 1 }}</td>
                                <td>
                                    <span>{{$item->user_name}}</span><br>
                                    <span>{{$item->given_name}}</span>
                                </td>
                                <td>{{$item->kpi_points}}</td>
                                <td>{{$item->low_ratings}}</td>
    {{--                            <td>--}}
    {{--                                @if ($item->rating_1 > 0)--}}
    {{--                                    <span>{{ $item->rating_1 }} ⭐</span><br>--}}
    {{--                                @endif--}}
    {{--                                @if ($item->rating_2 > 0)--}}
    {{--                                    <span>{{ $item->rating_2 }} ⭐⭐</span><br>--}}
    {{--                                @endif--}}
    {{--                                @if ($item->rating_3 > 0)--}}
    {{--                                    <span>{{ $item->rating_3 }} ⭐⭐⭐</span><br>--}}
    {{--                                @endif--}}
    {{--                                @if ($item->rating_4 > 0)--}}
    {{--                                    <span>{{ $item->rating_4 }} ⭐⭐⭐⭐</span><br>--}}
    {{--                                @endif--}}
    {{--                                @if ($item->rating_5 > 0)--}}
    {{--                                    <span>{{ $item->rating_5 }} ⭐⭐⭐⭐⭐</span><br>--}}
    {{--                                @endif--}}
    {{--                            </td>--}}
                                <td>
                                    <a href="{{route('employees.employee-detail', ['id' => $item->kiotviet_id])}}" type="button" class="btn btn-info">
                                        Thông tin
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
        </div>
    </div>
@endsection
