@php
    $sortedBanners = collect($banners ?? [])
        ->sortBy(function ($item) {
            return (int) ($item->sort_order ?? 999999);
        })
        ->values();

    $prescriptionHeroImage = asset('phuonganh/img/prescription-concierge-hero.png');
    $prescriptionUrl = route('website.prescription_request_v1.index');
    $consultUrl = route('website.pharmacist_consult_v1.index');

    $quickActions = [
        [
            'label' => 'Tìm thuốc theo đơn',
            'desc' => 'Gửi toa bệnh viện',
            'icon' => asset('phuonganh/img/ic_1.png'),
            'url' => $prescriptionUrl,
            'tone' => 'prescription',
        ],
        [
            'label' => 'Tư vấn dược sĩ',
            'desc' => 'Hỏi nhanh, dùng đúng',
            'icon' => asset('phuonganh/img/ic_2.png'),
            'url' => $consultUrl,
            'tone' => 'pink',
        ],
        [
            'label' => 'Đơn của tôi',
            'desc' => 'Tra cứu đơn hàng',
            'icon' => asset('phuonganh/img/ic_3.png'),
            'url' => route('website.my-order.index'),
            'tone' => 'green',
        ],
        [
            'label' => 'Đơn thuốc đã mua',
            'desc' => 'Mua lại thuận tiện',
            'icon' => asset('phuonganh/img/ic_4.png'),
            'url' => route('website.purchased_medicine_v1.index'),
            'tone' => 'blue',
        ],
        [
            'label' => 'Nhà thuốc gần bạn',
            'desc' => 'Tìm chi nhánh gần nhất',
            'icon' => asset('phuonganh/img/ic_5.png'),
            'url' => route('website.near-branches'),
            'tone' => 'gold',
        ],
        [
            'label' => 'Tích điểm đổi quà',
            'desc' => 'Ưu đãi thành viên',
            'icon' => asset('phuonganh/img/ic_6.png'),
            'url' => route('website.reward_exchange_v1.index'),
            'tone' => 'violet',
        ],
    ];

    $prescriptionSteps = [
        [
            'step' => '01',
            'title' => 'Chụp ảnh đơn thuốc',
            'desc' => 'Gửi ảnh toa bệnh viện hoặc danh sách thuốc cần mua.',
        ],
        [
            'step' => '02',
            'title' => 'Dược sĩ kiểm tra',
            'desc' => 'Đối chiếu tên thuốc, hàm lượng, tình trạng hàng và lưu ý sử dụng.',
        ],
        [
            'step' => '03',
            'title' => 'Tư vấn & chuẩn bị thuốc',
            'desc' => 'Nhận xác nhận trước khi đến lấy hoặc yêu cầu giao hàng.',
        ],
    ];

    $mobileTabs = [
        [
            'label' => 'Trang chủ',
            'icon' => asset('phuonganh/img/logo-pa.png'),
            'url' => url('/'),
            'active' => true,
        ],
        [
            'label' => 'Theo đơn',
            'icon' => asset('phuonganh/img/ic_1.png'),
            'url' => $prescriptionUrl,
            'active' => false,
        ],
        [
            'label' => 'Tư vấn',
            'icon' => asset('phuonganh/img/ic_2.png'),
            'url' => $consultUrl,
            'active' => false,
        ],
        [
            'label' => 'Đơn hàng',
            'icon' => asset('phuonganh/img/ic_3.png'),
            'url' => route('website.my-order.index'),
            'active' => false,
        ],
    ];
@endphp

<style>
    .pa-luxury-home,
    .pa-luxury-home *,
    .pa-luxury-actions,
    .pa-luxury-actions * {
        box-sizing: border-box;
    }

    .pa-luxury-home {
        --pa-ink: #10243f;
        --pa-muted: #667085;
        --pa-teal: #0f8b7c;
        --pa-teal-dark: #073f45;
        --pa-mint: #dff7ec;
        --pa-gold: #C8A45D;
        --pa-red: #ed1b2f;
        --pa-rose: #f04d8a;
        --pa-cloud: #f4faf8;
        position: relative;
        overflow: hidden;
        padding: 0 0 46px;
        background:
            linear-gradient(180deg, #f8fcfb 0%, #ffffff 54%, #f4faf8 100%);
    }

    .pa-luxury-home::before,
    .pa-luxury-home::after {
        content: "";
        position: absolute;
        pointer-events: none;
        border-radius: 999px;
        filter: blur(2px);
    }

    .pa-luxury-home::before {
        width: 420px;
        height: 420px;
        right: -150px;
        top: 18px;
        background: radial-gradient(circle, rgba(15, 139, 124, .13), transparent 68%);
        animation: paLuxuryFloat 9s ease-in-out infinite;
    }

    .pa-luxury-home::after {
        width: 320px;
        height: 320px;
        left: -110px;
        bottom: 0;
        background: radial-gradient(circle, rgba(200, 164, 93, .10), transparent 70%);
        animation: paLuxuryFloat 11s ease-in-out infinite reverse;
    }

    .pa-luxury-actions {
        position: relative;
        z-index: 3;
        width: min(1320px, calc(100% - 32px));
        margin: 0 auto;
        padding: 22px 0 18px;
    }

    .pa-luxury-actions__list {
        min-height: 96px;
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        overflow: hidden;
        border-radius: 8px;
        background: rgba(255, 255, 255, .86);
        border: 1px solid rgba(207, 228, 230, .95);
        box-shadow: 0 22px 54px rgba(16, 36, 63, .10);
        backdrop-filter: blur(18px);
    }

    .pa-luxury-action {
        position: relative;
        min-width: 0;
        border: 0;
        border-right: 1px solid rgba(207, 228, 230, .92);
        background: transparent;
        color: var(--pa-ink);
        padding: 18px 16px;
        display: grid;
        grid-template-columns: 46px minmax(0, 1fr);
        gap: 13px;
        align-items: center;
        text-align: left;
        cursor: pointer;
        font-family: inherit;
        transition: transform .22s ease, background .22s ease;
    }

    .pa-luxury-action:last-child {
        border-right: 0;
    }

    .pa-luxury-action::before {
        content: "";
        position: absolute;
        inset: 0;
        opacity: 0;
        background: linear-gradient(135deg, rgba(24, 183, 179, .11), rgba(255,255,255,.55));
        transition: opacity .22s ease;
    }

    .pa-luxury-action:hover {
        transform: translateY(-2px);
    }

    .pa-luxury-action:hover::before {
        opacity: 1;
    }

    .pa-luxury-action__icon {
        position: relative;
        z-index: 1;
        width: 44px;
        height: 44px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--tone, #18b7b3);
        box-shadow: 0 14px 28px rgba(16, 36, 63, .12);
    }

    .pa-luxury-action[data-tone="pink"] { --tone: #f04d8a; }
    .pa-luxury-action[data-tone="prescription"] { --tone: var(--pa-red); }
    .pa-luxury-action[data-tone="green"] { --tone: #77bf3d; }
    .pa-luxury-action[data-tone="blue"] { --tone: #4aa7f0; }
    .pa-luxury-action[data-tone="gold"] { --tone: #C8A45D; }
    .pa-luxury-action[data-tone="violet"] { --tone: #8d6cf2; }

    .pa-luxury-action__icon img {
        width: 27px;
        height: 27px;
        object-fit: contain;
        filter: brightness(0) invert(1);
    }

    .pa-luxury-action__body {
        position: relative;
        z-index: 1;
        min-width: 0;
    }

    .pa-luxury-action__label {
        color: var(--pa-ink);
        font-size: 15px;
        line-height: 1.25;
        font-weight: 850;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pa-luxury-action__desc {
        margin-top: 4px;
        color: #78849a;
        font-size: 13px;
        line-height: 1.35;
    }

    .pa-luxury-hero {
        position: relative;
        z-index: 2;
        width: min(1320px, calc(100% - 32px));
        min-height: 500px;
        margin: 0 auto;
        border-radius: 8px;
        overflow: hidden;
        display: grid;
        grid-template-columns: minmax(0, .98fr) minmax(420px, 1.02fr);
        align-items: stretch;
        background:
            linear-gradient(125deg, #073f45 0%, #0b6669 54%, #0f8b7c 100%);
        box-shadow: 0 30px 80px rgba(16, 36, 63, .16);
        isolation: isolate;
    }

    .pa-luxury-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: -1;
        background:
            linear-gradient(115deg, rgba(255,255,255,.14), transparent 32%, rgba(255,255,255,.18) 62%, transparent),
            repeating-linear-gradient(115deg, rgba(255,255,255,.06) 0 1px, transparent 1px 18px);
        opacity: .9;
    }

    .pa-luxury-hero::after {
        content: "";
        position: absolute;
        inset: -60% auto auto -40%;
        width: 55%;
        height: 220%;
        transform: rotate(24deg);
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.26), transparent);
        animation: paLuxuryShine 6.8s ease-in-out infinite;
    }

    .pa-luxury-hero__copy {
        min-width: 0;
        padding: 48px 56px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: #fff;
    }

    .pa-luxury-hero__eyebrow {
        width: fit-content;
        min-height: 34px;
        padding: 0 14px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,.17);
        border: 1px solid rgba(255,255,255,.22);
        color: #ffffff;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
        backdrop-filter: blur(12px);
    }

    .pa-luxury-hero__eyebrow::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: var(--pa-gold);
        box-shadow: 0 0 20px rgba(200, 164, 93, .52);
    }

    .pa-luxury-hero__title {
        margin: 20px 0 0;
        max-width: 620px;
        color: #ffffff;
        font-size: clamp(36px, 4vw, 54px);
        line-height: 1.02;
        font-weight: 950;
        letter-spacing: 0;
        text-shadow: 0 18px 42px rgba(5, 67, 72, .18);
    }

    .pa-luxury-hero__desc {
        margin: 18px 0 0;
        max-width: 560px;
        color: rgba(255,255,255,.88);
        font-size: 16px;
        line-height: 1.68;
    }

    .pa-luxury-hero__actions {
        margin-top: 28px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pa-luxury-hero__btn {
        min-height: 48px;
        padding: 0 22px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        color: #ffffff;
        font-size: 14px;
        font-weight: 900;
        text-decoration: none;
        transition: transform .22s ease, box-shadow .22s ease, background .22s ease;
    }

    .pa-luxury-hero__btn--primary {
        background: #ffffff;
        color: var(--pa-teal-dark);
        box-shadow: 0 18px 42px rgba(3, 40, 44, .20);
    }

    .pa-luxury-hero__btn--secondary {
        background: rgba(255,255,255,.11);
        border: 1px solid rgba(255,255,255,.24);
        color: #ffffff;
        backdrop-filter: blur(12px);
    }

    .pa-luxury-hero__btn:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }

    .pa-luxury-hero__btn--primary:hover {
        color: var(--pa-teal-dark);
        box-shadow: 0 22px 48px rgba(3, 40, 44, .26);
    }

    .pa-luxury-hero__btn--secondary:hover {
        background: rgba(255,255,255,.18);
        color: #ffffff;
    }

    .pa-title-mobile,
    .pa-cta-mobile,
    .pa-meta-mobile {
        display: none;
    }

    .pa-luxury-hero__search {
        width: min(100%, 610px);
        margin-top: 28px;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 8px;
        padding: 8px;
        border-radius: 999px;
        background: #ffffff;
        box-shadow: 0 20px 48px rgba(16, 36, 63, .18);
    }

    .pa-luxury-hero__search input {
        min-width: 0;
        min-height: 46px;
        border: 0;
        outline: 0;
        padding: 0 18px;
        background: transparent;
        color: #1d2b44;
        font-size: 15px;
    }

    .pa-luxury-hero__search button {
        min-height: 46px;
        border: 0;
        border-radius: 999px;
        padding: 0 22px;
        background: #10243f;
        color: #ffffff;
        font-size: 14px;
        font-weight: 900;
        cursor: pointer;
        box-shadow: 0 12px 26px rgba(16, 36, 63, .18);
        transition: transform .22s ease, background .22s ease;
    }

    .pa-luxury-hero__search button:hover {
        transform: translateY(-1px);
        background: #04162b;
    }

    .pa-luxury-hero__meta {
        margin-top: 28px;
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }

    .pa-luxury-hero__meta-item {
        min-height: 52px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #ffffff;
        font-size: 14px;
        font-weight: 800;
    }

    .pa-luxury-hero__meta-icon {
        width: 46px;
        height: 46px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,.94);
        color: var(--pa-teal-dark);
        font-size: 20px;
        box-shadow: 0 14px 30px rgba(16, 36, 63, .13);
    }

    .pa-luxury-hero__visual {
        min-width: 0;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 36px 42px 36px 8px;
    }

    .pa-luxury-hero__visual::before {
        content: "";
        position: absolute;
        width: 72%;
        aspect-ratio: 1;
        border-radius: 999px;
        background: rgba(255,255,255,.18);
        border: 1px solid rgba(255,255,255,.22);
        box-shadow: inset 0 0 70px rgba(255,255,255,.16);
        animation: paLuxuryPulse 4.8s ease-in-out infinite;
    }

    .pa-luxury-slider {
        position: relative;
        width: min(100%, 650px);
        aspect-ratio: 1.36 / 1;
        overflow: hidden;
        border-radius: 8px;
        background: rgba(255, 255, 255, .82);
        border: 1px solid rgba(255,255,255,.62);
        box-shadow: 0 30px 76px rgba(16, 36, 63, .24);
        backdrop-filter: blur(18px);
        transform: translateZ(0);
    }

    .pa-luxury-slider__track {
        display: flex;
        height: 100%;
        transition: transform .75s cubic-bezier(.22, 1, .36, 1);
        will-change: transform;
    }

    .pa-luxury-slider__slide {
        position: relative;
        flex: 0 0 100%;
        height: 100%;
        background: #edfafa;
    }

    .pa-luxury-slider__link,
    .pa-luxury-slider__image {
        display: block;
        width: 100%;
        height: 100%;
    }

    .pa-luxury-slider__image {
        object-fit: cover;
        object-position: center;
        transform: scale(1.055);
        transition: transform 6s ease, filter .5s ease;
        filter: saturate(1.04) contrast(1.02);
    }

    .pa-luxury-slider__slide.is-active .pa-luxury-slider__image {
        transform: scale(1);
    }

    .pa-luxury-slider__empty {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--pa-teal-dark);
        font-weight: 900;
    }

    .pa-luxury-slider__dots {
        position: absolute;
        left: 22px;
        bottom: 20px;
        z-index: 2;
        display: inline-flex;
        gap: 8px;
        padding: 8px 10px;
        border-radius: 999px;
        background: rgba(255,255,255,.82);
        backdrop-filter: blur(12px);
        box-shadow: 0 10px 24px rgba(16, 36, 63, .12);
    }

    .pa-luxury-slider__dot {
        width: 9px;
        height: 9px;
        border: 0;
        padding: 0;
        border-radius: 999px;
        background: #abc4c5;
        cursor: pointer;
        transition: width .22s ease, background .22s ease;
    }

    .pa-luxury-slider__dot.is-active {
        width: 28px;
        background: var(--pa-teal);
    }

    .pa-luxury-slider__badge {
        position: absolute;
        right: 18px;
        top: 18px;
        z-index: 2;
        min-height: 38px;
        padding: 0 14px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(16, 36, 63, .88);
        color: #ffffff;
        font-size: 12px;
        font-weight: 850;
        box-shadow: 0 16px 30px rgba(16, 36, 63, .18);
    }

    .pa-luxury-slider__badge::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: var(--pa-gold);
    }

    .pa-prescription-visual {
        position: relative;
        width: min(100%, 640px);
        border-radius: 8px;
        overflow: hidden;
        background: rgba(255, 255, 255, .84);
        border: 1px solid rgba(255,255,255,.62);
        box-shadow: 0 30px 76px rgba(16, 36, 63, .24);
        backdrop-filter: blur(18px);
    }

    .pa-prescription-visual__image {
        display: block;
        width: 100%;
        aspect-ratio: 16 / 9;
        object-fit: cover;
        object-position: center;
        filter: saturate(1.02) contrast(1.01);
    }

    .pa-prescription-visual__card {
        position: relative;
        width: 100%;
        padding: 16px 18px 18px;
        border-radius: 0;
        background: rgba(255,255,255,.92);
        border-top: 1px solid rgba(9, 47, 48, .10);
        box-shadow: none;
        backdrop-filter: blur(14px);
    }

    .pa-prescription-visual__status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--pa-teal-dark);
        font-size: 12px;
        line-height: 1.3;
        font-weight: 900;
    }

    .pa-prescription-visual__status::before {
        content: "";
        width: 9px;
        height: 9px;
        border-radius: 999px;
        background: var(--pa-gold);
        box-shadow: 0 0 0 4px rgba(200, 164, 93, .14);
    }

    .pa-prescription-visual__title {
        margin-top: 8px;
        color: var(--pa-ink);
        font-size: 18px;
        line-height: 1.25;
        font-weight: 950;
    }

    .pa-prescription-visual__text {
        margin-top: 6px;
        color: #5e6f76;
        font-size: 13px;
        line-height: 1.55;
    }

    .pa-prescription-service {
        position: relative;
        z-index: 2;
        width: min(1320px, calc(100% - 32px));
        margin: 22px auto 0;
        padding: 26px;
        border-radius: 8px;
        background:
            linear-gradient(180deg, rgba(255,255,255,.96) 0%, rgba(244,250,248,.94) 100%);
        border: 1px solid rgba(9, 47, 48, .10);
        box-shadow: 0 22px 58px rgba(9, 47, 48, .08);
        display: grid;
        grid-template-columns: minmax(0, .88fr) minmax(0, 1.12fr);
        gap: 24px;
        align-items: center;
    }

    .pa-prescription-service__eyebrow {
        width: fit-content;
        min-height: 30px;
        padding: 0 12px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(15, 139, 124, .08);
        border: 1px solid rgba(15, 139, 124, .14);
        color: var(--pa-teal-dark);
        font-size: 12px;
        font-weight: 900;
    }

    .pa-prescription-service__eyebrow::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 999px;
        background: var(--pa-gold);
    }

    .pa-prescription-service__title {
        margin: 14px 0 0;
        max-width: 560px;
        color: var(--pa-ink);
        font-size: clamp(26px, 2.7vw, 40px);
        line-height: 1.16;
        font-weight: 950;
    }

    .pa-prescription-service__desc {
        margin: 12px 0 0;
        max-width: 620px;
        color: #5e6f76;
        font-size: 15px;
        line-height: 1.75;
    }

    .pa-prescription-service__note {
        margin-top: 18px;
        padding-left: 14px;
        border-left: 3px solid var(--pa-gold);
        color: #53676f;
        font-size: 13px;
        line-height: 1.6;
    }

    .pa-prescription-service__steps {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .pa-prescription-step {
        min-height: 176px;
        padding: 18px;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid rgba(9, 47, 48, .10);
        box-shadow: 0 14px 32px rgba(9, 47, 48, .06);
    }

    .pa-prescription-step__number {
        width: 42px;
        height: 42px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(15, 139, 124, .10);
        color: var(--pa-teal-dark);
        font-size: 13px;
        font-weight: 950;
        box-shadow: inset 0 0 0 1px rgba(15, 139, 124, .12);
    }

    .pa-prescription-step__title {
        margin-top: 16px;
        color: var(--pa-ink);
        font-size: 16px;
        line-height: 1.35;
        font-weight: 950;
    }

    .pa-prescription-step__desc {
        margin-top: 8px;
        color: #66767d;
        font-size: 13px;
        line-height: 1.6;
    }

    .pa-mobile-tabbar {
        display: none;
    }

    .pa-prescription-service__toggle {
        display: none;
    }

    @keyframes paLuxuryShine {
        0%, 46% { transform: translateX(-28%) rotate(24deg); opacity: 0; }
        56% { opacity: .9; }
        100% { transform: translateX(260%) rotate(24deg); opacity: 0; }
    }

    @keyframes paLuxuryFloat {
        0%, 100% { transform: translate3d(0, 0, 0); }
        50% { transform: translate3d(16px, -18px, 0); }
    }

    @keyframes paLuxuryPulse {
        0%, 100% { transform: scale(1); opacity: .9; }
        50% { transform: scale(1.08); opacity: .68; }
    }

    @media (max-width: 1100px) {
        .pa-luxury-actions__list {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .pa-luxury-action:nth-child(3n) {
            border-right: 0;
        }

        .pa-luxury-hero {
            grid-template-columns: 1fr;
        }

        .pa-prescription-service {
            grid-template-columns: 1fr;
        }

        .pa-prescription-service__steps {
            grid-template-columns: 1fr;
        }

        .pa-luxury-hero__copy {
            padding-bottom: 18px;
        }

        .pa-luxury-hero__visual {
            padding: 18px 42px 46px;
        }
    }

    @media (max-width: 767px) {
        body {
            padding-bottom: calc(84px + env(safe-area-inset-bottom, 0px)) !important;
        }

        .pa-luxury-home {
            padding-bottom: 18px;
            background: #f5faf8;
        }

        .pa-luxury-actions,
        .pa-luxury-hero {
            width: calc(100vw - 20px);
            max-width: calc(100vw - 20px);
        }

        .pa-luxury-actions {
            padding: 0 0 8px;
            margin-top: 0;
        }

        .pa-luxury-actions__list {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            min-height: 0;
            gap: 8px;
            padding: 10px;
            border-radius: 20px;
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(9,47,48,.08);
            box-shadow: 0 16px 34px rgba(9,47,48,.08);
        }

        .pa-luxury-action,
        .pa-luxury-action:nth-child(3n) {
            min-height: 78px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 7px;
            padding: 10px 6px;
            border: 0;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: inset 0 0 0 1px rgba(9,47,48,.06);
            text-align: center;
        }

        .pa-luxury-action__icon {
            width: 40px;
            height: 40px;
            margin: 0 auto;
            box-shadow: 0 10px 22px rgba(16,36,63,.10);
        }

        .pa-luxury-action__icon img {
            width: 23px;
            height: 23px;
        }

        .pa-luxury-action__body {
            width: 100%;
        }

        .pa-luxury-action__label {
            min-height: 28px;
            color: #10243f;
            font-size: 11px;
            line-height: 1.25;
            font-weight: 900;
            white-space: normal;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .pa-luxury-action__desc {
            display: none;
        }

        .pa-luxury-hero {
            min-height: 0;
            border-radius: 22px;
            box-shadow: 0 18px 42px rgba(9,47,48,.13);
        }

        .pa-luxury-hero__copy {
            padding: 16px 16px 6px;
        }

        .pa-luxury-hero__eyebrow {
            min-height: 28px;
            padding: 0 10px;
            font-size: 10px;
        }

        .pa-luxury-hero__title {
            margin-top: 10px;
            font-size: 24px;
            line-height: 1.08;
            overflow-wrap: anywhere;
        }

        .pa-title-desktop,
        .pa-cta-desktop {
            display: none;
        }

        .pa-title-mobile,
        .pa-cta-mobile,
        .pa-meta-mobile {
            display: inline;
        }

        .pa-meta-desktop {
            display: none;
        }

        .pa-luxury-hero__desc {
            display: none;
        }

        .pa-luxury-hero__search {
            display: none;
        }

        .pa-luxury-hero__actions {
            display: grid;
            grid-template-columns: minmax(0, .82fr) minmax(0, 1.18fr);
            margin-top: 12px;
            gap: 8px;
        }

        .pa-luxury-hero__btn {
            width: 100%;
            min-height: 38px;
            padding: 0 8px;
            font-size: 11.5px;
            line-height: 1.15;
            white-space: nowrap;
        }

        .pa-luxury-hero__search button {
            border-radius: 14px;
            min-height: 42px;
        }

        .pa-luxury-hero__meta {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 8px;
            margin-top: 9px;
        }

        .pa-luxury-hero__meta-item {
            min-height: 24px;
            gap: 6px;
            font-size: 10px;
            line-height: 1.15;
            font-weight: 800;
            white-space: nowrap;
        }

        .pa-luxury-hero__meta-icon {
            width: 24px;
            height: 24px;
            min-width: 24px;
            font-size: 12px;
        }

        .pa-luxury-hero__visual {
            padding: 6px 12px 10px;
        }

        .pa-prescription-visual__image {
            aspect-ratio: 2.15 / 1;
            max-height: 126px;
            object-position: center 24%;
        }

        .pa-luxury-slider {
            width: 100%;
            aspect-ratio: 1.28 / 1;
        }

        .pa-luxury-slider__badge {
            display: none;
        }

        .pa-prescription-visual__card {
            display: none;
        }

        .pa-prescription-visual__title {
            font-size: 15px;
        }

        .pa-prescription-visual__text {
            font-size: 12px;
        }

        .pa-prescription-service {
            display: none !important;
        }

        .pa-prescription-service__title {
            font-size: 22px;
            line-height: 1.2;
        }

        .pa-prescription-service__desc {
            font-size: 13px;
            line-height: 1.62;
        }

        .pa-prescription-service__steps {
            gap: 10px;
        }

        .pa-prescription-service__toggle {
            width: 100%;
            min-height: 42px;
            margin-top: 14px;
            border: 1px solid rgba(15,139,124,.16);
            border-radius: 999px;
            background: rgba(15,139,124,.08);
            color: #073f45;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 900;
        }

        .pa-prescription-service__toggle::after {
            content: "↓";
            font-size: 14px;
            line-height: 1;
        }

        .pa-prescription-service.is-open .pa-prescription-service__toggle::after {
            content: "↑";
        }

        .pa-prescription-service__steps {
            display: none;
        }

        .pa-prescription-service.is-open .pa-prescription-service__steps {
            display: grid;
        }

        .pa-prescription-step {
            min-height: 0;
            padding: 14px;
            border-radius: 16px;
        }

        .pa-prescription-step__number {
            width: 34px;
            height: 34px;
        }

        .pa-prescription-step__title {
            margin-top: 10px;
            font-size: 14px;
        }

        .pa-prescription-step__desc {
            font-size: 12px;
        }

        .pa-mobile-tabbar {
            position: fixed;
            left: 10px;
            right: 10px;
            bottom: max(10px, env(safe-area-inset-bottom, 10px));
            z-index: 999;
            width: auto;
            max-width: none;
            min-height: 66px;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 4px;
            padding: 8px 8px 9px;
            box-sizing: border-box;
            transform: none;
            border-radius: 24px;
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(9,47,48,.10);
            box-shadow: 0 18px 48px rgba(6, 47, 51, .22);
            backdrop-filter: blur(18px);
        }

        .pa-mobile-tabbar * {
            box-sizing: border-box;
        }

        .pa-mobile-tabbar__item {
            min-width: 0;
            max-width: 100%;
            min-height: 48px;
            border-radius: 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            color: #65757b;
            text-decoration: none;
            font-size: 10px;
            line-height: 1.1;
            font-weight: 850;
            overflow: hidden;
        }

        .pa-mobile-tabbar__item.is-active {
            background: rgba(15,139,124,.10);
            color: #073f45;
        }

        .pa-mobile-tabbar__icon {
            width: 23px;
            height: 23px;
            border-radius: 8px;
            object-fit: contain;
        }

        .pa-mobile-tabbar__item:not(.is-active) .pa-mobile-tabbar__icon {
            filter: saturate(.86);
        }
    }

    @media (max-width: 380px) {
        .pa-mobile-tabbar {
            left: 8px;
            right: 8px;
            width: auto;
        }
    }

    @media (max-width: 600px) {
        .pa-luxury-actions,
        .pa-luxury-hero,
        .pa-prescription-service {
            width: calc(100vw - 20px) !important;
            max-width: calc(100vw - 20px) !important;
            margin-left: 10px !important;
            margin-right: 10px !important;
        }

        .pa-luxury-actions__list,
        .pa-luxury-hero {
            overflow: hidden;
        }

        .pa-luxury-hero__copy,
        .pa-luxury-hero__visual,
        .pa-luxury-hero__search,
        .pa-luxury-slider,
        .pa-prescription-visual {
            width: 100%;
            max-width: 100%;
            min-width: 0;
        }

        .pa-luxury-hero__title {
            font-size: 24px;
        }

        .pa-luxury-hero__meta {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        }

        .pa-luxury-hero__meta-item {
            min-width: 0;
        }
    }
</style>

<section class="pa-luxury-home" aria-label="Trang chủ Nhà thuốc Phương Anh">
    <div class="pa-luxury-actions" aria-label="Lối tắt dịch vụ">
        <div class="pa-luxury-actions__list">
            @foreach($quickActions as $action)
                <button
                    type="button"
                    class="pa-luxury-action"
                    data-tone="{{ $action['tone'] }}"
                    onclick="window.location.href='{{ $action['url'] }}'"
                >
                    <span class="pa-luxury-action__icon">
                        <img src="{{ $action['icon'] }}" alt="">
                    </span>
                    <span class="pa-luxury-action__body">
                        <span class="pa-luxury-action__label">{{ $action['label'] }}</span>
                        <span class="pa-luxury-action__desc">{{ $action['desc'] }}</span>
                    </span>
                </button>
            @endforeach
        </div>
    </div>

    <div class="pa-luxury-hero">
        <div class="pa-luxury-hero__copy">
            <div class="pa-luxury-hero__eyebrow">Dịch vụ hỗ trợ theo đơn</div>

            <h1 class="pa-luxury-hero__title">
                <span class="pa-title-desktop">Tìm thuốc theo đơn bệnh viện, có dược sĩ tư vấn</span>
                <span class="pa-title-mobile">Tìm thuốc bằng ảnh kê đơn</span>
            </h1>

            <p class="pa-luxury-hero__desc">
                Chụp ảnh đơn thuốc, gửi cho Nhà thuốc Phương Anh. Dược sĩ hỗ trợ kiểm tra thuốc, tư vấn cách dùng và chuẩn bị trước khi bạn đến mua hoặc nhận giao hàng.
            </p>

            <div class="pa-luxury-hero__actions">
                <a href="{{ $prescriptionUrl }}" class="pa-luxury-hero__btn pa-luxury-hero__btn--primary">
                    <span class="pa-cta-desktop">Gửi đơn thuốc ngay</span>
                    <span class="pa-cta-mobile">Gửi đơn thuốc</span>
                </a>
                <a href="{{ $consultUrl }}" class="pa-luxury-hero__btn pa-luxury-hero__btn--secondary">
                    <span class="pa-cta-desktop">Tư vấn với dược sĩ</span>
                    <span class="pa-cta-mobile">Trao đổi với dược sĩ</span>
                </a>
            </div>

            <form method="GET" action="{{ route('website.search.index') }}" class="pa-luxury-hero__search">
                <input type="search" name="q" placeholder="Tìm thuốc, thực phẩm chức năng, thiết bị y tế..." aria-label="Tìm kiếm sản phẩm">
                <button type="submit">Tìm thuốc nhanh</button>
            </form>

            <div class="pa-luxury-hero__meta">
                <div class="pa-luxury-hero__meta-item">
                    <span class="pa-luxury-hero__meta-icon">✓</span>
                    <span class="pa-meta-desktop">Bảo mật thông tin đơn thuốc</span>
                    <span class="pa-meta-mobile">Bảo mật đơn thuốc</span>
                </div>
                <div class="pa-luxury-hero__meta-item">
                    <span class="pa-luxury-hero__meta-icon">✦</span>
                    <span class="pa-meta-desktop">Dược sĩ trực tiếp kiểm tra</span>
                    <span class="pa-meta-mobile">Dược sĩ kiểm tra</span>
                </div>
            </div>
        </div>

        <div class="pa-luxury-hero__visual">
            <div class="pa-prescription-visual">
                <img
                    src="{{ $prescriptionHeroImage }}"
                    alt="Dược sĩ Nhà thuốc Phương Anh tư vấn đơn thuốc qua điện thoại"
                    class="pa-prescription-visual__image"
                    loading="eager"
                    decoding="async"
                >
                <div class="pa-prescription-visual__card">
                    <div class="pa-prescription-visual__status">Đơn thuốc đã được tiếp nhận</div>
                    <div class="pa-prescription-visual__title">Dược sĩ kiểm tra trước khi báo thuốc</div>
                    <div class="pa-prescription-visual__text">
                        Phù hợp với khách vừa khám bệnh viện, cần mua đúng thuốc và hỏi kỹ cách dùng.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pa-prescription-service">
        <div class="pa-prescription-service__copy">
            <div class="pa-prescription-service__eyebrow">Tìm thuốc theo đơn</div>
            <h2 class="pa-prescription-service__title">Giảm bớt lo lắng sau khi nhận đơn từ bệnh viện</h2>
            <p class="pa-prescription-service__desc">
                Khách hàng không cần tự dò từng tên thuốc hoặc gọi hỏi nhiều nơi. Gửi đơn để dược sĩ Phương Anh hỗ trợ kiểm tra, xác nhận thuốc phù hợp và hướng dẫn các lưu ý quan trọng trước khi mua.
            </p>
            <div class="pa-prescription-service__note">
                Thông tin đơn thuốc chỉ dùng cho mục đích tư vấn và chuẩn bị thuốc cho khách hàng.
            </div>
            <button type="button" class="pa-prescription-service__toggle" data-prescription-guide-toggle>
                Xem hướng dẫn 3 bước
            </button>
        </div>

        <div class="pa-prescription-service__steps">
            @foreach($prescriptionSteps as $item)
                <article class="pa-prescription-step">
                    <div class="pa-prescription-step__number">{{ $item['step'] }}</div>
                    <h3 class="pa-prescription-step__title">{{ $item['title'] }}</h3>
                    <p class="pa-prescription-step__desc">{{ $item['desc'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<nav class="pa-mobile-tabbar" aria-label="Điều hướng nhanh trên mobile">
    @foreach($mobileTabs as $tab)
        <a href="{{ $tab['url'] }}" class="pa-mobile-tabbar__item {{ $tab['active'] ? 'is-active' : '' }}">
            <img src="{{ $tab['icon'] }}" alt="" class="pa-mobile-tabbar__icon">
            <span>{{ $tab['label'] }}</span>
        </a>
    @endforeach
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const guideSection = document.querySelector('.pa-prescription-service');
    const guideToggle = document.querySelector('[data-prescription-guide-toggle]');

    if (guideSection && guideToggle) {
        guideToggle.addEventListener('click', function () {
            const opened = guideSection.classList.toggle('is-open');
            guideToggle.textContent = opened ? 'Ẩn hướng dẫn 3 bước' : 'Xem hướng dẫn 3 bước';
        });
    }

    const slider = document.getElementById('paLuxuryHeroSlider');
    const track = document.getElementById('paLuxuryHeroTrack');

    if (!slider || !track) return;

    const slides = Array.from(track.querySelectorAll('.pa-luxury-slider__slide'));
    const total = slides.length;
    if (total <= 1) return;

    const dots = Array.from(document.querySelectorAll('#paLuxuryHeroDots .pa-luxury-slider__dot'));
    let currentIndex = 0;
    let autoTimer = null;
    const autoDelay = 5600;

    function goTo(index) {
        currentIndex = (index + total) % total;
        track.style.transform = 'translate3d(-' + (currentIndex * 100) + '%, 0, 0)';

        slides.forEach(function (slide, i) {
            slide.classList.toggle('is-active', i === currentIndex);
        });

        dots.forEach(function (dot, i) {
            dot.classList.toggle('is-active', i === currentIndex);
        });
    }

    function startAutoPlay() {
        if (autoTimer) clearInterval(autoTimer);
        autoTimer = setInterval(function () {
            goTo(currentIndex + 1);
        }, autoDelay);
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            const index = Number(this.getAttribute('data-slide'));
            if (!Number.isNaN(index)) {
                goTo(index);
                startAutoPlay();
            }
        });
    });

    slider.addEventListener('mouseenter', function () {
        if (autoTimer) clearInterval(autoTimer);
    });

    slider.addEventListener('mouseleave', startAutoPlay);

    goTo(0);
    startAutoPlay();
});
</script>
