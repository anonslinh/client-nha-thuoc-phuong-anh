<footer class="lc-footer">
            @once
                <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">
            @endonce

            <!-- Thanh xanh trên -->
            <div class="lc-footer-top">
                <div class="lc-container">
                    <div class="lc-footer-top-inner">
                        <div class="lc-footer-top-left">
                            <div class="lc-footer-top-left-icon">
                                <i class="ri-map-pin-2-line" aria-hidden="true"></i>
                            </div>

                            <div>Danh sách hệ thống 16 cửa hàng tại Cao Bằng</div>
                        </div>

                        <button
                            onclick="window.location.href='{{ route('website.near-branches') }}'"
                            class="lc-footer-top-btn"
                            type="button"
                        >
                            <span>Xem danh sách nhà thuốc</span>
                            <i class="ri-arrow-right-line" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Phần nội dung chính -->
            <div class="lc-footer-main">
                <div class="lc-container">
                    <div class="lc-footer-grid">
                        <!-- Cột 1: Về chúng tôi -->
                        <div>
                            <div class="lc-footer-col-title">Về chúng tôi</div>
                            <ul class="lc-footer-list">
                                <li><a href="#">Giới thiệu</a></li>
                                <li><a href="#">Hệ thống cửa hàng</a></li>
                                <li><a href="#">Giấy phép kinh doanh</a></li>
                                <li><a href="#">Quy chế hoạt động</a></li>
                                <li><a href="#">Chính sách đặt cọc</a></li>
                                <li><a href="#">Chính sách nội dung</a></li>
                                <li><a href="#">Chính sách đổi trả thuốc</a></li>
                                <li><a href="#">Chính sách giao hàng</a></li>
                                <li><a href="#">Chính sách bảo mật dữ liệu cá nhân khách hàng</a></li>
                                <li>
                                    <a href="#">
                                        Thể lệ chương trình “Tích điểm nhận đặc quyền”
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Cột 2: Danh mục -->
                        <div>
                            <div class="lc-footer-col-title">Danh mục</div>
                            <ul class="lc-footer-list">
                                <li><a href="#">Thực phẩm chức năng</a></li>
                                <li><a href="#">Dược mỹ phẩm</a></li>
                                <li><a href="#">Thuốc</a></li>
                                <li><a href="#">Chăm sóc cá nhân</a></li>
                                <li><a href="#">Trang thiết bị y tế</a></li>
                                <li><a href="#">Đặt thuốc online</a></li>
                            </ul>
                        </div>

                        <!-- Cột 3: Tìm hiểu thêm -->
                        <div>
                            <div class="lc-footer-col-title">Tìm hiểu thêm</div>
                            <ul class="lc-footer-list">
                                <li><a href="#">Góc sức khoẻ</a></li>
                                <li><a href="#">Tra cứu thuốc</a></li>
                                <li><a href="#">Tra cứu dược chất</a></li>
                                <li><a href="#">Bệnh thường gặp</a></li>
                                <li><a href="#">Đội ngũ chuyên môn</a></li>
                                <li><a href="#">Tin tức tuyển dụng</a></li>
                                <li><a href="#">Tin tức sự kiện</a></li>
                            </ul>
                        </div>

                        <!-- Cột 4: Liên hệ + MXH + QR + thanh toán -->
                        <div class="lc-footer-contact-block">
                            <!-- Hotline -->
                            <div>
                                <div class="lc-footer-hotline-title">
                                    Tổng đài (8:00 - 22:00)
                                </div>
                                <div class="lc-footer-hotline-row">
                                    <span>085 884 5845</span>
                                    <span>Tư vấn 24/7</span>
                                </div>
                            </div>

                            <!-- Kết nối & QR -->
                            <div class="lc-footer-social">
                                <div class="lc-footer-col-title">Kết nối với chúng tôi</div>
                                <div class="lc-footer-social-icons">
                                    <div class="lc-footer-social-icon">f</div>
                                    <div class="lc-footer-social-icon">Z</div>
                                </div>
                            </div>

                            <div class="lc-footer-qr">
                                <img src="phuonganh/img/qrcodeoa.jpg" style=" width: 150px; " alt="Sản phẩm thương hiệu 1" />
                            </div>

                            <!-- Chứng nhận + thanh toán -->
                            <div class="lc-footer-badges">
                                <div class="lc-footer-cert-row">
                                    <div class="lc-footer-badge-label">Chứng nhận bởi</div>
                                    <div class="lc-footer-cert-icons">
                                        <span class="lc-footer-cert-pill">DMCA</span>
                                        <span class="lc-footer-cert-pill">PCI DSS</span>
                                    </div>
                                </div>

                                <div class="lc-footer-pay-row">
                                    <div class="lc-footer-badge-label">Hỗ trợ thanh toán</div>
                                    <div class="lc-footer-pay-icons">
                                        <span class="lc-footer-pay-pill">VISA</span>
                                        <span class="lc-footer-pay-pill">Mastercard</span>
                                        <span class="lc-footer-pay-pill">JCB</span>
                                        <span class="lc-footer-pay-pill">Momo</span>
                                        <span class="lc-footer-pay-pill">Zalopay</span>
                                        <span class="lc-footer-pay-pill">VNPay</span>
                                        <span class="lc-footer-pay-pill">Apple Pay</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.lc-footer-grid -->
                </div>
            </div>
        </footer>