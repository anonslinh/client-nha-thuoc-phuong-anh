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
                                        <h5 class="text-white fs-6 mb-0 text-nowrap">{{$customer->code}}
                                            <br />{{$customer->name}}
                                            <br />{{$customer->contact_number}}
                                        </h5>
                                    </div>
                                    <div class="mt-4 mt-sm-auto">
                                        <div class="row">
                                            <div class="col-6">
                                                <span class="opacity-75">Chi tiêu</span>
                                                <span class="opacity-75">{{number_format($customer->total_revenue)}}đ</span>
                                            </div>
                                            <div class="col-6 border-start border-light" style="--bs-border-opacity: .15;">
                                                <span class="opacity-75">Tổng điểm</span>
                                                <span class="opacity-75">{{$customer->reward_point}}</span>
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
                                <span class="text-dark-light"></span>
                                <div class="hstack gap-6 mb-4">
{{--                                    <h5 class="mb-0 fs-7">{{$gift_exchange}}</h5>--}}
                                </div>
{{--                                <a href="{{route('customer.exchange-gift')}}" class="btn btn-white fs-2 fw-semibold text-nowrap">Xem chi tiết</a>--}}
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-danger-subtle overflow-hidden shadow-none">
                            <div class="card-body p-4">
                                <span class="text-dark-light"></span>
                                <div class="hstack gap-6 mb-4">
{{--                                    <h5 class="mb-0 fs-7">{{$voucher_exchange}}</h5>--}}
                                </div>
{{--                                <a href="{{route('customer.exchange-voucher')}}" class="btn btn-white fs-2 fw-semibold text-nowrap">Xem chi tiết</a>--}}
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
                                    <h5 class="card-title">Tổng chi tiêu</h5>
                                    <p class="card-subtitle mb-0">7 tháng gần nhất</p>
                                </div>
                            </div>
                            <div class="hstack gap-9 mt-4 mt-md-0">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-block flex-shrink-0 round-8 bg-danger rounded-circle"></span>
                                    <span class="text-nowrap text-muted">Tổng chi tiêu</span>
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
                            <h5 class="card-title fw-semibold mb-0">Thông tin con</h5>
                            <nav aria-label="breadcrumb" class="ms-auto">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item" aria-current="page">
                                        <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalCreateChild">
                                            <i class="ti ti-send fs-4 me-2"></i>
                                            Thêm mới
                                        </button>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <!-- Modal thêm con -->
                        <div class="modal fade" id="modalCreateChild" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header d-flex align-items-center">
                                        <h4 class="modal-title" id="myLargeModalLabel">
                                            Thêm con
                                        </h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('crm-customers.store-child', ['customer_id' => $customer->kiotviet_id, 'contact_number' => $customer->contact_number])}}" method="post" class="modal-content" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Tên con</label>
                                                <input class="form-control" name="name" required>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Trạng thái</label>
                                                <select name="status" class="form-control">
                                                    <option value="born">Đã sinh</option>
                                                    <option value="pregnant">Mang bầu</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Giới tính</label>
                                                <select name="gender" class="form-control ">
                                                    <option value="male">Bé trai</option>
                                                    <option value="female">Bé gái</option>
                                                    <option value="unknown">Không xác định</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Ngày sinh hoặc dư kiến</label>
                                                <input class="form-control" name="date_of_birth" type="date" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <button class="btn btn-primary">Xác nhận</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content mb-n3">
                            <div class="tab-pane active" id="app" role="tabpanel">
                                <div class="table-responsive" data-simplebar>
                                    <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="fw-normal ps-0">STT</th>
                                            <th scope="col" class="fw-normal">Tên bé</th>
                                            <th scope="col" class="fw-normal">Giới tính</th>
                                            <th scope="col" class="fw-normal">Trạng thái</th>
                                            <th scope="col" class="fw-normal">Ngày sinh hoặc dư kiến</th>
                                            <th scope="col" class="fw-normal">Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($children as $k => $_child)
                                            <tr>
                                                <td class="ps-0">{{$k+1}}</td>
                                                <td>
                                                    <span>{{$_child->name}}</span><br>
                                                    <span>{{$_child->display_info}}</span>
                                                </td>
                                                <td>
                                                    @if($_child->gender == 'male') <span>Bé trai</span> @endif
                                                    @if($_child->gender == 'female') <span>Bé gái</span> @endif
                                                    @if($_child->gender == 'unknown') <span>Không xác định</span> @endif
                                                </td>
                                                <td>
                                                    @if($_child->status == 'pregnant') <span>Đang mang bầu</span> @endif
                                                    @if($_child->status == 'born') <span>Đã sinh</span> @endif
                                                </td>
                                                <td>
                                                    @if($_child->status == 'pregnant' && $_child->due_date)
                                                        <span>{{ \Carbon\Carbon::parse($_child->due_date)->format('d/m/Y') }}</span>
                                                    @endif
                                                    @if($_child->status == 'born' && $_child->dob)
                                                        <span>{{ \Carbon\Carbon::parse($_child->dob)->format('d/m/Y') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="dropdown-item text-danger btn-sa-confirm" href="{{route('crm-customers.delete-child', ['child_id' => $_child->id])}}">Xóa</a>
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
                            <h5 class="card-title fw-semibold mb-0">Ghi chú</h5>
                            <nav aria-label="breadcrumb" class="ms-auto">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item" aria-current="page">
                                        <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalCreateNote">
                                            <i class="ti ti-send fs-4 me-2"></i>
                                            Thêm mới
                                        </button>
                                    </li>
                                </ol>
                            </nav>
                        </div>

                        <!-- Modal thêm ghi chú -->
                        <div class="modal fade" id="modalCreateNote" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header d-flex align-items-center">
                                        <h4 class="modal-title" id="myLargeModalLabel">
                                            Ghi chú khách hàng
                                        </h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('crm-customers.store-customer-note', ['customer_id' => $customer->kiotviet_id, 'contact_number' => $customer->contact_number])}}" method="post" class="modal-content" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Nội dung</label>
                                                <textarea style="height: 150px" class="form-control" name="note" required></textarea>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Lịch gọi lại</label>
                                                <input class="form-control" name="schedule_date" type="date">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <button class="btn btn-primary">Xác nhận</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content mb-n3">
                            <div class="tab-pane active" id="app" role="tabpanel">
                                <div class="table-responsive" data-simplebar>
                                    <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="fw-normal">Ngày ghi chú</th>
                                            <th scope="col" class="fw-normal">Lịch gọi lại</th>
                                            <th scope="col" class="fw-normal">Nội dung</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($customer_notes as $note)
                                            <tr>
                                                <td class="ps-0">
                                                    <span>{{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y') }}</span>
                                                </td>
                                                <td>
                                                    @if($note->schedule_date) <span>{{ \Carbon\Carbon::parse($note->schedule_date)->format('d/m/Y') }}</span> @endif
                                                </td>
                                                <td>
                                                    <span>{{$note->note}}</span>
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
                                <h5 class="card-title fw-semibold mb-0">Lịch sử mua sắm</h5>
                            </div>
                        </div>

                        <div class="tab-content mb-n3">
                            <div class="tab-pane active" id="app" role="tabpanel">
                                <div class="table-responsive" data-simplebar>
                                    <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="fw-normal ps-0">STT</th>
                                            <th scope="col" class="fw-normal">Sản phẩm</th>
                                            <th scope="col" class="fw-normal">Cửa hàng</th>
                                            <th scope="col" class="fw-normal">Ngày mua</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoice_details as $key => $invoice_detail)
                                            <tr>
                                                <td>
                                                    <span>{{$key+1}}</span>
                                                </td>
                                                <td>
                                                    <span>{{$invoice_detail->product_name}}</span><br>
                                                    <span>SKU: {{$invoice_detail->product_code}}</span><br>
                                                    <span>SL: {{$invoice_detail->quantity}}</span><br>
                                                    <span>Tổng tiền: {{number_format($invoice_detail->sub_total)}}đ</span><br>
                                                </td>
                                                <td>
                                                    <span>{{$invoice_detail->sold_by_name}}</span><br>
                                                    <span>{{$invoice_detail->branch_name}}</span><br>
                                                </td>
                                                <td>
                                                    <span>{{$invoice_detail->created_date}}</span><br>
                                                    <span class="text-danger">Đã mua: {{$invoice_detail->days_since_purchase}} ngày</span><br>
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
        var months = {!! json_encode($spending_summary['months']) !!};
        var chartSeries = {!! json_encode($spending_summary['series']) !!};

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
          colors: ["var(--bs-danger)", "var(--bs-secondary)", "var(--bs-primary)", "var(--bs-warning)", "var(--bs-info)"],
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
              "var(--bs-info)",
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
