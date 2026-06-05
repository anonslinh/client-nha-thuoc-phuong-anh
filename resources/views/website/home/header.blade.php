<head>
    <meta charset="UTF-8" />
    <title>Nhà thuốc Phương Anh - Cao Bằng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <link href="phuonganh/img/logo-pa.png" rel="icon">
    <style>
        :root {
            --lc-blue: #0050c8;
            --lc-blue-light: #0b74ff;
            --lc-blue-deep: #003b9a;
            --lc-white: #ffffff;
            --lc-gray-bg: #f3f6ff;
            --lc-gray-text: #64748b;
            --lc-border-soft: rgba(255, 255, 255, 0.28);
            --lc-radius-pill: 999px;
            --lc-radius-lg: 24px;
            --lc-shadow-soft: 0 12px 30px rgba(15, 23, 42, 0.28);
            --container-width: 80%;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "SF Pro Text",
                "Helvetica Neue", Arial, sans-serif;
            background: var(--lc-gray-bg);
            color: #0f172a;
            line-height: 1.5;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        .lc-container {
            width: var(--container-width);
            margin: 0 auto;
            max-width: 1320px;
        }

        /* ============= HEADER ============= */
        .lc-header {
            position: relative;
            z-index: 50;
            font-size: 14px;
        }

        /* Top + middle: dùng 1 ảnh nền chung */
        .lc-header-hero {
            position: relative;
            color: var(--lc-white);
            padding-bottom: 18px;
            background: url("phuonganh/img/header-bg-placeholder.png") center/cover no-repeat !important;
            /* TODO: thay ảnh header */
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }

        /* Overlay gradient để chữ rõ hơn trên ảnh */
        .lc-header-hero::before {
            content: none !important;
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 0 0,
                    rgba(255, 255, 255, 0.14),
                    transparent 55%),
                linear-gradient(135deg,
                    rgba(59, 130, 246, 0.9),
                    rgba(37, 99, 235, 0.95));
            mix-blend-mode: multiply;
            opacity: 0.95;
            pointer-events: none;
        }

        .lc-header-hero>.lc-container {
            position: relative;
            /* đè lên overlay */
            z-index: 1;
        }

        /* ---------- Top bar ---------- */
        .lc-header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0 4px;
            font-size: 13px;
        }

        .lc-header-top-left,
        .lc-header-top-right {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.9);
        }

        .lc-header-top-left-icon {
            font-size: 16px;
        }

        .lc-header-top-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            transition: opacity 0.2s ease;
        }

        .lc-header-top-link strong {
            text-decoration: underline;
        }

        .lc-header-top-link:hover {
            opacity: 0.8;
        }

        .lc-header-top-sep {
            opacity: 0.55;
        }

        /* ---------- Middle: logo + search + actions ---------- */
        .lc-header-main {
            display: grid;
            grid-template-columns: minmax(0, 260px) minmax(0, 1fr) minmax(0, 260px);
            gap: 18px;
            align-items: center;
            padding: 8px 0 6px;
        }

        /* Logo */
        .lc-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .lc-logo-mark {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            /* background: linear-gradient(135deg, #0ea5e9, #22c55e, #f97316); */
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0f172a;
            font-weight: 700;
            font-size: 11px;
        }

        .lc-logo-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .lc-logo-text span {
            font-size: 11px;
            letter-spacing: 0.06em;
            opacity: 0.9;
            text-transform: uppercase;
        }

        .lc-logo-text strong {
            font-size: 16px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            line-height: 1.2;
        }

        /* Search area */
        .lc-search-wrap {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .lc-search-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--lc-white);
            border-radius: var(--lc-radius-pill);
            padding: 6px 14px 6px 18px;
            box-shadow: var(--lc-shadow-soft);
        }

        .lc-search-input-wrap {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .lc-search-icon {
            font-size: 18px;
            color: var(--lc-blue);
        }

        .lc-search-input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 14px;
            color: #0f172a;
        }

        .lc-search-input::placeholder {
            color: #9ca3af;
        }

        .lc-search-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lc-icon-btn {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f9fafb;
            color: #4b5563;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.1s ease, box-shadow 0.2s ease;
        }

        .lc-icon-btn:hover {
            background: #eff6ff;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
            transform: translateY(-1px);
        }

        .lc-search-suggestions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.9);
            opacity: 0.92;
        }

        .lc-search-suggestions span,
        .lc-search-suggestions a {
            cursor: pointer;
            position: relative;
            color: inherit;
            text-decoration: none;
        }

        .lc-search-suggestions span::after,
        .lc-search-suggestions a::after {
            content: "•";
            margin: 0 4px;
            opacity: 0.5;
        }

        .lc-search-suggestions span:last-child::after,
        .lc-search-suggestions a:last-child::after {
            content: "";
            margin: 0;
        }

        .lc-search-suggestions a:hover {
            text-decoration: underline;
        }

        /* Right actions */
        .lc-header-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            font-size: 14px;
        }

        .lc-link-user {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: var(--lc-radius-pill);
            cursor: pointer;
            transition: background 0.2s ease, transform 0.1s ease;
        }

        .lc-link-user-icon {
            font-size: 16px;
        }

        .lc-link-user:hover {
            background: rgba(15, 23, 42, 0.1);
            transform: translateY(-1px);
        }

        .lc-btn-cart {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: var(--lc-radius-pill);
            font-weight: 600;
            background: var(--lc-white);
            color: var(--lc-blue-deep);
            border: none;
            cursor: pointer;
            box-shadow: var(--lc-shadow-soft);
            transition: transform 0.12s ease, box-shadow 0.12s ease,
                background 0.2s ease;
            white-space: nowrap;
        }

        .lc-btn-cart-icon {
            font-size: 17px;
        }

        .lc-btn-cart:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.38);
            background: #e0edff;
        }

        /* ---------- Bottom nav ---------- */
        .lc-header-nav {
            background: var(--lc-white);
            box-shadow: 0 1px 0 rgba(15, 23, 42, 0.08);
        }

        .lc-header-nav-inner {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 22px;
            padding: 10px 0;
            font-size: 14px;
            font-weight: 500;
            color: #111827;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .lc-header-nav-inner::-webkit-scrollbar {
            display: none;
        }

        .lc-nav-item {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 0;
            cursor: pointer;
            white-space: nowrap;
        }

        .lc-nav-item span {
            display: inline-block;
        }

        .lc-nav-item--has-dropdown::after {
            content: "▾";
            font-size: 11px;
            color: #6b7280;
            margin-left: 2px;
        }

        .lc-nav-item::before {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--lc-blue), var(--lc-blue-light));
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.18s ease-out;
        }

        .lc-nav-item:hover::before,
        .lc-nav-item--active::before {
            transform: scaleX(1);
        }

        .lc-nav-item--active {
            color: var(--lc-blue);
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 992px) {
            .lc-header-main {
                grid-template-columns: minmax(0, 1fr);
                grid-template-rows: auto auto auto;
            }

            .lc-header-actions {
                justify-content: flex-start;
            }

            .lc-container {
                width: 92%;
            }
        }

        @media (max-width: 640px) {
            .lc-header-top {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }

            .lc-search-bar {
                padding: 6px 10px;
            }

            .lc-btn-cart {
                padding-inline: 14px;
            }

            .lc-logo-text strong {
                font-size: 14px;
            }
        }

        /* ============= BANNER HERO BELOW HEADER ============= */
        .lc-banner {
            position: relative;
            color: #ffffff;
            margin: 0 0 32px;
            background: url("phuonganh/img/back-gp.png") center/cover no-repeat !important;
            /* TODO: thay bằng ảnh nền banner */
            background-size: cover;
            background-position: center;
            padding: 28px 0 32px;
            overflow: hidden;
        }

        /* 3. Đảm bảo không có opacity làm mờ toàn bộ con bên trong */
        .lc-banner,
        .lc-banner>.lc-container,
        .lc-banner-campaign,
        .lc-banner-main {
            opacity: 1 !important;
        }

        .lc-banner img {
            mix-blend-mode: normal !important;
            filter: none !important;
        }

        .lc-banner::before {
            content: none !important;
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 0 0, rgba(255, 255, 255, 0.16), transparent 55%),
                radial-gradient(circle at 100% 0, rgba(56, 189, 248, 0.45), transparent 60%),
                linear-gradient(135deg, rgba(30, 64, 175, 0.96), rgba(30, 64, 175, 0.9));
            mix-blend-mode: multiply;
            opacity: 0.98;
            pointer-events: none;
        }

        .lc-banner>.lc-container {
            position: relative;
            z-index: 1;
        }

        /* ---------- Hero campaign (đái tháo đường) ---------- */
        .lc-banner-campaign {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding-bottom: 24px;
        }

        .lc-banner-campaign-tag {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #003c3d;
            margin-bottom: 6px;
            font-weight: 800;
        }

        .lc-banner-campaign-title {
            font-size: clamp(20px, 2.5vw, 28px);
            font-weight: 800;
            text-transform: uppercase;
            line-height: 1.35;
            max-width: 760px;
            margin-bottom: 14px;
        }

        .lc-banner-campaign-title span {
            color: #e43d28;
        }

        .lc-banner-btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 22px;
            border-radius: 999px;
            border: none;
            background: linear-gradient(135deg, #28e2e4, #00f5ff);
            color: #1f2937;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
            transition: transform 0.12s ease, box-shadow 0.15s ease,
                filter 0.15s ease;
        }

        .lc-banner-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45);
            filter: brightness(1.05);
        }

        .lc-banner-campaign-avatars {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 80px;
            margin-top: 18px;
        }

        .lc-banner-avatar {
            width: 104px;
            height: 104px;
            border-radius: 999px;
            border: 3px solid rgba(255, 255, 255, 0.92);
            overflow: hidden;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.6);
            background: #0f172a;
        }

        .lc-banner-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .lc-banner-campaign-arrow {
            position: absolute;
            top: 48%;
            transform: translateY(-50%);
            width: 38px;
            height: 38px;
            border-radius: 999px;
            border: none;
            background: rgba(15, 23, 42, 0.75);
            color: #e5e7eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 10px 26px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            transition: background 0.15s ease, transform 0.1s ease,
                box-shadow 0.15s ease, opacity 0.15s ease;
        }

        .lc-banner-campaign-arrow:hover {
            background: rgba(15, 23, 42, 0.95);
            transform: translateY(-50%) translateY(-1px);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.6);
        }

        .lc-banner-campaign-arrow--prev {
            left: 0;
        }

        .lc-banner-campaign-arrow--next {
            right: 0;
        }

        /* ---------- Row 2: Slide sản phẩm + 2 banner nhỏ ---------- */
        .lc-banner-main {
            display: grid;
            grid-template-columns: minmax(0, 2.3fr) minmax(0, 1.15fr);
            gap: 18px;
            margin-top: 22px;
        }

        /* Slide sản phẩm */
        .lc-banner-product-slider {
            position: relative;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: var(--lc-shadow-soft);
            background: radial-gradient(circle at 100% 0, rgba(248, 250, 252, 0.06), transparent 50%), linear-gradient(135deg, #0b9398,#0f5c6c)
        }

        .lc-banner-product-track {
            display: flex;
            scroll-behavior: smooth;
            overflow: hidden;
        }

        .lc-banner-product-slide {
            min-width: 100%;
            /* padding: 22px 24px; */
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr);
            gap: 10px;
            align-items: center;
            color: #e5e7eb;
        }

        .lc-banner-product-info-eyebrow {
            font-size: 13px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #fbfbfb;
            margin-bottom: 6px;
        }

        .lc-banner-product-title {
            font-size: 20px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .lc-banner-product-sub {
            font-size: 13px;
            color: #cbd5f5;
            margin-bottom: 10px;
        }

        .lc-banner-product-benefits {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            font-size: 12px;
            margin-bottom: 12px;
        }

        .lc-banner-product-benefit {
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(15, 118, 110, 0.9);
            color: #ecfeff;
        }

        .lc-banner-product-cta-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .lc-banner-product-price-tag {
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid rgba(248, 250, 252, 0.12);
            font-size: 13px;
            color: #e5e7eb;
        }

        .lc-banner-btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 16px;
            border-radius: 999px;
            border: 1px solid rgba(248, 250, 252, 0.7);
            background: rgba(15, 23, 42, 0.4);
            color: #f9fafb;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            backdrop-filter: blur(8px);
            transition: background 0.15s ease, transform 0.1s ease,
                box-shadow 0.15s ease;
        }

        .lc-banner-btn-secondary:hover {
            background: rgba(15, 23, 42, 0.75);
            transform: translateY(-1px);
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.6);
        }

        .lc-banner-product-media {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .lc-banner-product-media-inner {
            width: 180px;
            max-width: 100%;
            border-radius: 20px;
            background: radial-gradient(circle at 0 0, rgba(248, 250, 252, 0.08), transparent 50%), linear-gradient(145deg, #218f93, #38bdf8);
            padding: 12px 10px;
            box-shadow: 0 14px 40px rgba(8, 47, 73, 0.9);
        }

        .lc-banner-product-media-inner img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 12px;
            background: #e5e7eb;
        }

        .lc-banner-product-dots {
            position: absolute;
            left: 16px;
            bottom: 10px;
            display: flex;
            gap: 6px;
        }

        .lc-banner-product-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: rgba(148, 163, 184, 0.8);
        }

        .lc-banner-product-dot--active {
            width: 16px;
            background: #e43d28;
        }

        .lc-banner-product-arrow {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: none;
            background: #f9fafb;
            color: #111827;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.65);
            transition: background 0.15s ease, transform 0.1s ease,
                box-shadow 0.15s ease;
        }

        .lc-banner-product-arrow:hover {
            background: #e5e7eb;
            transform: translateY(-50%) translateY(-1px);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.75);
        }

        /* 2 banner nhỏ bên phải */
        .lc-banner-side {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .lc-banner-side-card {
            border-radius: 20px;
            padding: 16px 18px;
            background: #f9fafb;
            color: #0f172a;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.35);
            overflow: hidden;
            position: relative;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .lc-banner-side-card::after {
            content: "";
            position: absolute;
            right: -30px;
            bottom: -40px;
            width: 120px;
            height: 120px;
            border-radius: 999px;
            background: radial-gradient(circle,
                    rgba(59, 130, 246, 0.2),
                    transparent 60%);
            opacity: 0.8;
            pointer-events: none;
        }

        .lc-banner-side-label {
            font-size: 11px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #0369a1;
            margin-bottom: 4px;
        }

        .lc-banner-side-title {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .lc-banner-side-text {
            font-size: 13px;
            color: #475569;
            max-width: 260px;
        }

        .lc-banner-side-logos {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .lc-banner-side-logo-pill {
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid #cbd5f5;
            font-size: 11px;
            color: #1e3a8a;
            background: rgba(239, 246, 255, 0.9);
        }

        .lc-banner-side-link {
            margin-top: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #b91c1c;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .lc-banner-side-link span {
            font-size: 15px;
        }

        /* ---------- Row 3: 6 quick actions ---------- */
        .lc-banner-quick-actions {
            margin-top: 26px;
            background: rgb(0 243 216 / 11%);
            border-radius: 20px;
            padding: 10px 12px;
            backdrop-filter: blur(10px);
        }

        .lc-quick-list {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 10px;
        }

        .lc-quick-item {
            border-width: 0px;
            background: #ffffff;
            color: #0f172a;
            border-radius: 18px;
            padding: 10px 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.35);
            transition: transform 0.12s ease, box-shadow 0.12s ease,
                background 0.15s ease;
        }

        .lc-quick-item-icon {
            font-size: 20px;
            margin-bottom: 4px;
        }

        .lc-quick-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.5);
            background: #eff6ff;
        }

        /* ---------- Responsive cho banner ---------- */
        @media (max-width: 992px) {
            .lc-banner-main {
                grid-template-columns: minmax(0, 1fr);
            }

            .lc-banner-campaign-avatars {
                gap: 32px;
            }

            .lc-banner-product-slide {
                grid-template-columns: minmax(0, 1fr);
            }

            .lc-banner-product-media {
                justify-content: flex-start;
            }

            .lc-banner-product-media-inner {
                width: 160px;
            }

            .lc-quick-list {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .lc-banner {
                padding: 20px 0 24px;
            }

            .lc-banner-campaign-avatars {
                display: none;
                /* mobile cho gọn, bạn có thể bật lại nếu muốn */
            }

            .lc-banner-main {
                gap: 14px;
            }

            .lc-quick-list {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .lc-banner-product-slide {
                padding: 18px 16px;
            }
        }

        /* ============= FLASH SALE ============= */
        .lc-flashsale {
            position: relative;
            margin: 0 0 32px;
            padding: 18px 0 38px;
            /* Ảnh nền full width phía sau, box đè lên */
            background-image: url("images/flashsale-bg-placeholder.jpg");
            /* TODO: thay ảnh nền Flash Sale */
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }

        .lc-flashsale::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 0 0, rgba(248, 250, 252, 0.12), transparent 55%),
                linear-gradient(135deg, rgba(30, 64, 175, 0.9), rgba(30, 64, 175, 0.88));
            mix-blend-mode: multiply;
            opacity: 0.9;
            pointer-events: none;
        }

        .lc-flashsale>.lc-container {
            position: relative;
            z-index: 1;
        }

        /* Box nội dung flashsale (trắng, đè lên ảnh nền) */
        .lc-flashsale-box {
            background: #ffffff;
            border-radius: 24px;
            /* box-shadow: 0 18px 50px rgba(15, 23, 42, 0.45); */
            padding: 18px 18px 18px;
            position: relative;
            overflow: hidden;
        }
        
        /* Dòng tab thời gian */
        .lc-flashsale-tabs {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            scrollbar-width: thin;
            padding-bottom: 4px;
            margin-bottom: 10px;
        }

        .lc-flashsale-tabs::-webkit-scrollbar {
            height: 4px;
        }

        .lc-flashsale-tabs::-webkit-scrollbar-thumb {
            background: #c4d0ff;
            border-radius: 999px;
        }

        .lc-flashsale-tab {
            min-width: 170px;
            padding: 8px 10px;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            display: flex;
            flex-direction: column;
            gap: 2px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.15s ease, border-color 0.15s ease,
                transform 0.1s ease, box-shadow 0.15s ease;
            flex-shrink: 0;
        }

        .lc-flashsale-tab-time {
            font-weight: 600;
            color: #111827;
        }

        .lc-flashsale-tab-date {
            color: #6b7280;
        }

        .lc-flashsale-tab-status {
            margin-top: 4px;
            align-self: flex-start;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
        }

        .lc-flashsale-tab-status--active {
            background: #fee2e2;
            color: #b91c1c;
        }

        .lc-flashsale-tab-status--upcoming {
            background: #eff6ff;
            color: #07a9bf;
        }

        .lc-flashsale-tab--active {
            background: #fee2e2;
            border-color: #f97316;
        }

        /* Dòng countdown */
        .lc-flashsale-countdown {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 8px 4px 8px;
            border-top: 1px dashed #e5e7eb;
            border-bottom: 1px dashed #e5e7eb;
            margin-bottom: 12px;
            font-size: 13px;
            color: #111827;
        }

        .lc-flashsale-countdown-label {
            font-weight: 500;
        }

        .lc-flashsale-timer {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .lc-flashsale-timer-box {
            min-width: 34px;
            padding: 4px 6px;
            border-radius: 10px;
            background: #b91c1c;
            color: #ffffff;
            font-weight: 700;
            text-align: center;
            letter-spacing: 0.04em;
        }

        .lc-flashsale-timer-sep {
            font-weight: 700;
            color: #b91c1c;
        }

        /* Slider sản phẩm */
        .lc-flashsale-products-wrap {
            position: relative;
            margin-bottom: 12px;
        }

        .lc-flashsale-products {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 4px;
            scrollbar-width: thin;
        }

        .lc-flashsale-products::-webkit-scrollbar {
            height: 6px;
        }

        .lc-flashsale-products::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 999px;
        }

        .lc-flashsale-next {
            position: absolute;
            right: -6px;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: none;
            background: #ffffff;
            color: #111827;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.4);
            cursor: pointer;
            transition: background 0.15s ease, transform 0.1s ease,
                box-shadow 0.15s ease;
        }

        .lc-flashsale-next:hover {
            background: #eff6ff;
            transform: translateY(-50%) translateY(-1px);
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.6);
        }

        /* Card sản phẩm flashsale */
        .lc-product-card--flash {
            position: relative;
            flex: 0 0 190px;
            /* chiều rộng mỗi card trong slider */
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 25px rgba(148, 163, 184, 0.38);
            padding: 10px 10px 12px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .lc-product-discount-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            padding: 2px 6px;
            border-radius: 999px;
            background: #dc2626;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            box-shadow: 0 8px 18px rgba(220, 38, 38, 0.7);
        }

        .lc-product-image-wrap {
            width: 100%;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
        }

        .lc-product-image-wrap img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            display: block;
            background: #f9fafb;
            border-radius: 8px;
        }

        .lc-product-name {
            font-size: 13px;
            font-weight: 500;
            color: #111827;
            height: 40px;
            line-height: 1.3;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .lc-product-price-row {
            display: flex;
            flex-direction: column;
            gap: 2px;
            font-size: 12px;
        }

        .lc-product-price-sale {
            color: #07a9bf;
            font-weight: 700;
        }

        .lc-product-price-original {
            color: #9ca3af;
            text-decoration: line-through;
        }

        .lc-product-unit-pill {
            align-self: flex-start;
            margin-top: 2px;
            padding: 3px 8px;
            border-radius: 999px;
            background: #f3f4f6;
            color: #4b5563;
            font-size: 11px;
        }

        .lc-product-btn-buy {
            margin-top: 8px;
            width: 100%;
            padding: 7px 0;
            border-radius: 999px;
            border: none;
            background: #0f766e;
            color: #f9fafb;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease, transform 0.1s ease,
                box-shadow 0.15s ease;
            box-shadow: 0 10px 22px rgba(15, 118, 110, 0.6);
        }

        .lc-product-btn-buy:hover {
            background: #115e59;
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(15, 118, 110, 0.8);
        }

        /* Link Xem tất cả */
        .lc-flashsale-viewall {
            text-align: center;
            font-size: 13px;
            margin-top: 2px;
        }

        .lc-flashsale-viewall a {
            color: #07a9bf;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* Responsive Flash Sale */
        @media (max-width: 992px) {
            .lc-flashsale-box {
                padding: 14px 12px 14px;
            }

            .lc-flashsale-next {
                display: none;
                /* mobile dùng cuộn tay là đủ */
            }

            .lc-product-card--flash {
                flex: 0 0 160px;
            }
        }

        @media (max-width: 640px) {
            .lc-flashsale-countdown {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* ============= SẢN PHẨM BÁN CHẠY ============= */
        .lc-bestseller {
            margin-top: 50px !important;
            margin: 0 0 32px;
            padding: 10px 0 34px;
            background: transparent;
            /* nền ngoài dùng màu body */
        }

        .lc-bestseller-box {
            position: relative;
            border-radius: 26px;
            padding: 32px 18px 18px;
            background:
                radial-gradient(circle at 0 0, rgba(255, 255, 255, 0.35), transparent 55%), linear-gradient(135deg, #06b6d4, #6dc7db);
            box-shadow: 0 20px 48px rgba(56, 221, 240, 0.55);
            /* overflow: hidden; */
        }

        /* Ribbon đỏ "Sản phẩm bán chạy" đè lên mép trên box */
        .lc-bestseller-heading-wrap {
            position: absolute;
            top: -16px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
        }

        .lc-bestseller-heading {
            padding: 6px 22px;
            border-radius: 999px;
            background: #dc2626;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            box-shadow: 0 12px 28px rgba(185, 28, 28, 0.7);
            white-space: nowrap;
        }

        /* Vùng slider sản phẩm bên trong box */
        .lc-bestseller-products-wrap {
            position: relative;
            margin-top: 10px;
        }

        .lc-bestseller-products {
            display: flex;
            gap: 14px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 6px 4px 6px;
            scrollbar-width: thin;
        }

        .lc-bestseller-products::-webkit-scrollbar {
            height: 6px;
        }

        .lc-bestseller-products::-webkit-scrollbar-thumb {
            background: rgba(191, 219, 254, 0.9);
            border-radius: 999px;
        }

        .lc-bestseller-next {
            position: absolute;
            right: -6px;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: none;
            background: #ffffff;
            color: #111827;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.5);
            cursor: pointer;
            transition: background 0.15s ease, transform 0.1s ease,
                box-shadow 0.15s ease;
        }

        .lc-bestseller-next:hover {
            background: #eff6ff;
            transform: translateY(-50%) translateY(-1px);
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.7);
        }

        /* Card sản phẩm best seller
       (tách riêng với flash sale để dễ chỉnh) */
        .lc-product-card--best {
            position: relative;
            flex: 0 0 200px;
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #e5e7eb;
            padding: 10px 10px 12px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .lc-product-card--best .lc-product-discount-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            padding: 2px 7px;
            border-radius: 999px;
            background: #dc2626;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            box-shadow: 0 8px 18px rgba(220, 38, 38, 0.7);
        }

        .lc-product-card--best .lc-product-image-wrap {
            width: 100%;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
        }

        .lc-product-card--best .lc-product-image-wrap img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            display: block;
            background: #f9fafb;
            border-radius: 10px;
        }

        .lc-product-card--best .lc-product-name {
            font-size: 13px;
            font-weight: 500;
            color: #111827;
            height: 40px;
            line-height: 1.3;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .lc-product-card--best .lc-product-price-row {
            display: flex;
            flex-direction: column;
            gap: 2px;
            font-size: 12px;
        }

        .lc-product-card--best .lc-product-price-sale {
            color: #07a9bf;
            font-weight: 700;
        }

        .lc-product-card--best .lc-product-price-original {
            color: #9ca3af;
            text-decoration: line-through;
        }

        .lc-product-card--best .lc-product-unit-pill {
            align-self: flex-start;
            margin-top: 2px;
            padding: 3px 8px;
            border-radius: 999px;
            background: #f3f4f6;
            color: #4b5563;
            font-size: 11px;
        }

        .lc-product-card--best .lc-product-btn-buy {
            margin-top: 8px;
            width: 100%;
            padding: 7px 0;
            border-radius: 999px;
            border: none;
            background: #07a9bf;
            color: #f9fafb;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease, transform 0.1s ease,
                box-shadow 0.15s ease;
        }

        .lc-product-card--best .lc-product-btn-buy:hover {
            background: #119da5;
            transform: translateY(-1px);
        }

        /* Responsive best seller */
        @media (max-width: 992px) {
            .lc-bestseller-box {
                padding: 28px 14px 14px;
            }

            .lc-product-card--best {
                flex: 0 0 180px;
            }

            .lc-bestseller-next {
                display: none;
                /* mobile cuộn tay */
            }
        }

        @media (max-width: 640px) {
            .lc-product-card--best {
                flex: 0 0 160px;
            }
        }

        /* ============= DANH MỤC NỔI BẬT ============= */
        .lc-featured {
            margin: 0 0 32px;
            padding: 10px 0 10px;
        }

        /* header chung cho các section */
        .lc-section-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
        }

        .lc-section-header-icon {
            width: 28px;
            height: 28px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #07a9bf;
            color: #ffffff;
            font-size: 16px;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.6);
        }

        .lc-section-header-title {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }

        .lc-featured-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 14px;
        }

        .lc-featured-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 14px 10px;
            box-shadow: 0 10px 24px rgba(148, 163, 184, 0.45);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            font-size: 13px;
            color: #111827;
        }

        .lc-featured-icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }

        .lc-featured-icon-circle img {
            width: 26px;
            height: 26px;
            object-fit: contain;
            display: block;
        }

        .lc-featured-name {
            font-weight: 600;
            margin-bottom: 2px;
        }

        .lc-featured-count {
            font-size: 12px;
            color: #6b7280;
        }

        /* Responsive grid */
        @media (max-width: 1200px) {
            .lc-featured-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .lc-featured-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .lc-featured-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* ============= THƯƠNG HIỆU YÊU THÍCH ============= */
        .lc-favbrands {
            margin: 0 0 32px;
            padding: 10px 0 30px;
        }

        .lc-favbrands-wrap {
            position: relative;
            margin-top: 4px;
        }

        .lc-favbrands-list {
            display: flex;
            gap: 14px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 4px 4px 6px;
            scrollbar-width: thin;
        }

        .lc-favbrands-list::-webkit-scrollbar {
            height: 6px;
        }

        .lc-favbrands-list::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 999px;
        }

        .lc-favbrands-card {
            flex: 0 0 220px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.45);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .lc-favbrands-top {
            width: 100%;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9fafb;
        }

        .lc-favbrands-top img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
        }

        .lc-favbrands-bottom {
            padding: 12px 10px 12px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .lc-favbrands-logo-pill {
            min-width: 120px;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #111827;
        }

        .lc-favbrands-logo-pill img {
            width: 26px;
            height: 26px;
            object-fit: contain;
            display: block;
        }

        .lc-favbrands-discount {
            font-size: 13px;
            color: #07a9bf;
            font-weight: 600;
        }

        .lc-favbrands-next {
            position: absolute;
            right: -6px;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: none;
            background: #ffffff;
            color: #111827;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.5);
            cursor: pointer;
            transition: background 0.15s ease, transform 0.1s ease,
                box-shadow 0.15s ease;
        }

        .lc-favbrands-next:hover {
            background: #eff6ff;
            transform: translateY(-50%) translateY(-1px);
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.7);
        }

        @media (max-width: 992px) {
            .lc-favbrands-card {
                flex: 0 0 200px;
            }

            .lc-favbrands-next {
                display: none;
                /* mobile cuộn tay */
            }
        }

        @media (max-width: 640px) {
            .lc-favbrands-card {
                flex: 0 0 180px;
            }
        }

        /* ============= BỆNH THEO MÙA ============= */
        .lc-season {
            margin: 0 0 32px;
            padding: 10px 0 36px;
        }

        .lc-season-box {
            position: relative;
            border-radius: 28px;
            padding: 16px 18px 20px;
            background:
                radial-gradient(circle at 0 0, rgba(255, 255, 255, 0.35), transparent 55%), linear-gradient(135deg, #06b6d4, #6dc7db);
            box-shadow: 0 22px 52px rgba(15, 23, 42, 0.6);
            overflow: hidden;
        }

        .lc-season-box::before {
            content: "";
            position: absolute;
            inset: -40%;
            background:
                radial-gradient(circle at 0 0, rgba(248, 250, 252, 0.22), transparent 60%),
                radial-gradient(circle at 100% 100%, rgba(15, 23, 42, 0.3), transparent 55%);
            opacity: 0.55;
            pointer-events: none;
        }

        .lc-season-box-inner {
            position: relative;
            z-index: 1;
        }

        /* Tabs bệnh theo mùa */
        .lc-season-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 14px;
            flex-wrap: wrap;
        }

        .lc-season-tab {
            position: relative;
            padding: 7px 16px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            background: rgba(15, 23, 42, 0.1);
            color: #e5e7eb;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            backdrop-filter: blur(6px);
            transition: background 0.15s ease, border-color 0.15s ease,
                box-shadow 0.15s ease, transform 0.1s ease, color 0.15s ease;
            white-space: nowrap;
        }

        .lc-season-tab--active {
            background: #ffffff;
            color: #111827;
            border-color: #f97316;
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.6);
            transform: translateY(-1px);
        }

        /* Panel nội dung mỗi bệnh */
        .lc-season-panel {
            display: flex;
            gap: 18px;
            align-items: stretch;
        }

        .lc-season-panel:not(.is-active) {
            display: none;
        }

        /* Khối info bên trái (giống tờ giấy cong) */
        .lc-season-info {
            flex: 0 0 34%;
            min-width: 290px;
            max-width: 380px;
            background: linear-gradient(180deg, #ffffff, #f9fafb);
            border-radius: 26px;
            padding: 20px 18px 18px;
            position: relative;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.4);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .lc-season-info::after {
            /* hiệu ứng giấy cuộn góc phải dưới */
            content: "";
            position: absolute;
            width: 180px;
            height: 110px;
            right: -60px;
            bottom: -60px;
            background:
                radial-gradient(circle at 0 0, rgba(156, 163, 175, 0.3), transparent 60%),
                radial-gradient(circle at 100% 100%, #ffffff 0, #f3f4f6 60%, transparent 80%);
            transform: rotate(-14deg);
            opacity: 0.9;
        }

        .lc-season-info-title {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .lc-season-info-body {
            font-size: 14px;
            color: #111827;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        .lc-season-info-body strong {
            font-weight: 700;
        }

        .lc-season-info-cta {
            margin-top: 14px;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .lc-season-cta-btn {
            padding: 9px 18px;
            border-radius: 999px;
            border: none;
            background: #07a9bf;
            color: #f9fafb;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.75);
            transition: background 0.15s ease, transform 0.1s ease,
                box-shadow 0.15s ease;
            white-space: nowrap;
        }

        .lc-season-cta-btn:hover {
            background: #1e40af;
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(30, 64, 175, 0.9);
        }

        .lc-season-mascot {
            flex-shrink: 0;
            width: 64px;
            height: 64px;
            border-radius: 999px;
            background: #0ea5e9;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 24px rgba(14, 165, 233, 0.9);
            overflow: hidden;
        }

        .lc-season-mascot img {
            width: 70%;
            height: 70%;
            object-fit: contain;
            display: block;
        }

        /* Khối sản phẩm bên phải */
        .lc-season-products-wrap {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .lc-season-products {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 4px 4px 6px;
            scrollbar-width: thin;
        }

        .lc-season-products::-webkit-scrollbar {
            height: 6px;
        }

        .lc-season-products::-webkit-scrollbar-thumb {
            background: rgba(191, 219, 254, 0.9);
            border-radius: 999px;
        }

        .lc-season-next {
            position: absolute;
            right: -6px;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: none;
            background: #ffffff;
            color: #111827;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.55);
            cursor: pointer;
            transition: background 0.15s ease, transform 0.1s ease,
                box-shadow 0.15s ease;
        }

        .lc-season-next:hover {
            background: #eff6ff;
            transform: translateY(-50%) translateY(-1px);
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.8);
        }

        /* Card sản phẩm bên phải */
        .lc-product-card--season {
            position: relative;
            flex: 0 0 190px;
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.5);
            padding: 10px 10px 12px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .lc-product-card--season .lc-product-image-wrap {
            width: 100%;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
        }

        .lc-product-card--season .lc-product-image-wrap img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
            background: #f9fafb;
            border-radius: 8px;
        }

        .lc-product-card--season .lc-product-name {
            font-size: 13px;
            font-weight: 500;
            color: #111827;
            height: 40px;
            line-height: 1.3;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .lc-product-card--season .lc-product-price-row {
            font-size: 12px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .lc-product-card--season .lc-product-price-sale {
            color: #07a9bf;
            font-weight: 700;
        }

        .lc-product-card--season .lc-product-price-original {
            color: #9ca3af;
            text-decoration: line-through;
        }

        .lc-product-card--season .lc-product-unit-pill {
            align-self: flex-start;
            margin-top: 2px;
            padding: 3px 8px;
            border-radius: 999px;
            background: #f3f4f6;
            color: #4b5563;
            font-size: 11px;
        }

        .lc-product-card--season .lc-product-btn-buy {
            margin-top: 8px;
            width: 100%;
            padding: 7px 0;
            border-radius: 999px;
            border: none;
            background: #f97316;
            color: #fefce8;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 10px 22px rgba(248, 113, 22, 0.8);
            transition: background 0.15s ease, transform 0.1s ease,
                box-shadow 0.15s ease;
        }

        .lc-product-card--season .lc-product-btn-buy:hover {
            background: #ea580c;
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(234, 88, 12, 0.95);
        }

        /* Responsive cho Bệnh theo mùa */
        @media (max-width: 1024px) {
            .lc-season-panel {
                flex-direction: column;
            }

            .lc-season-info {
                max-width: 100%;
            }

            .lc-season-products-wrap {
                min-height: 0;
            }

            .lc-season-next {
                display: none;
                /* mobile cuộn tay */
            }
        }

        @media (max-width: 640px) {
            .lc-season-box {
                padding: 14px 12px 16px;
            }

            .lc-season-info {
                padding: 16px 14px;
            }
        }

        /* ============= GÓC SỨC KHỎE ============= */
        .lc-health {
            margin: 0 0 36px;
            padding: 10px 0 36px;
        }

        .lc-health-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .lc-health-title-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lc-health-title {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }

        .lc-health-viewall {
            font-size: 14px;
            color: #07a9bf;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
        }

        .lc-health-viewall span:last-child {
            font-size: 16px;
            transform: translateY(1px);
        }

        .lc-health-viewall:hover {
            text-decoration: underline;
        }

        /* Tag chủ đề (Dinh dưỡng, Phòng chữa bệnh...) */
        .lc-health-tags {
            display: flex;
            gap: 8px;
            margin-bottom: 18px;
            overflow-x: auto;
            padding-bottom: 2px;
            scrollbar-width: thin;
        }

        .lc-health-tags::-webkit-scrollbar {
            height: 4px;
        }

        .lc-health-tags::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 999px;
        }

        .lc-health-tag {
            padding: 7px 14px;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            color: #111827;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            cursor: pointer;
            transition: background 0.15s ease, border-color 0.15s ease,
                color 0.15s ease, box-shadow 0.15s ease, transform 0.1s ease;
        }

        .lc-health-tag--active {
            background: #07a9bf;
            color: #f9fafb;
            border-color: #07a9bf;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.6);
            transform: translateY(-1px);
        }

        .lc-health-tag:hover:not(.lc-health-tag--active) {
            background: #eff6ff;
        }

        /* Layout content: trái bài lớn, phải danh sách bài nhỏ */
        .lc-health-content {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(0, 1.3fr);
            gap: 18px;
            align-items: flex-start;
        }

        /* Bài lớn bên trái */
        .lc-health-main-card {
            background: #ffffff;
            border-radius: 22px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.55);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .lc-health-main-image {
            position: relative;
            width: 100%;
            padding-top: 58%;
            /* tỷ lệ gần giống ảnh Phương Anh */
            overflow: hidden;
        }

        .lc-health-main-image img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transform: scale(1.02);
        }

        .lc-health-main-image::after {
            /* overlay gradient ở đáy ảnh để nổi chữ */
            content: "";
            position: absolute;
            inset: auto 0 0 0;
            height: 45%;
            background: linear-gradient(180deg,
                    transparent,
                    rgba(15, 23, 42, 0.88));
        }

        .lc-health-main-chip {
            position: absolute;
            left: 16px;
            bottom: 14px;
            z-index: 1;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            color: #f9fafb;
            background: rgba(15, 23, 42, 0.85);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .lc-health-main-chip-dot {
            width: 6px;
            height: 6px;
            border-radius: 999px;
            background: #22c55e;
        }

        .lc-health-main-body {
            padding: 16px 16px 18px;
        }

        .lc-health-main-title {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .lc-health-main-excerpt {
            font-size: 14px;
            color: #4b5563;
            line-height: 1.6;
        }

        /* Danh sách bài bên phải */
        .lc-health-side-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .lc-health-side-item {
            display: grid;
            grid-template-columns: 120px minmax(0, 1fr);
            gap: 10px;
            padding: 10px;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 8px 22px rgba(148, 163, 184, 0.6);
        }

        .lc-health-side-thumb {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            background: #f3f4f6;
        }

        .lc-health-side-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .lc-health-side-body {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .lc-health-side-chip {
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
        }

        .lc-health-side-title {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;
        }

        /* Responsive Góc sức khoẻ */
        @media (max-width: 992px) {
            .lc-health-content {
                grid-template-columns: minmax(0, 1fr);
            }
        }

        @media (max-width: 640px) {
            .lc-health-main-body {
                padding: 14px 12px 16px;
            }

            .lc-health-main-title {
                font-size: 16px;
            }
        }

        /* ============= BỆNH (THEO ĐỐI TƯỢNG) ============= */
        .lc-disease {
            margin: 0 0 40px;
            padding: 10px 0 36px;
        }

        .lc-disease-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .lc-disease-title-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lc-disease-title {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }

        .lc-disease-viewall {
            font-size: 14px;
            color: #07a9bf;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
        }

        .lc-disease-viewall span:last-child {
            font-size: 16px;
            transform: translateY(1px);
        }

        .lc-disease-viewall:hover {
            text-decoration: underline;
        }

        /* switch "Bệnh theo đối tượng / Bệnh theo mùa" */
        .lc-disease-switch {
            display: inline-flex;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            padding: 2px;
            margin-bottom: 16px;
            gap: 2px;
        }

        .lc-disease-switch-btn {
            padding: 6px 16px;
            border-radius: 999px;
            border: none;
            background: transparent;
            font-size: 13px;
            font-weight: 500;
            color: #4b5563;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.15s ease, color 0.15s ease,
                box-shadow 0.15s ease, transform 0.1s ease;
        }

        .lc-disease-switch-btn--active {
            background: #07a9bf;
            color: #f9fafb;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.5);
            transform: translateY(-1px);
        }

        .lc-disease-switch-btn:hover:not(.lc-disease-switch-btn--active) {
            background: #e5edff;
        }

        /* grid 4 card bệnh theo đối tượng */
        .lc-disease-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .lc-disease-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.55);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .lc-disease-card-image {
            position: relative;
            width: 100%;
            padding-top: 60%;
            overflow: hidden;
            background: #f3f4f6;
        }

        .lc-disease-card-image img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .lc-disease-card-body {
            padding: 14px 16px 16px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .lc-disease-card-title {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .lc-disease-card-list {
            list-style: disc;
            padding-left: 18px;
            margin: 0 0 10px;
            font-size: 13px;
            color: #4b5563;
            line-height: 1.6;
            flex-grow: 1;
        }

        .lc-disease-card-list li+li {
            margin-top: 2px;
        }

        .lc-disease-card-more {
            margin-top: 8px;
        }

        .lc-disease-card-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 999px;
            border: none;
            background: #07a9bf;
            color: #f9fafb;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.75);
            transition: background 0.15s ease, transform 0.1s ease,
                box-shadow 0.15s ease;
        }

        .lc-disease-card-btn span:last-child {
            font-size: 15px;
            transform: translateY(1px);
        }

        .lc-disease-card-btn:hover {
            background: #1e40af;
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(30, 64, 175, 0.95);
        }

        @media (max-width: 1024px) {
            .lc-disease-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .lc-disease-grid {
                grid-template-columns: minmax(0, 1fr);
            }

            .lc-disease-card-body {
                padding: 12px 12px 14px;
            }
        }

        /* ============= FOOTER ============= */

        .lc-footer {
            margin-top: 40px;
            font-size: 13px;
            color: #111827;
        }

        /* thanh xanh trên cùng */
        .lc-footer-top {
            background: linear-gradient(135deg, #07a9bf, #0f60e0);
            color: #f9fafb;
            padding: 12px 0;
        }

        .lc-footer-top-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .lc-footer-top-left {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            font-weight: 600;
        }

        .lc-footer-top-left-icon {
            width: 26px;
            height: 26px;
            border-radius: 999px;
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .lc-footer-top-btn {
            padding: 8px 18px;
            border-radius: 999px;
            border: none;
            background: #ffffff;
            color: #07a9bf;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.45);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .lc-footer-top-btn span:last-child {
            font-size: 15px;
            transform: translateY(1px);
        }

        .lc-footer-top-btn:hover {
            background: #f9fafb;
        }

        /* phần nội dung chính dưới */
        .lc-footer-main {
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            padding: 28px 0 36px;
        }

        .lc-footer-grid {
            display: grid;
            grid-template-columns: 1.8fr 1.6fr 1.6fr 2.2fr;
            gap: 28px;
            align-items: flex-start;
        }

        .lc-footer-col-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #374151;
            margin-bottom: 10px;
        }

        .lc-footer-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .lc-footer-list li a {
            text-decoration: none;
            color: #4b5563;
        }

        .lc-footer-list li a:hover {
            color: #07a9bf;
        }

        /* cột liên hệ bên phải */
        .lc-footer-contact-block {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .lc-footer-hotline-title {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #111827;
        }

        .lc-footer-hotline-row {
            font-size: 13px;
            color: #111827;
        }

        .lc-footer-hotline-row span:first-child {
            font-weight: 700;
            color: #07a9bf;
        }

        .lc-footer-hotline-row span:last-child {
            color: #6b7280;
            margin-left: 4px;
        }

        .lc-footer-social {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .lc-footer-social-icons {
            display: inline-flex;
            gap: 8px;
            margin-top: 4px;
        }

        .lc-footer-social-icon {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            background: #07a9bf;
            color: #f9fafb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
        }

        .lc-footer-qr {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .lc-footer-qr-box {
            width: 90px;
            height: 90px;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #6b7280;
        }

        /* chứng nhận + thanh toán */
        .lc-footer-badges {
            margin-top: 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .lc-footer-cert-row,
        .lc-footer-pay-row {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .lc-footer-badge-label {
            font-size: 12px;
            color: #6b7280;
            min-width: 110px;
        }

        .lc-footer-cert-icons,
        .lc-footer-pay-icons {
            display: inline-flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .lc-footer-cert-pill,
        .lc-footer-pay-pill {
            padding: 4px 10px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            font-size: 11px;
            color: #4b5563;
            white-space: nowrap;
        }

        @media (max-width: 1024px) {
            .lc-footer-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .lc-footer-grid {
                grid-template-columns: minmax(0, 1fr);
            }

            .lc-footer-top-inner {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* ========== TÍCH ĐIỂM ĐỔI QUÀ ========== */
        .lc-rewards {
            padding: 32px 0 40px;
        }

        .lc-rewards-box {
            background: linear-gradient(135deg, #0f172a, #020617);
            border-radius: 16px;
            padding: 20px 20px 24px;
            color: #e5e7eb;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.55);
            position: relative;
            overflow: hidden;
        }

        .lc-rewards-box::before {
            content: "";
            position: absolute;
            inset: -40%;
            background:
                radial-gradient(circle at 0% 0%, rgba(56, 189, 248, 0.2), transparent 55%),
                radial-gradient(circle at 100% 100%, rgba(59, 130, 246, 0.25), transparent 55%);
            opacity: 0.7;
            pointer-events: none;
        }

        .lc-rewards-box-header {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            z-index: 1;
        }

        .lc-rewards-box-title {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .lc-rewards-body {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(0, 1.3fr);
            gap: 20px;
            align-items: stretch;
        }

        /* QUÀ NỔI BẬT */
        /* ========== TÍCH ĐIỂM ĐỔI QUÀ ========== */
        .lc-rewards {
            padding: 32px 0 40px;
        }

        .lc-rewards-box {
            background: linear-gradient(135deg, #4DBBC5, #0E7478);
            border-radius: 16px;
            padding: 20px 20px 24px;
            color: #e5e7eb;
            box-shadow: 0 18px 40px rgba(6, 78, 84, 0.55);
            position: relative;
            overflow: hidden;
        }

        .lc-rewards-box::before {
            content: "";
            position: absolute;
            inset: -40%;
            background:
                radial-gradient(circle at 0% 0%, rgba(77, 187, 197, 0.35), transparent 55%),
                radial-gradient(circle at 100% 100%, rgba(14, 116, 120, 0.4), transparent 55%);
            opacity: 0.9;
            pointer-events: none;
        }

        .lc-rewards-box-header {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            z-index: 1;
        }

        .lc-rewards-box-title {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .lc-rewards-body {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(0, 1.3fr);
            gap: 20px;
            align-items: stretch;
        }

        /* QUÀ NỔI BẬT */
        .lc-rewards-featured {
            background: linear-gradient(135deg,
                    rgba(6, 95, 101, 0.98),
                    rgba(21, 128, 130, 0.98));
            border-radius: 14px;
            padding: 16px 16px 18px;
            border: 1px solid rgba(226, 252, 255, 0.5);
            box-shadow: 0 12px 30px rgba(6, 78, 84, 0.7);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .lc-rewards-featured-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            align-self: flex-start;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            background: linear-gradient(90deg, #4DBBC5, #0E7478);
            color: #f9fafb;
            box-shadow: 0 0 0 1px rgba(15, 23, 42, 0.3);
        }

        .lc-rewards-featured-main {
            display: grid;
            grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.25fr);
            gap: 14px;
            align-items: center;
        }

        .lc-rewards-featured-image {
            border-radius: 12px;
            overflow: hidden;
            background: radial-gradient(circle at 50% 0%, #0b3f43, #022024);
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lc-rewards-featured-image img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .lc-rewards-featured-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .lc-rewards-featured-name {
            font-size: 16px;
            font-weight: 700;
        }

        .lc-rewards-featured-points {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            background: rgba(77, 187, 197, 0.12);
            color: #e0fafa;
            border: 1px solid rgba(224, 242, 254, 0.8);
        }

        .lc-rewards-featured-desc {
            font-size: 13px;
            color: #e0f2f1;
            line-height: 1.5;
        }

        .lc-rewards-btn-primary {
            margin-top: 4px;
            align-self: flex-start;
            padding: 7px 18px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            background: linear-gradient(90deg, #4DBBC5, #0E7478);
            color: #f9fafb;
            box-shadow: 0 10px 22px rgba(6, 78, 84, 0.75);
        }

        /* SLIDER QUÀ TẶNG */
        .lc-rewards-slider-wrap {
            position: relative;
            background: linear-gradient(135deg,
                    rgba(6, 95, 101, 0.96),
                    rgba(77, 187, 197, 0.94));
            border-radius: 14px;
            padding: 14px 32px 14px 14px;
            border: 1px solid rgba(226, 252, 255, 0.75);
            box-shadow: 0 14px 32px rgba(4, 56, 58, 0.9);
        }

        .lc-rewards-slider {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 4px;
        }

        .lc-rewards-slider::-webkit-scrollbar {
            height: 0;
        }

        .lc-reward-card {
            flex: 0 0 210px;
            background:#018294f5;
            border-radius: 12px;
            padding: 10px 10px 12px;
            border: 1px solid rgba(191, 219, 220, 0.85);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .lc-reward-card-image {
            border-radius: 10px;
            overflow: hidden;
            background: radial-gradient(circle at 50% 0%, #022c30, #020617);
            min-height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lc-reward-card-image img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .lc-reward-card-body {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .lc-reward-card-name {
            font-size: 14px;
            font-weight: 600;
            color: #f9fafb;
        }

        .lc-reward-card-points {
            font-size: 13px;
            font-weight: 600;
            color: #7ce3ee;
        }

        .lc-reward-card-desc {
            font-size: 12px;
            color: #d1fae5;
            line-height: 1.45;
        }

        .lc-rewards-btn-secondary {
            margin-top: 4px;
            align-self: flex-start;
            padding: 6px 14px;
            border-radius: 999px;
            border: 1px solid rgba(224, 242, 254, 0.9);
            background: transparent;
            color: #ecfeff;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            cursor: pointer;
        }

        /* Nút next slider */
        .lc-rewards-next {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 28px;
            height: 56px;
            border-radius: 28px;
            border: none;
            cursor: pointer;
            background: radial-gradient(circle at 30% 20%, #4DBBC5, #0E7478);
            color: #f9fafb;
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 26px rgba(4, 56, 58, 0.9);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .lc-rewards-body {
                grid-template-columns: minmax(0, 1fr);
            }

            .lc-rewards-featured-main {
                grid-template-columns: minmax(0, 1fr);
            }

            .lc-rewards-slider-wrap {
                padding-right: 40px;
            }
        }

        @media (max-width: 640px) {
            .lc-rewards {
                padding: 24px 0 30px;
            }

            .lc-rewards-box {
                padding: 16px 12px 18px;
            }

            .lc-rewards-box-title {
                font-size: 18px;
            }

            .lc-reward-card {
                flex: 0 0 190px;
            }
        }

        /* ============= CSS HEALTH ============= */
        .lc-health-content[hidden]{
    display: none !important;
}

.lc-health-layout{
    display: grid;
    grid-template-columns: minmax(0, 1.7fr) minmax(360px, 0.9fr);
    gap: 20px;
    align-items: stretch;
}

.lc-health-main-card{
    background: #fff;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 18px 40px rgba(15, 23, 42, .12);
    min-height: 100%;
}

.lc-health-main-link{
    display: block;
    width: 100%;
    height: 100%;
    text-decoration: none;
    color: inherit;
}

.lc-health-main-link:hover{
    color: inherit;
}

.lc-health-main-image{
    position: relative;
    height: 540px;
    overflow: hidden;
    background: #edf2f7;
}

.lc-health-main-image img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.lc-health-main-overlay{
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(15, 23, 42, .78) 0%, rgba(15, 23, 42, .08) 45%, rgba(15, 23, 42, 0) 100%);
}

.lc-health-main-chip{
    position: absolute;
    left: 22px;
    bottom: 18px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(17, 24, 39, .78);
    color: #fff;
    padding: 10px 16px;
    border-radius: 999px;
    font-size: 18px;
    font-weight: 700;
    z-index: 2;
}

.lc-health-main-chip-dot{
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #35e06b;
    display: block;
}

.lc-health-main-body{
    padding: 24px 28px 28px;
}

.lc-health-main-title{
    margin: 0 0 14px;
    font-size: 24px;
    line-height: 1.35;
    font-weight: 800;
    color: #182230;
}

.lc-health-main-excerpt{
    margin: 0;
    font-size: 16px;
    line-height: 1.75;
    color: #5f6b7a;
}

.lc-health-side-list{
    display: flex;
    flex-direction: column;
    gap: 16px;
    min-width: 0;
}

.lc-health-side-item{
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 14px 34px rgba(15, 23, 42, .10);
}

.lc-health-side-link{
    display: flex;
    align-items: stretch;
    gap: 14px;
    text-decoration: none;
    color: inherit;
    padding: 14px;
    min-height: 160px;
}

.lc-health-side-link:hover{
    color: inherit;
}

.lc-health-side-thumb{
    width: 168px;
    min-width: 168px;
    height: 132px;
    border-radius: 18px;
    overflow: hidden;
    background: #f1f5f9;
}

.lc-health-side-thumb img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.lc-health-side-body{
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.lc-health-side-chip{
    margin-bottom: 8px;
    font-size: 14px;
    line-height: 1.4;
    font-weight: 700;
    color: #6c7685;
}

.lc-health-side-title{
    margin: 0;
    font-size: 18px;
    line-height: 1.5;
    font-weight: 800;
    color: #182230;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@media (max-width: 1399px){
    .lc-health-layout{
        grid-template-columns: minmax(0, 1.5fr) minmax(320px, 1fr);
    }

    .lc-health-main-image{
        height: 480px;
    }

    .lc-health-side-thumb{
        width: 148px;
        min-width: 148px;
        height: 120px;
    }
}

@media (max-width: 991px){
    .lc-health-layout{
        grid-template-columns: 1fr;
    }

    .lc-health-main-image{
        height: 420px;
    }
}

@media (max-width: 767px){
    .lc-health-main-image{
        height: 260px;
    }

    .lc-health-main-body{
        padding: 18px;
    }

    .lc-health-main-title{
        font-size: 20px;
    }

    .lc-health-side-link{
        min-height: unset;
        padding: 12px;
        gap: 12px;
    }

    .lc-health-side-thumb{
        width: 110px;
        min-width: 110px;
        height: 90px;
        border-radius: 14px;
    }

    .lc-health-side-title{
        font-size: 16px;
        -webkit-line-clamp: 2;
    }

.lc-flashsale-panel[hidden]{
    display: none !important;
}

.lc-product-btn-buy{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.lc-flashsale-tab-status--ended{
    background: #eef2f7;
    color: #667085;
}
.lc-favbrands-card{
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.lc-favbrands-card:hover{
    color: inherit;
}

.lc-favbrands-top img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.lc-favbrands-logo-pill img{
    width: 28px;
    height: 28px;
    object-fit: contain;
    display: block;
    flex: 0 0 auto;
}

.lc-favbrands-empty{
    width: 100%;
    min-height: 180px;
    border-radius: 24px;
    border: 1px dashed #d8e4ef;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    font-size: 15px;
    font-weight: 700;
}
    .lc-search-submit-btn{
    border: none;
    background: transparent;
    padding: 0;
    margin: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: inherit;
}
.lc-footer-top-left-icon{
    width: 34px;
    height: 34px;
    border-radius: 999px;
    background: rgba(255,255,255,.16);
    color: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 auto;
}

.lc-footer-top-left-icon i{
    font-size: 18px;
    line-height: 1;
    font-weight: 400 !important;
}

.lc-footer-top-btn{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.lc-footer-top-btn i{
    font-size: 18px;
    line-height: 1;
    font-weight: 400 !important;
}
}
    </style>
</head>