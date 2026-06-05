@php
    $mainSeo = $topSeoHeader ?? null;
    $sortedBanners = collect($banners ?? [])
        ->sortBy(function ($item) {
            return (int) ($item->sort_order ?? 999999);
        })
        ->values();
@endphp

<style>
    .pa-home-hero,
    .pa-home-hero *,
    .pa-home-actions,
    .pa-home-actions * {
        box-sizing: border-box;
    }

    .pa-home-hero {
        background: linear-gradient(180deg, #f5fbfa 0%, #ffffff 100%);
        padding: 26px 0 18px;
    }

    .pa-home-hero__shell {
        width: min(1320px, calc(100% - 32px));
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(0, .9fr) minmax(420px, 1.1fr);
        gap: 28px;
        align-items: stretch;
        min-width: 0;
    }

    .pa-home-hero__copy {
        min-width: 0;
        min-height: 438px;
        border-radius: 8px;
        padding: 34px;
        background: #ffffff;
        border: 1px solid #dbe7e5;
        box-shadow: 0 16px 42px rgba(12, 88, 92, .08);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .pa-home-hero__eyebrow {
        width: fit-content;
        min-height: 32px;
        padding: 0 12px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(12, 143, 117, .08);
        color: #0c6d5d;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .pa-home-hero__title {
        margin: 16px 0 0;
        max-width: 620px;
        color: #092f30;
        font-size: clamp(34px, 4.1vw, 56px);
        line-height: 1.04;
        font-weight: 900;
        overflow-wrap: anywhere;
    }

    .pa-home-hero__desc {
        margin: 16px 0 0;
        max-width: 590px;
        color: #587071;
        font-size: 16px;
        line-height: 1.75;
    }

    .pa-home-hero__search {
        margin-top: 24px;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 10px;
        padding: 8px;
        border-radius: 8px;
        background: #f4faf8;
        border: 1px solid #dbe7e5;
    }

    .pa-home-hero__search input {
        width: 100%;
        min-height: 46px;
        border: 0;
        outline: 0;
        background: transparent;
        padding: 0 12px;
        color: #0f172a;
        font-size: 15px;
    }

    .pa-home-hero__search button {
        min-height: 46px;
        border: 0;
        border-radius: 8px;
        padding: 0 18px;
        background: #0c8f75;
        color: #ffffff;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        white-space: nowrap;
    }

    .pa-home-hero__trust {
        margin-top: 18px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
    }

    .pa-home-hero__trust-item {
        min-height: 74px;
        border-radius: 8px;
        padding: 12px;
        background: #f8fbfb;
        border: 1px solid #edf2f1;
    }

    .pa-home-hero__trust-title {
        color: #0c585c;
        font-size: 14px;
        line-height: 1.3;
        font-weight: 850;
    }

    .pa-home-hero__trust-text {
        margin-top: 4px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.4;
    }

    .pa-home-hero__media {
        position: relative;
        min-width: 0;
        min-height: 438px;
        overflow: hidden;
        border-radius: 8px;
        background: #eaf7f3;
        border: 1px solid #dbe7e5;
        box-shadow: 0 16px 42px rgba(12, 88, 92, .10);
    }

    .pa-home-hero__track {
        display: flex;
        width: 100%;
        height: 100%;
        min-height: inherit;
        transition: transform .55s ease;
    }

    .pa-home-hero__slide {
        flex: 0 0 100%;
        width: 100%;
        min-height: inherit;
    }

    .pa-home-hero__slide-link,
    .pa-home-hero__slide-image {
        display: block;
        width: 100%;
        height: 100%;
        min-height: inherit;
    }

    .pa-home-hero__slide-image {
        object-fit: cover;
        object-position: center;
        background: #eef6f4;
    }

    .pa-home-hero__empty {
        min-height: inherit;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        color: #0c585c;
        font-weight: 800;
    }

    .pa-home-hero__dots {
        position: absolute;
        left: 24px;
        bottom: 20px;
        display: flex;
        gap: 8px;
        padding: 8px 10px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .82);
        box-shadow: 0 10px 24px rgba(15, 23, 42, .10);
        backdrop-filter: blur(10px);
    }

    .pa-home-hero__dot {
        width: 9px;
        height: 9px;
        border: 0;
        padding: 0;
        border-radius: 999px;
        background: #9db4b1;
        cursor: pointer;
        transition: width .2s ease, background .2s ease;
    }

    .pa-home-hero__dot.is-active {
        width: 26px;
        background: #0c8f75;
    }

    .pa-home-actions {
        width: min(1320px, calc(100% - 32px));
        margin: 18px auto 0;
        min-width: 0;
    }

    .pa-home-actions__list {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 12px;
    }

    .pa-home-actions__item {
        min-height: 106px;
        border: 1px solid #dbe7e5;
        border-radius: 8px;
        background: #ffffff;
        color: #0f3f42;
        padding: 14px 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-align: center;
        cursor: pointer;
        box-shadow: 0 10px 26px rgba(12, 88, 92, .055);
        transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease;
        font-family: inherit;
    }

    .pa-home-actions__item:hover {
        transform: translateY(-2px);
        border-color: rgba(12, 143, 117, .38);
        box-shadow: 0 16px 32px rgba(12, 88, 92, .10);
    }

    .pa-home-actions__icon {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(12, 143, 117, .08);
        overflow: hidden;
    }

    .pa-home-actions__icon img {
        width: 28px;
        height: 28px;
        object-fit: contain;
        display: block;
    }

    .pa-home-actions__text {
        color: #0f3f42;
        font-size: 13px;
        line-height: 1.35;
        font-weight: 760;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    @media (max-width: 1100px) {
        .pa-home-hero__shell {
            grid-template-columns: 1fr;
        }

        .pa-home-hero__copy,
        .pa-home-hero__media {
            min-height: 360px;
        }

        .pa-home-actions__list {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px) {
        .pa-home-hero {
            padding: 14px 0 10px;
        }

        .pa-home-hero__shell,
        .pa-home-actions {
            width: calc(100vw - 24px) !important;
            max-width: calc(100vw - 24px) !important;
        }

        .pa-home-hero__shell {
            gap: 12px;
        }

        .pa-home-hero__copy {
            width: 100%;
            max-width: 100%;
            min-height: 0;
            padding: 20px;
            order: 2;
            overflow: hidden;
        }

        .pa-home-hero__media {
            width: 100%;
            max-width: 100%;
            min-height: 0;
            aspect-ratio: 16 / 9;
            order: 1;
        }

        .pa-home-hero__slide-link,
        .pa-home-hero__slide-image {
            min-height: 0;
        }

        .pa-home-hero__slide-image {
            object-fit: cover;
        }

        .pa-home-hero__title {
            font-size: 26px;
            line-height: 1.12;
        }

        .pa-home-hero__desc {
            font-size: 14px;
            line-height: 1.6;
        }

        .pa-home-hero__search {
            width: 100%;
            max-width: 100%;
            grid-template-columns: 1fr;
        }

        .pa-home-hero__search input,
        .pa-home-hero__search button {
            min-width: 0;
            max-width: 100%;
        }

        .pa-home-hero__trust {
            grid-template-columns: 1fr;
        }

        .pa-home-actions__list {
            width: 100%;
            max-width: 100%;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .pa-home-actions__item {
            min-width: 0;
            max-width: 100%;
            min-height: 92px;
            padding: 10px 6px;
        }

        .pa-home-actions__icon {
            width: 38px;
            height: 38px;
        }

        .pa-home-actions__icon img {
            width: 24px;
            height: 24px;
        }

        .pa-home-actions__text {
            font-size: 11px;
        }
    }

    @media (max-width: 600px) {
        .pa-home-hero__shell,
        .pa-home-actions {
            width: min(calc(100vw - 24px), 366px) !important;
            max-width: min(calc(100vw - 24px), 366px) !important;
            margin-left: 12px !important;
            margin-right: 12px !important;
        }
    }
</style>

<section class="pa-home-hero">
    <div class="pa-home-hero__shell">
        <div class="pa-home-hero__copy">
            <div class="pa-home-hero__eyebrow">
                Nhà thuốc Phương Anh
            </div>

            <h1 class="pa-home-hero__title">
                Chăm sóc sức khỏe gia đình rõ ràng, nhanh và đáng tin cậy
            </h1>

            <p class="pa-home-hero__desc">
                Tìm sản phẩm, gửi đơn thuốc, nhận tư vấn dược sĩ và theo dõi đơn hàng trong một trải nghiệm gọn gàng hơn.
            </p>

            <form method="GET" action="{{ route('website.search.index') }}" class="pa-home-hero__search">
                <input type="search" name="q" placeholder="Tìm thuốc, thực phẩm chức năng, thiết bị y tế..." aria-label="Tìm kiếm sản phẩm">
                <button type="submit">Tìm kiếm</button>
            </form>

            <div class="pa-home-hero__trust">
                <div class="pa-home-hero__trust-item">
                    <div class="pa-home-hero__trust-title">Tư vấn dược sĩ</div>
                    <div class="pa-home-hero__trust-text">Hỗ trợ chọn đúng sản phẩm cần dùng.</div>
                </div>

                <div class="pa-home-hero__trust-item">
                    <div class="pa-home-hero__trust-title">Sản phẩm rõ nguồn gốc</div>
                    <div class="pa-home-hero__trust-text">Thông tin giá, đơn vị và danh mục dễ kiểm tra.</div>
                </div>

                <div class="pa-home-hero__trust-item">
                    <div class="pa-home-hero__trust-title">Mua hàng thuận tiện</div>
                    <div class="pa-home-hero__trust-text">Gửi yêu cầu, tra đơn và tìm chi nhánh gần bạn.</div>
                </div>
            </div>
        </div>

        <div class="pa-home-hero__media" id="paHomeHeroSlider">
            <div class="pa-home-hero__track" id="paHomeHeroTrack">
                @forelse($sortedBanners as $index => $banner)
                    <article class="pa-home-hero__slide {{ $index === 0 ? 'is-active' : '' }}" data-index="{{ $index }}">
                        <a href="{{ $banner->detail_url ?? 'javascript:void(0)' }}"
                           class="pa-home-hero__slide-link"
                           @if(!empty($banner->detail_url) && \Illuminate\Support\Str::startsWith($banner->detail_url, ['http://', 'https://'])) target="_blank" @endif>
                            <img
                                src="{{ $banner->image_url }}"
                                alt="{{ $banner->title ?? 'Banner Nhà thuốc Phương Anh' }}"
                                class="pa-home-hero__slide-image"
                                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                decoding="async"
                            >
                        </a>
                    </article>
                @empty
                    <article class="pa-home-hero__slide is-active">
                        <div class="pa-home-hero__empty">Banner đang được cập nhật</div>
                    </article>
                @endforelse
            </div>

            @if($sortedBanners->count() > 1)
                <div class="pa-home-hero__dots" id="paHomeHeroDots">
                    @foreach($sortedBanners as $index => $banner)
                        <button
                            type="button"
                            class="pa-home-hero__dot {{ $index === 0 ? 'is-active' : '' }}"
                            data-slide="{{ $index }}"
                            aria-label="Chuyển đến banner {{ $index + 1 }}"
                        ></button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

<section class="pa-home-actions" aria-label="Lối tắt chức năng">
    <div class="pa-home-actions__list">
        <button type="button" class="pa-home-actions__item" onclick="window.location.href='{{ route('website.prescription_request_v1.index') }}'">
            <span class="pa-home-actions__icon"><img src="{{ asset('phuonganh/img/ic_1.png') }}" alt=""></span>
            <span class="pa-home-actions__text">Cần mua thuốc</span>
        </button>

        <button type="button" class="pa-home-actions__item" onclick="window.location.href='{{ route('website.pharmacist_consult_v1.index') }}'">
            <span class="pa-home-actions__icon"><img src="{{ asset('phuonganh/img/ic_2.png') }}" alt=""></span>
            <span class="pa-home-actions__text">Tư vấn dược sĩ</span>
        </button>

        <button type="button" class="pa-home-actions__item" onclick="window.location.href='{{ route('website.my-order.index') }}'">
            <span class="pa-home-actions__icon"><img src="{{ asset('phuonganh/img/ic_3.png') }}" alt=""></span>
            <span class="pa-home-actions__text">Đơn của tôi</span>
        </button>

        <button type="button" class="pa-home-actions__item" onclick="window.location.href='{{ route('website.purchased_medicine_v1.index') }}'">
            <span class="pa-home-actions__icon"><img src="{{ asset('phuonganh/img/ic_4.png') }}" alt=""></span>
            <span class="pa-home-actions__text">Đơn thuốc đã mua</span>
        </button>

        <button type="button" class="pa-home-actions__item" onclick="window.location.href='{{ route('website.near-branches') }}'">
            <span class="pa-home-actions__icon"><img src="{{ asset('phuonganh/img/ic_5.png') }}" alt=""></span>
            <span class="pa-home-actions__text">Nhà thuốc gần bạn</span>
        </button>

        <button type="button" class="pa-home-actions__item" onclick="window.location.href='{{ route('website.reward_exchange_v1.index') }}'">
            <span class="pa-home-actions__icon"><img src="{{ asset('phuonganh/img/ic_6.png') }}" alt=""></span>
            <span class="pa-home-actions__text">Tích điểm đổi quà</span>
        </button>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('paHomeHeroSlider');
    const track = document.getElementById('paHomeHeroTrack');

    if (!slider || !track) return;

    const slides = Array.from(track.querySelectorAll('.pa-home-hero__slide'));
    const total = slides.length;
    if (total <= 1) return;

    const dots = Array.from(document.querySelectorAll('#paHomeHeroDots .pa-home-hero__dot'));
    let currentIndex = 0;
    let autoTimer = null;
    const autoDelay = 5200;

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
