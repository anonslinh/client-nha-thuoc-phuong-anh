<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="Sona Template">
  <meta name="keywords" content="Sona, unica, creative, html">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>1986 Hotels</title>

  <!--favicon-->
  <link rel="icon" href="https://1986hotelscualo.com/assets/assetsclient/img/logo_img.png" type="image/x-icon">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap" rel="stylesheet">

  <!-- Css Styles -->
  <link rel="stylesheet" href="../assets/assetsclient/css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="../assets/assetsclient/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="../assets/assetsclient/css/elegant-icons.css" type="text/css">
  <link rel="stylesheet" href="../assets/assetsclient/css/flaticon.css" type="text/css">
  <link rel="stylesheet" href="../assets/assetsclient/css/owl.carousel.min.css" type="text/css">
  <link rel="stylesheet" href="../assets/assetsclient/css/nice-select.css" type="text/css">
  <link rel="stylesheet" href="../assets/assetsclient/css/jquery-ui.min.css" type="text/css">
  <link rel="stylesheet" href="../assets/assetsclient/css/magnific-popup.css" type="text/css">
  <link rel="stylesheet" href="../assets/assetsclient/css/slicknav.min.css" type="text/css">
  <link rel="stylesheet" href="../assets/assetsclient/css/style.css" type="text/css">

  <style>
    .cell-ok { background: #e8fff0; }
    .cell-bad { background: #f7f7f7; color:#999; }
    .cell-selected { outline: 2px solid #1f8f4a; outline-offset: -2px; }
    .cell-bad.cell-selected { outline-color: #999; }
    .cell-clickable { cursor:pointer; }
    .room-row-active { background: #f0f8ff; }
  </style>
</head>

<body>
  <!-- Page Preloder -->
  <div id="preloder">
    <div class="loader"></div>
  </div>

  <!-- Offcanvas Menu Section Begin -->
  <div class="offcanvas-menu-overlay"></div>
  <div style=" margin-top: 3px; " class="canvas-open">
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
        <img style=" width: 120px; " src="{{ asset('assets/assetsclient/img/logo_version2.png') }}" alt="">
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
                <img src="https://1986hotelscualo.com/assets/assetsclient/img/logo_version2.png" alt="">
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
                <img style="width: 120px;" src="https://1986hotelscualo.com/assets/assetsclient/img/logo_version2.png" alt="">
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

  <!-- MODAL CALENDAR -->
  <div class="modal fade" id="availabilityModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnPrevMonth">&laquo;</button>
            <h5 class="modal-title mb-0" id="calTitle">Lịch phòng</h5>
            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnNextMonth">&raquo;</button>
          </div>

          <!-- Compatible BS4 + BS5 -->
          <button type="button"
                  class="btn-close close"
                  data-bs-dismiss="modal"
                  data-dismiss="modal"
                  aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <div><b>Ngày nhận:</b> <span id="uiCheckIn">-</span></div>
            <div><b>Ngày trả:</b> <span id="uiCheckOut">-</span></div>
            <div><b>Loại phòng:</b> <span id="uiRoomName">-</span></div>
            <div><b>Số phòng:</b> <span id="uiQty">-</span></div>
            <div class="ms-auto text-muted" id="uiHint">Click 2 ô ngày trên lịch để chọn lại thời gian</div>
          </div>

          <div class="table-responsive" style="overflow:auto;">
            <table class="table table-bordered align-middle text-nowrap" id="calTable">
              <thead id="calThead"></thead>
              <tbody id="calTbody"></tbody>
            </table>
          </div>

          <div class="mt-2" id="uiResultNote"></div>
        </div>

        <div class="modal-footer d-flex justify-content-between">
          <div class="text-muted">
            <small>Mỗi ô: <b>Đã đặt / Còn trống / Tổng</b>. Ô xanh = đủ phòng cho khoảng ngày đang chọn.</small>
          </div>
          <button class="btn btn-primary" id="btnBookNow" disabled>Đặt phòng ngay</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Hero Section Begin -->
  <section class="hero-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="hero-text">
            <h1>1988 Hotels Cửa Lò</h1>
            <p>Chuẩn 3 sao, quy mô 10 tầng, 54 phòng nội thất hiện đại. Cách bãi biển chỉ 3 phút đi bộ. Phòng view hướng biển và 100% có cửa sổ thông thoáng.</p>
            <a href="#" class="primary-btn">Khám phá ngay</a>
          </div>
        </div>

        <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
          <div class="booking-form">
            <h3>Đặt phòng ngay</h3>

            <form id="bookingFilterForm" action="javascript:void(0)">
              <div class="check-date">
                <label for="date-in">Ngày nhận:</label>
                <input type="text" class="date-input" id="date-in" placeholder="Chọn ngày nhận" autocomplete="off">
                <i class="icon_calendar"></i>
              </div>

              <div class="check-date">
                <label for="date-out">Ngày trả:</label>
                <input type="text" class="date-input" id="date-out" placeholder="Chọn ngày trả" autocomplete="off">
                <i class="icon_calendar"></i>
              </div>

              <div class="select-option">
                <label for="room_type">Phân khúc phòng:</label>
                <select id="room_type">
                  @foreach($rooms as $r)
                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="select-option">
                <label for="qty">Số phòng cần đặt:</label>
                <select id="qty">
                  @for($i=1;$i<=10;$i++)
                    <option value="{{ $i }}">{{ $i }} Phòng</option>
                  @endfor
                </select>
              </div>

              <button type="submit">Kiểm tra phòng trống</button>
            </form>

            <small id="filterErr" style="color:#d00;display:none;margin-top:8px;"></small>
          </div>
        </div>
      </div>
    </div>

    <div class="hero-slider owl-carousel">
      <div class="hs-item set-bg" data-setbg="../assets/assetsclient/img/hero/hero-1.jpg"></div>
      <div class="hs-item set-bg" data-setbg="../assets/assetsclient/img/hero/hero-2.jpg"></div>
      <div class="hs-item set-bg" data-setbg="../assets/assetsclient/img/hero/hero-3.jpg"></div>
    </div>
  </section>
  <!-- Hero Section End -->

  <!-- About Us Section Begin -->
    <section class="aboutus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-text">
                        <div class="section-title">
                            <span>Giới thiệu khách sạn</span>
                            <h2>1986 Hotels <br />Chuẩn khác sạn 3 sao</h2>
                        </div>
                        <p class="f-para">Là một trong những khách sạn hàng đầu tại khu du lịch Cửa Lò với
                            quy mô 10 tầng đa dạng các vị trí view và tổng 54 phòng được thiết kế chuẩn 3 sao.
                            với nội thất và không gian hiện tại.</p>
                        <p class="s-para">Vị trí khách sạn cách bãi biển chính chỉ 3 phút đi bộ, và sở hữu quỹ phòng
                            100% cửa số view thoáng đem lại trải nghiệm nghỉ dưỡng thoải mái nhất.
                        </p>
                        <a href="#" class="primary-btn about-btn">Tìm hiểu</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-pic">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="../assets/assetsclient/img/about-3.png" alt="">
                            </div>
                            <div class="col-sm-6">
                                <img src="../assets/assetsclient/img/about-2.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Section End -->

    <!-- Services Section End -->
    <section class="services-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Dịch Vụ Của Khách Sạn</span>
                        <h2>Khám Phá Các Dịch Vụ Của Chúng Tôi</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-036-parking"></i>
                        <h4>Vị trí trung tâm</h4>
                        <p>Khoảng cách đến các địa danh khu du lịch, bãi biển, hoạt động buidling ngắn Tiết kiệm thời gian, trải nghiệm trọn vẹn</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-033-dinner"></i>
                        <h4>Dịch vụ phục vụ tiệc</h4>
                        <p>Có không gian hội trường,phù hợp tổ chức hội nghị, tiệc các hoạt động tổ chức.Thực đơn linh hoạt, nguyên liệu tươi, bày trí tinh tế theo yêu cầu.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-026-bed"></i>
                        <h4>Phù hợp gia đình có trẻ em</h4>
                        <p>An toàn – chu đáo – giúp bố mẹ an tâm tận hưởng kỳ nghỉ.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-024-towel"></i>
                        <h4>Giặt ủi</h4>
                        <p>Giặt – sấy – là nhanh gọn, chăm sóc đúng chất liệu, trả đồ trong ngày. Nhận và giao tận phòng, giá niêm yết minh bạch..</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-044-clock-1"></i>
                        <h4>Thuê tài xế</h4>
                        <p>Xe riêng với tài xế địa phương am hiểu đường sá: đón/tiễn sân bay, đưa đón tham quan linh hoạt theo lịch trình của bạn. An toàn – đúng giờ – thoải mái..</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-012-cocktail"></i>
                        <h4>Đồ uống</h4>
                        <p>Cà phê và nước trái cây tươi. Phục vụ tại quầy, tại phòng hoặc khu hội khi cho những khoảnh khắc thư giãn.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services Section End -->

    <!-- Home Room Section Begin -->
    <section class="hp-room-section">
        <div class="container-fluid">
            <div class="hp-room-items">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="../assets/assetsclient/img/room/room-b2.jpg">
                            <div class="hr-text">
                                <h3>Phòng Đơn</h3>
                                <h2>199$<span>/Pernight</span></h2>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Size:</td>
                                            <td>30 ft</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>Max persion 5</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Bed:</td>
                                            <td>King Beds</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Services:</td>
                                            <td>Wifi, Television, Bathroom,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="primary-btn">More Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="../assets/assetsclient/img/room/room-b2.png">
                            <div class="hr-text">
                                <h3>Phòng Đôi</h3>
                                <h2>159$<span>/Pernight</span></h2>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Size:</td>
                                            <td>30 ft</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>Max persion 5</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Bed:</td>
                                            <td>King Beds</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Services:</td>
                                            <td>Wifi, Television, Bathroom,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="primary-btn">More Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="../assets/assetsclient/img/room/room-b3.png">
                            <div class="hr-text">
                                <h3>Phòng Gia đình</h3>
                                <h2>198$<span>/Pernight</span></h2>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Size:</td>
                                            <td>30 ft</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>Max persion 5</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Bed:</td>
                                            <td>King Beds</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Services:</td>
                                            <td>Wifi, Television, Bathroom,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="primary-btn">More Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="../assets/assetsclient/img/room/room-b4.png">
                            <div class="hr-text">
                                <h3>Phòng 4 Giường</h3>
                                <h2>299$<span>/Pernight</span></h2>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Size:</td>
                                            <td>30 ft</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>Max persion 5</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Bed:</td>
                                            <td>King Beds</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Services:</td>
                                            <td>Wifi, Television, Bathroom,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="primary-btn">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Home Room Section End -->

    <!-- Testimonial Section Begin -->
    <section class="testimonial-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Chất lượng 3 Sao</span>
                        <h2>1986 có gì?</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="testimonial-slider owl-carousel">
                        <div class="ts-item">
                            <p>Bộ trang thiết bị phòng trong khách sạn thuộc chất lương tiêu chuẩn cao cấp, Dịch vụ
                                chăm sóc khách hàng 24/7. Không gian phòng đạt tiêu chuẩn 3 sao và view phòng 100% cửa số
                            tầm thoáng đảm bảo trải nghiệm tốt nhất cho khách hàng.</p>
                        </div>
                        <div class="ts-item">
                            <p>Khách sạn có khu vực tổ chức sự kiện với sức chứa 200 người, có khu vực sân khấu bố trí trang 
                                thiết bị hiện đại. Bàn ghế chỗ ngồi và ẩm thực tiệc building setup đầy đủ và phù hợp với mọi
                                hội nghị sự kiện.</p>
                        </div>
                        <div class="ts-item">
                            <p>Về ẩm thực cũng là một điểm nhấn của 1986 hotels với menu đa dạng rất nhiều món ăn từ hải sản
                                món nhậu hay các món ăn dân giã từ đó đem lại trải nghiệm thưởng thức phù hợp và cũng chuẩn với
                                những yêu cầu khó tính nhất. Nên trải nghiệm thử dù 1 lần.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Section End -->

    <!-- Blog Section Begin -->
    <section class="blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Hotel News</span>
                        <h2>Our Blog & Event</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="../assets/assetsclient/img/blog/1.jpg">
                        <div class="bi-text">
                            <span class="b-tag">Cửa Lò</span>
                            <h4><a href="#">Thiên đường biển thuần khiết tại Nghệ An</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 15th April, 2025</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="../assets/assetsclient/img/blog/2.jpg">
                        <div class="bi-text">
                            <span class="b-tag">Cửa Lò</span>
                            <h4><a href="#">Một góc check-in không thể thiếu khi đến Cửa Lò</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 15th April, 2025</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="../assets/assetsclient/img/blog/3.jpg">
                        <div class="bi-text">
                            <span class="b-tag">Cửa Lò</span>
                            <h4><a href="#">Đảo Hòn Ngư</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 21th April, 2025</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="blog-item small-size set-bg" data-setbg="../assets/assetsclient/img/blog/4.jpg">
                        <div class="bi-text">
                            <span class="b-tag">Event</span>
                            <h4><a href="#">Hoàng hôn tại Hòn Ngư</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 08th April, 2025</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item small-size set-bg" data-setbg="../assets/assetsclient/img/blog/5.jpg">
                        <div class="bi-text">
                            <span class="b-tag">Cửa Lò</span>
                            <h4><a href="#">Đảo Lan Châu</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 12th April, 2025</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

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

  <!-- Js Plugins -->
  <script src="../assets/assetsclient/js/jquery-3.3.1.min.js"></script>
  <script src="../assets/assetsclient/js/bootstrap.min.js"></script>
  <script src="../assets/assetsclient/js/jquery.magnific-popup.min.js"></script>
  <script src="../assets/assetsclient/js/jquery.nice-select.min.js"></script>
  <script src="../assets/assetsclient/js/jquery-ui.min.js"></script>
  <script src="../assets/assetsclient/js/jquery.slicknav.js"></script>
  <script src="../assets/assetsclient/js/owl.carousel.min.js"></script>
  <script src="../assets/assetsclient/js/main.js"></script>

  <script>
(() => {
  // ====== CONFIG ======
  const apiUrl = @json(route('client.rooms.availability')); // /api/rooms/availability

  // ====== ELEMENTS ======
  const form = document.getElementById('bookingFilterForm');
  const elIn = document.getElementById('date-in');
  const elOut = document.getElementById('date-out');
  const elRoom = document.getElementById('room_type');
  const elQty = document.getElementById('qty');
  const err = document.getElementById('filterErr');

  const modalEl = document.getElementById('availabilityModal');

  const calTitle = document.getElementById('calTitle');
  const calThead = document.getElementById('calThead');
  const calTbody = document.getElementById('calTbody');

  const uiCheckIn = document.getElementById('uiCheckIn');
  const uiCheckOut = document.getElementById('uiCheckOut');
  const uiRoomName = document.getElementById('uiRoomName');
  const uiQty = document.getElementById('uiQty');
  const uiResultNote = document.getElementById('uiResultNote');

  const btnBookNow = document.getElementById('btnBookNow');
  const btnPrevMonth = document.getElementById('btnPrevMonth');
  const btnNextMonth = document.getElementById('btnNextMonth');

  // ====== STATE ======
  let state = {
    checkIn: null,   // YYYY-MM-DD
    checkOut: null,  // YYYY-MM-DD
    roomId: null,
    qty: 1,
    month: null,     // YYYY-MM
    data: null,      // json from api
    picking: { start: null, end: null },
  };

  // ====== HELPERS ======
  const pad2 = (n) => String(n).padStart(2, '0');

  function ymdFromParts(y, m, d) {
    return `${y}-${pad2(m)}-${pad2(d)}`;
  }

  function ymd(dateObj) {
    return ymdFromParts(dateObj.getFullYear(), dateObj.getMonth() + 1, dateObj.getDate());
  }

  function ymFromYmd(ymdStr) {
    return String(ymdStr).slice(0, 7); // YYYY-MM
  }

  function parseYmdStrict(s) {
    // expects YYYY-MM-DD
    if (!/^\d{4}-\d{2}-\d{2}$/.test(s)) return null;
    const [y, m, d] = s.split('-').map(Number);
    const dt = new Date(y, m - 1, d);
    // validate round-trip
    if (dt.getFullYear() !== y || (dt.getMonth() + 1) !== m || dt.getDate() !== d) return null;
    return dt;
  }

  function addDays(ymdStr, days) {
    const dt = parseYmdStrict(ymdStr);
    if (!dt) return null;
    dt.setDate(dt.getDate() + days);
    return ymd(dt);
  }

  // Normalize input date to YYYY-MM-DD (accept nhiều kiểu nhập)
  function normalizeToYmd(input) {
    if (!input) return null;
    const s0 = String(input).trim();
    if (!s0) return null;

    // 1) YYYY-MM-DD
    if (/^\d{4}-\d{2}-\d{2}$/.test(s0)) return s0;

    // 2) YYYY/MM/DD
    if (/^\d{4}\/\d{2}\/\d{2}$/.test(s0)) return s0.replaceAll('/', '-');

    // 3) DD/MM/YYYY hoặc DD-MM-YYYY
    let m = s0.match(/^(\d{1,2})[\/-](\d{1,2})[\/-](\d{4})$/);
    if (m) {
      const dd = Number(m[1]), mm = Number(m[2]), yy = Number(m[3]);
      return ymdFromParts(yy, mm, dd);
    }

    // 4) YYYY-M-D (lỏng)
    m = s0.match(/^(\d{4})[\/-](\d{1,2})[\/-](\d{1,2})$/);
    if (m) {
      const yy = Number(m[1]), mm = Number(m[2]), dd = Number(m[3]);
      return ymdFromParts(yy, mm, dd);
    }

    // 5) "14 Janu" / "14 Jan" / "14 January 2026"
    // map tháng theo 3 ký tự đầu
    const monthMap = {
      jan: 1, january: 1, janu: 1,
      feb: 2, february: 2,
      mar: 3, march: 3,
      apr: 4, april: 4,
      may: 5,
      jun: 6, june: 6,
      jul: 7, july: 7,
      aug: 8, august: 8,
      sep: 9, sept: 9, september: 9,
      oct: 10, october: 10,
      nov: 11, november: 11,
      dec: 12, december: 12,
    };

    m = s0.match(/^(\d{1,2})\s+([A-Za-z\.]+)\s*(\d{4})?$/);
    if (m) {
      const dd = Number(m[1]);
      const monRaw = String(m[2]).replace('.', '').toLowerCase();
      const yy = m[3] ? Number(m[3]) : (new Date()).getFullYear();
      const mm = monthMap[monRaw] || monthMap[monRaw.slice(0,3)];
      if (mm) return ymdFromParts(yy, mm, dd);
    }

    // 6) Fallback: Date.parse (có thể parse được một số format)
    const t = Date.parse(s0);
    if (!Number.isNaN(t)) {
      return ymd(new Date(t));
    }

    return null;
  }

  function escapeHtml(s) {
    return String(s).replace(/[&<>"']/g, (m) => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
    }[m]));
  }
  function escapeAttr(s) {
    return escapeHtml(s).replace(/\n/g, '&#10;');
  }

  function showErr(msg) {
    err.textContent = msg;
    err.style.display = 'block';
  }
  function hideErr() {
    err.style.display = 'none';
  }

  // ====== MODAL (support BS5 or BS4) ======
  let modalApi = {
    show: () => {},
    hide: () => {},
  };

  // Bootstrap 5
  if (window.bootstrap && window.bootstrap.Modal) {
    const m = new window.bootstrap.Modal(modalEl);
    modalApi.show = () => m.show();
    modalApi.hide = () => m.hide();
  }
  // Bootstrap 4 (Sona template hay dùng)
  else if (window.jQuery && window.jQuery.fn && window.jQuery.fn.modal) {
    modalApi.show = () => window.jQuery(modalEl).modal('show');
    modalApi.hide = () => window.jQuery(modalEl).modal('hide');
  } else {
    console.warn('Không tìm thấy Bootstrap modal API (BS4/BS5). Popup có thể không hoạt động.');
  }

  // ====== DATEPICKER (jQuery UI) ======
  // Bạn đã include jquery-ui.min.js nên dùng luôn để khỏi cần flatpickr
  if (window.jQuery && window.jQuery.fn && window.jQuery.fn.datepicker) {
    window.jQuery(elIn).datepicker({ dateFormat: 'yy-mm-dd' });
    window.jQuery(elOut).datepicker({ dateFormat: 'yy-mm-dd' });
  } else {
    // Nếu thiếu jquery-ui thì vẫn chạy, nhưng user phải nhập đúng YYYY-MM-DD
    console.warn('Không có jQuery UI datepicker. Hãy nhập ngày theo YYYY-MM-DD.');
  }

  // ====== API ======
  async function fetchMonth(month) {
    // month MUST be YYYY-MM
    const res = await fetch(`${apiUrl}?month=${encodeURIComponent(month)}`, {
      headers: { 'Accept': 'application/json' }
    });

    if (res.ok) return await res.json();

    // handle error message from backend
    let detail = '';
    try {
      const ct = res.headers.get('content-type') || '';
      if (ct.includes('application/json')) {
        const j = await res.json();
        // Laravel validation typical:
        // { message: "...", errors: {month:["..."]}}
        if (j?.errors?.month?.length) detail = j.errors.month.join(', ');
        else detail = j?.message || '';
      } else {
        detail = await res.text();
      }
    } catch (e) {}

    const msg = detail ? `Không tải được dữ liệu lịch: ${detail}` : 'Không tải được dữ liệu lịch';
    throw new Error(msg);
  }

  function inRange(dateYmd, startYmd, endYmd) {
    // [start, end)
    return dateYmd >= startYmd && dateYmd < endYmd;
  }

  // ====== RENDER ======
  function renderCalendarTable() {
    const data = state.data;
    const days = data.days;   // ["YYYY-MM-DD",...]
    const rooms = data.rooms; // [{id,name,default_total,days:{...}}]

    calTitle.textContent = `Lịch phòng tháng ${data.month}`;

    // thead
    let th = `<tr><th style="min-width:220px;">Loại phòng</th>`;
    for (const d of days) {
      const dayNum = d.split('-')[2];
      th += `<th class="text-center" style="min-width:54px;">${dayNum}</th>`;
    }
    th += `</tr>`;
    calThead.innerHTML = th;

    const chosenRoomId = String(state.roomId);
    const qty = Number(state.qty || 1);
    const checkIn = state.checkIn;
    const checkOut = state.checkOut;

    let tb = '';

    for (const r of rooms) {
      const isActiveRow = String(r.id) === chosenRoomId;

      tb += `<tr class="${isActiveRow ? 'room-row-active' : ''}">
        <td>
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <b>${escapeHtml(r.name)}</b><br/>
              <small class="text-muted">Mặc định: ${Number(r.default_total || 0)} phòng</small>
            </div>
          </div>
        </td>`;

      for (const d of days) {
        const cell = (r.days && r.days[d]) ? r.days[d] : { total: 0, booked: 0, hold: 0, remain: 0, status: 'close' };

        const total  = Number(cell.total || 0);
        const booked = Number(cell.booked || 0);
        const remain = Number(cell.remain || 0);
        const status = cell.status || 'open';

        const selected = (checkIn && checkOut) ? inRange(d, checkIn, checkOut) : false;
        const ok = (status === 'open' && remain >= qty);

        const cellClass = [
          'text-center',
          'cell-clickable',
          selected ? 'cell-selected' : '',
          selected ? (ok ? 'cell-ok' : 'cell-bad') : (status !== 'open' ? 'cell-bad' : ''),
        ].join(' ').trim();

        const title = `Ngày ${d}\nStatus: ${status}\nĐã đặt: ${booked}\nCòn: ${remain}\nTổng: ${total}`;

        tb += `<td class="${cellClass}" data-date="${d}">
          <div style="font-size:12px;line-height:1.2" title="${escapeAttr(title)}">
            <div><b>${booked}</b>/<b>${remain}</b>/<b>${total}</b></div>
          </div>
        </td>`;
      }

      tb += `</tr>`;
    }

    calTbody.innerHTML = tb;

    // click chọn ngày trên lịch
    calTbody.querySelectorAll('td[data-date]').forEach(td => {
      td.addEventListener('click', () => onClickDay(td.getAttribute('data-date')));
    });

    updateBookButtonState();
  }

  function updateBookButtonState() {
    const data = state.data;
    const rooms = data.rooms || [];
    const qty = Number(state.qty || 1);

    uiCheckIn.textContent = state.checkIn || '-';
    uiCheckOut.textContent = state.checkOut || '-';
    uiQty.textContent = qty;

    const selectedRoom = rooms.find(x => String(x.id) === String(state.roomId));
    uiRoomName.textContent = selectedRoom ? selectedRoom.name : '-';

    let okAll = true;
    let badDays = [];

    if (!state.checkIn || !state.checkOut) okAll = false;
    if (state.checkOut && state.checkIn && state.checkOut <= state.checkIn) okAll = false;

    if (okAll && selectedRoom) {
      let d = state.checkIn;
      while (d < state.checkOut) {
        const cell = (selectedRoom.days && selectedRoom.days[d]) ? selectedRoom.days[d] : null;
        const remain = Number(cell?.remain || 0);
        const status = cell?.status || 'close';
        if (!(status === 'open' && remain >= qty)) {
          okAll = false;
          badDays.push(d);
        }
        d = addDays(d, 1);
        if (!d) { okAll = false; break; }
      }
    } else {
      okAll = false;
    }

    btnBookNow.disabled = !okAll;

    if (!state.checkIn || !state.checkOut) {
      uiResultNote.innerHTML = `<div class="alert alert-warning py-2">Hãy chọn ngày nhận & ngày trả (hoặc click trực tiếp trên lịch).</div>`;
      return;
    }

    if (state.checkOut <= state.checkIn) {
      uiResultNote.innerHTML = `<div class="alert alert-danger py-2">Ngày trả phải sau ngày nhận.</div>`;
      return;
    }

    if (okAll) {
      uiResultNote.innerHTML = `<div class="alert alert-success py-2">✅ Khoảng ngày đã chọn còn đủ phòng. Bạn có thể bấm <b>Đặt phòng ngay</b>.</div>`;
    } else {
      uiResultNote.innerHTML = `<div class="alert alert-secondary py-2">
        ⚠️ Một số ngày không đủ phòng hoặc đóng bán: <b>${badDays.slice(0,8).join(', ')}</b>${badDays.length>8?'...':''}.
        <br/>Bạn có thể <b>click 2 ô ngày</b> trên lịch để chọn lại.
      </div>`;
    }
  }

  async function openModalAndLoad(month) {
    state.month = month;              // YYYY-MM
    state.data = await fetchMonth(month);
    renderCalendarTable();
    modalApi.show();
  }

  function onClickDay(dateStr) {
    // click 2 lần để tạo range: start -> end
    if (!state.picking.start || (state.picking.start && state.picking.end)) {
      state.picking.start = dateStr;
      state.picking.end = null;

      state.checkIn = dateStr;
      state.checkOut = addDays(dateStr, 1);
    } else {
      const a = state.picking.start;
      let start = a, end = dateStr;

      if (end < start) { const tmp = start; start = end; end = tmp; }

      state.checkIn = start;
      state.checkOut = addDays(end, 1);
      state.picking.end = end;
    }

    // sync input + datepicker UI
    elIn.value = state.checkIn || '';
    elOut.value = state.checkOut || '';

    renderCalendarTable();
  }

  function safeGetCurrentMonthStartYmd() {
    // ưu tiên state.data.start nếu có (YYYY-MM-DD)
    const s = state?.data?.start;
    const dt = s ? parseYmdStrict(s) : null;
    if (dt) return ymd(dt);
    // fallback theo state.month
    if (state.month && /^\d{4}-\d{2}$/.test(state.month)) return `${state.month}-01`;
    // fallback now
    const now = new Date();
    return ymd(new Date(now.getFullYear(), now.getMonth(), 1));
  }

  btnPrevMonth.addEventListener('click', async () => {
    const startYmd = safeGetCurrentMonthStartYmd();
    const dt = parseYmdStrict(startYmd);
    dt.setMonth(dt.getMonth() - 1);
    await openModalAndLoad(`${dt.getFullYear()}-${pad2(dt.getMonth()+1)}`);
  });

  btnNextMonth.addEventListener('click', async () => {
    const startYmd = safeGetCurrentMonthStartYmd();
    const dt = parseYmdStrict(startYmd);
    dt.setMonth(dt.getMonth() + 1);
    await openModalAndLoad(`${dt.getFullYear()}-${pad2(dt.getMonth()+1)}`);
  });

  btnBookNow.addEventListener('click', () => {
    const qs = new URLSearchParams({
      check_in: state.checkIn,
      check_out: state.checkOut,
      room_id: state.roomId,
      qty: String(state.qty)
    });
    window.location.href = `/phong?${qs.toString()}`;
  });

  // ====== SUBMIT FILTER ======
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    hideErr();

    // normalize input
    const checkIn = normalizeToYmd(elIn.value);
    const checkOut = normalizeToYmd(elOut.value);

    if (!checkIn || !checkOut) return showErr('Vui lòng chọn ngày nhận và ngày trả (đúng định dạng).');
    if (checkOut <= checkIn) return showErr('Ngày trả phải sau ngày nhận.');

    state.checkIn = checkIn;
    state.checkOut = checkOut;
    state.roomId = elRoom.value;
    state.qty = Number(elQty.value || 1);
    state.picking.start = null;
    state.picking.end = null;

    // month MUST be YYYY-MM
    const month = ymFromYmd(checkIn);

    try {
      await openModalAndLoad(month);
    } catch (e2) {
      showErr(e2?.message || 'Có lỗi xảy ra.');
    }
  });

})();
</script>


</body>

</html>
