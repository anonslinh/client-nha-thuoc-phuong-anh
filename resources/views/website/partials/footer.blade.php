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

    <div class="lc-footer-main">
        <div class="lc-container">
            <div class="lc-footer-grid">
                <div>
                    <div class="lc-footer-col-title">Về chúng tôi</div>
                    <ul class="lc-footer-list">
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Hệ thống cửa hàng</a></li>
                        <li><a href="#">Giấy phép kinh doanh</a></li>
                    </ul>
                </div>

                <div>
                    <div class="lc-footer-col-title">Danh mục</div>
                    <ul class="lc-footer-list">
                        <li><a href="#">Thực phẩm chức năng</a></li>
                        <li><a href="#">Dược mỹ phẩm</a></li>
                        <li><a href="#">Thuốc</a></li>
                    </ul>
                </div>

                <div>
                    <div class="lc-footer-col-title">Tìm hiểu thêm</div>
                    <ul class="lc-footer-list">
                        <li><a href="#">Góc sức khoẻ</a></li>
                        <li><a href="#">Tra cứu thuốc</a></li>
                        <li><a href="#">Bệnh thường gặp</a></li>
                    </ul>
                </div>

                <div class="lc-footer-contact-block">
                    <div>
                        <div class="lc-footer-hotline-title">Tổng đài (8:00 - 22:00)</div>
                        <div class="lc-footer-hotline-row">
                                    <span>085 884 5845</span>
                                    <span>Tư vấn 24/7</span>
                                </div>
                    </div>

                    <div class="lc-footer-social">
                        <div class="lc-footer-col-title">Kết nối với chúng tôi</div>
                        <div class="lc-footer-social-icons">
                            <div class="lc-footer-social-icon">f</div>
                            <div class="lc-footer-social-icon">Z</div>
                        </div>
                    </div>

                    <div class="lc-footer-qr">
                        <img src="{{ asset('phuonganh/img/qrcodeoa.jpg') }}" style="width:150px;" alt="QR OA" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>