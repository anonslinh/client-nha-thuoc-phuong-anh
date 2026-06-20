<section class="pa-season-v2" aria-label="Bệnh theo mùa">
    <div class="lc-container">
        <div class="pa-season-v2__head">
            <div class="pa-season-v2__eyebrow">Chăm sóc sức khỏe theo mùa</div>
            <h5 class="pa-season-v2__title">Bệnh theo mùa</h5>
            <p class="pa-season-v2__desc">
                Thông tin ngắn gọn về các bệnh thường gặp theo mùa và những sản phẩm gợi ý liên quan.
            </p>
        </div>

        @if(!empty($seasonDiseases) && count($seasonDiseases) > 0)
            <div class="pa-season-v2__tabs" id="paSeasonTabs">
                @foreach($seasonDiseases as $index => $seasonDisease)
                    <button
                        style="
                            font-family: system-ui, -apple-system, BlinkMacSystemFont, &quot;SF Pro Text&quot;, &quot;Helvetica Neue&quot;, Arial, sans-seri;
                        "
                        type="button"
                        class="pa-season-v2__tab {{ (!empty($seasonDisease['is_active']) || $index === 0) ? 'is-active' : '' }}"
                        data-target="{{ $seasonDisease['panel_id'] }}"
                    >
                        {{ $seasonDisease['name'] }}
                    </button>
                @endforeach
            </div>

            <div class="pa-season-v2__panels">
                @foreach($seasonDiseases as $index => $seasonDisease)
                    <div
                        class="pa-season-v2__panel {{ (!empty($seasonDisease['is_active']) || $index === 0) ? 'is-active' : '' }}"
                        id="{{ $seasonDisease['panel_id'] }}"
                    >
                        <div class="pa-season-v2__box">
                            <div class="pa-season-v2__info">
                                <div
                                    class="pa-season-v2__banner"
                                    @if(!empty($seasonDisease['banner']))
                                        style="background-image:
                                            linear-gradient(180deg, rgba(15,23,42,.08), rgba(15,23,42,.36)),
                                            url('{{ $seasonDisease['banner'] }}');"
                                    @endif
                                >
                                    <div class="pa-season-v2__avatar">
                                        @if(!empty($seasonDisease['avatar']))
                                            <img src="{{ $seasonDisease['avatar'] }}" alt="{{ $seasonDisease['name'] }}">
                                        @else
                                            <span>🩺</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="pa-season-v2__info-body">
                                    <div class="pa-season-v2__info-label">Danh mục bệnh</div>
                                    <h3 class="pa-season-v2__info-title">{{ $seasonDisease['name'] }}</h3>

                                    <div class="pa-season-v2__info-text">
                                        <p>
                                            {{ $seasonDisease['description'] ?? 'Đang cập nhật mô tả cho danh mục này.' }}
                                        </p>
                                    </div>

                                    <div class="pa-season-v2__info-actions">
                                        <a
                                            href="{{ route('website.season-disease.show', $seasonDisease['id']) }}"
                                            class="pa-season-v2__detail-btn"
                                        >
                                            Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="pa-season-v2__products-wrap">
                                <div class="pa-season-v2__products-head">
                                    <div>
                                        <div class="pa-season-v2__products-label">Sản phẩm theo bệnh</div>
                                        <h4>Gợi ý nổi bật</h3>
                                    </div>

                                    <div class="pa-season-v2__nav">
                                        <button
                                            type="button"
                                            class="pa-season-v2__nav-btn is-prev"
                                            data-slider-prev="{{ $seasonDisease['panel_id'] }}"
                                            aria-label="Sản phẩm trước"
                                        >
                                            ‹
                                        </button>
                                        <button
                                            type="button"
                                            class="pa-season-v2__nav-btn is-next"
                                            data-slider-next="{{ $seasonDisease['panel_id'] }}"
                                            aria-label="Sản phẩm tiếp theo"
                                        >
                                            ›
                                        </button>
                                    </div>
                                </div>

                                @if(!empty($seasonDisease['products']) && count($seasonDisease['products']) > 0)
                                    <div class="pa-season-v2__slider" data-slider="{{ $seasonDisease['panel_id'] }}">
                                        <div class="pa-season-v2__track">
                                            @foreach($seasonDisease['products'] as $product)
                                                @php
                                                    $detailUrl = !empty($product['url'])
                                                        ? $product['url']
                                                        : (!empty($product['id'])
                                                            ? route('website.product-v1.show', ['id' => $product['id']])
                                                            : 'javascript:void(0)');
                                                @endphp

                                                <article class="pa-season-v2__product">
                                                    <a href="{{ route('website.product-v1.show', $product['id']) }}"
                                                    class="pa-season-v2__product-image">
                                                        <img
                                                            src="{{ $product['image'] ?? asset('images/no-image.png') }}"
                                                            alt="{{ $product['name'] ?? 'Sản phẩm' }}"
                                                        >
                                                    </a>

                                                    <div class="pa-season-v2__product-body">
                                                        <h4 class="pa-season-v2__product-name">
                                                            <a href="{{ route('website.product-v1.show', $product['id']) }}">
                                                                {{ $product['name'] ?? 'Sản phẩm' }}
                                                            </a>
                                                        </h4>

                                                        <div class="pa-season-v2__product-price">
                                                            <div class="pa-season-v2__product-price-sale">
                                                                {{ number_format((float) ($product['display_price'] ?? 0), 0, ',', '.') }}đ
                                                                @if(!empty($product['unit_name']))
                                                                    <span>/ {{ $product['unit_name'] }}</span>
                                                                @endif
                                                            </div>

                                                            @if(!empty($product['original_price']))
                                                                <div class="pa-season-v2__product-price-origin">
                                                                    {{ number_format((float) $product['original_price'], 0, ',', '.') }}đ
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <a href="{{ route('website.product-v1.show', $product['id']) }}" class="pa-season-v2__product-btn">
                                                            Chọn mua
                                                        </a>
                                                    </div>
                                                </article>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="pa-season-v2__empty">
                                        Chưa có sản phẩm cho danh mục này.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<style>
    .pa-season-v2__info-body{
        padding: 44px 24px 24px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .pa-season-v2__info-text{
        color: #475569;
        font-size: 16px;
        line-height: 1.85;
        margin-bottom: 18px;
    }

    .pa-season-v2__info-text p{
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 7;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .pa-season-v2__info-actions{
        margin-top: auto;
        padding-top: 16px;
    }

    .pa-season-v2__detail-btn{
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
        border-radius: 999px;
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        color: #fff;
        text-decoration: none;
        font-size: 15px;
        font-weight: 800;
        box-shadow: 0 14px 26px rgba(37, 99, 235, .18);
        transition: all .25s ease;
    }

    .pa-season-v2__detail-btn:hover{
        transform: translateY(-2px);
        box-shadow: 0 18px 32px rgba(37, 99, 235, .24);
    }
    .pa-season-v2{
        padding: 30px 0 10px;
    }

    .pa-season-v2__head{
        margin-bottom: 18px;
    }

    .pa-season-v2__eyebrow{
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: 999px;
        background: linear-gradient(135deg, rgba(14,165,233,.12), rgba(37,99,235,.12));
        color: #0284c7;
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .pa-season-v2__title{
        margin: 0;
        font-size: 48px;
        line-height: 1.08;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .pa-season-v2__desc{
        margin: 12px 0 0;
        color: #64748b;
        font-size: 17px;
        line-height: 1.7;
        max-width: 840px;
    }

    .pa-season-v2__tabs{
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 22px;
    }

    .pa-season-v2__tab{
        height: 52px;
        padding: 0 22px;
        border-radius: 999px;
        border: 1px solid #d7e5f1;
        background: #fff;
        color: #334155;
        font-size: 16px;
        font-weight: 800;
        cursor: pointer;
        transition: all .25s ease;
    }

    .pa-season-v2__tab:hover{
        border-color: #7dd3fc;
        color: #0284c7;
        transform: translateY(-1px);
    }

    .pa-season-v2__tab.is-active{
        border-color: transparent;
        color: #fff;
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        box-shadow: 0 16px 32px rgba(37,99,235,.18);
    }

    .pa-season-v2__panel{
        display: none;
    }

    .pa-season-v2__panel.is-active{
        display: block;
    }

    .pa-season-v2__box{
        display: grid;
        grid-template-columns: 400px minmax(0, 1fr);
        gap: 18px;
        padding: 18px;
        border-radius: 34px;
        background: linear-gradient(135deg, #d8f2ff 0%, #cceeff 45%, #dcf5ff 100%);
        box-shadow: 0 28px 60px rgba(15,23,42,.10);
    }

    .pa-season-v2__info{
        background: #fff;
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid #ecf2f8;
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .pa-season-v2__banner{
        min-height: 250px;
        position: relative;
        background: linear-gradient(135deg, #38bdf8 0%, #2563eb 100%);
        background-size: cover;
        background-position: center;
    }

    .pa-season-v2__avatar{
        position: absolute;
        left: 22px;
        bottom: -30px;
        width: 92px;
        height: 92px;
        border-radius: 24px;
        background: #fff;
        border: 4px solid #fff;
        box-shadow: 0 18px 36px rgba(15,23,42,.14);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pa-season-v2__avatar img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .pa-season-v2__avatar span{
        font-size: 38px;
    }

    .pa-season-v2__info-body{
        padding: 44px 24px 24px;
    }

    .pa-season-v2__info-label{
        font-size: 12px;
        font-weight: 900;
        color: #0284c7;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .pa-season-v2__info-title{
        margin: 0 0 14px;
        font-size: 28px;
        line-height: 1.2;
        font-weight: 900;
        color: #0f172a;
    }

    .pa-season-v2__info-text{
        color: #475569;
        font-size: 16px;
        line-height: 1.85;
    }

    .pa-season-v2__info-text p{
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 7;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .pa-season-v2__products-wrap{
        min-width: 0;
        background: rgba(255,255,255,.86);
        backdrop-filter: blur(10px);
        border-radius: 28px;
        padding: 24px;
        border: 1px solid rgba(255,255,255,.65);
        overflow: hidden;
    }

    .pa-season-v2__products-head{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }

    .pa-season-v2__products-label{
        font-size: 12px;
        font-weight: 900;
        color: #0284c7;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .pa-season-v2__products-head h3{
        margin: 0;
        color: #0f172a;
        font-size: 40px;
        line-height: 1.1;
        font-weight: 900;
        letter-spacing: -0.02em;
    }

    .pa-season-v2__nav{
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 0 0 auto;
    }

    .pa-season-v2__nav-btn{
        width: 46px;
        height: 46px;
        border: 1px solid #d8e6f2;
        background: #fff;
        color: #0f172a;
        border-radius: 999px;
        font-size: 28px;
        line-height: 1;
        cursor: pointer;
        transition: all .25s ease;
        box-shadow: 0 8px 18px rgba(15,23,42,.06);
    }

    .pa-season-v2__nav-btn:hover{
        color: #fff;
        border-color: transparent;
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        box-shadow: 0 14px 26px rgba(37,99,235,.18);
    }

    .pa-season-v2__slider{
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        padding-bottom: 6px;
        cursor: grab;
    }

    .pa-season-v2__slider:active{
        cursor: grabbing;
    }

    .pa-season-v2__slider::-webkit-scrollbar{
        height: 10px;
    }

    .pa-season-v2__slider::-webkit-scrollbar-track{
        background: #e6f0f8;
        border-radius: 999px;
    }

    .pa-season-v2__slider::-webkit-scrollbar-thumb{
        background: linear-gradient(135deg, #38bdf8, #2563eb);
        border-radius: 999px;
    }

    .pa-season-v2__track{
        display: flex;
        gap: 18px;
        width: max-content;
        min-width: 100%;
    }

    .pa-season-v2__product{
        width: 285px;
        min-width: 285px;
        max-width: 285px;
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #e6edf5;
        box-shadow: 0 14px 32px rgba(15,23,42,.06);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .pa-season-v2__product:hover{
        transform: translateY(-4px);
        box-shadow: 0 20px 42px rgba(15,23,42,.10);
    }

    .pa-season-v2__product-image{
        display: flex;
        align-items: center;
        justify-content: center;
        aspect-ratio: 1 / 1;
        background: linear-gradient(180deg, #f8fbff 0%, #f2f7fb 100%);
        padding: 18px;
        text-decoration: none;
    }

    .pa-season-v2__product-image img{
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }

    .pa-season-v2__product-body{
        padding: 18px;
    }

    .pa-season-v2__product-name{
        margin: 0 0 14px;
        min-height: 76px;
        font-size: 16px;
        line-height: 1.6;
        font-weight: 800;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .pa-season-v2__product-name a{
        color: #0f172a;
        text-decoration: none;
    }

    .pa-season-v2__product-name a:hover{
        color: #0284c7;
    }

    .pa-season-v2__product-price{
        margin-bottom: 14px;
    }

    .pa-season-v2__product-price-sale{
        color: #06b6d4;
        font-size: 24px;
        line-height: 1.2;
        font-weight: 900;
    }

    .pa-season-v2__product-price-sale span{
        color: #64748b;
        font-size: 13px;
        font-weight: 800;
    }

    .pa-season-v2__product-price-origin{
        margin-top: 6px;
        color: #94a3b8;
        text-decoration: line-through;
        font-size: 14px;
        font-weight: 700;
    }

    .pa-season-v2__product-btn{
        height: 46px;
        display: inline-flex;
        width: 100%;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: linear-gradient(135deg, #f97316, #fb923c);
        color: #fff;
        text-decoration: none;
        font-size: 15px;
        font-weight: 900;
        box-shadow: 0 16px 26px rgba(249,115,22,.18);
    }

    .pa-season-v2__empty{
        min-height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        background: #fff;
        border: 1px dashed #d9e5f0;
        color: #64748b;
        font-size: 15px;
        font-weight: 700;
    }

    @media (max-width: 1280px){
        .pa-season-v2__title{
            font-size: 42px;
        }

        .pa-season-v2__products-head h3{
            font-size: 34px;
        }

        .pa-season-v2__box{
            grid-template-columns: 360px minmax(0, 1fr);
        }

        .pa-season-v2__product{
            width: 260px;
            min-width: 260px;
            max-width: 260px;
        }
    }

    @media (max-width: 991px){
        .pa-season-v2__title{
            font-size: 34px;
        }

        .pa-season-v2__desc{
            font-size: 15px;
        }

        .pa-season-v2__box{
            grid-template-columns: 1fr;
        }

        .pa-season-v2__banner{
            min-height: 220px;
        }

        .pa-season-v2__products-head h3{
            font-size: 30px;
        }
    }

    @media (max-width: 767px){
        .pa-season-v2{
            padding-top: 20px;
        }

        .pa-season-v2__title{
            font-size: 28px;
        }

        .pa-season-v2__desc{
            font-size: 14px;
            line-height: 1.65;
        }

        .pa-season-v2__tabs{
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: 4px;
        }

        .pa-season-v2__tabs::-webkit-scrollbar{
            display: none;
        }

        .pa-season-v2__tab{
            white-space: nowrap;
            height: 46px;
            padding: 0 16px;
            font-size: 14px;
        }

        .pa-season-v2__box{
            padding: 14px;
            gap: 14px;
            border-radius: 24px;
        }

        .pa-season-v2__products-wrap{
            padding: 12px;
            border-radius: 18px;
        }

        .pa-season-v2__products-head{
            align-items: flex-start;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 10px;
        }

        .pa-season-v2__products-head h3{
            font-size: 20px;
        }

        .pa-season-v2__nav{
            align-self: flex-end;
        }

        .pa-season-v2__product{
            width: 152px;
            min-width: 152px;
            max-width: 152px;
            border-radius: 16px;
        }

        .pa-season-v2__product-image{
            height: 82px;
            aspect-ratio: auto;
            padding: 7px;
        }

        .pa-season-v2__product-body{
            padding: 8px;
        }

        .pa-season-v2__product-name{
            min-height: 32px;
            margin-bottom: 6px;
            font-size: 11.5px;
            line-height: 1.35;
            -webkit-line-clamp: 2;
        }

        .pa-season-v2__product-price-sale{
            font-size: 13px;
        }

        .pa-season-v2__product-price-sale span,
        .pa-season-v2__product-price-origin {
            display: none;
        }

        .pa-season-v2__product-price{
            margin-bottom: 6px;
        }

        .pa-season-v2__product-btn{
            height: 28px;
            min-height: 28px;
            font-size: 10.5px;
            box-shadow: none;
        }

        .pa-season-v2__banner{
            min-height: 180px;
        }

        .pa-season-v2__avatar{
            width: 78px;
            height: 78px;
            left: 18px;
            bottom: -24px;
            border-radius: 20px;
        }

        .pa-season-v2__info-body{
            padding: 36px 18px 18px;
        }

        .pa-season-v2__info-title{
            font-size: 24px;
        }

        .pa-season-v2__info-text{
            font-size: 15px;
            line-height: 1.75;
        }

        .pa-season-v2__info-text p{
            -webkit-line-clamp: 6;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.pa-season-v2__tab');
        const panels = document.querySelectorAll('.pa-season-v2__panel');

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                const target = this.getAttribute('data-target');

                tabs.forEach(item => item.classList.remove('is-active'));
                panels.forEach(panel => panel.classList.remove('is-active'));

                this.classList.add('is-active');

                const targetPanel = document.getElementById(target);
                if (targetPanel) {
                    targetPanel.classList.add('is-active');
                }
            });
        });

        document.querySelectorAll('[data-slider-prev], [data-slider-next]').forEach(button => {
            button.addEventListener('click', function () {
                const isNext = this.hasAttribute('data-slider-next');
                const panelId = this.getAttribute(isNext ? 'data-slider-next' : 'data-slider-prev');
                const slider = document.querySelector('[data-slider="' + panelId + '"]');
                if (!slider) return;

                const firstCard = slider.querySelector('.pa-season-v2__product');
                const gap = 18;
                const scrollAmount = firstCard ? (firstCard.offsetWidth + gap) * (window.innerWidth < 768 ? 1 : 2) : 320;

                slider.scrollBy({
                    left: isNext ? scrollAmount : -scrollAmount,
                    behavior: 'smooth'
                });
            });
        });

        document.querySelectorAll('.pa-season-v2__slider').forEach(slider => {
            let isDown = false;
            let startX = 0;
            let scrollLeft = 0;

            slider.addEventListener('mousedown', function (e) {
                isDown = true;
                slider.classList.add('is-dragging');
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });

            slider.addEventListener('mouseleave', function () {
                isDown = false;
                slider.classList.remove('is-dragging');
            });

            slider.addEventListener('mouseup', function () {
                isDown = false;
                slider.classList.remove('is-dragging');
            });

            slider.addEventListener('mousemove', function (e) {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 1.2;
                slider.scrollLeft = scrollLeft - walk;
            });
        });
    });
</script>
