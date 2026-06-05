@php
    $guestCheckoutInfo = session('guest_checkout_info', []);
    $guestDisplayName = $guestCheckoutInfo['customer_name'] ?? '';
@endphp
<header class="lc-header">
        <div class="lc-header-hero">
            <div class="lc-container">
                <!-- Top bar -->
                <div class="lc-header-top">
                    <div class="lc-header-top-left">
                        <span class="lc-header-top-left-icon"></span>
                        <a href="#" class="lc-header-top-link">
                            <span>NTPA - Dược phẩm Phương Anh</span>
                            <strong>Tìm hiểu ngay</strong>
                        </a>
                    </div>
                    <div class="lc-header-top-right">
                        <a href="#" class="lc-header-top-link">
                            <span>📱</span>
                            <span>Tải ứng dụng</span>
                        </a>
                        <span class="lc-header-top-sep">|</span>
                        <a href="tel:18006928" class="lc-header-top-link">
                            <span>📞</span>
                            <span>Tư vấn ngay: <strong>085 884 5845</strong></span>
                        </a>
                    </div>
                </div>

                <!-- Middle bar -->
                <div class="lc-header-main">
                    <!-- Logo -->
                    <a href="#" class="lc-logo">
                        <div class="lc-logo-mark">
                            <img style=" width: 56px; " src="phuonganh/img/lg.png" alt="Dược Phương Anh" />
                        </div>
                        <div class="lc-logo-text">
                            <span>Dược - Y tế</span>
                            <strong>NHÀ THUỐC<br />PHƯƠNG ANH</strong>
                        </div>
                    </a>

                    <!-- Search -->
                    <div class="lc-search-wrap">
                        <form method="GET" action="{{ route('website.search.index') }}" class="lc-search-bar">
                            <div class="lc-search-input-wrap">
                                <button type="submit" class="lc-search-submit-btn" aria-label="Tìm kiếm">
                                </button>

                                <input
                                    type="text"
                                    name="q"
                                    class="lc-search-input"
                                    placeholder="Tìm thuốc, thực phẩm chức năng, thiết bị y tế..."
                                    value="{{ request('q') }}"
                                    autocomplete="off"
                                />
                            </div>

                            <div class="lc-search-actions">
                                <button class="lc-icon-btn" type="button" aria-label="Tìm bằng giọng nói">
                                    🎙
                                </button>
                                <button class="lc-icon-btn" type="button" aria-label="Tìm bằng hình ảnh">
                                    📷
                                </button>
                            </div>
                        </form>
                        <div class="lc-search-suggestions">
                            @forelse($headerSearchKeywords ?? [] as $keyword)
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

                    <!-- User actions -->
                    <div class="lc-header-actions">
                        <button type="button" class="lc-link-user" id="lcOpenGuestPopupHome">
                            <span class="lc-link-user-icon">👤</span>
                            <span>
                                {{ $guestDisplayName ? \Illuminate\Support\Str::limit($guestDisplayName, 18) : 'Đăng nhập' }}
                            </span>
                        </button>

                        <a href="{{ route('website.cart.index') }}" class="lc-btn-cart">
                            <span class="lc-btn-cart-icon">🛒</span>
                            <span style=" color: #0c585c; ">Giỏ hàng</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh mục tổng -->
        <div class="lc-header-nav">
            <div class="lc-container">
                <nav class="lc-header-nav-inner">
                    @foreach($listMainCategory as $item)
                        <a href="{{ route('website.main-category-v1.show', ['id' => $item->id]) }}"
                        class="lc-nav-item lc-nav-item--has-dropdown">
                            <span>{{ $item->name }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>
    </header>
    <div class="lc-guest-popup" id="lcGuestPopupHome">
    <div class="lc-guest-popup-backdrop" id="lcGuestPopupBackdropHome"></div>

    <div class="lc-guest-popup-dialog">
        <button type="button" class="lc-guest-popup-close" id="lcCloseGuestPopupHome">×</button>

        <div class="lc-guest-popup-head">
            <h3>Thông tin khách hàng</h3>
            <p>Lưu nhanh thông tin để đặt hàng thuận tiện hơn ở các bước tiếp theo.</p>
        </div>

        <form method="POST" action="{{ route('website.guest-customer.store') }}" class="lc-guest-form">
            @csrf

            <div class="lc-guest-form-grid">
                <div class="lc-guest-form-group">
                    <label>Họ và tên *</label>
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
                    <label>Số điện thoại *</label>
                    <input
                        type="text"
                        name="customer_phone"
                        value="{{ old('customer_phone', $guestCheckoutInfo['customer_phone'] ?? '') }}"
                        placeholder="Nhập số điện thoại"
                    >
                    @error('customer_phone')
                        <div class="lc-guest-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="lc-guest-form-group full">
                    <label>Email</label>
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
                    <label>Tỉnh / Thành</label>
                    <input
                        type="text"
                        name="province_name"
                        value="{{ old('province_name', $guestCheckoutInfo['province_name'] ?? 'Cao Bằng') }}"
                        placeholder="Tỉnh / thành"
                    >
                </div>

                <div class="lc-guest-form-group">
                    <label>Quận / Huyện</label>
                    <input
                        type="text"
                        name="district_name"
                        value="{{ old('district_name', $guestCheckoutInfo['district_name'] ?? '') }}"
                        placeholder="Quận / huyện"
                    >
                </div>

                <div class="lc-guest-form-group">
                    <label>Phường / Xã</label>
                    <input
                        type="text"
                        name="ward_name"
                        value="{{ old('ward_name', $guestCheckoutInfo['ward_name'] ?? '') }}"
                        placeholder="Phường / xã"
                    >
                </div>

                <div class="lc-guest-form-group full">
                    <label>Địa chỉ chi tiết</label>
                    <textarea
                        name="address_detail"
                        placeholder="Số nhà, xóm, tổ dân phố..."
                    >{{ old('address_detail', $guestCheckoutInfo['address_detail'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="lc-guest-popup-actions">
                <button type="submit" class="lc-guest-btn lc-guest-btn-primary">
                    Lưu thông tin
                </button>
            </div>
        </form>

        @if(!empty($guestCheckoutInfo))
            <form method="POST" action="{{ route('website.guest-customer.clear') }}" style="margin-top:12px;">
                @csrf
                <button type="submit" class="lc-guest-btn lc-guest-btn-light" style="width:100%;">
                    Xóa thông tin đã lưu
                </button>
            </form>
        @endif
    </div>
</div>

@once
<style>
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

    .lc-header-actions .lc-btn-cart{
        text-decoration: none;
        color: inherit;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .lc-header-actions .lc-btn-cart:hover,
    .lc-header-actions .lc-link-user:hover{
        text-decoration: none;
        opacity: .92;
    }

    .lc-guest-popup{
        position: fixed;
        inset: 0;
        z-index: 9999;
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
        font-size: 24px;
        cursor: pointer;
    }

    .lc-guest-popup-head{
        margin-bottom: 18px;
    }

    .lc-guest-popup-head h3{
        margin: 0 0 8px;
        font-size: 28px;
        font-weight: 900;
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
        font-weight: 800;
        color: #0f172a;
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
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
    }

    .lc-guest-error{
        font-size: 13px;
        color: #dc2626;
        font-weight: 700;
    }

    .lc-guest-popup-actions{
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        flex-wrap: wrap;
    }

    .lc-guest-btn{
        min-height: 46px;
        padding: 0 18px;
        border-radius: 999px;
        border: 0;
        cursor: pointer;
        font-size: 15px;
        font-weight: 800;
    }

    .lc-guest-btn-primary{
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
        box-shadow: 0 12px 24px rgba(37, 99, 235, .18);
    }

    .lc-guest-btn-light{
        background: #f8fafc;
        color: #334155;
        border: 1px solid #dbe4f0;
    }

    @media (max-width: 767px){
        .lc-guest-popup-dialog{
            width: min(100%, calc(100% - 16px));
            margin: 8px auto;
            border-radius: 18px;
            padding: 18px;
        }

        .lc-guest-popup-head h3{
            font-size: 22px;
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
</style>
@endonce

@once
<script>
    (function () {
        const popup = document.getElementById('lcGuestPopupHome');
        const openBtn = document.getElementById('lcOpenGuestPopupHome');
        const closeBtn = document.getElementById('lcCloseGuestPopupHome');
        const backdrop = document.getElementById('lcGuestPopupBackdropHome');

        function openPopup() {
            popup?.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closePopup() {
            popup?.classList.remove('show');
            document.body.style.overflow = '';
        }

        openBtn?.addEventListener('click', openPopup);
        closeBtn?.addEventListener('click', closePopup);
        backdrop?.addEventListener('click', closePopup);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closePopup();
            }
        });

        @if($errors->has('customer_name') || $errors->has('customer_phone') || $errors->has('customer_email'))
            openPopup();
        @endif
    })();
</script>
@endonce