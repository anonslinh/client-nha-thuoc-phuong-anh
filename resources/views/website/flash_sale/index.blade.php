@extends('website.layout.index')

@section('style')
<style>
    .fs-page{
        padding: 28px 0 56px;
        background:
            radial-gradient(circle at top left, rgba(255, 120, 40, .10), transparent 32%),
            radial-gradient(circle at top right, rgba(255, 50, 50, .10), transparent 28%),
            #f6f8fc;
    }

    .fs-container{
        width: min(1320px, calc(100% - 32px));
        margin: 0 auto;
    }

    .fs-breadcrumb{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
        font-size: 14px;
        color: #667085;
    }

    .fs-breadcrumb a{
        color: #0ea5c6;
        text-decoration: none;
    }

    .fs-breadcrumb a:hover{
        text-decoration: underline;
    }

    .fs-hero{
        position: relative;
        overflow: hidden;
        border-radius: 30px;
        padding: 34px 36px;
        background:
            radial-gradient(circle at 20% 30%, rgba(255,255,255,.16), transparent 18%),
            radial-gradient(circle at 85% 20%, rgba(255,255,255,.10), transparent 18%),
            linear-gradient(135deg, #ff6a00 0%, #ff3c2e 48%, #ff174b 100%);
        color: #fff;
        box-shadow: 0 26px 56px rgba(255, 79, 34, .24);
        margin-bottom: 22px;
    }

    .fs-hero::after{
        content: "";
        position: absolute;
        right: -40px;
        bottom: -40px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
        filter: blur(6px);
    }

    .fs-hero-badge{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(255,255,255,.16);
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 14px;
        position: relative;
        z-index: 1;
    }

    .fs-hero h1{
        margin: 0 0 10px;
        font-size: 42px;
        line-height: 1.15;
        font-weight: 900;
        position: relative;
        z-index: 1;
    }

    .fs-hero p{
        margin: 0;
        max-width: 880px;
        font-size: 17px;
        line-height: 1.8;
        color: rgba(255,255,255,.94);
        position: relative;
        z-index: 1;
    }

    .fs-toolbar{
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 16px;
        margin-bottom: 20px;
        align-items: center;
    }

    .fs-session-tabs{
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding-bottom: 4px;
        scrollbar-width: none;
    }

    .fs-session-tabs::-webkit-scrollbar{
        display: none;
    }

    .fs-session-tab{
        min-width: 150px;
        padding: 14px 14px 12px;
        border-radius: 20px;
        text-decoration: none;
        color: #0f172a;
        background: #fff;
        border: 1px solid #e6edf5;
        box-shadow: 0 10px 26px rgba(15, 23, 42, 0.05);
        transition: all .2s ease;
    }

    .fs-session-tab:hover{
        transform: translateY(-2px);
        border-color: #ff6a00;
    }

    .fs-session-tab--active{
        background: linear-gradient(135deg, #ff6a00 0%, #ff3c2e 100%);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 16px 34px rgba(255, 79, 34, .22);
    }

    .fs-session-time{
        display: block;
        font-size: 18px;
        line-height: 1.3;
        font-weight: 900;
        margin-bottom: 4px;
    }

    .fs-session-date{
        display: block;
        font-size: 13px;
        opacity: .92;
        margin-bottom: 8px;
        font-weight: 700;
    }

    .fs-session-status{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 28px;
        padding: 0 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        background: #f7f8fa;
        color: #667085;
    }

    .fs-session-tab--active .fs-session-status{
        background: rgba(255,255,255,.16);
        color: #fff;
    }

    .fs-countdown-card{
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 18px;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 14px 32px rgba(15, 23, 42, 0.07);
        white-space: nowrap;
    }

    .fs-countdown-label{
        font-size: 14px;
        color: #475467;
        font-weight: 800;
    }

    .fs-timer{
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .fs-timer-box{
        min-width: 46px;
        height: 46px;
        border-radius: 14px;
        background: linear-gradient(180deg, #101828 0%, #2b3445 100%);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 900;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.05);
    }

    .fs-timer-sep{
        font-size: 20px;
        font-weight: 900;
        color: #0f172a;
    }

    .fs-meta-grid{
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .fs-meta-card{
        background: #fff;
        border-radius: 22px;
        padding: 18px 20px;
        box-shadow: 0 14px 32px rgba(15, 23, 42, 0.06);
    }

    .fs-meta-label{
        font-size: 13px;
        color: #667085;
        margin-bottom: 6px;
        font-weight: 700;
    }

    .fs-meta-value{
        font-size: 26px;
        line-height: 1.25;
        color: #0f172a;
        font-weight: 900;
    }

    .fs-meta-sub{
        margin-top: 4px;
        font-size: 13px;
        color: #667085;
    }

    .fs-grid{
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .fs-product-card{
        position: relative;
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
        border: 1px solid #edf2f7;
        transition: transform .2s ease, box-shadow .2s ease;
        display: flex;
        flex-direction: column;
    }

    .fs-product-card:hover{
        transform: translateY(-4px);
        box-shadow: 0 22px 44px rgba(15, 23, 42, 0.12);
    }

    .fs-product-card--soldout{
        opacity: .72;
    }

    .fs-discount-badge{
        position: absolute;
        top: 14px;
        left: 14px;
        z-index: 3;
        min-height: 34px;
        padding: 0 12px;
        border-radius: 999px;
        background: linear-gradient(135deg, #ff2d2d 0%, #ff6a00 100%);
        color: #fff;
        font-size: 15px;
        font-weight: 900;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 22px rgba(255, 79, 34, .28);
    }

    .fs-hot-badge{
        position: absolute;
        top: 14px;
        right: 14px;
        z-index: 3;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-height: 34px;
        padding: 0 12px;
        border-radius: 999px;
        background: rgba(15, 23, 42, .88);
        color: #fff;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .2px;
    }

    .fs-hot-badge .fs-fire{
        display: inline-block;
        filter: drop-shadow(0 0 10px rgba(255, 136, 0, .45));
        animation: fsFlame .9s ease-in-out infinite;
        transform-origin: center bottom;
    }

    @keyframes fsFlame{
        0%, 100%{ transform: rotate(-4deg) scale(1); opacity: 1; }
        50%{ transform: rotate(4deg) scale(1.18); opacity: .92; }
    }

    .fs-product-link{
        display: block;
        color: inherit;
        text-decoration: none;
    }

    .fs-product-thumb{
        aspect-ratio: 1/1;
        background: linear-gradient(180deg, #fbfcfe 0%, #f0f4f8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px;
    }

    .fs-product-thumb img{
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }

    .fs-product-body{
        padding: 18px 18px 0;
    }

    .fs-product-name{
        margin: 0 0 10px;
        font-size: 18px;
        line-height: 1.48;
        font-weight: 800;
        color: #0f172a;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 54px;
    }

    .fs-product-desc{
        margin: 0 0 12px;
        font-size: 14px;
        line-height: 1.65;
        color: #667085;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 46px;
    }

    .fs-price-row{
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 14px;
    }

    .fs-price-sale{
        font-size: 26px;
        line-height: 1.2;
        font-weight: 900;
        color: #ff3c2e;
    }

    .fs-price-original{
        font-size: 16px;
        color: #98a2b3;
        text-decoration: line-through;
        font-weight: 700;
    }

    .fs-stock-box{
        margin-top: 6px;
        padding: 14px;
        border-radius: 18px;
        background: linear-gradient(180deg, #fff8f2 0%, #fff4ec 100%);
        border: 1px solid #ffe1d1;
    }

    .fs-stock-top{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 8px;
    }

    .fs-stock-sold{
        font-size: 13px;
        color: #7a3f17;
        font-weight: 800;
    }

    .fs-stock-remain{
        font-size: 13px;
        color: #b54708;
        font-weight: 900;
    }

    .fs-progress{
        position: relative;
        height: 14px;
        border-radius: 999px;
        background: #ffd9c4;
        overflow: hidden;
    }

    .fs-progress-bar{
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #ff8a00 0%, #ff4d2d 60%, #ff174b 100%);
    }

    .fs-progress-bar--hot{
        box-shadow: 0 0 16px rgba(255, 102, 0, .48);
        animation: fsPulse 1.1s ease-in-out infinite;
    }

    @keyframes fsPulse{
        0%, 100%{ filter: brightness(1); }
        50%{ filter: brightness(1.18); }
    }

    .fs-progress-fire{
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 15px;
        animation: fsFlame 1s ease-in-out infinite;
        filter: drop-shadow(0 0 8px rgba(255, 125, 0, .5));
    }

    .fs-product-actions{
        padding: 16px 18px 18px;
        margin-top: auto;
    }

    .fs-buy-btn{
        width: 100%;
        min-height: 48px;
        padding: 0 16px;
        border-radius: 14px;
        border: 0;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 900;
        background: linear-gradient(135deg, #12b8d4 0%, #1687cb 100%);
        color: #fff;
        box-shadow: 0 12px 24px rgba(20, 144, 207, .16);
        transition: transform .2s ease, opacity .2s ease;
    }

    .fs-buy-btn:hover{
        transform: translateY(-1px);
    }

    .fs-buy-btn--disabled{
        background: linear-gradient(135deg, #98a2b3 0%, #667085 100%);
        box-shadow: none;
        pointer-events: none;
    }

    .fs-empty{
        background: #fff;
        border-radius: 24px;
        padding: 34px 22px;
        text-align: center;
        color: #667085;
        box-shadow: 0 14px 32px rgba(15,23,42,.06);
    }

    @media (max-width: 1399px){
        .fs-grid{
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 1199px){
        .fs-toolbar{
            grid-template-columns: 1fr;
        }

        .fs-meta-grid{
            grid-template-columns: 1fr;
        }

        .fs-grid{
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px){
        .fs-page{
            padding: 20px 0 40px;
        }

        .fs-container{
            width: min(100%, calc(100% - 20px));
        }

        .fs-hero{
            padding: 24px 18px;
            border-radius: 22px;
        }

        .fs-hero h1{
            font-size: 28px;
        }

        .fs-hero p{
            font-size: 15px;
        }

        .fs-countdown-card{
            flex-direction: column;
            align-items: flex-start;
        }

        .fs-grid{
            grid-template-columns: 1fr;
        }

        .fs-product-thumb{
            padding: 24px;
        }

        .fs-price-sale{
            font-size: 22px;
        }
    }
</style>
@endsection

@section('content')
@php
    $selectedFlashSale = $selectedFlashSale ?? null;
    $selectedFlashSaleProducts = $selectedFlashSaleProducts ?? collect();
    $flashSaleSessions = $flashSaleSessions ?? collect();

    $countProducts = $selectedFlashSaleProducts->count();
    $sumSold = $selectedFlashSaleProducts->sum('sold');
    $sumQty = $selectedFlashSaleProducts->sum('quantity');
@endphp

<section class="fs-page">
    <div class="fs-container">
        <nav class="fs-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <span>/</span>
            <span>Flash Sale</span>
            @if($selectedFlashSale)
                <span>/</span>
                <span>{{ $selectedFlashSale->date_label }}</span>
            @endif
        </nav>

        <div class="fs-hero">
            <div class="fs-hero-badge">
                <span>⚡</span>
                <span>Ưu đãi giới hạn thời gian</span>
            </div>
            <h1>Flash Sale giá sốc mỗi ngày</h1>
            <p>
                Săn deal nhanh với các phiên Flash Sale cập nhật liên tục. Giá tốt, số lượng có hạn,
                càng gần hết hàng càng nóng hơn với hiệu ứng cháy deal như trên các sàn thương mại điện tử.
            </p>
        </div>

        @if($flashSaleSessions->count() > 0 && $selectedFlashSale)
            <div class="fs-toolbar">
                <div class="fs-session-tabs">
                    @foreach($flashSaleSessions as $session)
                        <a
                            href="{{ route('website.flash-sale.index', ['session' => $session->id]) }}"
                            class="fs-session-tab {{ $selectedFlashSale->id == $session->id ? 'fs-session-tab--active' : '' }}"
                        >
                            <span class="fs-session-time">{{ $session->time_label }}</span>
                            <span class="fs-session-date">{{ $session->date_label }}</span>
                            <span class="fs-session-status">{{ $session->status_label }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="fs-countdown-card">
                    <div class="fs-countdown-label" id="fsCountdownLabel">
                        {{ $selectedFlashSale->status_key === 'upcoming' ? 'Bắt đầu sau' : ($selectedFlashSale->status_key === 'active' ? 'Kết thúc sau' : 'Phiên đã kết thúc') }}
                    </div>
                    <div class="fs-timer" id="fsTimer"
                        data-status="{{ $selectedFlashSale->status_key }}"
                        data-start-at="{{ $selectedFlashSale->start_at_iso }}"
                        data-end-at="{{ $selectedFlashSale->end_at_iso }}"
                    >
                        <div class="fs-timer-box" data-unit="hours">00</div>
                        <div class="fs-timer-sep">:</div>
                        <div class="fs-timer-box" data-unit="minutes">00</div>
                        <div class="fs-timer-sep">:</div>
                        <div class="fs-timer-box" data-unit="seconds">00</div>
                    </div>
                </div>
            </div>

            <div class="fs-meta-grid">
                <div class="fs-meta-card">
                    <div class="fs-meta-label">Tên phiên Flash Sale</div>
                    <div class="fs-meta-value">{{ $selectedFlashSale->title }}</div>
                    <div class="fs-meta-sub">{{ $selectedFlashSale->time_label }} | {{ $selectedFlashSale->date_label }}</div>
                </div>

                <div class="fs-meta-card">
                    <div class="fs-meta-label">Sản phẩm trong phiên</div>
                    <div class="fs-meta-value">{{ $countProducts }}</div>
                    <div class="fs-meta-sub">Các deal được cập nhật theo phiên đang chọn</div>
                </div>

                <div class="fs-meta-card">
                    <div class="fs-meta-label">Tổng số lượng đã bán</div>
                    <div class="fs-meta-value">{{ number_format($sumSold, 0, ',', '.') }}</div>
                    <div class="fs-meta-sub">
                        @if($sumQty > 0)
                            Trên tổng {{ number_format($sumQty, 0, ',', '.') }} sản phẩm của phiên
                        @else
                            Số liệu bán ra theo cấu hình flash sale
                        @endif
                    </div>
                </div>
            </div>

            @if($selectedFlashSaleProducts->count() > 0)
                <div class="fs-grid">
                    @foreach($selectedFlashSaleProducts as $product)
                        <article class="fs-product-card {{ $product->sold_out ? 'fs-product-card--soldout' : '' }}">
                            @if(!empty($product->discount_percent))
                                <div class="fs-discount-badge">-{{ $product->discount_percent }}%</div>
                            @endif

                            @if($product->almost_sold_out && !$product->sold_out)
                                <div class="fs-hot-badge">
                                    <span class="fs-fire">🔥</span>
                                    <span>Đang cháy hàng</span>
                                </div>
                            @endif

                            <a href="{{ $product->product_url }}" class="fs-product-link">
                                <div class="fs-product-thumb">
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}">
                                </div>

                                <div class="fs-product-body">
                                    <h2 class="fs-product-name">{{ $product->name }}</h2>

                                    @if(!empty($product->description))
                                        <p class="fs-product-desc">{{ $product->description }}</p>
                                    @endif

                                    <div class="fs-price-row">
                                        <div class="fs-price-sale">
                                            @if($product->flash_price > 0)
                                                {{ number_format($product->flash_price, 0, ',', '.') }}đ
                                            @else
                                                Liên hệ
                                            @endif
                                        </div>

                                        @if($product->original_price > 0)
                                            <div class="fs-price-original">
                                                {{ number_format($product->original_price, 0, ',', '.') }}đ
                                            </div>
                                        @endif
                                    </div>

                                    <div class="fs-stock-box">
                                        <div class="fs-stock-top">
                                            <div class="fs-stock-sold">
                                                Đã bán {{ number_format($product->sold, 0, ',', '.') }}
                                            </div>

                                            @if($product->quantity > 0)
                                                <div class="fs-stock-remain">
                                                    @if($product->sold_out)
                                                        Hết hàng
                                                    @else
                                                        Còn {{ number_format($product->remaining, 0, ',', '.') }}
                                                    @endif
                                                </div>
                                            @endif
                                        </div>

                                        @if($product->quantity > 0)
                                            <div class="fs-progress">
                                                <div
                                                    class="fs-progress-bar {{ $product->almost_sold_out ? 'fs-progress-bar--hot' : '' }}"
                                                    style="width: {{ $product->progress_percent }}%;"
                                                >
                                                    @if($product->almost_sold_out && !$product->sold_out)
                                                        <span class="fs-progress-fire">🔥</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>

                            <div class="fs-product-actions">
                                <a
                                    href="{{ $product->product_url }}"
                                    class="fs-buy-btn {{ $product->sold_out ? 'fs-buy-btn--disabled' : '' }}"
                                >
                                    {{ $product->sold_out ? 'Tạm hết hàng' : 'Chọn mua ngay' }}
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="fs-empty">
                    Phiên Flash Sale này hiện chưa có sản phẩm để hiển thị.
                </div>
            @endif
        @else
            <div class="fs-empty">
                Hiện chưa có phiên Flash Sale nào đang được cấu hình.
            </div>
        @endif
    </div>
</section>

@if($selectedFlashSale)
<script type="application/ld+json">
{
    "@context":"https://schema.org",
    "@type":"CollectionPage",
    "name":"Flash Sale {{ $selectedFlashSale->date_label }}",
    "description":"Danh sách sản phẩm Flash Sale của Nhà thuốc Phương Anh trong phiên {{ $selectedFlashSale->time_label }} ngày {{ $selectedFlashSale->date_label }}.",
    "url":"{{ route('website.flash-sale.index', ['session' => $selectedFlashSale->id]) }}"
}
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const timer = document.getElementById('fsTimer');
    const label = document.getElementById('fsCountdownLabel');

    if (!timer || !label) return;

    const hoursEl = timer.querySelector('[data-unit="hours"]');
    const minutesEl = timer.querySelector('[data-unit="minutes"]');
    const secondsEl = timer.querySelector('[data-unit="seconds"]');

    const status = timer.getAttribute('data-status');
    const startAt = timer.getAttribute('data-start-at');
    const endAt = timer.getAttribute('data-end-at');

    function pad(num) {
        return String(num).padStart(2, '0');
    }

    function setZero() {
        hoursEl.textContent = '00';
        minutesEl.textContent = '00';
        secondsEl.textContent = '00';
    }

    if (status === 'ended') {
        label.textContent = 'Phiên đã kết thúc';
        setZero();
        return;
    }

    const target = status === 'upcoming' ? new Date(startAt).getTime() : new Date(endAt).getTime();
    label.textContent = status === 'upcoming' ? 'Bắt đầu sau' : 'Kết thúc sau';

    function tick() {
        const now = Date.now();
        let diff = Math.floor((target - now) / 1000);

        if (diff <= 0) {
            setZero();
            return;
        }

        const hours = Math.floor(diff / 3600);
        diff = diff % 3600;
        const minutes = Math.floor(diff / 60);
        const seconds = diff % 60;

        hoursEl.textContent = pad(hours);
        minutesEl.textContent = pad(minutes);
        secondsEl.textContent = pad(seconds);
    }

    tick();
    setInterval(tick, 1000);
});
</script>
@endsection