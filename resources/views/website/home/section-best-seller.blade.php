@once
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">
@endonce

<section class="lc-bestseller" id="homeBestSellerSection" aria-label="Sản phẩm bán chạy">
    <div class="lc-container">
        <div class="lc-bestseller-box" style="
            background: #1fb2b3;
        ">
            <div class="lc-bestseller-heading-wrap">
                <div class="lc-bestseller-heading-left">
                    <div class="lc-bestseller-heading-icon">
                        <i class="ri-fire-line" aria-hidden="true"></i>
                    </div>

                    <div>
                        <div class="lc-bestseller-title-inline" style="
                            padding: 6px 22px;
                            border-radius: 999px;
                            background: none;
                            color: #ffffff;
                            font-size: 25px;
                            font-weight: 700;
                            text-transform: uppercase;
                            letter-spacing: 0.12em;
                            box-shadow: none;
                            white-space: nowrap;
                            margin: 14px 0 7px;
                            font-size: 34px;
                            line-height: 1.12;
                            font-weight: 850;
                            letter-spacing: -.035em;
                        ">
                            Sản phẩm bán chạy
                        </div>

                        <div class="lc-bestseller-subtitle">
                            Những sản phẩm được khách hàng lựa chọn nhiều tại Nhà thuốc Phương Anh
                        </div>
                    </div>
                </div>
            </div>

            <div class="lc-bestseller-products-wrap">
                <div class="lc-bestseller-products" id="bestsellerProducts">
                    @forelse($bestSellerProducts as $product)
                        <article class="lc-product-card--best">
                            <div class="lc-product-card-badges">
                                <div class="lc-product-hot-badge">
                                    <i class="ri-fire-line" aria-hidden="true"></i>
                                    <span>Bán chạy</span>
                                </div>

                                @if(!empty($product->discount_percent))
                                    <div class="lc-product-discount-badge">
                                        -{{ $product->discount_percent }}%
                                    </div>
                                @endif
                            </div>

                            <a href="{{ $product->product_url }}" class="lc-product-image-wrap">
                                <img
                                    src="{{ $product->image ?: asset('phuonganh/img/best-1-placeholder.jpg') }}"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                />
                            </a>

                            <div class="lc-product-body">
                                <h3 class="lc-product-name">
                                    <a href="{{ $product->product_url }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">
                                        @if($product->sale_price > 0)
                                            {{ number_format($product->sale_price, 0, ',', '.') }}đ
                                        @else
                                            Liên hệ
                                        @endif

                                        @if(!empty($product->unit_label))
                                            <small>/ {{ $product->unit_label }}</small>
                                        @endif
                                    </div>

                                    @if($product->original_price > 0)
                                        <div class="lc-product-price-original">
                                            {{ number_format($product->original_price, 0, ',', '.') }}đ
                                        </div>
                                    @endif

                                    @if(!empty($product->unit_label))
                                        <div class="lc-product-unit-pill">
                                            {{ $product->unit_label }}
                                        </div>
                                    @endif
                                </div>

                                <a href="{{ $product->product_url }}" class="lc-product-btn-buy">
                                    <i class="ri-shopping-cart-2-line" aria-hidden="true"></i>
                                    <span>Chọn mua</span>
                                </a>
                            </div>
                        </article>
                    @empty
                        <article class="lc-product-card--best">
                            <a href="javascript:void(0)" class="lc-product-image-wrap">
                                <img src="{{ asset('phuonganh/img/best-1-placeholder.jpg') }}" alt="Sản phẩm bán chạy" />
                            </a>

                            <div class="lc-product-body">
                                <h3 class="lc-product-name">
                                    <span>Hiện chưa có dữ liệu sản phẩm bán chạy</span>
                                </h3>

                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">
                                        Đang cập nhật
                                    </div>
                                </div>

                                <button class="lc-product-btn-buy is-disabled" type="button">
                                    <i class="ri-refresh-line" aria-hidden="true"></i>
                                    <span>Đang cập nhật</span>
                                </button>
                            </div>
                        </article>
                    @endforelse
                </div>

                @if(!empty($bestSellerProducts) && count($bestSellerProducts) > 0)
                    <button
                        class="lc-bestseller-next"
                        type="button"
                        id="bestsellerNext"
                        aria-label="Xem thêm sản phẩm bán chạy"
                    >
                        <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
                    </button>
                @endif
            </div>

            @if(!empty($bestSellerProducts) && count($bestSellerProducts) > 4)
                <div class="lc-bestseller-mobile-more">
                    <button type="button" class="lc-bestseller-mobile-more-btn" id="bestSellerMobileToggle">
                        <span data-open-text>Xem thêm sản phẩm</span>
                        <i class="ri-arrow-down-s-line" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
</section>

@once
<style>
    #homeBestSellerSection{
        --pa-brand: #0c585c;
        --pa-brand-2: #0c8f75;
        --pa-brand-3: #12a6b5;
        --pa-text: #0f172a;
        --pa-muted: #64748b;
        --pa-border: #dbe7e5;
        --pa-soft: rgba(12, 88, 92, .08);
        --pa-orange: #ff5722;
    }

    #homeBestSellerSection,
    #homeBestSellerSection *{
        box-sizing: border-box;
    }

    #homeBestSellerSection i{
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 400 !important;
        -webkit-text-stroke: 0 !important;
    }

    #homeBestSellerSection .lc-bestseller-box{
        position: relative;
        overflow: hidden;
        border-radius: 30px;
        padding: 28px;
        background:
            radial-gradient(circle at 0 0, rgba(255, 255, 255, .30), transparent 42%),
            radial-gradient(circle at 92% 10%, rgba(255, 255, 255, .20), transparent 32%),
            linear-gradient(135deg, #0c585c 0%, #0c8f75 52%, #12a6b5 100%);
        box-shadow: 0 22px 54px rgba(12, 88, 92, .18);
    }

    #homeBestSellerSection .lc-bestseller-box::before{
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(90deg, rgba(255,255,255,.08), transparent 38%, rgba(255,255,255,.10)),
            radial-gradient(circle at 22% 88%, rgba(255,255,255,.14), transparent 30%);
        pointer-events: none;
    }

    #homeBestSellerSection .lc-bestseller-heading-wrap{
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 22px;
    }

    #homeBestSellerSection .lc-bestseller-heading-left{
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    #homeBestSellerSection .lc-bestseller-heading-icon{
        width: 48px;
        height: 48px;
        border-radius: 18px;
        background: rgba(255, 255, 255, .16);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, .18);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        backdrop-filter: blur(10px);
    }

    #homeBestSellerSection .lc-bestseller-heading-icon i{
        font-size: 23px;
    }

    #homeBestSellerSection .lc-bestseller-subtitle{
        margin-top: 5px;
        color: rgba(255, 255, 255, .82);
        font-size: 15px;
        line-height: 1.5;
        font-weight: 400;
    }

    #homeBestSellerSection .lc-bestseller-products-wrap{
        position: relative;
        z-index: 1;
    }

    #homeBestSellerSection .lc-bestseller-products{
        display: flex;
        gap: 16px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 2px 4px 10px;
        scrollbar-width: none;
    }

    #homeBestSellerSection .lc-bestseller-products::-webkit-scrollbar{
        display: none;
    }

    #homeBestSellerSection .lc-product-card--best{
        position: relative;
        flex: 0 0 230px;
        min-height: 342px;
        border-radius: 22px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, .92);
        box-shadow: 0 14px 32px rgba(15, 23, 42, .12);
        display: flex;
        flex-direction: column;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    #homeBestSellerSection .lc-product-card--best:hover{
        transform: translateY(-3px);
        box-shadow: 0 20px 42px rgba(15, 23, 42, .16);
        border-color: rgba(12, 143, 117, .30);
    }

    #homeBestSellerSection .lc-product-card-badges{
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        z-index: 3;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
        pointer-events: none;
    }

    #homeBestSellerSection .lc-product-hot-badge{
        min-height: 27px;
        padding: 0 9px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(12, 88, 92, .94);
        color: #ffffff;
        box-shadow: 0 8px 18px rgba(12, 88, 92, .18);
        font-size: 12px;
        font-weight: 650;
        backdrop-filter: blur(8px);
    }

    #homeBestSellerSection .lc-product-hot-badge i{
        font-size: 14px;
    }

    #homeBestSellerSection .lc-product-discount-badge{
        min-height: 27px;
        padding: 0 9px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--pa-orange);
        color: #ffffff;
        box-shadow: 0 8px 18px rgba(255, 87, 34, .22);
        font-size: 12px;
        font-weight: 750;
    }

    #homeBestSellerSection .lc-product-image-wrap{
        height: 142px;
        background: #f8fafc;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        text-decoration: none;
    }

    #homeBestSellerSection .lc-product-image-wrap img{
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 12px;
        display: block;
        transition: transform .25s ease;
    }

    #homeBestSellerSection .lc-product-card--best:hover .lc-product-image-wrap img{
        transform: scale(1.04);
    }

    #homeBestSellerSection .lc-product-body{
        padding: 13px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    #homeBestSellerSection .lc-product-name{
        margin: 0 0 10px;
        min-height: 42px;
        color: var(--pa-text);
        font-size: 14px;
        line-height: 1.45;
        font-weight: 650;
    }

    #homeBestSellerSection .lc-product-name a,
    #homeBestSellerSection .lc-product-name span{
        color: inherit;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #homeBestSellerSection .lc-product-name a:hover{
        color: var(--pa-brand);
        text-decoration: none;
    }

    #homeBestSellerSection .lc-product-price-row{
        margin-top: auto;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
        min-height: 64px;
    }

    #homeBestSellerSection .lc-product-price-sale{
        color: var(--pa-brand);
        font-size: 17px;
        line-height: 1.25;
        font-weight: 850;
        letter-spacing: -.01em;
    }

    #homeBestSellerSection .lc-product-price-sale small{
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
    }

    #homeBestSellerSection .lc-product-price-original{
        color: #94a3b8;
        font-size: 13px;
        line-height: 1.3;
        font-weight: 500;
        text-decoration: line-through;
    }

    #homeBestSellerSection .lc-product-unit-pill{
        width: fit-content;
        max-width: 100%;
        min-height: 23px;
        padding: 0 8px;
        border-radius: 999px;
        background: rgba(12, 143, 117, .08);
        color: var(--pa-brand);
        font-size: 11px;
        font-weight: 650;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    #homeBestSellerSection .lc-product-btn-buy{
        width: 100%;
        min-height: 38px;
        margin-top: 11px;
        border: 0;
        border-radius: 14px;
        background: rgba(12, 143, 117, .10);
        color: var(--pa-brand);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        text-align: center;
        text-decoration: none;
        font-size: 13px;
        font-weight: 800;
        box-shadow: 0 10px 22px rgba(12, 143, 117, .10);
        cursor: pointer;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease, color .2s ease;
    }

    #homeBestSellerSection .lc-product-btn-buy i{
        font-size: 16px;
    }

    #homeBestSellerSection .lc-product-btn-buy:hover{
        color: #ffffff;
        background: linear-gradient(135deg, var(--pa-brand-2) 0%, var(--pa-brand) 100%);
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 14px 28px rgba(12, 143, 117, .22);
    }

    #homeBestSellerSection .lc-product-btn-buy.is-disabled{
        background: #e2e8f0;
        color: #64748b;
        box-shadow: none;
        pointer-events: none;
    }

    #homeBestSellerSection .lc-bestseller-next{
        position: absolute;
        top: 50%;
        right: -14px;
        transform: translateY(-50%);
        z-index: 5;
        width: 46px;
        height: 46px;
        border-radius: 999px;
        border: 1px solid rgba(226, 232, 240, .95);
        background: rgba(255, 255, 255, .96);
        color: var(--pa-brand);
        box-shadow: 0 14px 30px rgba(15, 23, 42, .16);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    #homeBestSellerSection .lc-bestseller-next i{
        font-size: 24px;
    }

    #homeBestSellerSection .lc-bestseller-next:hover{
        background: var(--pa-brand);
        color: #ffffff;
        border-color: var(--pa-brand);
    }

    #homeBestSellerSection .lc-bestseller-mobile-more{
        display: none;
    }

    @media (max-width: 991px){
        #homeBestSellerSection .lc-bestseller-box{
            border-radius: 26px;
            padding: 24px 20px 26px;
        }

        #homeBestSellerSection .lc-bestseller-subtitle{
            font-size: 14px;
        }
    }

    @media (max-width: 767px){
        #homeBestSellerSection{
            overflow: hidden;
            padding: 18px 0 20px;
            background: linear-gradient(180deg, #edf8f7 0%, #f7fbff 100%);
        }

        #homeBestSellerSection .lc-container{
            width: 100% !important;
            max-width: 100% !important;
            padding-left: 16px !important;
            padding-right: 16px !important;
        }

        #homeBestSellerSection .lc-bestseller-box{
            width: 100%;
            border-radius: 24px;
            padding: 18px 14px 16px !important;
            background: #1fb2b3 !important;
            box-shadow: 0 16px 34px rgba(12, 88, 92, .12);
        }

        #homeBestSellerSection .lc-bestseller-heading-wrap{
            margin-bottom: 14px;
            padding: 0;
        }

        #homeBestSellerSection .lc-bestseller-heading-left{
            width: 100%;
            display: grid;
            grid-template-columns: 34px minmax(0, 1fr);
            align-items: start;
            gap: 10px;
        }

        #homeBestSellerSection .lc-bestseller-heading-icon{
            width: 34px;
            height: 34px;
            border-radius: 14px;
            background: rgba(255,255,255,.16);
        }

        #homeBestSellerSection .lc-bestseller-heading-icon i{
            font-size: 18px;
        }

        #homeBestSellerSection .lc-bestseller-title-inline{
            padding: 0 !important;
            margin: 2px 0 0 !important;
            white-space: normal !important;
            color: #ffffff !important;
            font-size: 23px !important;
            line-height: 1.15 !important;
            font-weight: 900 !important;
            letter-spacing: -.03em !important;
            text-transform: uppercase !important;
            max-width: 100% !important;
            overflow: visible !important;
        }

        #homeBestSellerSection .lc-bestseller-subtitle{
            margin-top: 7px;
            max-width: 280px;
            color: rgba(255,255,255,.88);
            font-size: 12px;
            line-height: 1.45;
            font-weight: 500;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        #homeBestSellerSection .lc-bestseller-products-wrap{
            width: 100%;
            overflow: visible;
        }

        #homeBestSellerSection .lc-bestseller-products{
            width: 100%;
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            overflow: visible !important;
            padding: 0;
            scroll-snap-type: none;
        }

        #homeBestSellerSection .lc-product-card--best{
            width: 100% !important;
            min-width: 0 !important;
            max-width: 100% !important;
            flex: none !important;
            min-height: 0;
            border-radius: 18px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .10);
            scroll-snap-align: none;
        }

        #homeBestSellerSection .lc-product-card--best:hover{
            transform: none;
        }

        #homeBestSellerSection:not(.is-mobile-expanded) .lc-product-card--best:nth-child(n+5){
            display: none !important;
        }

        #homeBestSellerSection .lc-product-card-badges{
            top: 8px;
            left: 8px;
            right: 8px;
        }

        #homeBestSellerSection .lc-product-hot-badge{
            min-height: 22px;
            padding: 0 7px;
            font-size: 10px;
            gap: 4px;
        }

        #homeBestSellerSection .lc-product-hot-badge span{
            display: none;
        }

        #homeBestSellerSection .lc-product-hot-badge i{
            font-size: 12px;
        }

        #homeBestSellerSection .lc-product-discount-badge{
            min-height: 22px;
            padding: 0 7px;
            font-size: 10px;
        }

        #homeBestSellerSection .lc-product-image-wrap{
            width: 100%;
            height: 78px;
            border-bottom: 1px solid #eef2f7;
            background: #f8fafc;
        }

        #homeBestSellerSection .lc-product-image-wrap img{
            width: 100%;
            height: 100%;
            padding: 6px;
            object-fit: contain;
        }

        #homeBestSellerSection .lc-product-body{
            padding: 8px;
        }

        #homeBestSellerSection .lc-product-name{
            min-height: 30px;
            margin: 0 0 5px;
            font-size: 11.5px;
            line-height: 1.3;
            font-weight: 750;
        }

        #homeBestSellerSection .lc-product-name a,
        #homeBestSellerSection .lc-product-name span{
            -webkit-line-clamp: 2;
        }

        #homeBestSellerSection .lc-product-price-row{
            min-height: 28px;
            gap: 2px;
        }

        #homeBestSellerSection .lc-product-price-sale{
            font-size: 12.5px;
            line-height: 1.2;
            font-weight: 900;
            white-space: normal;
        }

        #homeBestSellerSection .lc-product-price-sale small{
            display: none;
        }

        #homeBestSellerSection .lc-product-price-original{
            font-size: 10px;
            line-height: 1.2;
        }

        #homeBestSellerSection .lc-product-unit-pill{
            display: none !important;
        }

        #homeBestSellerSection .lc-product-btn-buy{
            min-height: 28px;
            margin-top: 6px;
            border-radius: 12px;
            font-size: 10.5px;
            gap: 5px;
            box-shadow: none;
        }

        #homeBestSellerSection .lc-product-btn-buy i{
            font-size: 14px;
        }

        #homeBestSellerSection .lc-bestseller-next{
            display: none !important;
        }

        #homeBestSellerSection .lc-bestseller-mobile-more{
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            padding-top: 14px;
        }

        #homeBestSellerSection .lc-bestseller-mobile-more-btn{
            width: 100%;
            min-height: 42px;
            border: 1px solid rgba(255,255,255,.26);
            border-radius: 999px;
            background: rgba(255,255,255,.92);
            color: #0c585c;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-size: 13px;
            font-weight: 850;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 12px 26px rgba(12, 88, 92, .12);
        }

        #homeBestSellerSection .lc-bestseller-mobile-more-btn i{
            font-size: 18px;
            transition: transform .2s ease;
        }

        #homeBestSellerSection.is-mobile-expanded .lc-bestseller-mobile-more-btn i{
            transform: rotate(180deg);
        }
    }

    @media (max-width: 390px){
        #homeBestSellerSection .lc-container{
            padding-left: 14px !important;
            padding-right: 14px !important;
        }

        #homeBestSellerSection .lc-bestseller-box{
            padding: 16px 12px 14px !important;
            border-radius: 22px;
        }

        #homeBestSellerSection .lc-bestseller-products{
            gap: 10px;
        }

        #homeBestSellerSection .lc-bestseller-title-inline{
            font-size: 21px !important;
        }

        #homeBestSellerSection .lc-bestseller-subtitle{
            font-size: 11.5px;
        }

        #homeBestSellerSection .lc-product-image-wrap{
            height: 74px;
        }

        #homeBestSellerSection .lc-product-body{
            padding: 7px;
        }

        #homeBestSellerSection .lc-product-name{
            font-size: 11px;
            min-height: 29px;
        }

        #homeBestSellerSection .lc-product-price-sale{
            font-size: 12px;
        }

        #homeBestSellerSection .lc-product-btn-buy{
            min-height: 28px;
            font-size: 10.5px;
        }
    }
</style>
@endonce

@once
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const section = document.getElementById('homeBestSellerSection');
        const list = document.getElementById('bestsellerProducts');
        const nextBtn = document.getElementById('bestsellerNext');
        const mobileToggleBtn = document.getElementById('bestSellerMobileToggle');

        if (list && nextBtn) {
            nextBtn.addEventListener('click', function () {
                const card = list.querySelector('.lc-product-card--best');
                const gap = window.innerWidth <= 767 ? 12 : 16;
                const scrollAmount = card ? card.offsetWidth + gap : 246;

                list.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });
        }

        if (section && mobileToggleBtn) {
            const textEl = mobileToggleBtn.querySelector('[data-open-text]');

            mobileToggleBtn.addEventListener('click', function () {
                const expanded = section.classList.toggle('is-mobile-expanded');

                if (textEl) {
                    textEl.textContent = expanded ? 'Thu gọn sản phẩm' : 'Xem thêm sản phẩm';
                }
            });
        }
    });
</script>
@endonce
