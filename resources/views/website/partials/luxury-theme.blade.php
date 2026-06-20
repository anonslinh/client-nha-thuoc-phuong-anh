<style>
    :root {
        --pa-luxury-font: "Be Vietnam Pro", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        --pa-luxury-display: "Manrope", "Be Vietnam Pro", system-ui, sans-serif;
        --pa-luxury-ink: #0b2430;
        --pa-luxury-deep: #073f45;
        --pa-luxury-teal: #0f8b7c;
        --pa-luxury-teal-2: #14b18e;
        --pa-luxury-gold: #C8A45D;
        --pa-luxury-line: rgba(9, 47, 48, .12);
    }

    html,
    body {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }

    body {
        font-family: var(--pa-luxury-font) !important;
        color: var(--pa-luxury-ink) !important;
        background: linear-gradient(180deg, #f8fcfb 0%, #eef8f5 42%, #ffffff 100%) !important;
        text-rendering: optimizeLegibility;
    }

    body * {
        letter-spacing: 0 !important;
    }

    main {
        min-height: 60vh;
        background: linear-gradient(180deg, #f8fcfb 0%, #ffffff 34%, #f4faf8 100%) !important;
        overflow-x: hidden;
    }

    .lc-container,
    .wc-container,
    .fs-container,
    .pa-container {
        width: min(1320px, calc(100% - 32px)) !important;
        max-width: 1320px !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .lc-header {
        position: sticky !important;
        top: 0 !important;
        z-index: 80 !important;
        filter: drop-shadow(0 14px 34px rgba(6, 47, 51, .10));
    }

    .lc-header-hero {
        background: linear-gradient(120deg, rgba(7, 63, 69, .98) 0%, rgba(10, 91, 92, .96) 46%, rgba(15, 139, 124, .94) 100%) !important;
        color: #ffffff !important;
        overflow: hidden !important;
    }

    .lc-header-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.08) 50%, transparent 100%);
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

    .lc-logo,
    .lc-logo-text-main,
    .lc-logo-text-sub,
    .lc-header-actions,
    .lc-header-actions a,
    .lc-header-actions button {
        color: #ffffff !important;
    }

    .lc-logo-mark,
    .lc-link-user-icon,
    .lc-btn-cart-icon {
        background: rgba(255,255,255,.96) !important;
        box-shadow: 0 12px 30px rgba(0, 0, 0, .13) !important;
    }

    .lc-search-bar {
        border-radius: 999px !important;
        background: rgba(255,255,255,.98) !important;
        border: 1px solid rgba(255,255,255,.70) !important;
        box-shadow: 0 16px 40px rgba(3, 40, 44, .18) !important;
        overflow: hidden !important;
    }

    .lc-search-input,
    .lc-search-bar input {
        color: var(--pa-luxury-ink) !important;
        font-family: var(--pa-luxury-font) !important;
    }

    .lc-header-nav {
        background: rgba(255,255,255,.94) !important;
        border-bottom: 1px solid rgba(9, 47, 48, .10) !important;
        box-shadow: 0 10px 28px rgba(9, 47, 48, .08) !important;
        backdrop-filter: blur(14px);
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

    [class*="breadcrumb"],
    .lc-breadcrumb,
    .wc-breadcrumb {
        font-family: var(--pa-luxury-font) !important;
        color: #64748b !important;
        font-weight: 650 !important;
    }

    [class*="breadcrumb"] a,
    .lc-breadcrumb a,
    .wc-breadcrumb a {
        color: var(--pa-luxury-teal) !important;
        text-decoration: none !important;
    }

    .lc-product-detail-page,
    .wc-page,
    .lc-maincat-page,
    .pa-flash-page,
    .lc-flash-page,
    .fs-page,
    .lc-search-page,
    .lc-cart-page,
    .lc-checkout-page,
    .lc-health-page,
    .lc-disease-page,
    .lc-branch-page,
    .lc-order-page,
    .lc-reward-page,
    .lc-prescription-page,
    .lc-consult-page {
        background: linear-gradient(180deg, #f8fcfb 0%, #ffffff 44%, #f4faf8 100%) !important;
        padding-top: 30px !important;
        padding-bottom: 54px !important;
        color: var(--pa-luxury-ink) !important;
    }

    .lc-product-title,
    .wc-hero__title,
    .lc-maincat-title,
    .lc-section-title,
    .lc-section-heading,
    .lc-detail-title,
    h1, h2, h3 {
        font-family: var(--pa-luxury-display) !important;
        color: var(--pa-luxury-ink);
    }

    .lc-product-title,
    .wc-hero__title,
    .lc-maincat-title {
        font-size: clamp(30px, 3vw, 46px) !important;
        line-height: 1.14 !important;
        font-weight: 900 !important;
    }

    .lc-maincat-head,
    .wc-hero,
    .pa-flash-hero,
    .fs-hero,
    .lc-page-hero {
        position: relative;
        border-radius: 8px !important;
        background: linear-gradient(135deg, #082e36 0%, #0a6466 58%, #0f8b7c 100%) !important;
        border: 1px solid rgba(255,255,255,.22) !important;
        box-shadow: 0 28px 78px rgba(8, 46, 54, .20) !important;
        overflow: hidden !important;
    }

    .lc-maincat-head *,
    .wc-hero *,
    .pa-flash-hero *,
    .fs-hero *,
    .lc-page-hero * {
        color: #ffffff !important;
    }

    .lc-maincat-head::after,
    .wc-hero::after,
    .pa-flash-hero::after,
    .fs-hero::before,
    .lc-page-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: linear-gradient(115deg, transparent 0%, rgba(255,255,255,.20) 48%, transparent 68%);
        transform: translateX(-120%);
        animation: paLuxurySweep 8s ease-in-out infinite;
    }

    .lc-gallery-card,
    .lc-info-card,
    .lc-detail-card,
    .lc-related-card-wrap,
    .wc-card,
    .wc-filter-card,
    .lc-maincat-content,
    .lc-subcat-card,
    .lc-sidebar-card,
    .lc-card,
    .pa-card,
    .product-card,
    .fs-stat-card,
    .fs-product-card,
    .fs-countdown-card,
    .fs-session-tab,
    [class*="product-card"],
    [class*="filter-card"],
    [class*="info-card"],
    [class*="detail-card"] {
        border-radius: 8px !important;
        background: rgba(255,255,255,.96) !important;
        border: 1px solid rgba(9,47,48,.10) !important;
        box-shadow: 0 14px 36px rgba(9,47,48,.08) !important;
    }

    .lc-gallery-card,
    .lc-info-card,
    .lc-detail-card,
    .lc-related-card-wrap,
    .wc-card,
    .lc-subcat-card,
    .fs-product-card,
    .fs-session-tab,
    [class*="product-card"] {
        transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease, filter .28s ease !important;
    }

    .lc-gallery-card:hover,
    .lc-info-card:hover,
    .lc-detail-card:hover,
    .wc-card:hover,
    .lc-subcat-card:hover,
    .fs-product-card:hover,
    .fs-session-tab:hover,
    [class*="product-card"]:hover {
        border-color: rgba(15,139,124,.34) !important;
        box-shadow: 0 26px 64px rgba(9,47,48,.14) !important;
        filter: saturate(1.03);
    }

    .lc-main-image-wrap,
    .lc-thumb-item,
    .lc-subcat-icon,
    .lc-product-image-wrap,
    .wc-product-image,
    [class*="image-wrap"],
    [class*="product-image"] {
        border-radius: 8px !important;
        background: linear-gradient(180deg, #ffffff 0%, #f0faf5 100%) !important;
    }

    .lc-price-sale,
    .wc-product-price-sale,
    .lc-product-price-sale,
    [class*="price-sale"] {
        color: #0b5f64 !important;
        font-weight: 900 !important;
    }

    .lc-price-original,
    .wc-product-price-original,
    [class*="price-original"] {
        color: #94a3b8 !important;
    }

    .lc-brand-chip,
    .lc-flash-sale-pill,
    .lc-stock-pill,
    .wc-hero__eyebrow,
    .fs-hero-badge,
    .fs-session-status,
    .wc-filter-chip,
    .lc-tag,
    [class*="pill"],
    [class*="badge"] {
        border-radius: 999px !important;
        font-family: var(--pa-luxury-font) !important;
        font-weight: 850 !important;
    }

    .lc-brand-chip,
    .wc-filter-chip,
    .lc-tag {
        background: rgba(15,139,124,.08) !important;
        border: 1px solid rgba(15,139,124,.15) !important;
        color: var(--pa-luxury-teal) !important;
    }

    a[class*="btn"],
    button[class*="btn"],
    .lc-add-cart-btn,
    .lc-buy-now-btn,
    .lc-product-btn-buy,
    .lc-action-btn,
    .lc-related-btn,
    .wc-product__btn,
    .wc-product-btn,
    .lc-product-buy,
    .lc-product-search-btn,
    .fs-buy-btn,
    .pa-button,
    .btn-primary {
        border-radius: 999px !important;
        font-family: var(--pa-luxury-font) !important;
        font-weight: 900 !important;
        text-decoration: none !important;
    }

    .lc-add-cart-btn,
    .lc-buy-now-btn,
    .lc-product-btn-buy,
    .lc-action-btn.primary,
    .lc-related-btn,
    .wc-product__btn,
    .wc-product-btn,
    .lc-product-buy,
    .lc-product-search-btn,
    .fs-buy-btn:not(.fs-buy-btn--disabled),
    .btn-primary,
    button[type="submit"]:not(.lc-search-submit-btn) {
        background: linear-gradient(135deg, #0f8b7c 0%, #14b18e 100%) !important;
        color: #ffffff !important;
        border: 0 !important;
        box-shadow: 0 14px 30px rgba(15,139,124,.20) !important;
    }

    .lc-add-cart-btn:hover,
    .lc-buy-now-btn:hover,
    .lc-product-btn-buy:hover,
    .lc-action-btn.primary:hover,
    .lc-related-btn:hover,
    .wc-product__btn:hover,
    .wc-product-btn:hover,
    .lc-product-buy:hover,
    .lc-product-search-btn:hover,
    .fs-buy-btn:not(.fs-buy-btn--disabled):hover,
    .btn-primary:hover,
    button[type="submit"]:not(.lc-search-submit-btn):hover {
        background: linear-gradient(135deg, #16ad94 0%, #074d55 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 18px 38px rgba(15,139,124,.28) !important;
        transform: translateY(-1px);
    }

    .lc-action-btn.secondary {
        background: rgba(15,139,124,.10) !important;
        color: var(--pa-luxury-teal) !important;
        box-shadow: none !important;
        border: 1px solid rgba(15,139,124,.14) !important;
    }

    .lc-action-btn.secondary:hover {
        background: rgba(15,139,124,.16) !important;
        color: #074d55 !important;
    }

    .lc-qty-btn,
    .lc-tab-btn,
    .lc-sort-btn,
    .fs-session-tab {
        border-radius: 999px !important;
        font-family: var(--pa-luxury-font) !important;
    }

    .lc-tab-btn.is-active,
    .lc-sort-btn.is-active,
    .fs-session-tab--active {
        background: linear-gradient(135deg, rgba(15,139,124,.14), rgba(198,155,74,.10)) !important;
        color: var(--pa-luxury-teal) !important;
        border-color: rgba(15,139,124,.38) !important;
        box-shadow: 0 14px 28px rgba(9,47,48,.09) !important;
    }

    .fs-session-tab--active .fs-session-status {
        background: rgba(15,139,124,.12) !important;
        color: var(--pa-luxury-teal) !important;
    }

    .fs-buy-btn--disabled {
        background: #edf5f3 !important;
        color: #7b8f98 !important;
        box-shadow: none !important;
    }

    .fs-discount-badge,
    .lc-price-discount,
    .lc-flash-sale-pill {
        background: linear-gradient(135deg, #ff6a3d 0%, #e23d2b 100%) !important;
        color: #ffffff !important;
    }

    .fs-page .fs-toolbar {
        grid-template-columns: minmax(0, 1fr) minmax(300px, 360px) !important;
        align-items: center !important;
        gap: 16px !important;
    }

    .fs-page .fs-session-tabs {
        align-items: stretch !important;
        gap: 12px !important;
        min-width: 0 !important;
        padding: 4px 2px 8px !important;
    }

    .fs-page .fs-session-tab {
        flex: 0 0 150px !important;
        min-width: 150px !important;
        max-width: 150px !important;
        min-height: 112px !important;
        border-radius: 8px !important;
        padding: 14px 14px 12px !important;
        background: rgba(255,255,255,.96) !important;
        color: var(--pa-luxury-ink) !important;
        border: 1px solid rgba(9,47,48,.10) !important;
        box-shadow: 0 14px 32px rgba(9,47,48,.08) !important;
        transform: none !important;
    }

    .fs-page .fs-session-tab:hover {
        transform: translateY(-2px) !important;
        border-color: rgba(15,139,124,.34) !important;
    }

    .fs-page .fs-session-tab--active {
        background: linear-gradient(135deg, rgba(15,139,124,.14), rgba(198,155,74,.10)) !important;
        color: var(--pa-luxury-teal) !important;
        border-color: rgba(15,139,124,.38) !important;
        box-shadow: 0 18px 38px rgba(9,47,48,.12) !important;
    }

    .fs-page .fs-session-time,
    .fs-page .fs-session-date {
        color: inherit !important;
    }

    .fs-page .fs-session-status {
        border-radius: 999px !important;
        background: #eef5f3 !important;
        color: #64748b !important;
    }

    .fs-page .fs-session-tab--active .fs-session-status {
        background: rgba(15,139,124,.12) !important;
        color: var(--pa-luxury-teal) !important;
    }

    .fs-page .fs-countdown-card {
        border-radius: 8px !important;
        min-height: 76px !important;
        justify-content: center !important;
    }

    input,
    select,
    textarea {
        border-radius: 8px !important;
        border-color: rgba(9,47,48,.14) !important;
        font-family: var(--pa-luxury-font) !important;
    }

    input:focus,
    select:focus,
    textarea:focus {
        border-color: rgba(15,139,124,.55) !important;
        box-shadow: 0 0 0 4px rgba(15,139,124,.10) !important;
        outline: 0 !important;
    }

    .lc-product-hero {
        gap: 26px !important;
    }

    .lc-info-card {
        position: relative;
        overflow: hidden;
    }

    .lc-info-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--pa-luxury-teal), var(--pa-luxury-gold));
    }

    .lc-detail-card h2,
    .lc-detail-card h3,
    .lc-related-title,
    .wc-filter-title,
    .wc-section-title {
        font-size: clamp(22px, 2vw, 30px) !important;
        font-weight: 900 !important;
    }

    .wc-layout,
    .lc-maincat-layout {
        gap: 24px !important;
    }

    .wc-product-grid,
    .lc-maincat-products,
    .lc-product-grid,
    [class*="product-grid"] {
        gap: 18px !important;
    }

    .lc-footer {
        margin-top: 0 !important;
        background: #082e36 !important;
    }

    .lc-footer-top {
        background: linear-gradient(135deg, #0f8b7c 0%, #0a6466 100%) !important;
        border-bottom: 1px solid rgba(255,255,255,.14) !important;
        overflow: hidden;
    }

    .lc-footer-main {
        background: linear-gradient(180deg, #082e36 0%, #061f27 100%) !important;
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
        color: #C8A45D !important;
    }

    .pa-luxury-reveal-ready .pa-luxury-reveal {
        opacity: 0;
        transform: translateY(24px) scale(.985);
        transition: opacity .72s cubic-bezier(.2,.78,.2,1), transform .72s cubic-bezier(.2,.78,.2,1);
    }

    .pa-luxury-reveal-ready .pa-luxury-visible {
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

    @media (max-width: 991px) {
        .lc-product-hero,
        .wc-layout,
        .lc-maincat-layout {
            grid-template-columns: 1fr !important;
        }
    }

    @media (max-width: 767px) {
        .lc-container,
        .wc-container,
        .fs-container,
        .pa-container {
            width: calc(100% - 24px) !important;
        }

        .lc-header {
            position: relative !important;
        }

        .lc-header-main {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 12px 0 !important;
            gap: 12px !important;
        }

        .lc-logo {
            min-width: 0 !important;
            flex: 1 1 calc(100% - 126px) !important;
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
            flex: 0 0 auto !important;
            width: auto !important;
            display: inline-flex !important;
            justify-content: flex-end !important;
            gap: 8px !important;
        }

        .lc-header-actions .lc-link-user,
        .lc-header-actions .lc-btn-cart,
        .lc-mobile-menu-trigger {
            width: 42px !important;
            height: 42px !important;
            min-width: 42px !important;
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
            width: 42px !important;
            height: 42px !important;
            min-width: 42px !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        .lc-search-wrap {
            flex: 1 0 100% !important;
            width: 100% !important;
        }

        .lc-search-suggestions {
            display: none !important;
        }

        .lc-product-detail-page,
        .wc-page,
        .lc-maincat-page,
        .pa-flash-page,
        .fs-page,
        .lc-search-page,
        .lc-cart-page,
        .lc-checkout-page {
            padding-top: 22px !important;
            padding-bottom: 34px !important;
        }

        .lc-product-title,
        .wc-hero__title,
        .lc-maincat-title {
            font-size: 26px !important;
        }

        .fs-page .fs-toolbar {
            grid-template-columns: 1fr !important;
        }

        .fs-page .fs-session-tab {
            flex-basis: 138px !important;
            min-width: 138px !important;
            max-width: 138px !important;
            min-height: 104px !important;
        }

        .lc-maincat-page .lc-product-grid,
        .wc-page .wc-products-grid,
        .wc-products-grid,
        .lc-product-grid,
        .wc-product-grid,
        .lc-maincat-products,
        [class*="product-grid"] {
            grid-template-columns: minmax(0, 1fr) !important;
            gap: 14px !important;
        }

        .lc-maincat-page .lc-product-card,
        .wc-page .wc-product,
        .wc-product,
        .lc-product-card,
        .product-card,
        [class*="product-card"] {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
        }
    }
</style>
