{{-- resources/views/client/rooms/index.blade.php --}}
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>1986Hotels | Phòng</title>
    <!--favicon-->
    <link rel="icon" href="https://1986hotelscualo.com/assets/assetsclient/img/logo.jpg" type="image/x-icon">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/flaticon.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/style.css') }}" type="text/css">
</head>

<body>
@php use Illuminate\Support\Str; @endphp
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Section Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="canvas-open">
        <i class="icon_menu"></i>
    </div>
    <div class="offcanvas-menu-wrapper">
        <div class="canvas-close">
            <i class="icon_close"></i>
        </div>
        <div class="search-icon search-switch">
            <i class="icon_search"></i>
        </div>
        <div class="header-configure-area">
            <div class="language-option">
                <img src="{{ asset('assets/assetsclient/img/logo.jpg') }}" alt="">
                <span>EN <i class="fa fa-angle-down"></i></span>
                <div class="flag-dropdown">
                    <ul>
                        <li><a href="#">Zi</a></li>
                        <li><a href="#">Fr</a></li>
                    </ul>
                </div>
            </div>
            <a href="#" class="bk-btn">Đặt phòng</a>
        </div>
        <nav class="mainmenu mobile-menu">
            <ul>
                <li class="active"><a href="{{ url('/') }}">Trang chủ</a></li>
                <li><a href="{{ route('client.rooms.index') }}">Phòng</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Pages</a>
                    <ul class="dropdown">
                        <li><a href="#">Room Details</a></li>
                        <li><a href="#">Blog Details</a></li>
                        <li><a href="#">Family Room</a></li>
                        <li><a href="#">Premium Room</a></li>
                    </ul>
                </li>
                <li><a href="#">Bài viết</a></li>
                <li><a href="#">Liên hệ</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="top-social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-tripadvisor"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
        <ul class="top-widget">
            <li><i class="fa fa-phone"></i> 0339662172</li>
            <li><i class="fa fa-envelope"></i> 1986hotel@gmail.com</li>
        </ul>
    </div>
    <!-- Offcanvas Menu Section End -->

    <!-- Header Section Begin -->
    <header class="header-section header-normal">
        <div class="top-nav">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="tn-left">
                            <li><i class="fa fa-phone"></i>0339662172</li>
                            <li><i class="fa fa-envelope"></i> 1986hotel@gmail.com</li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="tn-right">
                            <div class="top-social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                            <a href="#" class="bk-btn">Đặt Phòng Ngay</a>
                            <div class="language-option">
                                <img src="{{ asset('assets/assetsclient/img/flag.jpg') }}" alt="">
                                <span>EN <i class="fa fa-angle-down"></i></span>
                                <div class="flag-dropdown">
                                    <ul>
                                        <li><a href="#">Zi</a></li>
                                        <li><a href="#">Fr</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="menu-item">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/assetsclient/img/logo.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="nav-menu">
                            <nav class="mainmenu">
                                <ul>
                                    <li><a href="{{ url('/') }}">Trang chủ</a></li>
                                    <li class="active"><a href="{{ route('client.rooms.index') }}">Phòng</a></li>
                                    <li><a href="#">Giới thiệu</a></li>
                                    <li><a href="#">Pages</a>
                                        <ul class="dropdown">
                                            <li><a href="#">Room Details</a></li>
                                            <li><a href="#">Blog Details</a></li>
                                            <li><a href="#">Family Room</a></li>
                                            <li><a href="#">Premium Room</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Bài viết</a></li>
                                    <li><a href="#">Liên hệ</a></li>
                                </ul>
                            </nav>
                            <div class="nav-right search-switch">
                                <i class="icon_search"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Phân khúc phòng</h2>
                        <div class="bt-option">
                            <a href="{{ url('/') }}">Trang chủ</a>
                            <span>Danh sách phòng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rooms Section Begin -->
    <section class="rooms-section spad">
        <div class="container">
            <div class="row">
                @forelse($rooms as $room)
                    @php
                        $avatar = $room->img_avatar
                            ? (Str::startsWith($room->img_avatar, ['http://', 'https://']) ? $room->img_avatar : asset($room->img_avatar))
                            : asset('assets/assetsclient/img/room/room-1.jpg'); // fallback
                    @endphp
                    <div class="col-lg-4 col-md-6">
                        <div class="room-item">
                            <img src="{{ $avatar }}" alt="{{ $room->name }}">
                            <div class="ri-text">
                                <h4>{{ $room->name }}</h4>
                                <h3>{{ number_format($room->price) }}<span>/ 1 ngày đêm</span></h3>
                                <table>
                                    <tbody>
                                        <!-- <tr>
                                            <td class="r-o">Size:</td>
                                            <td>30 ft</td> {{-- default --}}
                                        </tr> -->
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>
                                                @switch((int) $room->type)
                                                    @case(1) Tối đa 2 người lớn @break
                                                    @case(2) Tối đa 4 người lớn @break
                                                    @case(3) Tối đa 6 người lớn @break
                                                    @default Tối đa 2 người lớn
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Phân loại giường:</td>
                                            <td>King Beds</td> {{-- default --}}
                                        </tr>
                                        <tr>
                                            <td class="r-o">Tiện ích:</td>
                                            <td>{{ $room->note_services ?: 'Wifi, Television, Bathroom,...' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="{{ route('client.rooms.show', $room->code_url) }}" class="primary-btn">Xem chi tiết phòng</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-danger m-0">Không có phòng khả dụng.</p>
                    </div>
                @endforelse

                {{-- Pagination --}}
                @if ($rooms->hasPages())
                    <div class="col-lg-12 mt-3">
                        <div class="room-pagination d-flex justify-content-center">
                            {{ $rooms->onEachSide(1)->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Rooms Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer-section">
        <div class="container">
            <div class="footer-text">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ft-about">
                            <div class="logo">
                                <a href="#">
                                    <img src="{{ asset('assets/assetsclient/img/footer-logo.png') }}" alt="">
                                </a>
                            </div>
                            <p>Chuẩn 3 sao, quy mô 10 tầng, 54 phòng nội thất hiện đại.<br /> Cách bãi biển chỉ 3 phút đi bộ.<br /> Phòng view hướng biển và 100% có cửa sổ thông thoáng.<br /></p>
                            <div class="fa-social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-youtube-play"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-contact">
                            <h6>Liên Hệ</h6>
                            <ul>
                                <li>0339662172</li>
                                <li>1986hotel@gmail.com</li>
                                <li>228 Đường Nguyễn Sư Hồi, Đông Quan, Việt Nam</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-newslatter">
                            <h6>Ưu đãi mới</h6>
                            <p>Nhận thông tin cập nhật và ưu đãi mới nhất..</p>
                            <form action="#" class="fn-form">
                                <input type="text" placeholder="Email">
                                <button type="submit"><i class="fa fa-send"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <ul>
                            <li><a href="#">Liên hệ</a></li>
                            <li><a href="#">Về chúng tôi</a></li>
                            <li><a href="#">Chính sách</a></li>
                            <li><a href="#">Quyền riêng tư</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-5">
                        <div class="co-text"><p>
                          Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                          All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i>
                          by <a href="#" target="_blank">OutTech</a>
                        </p></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="{{ asset('assets/assetsclient/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/assetsclient/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/assetsclient/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/assetsclient/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/assetsclient/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/assetsclient/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('assets/assetsclient/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/assetsclient/js/main.js') }}"></script>
</body>

</html>
