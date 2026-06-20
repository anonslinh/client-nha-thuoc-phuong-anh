<!DOCTYPE html>
<html lang="vi">

@include('website.home.header')

<body>
    <!-- ========== HEADER ========== -->
    @include('website.home.header-menu')
    <style>
        html,
        body {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        body {
            background: #f3f7fa !important;
            color: #10243f;
        }

        main {
            overflow-x: hidden;
            background:
                linear-gradient(180deg, #f3f7fa 0%, #ffffff 38%, #f8fbfc 100%);
        }

        main .lc-container {
            width: min(1320px, calc(100% - 32px)) !important;
            max-width: 1320px !important;
        }

        main section {
            scroll-margin-top: 96px;
        }

        .lc-flashsale,
        .lc-bestseller,
        .lc-featured,
        .lc-favbrands,
        .lc-season,
        .lc-health,
        .lc-disease {
            padding-top: 26px !important;
            padding-bottom: 26px !important;
        }

        .lc-flashsale,
        .lc-bestseller,
        .lc-featured,
        .lc-favbrands,
        .lc-season,
        .lc-health,
        .lc-disease {
            position: relative;
        }

        .lc-section-header {
            margin-bottom: 18px !important;
            align-items: center !important;
        }

        .lc-section-header-icon {
            display: none !important;
        }

        .lc-section-header-title,
        .lc-flashsale-title,
        .lc-bestseller-title-inline {
            letter-spacing: 0 !important;
        }

        .lc-section-header-title {
            color: #092f30 !important;
            font-size: 30px !important;
            line-height: 1.2 !important;
            font-weight: 900 !important;
        }

        #homeFlashSaleSection {
            margin-top: 0 !important;
            background: #ffffff !important;
        }

        #homeFlashSaleSection .lc-flashsale-box,
        #homeBestSellerSection .lc-bestseller-box {
            border-radius: 8px !important;
        }

        #homeFlashSaleSection .lc-flashsale-box {
            background:
                radial-gradient(circle at 88% 0%, rgba(24, 183, 179, .11), transparent 30%),
                linear-gradient(180deg, #ffffff 0%, #f7fcfd 100%) !important;
            border: 1px solid #dbe7e5 !important;
            box-shadow: 0 22px 60px rgba(16, 36, 63, .08) !important;
        }

        #homeBestSellerSection {
            background: #f3f7fa !important;
        }

        #homeBestSellerSection .lc-bestseller-box {
            background:
                radial-gradient(circle at 8% 0%, rgba(255,255,255,.22), transparent 36%),
                linear-gradient(135deg, #10243f 0%, #0d827c 56%, #17b9b2 100%) !important;
            box-shadow: 0 24px 68px rgba(16, 36, 63, .16) !important;
        }

        #homeFlashSaleSection .lc-product-card--flash,
        #homeBestSellerSection .lc-product-card--best,
        .lc-featured-card,
        .lc-favbrands-card,
        .lc-season-card,
        .lc-health-card,
        .lc-disease-card {
            border-radius: 8px !important;
            box-shadow: 0 10px 28px rgba(12, 88, 92, .06) !important;
        }

        #homeFlashSaleSection .lc-product-card--flash,
        #homeBestSellerSection .lc-product-card--best {
            border-color: rgba(220, 234, 235, .95) !important;
            transition: transform .24s ease, box-shadow .24s ease, border-color .24s ease, filter .24s ease !important;
        }

        #homeFlashSaleSection .lc-product-card--flash:hover,
        #homeBestSellerSection .lc-product-card--best:hover {
            transform: translateY(-7px) !important;
            border-color: rgba(24, 183, 179, .38) !important;
            box-shadow: 0 24px 54px rgba(16, 36, 63, .13) !important;
            filter: saturate(1.03);
        }

        #homeFlashSaleSection .lc-product-image-wrap,
        #homeBestSellerSection .lc-product-image-wrap {
            background:
                radial-gradient(circle at 50% 45%, #ffffff 0%, #f5fbfb 58%, #edf7f8 100%) !important;
        }

        #homeFlashSaleSection .lc-product-btn-buy,
        #homeBestSellerSection .lc-product-btn-buy,
        #homeFlashSaleSection .lc-flashsale-viewall a {
            border-radius: 999px !important;
            font-weight: 900 !important;
            letter-spacing: 0 !important;
        }

        #homeFlashSaleSection .lc-product-btn-buy:hover,
        #homeBestSellerSection .lc-product-btn-buy:hover,
        #homeFlashSaleSection .lc-flashsale-viewall a:hover {
            box-shadow: 0 16px 32px rgba(24, 183, 179, .20) !important;
        }

        .lc-featured {
            background: #f3f7fa !important;
        }

        .lc-featured-grid {
            gap: 14px !important;
        }

        .lc-featured-card {
            border: 1px solid #dbe7e5 !important;
            background: rgba(255,255,255,.92) !important;
            transition: transform .24s ease, box-shadow .24s ease, border-color .24s ease !important;
        }

        .lc-featured-card:hover {
            transform: translateY(-5px) !important;
            border-color: rgba(24, 183, 179, .35) !important;
            box-shadow: 0 20px 44px rgba(16, 36, 63, .10) !important;
        }

        .lc-featured-icon-circle {
            border-radius: 8px !important;
            background: rgba(12, 143, 117, .08) !important;
        }

        .lc-featured-icon-circle img {
            border-radius: 8px !important;
        }

        .lc-favbrands-card,
        .lc-health-card,
        .lc-disease-card,
        .lc-season-card {
            transition: transform .24s ease, box-shadow .24s ease, border-color .24s ease !important;
        }

        .lc-favbrands-card:hover,
        .lc-health-card:hover,
        .lc-disease-card:hover,
        .lc-season-card:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 20px 44px rgba(16, 36, 63, .10) !important;
        }

        .pa-reveal-ready .lc-flashsale-box,
        .pa-reveal-ready .lc-bestseller-box,
        .pa-reveal-ready .lc-featured-card,
        .pa-reveal-ready .lc-favbrands-card,
        .pa-reveal-ready .lc-health-card {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity .65s ease, transform .65s ease;
        }

        .pa-reveal-ready .pa-reveal-visible,
        .pa-reveal-ready .pa-reveal-visible.lc-featured-card,
        .pa-reveal-ready .pa-reveal-visible.lc-favbrands-card,
        .pa-reveal-ready .pa-reveal-visible.lc-health-card {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 767px) {
            main .lc-container {
                width: calc(100% - 24px) !important;
            }

            .pa-mobile-category-first {
                display: block !important;
                margin-bottom: 6px !important;
            }

            .pa-mobile-category-first .lc-featured--balanced {
                padding-bottom: 0 !important;
                margin-bottom: 0 !important;
            }

            .pa-mobile-category-first .lc-featured-grid {
                padding-bottom: 6px !important;
            }

            .pa-desktop-category-position {
                display: none !important;
            }

            .lc-flashsale,
            .lc-bestseller,
            .lc-featured,
            .lc-favbrands,
            .lc-season,
            .lc-health,
            .lc-disease {
                padding-top: 18px !important;
                padding-bottom: 18px !important;
            }

            .lc-section-header-title {
                font-size: 23px !important;
            }

            #homeFlashSaleSection {
                margin-top: 14px !important;
            }
        }

        .pa-mobile-category-first {
            display: none;
        }
    </style>
    <style>
        :root {
            --pa-luxury-ink: #0b2430;
            --pa-luxury-deep: #073f45;
            --pa-luxury-teal: #0f8b7c;
            --pa-luxury-mint: #dff7ec;
            --pa-luxury-gold: #C8A45D;
            --pa-luxury-paper: #ffffff;
            --pa-luxury-soft: #f4faf8;
            --pa-luxury-line: rgba(9, 47, 48, .12);
            --pa-luxury-shadow: 0 24px 70px rgba(9, 47, 48, .10);
        }

        body {
            background:
                linear-gradient(180deg, #f8fcfb 0%, #eef8f5 42%, #ffffff 100%) !important;
            color: var(--pa-luxury-ink) !important;
        }

        .lc-header {
            position: sticky !important;
            top: 0 !important;
            z-index: 80 !important;
            filter: drop-shadow(0 14px 34px rgba(6, 47, 51, .10));
        }

        .lc-header-hero {
            background:
                linear-gradient(120deg, rgba(7, 63, 69, .98) 0%, rgba(10, 91, 92, .96) 46%, rgba(15, 139, 124, .94) 100%) !important;
            color: #ffffff !important;
            overflow: hidden !important;
        }

        .lc-header-hero::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(90deg, transparent 0%, rgba(255,255,255,.08) 50%, transparent 100%);
            transform: translateX(-110%);
            animation: paLuxuryHeaderSweep 7s ease-in-out infinite;
        }

        .lc-header-top {
            min-height: 38px !important;
            border-bottom: 1px solid rgba(255,255,255,.16) !important;
            color: rgba(255,255,255,.88) !important;
        }

        .lc-header-main {
            padding: 14px 0 16px !important;
            gap: 22px !important;
        }

        .lc-logo {
            color: #ffffff !important;
        }

        .lc-logo-mark,
        .lc-link-user-icon,
        .lc-btn-cart-icon {
            background: rgba(255,255,255,.96) !important;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .13) !important;
        }

        .lc-logo-text-main,
        .lc-logo-text-sub,
        .lc-header-actions,
        .lc-header-actions a,
        .lc-header-actions button {
            color: #ffffff !important;
        }

        .lc-search-bar {
            border-radius: 999px !important;
            background: rgba(255,255,255,.98) !important;
            border: 1px solid rgba(255,255,255,.70) !important;
            box-shadow: 0 16px 40px rgba(3, 40, 44, .18) !important;
            overflow: hidden !important;
        }

        .lc-search-bar input,
        .lc-search-input {
            color: var(--pa-luxury-ink) !important;
        }

        .lc-header-nav {
            background: rgba(255,255,255,.94) !important;
            border-bottom: 1px solid rgba(9, 47, 48, .10) !important;
            box-shadow: 0 10px 28px rgba(9, 47, 48, .08) !important;
            backdrop-filter: blur(14px);
        }

        .lc-header-nav-inner {
            gap: 8px !important;
        }

        .lc-nav-item,
        .lc-header-nav a {
            border-radius: 999px !important;
            color: #16444b !important;
            font-weight: 800 !important;
            transition: background .2s ease, color .2s ease, transform .2s ease !important;
        }

        .lc-nav-item:hover,
        .lc-header-nav a:hover {
            background: rgba(15, 139, 124, .10) !important;
            color: var(--pa-luxury-teal) !important;
            transform: translateY(-1px);
        }

        main {
            background:
                linear-gradient(180deg, #f8fcfb 0%, #ffffff 34%, #f4faf8 100%) !important;
        }

        main section:not(.pa-luxury-home) {
            padding-top: 44px !important;
            padding-bottom: 44px !important;
        }

        main section:nth-of-type(even):not(.pa-luxury-home) {
            background:
                linear-gradient(180deg, rgba(244,250,248,.75) 0%, rgba(255,255,255,.92) 100%) !important;
        }

        .lc-section-header,
        .lc-health-header,
        .pa-ds-header,
        .pa-season-v2__head {
            margin-bottom: 22px !important;
        }

        .lc-section-header-title,
        .lc-health-title,
        .pa-ds-title,
        .pa-season-v2__title,
        .lc-flashsale-title,
        .lc-bestseller-title-inline {
            color: var(--pa-luxury-ink) !important;
            font-size: clamp(26px, 2.6vw, 40px) !important;
            line-height: 1.16 !important;
            font-weight: 950 !important;
            letter-spacing: 0 !important;
        }

        .lc-section-header-title::after,
        .lc-health-title::after,
        .pa-ds-title::after,
        .pa-season-v2__title::after,
        .lc-flashsale-title::after {
            content: "";
            display: block;
            width: 74px;
            height: 3px;
            margin-top: 10px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--pa-luxury-teal), var(--pa-luxury-gold));
        }

        .lc-flashsale-box,
        .lc-bestseller-box,
        .lc-favbrands-intro,
        .pa-season-v2__box,
        #pa-disease-hub .pa-ds-mode-head,
        .lc-footer-top {
            position: relative;
            overflow: hidden;
        }

        .lc-flashsale-box::before,
        .lc-bestseller-box::before,
        .lc-favbrands-intro::before,
        .pa-season-v2__box::before,
        #pa-disease-hub .pa-ds-mode-head::before,
        .lc-footer-top::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: linear-gradient(115deg, transparent 0%, rgba(255,255,255,.22) 48%, transparent 68%);
            transform: translateX(-120%);
            animation: paLuxurySweep 8s ease-in-out infinite;
        }

        #homeFlashSaleSection,
        .lc-featured,
        .lc-favbrands,
        .pa-season-v2,
        #pa-health-corner,
        #pa-disease-hub {
            background: transparent !important;
        }

        #homeFlashSaleSection .lc-flashsale-box {
            border-radius: 8px !important;
            background:
                linear-gradient(135deg, #ffffff 0%, #f4fbf8 58%, #eef9f3 100%) !important;
            border: 1px solid var(--pa-luxury-line) !important;
            box-shadow: var(--pa-luxury-shadow) !important;
        }

        #homeBestSellerSection .lc-bestseller-box,
        .lc-favbrands-intro,
        .pa-season-v2__box,
        #pa-disease-hub .pa-ds-mode-head {
            border-radius: 8px !important;
            background:
                linear-gradient(135deg, #082e36 0%, #0a6466 58%, #0f8b7c 100%) !important;
            border: 1px solid rgba(255,255,255,.22) !important;
            box-shadow: 0 28px 78px rgba(8, 46, 54, .20) !important;
        }

        #homeBestSellerSection .lc-bestseller-title-inline,
        #homeBestSellerSection .lc-bestseller-subtitle,
        .lc-favbrands-intro *,
        .pa-season-v2__box,
        #pa-disease-hub .pa-ds-mode-head * {
            color: #ffffff !important;
        }

        .lc-product-card--flash,
        .lc-product-card--best,
        .pa-season-v2__product,
        .lc-featured-card,
        .lc-favbrands-card,
        #pa-health-corner .pa-hc-featured,
        #pa-health-corner .pa-hc-item,
        #pa-disease-hub .pa-ds-card {
            border-radius: 8px !important;
            background: rgba(255,255,255,.96) !important;
            border: 1px solid rgba(9,47,48,.10) !important;
            box-shadow: 0 14px 36px rgba(9,47,48,.08) !important;
            transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease, filter .28s ease !important;
        }

        .lc-product-card--flash:hover,
        .lc-product-card--best:hover,
        .pa-season-v2__product:hover,
        .lc-featured-card:hover,
        .lc-favbrands-card:hover,
        #pa-health-corner .pa-hc-featured:hover,
        #pa-health-corner .pa-hc-item:hover,
        #pa-disease-hub .pa-ds-card:hover {
            transform: translateY(-8px) !important;
            border-color: rgba(15,139,124,.34) !important;
            box-shadow: 0 26px 64px rgba(9,47,48,.14) !important;
            filter: saturate(1.04);
        }

        .lc-product-image-wrap,
        .pa-season-v2__product-image,
        .lc-featured-icon-circle,
        .lc-favbrands-logo-pill {
            background:
                linear-gradient(180deg, #ffffff 0%, #f0faf5 100%) !important;
            border-radius: 8px !important;
        }

        .lc-product-btn-buy,
        .pa-season-v2__product-btn,
        .pa-season-v2__detail-btn,
        #pa-disease-hub .pa-ds-btn--primary,
        .lc-footer-top-btn {
            border-radius: 999px !important;
            background: linear-gradient(135deg, #0f8b7c 0%, #14b18e 100%) !important;
            color: #ffffff !important;
            border: 0 !important;
            box-shadow: 0 14px 30px rgba(15,139,124,.20) !important;
            font-weight: 900 !important;
        }

        .lc-product-price-sale,
        .pa-season-v2__product-price-sale {
            color: #0b5f64 !important;
            font-weight: 950 !important;
        }

        #homeFlashSaleSection .lc-product-btn-buy:not(.is-disabled) {
            background: linear-gradient(135deg, #0f8b7c 0%, #0b5f64 100%) !important;
            color: #ffffff !important;
            border: 1px solid rgba(255,255,255,.22) !important;
            box-shadow: 0 14px 30px rgba(15,139,124,.22) !important;
            opacity: 1 !important;
        }

        #homeFlashSaleSection .lc-product-btn-buy:not(.is-disabled) i,
        #homeFlashSaleSection .lc-product-btn-buy:not(.is-disabled) span {
            color: #ffffff !important;
            opacity: 1 !important;
        }

        #homeFlashSaleSection .lc-product-btn-buy:not(.is-disabled):hover {
            background: linear-gradient(135deg, #16ad94 0%, #074d55 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 18px 38px rgba(15,139,124,.28) !important;
        }

        #homeFlashSaleSection .lc-product-btn-buy.is-disabled {
            background: #edf5f3 !important;
            color: #7b8f98 !important;
            box-shadow: none !important;
        }

        .lc-featured-grid {
            display: grid !important;
            grid-template-columns: repeat(6, minmax(0, 1fr)) !important;
            gap: 16px !important;
        }

        .lc-featured-card {
            padding: 20px 14px !important;
            min-height: 170px !important;
        }

        .lc-favbrands-list {
            gap: 18px !important;
        }

        .pa-season-v2__head,
        #pa-health-corner .lc-health-header,
        #pa-disease-hub .pa-ds-header {
            align-items: flex-end !important;
        }

        .pa-season-v2__eyebrow,
        .pa-season-v2__desc,
        .lc-health-viewall,
        #pa-disease-hub .pa-ds-viewall {
            color: var(--pa-luxury-teal) !important;
            font-weight: 850 !important;
        }

        .pa-season-v2__tabs,
        #pa-disease-hub .pa-ds-switch,
        .lc-health-tags {
            background: rgba(15,139,124,.08) !important;
            border: 1px solid rgba(15,139,124,.12) !important;
            border-radius: 999px !important;
            padding: 8px !important;
        }

        .pa-season-v2__tab,
        #pa-disease-hub .pa-ds-switch-btn,
        .lc-health-tag {
            border-radius: 999px !important;
            font-weight: 900 !important;
        }

        .pa-season-v2__tab.is-active,
        #pa-disease-hub .pa-ds-switch-btn--active,
        .lc-health-tag--active {
            background: #ffffff !important;
            color: var(--pa-luxury-teal) !important;
            box-shadow: 0 12px 30px rgba(9,47,48,.10) !important;
        }

        .pa-season-v2__info,
        .pa-season-v2__products-wrap {
            background: rgba(255,255,255,.12) !important;
            border: 1px solid rgba(255,255,255,.16) !important;
            border-radius: 8px !important;
            backdrop-filter: blur(10px);
        }

        .pa-season-v2__info-label,
        .pa-season-v2__products-label {
            color: #62e6d5 !important;
        }

        .pa-season-v2__info-title,
        .pa-season-v2__products-title {
            color: #ffffff !important;
        }

        .pa-season-v2__info-text,
        .pa-season-v2__info-text *,
        .pa-season-v2__info-body {
            color: rgba(255,255,255,.78) !important;
        }

        #pa-health-corner .pa-hc-featured-media,
        #pa-disease-hub .pa-ds-card-media {
            border-radius: 8px 8px 0 0 !important;
        }

        #pa-health-corner .pa-hc-featured-title,
        #pa-health-corner .pa-hc-item-title,
        #pa-disease-hub .pa-ds-card-title {
            color: var(--pa-luxury-ink) !important;
        }

        .lc-footer {
            margin-top: 28px !important;
            background: #082e36 !important;
        }

        .lc-footer-top {
            background:
                linear-gradient(135deg, #0f8b7c 0%, #0a6466 100%) !important;
            border-bottom: 1px solid rgba(255,255,255,.14) !important;
        }

        .lc-footer-main {
            background:
                linear-gradient(180deg, #082e36 0%, #061f27 100%) !important;
            border-top: 0 !important;
            color: rgba(255,255,255,.74) !important;
        }

        .lc-footer-grid {
            gap: 30px !important;
            padding-top: 44px !important;
            padding-bottom: 42px !important;
        }

        .lc-footer-col-title,
        .lc-footer-hotline-title,
        .lc-footer-hotline-row span:first-child {
            color: #ffffff !important;
            font-weight: 950 !important;
        }

        .lc-footer-list li a,
        .lc-footer-hotline-row span:last-child,
        .lc-footer-badge-label {
            color: rgba(255,255,255,.68) !important;
        }

        .lc-footer-list li a:hover {
            color: #d8b469 !important;
        }

        .lc-footer-social-icon,
        .lc-footer-cert-pill,
        .lc-footer-pay-pill {
            background: rgba(255,255,255,.10) !important;
            border: 1px solid rgba(255,255,255,.16) !important;
            color: #ffffff !important;
        }

        .lc-footer-qr img {
            border-radius: 8px !important;
            padding: 10px !important;
            background: #ffffff !important;
            box-shadow: 0 18px 44px rgba(0,0,0,.22) !important;
        }

        .pa-reveal-ready .lc-flashsale-box,
        .pa-reveal-ready .lc-bestseller-box,
        .pa-reveal-ready .lc-product-card--flash,
        .pa-reveal-ready .lc-product-card--best,
        .pa-reveal-ready .lc-featured-card,
        .pa-reveal-ready .lc-favbrands-intro,
        .pa-reveal-ready .lc-favbrands-card,
        .pa-reveal-ready .pa-season-v2__head,
        .pa-reveal-ready .pa-season-v2__info,
        .pa-reveal-ready .pa-season-v2__product,
        .pa-reveal-ready #pa-health-corner .pa-hc-featured,
        .pa-reveal-ready #pa-health-corner .pa-hc-item,
        .pa-reveal-ready #pa-disease-hub .pa-ds-mode-head,
        .pa-reveal-ready #pa-disease-hub .pa-ds-card,
        .pa-reveal-ready .lc-footer-top,
        .pa-reveal-ready .lc-footer-grid > * {
            opacity: 0;
            transform: translateY(26px) scale(.985);
            transition: opacity .72s cubic-bezier(.2,.78,.2,1), transform .72s cubic-bezier(.2,.78,.2,1);
        }

        .pa-reveal-ready .pa-reveal-visible {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
        }

        @keyframes paLuxurySweep {
            0%, 42% { transform: translateX(-120%); opacity: 0; }
            52% { opacity: 1; }
            72%, 100% { transform: translateX(120%); opacity: 0; }
        }

        @keyframes paLuxuryHeaderSweep {
            0%, 52% { transform: translateX(-110%); opacity: 0; }
            62% { opacity: .95; }
            82%, 100% { transform: translateX(110%); opacity: 0; }
        }

        @media (max-width: 1199px) {
            .lc-featured-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            }
        }

        @media (max-width: 767px) {
            .lc-header {
                position: relative !important;
            }

            .lc-header .lc-container {
                width: min(calc(100% - 28px), 362px) !important;
                max-width: min(calc(100% - 28px), 362px) !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .lc-header-main {
                display: grid !important;
                grid-template-columns: minmax(0, 1fr) !important;
                position: relative !important;
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
                align-items: center !important;
                padding: 12px 0 !important;
                gap: 10px 8px !important;
                overflow: visible !important;
            }

            .lc-logo {
                min-width: 0 !important;
                grid-column: 1 !important;
                grid-row: 1 !important;
                max-width: calc(100% - 134px) !important;
            }

            .lc-logo-mark img {
                width: 46px !important;
            }

            .lc-logo-text strong {
                font-size: 13px !important;
                line-height: 1.15 !important;
            }

            .lc-logo-text span,
            .lc-link-user-text,
            .lc-btn-cart-text {
                display: none !important;
            }

            .lc-header-actions {
                display: none !important;
                visibility: hidden !important;
                width: 0 !important;
                min-width: 0 !important;
                overflow: hidden !important;
            }

            .pa-mobile-header-actions {
                position: absolute !important;
                top: 12px !important;
                right: 0 !important;
                width: 126px !important;
                min-width: 126px !important;
                height: 38px !important;
                display: block !important;
                z-index: 2 !important;
            }

            .pa-mobile-header-actions > a,
            .pa-mobile-header-actions > button {
                position: absolute !important;
                top: 0 !important;
                width: 38px !important;
                height: 38px !important;
                min-width: 38px !important;
                border: 0 !important;
                border-radius: 999px !important;
                padding: 0 !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                background: rgba(255,255,255,.94) !important;
                color: var(--pa-luxury-teal) !important;
                box-shadow: 0 12px 28px rgba(3,40,44,.16) !important;
                text-decoration: none !important;
            }

            .pa-mobile-header-actions > :nth-child(1) {
                right: 88px !important;
            }

            .pa-mobile-header-actions > :nth-child(2) {
                right: 44px !important;
            }

            .pa-mobile-header-actions > :nth-child(3) {
                right: 0 !important;
            }

            .pa-mobile-header-actions > a i,
            .pa-mobile-header-actions > button i {
                font-size: 18px !important;
            }

            .lc-header-actions .lc-link-user,
            .lc-header-actions .lc-btn-cart,
            .lc-mobile-menu-trigger {
                width: 38px !important;
                height: 38px !important;
                min-width: 38px !important;
                border-radius: 999px !important;
                padding: 0 !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                background: rgba(255,255,255,.94) !important;
                color: var(--pa-luxury-teal) !important;
                box-shadow: 0 12px 28px rgba(3,40,44,.16) !important;
            }

            .lc-link-user-icon,
            .lc-btn-cart-icon {
                width: 38px !important;
                height: 38px !important;
                min-width: 38px !important;
                box-shadow: none !important;
                background: transparent !important;
            }

            .lc-search-wrap {
                grid-column: 1 / -1 !important;
                grid-row: 2 !important;
                width: 100% !important;
                margin-top: 10px !important;
            }

            .lc-search-suggestions {
                display: none !important;
            }

            main section:not(.pa-luxury-home) {
                padding-top: 16px !important;
                padding-bottom: 16px !important;
            }

            .lc-section-header-title,
            .lc-health-title,
            .pa-ds-title,
            .pa-season-v2__title,
            .lc-flashsale-title,
            .lc-bestseller-title-inline {
                font-size: 20px !important;
                line-height: 1.22 !important;
            }

            .lc-section-header,
            .lc-health-header,
            .pa-ds-header,
            .pa-season-v2__head {
                margin-bottom: 12px !important;
                align-items: center !important;
            }

            .lc-section-header-title::after,
            .lc-health-title::after,
            .pa-ds-title::after,
            .pa-season-v2__title::after,
            .lc-flashsale-title::after {
                width: 42px !important;
                height: 2px !important;
                margin-top: 7px !important;
            }

            #homeFlashSaleSection .lc-flashsale-box,
            #homeBestSellerSection .lc-bestseller-box,
            .lc-favbrands-intro,
            .pa-season-v2__box,
            #pa-disease-hub .pa-ds-mode-head {
                border-radius: 18px !important;
                box-shadow: 0 16px 38px rgba(9,47,48,.10) !important;
            }

            #homeFlashSaleSection .lc-product-card--flash,
            #homeBestSellerSection .lc-product-card--best,
            .pa-season-v2__product,
            .lc-favbrands-card,
            #pa-health-corner .pa-hc-featured,
            #pa-health-corner .pa-hc-item,
            #pa-disease-hub .pa-ds-card {
                border-radius: 16px !important;
                box-shadow: 0 10px 24px rgba(9,47,48,.07) !important;
            }

            #homeFlashSaleSection .lc-product-card--flash,
            #homeBestSellerSection .lc-product-card--best,
            .pa-season-v2__product {
                min-width: 152px !important;
                max-width: 168px !important;
            }

            #homeFlashSaleSection .lc-product-image-wrap,
            #homeBestSellerSection .lc-product-image-wrap,
            .pa-season-v2__product-image {
                min-height: 112px !important;
                border-radius: 14px !important;
            }

            #homeFlashSaleSection .lc-product-name,
            #homeBestSellerSection .lc-product-name,
            .pa-season-v2__product-name {
                font-size: 12px !important;
                line-height: 1.35 !important;
            }

            #homeFlashSaleSection .lc-product-btn-buy,
            #homeBestSellerSection .lc-product-btn-buy,
            .pa-season-v2__product-btn {
                min-height: 36px !important;
                font-size: 12px !important;
            }

            #homeBestSellerSection .lc-product-card--best {
                min-height: 0 !important;
                max-width: 154px !important;
            }

            #homeBestSellerSection .lc-product-image-wrap {
                height: 78px !important;
                min-height: 78px !important;
            }

            #homeBestSellerSection .lc-product-body {
                padding: 8px !important;
            }

            #homeBestSellerSection .lc-product-name {
                min-height: 30px !important;
                margin-bottom: 5px !important;
                font-size: 11.5px !important;
                line-height: 1.3 !important;
            }

            #homeBestSellerSection .lc-product-price-row {
                min-height: 28px !important;
            }

            #homeBestSellerSection .lc-product-unit-pill,
            #homeBestSellerSection .lc-product-price-sale small {
                display: none !important;
            }

            #homeBestSellerSection .lc-product-btn-buy {
                min-height: 28px !important;
                margin-top: 6px !important;
                font-size: 10.5px !important;
            }

            .pa-season-v2__product {
                min-height: 0 !important;
                max-width: 152px !important;
            }

            .pa-season-v2__product-image {
                height: 82px !important;
                min-height: 82px !important;
            }

            .pa-season-v2__product-body {
                padding: 8px !important;
            }

            .pa-season-v2__product-name {
                min-height: 32px !important;
                margin-bottom: 5px !important;
                font-size: 11.5px !important;
                line-height: 1.32 !important;
            }

            .pa-season-v2__product-price-sale {
                font-size: 13px !important;
            }

            .pa-season-v2__product-price-sale span,
            .pa-season-v2__product-price-origin {
                display: none !important;
            }

            .pa-season-v2__product-btn {
                min-height: 28px !important;
                margin-top: 6px !important;
                font-size: 10.5px !important;
            }

            .pa-season-v2__tabs,
            #pa-disease-hub .pa-ds-switch,
            .lc-health-tags {
                border-radius: 999px !important;
                overflow-x: auto;
                justify-content: flex-start !important;
                padding: 6px !important;
                scrollbar-width: none;
            }

            .pa-season-v2__tabs::-webkit-scrollbar,
            #pa-disease-hub .pa-ds-switch::-webkit-scrollbar,
            .lc-health-tags::-webkit-scrollbar {
                display: none;
            }

            .pa-season-v2__tab,
            #pa-disease-hub .pa-ds-switch-btn,
            .lc-health-tag {
                flex: 0 0 auto;
                min-height: 34px !important;
                padding: 0 12px !important;
                font-size: 12px !important;
            }

            #pa-health-corner .pa-hc-featured-title,
            #pa-health-corner .pa-hc-item-title,
            #pa-disease-hub .pa-ds-card-title {
                font-size: 14px !important;
                line-height: 1.35 !important;
            }

            .lc-footer-grid {
                padding-top: 32px !important;
                padding-bottom: 96px !important;
            }
        }
    </style>
    <main>
        <div class="pa-mobile-category-first">
            @include('website.home.section-best-category')
        </div>

        <!-- ========== BANNER HERO ==========
         Nền full width, nội dung căn giữa 80% -->
        @include('website.home.section-banner-hero')

        <!-- ========== FLASH SALE GIÁ TỐT ========== -->
        @include('website.home.section-flash-sale')

        <!-- ========== SẢN PHẨM BÁN CHẠY ========== -->
        @include('website.home.section-best-seller')

        <!-- ========== DANH MỤC NỔI BẬT ========== -->
        <div class="pa-desktop-category-position">
            @include('website.home.section-best-category')
        </div>

        <!-- ========== THƯƠNG HIỆU YÊU THÍCH ========== -->
        @include('website.home.section-favbrands')

        <!-- ========== TÍCH ĐIỂM ĐỔI QUÀ ========== -->


        <!-- ========== BỆNH THEO MÙA ========== -->
        @include('website.home.section-sick')
        
        <!-- ========== GÓC SỨC KHỎE ========== -->
        @include('website.home.health-corner')

        <!-- ========== BỆNH (THEO ĐỐI TƯỢNG) ========== -->
        @include('website.home.section-sick-customer')

        <!-- ========== FOOTER ========== -->
        @include('website.home.footer')

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.body.classList.add('pa-reveal-ready');

            const revealItems = document.querySelectorAll(
                '.lc-flashsale-box, .lc-bestseller-box, .lc-product-card--flash, .lc-product-card--best, .lc-featured-card, .lc-favbrands-intro, .lc-favbrands-card, .pa-season-v2__head, .pa-season-v2__info, .pa-season-v2__product, #pa-health-corner .pa-hc-featured, #pa-health-corner .pa-hc-item, #pa-disease-hub .pa-ds-mode-head, #pa-disease-hub .pa-ds-card, .lc-footer-top, .lc-footer-grid > *'
            );

            if (!('IntersectionObserver' in window) || !revealItems.length) {
                revealItems.forEach(function (item) {
                    item.classList.add('pa-reveal-visible');
                });
                return;
            }

            const revealVisibleNow = function () {
                const viewportHeight = window.innerHeight || document.documentElement.clientHeight || 0;

                revealItems.forEach(function (item) {
                    if (item.classList.contains('pa-reveal-visible')) return;

                    const rect = item.getBoundingClientRect();
                    if (rect.top < viewportHeight * 0.96 && rect.bottom > 0) {
                        item.classList.add('pa-reveal-visible');
                    }
                });
            };

            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('pa-reveal-visible');
                    observer.unobserve(entry.target);
                });
            }, {
                threshold: 0.12,
                rootMargin: '0px 0px -70px 0px'
            });

            revealItems.forEach(function (item, index) {
                item.style.transitionDelay = Math.min(index % 6, 5) * 55 + 'ms';
                observer.observe(item);
            });

            requestAnimationFrame(revealVisibleNow);
            setTimeout(revealVisibleNow, 250);
            setTimeout(revealVisibleNow, 900);
            window.addEventListener('scroll', revealVisibleNow, { passive: true });
            window.addEventListener('resize', revealVisibleNow, { passive: true });
        });

        // Switch "Bệnh theo đối tượng / Bệnh theo mùa"
        (function () {
            const btns = document.querySelectorAll(".lc-disease-switch-btn");
            const seasonSection = document.querySelector(".lc-season");

            btns.forEach((btn) => {
                btn.addEventListener("click", () => {
                    btns.forEach((b) =>
                        b.classList.remove("lc-disease-switch-btn--active")
                    );
                    btn.classList.add("lc-disease-switch-btn--active");

                    const mode = btn.getAttribute("data-mode");
                    if (mode === "by-season" && seasonSection) {
                        seasonSection.scrollIntoView({ behavior: "smooth" });
                    }
                    // mode "by-subject" hiện tại chỉ highlight, không ẩn grid
                });
            });
        })();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('[data-health-tab]');
            const panels = document.querySelectorAll('[data-health-panel]');

            if (!tabs.length || !panels.length) return;

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    const id = this.getAttribute('data-health-tab');

                    tabs.forEach(function (btn) {
                        btn.classList.remove('lc-health-tag--active');
                    });

                    panels.forEach(function (panel) {
                        panel.hidden = panel.getAttribute('data-health-panel') !== id;
                    });

                    this.classList.add('lc-health-tag--active');
                });
            });
        });
        </script>
    <script>
        
        // ========== BANNER PRODUCT SLIDER (2 slide Durex / Vitamin) ==========
        (function () {
            const track = document.getElementById("bannerProductTrack");
            if (!track) return;

            const slides = Array.from(
                track.querySelectorAll(".lc-banner-product-slide")
            );
            if (!slides.length) return;

            const dotsWrap = document.getElementById("bannerProductDots");
            const dots = dotsWrap
                ? Array.from(dotsWrap.querySelectorAll(".lc-banner-product-dot"))
                : [];
            const btnNext = document.getElementById("bannerProductNext");
            const bannerSection = document.querySelector(".lc-banner");

            let current = 0;
            let timer = null;
            const INTERVAL = 5000; // 5s auto chuyển

            function goToSlide(index) {
                if (!slides.length) return;
                current = (index + slides.length) % slides.length;
                const offset = -current * 100;
                track.style.transform = "translateX(" + offset + "%)";

                if (dots.length) {
                    dots.forEach((dot, i) => {
                        dot.classList.toggle(
                            "lc-banner-product-dot--active",
                            i === current
                        );
                    });
                }
            }

            function startAuto() {
                stopAuto();
                timer = setInterval(function () {
                    goToSlide(current + 1);
                }, INTERVAL);
            }

            function stopAuto() {
                if (timer) {
                    clearInterval(timer);
                    timer = null;
                }
            }

            // Nút chuyển slide
            if (btnNext) {
                btnNext.addEventListener("click", function () {
                    goToSlide(current + 1);
                    startAuto();
                });
            }

            // Click dot
            if (dots.length) {
                dots.forEach(function (dot, index) {
                    dot.addEventListener("click", function () {
                        goToSlide(index);
                        startAuto();
                    });
                });
            }

            // Hover banner thì dừng auto
            if (bannerSection) {
                bannerSection.addEventListener("mouseenter", stopAuto);
                bannerSection.addEventListener("mouseleave", startAuto);
            }

            // Khởi tạo
            goToSlide(0);
            startAuto();
        })();

        // ========== FLASH SALE: TAB + COUNTDOWN + SLIDER ==========
        // Tab ngày Flash Sale (chỉ đổi active)
        (function () {
            const tabs = document.querySelectorAll(".lc-flashsale-tab");
            if (!tabs.length) return;

            tabs.forEach(function (tab) {
                tab.addEventListener("click", function () {
                    tabs.forEach(function (t) {
                        t.classList.remove("lc-flashsale-tab--active");
                    });
                    tab.classList.add("lc-flashsale-tab--active");
                    // Sau này có nhiều data theo tab, mình map thêm ở đây
                });
            });
        })();

        // Countdown dựa trên số H:M:S hiện có trong DOM
        (function () {
            const timerEl = document.getElementById("flashsaleTimer");
            if (!timerEl) return;

            const boxH = timerEl.querySelector('[data-unit="hours"]');
            const boxM = timerEl.querySelector('[data-unit="minutes"]');
            const boxS = timerEl.querySelector('[data-unit="seconds"]');

            if (!boxH || !boxM || !boxS) return;

            function toInt(el) {
                return parseInt((el.textContent || "0").trim(), 10) || 0;
            }

            let h = toInt(boxH);
            let m = toInt(boxM);
            let s = toInt(boxS);

            function pad(n) {
                return String(n < 0 ? 0 : n).padStart(2, "0");
            }

            function render() {
                boxH.textContent = pad(h);
                boxM.textContent = pad(m);
                boxS.textContent = pad(s);
            }

            function tick() {
                if (h === 0 && m === 0 && s === 0) return;

                s--;
                if (s < 0) {
                    s = 59;
                    m--;
                }
                if (m < 0) {
                    m = 59;
                    h--;
                }
                if (h < 0) {
                    h = 0;
                    m = 0;
                    s = 0;
                }
                render();
            }

            render();
            setInterval(tick, 1000);
        })();

        // Slider ngang Flash Sale (scroll)
        (function () {
            const list = document.getElementById("flashsaleProducts");
            const btn = document.getElementById("flashsaleNext");
            if (!list || !btn) return;

            btn.addEventListener("click", function () {
                const card = list.querySelector(".lc-product-card--flash");
                const step = card
                    ? card.getBoundingClientRect().width + 16
                    : 220;
                list.scrollBy({ left: step, behavior: "smooth" });
            });
        })();

        // ========== SẢN PHẨM BÁN CHẠY: SLIDER NGANG ==========
        (function () {
            const container = document.getElementById("bestsellerProducts");
            const btnNext = document.getElementById("bestsellerNext");
            if (!container || !btnNext) return;

            btnNext.addEventListener("click", function () {
                const card = container.querySelector(".lc-product-card--best");
                const step = card
                    ? card.getBoundingClientRect().width + 16
                    : 220;
                container.scrollBy({ left: step, behavior: "smooth" });
            });
        })();

        // ========== THƯƠNG HIỆU YÊU THÍCH: SLIDER NGANG ==========
        (function () {
            const list = document.getElementById("favBrandsList");
            const btn = document.getElementById("favBrandsNext");
            if (!list || !btn) return;

            btn.addEventListener("click", function () {
                const card = list.querySelector(".lc-favbrands-card");
                const step = card
                    ? card.getBoundingClientRect().width + 16
                    : 220;
                list.scrollBy({ left: step, behavior: "smooth" });
            });
        })();

        // ========== BỆNH THEO MÙA: TABS + SLIDER ==========
        (function () {
            const tabs = document.querySelectorAll(".lc-season-tab");
            const panels = document.querySelectorAll(".lc-season-panel");

            if (!tabs.length || !panels.length) return;

            tabs.forEach(function (tab) {
                tab.addEventListener("click", function () {
                    const targetId = tab.getAttribute("data-target");
                    if (!targetId) return;

                    tabs.forEach(function (t) {
                        t.classList.remove("lc-season-tab--active");
                    });
                    tab.classList.add("lc-season-tab--active");

                    panels.forEach(function (p) {
                        p.classList.remove("is-active");
                    });
                    const panel = document.getElementById(targetId);
                    if (panel) panel.classList.add("is-active");
                });
            });

            // Slider sản phẩm cho panel "Sốt xuất huyết"
            const dengueList = document.getElementById("seasonProductsDengue");
            const dengueNext = document.getElementById("seasonDengueNext");
            if (dengueList && dengueNext) {
                dengueNext.addEventListener("click", function () {
                    const card = dengueList.querySelector(".lc-product-card--season");
                    const step = card
                        ? card.getBoundingClientRect().width + 12
                        : 220;
                    dengueList.scrollBy({ left: step, behavior: "smooth" });
                });
            }
        })();

        // ========== GÓC SỨC KHOẺ: đổi tag active ==========
        (function () {
            const tags = document.querySelectorAll(".lc-health-tag");
            if (!tags.length) return;

            tags.forEach(function (tag) {
                tag.addEventListener("click", function () {
                    tags.forEach(function (t) {
                        t.classList.remove("lc-health-tag--active");
                    });
                    tag.classList.add("lc-health-tag--active");
                });
            });
        })();

        // ========== BỆNH: switch "theo đối tượng / theo mùa" ==========
        (function () {
            const btns = document.querySelectorAll(".lc-disease-switch-btn");
            if (!btns.length) return;

            const seasonSection = document.querySelector(".lc-season");

            btns.forEach(function (btn) {
                btn.addEventListener("click", function () {
                    btns.forEach(function (b) {
                        b.classList.remove("lc-disease-switch-btn--active");
                    });
                    btn.classList.add("lc-disease-switch-btn--active");

                    const mode = btn.getAttribute("data-mode");
                    if (mode === "by-season" && seasonSection) {
                        seasonSection.scrollIntoView({ behavior: "smooth" });
                    }
                    // mode "by-subject": chỉ highlight, không ẩn grid
                });
            });
        })();

        // ========== HEADER NAV: set item active khi click ==========
        (function () {
            const items = document.querySelectorAll(
                ".lc-header-nav-inner .lc-nav-item"
            );
            if (!items.length) return;

            items.forEach(function (item) {
                item.addEventListener("click", function () {
                    items.forEach(function (i) {
                        i.classList.remove("lc-nav-item--active");
                    });
                    item.classList.add("lc-nav-item--active");
                });
            });
        })();
    </script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const root = document.getElementById('homeFlashSaleSection');
    if (!root) return;

    const tabs = root.querySelectorAll('[data-flashsale-tab]');
    const panels = root.querySelectorAll('[data-flashsale-panel]');
    const countdownLabel = root.querySelector('[data-flashsale-label]');
    const hoursEl = root.querySelector('[data-unit="hours"]');
    const minutesEl = root.querySelector('[data-unit="minutes"]');
    const secondsEl = root.querySelector('[data-unit="seconds"]');

    let timer = null;

    function pad(num) {
        return String(num).padStart(2, '0');
    }

    function updateTimer(targetIso, statusKey) {
        if (!hoursEl || !minutesEl || !secondsEl) return;

        if (timer) {
            clearInterval(timer);
            timer = null;
        }

        if (statusKey === 'ended' || !targetIso) {
            if (countdownLabel) countdownLabel.textContent = 'Đã kết thúc';
            hoursEl.textContent = '00';
            minutesEl.textContent = '00';
            secondsEl.textContent = '00';
            return;
        }

        if (countdownLabel) {
            countdownLabel.textContent = statusKey === 'upcoming' ? 'Bắt đầu sau' : 'Kết thúc sau';
        }

        function tick() {
            const now = new Date().getTime();
            const target = new Date(targetIso).getTime();
            let diff = Math.floor((target - now) / 1000);

            if (diff <= 0) {
                hoursEl.textContent = '00';
                minutesEl.textContent = '00';
                secondsEl.textContent = '00';
                clearInterval(timer);
                return;
            }

            const hours = Math.floor(diff / 3600);
            diff %= 3600;
            const minutes = Math.floor(diff / 60);
            const seconds = diff % 60;

            hoursEl.textContent = pad(hours);
            minutesEl.textContent = pad(minutes);
            secondsEl.textContent = pad(seconds);
        }

        tick();
        timer = setInterval(tick, 1000);
    }

    function activateSession(sessionId) {
        let activeTab = null;

        tabs.forEach(function (tab) {
            const active = tab.getAttribute('data-flashsale-tab') === String(sessionId);
            tab.classList.toggle('lc-flashsale-tab--active', active);
            if (active) activeTab = tab;
        });

        panels.forEach(function (panel) {
            panel.hidden = panel.getAttribute('data-flashsale-panel') !== String(sessionId);
        });

        if (activeTab) {
            const statusKey = activeTab.getAttribute('data-status');
            const targetIso = statusKey === 'upcoming'
                ? activeTab.getAttribute('data-start-at')
                : activeTab.getAttribute('data-end-at');

            updateTimer(targetIso, statusKey);
        }
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            activateSession(this.getAttribute('data-flashsale-tab'));
        });
    });

    root.querySelectorAll('[data-flashsale-next]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const wrap = this.closest('.lc-flashsale-products-wrap');
            const slider = wrap ? wrap.querySelector('[data-flashsale-products]') : null;
            if (!slider) return;

            slider.scrollBy({
                left: 320,
                behavior: 'smooth'
            });
        });
    });

    const initialActiveTab = root.querySelector('.lc-flashsale-tab--active') || tabs[0];
    if (initialActiveTab) {
        activateSession(initialActiveTab.getAttribute('data-flashsale-tab'));
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const favBrandsList = document.getElementById('favBrandsList');
    const favBrandsNext = document.getElementById('favBrandsNext');

    if (favBrandsList && favBrandsNext) {
        favBrandsNext.addEventListener('click', function () {
            const firstCard = favBrandsList.querySelector('.lc-favbrands-card');
            const scrollAmount = firstCard ? (firstCard.offsetWidth + 20) * 2 : 500;

            favBrandsList.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });
    }
});
</script>

@if($popupTestEnabled ?? true)
<div class="pa-beta-popup" id="paBetaPopup">
    <div class="pa-beta-popup-backdrop" id="paBetaPopupBackdrop"></div>

    <div class="pa-beta-popup-dialog" role="dialog" aria-modal="true" aria-labelledby="paBetaPopupTitle">
        <button type="button" class="pa-beta-popup-close" id="paBetaPopupClose" aria-label="Đóng">
            <i class="ri-close-line" aria-hidden="true"></i>
        </button>

        <div class="pa-beta-popup-icon">
            <i class="ri-flask-line" aria-hidden="true"></i>
        </div>

        <h3 class="pa-beta-popup-title" id="paBetaPopupTitle">Website đang trong giai đoạn thử nghiệm</h3>

        <p class="pa-beta-popup-desc">
            Nhà thuốc Phương Anh đang trong quá trình hoàn thiện website. Một số chức năng có thể chưa hoạt động hoàn hảo.
            Rất mong nhận được góp ý của bạn để chúng tôi cải thiện trải nghiệm tốt hơn!
        </p>

        <div class="pa-beta-popup-actions">
            <a href="https://zalo.me/4374437222076872555" target="_blank" rel="noopener" class="pa-beta-popup-btn pa-beta-popup-btn-outline">
                <i class="ri-chat-3-line" aria-hidden="true"></i>
                Góp ý qua Zalo
            </a>

            <button type="button" class="pa-beta-popup-btn pa-beta-popup-btn-primary" id="paBetaPopupOk">
                Đã hiểu, tiếp tục
            </button>

            <button type="button" class="pa-beta-popup-btn pa-beta-popup-btn-text" id="paBetaPopupNeverShow">
                Không hiển thị lại
            </button>
        </div>
    </div>
</div>

<style>
    .pa-beta-popup{
        position: fixed;
        inset: 0;
        z-index: 10050;
        display: none;
    }

    .pa-beta-popup.show{
        display: block;
    }

    .pa-beta-popup-backdrop{
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, .5);
        backdrop-filter: blur(2px);
    }

    .pa-beta-popup-dialog{
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%) translateY(100%);
        width: 100%;
        max-width: 440px;
        background: #fff;
        border-radius: 24px 24px 0 0;
        padding: 28px 22px 22px;
        box-shadow: 0 -10px 40px rgba(15, 23, 42, .25);
        transition: transform .3s ease;
    }

    .pa-beta-popup.show .pa-beta-popup-dialog{
        transform: translateX(-50%) translateY(0);
    }

    .pa-beta-popup-close{
        position: absolute;
        top: 14px;
        right: 14px;
        width: 36px;
        height: 36px;
        border: 0;
        border-radius: 50%;
        background: #f1f5f9;
        color: #0f172a;
        font-size: 18px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .pa-beta-popup-icon{
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #e0f7f3 0%, #eefdf7 100%);
        color: #0c8f75;
        font-size: 26px;
        margin-bottom: 14px;
    }

    .pa-beta-popup-title{
        margin: 0 0 8px;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.35;
    }

    .pa-beta-popup-desc{
        margin: 0 0 18px;
        font-size: 14px;
        line-height: 1.6;
        color: #475569;
    }

    .pa-beta-popup-actions{
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .pa-beta-popup-btn{
        min-height: 46px;
        border-radius: 999px;
        border: 0;
        font-size: 14px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        text-decoration: none;
    }

    .pa-beta-popup-btn-primary{
        background: linear-gradient(135deg, #0c8f75 0%, #0c585c 100%);
        color: #fff;
        box-shadow: 0 12px 24px rgba(12, 143, 117, .25);
    }

    .pa-beta-popup-btn-outline{
        background: #f8fafc;
        color: #0c585c;
        border: 1px solid #dbe7e5;
    }

    .pa-beta-popup-btn-text{
        background: transparent;
        color: #94a3b8;
        min-height: 36px;
        font-weight: 600;
        font-size: 13px;
    }

    .pa-beta-popup-btn-text:hover{
        color: #64748b;
        text-decoration: underline;
    }

    @media (min-width: 768px){
        .pa-beta-popup{
            display: none !important;
        }
    }
</style>

<script>
    (function () {
        var STORAGE_KEY = 'paBetaPopupNeverShow';

        var isMobileUserAgent = /Android|iPhone|iPad|iPod|Mobile|Windows Phone/i.test(navigator.userAgent || '');
        var isNarrowViewport = window.matchMedia('(max-width: 767px)').matches;
        var isMobile = isMobileUserAgent && isNarrowViewport;

        if (!isMobile || localStorage.getItem(STORAGE_KEY)) {
            return;
        }

        var popup = document.getElementById('paBetaPopup');
        var backdrop = document.getElementById('paBetaPopupBackdrop');
        var closeBtn = document.getElementById('paBetaPopupClose');
        var okBtn = document.getElementById('paBetaPopupOk');
        var neverShowBtn = document.getElementById('paBetaPopupNeverShow');

        function closePopup() {
            popup.classList.remove('show');
        }

        function neverShowAgain() {
            localStorage.setItem(STORAGE_KEY, '1');
            closePopup();
        }

        setTimeout(function () {
            popup.classList.add('show');
        }, 600);

        closeBtn.addEventListener('click', closePopup);
        backdrop.addEventListener('click', closePopup);
        okBtn.addEventListener('click', closePopup);
        neverShowBtn.addEventListener('click', neverShowAgain);
    })();
</script>
@endif
</body>

</html>
