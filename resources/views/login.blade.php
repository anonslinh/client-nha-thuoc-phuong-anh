<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{asset('')}}">
    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />

    <!-- Core Css -->
    <link rel="stylesheet" href="assets/css/styles.css" />

    <title>Win Win Group</title>
</head>

<body>
<!-- Preloader -->
<div class="preloader">
    <img src="../assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
</div>
<div id="main-wrapper">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
        <div class="position-relative z-index-5">
            <div class="row gx-0">

                <div class="col-lg-6 col-xl-5 col-xxl-4">
                    <div class="min-vh-100 bg-body row justify-content-center align-items-center p-5">
                        <div class="col-12 auth-card">
                            <a href="/" class="text-nowrap logo-img d-block w-100">
                                <img src="../assets/images/logos/logo1.svg" class="dark-logo" alt="Logo-Dark" />
                            </a>
                            <h2 class="mb-2 mt-4 fs-7 fw-bolder">Sign In</h2>
                            <p class="mb-9">Your Admin Dashboard</p>
                            <div class="row">
                                <div class="col-6 mb-2 mb-sm-0">
                                    <a class="btn btn-link border border-muted d-flex align-items-center justify-content-center rounded-2 py-8 text-decoration-none" href="javascript:void(0)" role="button">
                                        <img src="../assets/images/svgs/google-icon.svg" alt="matdash-img" class="img-fluid me-2" width="18" height="18" />
                                        Google
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a class="btn btn-link border border-muted d-flex align-items-center justify-content-center rounded-2 py-8 text-decoration-none" href="javascript:void(0)" role="button">
                                        <img src="../assets/images/svgs/facebook-icon.svg" alt="matdash-img" class="img-fluid me-2" width="18" height="18" />
                                        Facebook
                                    </a>
                                </div>
                            </div>
                            <div class="position-relative text-center my-4">
                                <p class="mb-0 fs-4 px-3 d-inline-block bg-body text-dark z-index-5 position-relative">
                                    or sign in with
                                </p>
                                <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                            </div>
                            <form method="post" action="{{route('doLogin')}}">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Tài khoản</label>
                                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" />
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" />
                                </div>
                                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked />
                                        <label class="form-check-label text-dark" for="flexCheckChecked">
                                            Remeber this Device
                                        </label>
                                    </div>
                                    <a class="text-primary fw-medium" href="./authentication-forgot-password.html">Quên mật khẩu ?</a>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign In</button>
                                <div class="d-flex align-items-center justify-content-center">
                                    <p class="fs-4 mb-0 fw-medium">Win Win Group</p>
                                    <a class="text-primary fw-medium ms-2" >Kính chào quý khách!</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-xl-7 col-xxl-8 position-relative overflow-hidden bg-dark d-none d-lg-block">
                    <div class="circle-top"></div>
                    <div>
                        <img src="../assets/images/logos/logo-icon.svg" class="circle-bottom" alt="Logo-Dark" />
                    </div>
                    <div class="d-lg-flex align-items-center z-index-5 position-relative h-n80">
                        <div class="row justify-content-center w-100">
                            <div class="col-lg-6">
                                <h2 class="text-white fs-10 mb-3 lh-sm">
                                    Chào mừng bạn đến với
                                    <br />
                                    Win Win Group
                                </h2>
                                <span class="opacity-75 fs-4 text-white d-block mb-3">Warm & Build là ứng dụng dành cho khách hàng trong ngành mẹ và bé,
                    <br />
                    giúp bạn trải nghiệm dịch vụ tốt hơn với nhiều tiện ích hữu ích.
                  </span>
                                <a target="_blank" href="https://winwingroup.vn/contact" class="btn btn-primary">Liên hệ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dark-transparent sidebartoggler"></div>
<!-- Import Js Files -->
<script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/simplebar/dist/simplebar.min.js"></script>
<script src="assets/js/theme/app.init.js"></script>
<script src="assets/js/theme/theme.js"></script>
<script src="assets/js/theme/app.min.js"></script>

<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
