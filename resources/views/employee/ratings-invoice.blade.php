@extends('Layout.index')
@section('content')
    <div class="container-fluid">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body pb-4">
                    <div class="d-md-flex align-items-center justify-content-between mb-4">
                        <div class="hstack align-items-center gap-3">
                            <div>
                                <h5 class="card-title">Tổng quan đánh giá</h5>
                                <p class="card-subtitle mb-0">6 tháng qua</p>
                            </div>
                        </div>

                        <div class="hstack gap-9 mt-4 mt-md-0 flex-wrap">
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-block flex-shrink-0 round-8 bg-danger rounded-circle"></span>
                                <span class="text-nowrap text-muted">⭐</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-block flex-shrink-0 round-8 bg-primary rounded-circle"></span>
                                <span class="text-nowrap text-muted">⭐⭐</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-block flex-shrink-0 round-8 bg-warning rounded-circle"></span>
                                <span class="text-nowrap text-muted">⭐⭐⭐</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-block flex-shrink-0 round-8 bg-secondary rounded-circle"></span>
                                <span class="text-nowrap text-muted">⭐⭐⭐⭐</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-block flex-shrink-0 round-8 bg-success rounded-circle"></span>
                                <span class="text-nowrap text-muted">⭐⭐⭐⭐⭐</span>
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
            <div class="card-body">
                <form action="{{route('employees.ratings-invoice')}}" method="get" class="row">
                    <div class="col-md-3 mb-2">
                        <label>Từ ngày</label>
                        <input name="from_date" class="form-control" type="datetime-local" value="{{ request()->get('from_date') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>Đến ngày</label>
                        <input name="to_date" class="form-control" type="datetime-local" value="{{ request()->get('to_date') }}">
                    </div>
                    <div class="col-md-3 mb-2">
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
                    <div class="col-md-6">
                        <button class="btn btn-primary align-self-end">Tìm kiếm</button>
                        <a href="{{ route('employees.ratings-invoice') }}" class="btn btn-danger align-self-end">Hủy</a>
                        <a href="{{ route('employees.export-ratings-invoice', ['from_date' => request('from_date'), 'to_date' => request('to_date'), 'rating' => request('rating')]) }}"
                           class="btn btn-danger align-self-end">
                            <i class="ti ti-transition-right me-1 fs-4"></i>Xuất Excel</a>
                    </div>
                </form>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered text-nowrap">
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
                                    <span>{{ optional($item->invoice)->code }} - {{ number_format(optional($item->invoice)->total_payment) }}đ</span><br>
                                    <span>{{optional($item->invoice)->sold_by_name}}</span><br>
                                    <span>{{optional($item->invoice)->branch_name}}</span><br>
    {{--                                <span>{{ optional($item->invoice)->code }}</span><br>--}}

                                </td>
                                <td>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $item->rating ? 'bi-star-fill text-warning' : 'bi-star text-secondary' }}"></i>
                                    @endfor
                                        <br><span>{{date_format(date_create($item->created_at), 'h:s d/m/Y')}}</span>
                                </td>
                                <td>{{$item->comment}}</td>
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
@section('script')
    <script src="assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script>
        var months = {!! json_encode($months) !!};
        var chartSeries = {!! json_encode($chartSeries) !!};

        var chart = {
            series: chartSeries,
            chart: {
                toolbar: {
                    show: false,
                },
                type: "area",
                fontFamily: "inherit",
                foreColor: "#adb0bb",
                height: 300,
                width: "100%",
                stacked: false,
                offsetX: -10,
            },
            colors: ["var(--bs-danger)", "var(--bs-primary)", "var(--bs-warning)", "var(--bs-secondary)", "var(--bs-success)"],
            plotOptions: {},
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: false,
            },
            stroke: {
                width: 2,
                curve: "monotoneCubic",
            },
            grid: {
                show: true,
                padding: {
                    top: 0,
                    bottom: 0,
                },
                borderColor: "rgba(0,0,0,0.05)",
                xaxis: {
                    lines: {
                        show: true,
                    },
                },
                yaxis: {
                    lines: {
                        show: true,
                    },
                },
            },
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 0,
                    inverseColors: false,
                    opacityFrom: 0.1,
                    opacityTo: 0.01,
                    stops: [0, 100],
                },
            },
            xaxis: {
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
                categories: months,
            },
            markers: {
                strokeColor: [
                    "var(--bs-danger)",
                    "var(--bs-secondary)",
                    "var(--bs-primary)",
                ],
                strokeWidth: 2,
            },
            tooltip: {
                theme: "dark",
            },
        };

        var chart = new ApexCharts(
            document.querySelector("#revenue-forecast"),
            chart
        );
        chart.render();
    </script>
@endsection
