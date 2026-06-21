@once
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">
@endonce

@php
    $loggedInCustomer = auth('website_customer')->user();
    $guestCheckoutInfo = session('guest_checkout_info', []);
    $guestDisplayName = $loggedInCustomer->name ?? ($guestCheckoutInfo['customer_name'] ?? '');
    $isCustomerLoggedIn = !empty($loggedInCustomer);

    $headerSearchKeywords = $headerSearchKeywords ?? collect();
    $listMainCategory = $listMainCategory ?? collect();

    $getMainCategoryIcon = function ($name) {
        $catName = mb_strtolower($name ?? '', 'UTF-8');

        if (\Illuminate\Support\Str::contains($catName, ['thực phẩm', 'chức năng'])) {
            return 'ri-capsule-line';
        }

        if (\Illuminate\Support\Str::contains($catName, ['dược mỹ phẩm', 'mỹ phẩm'])) {
            return 'ri-dropper-line';
        }

        if (\Illuminate\Support\Str::contains($catName, ['không kê đơn'])) {
            return 'ri-medicine-bottle-line';
        }

        if (\Illuminate\Support\Str::contains($catName, ['kê đơn'])) {
            return 'ri-file-list-3-line';
        }

        if (\Illuminate\Support\Str::contains($catName, ['chăm sóc'])) {
            return 'ri-heart-pulse-line';
        }

        if (\Illuminate\Support\Str::contains($catName, ['thiết bị'])) {
            return 'ri-stethoscope-line';
        }

        if (\Illuminate\Support\Str::contains($catName, ['mẹ', 'bé', 'trẻ'])) {
            return 'ri-parent-line';
        }

        if (\Illuminate\Support\Str::contains($catName, ['vitamin', 'khoáng'])) {
            return 'ri-leaf-line';
        }

        return 'ri-medicine-bottle-line';
    };
@endphp

<header class="lc-header">
    <div class="lc-header-hero">
        <div class="lc-container">
            <div class="lc-header-top">
                <div class="lc-header-top-left">
                    <span class="lc-header-top-left-icon">
                        <i class="ri-shield-check-line" aria-hidden="true"></i>
                    </span>

                    <a href="#" class="lc-header-top-link">
                        <span>NTPA - Dược phẩm Phương Anh</span>
                        <strong>Tìm hiểu ngay</strong>
                    </a>
                </div>

                <div class="lc-header-top-right">
                    <a href="#" class="lc-header-top-link">
                        <i class="ri-smartphone-line lc-ri-top-icon" aria-hidden="true"></i>
                        <span>Tải ứng dụng</span>
                    </a>

                    <span class="lc-header-top-sep">|</span>

                    <a href="tel:0858845845" class="lc-header-top-link">
                        <i class="ri-phone-line lc-ri-top-icon" aria-hidden="true"></i>
                        <span>Tư vấn ngay: <strong>085 884 5845</strong></span>
                    </a>
                </div>
            </div>

            <div class="lc-header-main">
                <a href="{{ url('/') }}" class="lc-logo">
                    <div class="lc-logo-mark">
                        <img src="{{ asset('phuonganh/img/lg.png') }}" alt="Dược Phương Anh">
                    </div>

                    <div class="lc-logo-text">
                        <span>Dược - Y tế</span>
                        <strong>NHÀ THUỐC<br>PHƯƠNG ANH</strong>
                    </div>
                </a>

                <div class="pa-mobile-header-actions" aria-label="Thao tác nhanh mobile">
                    <button type="button" data-pa-mobile-user aria-label="Thông tin khách hàng">
                        <i class="ri-user-3-line" aria-hidden="true"></i>
                    </button>
                    <a href="{{ route('website.cart.index') }}" aria-label="Giỏ hàng">
                        <i class="ri-shopping-cart-2-line" aria-hidden="true"></i>
                    </a>
                    <button type="button" data-pa-mobile-menu aria-label="Mở menu">
                        <i class="ri-menu-3-line" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="lc-search-wrap">
                    <form method="GET" action="{{ route('website.search.index') }}" class="lc-search-bar">
                        <div class="lc-search-input-wrap">
                            <button type="submit" class="lc-search-submit-btn" aria-label="Tìm kiếm">
                                <i class="ri-search-line" aria-hidden="true"></i>
                            </button>

                            <input
                                type="text"
                                name="q"
                                class="lc-search-input"
                                placeholder="Tìm thuốc, thực phẩm chức năng, thiết bị y tế..."
                                value="{{ request('q') }}"
                                autocomplete="off"
                            >
                        </div>

                        <div class="lc-search-actions">
                            <button class="lc-icon-btn lc-icon-btn-plain" type="button" aria-label="Tìm bằng giọng nói">
                                <i class="ri-mic-line" aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>

                    <div class="lc-search-suggestions">
                        @forelse($headerSearchKeywords as $keyword)
                            <a href="{{ route('website.search.keyword', ['id' => $keyword->id]) }}">
                                {{ $keyword->key_search }}
                            </a>
                        @empty
                            <span>Omega 3</span>
                            <span>Canxi</span>
                            <span>Dung dịch vệ sinh</span>
                        @endforelse
                    </div>
                </div>

                <div class="lc-header-actions">
                    <button type="button" class="lc-link-user" id="lcOpenGuestPopupHeader" data-logged-in="{{ $isCustomerLoggedIn ? '1' : '0' }}">
                        <span class="lc-link-user-icon">
                            <i class="ri-user-3-line" aria-hidden="true"></i>
                        </span>

                        <span class="lc-link-user-text">
                            {{ $guestDisplayName ? \Illuminate\Support\Str::limit($guestDisplayName, 18) : 'Đăng nhập' }}
                        </span>
                    </button>

                    <a href="{{ route('website.cart.index') }}" class="lc-btn-cart">
                        <span class="lc-btn-cart-icon">
                            <i class="ri-shopping-cart-2-line" aria-hidden="true"></i>
                        </span>

                        <span class="lc-btn-cart-text">Giỏ hàng</span>
                    </a>

                    <button type="button" class="lc-mobile-menu-trigger" id="lcOpenMobileMenuHeader" aria-label="Mở menu">
                        <i class="ri-menu-3-line" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="lc-header-nav">
        <div class="lc-container">
            <nav class="lc-header-nav-inner">
                @foreach($listMainCategory as $item)
                    <a
                        href="{{ route('website.main-category-v1.show', ['id' => $item->id]) }}"
                        class="lc-nav-item lc-nav-item--has-dropdown"
                    >
                        <i class="{{ $getMainCategoryIcon($item->name) }} lc-nav-item-icon" aria-hidden="true"></i>
                        <span>{{ $item->name }}</span>
                    </a>
                @endforeach
            </nav>
        </div>
    </div>
</header>

<div class="lc-mobile-menu" id="lcMobileMenuHeader">
    <div class="lc-mobile-menu-backdrop" id="lcMobileMenuBackdropHeader"></div>

    <aside class="lc-mobile-menu-panel" aria-label="Menu mobile">
        <div class="lc-mobile-menu-head">
            <a href="{{ url('/') }}" class="lc-mobile-brand">
                <div class="lc-mobile-brand-logo">
                    <img src="{{ asset('phuonganh/img/lg.png') }}" alt="Dược Phương Anh">
                </div>

                <div class="lc-mobile-brand-text">
                    <strong>Dược Phương Anh</strong>
                    <span>Nhà thuốc chuẩn chuyên môn</span>
                </div>
            </a>

            <button type="button" class="lc-mobile-menu-close" id="lcCloseMobileMenuHeader" aria-label="Đóng menu">
                <i class="ri-close-line" aria-hidden="true"></i>
            </button>
        </div>

        <form method="GET" action="{{ route('website.search.index') }}" class="lc-mobile-drawer-search">
            <button type="submit" aria-label="Tìm kiếm">
                <i class="ri-search-line" aria-hidden="true"></i>
            </button>

            <input
                type="text"
                name="q"
                placeholder="Tìm sản phẩm..."
                value="{{ request('q') }}"
                autocomplete="off"
            >
        </form>

        <div class="lc-mobile-menu-section">
            <button type="button" class="lc-mobile-menu-section-title active" data-mobile-accordion-header="mobileCategoryListHeader">
                <span>Danh mục sản phẩm</span>
                <i class="ri-arrow-down-s-line" aria-hidden="true"></i>
            </button>

            <div class="lc-mobile-menu-list show" id="mobileCategoryListHeader">
                @forelse($listMainCategory as $item)
                    <a href="{{ route('website.main-category-v1.show', ['id' => $item->id]) }}" class="lc-mobile-menu-link">
                        <i class="{{ $getMainCategoryIcon($item->name) }}" aria-hidden="true"></i>
                        <span>{{ $item->name }}</span>
                    </a>
                @empty
                    <div class="lc-mobile-menu-empty">Đang cập nhật danh mục.</div>
                @endforelse
            </div>
        </div>

        <div class="lc-mobile-menu-section">
            <button type="button" class="lc-mobile-menu-section-title" data-mobile-accordion-header="mobileNavigationListHeader">
                <span>Điều hướng</span>
                <i class="ri-arrow-down-s-line" aria-hidden="true"></i>
            </button>

            <div class="lc-mobile-menu-list" id="mobileNavigationListHeader">
                <a href="{{ url('/') }}" class="lc-mobile-menu-link">
                    <i class="ri-home-5-line" aria-hidden="true"></i>
                    <span>Trang chủ</span>
                </a>

                <a href="{{ route('website.cart.index') }}" class="lc-mobile-menu-link">
                    <i class="ri-shopping-cart-2-line" aria-hidden="true"></i>
                    <span>Giỏ hàng</span>
                </a>

                <button type="button" class="lc-mobile-menu-link lc-mobile-menu-link-button" id="lcOpenGuestPopupFromMobileHeader">
                    <i class="ri-user-3-line" aria-hidden="true"></i>
                    <span>Thông tin khách hàng</span>
                </button>
            </div>
        </div>

        <div class="lc-mobile-menu-section">
            <button type="button" class="lc-mobile-menu-section-title" data-mobile-accordion-header="mobileSupportListHeader">
                <span>Hỗ trợ khách hàng</span>
                <i class="ri-arrow-down-s-line" aria-hidden="true"></i>
            </button>

            <div class="lc-mobile-menu-list" id="mobileSupportListHeader">
                <a href="tel:0858845845" class="lc-mobile-menu-link">
                    <i class="ri-phone-line" aria-hidden="true"></i>
                    <span>Tư vấn ngay: 085 884 5845</span>
                </a>

                <a href="#" class="lc-mobile-menu-link">
                    <i class="ri-shield-check-line" aria-hidden="true"></i>
                    <span>Cam kết chính hãng</span>
                </a>

                <a href="#" class="lc-mobile-menu-link">
                    <i class="ri-truck-line" aria-hidden="true"></i>
                    <span>Giao hàng tận nơi</span>
                </a>
            </div>
        </div>
    </aside>
</div>

<div class="lc-guest-popup" id="lcGuestPopupHeader" data-initial-step="{{ $isCustomerLoggedIn ? 'account' : 'phone' }}">
    <div class="lc-guest-popup-backdrop" id="lcGuestPopupBackdropHeader"></div>

    <div class="lc-guest-popup-dialog">
        <button type="button" class="lc-guest-popup-close" id="lcCloseGuestPopupHeader" aria-label="Đóng">
            <i class="ri-close-line" aria-hidden="true"></i>
        </button>

        <div class="lc-guest-popup-head">
            <div class="lc-guest-popup-icon">
                <i class="ri-user-heart-line" aria-hidden="true"></i>
            </div>

            <div>
                <h3 id="lcGuestPopupTitle">{{ $isCustomerLoggedIn ? 'Tài khoản của bạn' : 'Đăng nhập' }}</h3>
                <p id="lcGuestPopupDesc">
                    @if(session('open_login_popup') && session('error'))
                        {{ session('error') }}
                    @else
                        {{ $isCustomerLoggedIn ? 'Quản lý thông tin tài khoản dùng cho đặt hàng.' : 'Đăng nhập bằng số điện thoại, xác thực OTP qua Zalo.' }}
                    @endif
                </p>
            </div>
        </div>

        {{-- BƯỚC 1: NHẬP SỐ ĐIỆN THOẠI --}}
        <div class="lc-auth-step" id="lcAuthStepPhone">
            <div class="lc-guest-form-group">
                <label>
                    <i class="ri-phone-line" aria-hidden="true"></i>
                    Số điện thoại
                </label>

                <input
                    type="tel"
                    id="lcAuthPhoneInput"
                    value="{{ $guestCheckoutInfo['customer_phone'] ?? '' }}"
                    placeholder="VD: 0912345678"
                    autocomplete="tel"
                >
            </div>

            <div class="lc-guest-error" id="lcAuthPhoneError"></div>

            <div class="lc-guest-popup-actions">
                <button type="button" class="lc-guest-btn lc-guest-btn-primary" id="lcAuthSendOtpBtn">
                    <i class="ri-shield-keyhole-line" aria-hidden="true"></i>
                    Gửi mã OTP qua Zalo
                </button>
            </div>

            <button type="button" class="lc-auth-link-btn" id="lcAuthGoToSecretBtn">
                <i class="ri-key-2-line" aria-hidden="true"></i>
                Đăng nhập bằng mã bí mật (nội bộ)
            </button>
        </div>

        {{-- BƯỚC 1b: NHẬP MÃ BÍ MẬT (NỘI BỘ) --}}
        <div class="lc-auth-step" id="lcAuthStepSecret" style="display:none;">
            <div class="lc-guest-form-group">
                <label>
                    <i class="ri-key-2-line" aria-hidden="true"></i>
                    Mã bí mật
                </label>

                <input
                    type="text"
                    id="lcAuthSecretInput"
                    inputmode="numeric"
                    maxlength="10"
                    placeholder="Nhập mã bí mật 10 số"
                    autocomplete="off"
                >
            </div>

            <div class="lc-guest-error" id="lcAuthSecretError"></div>

            <div class="lc-guest-popup-actions">
                <button type="button" class="lc-guest-btn lc-guest-btn-primary" id="lcAuthVerifySecretBtn">
                    <i class="ri-check-line" aria-hidden="true"></i>
                    Đăng nhập
                </button>
            </div>

            <button type="button" class="lc-auth-link-btn" id="lcAuthBackToPhoneFromSecretBtn">
                <i class="ri-arrow-left-line" aria-hidden="true"></i>
                Quay lại đăng nhập bằng số điện thoại
            </button>
        </div>

        {{-- BƯỚC 2: NHẬP MÃ OTP --}}
        <div class="lc-auth-step" id="lcAuthStepOtp" style="display:none;">
            <p class="lc-auth-otp-hint">
                Mã OTP đã được gửi qua Zalo tới số <strong id="lcAuthOtpPhoneLabel"></strong>. Hiệu lực trong 5 phút.
            </p>

            <div class="lc-guest-form-group">
                <label>
                    <i class="ri-shield-keyhole-line" aria-hidden="true"></i>
                    Mã OTP
                </label>

                <input
                    type="text"
                    id="lcAuthOtpInput"
                    inputmode="numeric"
                    maxlength="4"
                    placeholder="Nhập mã 4 số"
                    autocomplete="one-time-code"
                >
            </div>

            <div class="lc-guest-form-group" id="lcAuthOtpNameGroup" style="display:none;">
                <label>
                    <i class="ri-user-line" aria-hidden="true"></i>
                    Họ và tên
                </label>

                <input type="text" id="lcAuthOtpNameInput" placeholder="Nhập họ và tên của bạn">
            </div>

            <div class="lc-guest-error" id="lcAuthOtpError"></div>

            <div class="lc-guest-popup-actions">
                <button type="button" class="lc-guest-btn lc-guest-btn-primary" id="lcAuthVerifyOtpBtn">
                    <i class="ri-check-line" aria-hidden="true"></i>
                    Xác nhận
                </button>
            </div>

            <button type="button" class="lc-auth-link-btn" id="lcAuthBackToPhoneBtn">
                <i class="ri-arrow-left-line" aria-hidden="true"></i>
                Đổi số điện thoại / Gửi lại mã
            </button>
        </div>

        {{-- BƯỚC 3: THÔNG TIN TÀI KHOẢN (đã đăng nhập) --}}
        <div class="lc-auth-step" id="lcAuthStepAccount" style="display:none;">
            <form method="POST" action="{{ route('website.auth.update-profile') }}" class="lc-guest-form">
                @csrf

                <div class="lc-guest-form-grid">
                    <div class="lc-guest-form-group">
                        <label>
                            <i class="ri-user-line" aria-hidden="true"></i>
                            Họ và tên *
                        </label>

                        <input
                            type="text"
                            name="customer_name"
                            value="{{ old('customer_name', $guestCheckoutInfo['customer_name'] ?? '') }}"
                            placeholder="Nhập họ và tên"
                        >

                        @error('customer_name')
                            <div class="lc-guest-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="lc-guest-form-group">
                        <label>
                            <i class="ri-phone-line" aria-hidden="true"></i>
                            Số điện thoại
                        </label>

                        <input type="text" value="{{ $guestCheckoutInfo['customer_phone'] ?? '' }}" disabled>
                    </div>

                    <div class="lc-guest-form-group full">
                        <label>
                            <i class="ri-mail-line" aria-hidden="true"></i>
                            Email
                        </label>

                        <input
                            type="text"
                            name="customer_email"
                            value="{{ old('customer_email', $guestCheckoutInfo['customer_email'] ?? '') }}"
                            placeholder="Nhập email nếu có"
                        >

                        @error('customer_email')
                            <div class="lc-guest-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="lc-guest-form-group">
                        <label>
                            <i class="ri-map-pin-2-line" aria-hidden="true"></i>
                            Tỉnh / Thành
                        </label>

                        <input
                            type="text"
                            name="province_name"
                            value="{{ old('province_name', $guestCheckoutInfo['province_name'] ?? 'Cao Bằng') }}"
                            placeholder="Tỉnh / thành"
                        >
                    </div>

                    <div class="lc-guest-form-group">
                        <label>
                            <i class="ri-map-2-line" aria-hidden="true"></i>
                            Quận / Huyện
                        </label>

                        <input
                            type="text"
                            name="district_name"
                            value="{{ old('district_name', $guestCheckoutInfo['district_name'] ?? '') }}"
                            placeholder="Quận / huyện"
                        >
                    </div>

                    <div class="lc-guest-form-group">
                        <label>
                            <i class="ri-community-line" aria-hidden="true"></i>
                            Phường / Xã
                        </label>

                        <input
                            type="text"
                            name="ward_name"
                            value="{{ old('ward_name', $guestCheckoutInfo['ward_name'] ?? '') }}"
                            placeholder="Phường / xã"
                        >
                    </div>

                    <div class="lc-guest-form-group full">
                        <label>
                            <i class="ri-home-5-line" aria-hidden="true"></i>
                            Địa chỉ chi tiết
                        </label>

                        <textarea
                            name="address_detail"
                            placeholder="Số nhà, xóm, tổ dân phố..."
                        >{{ old('address_detail', $guestCheckoutInfo['address_detail'] ?? '') }}</textarea>
                    </div>
                </div>

                <div class="lc-guest-popup-actions">
                    <button type="submit" class="lc-guest-btn lc-guest-btn-primary">
                        <i class="ri-save-3-line" aria-hidden="true"></i>
                        Lưu thông tin
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('website.auth.logout') }}" style="margin-top:12px;">
                @csrf

                <button type="submit" class="lc-guest-btn lc-guest-btn-light" style="width:100%;">
                    <i class="ri-logout-box-r-line" aria-hidden="true"></i>
                    Đăng xuất
                </button>
            </form>
        </div>
    </div>
</div>

@once
<style>
    :root{
        --pa-brand: #0c585c;
        --pa-brand-2: #0c8f75;
        --pa-brand-soft: rgba(12, 88, 92, .07);
        --pa-border: #dbe7e5;
        --pa-text: #0f172a;
        --pa-muted: #64748b;
    }

    .lc-header i,
    .pa-mobile-header-actions i,
    .lc-mobile-menu i,
    .lc-guest-popup i{
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 400 !important;
        -webkit-text-stroke: 0 !important;
    }

    .lc-logo-mark img{
        width: 56px;
        height: auto;
        display: block;
    }

    .lc-header-top-left-icon{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .16);
        color: #ffffff;
        font-size: 15px;
        flex: 0 0 auto;
    }

    .lc-ri-top-icon{
        font-size: 15px;
        color: currentColor;
        opacity: .92;
    }

    .pa-mobile-header-actions{
        display: none;
    }

    .lc-search-input-wrap .lc-search-submit-btn,
    button.lc-search-submit-btn{
        width: 38px;
        height: 38px;
        min-width: 38px;
        border: 0 !important;
        outline: none !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
        color: var(--pa-brand) !important;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
    }

    .lc-search-submit-btn i{
        font-size: 22px;
        line-height: 1;
        color: var(--pa-brand);
    }

    .lc-search-actions{
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .lc-search-actions .lc-icon-btn,
    .lc-search-actions .lc-icon-btn-plain,
    button.lc-icon-btn{
        width: 36px;
        height: 36px;
        min-width: 36px;
        border: 0 !important;
        outline: none !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
        color: var(--pa-brand) !important;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
    }

    .lc-search-actions .lc-icon-btn i{
        font-size: 22px;
        line-height: 1;
        color: var(--pa-brand);
    }

    .lc-search-actions .lc-icon-btn:hover,
    .lc-search-submit-btn:hover{
        background: var(--pa-brand-soft) !important;
        border-radius: 999px;
    }

    .lc-search-actions .lc-icon-btn:focus,
    .lc-search-submit-btn:focus,
    .lc-search-actions .lc-icon-btn:active,
    .lc-search-submit-btn:active{
        border: 0 !important;
        outline: none !important;
        box-shadow: none !important;
    }

    .lc-header-actions .lc-link-user{
        border: 0;
        background: transparent;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: inherit;
        font: inherit;
        padding: 0;
    }

    .lc-link-user-icon,
    .lc-btn-cart-icon{
        width: 30px;
        height: 30px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, .92);
        color: var(--pa-brand);
        box-shadow: 0 8px 18px rgba(15, 23, 42, .07);
        flex: 0 0 auto;
    }

    .lc-link-user-icon i,
    .lc-btn-cart-icon i{
        font-size: 17px;
    }

    .lc-header-actions .lc-btn-cart{
        text-decoration: none;
        color: inherit;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .lc-btn-cart-text{
        color: var(--pa-brand);
    }

    .lc-header-actions .lc-btn-cart:hover,
    .lc-header-actions .lc-link-user:hover{
        text-decoration: none;
        opacity: .92;
    }

    .lc-mobile-menu-trigger{
        display: none;
    }

    .lc-header-nav-inner{
        display: flex;
        align-items: center;
        gap: 34px;
    }

    .lc-nav-item{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #1f2937;
        font-size: 15px;
        font-weight: 500 !important;
        letter-spacing: 0;
        text-decoration: none;
        white-space: nowrap;
        transition: color .2s ease, transform .2s ease;
    }

    .lc-nav-item span{
        font-weight: 500 !important;
    }

    .lc-nav-item:hover{
        color: var(--pa-brand);
        transform: translateY(-1px);
        text-decoration: none;
    }

    .lc-nav-item-icon{
        font-size: 18px;
        color: var(--pa-brand);
        line-height: 1;
        opacity: .92;
    }

    .lc-nav-item--has-dropdown::after{
        color: var(--pa-brand);
        opacity: .65;
        font-weight: 400;
    }

    .lc-mobile-menu{
        position: fixed;
        inset: 0;
        z-index: 10020;
        pointer-events: none;
    }

    .lc-mobile-menu-backdrop{
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, .48);
        opacity: 0;
        visibility: hidden;
        transition: opacity .25s ease, visibility .25s ease;
    }

    .lc-mobile-menu-panel{
        position: absolute;
        top: 0;
        left: 0;
        width: min(88vw, 372px);
        height: 100%;
        background: #ffffff;
        transform: translateX(-105%);
        transition: transform .28s ease;
        box-shadow: 24px 0 60px rgba(15, 23, 42, .18);
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        padding: 18px 16px 28px;
    }

    .lc-mobile-menu.show{
        pointer-events: auto;
    }

    .lc-mobile-menu.show .lc-mobile-menu-backdrop{
        opacity: 1;
        visibility: visible;
    }

    .lc-mobile-menu.show .lc-mobile-menu-panel{
        transform: translateX(0);
    }

    .lc-mobile-menu-head{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 20px;
    }

    .lc-mobile-brand{
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: var(--pa-text);
        min-width: 0;
    }

    .lc-mobile-brand-logo{
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(12, 143, 117, .12), rgba(12, 88, 92, .08));
        flex: 0 0 auto;
        overflow: hidden;
    }

    .lc-mobile-brand-logo img{
        width: 42px;
        height: auto;
        display: block;
    }

    .lc-mobile-brand-text{
        min-width: 0;
    }

    .lc-mobile-brand-text strong{
        display: block;
        color: var(--pa-brand);
        font-size: 17px;
        line-height: 1.25;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .lc-mobile-brand-text span{
        display: block;
        margin-top: 3px;
        color: var(--pa-muted);
        font-size: 12px;
        line-height: 1.35;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .lc-mobile-menu-close{
        width: 44px;
        height: 44px;
        border: 0;
        border-radius: 16px;
        background: rgba(12, 143, 117, .08);
        color: var(--pa-brand);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex: 0 0 auto;
    }

    .lc-mobile-menu-close i{
        font-size: 20px;
    }

    .lc-mobile-drawer-search{
        height: 50px;
        border: 1px solid var(--pa-border);
        border-radius: 999px;
        background: #fff;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 14px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
        margin-bottom: 20px;
    }

    .lc-mobile-drawer-search button{
        width: 28px;
        height: 28px;
        border: 0;
        background: transparent;
        color: var(--pa-brand);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        cursor: pointer;
    }

    .lc-mobile-drawer-search button i{
        font-size: 20px;
    }

    .lc-mobile-drawer-search input{
        flex: 1;
        min-width: 0;
        border: 0;
        outline: none;
        background: transparent;
        color: var(--pa-text);
        font-size: 15px;
    }

    .lc-mobile-drawer-search input::placeholder{
        color: #94a3b8;
    }

    .lc-mobile-menu-section{
        border-top: 1px solid #e3eeec;
    }

    .lc-mobile-menu-section:last-child{
        border-bottom: 1px solid #e3eeec;
    }

    .lc-mobile-menu-section-title{
        width: 100%;
        min-height: 58px;
        border: 0;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 0 2px;
        cursor: pointer;
        color: #083d3f;
        text-align: left;
    }

    .lc-mobile-menu-section-title span{
        font-size: 17px;
        font-weight: 700;
        letter-spacing: -.01em;
    }

    .lc-mobile-menu-section-title i{
        font-size: 20px;
        transition: transform .2s ease;
    }

    .lc-mobile-menu-section-title.active i{
        transform: rotate(180deg);
    }

    .lc-mobile-menu-list{
        display: none;
        padding: 4px 0 18px;
    }

    .lc-mobile-menu-list.show{
        display: block;
    }

    .lc-mobile-menu-link{
        min-height: 44px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #617273;
        text-decoration: none;
        font-size: 15px;
        font-weight: 400;
        line-height: 1.45;
        padding: 7px 4px;
        border-radius: 12px;
    }

    .lc-mobile-menu-link i{
        width: 22px;
        min-width: 22px;
        color: var(--pa-brand);
        font-size: 18px;
        opacity: .9;
    }

    .lc-mobile-menu-link:hover{
        color: var(--pa-brand);
        background: rgba(12, 88, 92, .06);
        text-decoration: none;
    }

    .lc-mobile-menu-link-button{
        width: 100%;
        border: 0;
        background: transparent;
        text-align: left;
        cursor: pointer;
        font-family: inherit;
    }

    .lc-mobile-menu-empty{
        color: #94a3b8;
        font-size: 14px;
        padding: 10px 4px 16px;
    }

    body.lc-menu-open{
        overflow: hidden;
        touch-action: none;
    }

    .lc-guest-popup{
        position: fixed;
        inset: 0;
        z-index: 10030;
        display: none;
    }

    .lc-guest-popup.show{
        display: block;
    }

    .lc-guest-popup-backdrop{
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, .45);
        backdrop-filter: blur(2px);
    }

    .lc-guest-popup-dialog{
        position: relative;
        width: min(760px, calc(100% - 24px));
        max-height: calc(100vh - 40px);
        overflow: auto;
        margin: 20px auto;
        background: #fff;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, .22);
    }

    .lc-guest-popup-close{
        position: absolute;
        top: 12px;
        right: 12px;
        width: 38px;
        height: 38px;
        border: 0;
        border-radius: 50%;
        background: #f1f5f9;
        color: #0f172a;
        font-size: 20px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .lc-guest-popup-close:hover{
        background: #e2e8f0;
    }

    .lc-guest-popup-head{
        margin-bottom: 18px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding-right: 38px;
    }

    .lc-guest-popup-icon{
        width: 44px;
        height: 44px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        background: linear-gradient(135deg, #e0f7f3 0%, #eefdf7 100%);
        color: var(--pa-brand-2);
        box-shadow: 0 10px 22px rgba(12, 143, 117, .12);
    }

    .lc-guest-popup-icon i{
        font-size: 22px;
    }

    .lc-guest-popup-head h3{
        margin: 0 0 8px;
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
    }

    .lc-guest-popup-head p{
        margin: 0;
        font-size: 15px;
        line-height: 1.7;
        color: #64748b;
    }

    .lc-guest-form-grid{
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .lc-guest-form-group{
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .lc-guest-form-group.full{
        grid-column: 1 / -1;
    }

    .lc-guest-form-group label{
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .lc-guest-form-group label i{
        font-size: 16px;
        color: var(--pa-brand-2);
    }

    .lc-guest-form-group input,
    .lc-guest-form-group textarea{
        width: 100%;
        min-height: 48px;
        border-radius: 14px;
        border: 1px solid #dbe4f0;
        background: #fff;
        padding: 0 14px;
        font-size: 15px;
        color: #0f172a;
        outline: none;
    }

    .lc-guest-form-group textarea{
        min-height: 110px;
        resize: vertical;
        padding: 12px 14px;
    }

    .lc-guest-form-group input:focus,
    .lc-guest-form-group textarea:focus{
        border-color: var(--pa-brand-2);
        box-shadow: 0 0 0 3px rgba(12, 143, 117, .1);
    }

    .lc-guest-error{
        font-size: 13px;
        color: #dc2626;
        font-weight: 600;
    }

    .lc-guest-popup-actions{
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        flex-wrap: wrap;
    }

    .lc-auth-step .lc-guest-popup-actions{
        justify-content: stretch;
    }

    .lc-auth-step .lc-guest-popup-actions .lc-guest-btn{
        width: 100%;
        justify-content: center;
    }

    .lc-auth-otp-hint{
        margin: 0 0 14px;
        font-size: 13px;
        color: #64748b;
        line-height: 1.6;
    }

    .lc-auth-otp-hint strong{
        color: #0c585c;
    }

    #lcAuthOtpInput{
        letter-spacing: 6px;
        font-size: 20px;
        font-weight: 800;
        text-align: center;
    }

    .lc-auth-link-btn{
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 14px;
        background: transparent;
        border: 0;
        color: #0c8f75;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        padding: 0;
    }

    .lc-auth-link-btn:hover{
        text-decoration: underline;
    }

    .lc-guest-btn{
        min-height: 46px;
        padding: 0 18px;
        border-radius: 999px;
        border: 0;
        cursor: pointer;
        font-size: 15px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .lc-guest-btn i{
        font-size: 17px;
    }

    .lc-guest-btn-primary{
        background: linear-gradient(135deg, var(--pa-brand-2) 0%, var(--pa-brand) 100%);
        color: #fff;
        box-shadow: 0 12px 24px rgba(12, 143, 117, .18);
    }

    .lc-guest-btn-light{
        background: #f8fafc;
        color: #334155;
        border: 1px solid #dbe4f0;
    }

    @media (max-width: 767px){
        .lc-header{
            position: relative;
            z-index: 30;
            background: #fff;
        }

        .lc-header-hero{
            padding: 1px 0 1px !important;
        }

        .lc-header .lc-container{
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        .lc-header-top{
            display: none !important;
        }

        .lc-header-main{
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 10px 8px;
            align-items: center;
        }

        .lc-logo{
            min-width: 0;
            max-width: 230px;
            display: inline-flex !important;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            overflow: hidden;
        }

        .lc-logo-mark{
            width: 42px !important;
            height: 42px !important;
            min-width: 42px !important;
            border-radius: 14px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex: 0 0 auto;
        }

        .lc-logo-mark img{
            width: 40px !important;
            max-width: 40px !important;
            height: auto !important;
            display: block;
        }

        .lc-logo-text{
            display: block !important;
            min-width: 0;
            overflow: hidden;
        }

        .lc-logo-text span{
            display: none !important;
        }

        .lc-logo-text strong{
            display: block !important;
            color: #ffffff;
            font-size: 14px !important;
            line-height: 1.16;
            letter-spacing: .035em;
            font-weight: 800;
            text-transform: uppercase;
            white-space: normal;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: 34px;
        }

        .lc-header-actions{
            display: inline-flex !important;
            align-items: center;
            gap: 6px;
            justify-content: flex-end;
        }

        .lc-link-user{
            display: none !important;
        }

        .lc-btn-cart{
            width: 36px !important;
            height: 36px !important;
            min-width: 36px !important;
            border-radius: 13px !important;
            padding: 0 !important;
            background: rgba(255, 255, 255, .94) !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 18px rgba(15, 23, 42, .08);
        }

        .lc-btn-cart-icon{
            width: auto !important;
            height: auto !important;
            background: transparent !important;
            box-shadow: none !important;
            color: var(--pa-brand) !important;
        }

        .lc-btn-cart-icon i{
            font-size: 18px !important;
        }

        .lc-btn-cart-text{
            display: none !important;
        }

        .lc-mobile-menu-trigger{
            width: 36px !important;
            height: 36px !important;
            min-width: 36px !important;
            border: 0 !important;
            border-radius: 13px !important;
            padding: 0 !important;
            background: rgba(255, 255, 255, .16) !important;
            color: #ffffff !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .lc-mobile-menu-trigger i{
            font-size: 20px !important;
        }

        .lc-search-wrap{
            grid-column: 1 / -1;
            width: 100%;
            order: 3;
            margin: 0 !important;
            padding: 0 !important;
        }

        .lc-header-main{
            grid-template-columns: minmax(0, 1fr) !important;
            position: relative !important;
        }

        .lc-logo{
            grid-column: 1 !important;
            grid-row: 1 !important;
        }

        .lc-header-actions{
            display: none !important;
        }

        .pa-mobile-header-actions{
            position: absolute !important;
            top: 50% !important;
            right: 0 !important;
            transform: translateY(-50%) !important;
            width: 126px;
            min-width: 126px;
            display: inline-flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            z-index: 2;
        }

        .pa-mobile-header-actions a,
        .pa-mobile-header-actions button{
            width: 38px;
            height: 38px;
            min-width: 38px;
            border: 0;
            border-radius: 999px;
            padding: 0;
            background: rgba(255,255,255,.94);
            color: var(--pa-brand);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 10px 22px rgba(3,40,44,.14);
        }

        .pa-mobile-header-actions a i,
        .pa-mobile-header-actions button i{
            font-size: 18px;
        }

        .lc-search-wrap{
            grid-column: 1 / -1 !important;
            grid-row: 2 !important;
            margin-top: 10px !important;
        }

        .lc-search-bar{
            height: 44px !important;
            min-height: 44px !important;
            border-radius: 999px !important;
            background: #ffffff !important;
            display: flex !important;
            align-items: center;
            overflow: hidden;
            box-shadow: 0 8px 18px rgba(15, 23, 42, .06);
        }

        .lc-search-input-wrap{
            flex: 1;
            min-width: 0;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .lc-search-input{
            width: 100%;
            height: 100%;
            min-width: 0;
            border: none;
            font-size: 13px !important;
            line-height: 1.2;
            padding-right: 4px !important;
            text-overflow: ellipsis;
        }

        .lc-search-input::placeholder{
            font-size: 13px !important;
            color: #94a3b8 !important;
        }

        .lc-search-input-wrap .lc-search-submit-btn,
        button.lc-search-submit-btn{
            width: 34px !important;
            height: 34px !important;
            min-width: 34px !important;
        }

        .lc-search-submit-btn i{
            font-size: 18px !important;
        }

        .lc-search-actions{
            gap: 2px !important;
            padding-right: 6px !important;
        }

        .lc-search-actions .lc-icon-btn,
        .lc-search-actions .lc-icon-btn-plain,
        button.lc-icon-btn{
            width: 32px !important;
            height: 32px !important;
            min-width: 32px !important;
        }

        .lc-search-actions .lc-icon-btn i{
            font-size: 18px !important;
        }

        .lc-header .lc-search-suggestions,
        .lc-search-suggestions{
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            max-height: 0 !important;
            min-height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            pointer-events: none !important;
        }

        .lc-header-nav{
            display: none !important;
        }

        .lc-mobile-menu-panel{
            width: min(88vw, 340px);
            padding: 16px 14px 24px;
        }

        .lc-mobile-brand-logo{
            width: 46px;
            height: 46px;
            border-radius: 14px;
        }

        .lc-mobile-brand-logo img{
            width: 38px;
        }

        .lc-mobile-brand-text strong{
            font-size: 16px;
        }

        .lc-mobile-brand-text span{
            font-size: 12px;
        }

        .lc-mobile-menu-close{
            width: 38px;
            height: 38px;
            border-radius: 14px;
        }

        .lc-mobile-menu-close i{
            font-size: 18px;
        }

        .lc-mobile-drawer-search{
            height: 44px;
            margin-bottom: 16px;
            padding: 0 12px;
        }

        .lc-mobile-drawer-search input{
            font-size: 13px;
        }

        .lc-mobile-menu-section-title{
            min-height: 52px;
        }

        .lc-mobile-menu-section-title span{
            font-size: 15px;
        }

        .lc-mobile-menu-link{
            min-height: 40px;
            font-size: 14px;
        }

        .lc-guest-popup-dialog{
            width: min(100%, calc(100% - 16px));
            margin: 8px auto;
            border-radius: 18px;
            padding: 18px;
        }

        .lc-guest-popup-head{
            gap: 10px;
        }

        .lc-guest-popup-head h3{
            font-size: 22px;
        }

        .lc-guest-popup-icon{
            width: 40px;
            height: 40px;
            border-radius: 14px;
        }

        .lc-guest-popup-icon i{
            font-size: 20px;
        }

        .lc-guest-form-grid{
            grid-template-columns: 1fr;
        }

        .lc-guest-popup-actions{
            flex-direction: column;
        }

        .lc-guest-btn{
            width: 100%;
        }
    }

    @media (max-width: 390px){
        .lc-header-hero{
            padding: 9px 0 10px !important;
        }

        .lc-logo{
            max-width: 210px;
            gap: 7px;
        }

        .lc-logo-mark{
            width: 40px !important;
            min-width: 40px !important;
            height: 40px !important;
        }

        .lc-logo-mark img{
            width: 38px !important;
            max-width: 38px !important;
        }

        .lc-logo-text strong{
            font-size: 13px !important;
            line-height: 1.15;
            letter-spacing: .03em;
            max-height: 31px;
        }

        .lc-btn-cart,
        .lc-mobile-menu-trigger{
            width: 34px !important;
            height: 34px !important;
            min-width: 34px !important;
        }

        .lc-btn-cart-icon i,
        .lc-mobile-menu-trigger i{
            font-size: 17px !important;
        }

        .lc-search-bar{
            height: 42px !important;
            min-height: 42px !important;
        }

        .lc-search-input,
        .lc-search-input::placeholder{
            font-size: 12.5px !important;
        }
    }

    @media (max-width: 340px){
        .lc-logo{
            max-width: 185px;
        }

        .lc-logo-text strong{
            font-size: 12px !important;
        }
    }

    @media (min-width: 768px){
        .lc-mobile-menu{
            display: none !important;
        }
    }

    @media (max-width: 767px){
        .lc-header-main,
        .lc-search-wrap,
        .lc-search-bar{
            width: 100% !important;
            max-width: 100% !important;
        }

        .pa-mobile-header-actions{
            right: 0 !important;
        }
    }
</style>
@endonce

@once
<script>
    (function () {
        const popup = document.getElementById('lcGuestPopupHeader');
        const openBtn = document.getElementById('lcOpenGuestPopupHeader');
        const openBtnFromMobile = document.getElementById('lcOpenGuestPopupFromMobileHeader');
        const closeBtn = document.getElementById('lcCloseGuestPopupHeader');
        const backdrop = document.getElementById('lcGuestPopupBackdropHeader');

        const mobileMenu = document.getElementById('lcMobileMenuHeader');
        const openMobileMenuBtn = document.getElementById('lcOpenMobileMenuHeader');
        const closeMobileMenuBtn = document.getElementById('lcCloseMobileMenuHeader');
        const mobileMenuBackdrop = document.getElementById('lcMobileMenuBackdropHeader');

        function showAuthStep(step, keepFlashDesc) {
            document.getElementById('lcAuthStepPhone').style.display = step === 'phone' ? 'block' : 'none';
            document.getElementById('lcAuthStepSecret').style.display = step === 'secret' ? 'block' : 'none';
            document.getElementById('lcAuthStepOtp').style.display = step === 'otp' ? 'block' : 'none';
            document.getElementById('lcAuthStepAccount').style.display = step === 'account' ? 'block' : 'none';

            const title = document.getElementById('lcGuestPopupTitle');
            const desc = document.getElementById('lcGuestPopupDesc');

            if (step === 'account') {
                title.textContent = 'Tài khoản của bạn';
                if (!keepFlashDesc) desc.textContent = 'Quản lý thông tin tài khoản dùng cho đặt hàng.';
            } else {
                title.textContent = 'Đăng nhập';
                if (!keepFlashDesc) desc.textContent = 'Đăng nhập bằng số điện thoại, xác thực OTP qua Zalo.';
            }
        }

        let lcAuthFirstOpen = true;

        function openPopup() {
            popup?.classList.add('show');
            document.body.style.overflow = 'hidden';
            showAuthStep(popup?.getAttribute('data-initial-step') || 'phone', lcAuthFirstOpen);
            lcAuthFirstOpen = false;
        }

        function closePopup() {
            popup?.classList.remove('show');
            document.body.style.overflow = '';
        }

        (function setupAuthFlow() {
            const SEND_OTP_URL = @json(route('website.auth.send-otp'));
            const VERIFY_OTP_URL = @json(route('website.auth.verify-otp'));
            const SECRET_LOGIN_URL = @json(route('website.auth.secret-login'));
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            const phoneInput = document.getElementById('lcAuthPhoneInput');
            const phoneError = document.getElementById('lcAuthPhoneError');
            const sendOtpBtn = document.getElementById('lcAuthSendOtpBtn');

            const otpInput = document.getElementById('lcAuthOtpInput');
            const otpError = document.getElementById('lcAuthOtpError');
            const otpPhoneLabel = document.getElementById('lcAuthOtpPhoneLabel');
            const otpNameGroup = document.getElementById('lcAuthOtpNameGroup');
            const otpNameInput = document.getElementById('lcAuthOtpNameInput');
            const verifyOtpBtn = document.getElementById('lcAuthVerifyOtpBtn');
            const backToPhoneBtn = document.getElementById('lcAuthBackToPhoneBtn');

            const goToSecretBtn = document.getElementById('lcAuthGoToSecretBtn');
            const backToPhoneFromSecretBtn = document.getElementById('lcAuthBackToPhoneFromSecretBtn');
            const secretInput = document.getElementById('lcAuthSecretInput');
            const secretError = document.getElementById('lcAuthSecretError');
            const verifySecretBtn = document.getElementById('lcAuthVerifySecretBtn');

            let currentPhone = '';

            async function postJson(url, body) {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(body)
                });

                return response.json();
            }

            sendOtpBtn?.addEventListener('click', async function () {
                const phone = (phoneInput.value || '').trim();
                phoneError.textContent = '';

                if (!/^0[0-9]{9}$/.test(phone)) {
                    phoneError.textContent = 'Số điện thoại không hợp lệ (VD: 0912345678).';
                    return;
                }

                sendOtpBtn.disabled = true;
                const oldText = sendOtpBtn.innerHTML;
                sendOtpBtn.innerHTML = 'Đang gửi...';

                try {
                    const result = await postJson(SEND_OTP_URL, { phone: phone });

                    if (!result.status) {
                        phoneError.textContent = result.msg || 'Không thể gửi OTP.';
                        return;
                    }

                    currentPhone = phone;
                    otpPhoneLabel.textContent = phone;
                    otpInput.value = '';
                    otpError.textContent = '';
                    otpNameGroup.style.display = result.is_new_customer ? 'block' : 'none';
                    showAuthStep('otp');
                    otpInput.focus();
                } catch (e) {
                    phoneError.textContent = 'Có lỗi xảy ra, vui lòng thử lại.';
                } finally {
                    sendOtpBtn.disabled = false;
                    sendOtpBtn.innerHTML = oldText;
                }
            });

            backToPhoneBtn?.addEventListener('click', function () {
                showAuthStep('phone');
            });

            goToSecretBtn?.addEventListener('click', function () {
                secretError.textContent = '';
                secretInput.value = '';
                showAuthStep('secret');
                secretInput.focus();
            });

            backToPhoneFromSecretBtn?.addEventListener('click', function () {
                showAuthStep('phone');
            });

            secretInput?.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    verifySecretBtn?.click();
                }
            });

            verifySecretBtn?.addEventListener('click', async function () {
                const code = (secretInput.value || '').trim();
                secretError.textContent = '';

                if (!code) {
                    secretError.textContent = 'Vui lòng nhập mã bí mật.';
                    return;
                }

                verifySecretBtn.disabled = true;
                const oldText = verifySecretBtn.innerHTML;
                verifySecretBtn.innerHTML = 'Đang đăng nhập...';

                try {
                    const result = await postJson(SECRET_LOGIN_URL, { code: code });

                    if (!result.status) {
                        secretError.textContent = result.msg || 'Mã bí mật không đúng.';
                        return;
                    }

                    window.location.reload();
                } catch (e) {
                    secretError.textContent = 'Có lỗi xảy ra, vui lòng thử lại.';
                } finally {
                    verifySecretBtn.disabled = false;
                    verifySecretBtn.innerHTML = oldText;
                }
            });

            verifyOtpBtn?.addEventListener('click', async function () {
                const otp = (otpInput.value || '').trim();
                otpError.textContent = '';

                if (!otp) {
                    otpError.textContent = 'Vui lòng nhập mã OTP.';
                    return;
                }

                verifyOtpBtn.disabled = true;
                const oldText = verifyOtpBtn.innerHTML;
                verifyOtpBtn.innerHTML = 'Đang xác thực...';

                try {
                    const result = await postJson(VERIFY_OTP_URL, {
                        phone: currentPhone,
                        otp: otp,
                        name: otpNameInput ? otpNameInput.value : ''
                    });

                    if (!result.status) {
                        otpError.textContent = result.msg || 'Mã OTP không đúng.';
                        return;
                    }

                    window.location.reload();
                } catch (e) {
                    otpError.textContent = 'Có lỗi xảy ra, vui lòng thử lại.';
                } finally {
                    verifyOtpBtn.disabled = false;
                    verifyOtpBtn.innerHTML = oldText;
                }
            });
        })();

        function openMobileMenu() {
            mobileMenu?.classList.add('show');
            document.body.classList.add('lc-menu-open');
        }

        function closeMobileMenu() {
            mobileMenu?.classList.remove('show');
            document.body.classList.remove('lc-menu-open');
        }

        openBtn?.addEventListener('click', openPopup);

        document.querySelector('[data-pa-mobile-user]')?.addEventListener('click', openPopup);
        document.querySelector('[data-pa-mobile-menu]')?.addEventListener('click', openMobileMenu);

        openBtnFromMobile?.addEventListener('click', function () {
            closeMobileMenu();
            setTimeout(openPopup, 180);
        });

        closeBtn?.addEventListener('click', closePopup);
        backdrop?.addEventListener('click', closePopup);

        openMobileMenuBtn?.addEventListener('click', openMobileMenu);
        closeMobileMenuBtn?.addEventListener('click', closeMobileMenu);
        mobileMenuBackdrop?.addEventListener('click', closeMobileMenu);

        document.querySelectorAll('[data-mobile-accordion-header]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const targetId = btn.getAttribute('data-mobile-accordion-header');
                const target = document.getElementById(targetId);

                btn.classList.toggle('active');
                target?.classList.toggle('show');
            });
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closePopup();
                closeMobileMenu();
            }
        });

        @if($errors->has('customer_name') || $errors->has('customer_phone') || $errors->has('customer_email') || session('open_login_popup'))
            openPopup();
        @endif
    })();
</script>
@endonce
