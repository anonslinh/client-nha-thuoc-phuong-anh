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

    <title>Win 🍼👶 Baby</title>
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
                                <img style="width: 368px; height: auto;" src="../assets/images/logos/logo_win_baby_login.svg"/>
                            </a>
                            <h2 class="mb-2 mt-4 fs-7 fw-bolder">Quên mật khẩu</h2>
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        <!-- Hiển thị lỗi validate -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <p class="mb-9">Vui lòng nhập địa chỉ email liên kết với tài khoản của bạn, chúng tôi sẽ gửi cho bạn một liên kết để đặt lại mật khẩu.</p>
                            <form method="post" action="{{route('store-forgot-password')}}">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" />
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Quên mật khẩu?</button>
                                <a href="{{route('login')}}" class="btn bg-primary-subtle text-primary w-100 py-8">Quay lại đăng nhập</a>
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
                                <h5 class="text-white">
                                    Win Baby – Nơi kết nối công nghệ hiện đại với yêu thương chân thành.
                                </h5></br>
                                <span class="opacity-75 fs-4 text-white d-block mb-3">
                                    Chúng tôi tin rằng mỗi cửa hàng mẹ và bé xứng đáng được trang bị những công cụ đột phá,
                                    biến những giao dịch thông thường thành trải nghiệm khó quên.  </br></br>
                                    Khi mọi cửa hàng có thể tự tạo ra không gian độc đáo để gắn kết với khách hàng,
                                    họ sẽ có thời gian tập trung vào điều mà con người làm tốt nhất – mang đến sự quan tâm và chăm sóc tận tâm.</br></br>
                                    Vì Win Baby được xây dựng để phục vụ con người, giúp mỗi khoảnh khắc mua sắm trở nên ý nghĩa và trọn vẹn.
                                </span>
{{--                                <a target="_blank" href="https://winwingroup.vn/contact" class="btn btn-primary">Liên hệ</a>--}}
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
