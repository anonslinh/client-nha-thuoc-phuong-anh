@extends('Layout.index')
@section('content')
    <div class="container-fluid">
{{--        <div class="card card-body py-3">--}}
{{--            <div class="row align-items-center">--}}
{{--                <div class="col-12">--}}
{{--                    <div class="d-sm-flex align-items-center justify-space-between">--}}
{{--                        <h4 class="mb-4 mb-sm-0 card-title">{{$employee->given_name}}</h4>--}}
{{--                        <nav aria-label="breadcrumb" class="ms-auto">--}}
{{--                            <ol class="breadcrumb">--}}
{{--                                <li class="breadcrumb-item d-flex align-items-center">--}}
{{--                                    <a class="text-muted text-decoration-none d-flex">--}}
{{--                                        <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>--}}
{{--                                    </a>--}}
{{--                                </li>--}}

{{--                            </ol>--}}
{{--                        </nav>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="col-md-12">
            <div class="card">
                <div class="card-body pb-4">
                    <div class="d-md-flex align-items-center justify-content-between mb-4">
                        <div class="hstack align-items-center gap-3">
                      <span class="d-flex align-items-center justify-content-center round-48 bg-primary-subtle rounded flex-shrink-0">
                        <iconify-icon icon="solar:shield-user-line-duotoner" class="fs-7 text-primary"></iconify-icon>
                      </span>
                            <div>
                                <h5 class="card-title">{{$employee->given_name}}</h5>
                                <p class="card-subtitle mb-0">{{$points}}/70 điểm trong tháng</p>
                            </div>
                        </div>

                        <div class="hstack gap-9 mt-4 mt-md-0">
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-block flex-shrink-0 round-8 bg-primary rounded-circle"></span>
                                <span class="text-nowrap text-muted">Điểm</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-block flex-shrink-0 round-8 bg-secondary rounded-circle"></span>
                                <span class="text-nowrap text-muted">⭐ Nguy hiểm</span>
                            </div>
                        </div>
                    </div>
                    <div style="height: 285px;" class="me-n7">
                        <div id="revenue-forecast"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <form action="{{ route('employees.employee-detail', ['id' => $employee->kiotviet_id]) }}" method="get" class="d-flex align-items-end flex-wrap">
                    <div class="col-md-2" style="margin-right: 10px">
                        <label>Từ ngày</label>
                        <input name="from_date" class="form-control" type="datetime-local" value="{{ request()->get('from_date') }}">
                    </div>
                    <div class="col-md-2" style="margin-right: 10px">
                        <label>Đến ngày</label>
                        <input name="to_date" class="form-control" type="datetime-local" value="{{ request()->get('to_date') }}">
                    </div>
                    <div class="col-md-2" style="margin-right: 10px">
                        <label>&nbsp;</label>
                        <select name="rating" class="form-control">
                            <option value="" {{ request()->get('rating') == '' ? 'selected' : '' }}>Lọc theo số sao</option>
                            <option value="5" {{ request()->get('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 sao)</option>
                            <option value="4" {{ request()->get('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4 sao)</option>
                            <option value="3" {{ request()->get('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3 sao)</option>
                            <option value="2" {{ request()->get('rating') == '2' ? 'selected' : '' }}>⭐⭐ (2 sao)</option>
                            <option value="1" {{ request()->get('rating') == '1' ? 'selected' : '' }}>⭐ (1 sao)</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex" style="gap: 10px">
                        <button class="btn btn-primary align-self-end">Tìm kiếm</button>
                        <a href="{{ route('employees.employee-detail', ['id' => $employee->kiotviet_id]) }}" class="btn btn-danger align-self-end">Hủy</a>
                    </div>
                </form>

            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Hoá đơn</th>
                        <th>Sao</th>
                        <th>Nội dung</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listData as $key => $item)
                        <tr>
                            <td>{{ ($listData->currentPage() - 1) * $listData->perPage() + $key + 1 }}</td>
                            <td>
                                <span>{{ optional($item->invoice)->code }}</span><br>
                                <span>{{date_format(date_create($item->created_at), 'h:s d/m/Y')}}</span>
                            </td>
                            <td>
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $item->rating ? 'bi-star-fill text-warning' : 'bi-star text-secondary' }}"></i>
                                @endfor
                            </td>
                            <td>{{$item->comment}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
        </div>
    </div>
@endsection
