@extends('Layout.index')
@section('content')
    <div class="row">
        <div class="col-lg-5">
            <!-- -------------------------------------------- -->
            <!-- Welcome Card -->
            <!-- -------------------------------------------- -->
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
                                        <br />David
                                    </h5>
                                </div>
                                <div class="mt-4 mt-sm-auto">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="opacity-75">Budget</span>
                                            <h4 class="mb-0 text-white mt-1 text-nowrap fs-13 fw-bolder">
                                                $98,450</h4>
                                        </div>
                                        <div class="col-6 border-start border-light" style="--bs-border-opacity: .15;">
                                            <span class="opacity-75">Expense</span>
                                            <h4 class="mb-0 text-white mt-1 text-nowrap fs-13 fw-bolder">
                                                $2,440</h4>
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
                <!-- -------------------------------------------- -->
                <!-- Customers -->
                <!-- -------------------------------------------- -->
                <div class="col-md-6">
                    <div class="card bg-secondary-subtle overflow-hidden shadow-none">
                        <div class="card-body p-4">
                            <span class="text-dark-light">Customers</span>
                            <div class="hstack gap-6">
                                <h5 class="mb-0 fs-7">36,358</h5>
                                <span class="fs-11 text-dark-light fw-semibold">-12%</span>
                            </div>
                        </div>
                        <div id="customers"></div>
                    </div>
                </div>
                <!-- -------------------------------------------- -->
                <!-- Projects -->
                <!-- -------------------------------------------- -->
                <div class="col-md-6">
                    <div class="card bg-danger-subtle overflow-hidden shadow-none">
                        <div class="card-body p-4">
                            <span class="text-dark-light">Projects</span>
                            <div class="hstack gap-6 mb-4">
                                <h5 class="mb-0 fs-7">78,298</h5>
                                <span class="fs-11 text-dark-light fw-semibold">+31.8%</span>
                            </div>
                            <div class="mx-n1">
                                <div id="projects"></div>
                            </div>
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
                        <iconify-icon icon="solar:layers-linear" class="fs-7 text-primary"></iconify-icon>
                      </span>
                            <div>
                                <h5 class="card-title">Revenue Forecast</h5>
                                <p class="card-subtitle mb-0">Overview of Profit</p>
                            </div>
                        </div>

                        <div class="hstack gap-9 mt-4 mt-md-0">
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-block flex-shrink-0 round-8 bg-primary rounded-circle"></span>
                                <span class="text-nowrap text-muted">2024</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-block flex-shrink-0 round-8 bg-danger rounded-circle"></span>
                                <span class="text-nowrap text-muted">2023</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-block flex-shrink-0 round-8 bg-secondary rounded-circle"></span>
                                <span class="text-nowrap text-muted">2022</span>
                            </div>
                        </div>
                    </div>
                    <div style="height: 285px;" class="me-n7">
                        <div id="revenue-forecast"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <!-- -------------------------------------------- -->
            <!-- Your Performance -->
            <!-- -------------------------------------------- -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Your Performance</h5>
                    <p class="card-subtitle mb-0 lh-base">Last check on 25 february</p>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="vstack gap-9 mt-2">
                                <div class="hstack align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center round-48 rounded bg-primary-subtle flex-shrink-0">
                                        <iconify-icon icon="solar:shop-2-linear" class="fs-7 text-primary"></iconify-icon>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">64 new orders</h6>
                                        <span>Processing</span>
                                    </div>

                                </div>
                                <div class="hstack align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center round-48 rounded bg-danger-subtle">
                                        <iconify-icon icon="solar:filters-outline" class="fs-7 text-danger"></iconify-icon>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">4 orders</h6>
                                        <span>On hold</span>
                                    </div>

                                </div>
                                <div class="hstack align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center round-48 rounded bg-secondary-subtle">
                                        <iconify-icon icon="solar:pills-3-linear" class="fs-7 text-secondary"></iconify-icon>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">12 orders</h6>
                                        <span>Delivered</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center mt-sm-n7">
                                <div id="your-preformance"></div>
                                <h2 class="fs-8">275</h2>
                                <p class="mb-0">
                                    Learn insigs how to manage all aspects of your
                                    startup.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="row">
                <div class="col-md-6">
                    <!-- -------------------------------------------- -->
                    <!-- Customers -->
                    <!-- -------------------------------------------- -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <h5 class="card-title fw-semibold">Customers</h5>
                                    <p class="card-subtitle mb-0">Last 7 days</p>
                                </div>
                                <span class="fs-11 text-success fw-semibold lh-lg">+26.5%</span>
                            </div>
                            <div class="py-4 my-1">
                                <div id="customers-area"></div>
                            </div>
                            <div class="d-flex flex-column align-items-center gap-2 w-100 mt-3">
                                <div class="d-flex align-items-center gap-2 w-100">
                                    <span class="d-block flex-shrink-0 round-8 bg-primary rounded-circle"></span>
                                    <h6 class="fs-3 fw-normal text-muted mb-0">April 07 - April 14</h6>
                                    <h6 class="fs-3 fw-normal mb-0 ms-auto text-muted">6,380</h6>
                                </div>
                                <div class="d-flex align-items-center gap-2 w-100">
                                    <span class="d-block flex-shrink-0 round-8 bg-light rounded-circle"></span>
                                    <h6 class="fs-3 fw-normal text-muted mb-0">Last Week</h6>
                                    <h6 class="fs-3 fw-normal mb-0 ms-auto text-muted">4,298</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- -------------------------------------------- -->
                    <!-- Sales Overview -->
                    <!-- -------------------------------------------- -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">Sales Overview</h5>
                            <p class="card-subtitle mb-1">Last 7 days</p>

                            <div class="position-relative labels-chart">
                                <span class="fs-11 label-1">0%</span>
                                <span class="fs-11 label-2">25%</span>
                                <span class="fs-11 label-3">50%</span>
                                <span class="fs-11 label-4">75%</span>
                                <div id="sales-overview"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-8">
            <!-- -------------------------------------------- -->
            <!-- Revenue by Product -->
            <!-- -------------------------------------------- -->
            <div class="card mb-lg-0">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3 mb-9 justify-content-between align-items-center">
                        <h5 class="card-title fw-semibold mb-0">Revenue by Product</h5>
                        <select class="form-select w-auto fw-semibold">
                            <option value="1">Sep 2024</option>
                            <option value="2">Oct 2024</option>
                            <option value="3">Nov 2024</option>
                        </select>
                    </div>

                    <div class="table-responsive">
                        <ul class="nav nav-tabs theme-tab gap-3 flex-nowrap" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#app" role="tab">
                                    <div class="hstack gap-2">
                                        <iconify-icon icon="solar:widget-linear" class="fs-4"></iconify-icon>
                                        <span>App</span>
                                    </div>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#mobile" role="tab">
                                    <div class="hstack gap-2">
                                        <iconify-icon icon="solar:smartphone-line-duotone" class="fs-4"></iconify-icon>
                                        <span>Mobile</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#saas" role="tab">
                                    <div class="hstack gap-2">
                                        <iconify-icon icon="solar:calculator-linear" class="fs-4"></iconify-icon>
                                        <span>SaaS</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#other" role="tab">
                                    <div class="hstack gap-2">
                                        <iconify-icon icon="solar:folder-open-outline" class="fs-4"></iconify-icon>
                                        <span>Others</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content mb-n3">
                        <div class="tab-pane active" id="app" role="tabpanel">
                            <div class="table-responsive" data-simplebar>
                                <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="fw-normal ps-0">Assigned
                                        </th>
                                        <th scope="col" class="fw-normal">Progress</th>
                                        <th scope="col" class="fw-normal">Priority</th>
                                        <th scope="col" class="fw-normal">Budget</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-1.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Minecraf App</h6>
                                                    <span>Jason Roy</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success">Low</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-2.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Web App Project</h6>
                                                    <span>Mathew Flintoff</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning">Medium</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-3.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Modernize Dashboard</h6>
                                                    <span>Anil Kumar</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                <span class="badge bg-secondary-subtle text-secondary">Very
                                  High</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-4.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Dashboard Co</h6>
                                                    <span>George Cruize</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger-subtle text-danger">High</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="mobile" role="tabpanel">
                            <div class="table-responsive" data-simplebar>
                                <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="fw-normal ps-0">Assigned
                                        </th>
                                        <th scope="col" class="fw-normal">Progress</th>
                                        <th scope="col" class="fw-normal">Priority</th>
                                        <th scope="col" class="fw-normal">Budget</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-2.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Web App Project</h6>
                                                    <span>Mathew Flintoff</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning">Medium</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-3.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Modernize Dashboard</h6>
                                                    <span>Anil Kumar</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                <span class="badge bg-secondary-subtle text-secondary">Very
                                  High</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-1.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Minecraf App</h6>
                                                    <span>Jason Roy</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success">Low</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-4.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Dashboard Co</h6>
                                                    <span>George Cruize</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger-subtle text-danger">High</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="saas" role="tabpanel">
                            <div class="table-responsive" data-simplebar>
                                <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="fw-normal ps-0">Assigned
                                        </th>
                                        <th scope="col" class="fw-normal">Progress</th>
                                        <th scope="col" class="fw-normal">Priority</th>
                                        <th scope="col" class="fw-normal">Budget</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-2.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Web App Project</h6>
                                                    <span>Mathew Flintoff</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning">Medium</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-1.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Minecraf App</h6>
                                                    <span>Jason Roy</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success">Low</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-3.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Modernize Dashboard</h6>
                                                    <span>Anil Kumar</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                <span class="badge bg-secondary-subtle text-secondary">Very
                                  High</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-4.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Dashboard Co</h6>
                                                    <span>George Cruize</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger-subtle text-danger">High</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane" id="other" role="tabpanel">
                            <div class="table-responsive" data-simplebar>
                                <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="fw-normal ps-0">Assigned
                                        </th>
                                        <th scope="col" class="fw-normal">Progress</th>
                                        <th scope="col" class="fw-normal">Priority</th>
                                        <th scope="col" class="fw-normal">Budget</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-1.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Minecraf App</h6>
                                                    <span>Jason Roy</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success">Low</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-3.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Modernize Dashboard</h6>
                                                    <span>Anil Kumar</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                <span class="badge bg-secondary-subtle text-secondary">Very
                                  High</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-2.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Web App Project</h6>
                                                    <span>Mathew Flintoff</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning">Medium</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="../assets/images/products/dash-prd-4.jpg" alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">Dashboard Co</h6>
                                                    <span>George Cruize</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>73.2%</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger-subtle text-danger">High</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-light">$3.5k</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <!-- -------------------------------------------- -->
            <!-- Total settlements -->
            <!-- -------------------------------------------- -->
            <div class="card bg-primary-subtle mb-0">
                <div class="card-body">
                    <div class="hstack align-items-center gap-3 mb-4">
                    <span class="d-flex align-items-center justify-content-center round-48 bg-white rounded flex-shrink-0">
                      <iconify-icon icon="solar:box-linear" class="fs-7 text-primary"></iconify-icon>
                    </span>
                        <div>
                            <p class="mb-1 text-dark-light">Total settlements</p>
                            <h4 class="mb-0 fw-bolder">$122,580</h5>
                        </div>
                    </div>
                    <div style="height: 278px;">
                        <div id="settlements"></div>
                    </div>
                    <div class="row mt-4 mb-2">
                        <div class="col-md-6 text-center">
                            <p class="mb-1 text-dark-light lh-lg">Total balance</p>
                            <h4 class="mb-0 text-nowrap">$122,580</h4>
                        </div>
                        <div class="col-md-6 text-center mt-3 mt-md-0">
                            <p class="mb-1 text-dark-light lh-lg">Withdrawals</p>
                            <h4 class="mb-0">$31,640</h4>
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
        var options = {
          chart: {
            id: "customers",
            type: "area",
            height: 70,
            sparkline: {
              enabled: true,
            },
            group: "sparklines",
            fontFamily: "inherit",
            foreColor: "#adb0bb",
          },
          series: [
            {
              name: "customers",
              color: "var(--bs-secondary)",
              data: [36, 45, 31, 47, 38, 43],
            },
          ],
          stroke: {
            curve: "smooth",
            width: 2,
          },
          fill: {
            type: "gradient",
            color: "var(--bs-secondary)",

            gradient: {
              shadeIntensity: 0,
              inverseColors: false,
              opacityFrom: 0.2,
              opacityTo: 0.1,
              stops: [100],
            },
          },

          markers: {
            size: 0,
          },
          tooltip: {
            theme: "dark",
            fixed: {
              enabled: true,
              position: "right",
            },
            x: {
              show: false,
            },
          },
        };
        new ApexCharts(document.querySelector("#customers"), options).render();
        var chart_bounce_rate = {
          series: [
            {
              name: "Project",
              labels: ["2012", "2013", "2014", "2015", "2016", "2017"],
              data: [3, 5, 5, 7, 6, 5, 3, 5, 3],
            },
          ],
          chart: {
            fontFamily: "inherit",
            height: 46,
            type: "bar",
            offsetX: -10,
            toolbar: {
              show: false,
            },
            sparkline: {
              enabled: true,
            },
          },
          colors: ["var(--bs-white)"],
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: "55%",
              endingShape: "flat",
              borderRadius: 4,
            },
          },
          tooltip: {
            theme: "dark",
            followCursor: true,
          },
        };
        var chart_line_basic = new ApexCharts(
          document.querySelector("#projects"),
          chart_bounce_rate
        );
        chart_line_basic.render();

        var chart = {
          series: [
            {
              name: "2023",
              data: [50, 60, 30, 55, 75, 60, 100, 120],
            },

            {
              name: "2022",
              data: [35, 45, 40, 50, 35, 55, 40, 45],
            },
            {
              name: "2024",
              data: [100, 75, 80, 40, 20, 40, 0, 25],
            },
          ],
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
          colors: ["var(--bs-danger)", "var(--bs-secondary)", "var(--bs-primary)"],
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
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "July", "Aug"],
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

        var options = {
          series: [20, 20, 20, 20, 20],
          labels: ["245", "45", "14", "78", "95"],
          chart: {
            height: 205,
            fontFamily: "inherit",
            type: "donut",
          },
          plotOptions: {
            pie: {
              startAngle: -90,
              endAngle: 90,
              offsetY: 10,
              donut: {
                size: "90%",
              },
            },
          },
          grid: {
            padding: {
              bottom: -80,
            },
          },
          legend: {
            show: false,
          },
          dataLabels: {
            enabled: false,
            name: {
              show: false,
            },
          },
          stroke: {
            width: 2,
            colors: "var(--bs-card-bg)",
          },
          tooltip: {
            fillSeriesColor: false,
          },
          colors: [
            "var(--bs-danger)",
            "var(--bs-warning)",
            "var(--bs-warning-bg-subtle)",
            "var(--bs-secondary-bg-subtle)",
            "var(--bs-secondary)",
          ],
          responsive: [{
            breakpoint: 1400,
            options: {
              chart: {
                height: 170
              },
            },
          }],
        };

        var chart = new ApexCharts(
          document.querySelector("#your-preformance"),
          options
        );
        chart.render();
        var chart_users = {
          series: [
            {
              name: "April 07 ",
              data: [0, 20, 15, 19, 14, 25, 30],
            },
            {
              name: "Last Week",
              data: [0, 8, 19, 13, 26, 16, 25],
            },
          ],
          chart: {
            fontFamily: "inherit",
            height: 100,
            type: "line",
            toolbar: {
              show: false,
            },
            sparkline: {
              enabled: true,
            },
          },
          colors: ["var(--bs-primary)", "var(--bs-primary-bg-subtle)"],
          grid: {
            show: false,
          },
          stroke: {
            curve: "smooth",
            colors: ["var(--bs-primary)", "var(--bs-primary-bg-subtle)"],
            width: 2,
          },
          markers: {
            colors: ["var(--bs-primary)", "var(--bs-primary-bg-subtle)"],
            strokeColors: "transparent",
          },
          tooltip: {
            theme: "dark",
            x: {
              show: false,
            },
            followCursor: true,
          },
        };
        var chart_line_basic = new ApexCharts(
          document.querySelector("#customers-area"),
          chart_users
        );
        chart_line_basic.render();

        // -----------------------------------------------------------------------
        // Sales Overview
        // -----------------------------------------------------------------------
        var options = {
          series: [50, 80, 30],
          labels: ["36%", "10%", "36%"],
          chart: {
            type: "radialBar",
            height: 230,
            fontFamily: "inherit",
            foreColor: "#c6d1e9",
          },
          plotOptions: {
            radialBar: {
              inverseOrder: false,
              startAngle: 0,
              endAngle: 270,
              hollow: {
                margin: 1,
                size: "40%",
              },
              dataLabels: {
                show: false,
              },
            },
          },
          legend: {
            show: false,
          },
          stroke: { width: 1, lineCap: "round" },
          tooltip: {
            enabled: false,
            fillSeriesColor: false,
          },
          colors: ["var(--bs-primary)", "var(--bs-secondary)", "var(--bs-danger)"],
        };

        var chart = new ApexCharts(
          document.querySelector("#sales-overview"),
          options
        );
        chart.render();

        // -----------------------------------------------------------------------
        // Total settlements
        // -----------------------------------------------------------------------
        var settlements = {
          series: [
            {
              name: "settlements",
              data: [
                40, 40, 80, 80, 30, 30, 10, 10, 30, 30, 100, 100, 20, 20, 140, 140,
              ],
            },
          ],
          chart: {
            fontFamily: "inherit",
            type: "line",
            height: 300,
            toolbar: { show: !1 },
          },
          legend: { show: !1 },
          dataLabels: { enabled: !1 },
          stroke: {
            curve: "smooth",
            show: !0,
            width: 2,
            colors: ["var(--bs-primary)"],
          },
          xaxis: {
            categories: [
              "1W",
              "",
              "3W",
              "",
              "5W",
              "6W",
              "7W",
              "8W",
              "9W",
              "",
              "11W",
              "",
              "13W",
              "",
              "15W",
            ],
            axisBorder: { show: !1 },
            axisTicks: { show: !1 },
            tickAmount: 6,
            labels: {
              rotate: 0,
              rotateAlways: !0,
              style: { fontSize: "10px", colors: "#adb0bb", fontWeight: "600" },
            },
          },
          yaxis: {
            show: false,
            tickAmount: 3,
          },
          tooltip: {
            theme: "dark",
          },
          colors: ["var(--bs-primary)"],
          grid: {
            borderColor: "var(--bs-primary-bg-subtle)",
            strokeDashArray: 4,
            yaxis: { show: false },
          },
          markers: {
            strokeColor: ["var(--bs-primary)"],
            strokeWidth: 3,
          },
        };

        var chart_area_spline = new ApexCharts(
          document.querySelector("#settlements"),
          settlements
        );
        chart_area_spline.render();
    </script>
@endsection
