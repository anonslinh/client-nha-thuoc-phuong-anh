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

    <style>
      .book-note { font-size: 12px; margin-top: 10px; display:none; line-height: 1.4; }
      .book-note.ok { color: #1f8f4a; }
      .book-note.bad { color: #b00020; }
      .btn-disabled { opacity:.6; pointer-events:none; }

      /* ==== BOOKING UI FIX: đồng bộ input/select ==== */
      .room-booking label{
        display:block;
        margin-bottom:8px;
      }

      .room-booking .check-date,
      .room-booking .select-option{
        margin-bottom: 18px;
      }

      /* CHỈ 2 ô ngày mới dùng date-input để theme gắn datepicker */
      .room-booking .date-input{
        width: 100%;
        height: 52px;
        line-height: 52px;
        padding: 0 16px;
        border: 1px solid #ebebeb;
        font-size: 15px;
        color: #19191a;
        border-radius: 0;
        box-sizing: border-box;
      }

      /* Input thường cho Họ tên / SĐT / Email */
      .room-booking .book-input{
        width: 100%;
        height: 52px;
        line-height: 52px;
        padding: 0 16px;
        border: 1px solid #ebebeb;
        font-size: 15px;
        color: #19191a;
        border-radius: 0;
        box-sizing: border-box;
        outline: none;
      }

      /* Textarea đồng bộ */
      .room-booking textarea.book-input{
        width: 100%;
        height: auto;
        line-height: 1.4;
        padding: 12px 16px;
        border: 1px solid #ebebeb;
        font-size: 15px;
        color: #19191a;
        border-radius: 0;
        box-sizing: border-box;
        resize: vertical;
      }

      /* nice-select (plugin dropdown) */
      .room-booking .nice-select{
        width: 100% !important;
        height: 52px;
        line-height: 52px;
        border: 1px solid #ebebeb;
        padding-left: 16px;
        padding-right: 42px;
        float: none;
        border-radius: 0;
        box-sizing: border-box;
      }
      .room-booking .nice-select:after{
        right: 16px;
      }
      .room-booking .nice-select .list{
        width: 100%;
      }

      /* Button full width + đồng bộ height */
      .room-booking button{
        width: 100%;
        height: 52px;
        line-height: 52px;
      }
    </style>
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
            <a href="#bookingBox" class="bk-btn">Đặt phòng</a>
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
                            <a href="#bookingBox" class="bk-btn">Đặt Phòng Ngay</a>
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

    <!-- Gallery Section Begin -->
    <section class="gallery-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Our Gallery</span>
                        <h2>Discover Our Work</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="gallery-item set-bg" data-setbg="/assets/assetsclient/img/gallery/gallery-1.jpg">
                        <div class="gi-text">
                            <h3>Room Luxury</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="gallery-item set-bg" data-setbg="/assets/assetsclient/img/gallery/gallery-3.jpg">
                                <div class="gi-text">
                                    <h3>Room Luxury</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="gallery-item set-bg" data-setbg="/assets/assetsclient/img/gallery/gallery-4.jpg">
                                <div class="gi-text">
                                    <h3>Room Luxury</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="gallery-item large-item set-bg" data-setbg="/assets/assetsclient/img/gallery/gallery-2.jpg">
                        <div class="gi-text">
                            <h3>Room Luxury</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Amenities Section Begin -->
    <section class="amenities-section spad">
      <div class="container">
        <div class="section-title">
          <span>Room Amenities</span>
          <h2>Services Included</h2>
        </div>
        <div class="row">
          <div class="col-lg-4 col-sm-6">
            <div class="as-item">
              <i class="fa fa-wifi"></i>
              <h5>Free Wi-Fi</h5>
              <p>High-speed internet access available in all rooms.</p>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="as-item">
              <i class="fa fa-cutlery"></i>
              <h5>Breakfast Included</h5>
              <p>Daily buffet breakfast served at our restaurant.</p>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="as-item">
              <i class="fa fa-car"></i>
              <h5>Airport Pickup</h5>
              <p>Shuttle service from and to the airport upon request.</p>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="as-item">
              <i class="fa fa-television"></i>
              <h5>Flat Screen TV</h5>
              <p>Satellite TV channels with on-demand movies.</p>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="as-item">
              <i class="fa fa-bath"></i>
              <h5>Private Bathroom</h5>
              <p>Modern shower with complimentary toiletries.</p>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="as-item">
              <i class="fa fa-snowflake-o"></i>
              <h5>Air Conditioning</h5>
              <p>Individually controlled AC in every room.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Amenities Section End -->

    <!-- Room Details Section Begin -->
    <section class="room-details-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="room-details-item">
                        <img src="/assets/assetsclient/img/room/room-details.jpg" alt="">
                        <div class="rd-text">
                            <div class="rd-title">
                                <h3>{{ $room->name ?? 'Premium King Room' }}</h3>
                                <div class="rdt-right">
                                    <div class="rating">
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star-half_alt"></i>
                                    </div>
                                    <a href="#bookingBox">Booking Now</a>
                                </div>
                            </div>
                            <h2>{{ $room->price ?? '159$' }}<span>/Pernight</span></h2>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Size:</td>
                                        <td>{{ $room->size ?? '30 ft' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Capacity:</td>
                                        <td>{{ $room->capacity ?? 'Max person 5' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Bed:</td>
                                        <td>{{ $room->bed ?? 'King Beds' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Services:</td>
                                        <td>{{ $room->services ?? 'Wifi, Television, Bathroom,...' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="f-para">Motorhome or Trailer that is the question for you...</p>
                            <p>The two commonly known recreational vehicle classes are the motorized and towable...</p>
                        </div>
                    </div>

                    <div class="rd-reviews">
                        <h4>Reviews</h4>
                        <div class="review-item">
                            <div class="ri-pic">
                                <img src="/assets/assetsclient/img/room/avatar/avatar-1.jpg" alt="">
                            </div>
                            <div class="ri-text">
                                <span>27 Aug 2019</span>
                                <div class="rating">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <h5>Brandon Kelley</h5>
                                <p>Neque porro qui squam est...</p>
                            </div>
                        </div>
                        <div class="review-item">
                            <div class="ri-pic">
                                <img src="/assets/assetsclient/img/room/avatar/avatar-2.jpg" alt="">
                            </div>
                            <div class="ri-text">
                                <span>27 Aug 2019</span>
                                <div class="rating">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <h5>Brandon Kelley</h5>
                                <p>Neque porro qui squam est...</p>
                            </div>
                        </div>
                    </div>

                    <div class="review-add">
                        <h4>Add Review</h4>
                        <form action="#" class="ra-form">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Name*">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Email*">
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <h5>You Rating:</h5>
                                        <div class="rating">
                                            <i class="icon_star"></i>
                                            <i class="icon_star"></i>
                                            <i class="icon_star"></i>
                                            <i class="icon_star"></i>
                                            <i class="icon_star-half_alt"></i>
                                        </div>
                                    </div>
                                    <textarea placeholder="Your Review"></textarea>
                                    <button type="submit">Submit Now</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

                {{-- ====== BOOKING BOX (UPDATED + FIXED UI) ====== --}}
                <div class="col-lg-4" id="bookingBox">
                    <div class="room-booking">
                        <h3>Đặt phòng</h3>

                        {{-- success --}}
                        @if(session('success'))
                          <div class="alert alert-success" style="font-size:13px;">
                            {{ session('success') }}
                          </div>
                        @endif

                        {{-- server-side errors --}}
                        @if ($errors->any())
                          <div class="alert alert-danger" style="font-size:13px;">
                            <b>Có lỗi:</b>
                            <ul class="mb-0">
                              @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                              @endforeach
                            </ul>
                          </div>
                        @endif

                        <form id="bookingForm" action="{{ route('client.bookings.store') }}" method="POST">
                            @csrf

                            {{-- room_id dùng để lưu booking + check phòng trống --}}
                            <input type="hidden" name="room_id" value="{{ $room->id ?? request()->route('id') }}">
                            <input type="hidden" id="js_room_id" value="{{ $room->id ?? request()->route('id') }}">

                            <div class="check-date">
                                <label for="book_date_in">Ngày vào:</label>
                                <input
                                  type="text"
                                  class="date-input"
                                  id="book_date_in"
                                  name="check_in_date"
                                  value="{{ old('check_in_date') }}"
                                  placeholder="YYYY-MM-DD"
                                  autocomplete="off"
                                  required
                                >
                                <i class="icon_calendar"></i>
                            </div>

                            <div class="check-date">
                                <label for="book_date_out">Ngày ra:</label>
                                <input
                                  type="text"
                                  class="date-input"
                                  id="book_date_out"
                                  name="check_out_date"
                                  value="{{ old('check_out_date') }}"
                                  placeholder="YYYY-MM-DD"
                                  autocomplete="off"
                                  required
                                >
                                <i class="icon_calendar"></i>
                            </div>

                            <div class="select-option">
                                <label for="book_qty">Số lượng phòng</label>
                                <select id="book_qty" name="qty" required>
                                  @for($i=1;$i<=10;$i++)
                                    <option value="{{ $i }}" {{ (int)old('qty',1) === $i ? 'selected' : '' }}>
                                      {{ $i }} phòng
                                    </option>
                                  @endfor
                                </select>
                            </div>

                            <div class="select-option">
                                <label for="book_adults">Người lớn</label>
                                <select id="book_adults" name="adults" required>
                                  @for($i=1;$i<=10;$i++)
                                    <option value="{{ $i }}" {{ (int)old('adults',2) === $i ? 'selected' : '' }}>
                                      {{ $i }}
                                    </option>
                                  @endfor
                                </select>
                            </div>

                            <div class="select-option">
                                <label for="book_children">Trẻ em</label>
                                <select id="book_children" name="children">
                                  @for($i=0;$i<=10;$i++)
                                    <option value="{{ $i }}" {{ (int)old('children',0) === $i ? 'selected' : '' }}>
                                      {{ $i }}
                                    </option>
                                  @endfor
                                </select>
                            </div>

                            {{-- IMPORTANT: không dùng date-input để tránh bật lịch --}}
                            <div class="select-option">
                                <label for="book_name">Họ tên</label>
                                <input
                                  type="text"
                                  class="book-input"
                                  id="book_name"
                                  name="customer_name"
                                  value="{{ old('customer_name') }}"
                                  placeholder="Nguyễn Văn A"
                                  required
                                >
                            </div>

                            <div class="select-option">
                                <label for="book_phone">Số điện thoại</label>
                                <input
                                  type="text"
                                  class="book-input"
                                  id="book_phone"
                                  name="phone"
                                  value="{{ old('phone') }}"
                                  placeholder="03xxxxxxxx"
                                  required
                                >
                            </div>

                            <div class="select-option">
                                <label for="book_email">Email (không bắt buộc)</label>
                                <input
                                  type="text"
                                  class="book-input"
                                  id="book_email"
                                  name="email"
                                  value="{{ old('email') }}"
                                  placeholder="abc@gmail.com"
                                >
                            </div>

                            <div class="select-option">
                                <label for="book_note">Ghi chú</label>
                                <textarea
                                  id="book_note"
                                  class="book-input"
                                  name="note"
                                  rows="3"
                                  placeholder="Yêu cầu thêm...">{{ old('note') }}</textarea>
                            </div>

                            <div id="bookNote" class="book-note"></div>

                            <button id="btnSubmitBooking" type="submit" class="btn-disabled" disabled>
                              Gửi yêu cầu đặt phòng
                            </button>
                        </form>
                    </div>
                </div>
                {{-- ====== END BOOKING BOX ====== --}}

            </div>
        </div>
    </section>
    <!-- Room Details Section End -->

    <!-- Map Section Begin -->
    <section class="map-section spad">
      <div class="container">
        <div class="section-title">
          <span>Location</span>
          <h2>Find Us On The Map</h2>
        </div>
      </div>
      <div class="map-iframe">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.5028804191437!2d106.70042341533482!3d10.772249992323067!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f40b4c2f4a3%3A0x5c5d44efb9c94d2e!2zSG90ZWwgRXhhbXBsZQ!5e0!3m2!1sen!2s!4v1636452345610!5m2!1sen!2s"
          width="100%"
          height="450"
          style="border:0;"
          allowfullscreen=""
          loading="lazy">
        </iframe>
      </div>
    </section>
    <!-- Map Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer-section">
        <div class="container">
            <div class="footer-text">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ft-about">
                            <div class="logo">
                                <a href="#">
                                    <img src="/assets/assetsclient/img/footer-logo.png" alt="">
                                </a>
                            </div>
                            <p>We inspire and reach millions of travelers<br /> across 90 local websites</p>
                            <div class="fa-social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-tripadvisor"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-youtube-play"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-contact">
                            <h6>Contact Us</h6>
                            <ul>
                                <li>(12) 345 67890</li>
                                <li>info.colorlib@gmail.com</li>
                                <li>856 Cordia Extension Apt. 356, Lake, United State</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-newslatter">
                            <h6>New latest</h6>
                            <p>Get the latest updates and offers.</p>
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
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Terms of use</a></li>
                            <li><a href="#">Privacy</a></li>
                            <li><a href="#">Environmental Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-5">
                        <div class="co-text"><p>
                          Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                          All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by
                          <a href="https://colorlib.com" target="_blank">Colorlib</a>
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
    <script src="/assets/assetsclient/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/assetsclient/js/bootstrap.min.js"></script>
    <script src="/assets/assetsclient/js/jquery.magnific-popup.min.js"></script>
    <script src="/assets/assetsclient/js/jquery.nice-select.min.js"></script>
    <script src="/assets/assetsclient/js/jquery-ui.min.js"></script>
    <script src="/assets/assetsclient/js/jquery.slicknav.js"></script>
    <script src="/assets/assetsclient/js/owl.carousel.min.js"></script>
    <script src="/assets/assetsclient/js/main.js"></script>

    {{-- BOOKING JS --}}
    <script>
      (function() {
        const checkUrl = @json(route('client.bookings.check'));

        const $form = $('#bookingForm');
        const $in  = $('#book_date_in');
        const $out = $('#book_date_out');
        const $qty = $('#book_qty');

        const $note = $('#bookNote');
        const $btn  = $('#btnSubmitBooking');

        function setNote(type, html) {
          $note.removeClass('ok bad').addClass(type).html(html).show();
        }

        function disableBtn() {
          $btn.addClass('btn-disabled').prop('disabled', true);
        }

        function enableBtn() {
          $btn.removeClass('btn-disabled').prop('disabled', false);
        }

        function pad2(n) { return String(n).padStart(2, '0'); }

        function formatYMD(d) {
          return d.getFullYear() + '-' + pad2(d.getMonth() + 1) + '-' + pad2(d.getDate());
        }

        /**
         * Chuẩn hoá mọi kiểu ngày về YYYY-MM-DD
         * Hỗ trợ:
         * - YYYY-MM-DD
         * - DD/MM/YYYY hoặc DD-MM-YYYY
         * - "24 January, 2026" / "24 JANUARY, 2026" (từ datepicker template)
         */
        function normalizeToYMD(raw) {
          raw = (raw || '').trim();
          if (!raw) return null;

          // YYYY-MM-DD
          if (/^\d{4}-\d{2}-\d{2}$/.test(raw)) return raw;

          // DD/MM/YYYY hoặc DD-MM-YYYY
          let m = raw.match(/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/);
          if (m) {
            const dd = parseInt(m[1], 10);
            const mm = parseInt(m[2], 10);
            const yy = parseInt(m[3], 10);
            const d = new Date(yy, mm - 1, dd);
            if (!isNaN(d.getTime())) return formatYMD(d);
          }

          // "24 JANUARY, 2026" / "24 January, 2026"
          const cleaned = raw.replace(/\s+/g, ' ').replace(/,/g, '').trim();
          const d2 = new Date(cleaned);
          if (!isNaN(d2.getTime())) return formatYMD(d2);

          return null;
        }

        // IMPORTANT: nếu theme đã lỡ gắn datepicker vào các ô này thì destroy
        // (tránh click vào họ tên/sđt/email lại bung lịch)
        ['#book_name','#book_phone','#book_email','#book_note'].forEach(function(sel){
          try { $(sel).datepicker('destroy'); } catch(e) {}
          $(sel).removeClass('hasDatepicker');
        });

        // Datepicker: KHÔNG ép format, để template hiển thị đẹp.
        // Chỉ set minDate & gọi runCheck khi chọn.
        if ($.fn.datepicker) {
          try {
            $in.datepicker({
              minDate: 0,
              onSelect: function() {
                // set minDate cho ngày ra = ngày vào + 1
                const inIso = normalizeToYMD($in.val());
                if (inIso) {
                  const parts = inIso.split('-'); // [YYYY,MM,DD]
                  const d = new Date(parseInt(parts[0],10), parseInt(parts[1],10)-1, parseInt(parts[2],10));
                  d.setDate(d.getDate() + 1);
                  try { $out.datepicker('option', 'minDate', d); } catch(e){}
                }
                runCheck();
              }
            });

            $out.datepicker({
              minDate: 1,
              onSelect: function() { runCheck(); }
            });
          } catch(e) {
            // nếu template đã init datepicker kiểu khác thì bỏ qua
          }
        }

        $qty.on('change', runCheck);
        $in.on('change keyup', runCheck);
        $out.on('change keyup', runCheck);

        async function runCheck() {
          disableBtn();

          const roomId = $('#js_room_id').val();
          const inRaw  = ($in.val() || '').trim();
          const outRaw = ($out.val() || '').trim();
          const qty = $qty.val();

          const checkIn  = normalizeToYMD(inRaw);
          const checkOut = normalizeToYMD(outRaw);

          if (!checkIn || !checkOut) {
            setNote('bad', 'Vui lòng chọn ngày hợp lệ.');
            return;
          }

          if (checkOut <= checkIn) {
            setNote('bad', 'Ngày ra phải sau ngày vào.');
            return;
          }

          setNote('bad', 'Đang kiểm tra phòng trống...');

          try {
            const url = checkUrl + '?' + new URLSearchParams({
              room_id: roomId,
              check_in: checkIn,
              check_out: checkOut,
              qty: qty
            }).toString();

            const res = await fetch(url, { headers: { 'Accept': 'application/json' }});
            const json = await res.json();

            if (json && json.ok) {
              setNote('ok', json.message || 'OK');
              enableBtn();
            } else {
              setNote('bad', (json && json.message) ? json.message : 'Không đủ phòng trong khoảng ngày đã chọn.');
              disableBtn();
            }
          } catch (e) {
            setNote('bad', 'Không kiểm tra được phòng trống. Vui lòng thử lại.');
            disableBtn();
          }
        }

        // Trước khi submit: ép value về YYYY-MM-DD để backend nhận chuẩn
        $form.on('submit', function(e) {
          const inIso  = normalizeToYMD($in.val());
          const outIso = normalizeToYMD($out.val());

          if (!inIso || !outIso) {
            e.preventDefault();
            setNote('bad', 'Vui lòng chọn ngày hợp lệ trước khi gửi.');
            disableBtn();
            return;
          }
          if (outIso <= inIso) {
            e.preventDefault();
            setNote('bad', 'Ngày ra phải sau ngày vào.');
            disableBtn();
            return;
          }

          // set lại value input để server nhận đúng YYYY-MM-DD
          $in.val(inIso);
          $out.val(outIso);
        });

        // initial
        disableBtn();
      })();
    </script>

</body>
</html>
