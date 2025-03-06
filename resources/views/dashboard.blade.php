@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5">
                <div class="card text-bg-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="d-flex flex-column h-100">
                                    <div class="hstack gap-3">
                          <span class="d-flex align-items-center justify-content-center round-48 bg-white rounded flex-shrink-0">
                            <iconify-icon icon="solar:course-up-outline" class="fs-7 text-muted"></iconify-icon>
                          </span>
                                        <h5 class="text-white fs-6 mb-0 text-nowrap">Welcome Back
                                            <br />{{$user->name}}
                                        </h5>
                                    </div>
                                    <div class="mt-4 mt-sm-auto">
                                        <div class="row">
                                            <div class="col-6">
                                                <span class="opacity-75">Truy cập</span>
                                                <h5 class="mb-0 text-white mt-1 text-nowrap fs-13 fw-bolder">{{$totalAccess}}</h5>
                                                <span class="opacity-75">lần</span>
                                            </div>
                                            <div class="col-6 border-start border-light" style="--bs-border-opacity: .15;">
                                                <span class="opacity-75">Khách hàng</span>
                                                <h5 class="mb-0 text-white mt-1 text-nowrap fs-13 fw-bolder">{{$totalCustomers}}</h5>
                                                <span class="opacity-75">tài khoản</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-md-end">
                                <img src="../assets/images/backgrounds/welcome-bg.png" alt="welcome" class="img-fluid mb-n7 mt-2" width="180" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-secondary-subtle overflow-hidden shadow-none">
                            <div class="card-body p-4">
                                <span class="text-dark-light">Qùa tặng</span>
                                <div class="hstack gap-6 mb-4">
                                    <h5 class="mb-0 fs-7">{{$gift_exchange}}</h5>
                                </div>
                                <a href="{{route('customer.exchange-gift')}}" class="btn btn-white fs-2 fw-semibold text-nowrap">Xem chi tiết</a>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-danger-subtle overflow-hidden shadow-none">
                            <div class="card-body p-4">
                                <span class="text-dark-light">Voucher</span>
                                <div class="hstack gap-6 mb-4">
                                    <h5 class="mb-0 fs-7">{{$voucher_exchange}}</h5>
                                </div>
                                <a href="{{route('customer.exchange-voucher')}}" class="btn btn-white fs-2 fw-semibold text-nowrap">Xem chi tiết</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <!-- -------------------------------------------- -->
                <!-- Revenue Forecast -->
                <!-- -------------------------------------------- -->
                <div class="card">
                    <div class="card-body pb-4">
                        <div class="d-md-flex align-items-center justify-content-between mb-4">
                            <div class="hstack align-items-center gap-3">
                      <span class="d-flex align-items-center justify-content-center round-48 bg-primary-subtle rounded flex-shrink-0">
                        <iconify-icon icon="solar:atom-line-duotone" class="fs-7 text-primary"></iconify-icon>
                      </span>
                                <div>
                                    <h5 class="card-title">Lượt truy cập</h5>
                                    <p class="card-subtitle mb-0">7 ngày gần nhất</p>
                                </div>
                            </div>
                            <div class="hstack gap-9 mt-4 mt-md-0">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-block flex-shrink-0 round-8 bg-danger rounded-circle"></span>
                                    <span class="text-nowrap text-muted">Truy cập</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-block flex-shrink-0 round-8 bg-secondary rounded-circle"></span>
                                    <span class="text-nowrap text-muted">Điểm</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-block flex-shrink-0 round-8 bg-primary rounded-circle"></span>
                                    <span class="text-nowrap text-muted">Quà voucher</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-block flex-shrink-0 round-8 bg-warning rounded-circle"></span>
                                    <span class="text-nowrap text-muted">Đánh giá</span>
                                </div>
                            </div>
                        </div>
                        <div style="height: 285px;" class="me-n7">
                            <div id="revenue-forecast"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-3 mb-9 justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title fw-semibold mb-0">Đánh giá hoá đơn</h5>
                                <span class="text-dark-light">Hôm nay</span>
                            </div>
                            <a href="{{route('employees.ratings-invoice')}}" class="btn btn-white fs-2 fw-semibold text-nowrap">Xem tất cả</a>
                        </div>

                        <div class="tab-content mb-n3">
                            <div class="tab-pane active" id="app" role="tabpanel">
                                <div class="table-responsive" data-simplebar>
                                    <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="fw-normal ps-0">Hoá đơn</th>
                                            <th scope="col" class="fw-normal">Sao</th>
                                            <th scope="col" class="fw-normal">Nội dung</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($ratings as $rating)
                                            <tr>
                                                <td class="ps-0">
                                                    <span>{{$rating->invoice->code}} - {{number_format($rating->invoice->total_payment)}}đ</span><br>
                                                    <span>{{$rating->invoice->sold_by_name}}</span><br>
                                                    <span>{{$rating->invoice->branch_name}}</span>
                                                </td>
                                                <td>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="bi {{ $i <= $rating->rating ? 'bi-star-fill text-warning' : 'bi-star text-secondary' }}"></i>
                                                    @endfor
                                                </td>
                                                <td>
                                                    <span>{{$rating->comment}}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-3 mb-9 justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title fw-semibold mb-0">Nhân viên</h5>
                                <span class="text-dark-light">⚠ Cảnh báo</span>
                            </div>
                            <a href="{{route('employees.employees')}}" class="btn btn-white fs-2 fw-semibold text-nowrap">Xem tất cả</a>
                        </div>

                        <div class="tab-content mb-n3">
                            <div class="tab-pane active" id="app" role="tabpanel">
                                <div class="table-responsive" data-simplebar>
                                    <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="fw-normal ps-0">Tài khoản</th>
                                            <th scope="col" class="fw-normal">Điểm số trong tháng</th>
                                            <th scope="col" class="fw-normal">Đánh giá nguy hiểm</th>
                                            <th scope="col" class="fw-normal">Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($employees as $employee)
                                            <tr>
                                                <td>
                                                    <span>{{$employee->user_name}}</span><br>
                                                    <span>{{$employee->given_name}}</span>
                                                </td>
                                                <td><span>{{$employee->kpi_points}}</span></td>
                                                <td><span>{{$employee->low_ratings}}</span></td>
                                                <td>
                                                    <a href="{{route('employees.employee-detail', ['id' => $employee->kiotviet_id])}}" type="button" class="btn btn-info">
                                                        Thông tin
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mb-lg-0">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-3 mb-9 justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title fw-semibold mb-0">Danh sách khách hàng</h5>
                                <span class="text-dark-light">Khách hàng mới hôm nay</span>
                            </div>
                            <a href="{{route('customer')}}" class="btn btn-white fs-2 fw-semibold text-nowrap">Xem tất cả</a>
                        </div>

                        <div class="tab-content mb-n3">
                            <div class="tab-pane active" id="app" role="tabpanel">
                                <div class="table-responsive" data-simplebar>
                                    <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="fw-normal ps-0">Khách hàng</th>
                                            <th scope="col" class="fw-normal">Tổng chi tiêu</th>
                                            <th scope="col" class="fw-normal">Tổng đơn hàng</th>
                                            <th scope="col" class="fw-normal">Tổng điểm</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($customers as $customer)
                                            <tr>
                                                <td>
                                                    <span>{{$customer->code}}</span><br>
                                                    <span>{{$customer->name}} - {{$customer->contact_number}}</span>
                                                </td>
                                                <td>
                                                    <span>{{number_format($customer->total_revenue)}}đ</span>
                                                </td>
                                                <td>
                                                    <span>{{$customer->total_orders}}</span>
                                                </td>
                                                <td>
                                                    <span>{{$customer->kiotviet_reward_point - $customer->used_points}}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script>
        var months = {!! json_encode($activity_summary['dates']) !!};
        var chartSeries = {!! json_encode($activity_summary['series']) !!};

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
          colors: ["var(--bs-danger)", "var(--bs-secondary)", "var(--bs-primary)", "var(--bs-warning)"],
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
              "var(--bs-warning)",
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
