<!DOCTYPE html>
<html lang="vi">


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
            width: min(1320px, calc(100% - 32px));
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

        .lc-search-suggestions span {
            cursor: pointer;
            position: relative;
        }

        .lc-search-suggestions span::after {
            content: "•";
            margin: 0 4px;
            opacity: 0.5;
        }

        .lc-search-suggestions span:last-child::after {
            content: "";
            margin: 0;
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
            padding: 22px 24px;
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
            background: rgba(15, 23, 42, 0.1);
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
    </style>
</head>
<body>
    <!-- ========== HEADER ========== -->
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
                            <span>Tư vấn ngay: <strong>1800 1111</strong></span>
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
                        <div class="lc-search-bar">
                            <div class="lc-search-input-wrap">
                                <span class="lc-search-icon">🔍</span>
                                <input type="text" class="lc-search-input"
                                    placeholder="Tìm thuốc, thực phẩm chức năng, thiết bị y tế..." />
                            </div>
                            <div class="lc-search-actions">
                                <button class="lc-icon-btn" type="button" aria-label="Tìm bằng giọng nói">
                                    🎙
                                </button>
                                <button class="lc-icon-btn" type="button" aria-label="Tìm bằng hình ảnh">
                                    📷
                                </button>
                            </div>
                        </div>
                        <div class="lc-search-suggestions">
                            <span>Omega 3</span>
                            <span>Canxi</span>
                            <span>Dung dịch vệ sinh</span>
                            <span>Sữa rửa mặt</span>
                            <span>Thuốc nhỏ mắt</span>
                            <span>Kẽm</span>
                            <span>Men vi sinh</span>
                            <span>Kem chống nắng</span>
                        </div>
                    </div>

                    <!-- User actions -->
                    <div class="lc-header-actions">
                        <a href="#" class="lc-link-user">
                            <span class="lc-link-user-icon">👤</span>
                            <span>Đăng nhập</span>
                        </a>
                        <button class="lc-btn-cart" type="button">
                            <span class="lc-btn-cart-icon">🛒</span>
                            <span>Giỏ hàng</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom nav -->
        <div class="lc-header-nav">
            <div class="lc-container">
                <nav class="lc-header-nav-inner">
                    <div class="lc-nav-item lc-nav-item--has-dropdown lc-nav-item--active">
                        <span>Thực phẩm chức năng</span>
                    </div>
                    <div class="lc-nav-item lc-nav-item--has-dropdown">
                        <span>Dược mỹ phẩm</span>
                    </div>
                    <div class="lc-nav-item lc-nav-item--has-dropdown">
                        <span>Thuốc</span>
                    </div>
                    <div class="lc-nav-item">
                        <span>Chăm sóc cá nhân</span>
                    </div>
                    <div class="lc-nav-item lc-nav-item--has-dropdown">
                        <span>Thiết bị y tế</span>
                    </div>
                    <div class="lc-nav-item lc-nav-item--has-dropdown">
                        <span>Bệnh &amp; Góc sức khoẻ</span>
                    </div>
                    <div class="lc-nav-item">
                        <span>Hệ thống nhà thuốc</span>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <!-- ========== BANNER HERO ==========
         Nền full width, nội dung căn giữa 80% -->
        <section class="lc-banner">
            <div class="lc-container">
                <!-- Hero campaign trên cùng -->
                <div class="lc-banner-campaign">
                    <button class="lc-banner-campaign-arrow lc-banner-campaign-arrow--prev" type="button"
                        aria-label="Slide trước">
                        ‹
                    </button>
                    <button class="lc-banner-campaign-arrow lc-banner-campaign-arrow--next" type="button"
                        aria-label="Slide sau">
                        ›
                    </button>

                    <div class="lc-banner-campaign-tag">
                        — Chào mừng cửa hàng số 16 của nhà thuốc Phương Anh —
                    </div>
                    <h2 class="lc-banner-campaign-title">
                        <span>PHƯƠNG ANH</span> áp dụng chương trình thăm khám sương khớp miễn phí toàn chuỗi
                    </h2>
                    <button class="lc-banner-btn-primary" type="button">
                        Xem ngay
                    </button>
                </div>

                <!-- Hàng 2: Slide sản phẩm + 2 banner nhỏ -->
                <div class="lc-banner-main">
                    <!-- Slide sản phẩm khuyến mãi -->
                    <section class="lc-banner-product-slider" aria-label="Flash khuyến mãi">
                        <div class="lc-banner-product-track" id="bannerProductTrack">
                            <!-- Slide 1: ví dụ Durex -->
                            <article class="lc-banner-product-slide">
                                <div>
                                    <div class="lc-banner-product-info-eyebrow">
                                        Ưu đãi thương hiệu
                                    </div>
                                    <h3 class="lc-banner-product-title">
                                        TPBVSK Nga Phụ Khang
                                    </h3>
                                    <p class="lc-banner-product-sub">
                                        Một sản phẩm của dược phẩm Á Âu tin cậy chất lượng suốt 20 năm
                                    </p>
                                    <div class="lc-banner-product-benefits">
                                        <span class="lc-banner-product-benefit">Giảm đến 25%</span>
                                        <span class="lc-banner-product-benefit">Giao nhanh 2H</span>
                                        <span class="lc-banner-product-benefit">Freeship theo điều kiện</span>
                                    </div>
                                    <div class="lc-banner-product-cta-row">
                                        <span class="lc-banner-product-price-tag">
                                            Giá chỉ từ 220.000đ
                                        </span>
                                        <button class="lc-banner-btn-secondary" type="button">
                                            Mua ngay
                                        </button>
                                    </div>
                                </div>
                                <div class="lc-banner-product-media">
                                    <div class="lc-banner-product-media-inner">
                                        <!-- Placeholder ảnh sản phẩm -->
                                        <img src="phuonganh/img/pa1.jpg" alt="Sản phẩm Durex khuyến mãi" />
                                    </div>
                                </div>
                            </article>

                        </div>

                        <!-- Dots & mũi tên slider -->
                        <div class="lc-banner-product-dots" id="bannerProductDots">
                            <div class="lc-banner-product-dot lc-banner-product-dot--active"></div>
                            <div class="lc-banner-product-dot"></div>
                        </div>
                        <button class="lc-banner-product-arrow" type="button" id="bannerProductNext"
                            aria-label="Chuyển slide">
                            ›
                        </button>
                    </section>

                    <!-- Hai banner nhỏ bên phải -->
                    <aside class="lc-banner-side">
                        <!-- Banner kiến thức ung thư -->
                        <article class="lc-banner-side-card">
                            <div>
                                <div class="lc-banner-side-label">
                                    Chuyên môn cho bạn
                                </div>
                                <h3 class="lc-banner-side-title">
                                    Tìm hiểu về Dịch Cúm A
                                </h3>
                                <p class="lc-banner-side-text">
                                    Cúm A thường xuất hiện nhiều hơn trong các dịch
                                </p>
                                <div class="lc-banner-side-logos">
                                    <span class="lc-banner-side-logo-pill">Tư vấn</span>
                                    <span class="lc-banner-side-logo-pill">Chi tiết</span>
                                </div>
                            </div>
                        </article>

                        <!-- Banner cập nhật địa chỉ -->
                        <article class="lc-banner-side-card">
                            <div>
                                <div class="lc-banner-side-label">
                                    Tiện ích
                                </div>
                                <h3 class="lc-banner-side-title">
                                    Cập nhật tính năng đổi quà
                                </h3>
                                <p class="lc-banner-side-text">
                                    Từ ngày 01-01-2026 tất cả khách hàng sẽ có thể đổi quà đơn giản qua website
                                </p>
                            </div>
                            <a href="#" class="lc-banner-side-link">
                                <span>Tra cứu ngay</span>
                                <span>›</span>
                            </a>
                        </article>
                    </aside>
                </div>

                <!-- Hàng 3: 6 danh mục nhanh -->
                <section class="lc-banner-quick-actions" aria-label="Lối tắt chức năng">
                    <div class="lc-quick-list">
                        <button type="button" class="lc-quick-item">
                            <div class="lc-quick-item-icon">
                                <img style=" width: 45px; " src="phuonganh/img/ic_1.png" alt="Dược Phương Anh" />
                            </div>
                            <div>Cần mua thuốc</div>
                        </button>
                        <button type="button" class="lc-quick-item">
                            <div class="lc-quick-item-icon">
                                <img style=" width: 45px; " src="phuonganh/img/ic_2.png" alt="Dược Phương Anh" />
                            </div>
                            <div>Tư vấn với Dược sỹ</div>
                        </button>
                        <button
                            type="button"
                            class="lc-quick-item"
                            onclick="window.location.href='{{ route('website.my-order.index') }}'"
                        >
                            <div class="lc-quick-item-icon">
                                <img style="width:45px;" src="{{ asset('phuonganh/img/ic_3.png') }}" alt="Dược Phương Anh" />
                            </div>
                            <div>Đơn của tôi</div>
                        </button>
                        <button
                            type="button"
                            class="lc-quick-item"
                            onclick="window.location.href='{{ route('website.purchased_medicine_v1.index') }}'"
                        >
                            <div class="lc-quick-item-icon">
                                <img style="width:45px;" src="{{ asset('phuonganh/img/ic_4.png') }}" alt="Dược Phương Anh" />
                            </div>
                            <div>Đơn thuốc đã mua</div>
                        </button>
                        <button type="button" class="lc-quick-item">
                            <div class="lc-quick-item-icon">
                                <img style=" width: 45px; " src="phuonganh/img/ic_5.png" alt="Dược Phương Anh" />
                            </div>
                            <div>Nhà thuốc gần bạn</div>
                        </button>
                        <button type="button" class="lc-quick-item">
                            <div class="lc-quick-item-icon">
                                <img style=" width: 45px; " src="phuonganh/img/ic_6.png" alt="Dược Phương Anh" />
                            </div>
                            <div>Tích điểm - Đổi quà</div>
                        </button>
                    </div>
                </section>
            </div>
        </section>
        <!-- ========== FLASH SALE GIÁ TỐT ========== -->
        <section class="" aria-label="Flash Sale giá tốt">
            <div class="lc-container">
                <!-- Box nội dung đè lên ảnh nền -->
                <div class="lc-flashsale-box">
                    <!-- Dòng tab thời gian -->
                    <div class="lc-flashsale-tabs">
                        <button class="lc-flashsale-tab lc-flashsale-tab--active" type="button">
                            <span class="lc-flashsale-tab-time">08:00 – 22:00</span>
                            <span class="lc-flashsale-tab-date">14/11</span>
                            <span class="lc-flashsale-tab-status lc-flashsale-tab-status--active">
                                Đang diễn ra
                            </span>
                        </button>
                        <button class="lc-flashsale-tab" type="button">
                            <span class="lc-flashsale-tab-time">08:00 – 22:00</span>
                            <span class="lc-flashsale-tab-date">15/11</span>
                            <span class="lc-flashsale-tab-status lc-flashsale-tab-status--upcoming">
                                Sắp diễn ra
                            </span>
                        </button>
                        <button class="lc-flashsale-tab" type="button">
                            <span class="lc-flashsale-tab-time">08:00 – 22:00</span>
                            <span class="lc-flashsale-tab-date">16/11</span>
                            <span class="lc-flashsale-tab-status lc-flashsale-tab-status--upcoming">
                                Sắp diễn ra
                            </span>
                        </button>
                        <button class="lc-flashsale-tab" type="button">
                            <span class="lc-flashsale-tab-time">08:00 – 22:00</span>
                            <span class="lc-flashsale-tab-date">16/11</span>
                            <span class="lc-flashsale-tab-status lc-flashsale-tab-status--upcoming">
                                Sắp diễn ra
                            </span>
                        </button>
                        <button class="lc-flashsale-tab" type="button">
                            <span class="lc-flashsale-tab-time">08:00 – 22:00</span>
                            <span class="lc-flashsale-tab-date">17/11</span>
                            <span class="lc-flashsale-tab-status lc-flashsale-tab-status--upcoming">
                                Sắp diễn ra
                            </span>
                        </button>
                        <button class="lc-flashsale-tab" type="button">
                            <span class="lc-flashsale-tab-time">08:00 – 22:00</span>
                            <span class="lc-flashsale-tab-date">18/11</span>
                            <span class="lc-flashsale-tab-status lc-flashsale-tab-status--upcoming">
                                Sắp diễn ra
                            </span>
                        </button>
                        <button class="lc-flashsale-tab" type="button">
                            <span class="lc-flashsale-tab-time">08:00 – 22:00</span>
                            <span class="lc-flashsale-tab-date">19/11</span>
                            <span class="lc-flashsale-tab-status lc-flashsale-tab-status--upcoming">
                                Sắp diễn ra
                            </span>
                        </button>
                        <!-- Có thể thêm các tab khác nếu cần -->
                    </div>

                    <!-- Countdown -->
                    <div class="lc-flashsale-countdown">
                        <div class="lc-flashsale-countdown-label">
                            Kết thúc sau
                        </div>
                        <div class="lc-flashsale-timer" id="flashsaleTimer">
                            <div class="lc-flashsale-timer-box" data-unit="hours">00</div>
                            <div class="lc-flashsale-timer-sep">:</div>
                            <div class="lc-flashsale-timer-box" data-unit="minutes">11</div>
                            <div class="lc-flashsale-timer-sep">:</div>
                            <div class="lc-flashsale-timer-box" data-unit="seconds">12</div>
                        </div>
                    </div>

                    <!-- Slider sản phẩm -->
                    <div class="lc-flashsale-products-wrap">
                        <div class="lc-flashsale-products" id="flashsaleProducts">
                            <!-- Card 1 -->
                            <article class="lc-product-card--flash">
                                <div class="lc-product-discount-badge">-20%</div>
                                <div class="lc-product-image-wrap">
                                    <!-- Placeholder ảnh sản phẩm -->
                                    <img src="phuonganh/img/fl1.jpg" alt="Viên nam lực Bang Cevrai" />
                                </div>
                                <h3 class="lc-product-name">
                                    Viên nam lực Bang Cevrai hỗ trợ cải thiện chức năng sinh lý nam giới
                                </h3>
                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">424.000đ / Chai</div>
                                    <div class="lc-product-price-original">530.000đ</div>
                                    <div class="lc-product-unit-pill">Chai 60 viên</div>
                                </div>
                                <button class="lc-product-btn-buy" type="button">
                                    Chọn mua
                                </button>
                            </article>

                            <!-- Card 2 -->
                            <article class="lc-product-card--flash">
                                <div class="lc-product-discount-badge">-10%</div>
                                <div class="lc-product-image-wrap">
                                    <img src="phuonganh/img/fl2.jpg"
                                        alt="Thực phẩm bảo vệ sức khỏe NMN" />
                                </div>
                                <h3 class="lc-product-name">
                                    Thực phẩm bảo vệ sức khỏe NMN hỗ trợ tăng cường sức khỏe tế bào
                                </h3>
                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">6.675.000đ / Hộp</div>
                                    <div class="lc-product-price-original">7.500.000đ</div>
                                    <div class="lc-product-unit-pill">Hộp 60 viên</div>
                                </div>
                                <button class="lc-product-btn-buy" type="button">
                                    Chọn mua
                                </button>
                            </article>

                            <!-- Card 3 -->
                            <article class="lc-product-card--flash">
                                <div class="lc-product-discount-badge">-15%</div>
                                <div class="lc-product-image-wrap">
                                    <img src="phuonganh/img/fl3.png" alt="Siro ho cảm long đờm" />
                                </div>
                                <h3 class="lc-product-name">
                                    Siro ho cảm long đờm cho cả gia đình, vị thảo dược dễ uống
                                </h3>
                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">89.000đ / Chai</div>
                                    <div class="lc-product-price-original">105.000đ</div>
                                    <div class="lc-product-unit-pill">Chai 100ml</div>
                                </div>
                                <button class="lc-product-btn-buy" type="button">
                                    Chọn mua
                                </button>
                            </article>

                            <!-- Card 4 -->
                            <article class="lc-product-card--flash">
                                <div class="lc-product-discount-badge">-25%</div>
                                <div class="lc-product-image-wrap">
                                    <img src="phuonganh/img/fl4.jpg"
                                        alt="Kem chống nắng cho da nhạy cảm" />
                                </div>
                                <h3 class="lc-product-name">
                                    Kem chống nắng phổ rộng cho da nhạy cảm, chống tia UVA/UVB hiệu quả
                                </h3>
                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">239.000đ / Tuýp</div>
                                    <div class="lc-product-price-original">320.000đ</div>
                                    <div class="lc-product-unit-pill">Tuýp 50ml</div>
                                </div>
                                <button class="lc-product-btn-buy" type="button">
                                    Chọn mua
                                </button>
                            </article>

                            <!-- Card 5 -->
                            <article class="lc-product-card--flash">
                                <div class="lc-product-discount-badge">-18%</div>
                                <div class="lc-product-image-wrap">
                                    <img src="phuonganh/img/fl5.jpg"
                                        alt="Men vi sinh hỗ trợ tiêu hóa" />
                                </div>
                                <h3 class="lc-product-name">
                                    Men vi sinh hỗ trợ tiêu hóa, cân bằng hệ vi khuẩn đường ruột
                                </h3>
                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">149.000đ / Hộp</div>
                                    <div class="lc-product-price-original">182.000đ</div>
                                    <div class="lc-product-unit-pill">Hộp 20 gói</div>
                                </div>
                                <button class="lc-product-btn-buy" type="button">
                                    Chọn mua
                                </button>
                            </article>
                            <article class="lc-product-card--flash">
                                <div class="lc-product-discount-badge">-20%</div>
                                <div class="lc-product-image-wrap">
                                    <!-- Placeholder ảnh sản phẩm -->
                                    <img src="phuonganh/img/fl6.jpg" alt="Viên nam lực Bang Cevrai" />
                                </div>
                                <h3 class="lc-product-name">
                                    Viên nam lực Bang Cevrai hỗ trợ cải thiện chức năng sinh lý nam giới
                                </h3>
                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">424.000đ / Chai</div>
                                    <div class="lc-product-price-original">530.000đ</div>
                                    <div class="lc-product-unit-pill">Chai 60 viên</div>
                                </div>
                                <button class="lc-product-btn-buy" type="button">
                                    Chọn mua
                                </button>
                            </article>
                        </div>

                        <!-- Nút trượt sang phải (desktop) -->
                        <button class="lc-flashsale-next" type="button" id="flashsaleNext"
                            aria-label="Xem thêm sản phẩm flash sale">
                            ›
                        </button>
                    </div>

                    <!-- Link Xem tất cả -->
                    <div class="lc-flashsale-viewall">
                        <a href="#">
                            <span>Xem tất cả sản phẩm Flash Sale</span>
                            <span>›</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========== SẢN PHẨM BÁN CHẠY ========== -->
        <section class="lc-bestseller" aria-label="Sản phẩm bán chạy">
            <div class="lc-container">
                <div class="lc-bestseller-box">
                    <!-- Ribbon đỏ tiêu đề -->
                    <div class="lc-bestseller-heading-wrap">
                        <div class="lc-bestseller-heading">
                            Sản phẩm bán chạy
                        </div>
                    </div>

                    <!-- Slider sản phẩm -->
                    <div class="lc-bestseller-products-wrap">
                        <div class="lc-bestseller-products" id="bestsellerProducts">
                            <!-- Card 1 -->
                            <article class="lc-product-card--best">
                                <div class="lc-product-discount-badge">-25%</div>
                                <div class="lc-product-image-wrap">
                                    <!-- Placeholder ảnh sản phẩm -->
                                    <img src="phuonganh/img/best-1-placeholder.jpg" alt="Thực phẩm bảo vệ sức khỏe NMN PQQ" />
                                </div>
                                <h3 class="lc-product-name">
                                    Thực phẩm bảo vệ sức khỏe NMN PQQ hỗ trợ cải thiện sức khỏe tế bào
                                </h3>
                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">6.675.000đ / Hộp</div>
                                    <div class="lc-product-price-original">8.900.000đ</div>
                                    <div class="lc-product-unit-pill">Hộp 60 viên</div>
                                </div>
                                <button class="lc-product-btn-buy" type="button">
                                    Chọn mua
                                </button>
                            </article>

                            <!-- Card 2 -->
                            <article class="lc-product-card--best">
                                <div class="lc-product-discount-badge">-18%</div>
                                <div class="lc-product-image-wrap">
                                    <img src="phuonganh/img/best-2-placeholder.jpg" alt="Collagen giúp da săn chắc" />
                                </div>
                                <h3 class="lc-product-name">
                                    Collagen hỗ trợ làm đẹp da, giúp da săn chắc và giảm nếp nhăn
                                </h3>
                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">429.000đ / Hộp</div>
                                    <div class="lc-product-price-original">525.000đ</div>
                                    <div class="lc-product-unit-pill">Hộp 30 gói</div>
                                </div>
                                <button class="lc-product-btn-buy" type="button">
                                    Chọn mua
                                </button>
                            </article>

                            <!-- Card 3 -->
                            <article class="lc-product-card--best">
                                <div class="lc-product-discount-badge">-20%</div>
                                <div class="lc-product-image-wrap">
                                    <img src="phuonganh/img/best-3-placeholder.jpg" alt="Vitamin tổng hợp cho người lớn" />
                                </div>
                                <h3 class="lc-product-name">
                                    Vitamin tổng hợp cho người lớn giúp tăng cường sức khỏe toàn diện
                                </h3>
                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">189.000đ / Lọ</div>
                                    <div class="lc-product-price-original">235.000đ</div>
                                    <div class="lc-product-unit-pill">Lọ 60 viên</div>
                                </div>
                                <button class="lc-product-btn-buy" type="button">
                                    Chọn mua
                                </button>
                            </article>

                            <!-- Card 4 -->
                            <article class="lc-product-card--best">
                                <div class="lc-product-discount-badge">-15%</div>
                                <div class="lc-product-image-wrap">
                                    <img src="phuonganh/img/best-4-placeholder.jpg"
                                        alt="Sữa rửa mặt dịu nhẹ cho da nhạy cảm" />
                                </div>
                                <h3 class="lc-product-name">
                                    Sữa rửa mặt dịu nhẹ cho da nhạy cảm, làm sạch mà không gây khô căng
                                </h3>
                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">129.000đ / Chai</div>
                                    <div class="lc-product-price-original">152.000đ</div>
                                    <div class="lc-product-unit-pill">Chai 150ml</div>
                                </div>
                                <button class="lc-product-btn-buy" type="button">
                                    Chọn mua
                                </button>
                            </article>

                            <!-- Card 5 -->
                            <article class="lc-product-card--best">
                                <div class="lc-product-discount-badge">-22%</div>
                                <div class="lc-product-image-wrap">
                                    <img src="phuonganh/img/best-5-placeholder.jpg" alt="Men vi sinh cho trẻ em" />
                                </div>
                                <h3 class="lc-product-name">
                                    Men vi sinh cho trẻ em hỗ trợ tiêu hóa, giúp bé ăn ngon hơn
                                </h3>
                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">215.000đ / Hộp</div>
                                    <div class="lc-product-price-original">275.000đ</div>
                                    <div class="lc-product-unit-pill">Hộp 20 gói</div>
                                </div>
                                <button class="lc-product-btn-buy" type="button">
                                    Chọn mua
                                </button>
                            </article>
                            <!-- Card 4 -->
                            <article class="lc-product-card--best">
                                <div class="lc-product-discount-badge">-15%</div>
                                <div class="lc-product-image-wrap">
                                    <img src="phuonganh/img/best-4-placeholder.jpg"
                                        alt="Sữa rửa mặt dịu nhẹ cho da nhạy cảm" />
                                </div>
                                <h3 class="lc-product-name">
                                    Sữa rửa mặt dịu nhẹ cho da nhạy cảm, làm sạch mà không gây khô căng
                                </h3>
                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">129.000đ / Chai</div>
                                    <div class="lc-product-price-original">152.000đ</div>
                                    <div class="lc-product-unit-pill">Chai 150ml</div>
                                </div>
                                <button class="lc-product-btn-buy" type="button">
                                    Chọn mua
                                </button>
                            </article>
                        </div>

                        <!-- Nút trượt qua phải (desktop) -->
                        <button class="lc-bestseller-next" type="button" id="bestsellerNext"
                            aria-label="Xem thêm sản phẩm bán chạy">
                            ›
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <!-- ========== DANH MỤC NỔI BẬT ========== -->
        <section class="lc-featured" aria-label="Danh mục nổi bật">
            <div class="lc-container">
                <header class="lc-section-header">
                    <div class="lc-section-header-icon">🏷️</div>
                    <h2 class="lc-section-header-title">Danh mục nổi bật</h2>
                </header>

                <div class="lc-featured-grid">
                    <!-- 1 -->
                    <article class="lc-featured-card">
                        <div class="lc-featured-icon-circle">
                            <img src="phuonganh/img/cat-brain-placeholder.png" alt="" />
                        </div>
                        <div class="lc-featured-name">Thần kinh não</div>
                        <div class="lc-featured-count">57 sản phẩm</div>
                    </article>

                    <!-- 2 -->
                    <article class="lc-featured-card">
                        <div class="lc-featured-icon-circle">
                            <img src="phuonganh/img/cat-vitamin-placeholder.png" alt="" />
                        </div>
                        <div class="lc-featured-name">Vitamin &amp; Khoáng chất</div>
                        <div class="lc-featured-count">113 sản phẩm</div>
                    </article>

                    <!-- 3 -->
                    <article class="lc-featured-card">
                        <div class="lc-featured-icon-circle">
                            <img src="phuonganh/img/cat-heart-placeholder.png" alt="" />
                        </div>
                        <div class="lc-featured-name">Sức khoẻ tim mạch</div>
                        <div class="lc-featured-count">23 sản phẩm</div>
                    </article>

                    <!-- 4 -->
                    <article class="lc-featured-card">
                        <div class="lc-featured-icon-circle">
                            <img src="phuonganh/img/cat-immune-placeholder.png" alt="" />
                        </div>
                        <div class="lc-featured-name">Tăng sức đề kháng, miễn dịch</div>
                        <div class="lc-featured-count">39 sản phẩm</div>
                    </article>

                    <!-- 5 -->
                    <article class="lc-featured-card">
                        <div class="lc-featured-icon-circle">
                            <img src="phuonganh/img/cat-digest-placeholder.png" alt="" />
                        </div>
                        <div class="lc-featured-name">Hỗ trợ tiêu hoá</div>
                        <div class="lc-featured-count">68 sản phẩm</div>
                    </article>

                    <!-- 6 -->
                    <article class="lc-featured-card">
                        <div class="lc-featured-icon-circle">
                            <img src="phuonganh/img/cat-hormone-placeholder.png" alt="" />
                        </div>
                        <div class="lc-featured-name">Sinh lý - Nội tiết tố</div>
                        <div class="lc-featured-count">42 sản phẩm</div>
                    </article>

                    <!-- 7 -->
                    <article class="lc-featured-card">
                        <div class="lc-featured-icon-circle">
                            <img src="phuonganh/img/cat-nutrition-placeholder.png" alt="" />
                        </div>
                        <div class="lc-featured-name">Dinh dưỡng</div>
                        <div class="lc-featured-count">37 sản phẩm</div>
                    </article>

                    <!-- 8 -->
                    <article class="lc-featured-card">
                        <div class="lc-featured-icon-circle">
                            <img src="phuonganh/img/cat-support-placeholder.png" alt="" />
                        </div>
                        <div class="lc-featured-name">Hỗ trợ điều trị</div>
                        <div class="lc-featured-count">125 sản phẩm</div>
                    </article>

                    <!-- 9 -->
                    <article class="lc-featured-card">
                        <div class="lc-featured-icon-circle">
                            <img src="phuonganh/img/cat-skin-placeholder.png" alt="" />
                        </div>
                        <div class="lc-featured-name">Giải pháp làn da</div>
                        <div class="lc-featured-count">88 sản phẩm</div>
                    </article>

                    <!-- 10 -->
                    <article class="lc-featured-card">
                        <div class="lc-featured-icon-circle">
                            <img src="phuonganh/img/cat-facecare-placeholder.png" alt="" />
                        </div>
                        <div class="lc-featured-name">Chăm sóc da mặt</div>
                        <div class="lc-featured-count">198 sản phẩm</div>
                    </article>

                    <!-- 11 -->
                    <article class="lc-featured-card">
                        <div class="lc-featured-icon-circle">
                            <img src="phuonganh/img/cat-beauty-placeholder.png" alt="" />
                        </div>
                        <div class="lc-featured-name">Hỗ trợ làm đẹp</div>
                        <div class="lc-featured-count">22 sản phẩm</div>
                    </article>

                    <!-- 12 -->
                    <article class="lc-featured-card">
                        <div class="lc-featured-icon-circle">
                            <img src="phuonganh/img/cat-sex-placeholder.png" alt="" />
                        </div>
                        <div class="lc-featured-name">Sức khoẻ giới tính</div>
                        <div class="lc-featured-count">41 sản phẩm</div>
                    </article>
                </div>
            </div>
        </section>

        <!-- ========== THƯƠNG HIỆU YÊU THÍCH ========== -->
        <section class="lc-favbrands" aria-label="Thương hiệu yêu thích">
            <div class="lc-container">
                <header class="lc-section-header">
                    <div class="lc-section-header-icon">⭐</div>
                    <h2 class="lc-section-header-title">Thương hiệu yêu thích</h2>
                </header>

                <div class="lc-favbrands-wrap">
                    <div class="lc-favbrands-list" id="favBrandsList">
                        <!-- Brand 1 -->
                        <article class="lc-favbrands-card">
                            <div class="lc-favbrands-top">
                                <img src="phuonganh/img/favbrand-1-top-placeholder.jpg" alt="Sản phẩm thương hiệu 1" />
                            </div>
                            <div class="lc-favbrands-bottom">
                                <div class="lc-favbrands-logo-pill">
                                    <img src="phuonganh/img/favbrand-1-logo-placeholder.png" alt="Jpanwell" />
                                    <span>Jpanwell</span>
                                </div>
                                <div class="lc-favbrands-discount">Giảm đến 35%</div>
                            </div>
                        </article>

                        <!-- Brand 2 -->
                        <article class="lc-favbrands-card">
                            <div class="lc-favbrands-top">
                                <img src="phuonganh/img/favbrand-2-top-placeholder.jpg" alt="Sản phẩm thương hiệu 2" />
                            </div>
                            <div class="lc-favbrands-bottom">
                                <div class="lc-favbrands-logo-pill">
                                    <img src="phuonganh/img/favbrand-2-logo-placeholder.png" alt="Ocalvit" />
                                    <span>Ocalvit</span>
                                </div>
                                <div class="lc-favbrands-discount">Giảm đến 20%</div>
                            </div>
                        </article>

                        <!-- Brand 3 -->
                        <article class="lc-favbrands-card">
                            <div class="lc-favbrands-top">
                                <img src="phuonganh/img/favbrand-3-top-placeholder.jpg" alt="Sản phẩm thương hiệu 3" />
                            </div>
                            <div class="lc-favbrands-bottom">
                                <div class="lc-favbrands-logo-pill">
                                    <img src="phuonganh/img/favbrand-3-logo-placeholder.png" alt="BRAUER" />
                                    <span>BRAUER</span>
                                </div>
                                <div class="lc-favbrands-discount">Giảm đến 20%</div>
                            </div>
                        </article>

                        <!-- Brand 4 -->
                        <article class="lc-favbrands-card">
                            <div class="lc-favbrands-top">
                                <img src="phuonganh/img/favbrand-4-top-placeholder.jpg" alt="Sản phẩm thương hiệu 4" />
                            </div>
                            <div class="lc-favbrands-bottom">
                                <div class="lc-favbrands-logo-pill">
                                    <img src="phuonganh/img/favbrand-4-logo-placeholder.png" alt="Vitamins For Life" />
                                    <span>Vitamins For Life</span>
                                </div>
                                <div class="lc-favbrands-discount">Giảm đến 20%</div>
                            </div>
                        </article>

                        <!-- Brand 5 -->
                        <article class="lc-favbrands-card">
                            <div class="lc-favbrands-top">
                                <img src="phuonganh/img/favbrand-5-top-placeholder.jpg" alt="Sản phẩm thương hiệu 5" />
                            </div>
                            <div class="lc-favbrands-bottom">
                                <div class="lc-favbrands-logo-pill">
                                    <img src="phuonganh/img/favbrand-5-logo-placeholder.png" alt="Vitabiotics" />
                                    <span>Vitabiotics</span>
                                </div>
                                <div class="lc-favbrands-discount">Giảm đến 20%</div>
                            </div>
                        </article>
                        <!-- Brand 6 -->
                        <article class="lc-favbrands-card">
                            <div class="lc-favbrands-top">
                                <img src="phuonganh/img/favbrand-6-top-placeholder.jpg" alt="Sản phẩm thương hiệu 5" />
                            </div>
                            <div class="lc-favbrands-bottom">
                                <div class="lc-favbrands-logo-pill">
                                    <img src="phuonganh/img/favbrand-6-logo-placeholder.png" alt="Vitabiotics" />
                                    <span>Vitabiotics</span>
                                </div>
                                <div class="lc-favbrands-discount">Giảm đến 20%</div>
                            </div>
                        </article>
                    </div>

                    <!-- nút trượt qua phải (desktop) -->
                    <button class="lc-favbrands-next" type="button" id="favBrandsNext"
                        aria-label="Xem thêm thương hiệu yêu thích">
                        ›
                    </button>
                </div>
            </div>
        </section>
        <!-- ========== TÍCH ĐIỂM ĐỔI QUÀ ========== -->
        <section class="lc-rewards" aria-label="Tích điểm đổi quà">
            <div class="lc-container">
                <div class="lc-rewards-box">
                    <!-- Header box -->
                    <header class="lc-rewards-box-header">
                        <!-- <div class="lc-section-header-icon">🎁</div> -->
                        <h2 class="lc-rewards-box-title">Danh sách quà tích luỹ</h2>
                    </header>

                    <div class="lc-rewards-body">
                        <!-- QUÀ NỔI BẬT BÊN TRÁI -->
                        <article class="lc-rewards-featured">
                            <div class="lc-rewards-featured-badge">Đổi nhiều nhất</div>

                            <div class="lc-rewards-featured-main">
                                <div class="lc-rewards-featured-image">
                                    <!-- Placeholder ảnh, chị thay sau -->
                                    <img src="phuonganh/img/reward-featured-placeholder.jpeg" alt="Bình giữ nhiệt Phương Anh" />
                                </div>

                                <div class="lc-rewards-featured-info">
                                    <h3 class="lc-rewards-featured-name">
                                        Gấu bông tích điểm Phương Anh
                                    </h3>
                                    <div class="lc-rewards-featured-points">
                                        20 điểm
                                    </div>
                                    <p class="lc-rewards-featured-desc">
                                        Gấu bông chất lượng cao, thiết kế đáng yêu không lỗi mốt đặc biệt có giá trị sư tầm
                                        rất lớn, các bé rất thích không bị lông rơi.
                                    </p>
                                    <button class="lc-rewards-btn-primary" type="button">
                                        Đổi ngay
                                    </button>
                                </div>
                            </div>
                        </article>

                        <!-- SLIDER QUÀ TẶNG BÊN PHẢI -->
                        <div class="lc-rewards-slider-wrap">
                            <div class="lc-rewards-slider" id="rewardsSlider">
                                <!-- Item 1 -->
                                <article class="lc-reward-card">
                                    <div class="lc-reward-card-image">
                                        <img src="phuonganh/img/reward-1-placeholder.png" alt="Phiếu mua hàng 50.000đ" />
                                    </div>
                                    <div class="lc-reward-card-body">
                                        <h3 class="lc-reward-card-name">
                                            Phiếu mua hàng 50.000đ
                                        </h3>
                                        <div class="lc-reward-card-points">
                                            500 điểm
                                        </div>
                                        <p class="lc-reward-card-desc">
                                            Áp dụng khi mua hàng tại hệ thống nhà thuốc Phương Anh, không giới hạn sản
                                            phẩm.
                                        </p>
                                        <button class="lc-rewards-btn-secondary" type="button">
                                            Đổi quà
                                        </button>
                                    </div>
                                </article>

                                <!-- Item 2 -->
                                <article class="lc-reward-card">
                                    <div class="lc-reward-card-image">
                                        <img src="phuonganh/img/reward-2-placeholder.jpg" alt="Ô gập 3 Phương Anh" />
                                    </div>
                                    <div class="lc-reward-card-body">
                                        <h3 class="lc-reward-card-name">
                                            Ô gập 3 Phương Anh chống tia UV
                                        </h3>
                                        <div class="lc-reward-card-points">
                                            1.200 điểm
                                        </div>
                                        <p class="lc-reward-card-desc">
                                            Thiết kế gọn nhẹ, phủ chống nắng, phù hợp sử dụng hàng ngày.
                                        </p>
                                        <button class="lc-rewards-btn-secondary" type="button">
                                            Đổi quà
                                        </button>
                                    </div>
                                </article>

                                <!-- Item 3 -->
                                <article class="lc-reward-card">
                                    <div class="lc-reward-card-image">
                                        <img src="phuonganh/img/reward-3-placeholder.webp" alt="Hộp đựng thuốc 7 ngăn" />
                                    </div>
                                    <div class="lc-reward-card-body">
                                        <h3 class="lc-reward-card-name">
                                            Hộp đựng thuốc 7 ngăn tiện lợi
                                        </h3>
                                        <div class="lc-reward-card-points">
                                            350 điểm
                                        </div>
                                        <p class="lc-reward-card-desc">
                                            Chia liều theo ngày, nhỏ gọn, mang theo khi đi làm hoặc đi du lịch.
                                        </p>
                                        <button class="lc-rewards-btn-secondary" type="button">
                                            Đổi quà
                                        </button>
                                    </div>
                                </article>

                                <!-- Item 4 -->
                                <article class="lc-reward-card">
                                    <div class="lc-reward-card-image">
                                        <img src="phuonganh/img/reward-4-placeholder.jpg" alt="Túi canvas Phương Anh" />
                                    </div>
                                    <div class="lc-reward-card-body">
                                        <h3 class="lc-reward-card-name">
                                            Túi canvas Phương Anh thân thiện môi trường
                                        </h3>
                                        <div class="lc-reward-card-points">
                                            800 điểm
                                        </div>
                                        <p class="lc-reward-card-desc">
                                            Tái sử dụng nhiều lần, phù hợp mang sách vở, laptop hoặc đi chợ.
                                        </p>
                                        <button class="lc-rewards-btn-secondary" type="button">
                                            Đổi quà
                                        </button>
                                    </div>
                                </article>
                            </div>

                            <!-- Nút trượt sang phải -->
                            <button class="lc-rewards-next" type="button" id="rewardsNext"
                                aria-label="Xem thêm quà tặng tích điểm">
                                ›
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ========== BỆNH THEO MÙA ========== -->
        <section class="lc-season" aria-label="Bệnh theo mùa">
            <div class="lc-container">
                <header class="lc-section-header">
                    <div class="lc-section-header-icon">➕</div>
                    <h2 class="lc-section-header-title">Bệnh theo mùa</h2>
                </header>

                <div class="lc-season-box">
                    <div class="lc-season-box-inner">
                        <!-- Tabs -->
                        <div class="lc-season-tabs">
                            <button class="lc-season-tab lc-season-tab--active" type="button"
                                data-target="season-dengue">
                                Sốt xuất huyết
                            </button>
                            <button class="lc-season-tab" type="button" data-target="season-hfm">
                                Tay chân miệng
                            </button>
                            <button class="lc-season-tab" type="button" data-target="season-zona">
                                Zona thần kinh
                            </button>
                            <button class="lc-season-tab" type="button" data-target="season-flu">
                                Cúm
                            </button>
                            <button class="lc-season-tab" type="button" data-target="season-pertussis">
                                Ho gà
                            </button>
                        </div>

                        <!-- PANEL: Sốt xuất huyết -->
                        <div class="lc-season-panel is-active" id="season-dengue">
                            <!-- Info bên trái -->
                            <aside class="lc-season-info">
                                <div>
                                    <h3 class="lc-season-info-title">Sốt xuất huyết đang gia tăng</h3>
                                    <div class="lc-season-info-body">
                                        <p>
                                            Sốt xuất huyết <strong>đang gia tăng nhanh chóng</strong>,
                                            nhiều ca trở nặng vì phát hiện trễ hoặc chủ quan.
                                        </p>
                                        <p>
                                            Trong gia đình, người lớn tuổi và trẻ nhỏ là những đối tượng
                                            dễ bị tổn thương nhất. Đừng để đến
                                            <strong>khi sốt cao, kiệt sức</strong> mới lo bù nước hay tăng đề kháng.
                                        </p>
                                    </div>
                                </div>

                                <div class="lc-season-info-cta">
                                    <button class="lc-season-cta-btn" type="button">
                                        Khám phá ngay giải pháp
                                    </button>
                                    <div class="lc-season-mascot">
                                        <!-- Placeholder mascot -->
                                        <img src="images/season-mascot-placeholder.png" alt="Phương Anh mascot" />
                                    </div>
                                </div>
                            </aside>

                            <!-- Sản phẩm bên phải -->
                            <div class="lc-season-products-wrap">
                                <div class="lc-season-products" id="seasonProductsDengue">
                                    <!-- Card 1 -->
                                    <article class="lc-product-card--season">
                                        <div class="lc-product-image-wrap">
                                            <img src="phuonganh/img/season-dengue-1-placeholder.jpg"
                                                alt="Nhiệt kế điện tử Omron MC-246" />
                                        </div>
                                        <h3 class="lc-product-name">
                                            Nhiệt kế điện tử Omron MC-246 đo nhiệt độ cho trẻ khi sốt
                                        </h3>
                                        <div class="lc-product-price-row">
                                            <div class="lc-product-price-sale">125.000đ / Hộp</div>
                                            <div class="lc-product-price-original">145.000đ</div>
                                            <div class="lc-product-unit-pill">Hộp</div>
                                        </div>
                                        <button class="lc-product-btn-buy" type="button">
                                            Chọn mua
                                        </button>
                                    </article>

                                    <!-- Card 2 -->
                                    <article class="lc-product-card--season">
                                        <div class="lc-product-image-wrap">
                                            <img src="phuonganh/img/season-dengue-2-placeholder.jpeg"
                                                alt="Nhiệt kế hồng ngoại Microlife" />
                                        </div>
                                        <h3 class="lc-product-name">
                                            Nhiệt kế hồng ngoại Microlife đo không chạm, nhanh, chính xác
                                        </h3>
                                        <div class="lc-product-price-row">
                                            <div class="lc-product-price-sale">990.000đ / Hộp</div>
                                            <div class="lc-product-price-original">1.150.000đ</div>
                                            <div class="lc-product-unit-pill">Hộp</div>
                                        </div>
                                        <button class="lc-product-btn-buy" type="button">
                                            Chọn mua
                                        </button>
                                    </article>

                                    <!-- Card 3 -->
                                    <article class="lc-product-card--season">
                                        <div class="lc-product-image-wrap">
                                            <img src="phuonganh/img/season-dengue-3-placeholder.jpg"
                                                alt="Nhiệt kế hồng ngoại Yuwell YT-1C" />
                                        </div>
                                        <h3 class="lc-product-name">
                                            Nhiệt kế hồng ngoại Yuwell YT-1C đo nhiệt độ cơ thể
                                        </h3>
                                        <div class="lc-product-price-row">
                                            <div class="lc-product-price-sale">590.000đ / Hộp</div>
                                            <div class="lc-product-price-original">730.000đ</div>
                                            <div class="lc-product-unit-pill">Hộp</div>
                                        </div>
                                        <button class="lc-product-btn-buy" type="button">
                                            Chọn mua
                                        </button>
                                    </article>

                                    <!-- Card 4 -->
                                    <article class="lc-product-card--season">
                                        <div class="lc-product-image-wrap">
                                            <img src="phuonganh/img/season-dengue-4-placeholder.jpg"
                                                alt="Nhiệt kế điện tử Fuji DT007" />
                                        </div>
                                        <h3 class="lc-product-name">
                                            Nhiệt kế điện tử Fuji DT007 đo nhiệt độ cơ thể
                                        </h3>
                                        <div class="lc-product-price-row">
                                            <div class="lc-product-price-sale">69.000đ / Hộp</div>
                                            <div class="lc-product-price-original">89.000đ</div>
                                            <div class="lc-product-unit-pill">Hộp</div>
                                        </div>
                                        <button class="lc-product-btn-buy" type="button">
                                            Chọn mua
                                        </button>
                                    </article>
                                </div>

                                <button class="lc-season-next" type="button" id="seasonDengueNext"
                                    aria-label="Xem thêm sản phẩm hỗ trợ sốt xuất huyết">
                                    ›
                                </button>
                            </div>
                        </div>

                        <!-- Các panel khác (placeholder, cùng layout) -->
                        <div class="lc-season-panel" id="season-hfm">
                            <aside class="lc-season-info">
                                <div>
                                    <h3 class="lc-season-info-title">Tay chân miệng ở trẻ nhỏ</h3>
                                    <div class="lc-season-info-body">
                                        <p>
                                            Bệnh tay chân miệng thường gặp ở trẻ dưới 5 tuổi, lây lan
                                            nhanh trong môi trường nhà trẻ, mẫu giáo.
                                        </p>
                                        <p>
                                            Vệ sinh tay, đồ chơi, khu vực sinh hoạt và
                                            <strong>theo dõi sát dấu hiệu sốt, mệt</strong> giúp phát hiện sớm
                                            và điều trị kịp thời.
                                        </p>
                                    </div>
                                </div>
                                <div class="lc-season-info-cta">
                                    <button class="lc-season-cta-btn" type="button">
                                        Xem gợi ý sản phẩm
                                    </button>
                                    <div class="lc-season-mascot">
                                        <img src="images/season-mascot-placeholder.png" alt="" />
                                    </div>
                                </div>
                            </aside>

                            <div class="lc-season-products-wrap">
                                <div class="lc-season-products" id="seasonProductsHFM">
                                    <!-- chỉ để mẫu, chị có thể thay nội dung thật -->
                                    <article class="lc-product-card--season">
                                        <div class="lc-product-image-wrap">
                                            <img src="images/season-hfm-1-placeholder.jpg"
                                                alt="Nước súc miệng cho bé" />
                                        </div>
                                        <h3 class="lc-product-name">
                                            Nước súc miệng dịu nhẹ cho bé hỗ trợ làm sạch khoang miệng
                                        </h3>
                                        <div class="lc-product-price-row">
                                            <div class="lc-product-price-sale">89.000đ / Chai</div>
                                            <div class="lc-product-price-original">105.000đ</div>
                                            <div class="lc-product-unit-pill">Chai 250ml</div>
                                        </div>
                                        <button class="lc-product-btn-buy" type="button">Chọn mua</button>
                                    </article>

                                    <article class="lc-product-card--season">
                                        <div class="lc-product-image-wrap">
                                            <img src="images/season-hfm-2-placeholder.jpg"
                                                alt="Dung dịch sát khuẩn tay" />
                                        </div>
                                        <h3 class="lc-product-name">
                                            Dung dịch sát khuẩn tay nhanh dùng cho cả gia đình
                                        </h3>
                                        <div class="lc-product-price-row">
                                            <div class="lc-product-price-sale">55.000đ / Chai</div>
                                            <div class="lc-product-price-original">68.000đ</div>
                                            <div class="lc-product-unit-pill">Chai 100ml</div>
                                        </div>
                                        <button class="lc-product-btn-buy" type="button">Chọn mua</button>
                                    </article>
                                </div>
                            </div>
                        </div>

                        <!-- Panel: Zona thần kinh (placeholder) -->
                        <div class="lc-season-panel" id="season-zona">
                            <aside class="lc-season-info">
                                <div>
                                    <h3 class="lc-season-info-title">Zona thần kinh</h3>
                                    <div class="lc-season-info-body">
                                        <p>
                                            Zona thường gây đau rát, nổi mụn nước dọc theo đường thần kinh,
                                            hay gặp ở người lớn tuổi hoặc người suy giảm miễn dịch.
                                        </p>
                                        <p>
                                            Nên <strong>thăm khám sớm</strong> khi có triệu chứng, không tự ý
                                            chọc vỡ mụn nước để hạn chế sẹo và biến chứng.
                                        </p>
                                    </div>
                                </div>
                                <div class="lc-season-info-cta">
                                    <button class="lc-season-cta-btn" type="button">
                                        Xem gợi ý chăm sóc
                                    </button>
                                    <div class="lc-season-mascot">
                                        <img src="images/season-mascot-placeholder.png" alt="" />
                                    </div>
                                </div>
                            </aside>
                            <div class="lc-season-products-wrap">
                                <div class="lc-season-products" id="seasonProductsZona">
                                    <article class="lc-product-card--season">
                                        <div class="lc-product-image-wrap">
                                            <img src="images/season-zona-1-placeholder.jpg" alt="Kem bôi da dịu mát" />
                                        </div>
                                        <h3 class="lc-product-name">
                                            Kem bôi da dịu mát giúp làm mềm vùng da tổn thương
                                        </h3>
                                        <div class="lc-product-price-row">
                                            <div class="lc-product-price-sale">140.000đ / Tuýp</div>
                                            <div class="lc-product-price-original">165.000đ</div>
                                            <div class="lc-product-unit-pill">Tuýp 30g</div>
                                        </div>
                                        <button class="lc-product-btn-buy" type="button">Chọn mua</button>
                                    </article>
                                </div>
                            </div>
                        </div>

                        <!-- Panel: Cúm (placeholder) -->
                        <div class="lc-season-panel" id="season-flu">
                            <aside class="lc-season-info">
                                <div>
                                    <h3 class="lc-season-info-title">Cúm theo mùa</h3>
                                    <div class="lc-season-info-body">
                                        <p>
                                            Cúm lan truyền qua đường hô hấp, dễ bùng phát khi thời tiết
                                            thay đổi, thời gian ở trong phòng kín nhiều.
                                        </p>
                                        <p>
                                            Tiêm vắc xin cúm hàng năm, giữ ấm cơ thể và
                                            <strong>đeo khẩu trang</strong> khi đến nơi đông người là những
                                            biện pháp phòng ngừa đơn giản nhưng hiệu quả.
                                        </p>
                                    </div>
                                </div>
                                <div class="lc-season-info-cta">
                                    <button class="lc-season-cta-btn" type="button">
                                        Gợi ý sản phẩm hỗ trợ
                                    </button>
                                    <div class="lc-season-mascot">
                                        <img src="images/season-mascot-placeholder.png" alt="" />
                                    </div>
                                </div>
                            </aside>
                            <div class="lc-season-products-wrap">
                                <div class="lc-season-products" id="seasonProductsFlu">
                                    <article class="lc-product-card--season">
                                        <div class="lc-product-image-wrap">
                                            <img src="images/season-flu-1-placeholder.jpg" alt="Siro ho cảm" />
                                        </div>
                                        <h3 class="lc-product-name">
                                            Siro ho cảm thảo dược hỗ trợ giảm ho, đau rát họng
                                        </h3>
                                        <div class="lc-product-price-row">
                                            <div class="lc-product-price-sale">95.000đ / Chai</div>
                                            <div class="lc-product-price-original">115.000đ</div>
                                            <div class="lc-product-unit-pill">Chai 100ml</div>
                                        </div>
                                        <button class="lc-product-btn-buy" type="button">Chọn mua</button>
                                    </article>
                                </div>
                            </div>
                        </div>

                        <!-- Panel: Ho gà (placeholder) -->
                        <div class="lc-season-panel" id="season-pertussis">
                            <aside class="lc-season-info">
                                <div>
                                    <h3 class="lc-season-info-title">Ho gà</h3>
                                    <div class="lc-season-info-body">
                                        <p>
                                            Ho gà là bệnh nhiễm khuẩn đường hô hấp lây qua giọt bắn, có
                                            thể gây ho kéo dài, nguy hiểm với trẻ sơ sinh.
                                        </p>
                                        <p>
                                            Tiêm phòng đầy đủ và <strong>theo dõi sát triệu chứng khó thở</strong>
                                            giúp giảm nguy cơ biến chứng nặng.
                                        </p>
                                    </div>
                                </div>
                                <div class="lc-season-info-cta">
                                    <button class="lc-season-cta-btn" type="button">
                                        Xem sản phẩm liên quan
                                    </button>
                                    <div class="lc-season-mascot">
                                        <img src="images/season-mascot-placeholder.png" alt="" />
                                    </div>
                                </div>
                            </aside>
                            <div class="lc-season-products-wrap">
                                <div class="lc-season-products" id="seasonProductsPertussis">
                                    <article class="lc-product-card--season">
                                        <div class="lc-product-image-wrap">
                                            <img src="images/season-pertussis-1-placeholder.jpg" alt="Xịt họng" />
                                        </div>
                                        <h3 class="lc-product-name">
                                            Xịt họng thảo dược hỗ trợ giảm ho, giảm kích ứng họng
                                        </h3>
                                        <div class="lc-product-price-row">
                                            <div class="lc-product-price-sale">120.000đ / Chai</div>
                                            <div class="lc-product-price-original">145.000đ</div>
                                            <div class="lc-product-unit-pill">Chai 20ml</div>
                                        </div>
                                        <button class="lc-product-btn-buy" type="button">Chọn mua</button>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ========== GÓC SỨC KHỎE ========== -->
        <section class="lc-health" aria-label="Góc sức khoẻ">
            <div class="lc-container">
                <!-- Header -->
                <div class="lc-health-header">
                    <div class="lc-health-title-wrap">
                        <div class="lc-section-header-icon">📚</div>
                        <h2 class="lc-health-title">Góc sức khoẻ</h2>
                    </div>
                    <div class="lc-health-viewall">
                        <span>Xem tất cả</span>
                        <span>›</span>
                    </div>
                </div>

                <!-- Tag chủ đề -->
                <div class="lc-health-tags">
                    <button class="lc-health-tag lc-health-tag--active" type="button">
                        Dinh dưỡng
                    </button>
                    <button class="lc-health-tag" type="button">
                        Phòng chữa bệnh
                    </button>
                    <button class="lc-health-tag" type="button">
                        Người cao tuổi
                    </button>
                    <button class="lc-health-tag" type="button">
                        Khỏe đẹp
                    </button>
                    <button class="lc-health-tag" type="button">
                        Mẹ và bé
                    </button>
                    <button class="lc-health-tag" type="button">
                        Giới tính
                    </button>
                    <button class="lc-health-tag" type="button">
                        Tin tức khuyến mại
                    </button>
                    <button class="lc-health-tag" type="button">
                        Tin tức sức khoẻ
                    </button>
                </div>

                <!-- Content -->
                <div class="lc-health-content">
                    <!-- Bài lớn bên trái -->
                    <article class="lc-health-main-card">
                        <div class="lc-health-main-image">
                            <!-- Placeholder, chị thay bằng ảnh thật -->
                            <img src="phuonganh/img/health-main-placeholder.jpg"
                                alt="Sự kiện" />
                            <div class="lc-health-main-chip">
                                <span class="lc-health-main-chip-dot"></span>
                                <span>Truyền thông</span>
                            </div>
                        </div>
                        <div class="lc-health-main-body">
                            <h3 class="lc-health-main-title">
                                Nhà thuốc Phương Anh luôn tìm những đối tác chất lượng
                            </h3>
                            <p class="lc-health-main-excerpt">
                                Trong năm 2025 Hệ thống nhà thuốc Phương Anh đã liên tục kết hợp
                                với những đối tác chất lượng và Uy tín hàng đầu. Lựa chọn kỹ lưỡng
                                và tìm kiếm những sản phẩm hàng đầu thế giới
                            </p>
                        </div>
                    </article>

                    <!-- Danh sách bài bên phải -->
                    <div class="lc-health-side-list">
                        <!-- Item 1 -->
                        <article class="lc-health-side-item">
                            <div class="lc-health-side-thumb">
                                <img src="phuonganh/img/health-side-1-placeholder.jpg"
                                    alt=" cùng Abbott chăm sóc sức khoẻ cộng đồng" />
                            </div>
                            <div class="lc-health-side-body">
                                <div class="lc-health-side-chip">Truyền thông</div>
                                <h4 class="lc-health-side-title">
                                    Phương Anh cùng Kyolic – Giải pháp chăm sóc sức khoẻ cho mắt an toàn
                                    và hiệu quả
                                </h4>
                            </div>
                        </article>

                        <!-- Item 2 -->
                        <article class="lc-health-side-item">
                            <div class="lc-health-side-thumb">
                                <img src="phuonganh/img/health-side-2-placeholder.jpg" alt="Thương gửi khúc ruột miền Trung" />
                            </div>
                            <div class="lc-health-side-body">
                                <div class="lc-health-side-chip">Truyền thông</div>
                                <h4 class="lc-health-side-title">
                                    Phương Anh cùng LiveSpo - Giải pháp đặc biệt cho sức khoẻ, 1 giải pháp 
                                    cho tương lai không kháng sinh
                                </h4>
                            </div>
                        </article>

                        <!-- Item 3 -->
                        <article class="lc-health-side-item">
                            <div class="lc-health-side-thumb">
                                <img src="phuonganh/img/health-side-3-placeholder.jpg"
                                    alt="Hợp tác lịch sử với Bộ Y tế, Bayer…" />
                            </div>
                            <div class="lc-health-side-body">
                                <div class="lc-health-side-chip">Truyền thông</div>
                                <h4 class="lc-health-side-title">
                                    Phương Anh triển khai hỗ trợ khắc phục hậu quả sau lũ của cơn bão số
                                    12 tại thành phố Cao Bằng
                                </h4>
                            </div>
                        </article>

                        <!-- Item 4 -->
                        <article class="lc-health-side-item">
                            <div class="lc-health-side-thumb">
                                <img src="phuonganh/img/health-side-4-placeholder.jpg"
                                    alt="Phương Anh hợp tác giải pháp tiên tiến cho người bệnh tiểu đường" />
                            </div>
                            <div class="lc-health-side-body">
                                <div class="lc-health-side-chip">Truyền thông</div>
                                <h4 class="lc-health-side-title">
                                    Nhà thuốc Phương Anh tổ chức sự kiến Vote: Duyên dáng Phương Anh
                                </h4>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
        <!-- ========== BỆNH (THEO ĐỐI TƯỢNG) ========== -->
        <section class="lc-disease" aria-label="Bệnh theo đối tượng">
            <div class="lc-container">
                <!-- Header -->
                <div class="lc-disease-header">
                    <div class="lc-disease-title-wrap">
                        <div class="lc-section-header-icon">➕</div>
                        <h2 class="lc-disease-title">Bệnh</h2>
                    </div>
                    <div class="lc-disease-viewall">
                        <span>Xem tất cả</span>
                        <span>›</span>
                    </div>
                </div>

                <!-- Switch -->
                <div class="lc-disease-switch">
                    <button class="lc-disease-switch-btn lc-disease-switch-btn--active" type="button"
                        data-mode="by-subject">
                        Bệnh theo đối tượng
                    </button>
                    <button class="lc-disease-switch-btn" type="button" data-mode="by-season">
                        Bệnh theo mùa
                    </button>
                </div>

                <!-- Grid 4 card -->
                <div class="lc-disease-grid" id="diseaseBySubject">
                    <!-- Bệnh nam giới -->
                    <article class="lc-disease-card">
                        <div class="lc-disease-card-image">
                            <img src="phuonganh/img/disease-men-placeholder.webp" alt="Bệnh nam giới" />
                        </div>
                        <div class="lc-disease-card-body">
                            <h3 class="lc-disease-card-title">BỆNH NAM GIỚI</h3>
                            <ul class="lc-disease-card-list">
                                <li>Loãng xương ở nam</li>
                                <li>Di tinh, mộng tinh</li>
                                <li>Hẹp bao quy đầu</li>
                                <li>Yếu sinh lý</li>
                            </ul>
                            <div class="lc-disease-card-more">
                                <button class="lc-disease-card-btn" type="button">
                                    <span>Tìm hiểu thêm</span>
                                    <span>›</span>
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- Bệnh nữ giới -->
                    <article class="lc-disease-card">
                        <div class="lc-disease-card-image">
                            <img src="phuonganh/img/disease-women-placeholder.png" alt="Bệnh nữ giới" />
                        </div>
                        <div class="lc-disease-card-body">
                            <h3 class="lc-disease-card-title">BỆNH NỮ GIỚI</h3>
                            <ul class="lc-disease-card-list">
                                <li>Hội chứng tiền kinh nguyệt</li>
                                <li>Hội chứng tiền mãn kinh</li>
                                <li>Chậm kinh</li>
                                <li>Mất kinh</li>
                            </ul>
                            <div class="lc-disease-card-more">
                                <button class="lc-disease-card-btn" type="button">
                                    <span>Tìm hiểu thêm</span>
                                    <span>›</span>
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- Bệnh người già -->
                    <article class="lc-disease-card">
                        <div class="lc-disease-card-image">
                            <img src="phuonganh/img/disease-elder-placeholder.webp" alt="Bệnh người già" />
                        </div>
                        <div class="lc-disease-card-body">
                            <h3 class="lc-disease-card-title">BỆNH NGƯỜI GIÀ</h3>
                            <ul class="lc-disease-card-list">
                                <li>Alzheimer</li>
                                <li>Parkinson</li>
                                <li>Parkinson thứ phát</li>
                                <li>Đục thuỷ tinh thể ở người già</li>
                            </ul>
                            <div class="lc-disease-card-more">
                                <button class="lc-disease-card-btn" type="button">
                                    <span>Tìm hiểu thêm</span>
                                    <span>›</span>
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- Bệnh trẻ em -->
                    <article class="lc-disease-card">
                        <div class="lc-disease-card-image">
                            <img src="phuonganh/img/disease-kids-placeholder.jpg" alt="Bệnh trẻ em" />
                        </div>
                        <div class="lc-disease-card-body">
                            <h3 class="lc-disease-card-title">BỆNH TRẺ EM</h3>
                            <ul class="lc-disease-card-list">
                                <li>Bại não trẻ em</li>
                                <li>Tự kỷ</li>
                                <li>Uốn ván</li>
                                <li>Tắc ruột sơ sinh</li>
                            </ul>
                            <div class="lc-disease-card-more">
                                <button class="lc-disease-card-btn" type="button">
                                    <span>Tìm hiểu thêm</span>
                                    <span>›</span>
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <!-- ========== FOOTER ========== -->
        <footer class="lc-footer">
            <!-- Thanh xanh trên -->
            <div class="lc-footer-top">
                <div class="lc-container">
                    <div class="lc-footer-top-inner">
                        <div class="lc-footer-top-left">
                            <div class="lc-footer-top-left-icon">📍</div>
                            <div>Danh sách hệ thống 16 cửa hàng tại Cao Bằng</div>
                        </div>
                        <button onclick="window.location.href='{{ route('website.near-branches') }}'" class="lc-footer-top-btn" type="button">
                            <span>Xem danh sách nhà thuốc</span>
                            <span>›</span>
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
                                <li><a href="#">Tiêm chủng Phương Anh</a></li>
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

    </main>

    <script>
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

</body>

</html>