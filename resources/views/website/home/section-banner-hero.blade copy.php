@php
    $mainSeo = $topSeoHeader ?? null;
    $sideItems = collect($sideSeoHeaders ?? [])->take(3);
    $sortedBanners = collect($banners ?? [])
        ->sortBy(function ($item) {
            return (int) ($item->sort_order ?? 999999);
        })
        ->values();
@endphp

<style>
    .pa-home-hero{
        padding: 0 0 20px;
    }

    .pa-home-hero__bleed{
        width: 100vw;
        margin-left: calc(50% - 50vw);
        position: relative;
    }

    .pa-home-hero__slider{
        position: relative;
        min-height: clamp(360px, 44vw, 620px);
        overflow: hidden;
        background: linear-gradient(135deg, #dff5ff 0%, #cfeeff 50%, #dff5ff 100%);
    }

    .pa-home-hero__track{
        display: flex;
        width: 100%;
        height: 100%;
        min-height: inherit;
        transition: transform .6s cubic-bezier(.22,1,.36,1);
        will-change: transform;
    }

    .pa-home-hero__slide{
        position: relative;
        flex: 0 0 100%;
        width: 100%;
        min-height: inherit;
        overflow: hidden;
    }

    .pa-home-hero__slide-link{
        display: block;
        width: 100%;
        height: 100%;
        min-height: inherit;
        text-decoration: none;
    }

    .pa-home-hero__slide-image{
        width: 100%;
        height: 100%;
        min-height: inherit;
        object-fit: cover;
        object-position: center;
        display: block;
        transform: scale(1.03);
        transition: transform 7s ease;
        background: #eef6fb;
    }

    .pa-home-hero__slide.is-active .pa-home-hero__slide-image{
        transform: scale(1);
    }

    .pa-home-hero__overlay{
        position: absolute;
        inset: 0;
        z-index: 3;
        pointer-events: none;
        background:
            linear-gradient(90deg, rgba(8, 47, 73, .74) 0%, rgba(8, 47, 73, .46) 34%, rgba(8, 47, 73, .18) 60%, rgba(8, 47, 73, .10) 100%);
    }

    .pa-home-hero__inner{
        width: min(1320px, calc(100% - 32px));
        margin: 0 auto;
        min-height: inherit;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        align-items: end;
        gap: 24px;
        padding: 28px 0 34px;
        height: 100%;
    }

    .pa-home-hero__content{
        pointer-events: auto;
        max-width: 760px;
        color: #fff;
    }

    .pa-home-hero__eyebrow{
        display: inline-flex;
        align-items: center;
        min-height: 40px;
        padding: 0 16px;
        border-radius: 999px;
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.18);
        backdrop-filter: blur(10px);
        font-size: 13px;
        font-weight: 900;
        letter-spacing: .04em;
        margin-bottom: 14px;
    }

    .pa-home-hero__title{
        margin: 0;
        font-size: clamp(32px, 5vw, 64px);
        line-height: 1.02;
        font-weight: 900;
        letter-spacing: -0.04em;
        color: #fff;
        text-shadow: 0 10px 30px rgba(0,0,0,.15);
    }

    .pa-home-hero__desc{
        margin: 16px 0 0;
        font-size: clamp(15px, 1.6vw, 18px);
        line-height: 1.85;
        color: rgba(255,255,255,.92);
        max-width: 720px;
    }

    .pa-home-hero__actions{
        margin-top: 24px;
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .pa-home-hero__btn{
        min-height: 50px;
        padding: 0 22px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 15px;
        font-weight: 900;
        transition: all .25s ease;
    }

    .pa-home-hero__btn--primary{
        color: #fff;
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        box-shadow: 0 18px 32px rgba(37,99,235,.28);
    }

    .pa-home-hero__btn--primary:hover{
        transform: translateY(-2px);
    }

    .pa-home-hero__btn--ghost{
        color: #fff;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.18);
        backdrop-filter: blur(10px);
    }

    .pa-home-hero__btn--ghost:hover{
        background: rgba(255,255,255,.18);
    }

    .pa-home-hero__side{
        pointer-events: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        align-self: center;
    }

    .pa-home-hero__side-card{
        display: block;
        text-decoration: none;
        color: #fff;
        border-radius: 22px;
        padding: 16px 18px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.16);
        backdrop-filter: blur(12px);
        box-shadow: 0 18px 30px rgba(15,23,42,.12);
        transition: all .25s ease;
    }

    .pa-home-hero__side-card:hover{
        transform: translateY(-2px);
        background: rgba(255,255,255,.18);
        color: #fff;
    }

    .pa-home-hero__side-title{
        font-size: 16px;
        line-height: 1.45;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .pa-home-hero__side-desc{
        font-size: 13px;
        line-height: 1.7;
        color: rgba(255,255,255,.82);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .pa-home-hero__nav{
        position: absolute;
        inset: 0;
        z-index: 5;
        pointer-events: none;
    }

    .pa-home-hero__arrow{
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: auto;
        width: 48px;
        height: 48px;
        border: 0;
        border-radius: 999px;
        background: rgba(255,255,255,.88);
        color: #0f172a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        line-height: 1;
        cursor: pointer;
        box-shadow: 0 16px 30px rgba(15,23,42,.16);
        transition: all .2s ease;
        backdrop-filter: blur(6px);
    }

    .pa-home-hero__arrow:hover{
        background: #fff;
        transform: translateY(-50%) scale(1.06);
    }

    .pa-home-hero__arrow--prev{
        left: 18px;
    }

    .pa-home-hero__arrow--next{
        right: 18px;
    }

    .pa-home-hero__dots{
        position: absolute;
        left: 50%;
        bottom: 18px;
        transform: translateX(-50%);
        z-index: 6;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(15,23,42,.22);
        backdrop-filter: blur(10px);
    }

    .pa-home-hero__dot{
        width: 10px;
        height: 10px;
        border-radius: 999px;
        border: 0;
        padding: 0;
        background: rgba(255,255,255,.5);
        cursor: pointer;
        transition: all .25s ease;
    }

    .pa-home-hero__dot:hover{
        background: rgba(255,255,255,.8);
    }

    .pa-home-hero__dot.is-active{
        width: 26px;
        background: #fff;
    }

    .pa-home-hero__progress{
        position: absolute;
        left: 0;
        bottom: 0;
        z-index: 7;
        height: 3px;
        width: 0;
        background: rgba(255,255,255,.95);
        box-shadow: 0 0 12px rgba(255,255,255,.35);
    }

    .pa-home-hero__empty{
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: inherit;
        color: #0f172a;
        font-size: 18px;
        font-weight: 800;
        background: linear-gradient(135deg, #edf7fb, #f8fbfd);
    }

    @media (max-width: 1199px){
        .pa-home-hero__inner{
            grid-template-columns: minmax(0, 1fr) 300px;
        }
    }

    @media (max-width: 991px){
        .pa-home-hero__slider{
            min-height: 520px;
        }

        .pa-home-hero__inner{
            grid-template-columns: 1fr;
            align-items: end;
            gap: 16px;
            padding: 22px 0 30px;
        }

        .pa-home-hero__side{
            display: grid;
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px){
        .pa-home-hero__slider{
            min-height: 470px;
        }

        .pa-home-hero__bleed{
            width: 100%;
            margin-left: 0;
        }

        .pa-home-hero__inner{
            width: min(100%, calc(100% - 20px));
            padding: 18px 0 24px;
        }

        .pa-home-hero__desc{
            line-height: 1.7;
        }

        .pa-home-hero__actions{
            gap: 10px;
        }

        .pa-home-hero__btn{
            min-height: 46px;
            padding: 0 18px;
            font-size: 14px;
        }

        .pa-home-hero__arrow{
            width: 40px;
            height: 40px;
            font-size: 22px;
        }

        .pa-home-hero__arrow--prev{
            left: 10px;
        }

        .pa-home-hero__arrow--next{
            right: 10px;
        }

        .pa-home-hero__dots{
            bottom: 12px;
            gap: 6px;
            padding: 7px 10px;
        }

        .pa-home-hero__dot{
            width: 8px;
            height: 8px;
        }

        .pa-home-hero__dot.is-active{
            width: 20px;
        }
    }
</style>

<section class="pa-home-hero">
    <div class="pa-home-hero__bleed">
        <div class="pa-home-hero__slider" id="paHomeHeroSlider">
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

            <div class="pa-home-hero__overlay">
                <div class="pa-home-hero__inner">
                    <div class="pa-home-hero__content">
                        @if($mainSeo)
                            <div class="pa-home-hero__eyebrow">
                                {{ $mainSeo->seo_title ?? 'Nhà thuốc Phương Anh' }}
                            </div>

                            <h1 class="pa-home-hero__title">
                                {{ $mainSeo->seo_description ?? 'Nhà thuốc Phương Anh luôn đồng hành cùng sức khỏe gia đình bạn' }}
                            </h1>

                            <p class="pa-home-hero__desc">
                                {{ \Illuminate\Support\Str::limit(strip_tags($mainSeo->seo_keyword ?? $mainSeo->seo_description ?? ''), 220) ?: 'Hệ thống nhà thuốc với sản phẩm chính hãng, tư vấn tận tâm và trải nghiệm mua sắm hiện đại.' }}
                            </p>

                            <div class="pa-home-hero__actions">
                                <a href="{{ route('website.text_seo_header.show', $mainSeo->id) }}" class="pa-home-hero__btn pa-home-hero__btn--primary">
                                    Xem ngay
                                </a>
                                <a href="javascript:void(0)" class="pa-home-hero__btn pa-home-hero__btn--ghost">
                                    Khám phá thêm
                                </a>
                            </div>
                        @else
                            <div class="pa-home-hero__eyebrow">Nhà thuốc Phương Anh</div>

                            <h1 class="pa-home-hero__title">
                                Chăm sóc sức khỏe gia đình bằng trải nghiệm mua sắm hiện đại
                            </h1>

                            <p class="pa-home-hero__desc">
                                Sản phẩm rõ nguồn gốc, tư vấn tận tâm, dễ tìm kiếm và đặt hàng nhanh chóng trên toàn hệ thống.
                            </p>

                            <div class="pa-home-hero__actions">
                                <a href="javascript:void(0)" class="pa-home-hero__btn pa-home-hero__btn--primary">
                                    Xem ngay
                                </a>
                            </div>
                        @endif
                    </div>

                    @if($sideItems->count() > 0)
                        <div class="pa-home-hero__side">
                            @foreach($sideItems as $item)
                                <a href="{{ route('website.text_seo_header.show', $item->id) }}"
                                   class="pa-home-hero__side-card">
                                    <div class="pa-home-hero__side-title">
                                        {{ $item->seo_title ?? 'Thông tin nổi bật' }}
                                    </div>
                                    <div class="pa-home-hero__side-desc">
                                        {{ $item->seo_description ?? 'Xem thêm nội dung đang được khách hàng quan tâm.' }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            @if($sortedBanners->count() > 1)
                <div class="pa-home-hero__nav">
                    <button class="pa-home-hero__arrow pa-home-hero__arrow--prev" type="button" id="paHomeHeroPrev" aria-label="Banner trước">
                        ‹
                    </button>

                    <button class="pa-home-hero__arrow pa-home-hero__arrow--next" type="button" id="paHomeHeroNext" aria-label="Banner tiếp theo">
                        ›
                    </button>
                </div>

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

                <div class="pa-home-hero__progress" id="paHomeHeroProgress"></div>
            @endif
        </div>
    </div>
</section>
<section class="lc-banner-quick-actions" aria-label="Lối tắt chức năng">
            <div class="lc-quick-list">
                <button type="button" class="lc-quick-item">
                    <div class="lc-quick-item-icon">
                        <img style="width:45px;" src="{{ asset('phuonganh/img/ic_1.png') }}" alt="Dược Phương Anh" />
                    </div>
                    <div>Cần mua thuốc</div>
                </button>
                <button
                    type="button"
                    class="lc-quick-item"
                    onclick="window.location.href='{{ route('website.pharmacist_consult_v1.index') }}'"
                >
                    <div class="lc-quick-item-icon">
                        <img style="width:45px;" src="{{ asset('phuonganh/img/ic_2.png') }}" alt="Dược Phương Anh" />
                    </div>
                    <div>Tư vấn với Dược sĩ</div>
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
                <button type="button" class="lc-quick-item"
                    
                >
                    <div class="lc-quick-item-icon">
                        <img style="width:45px;" src="{{ asset('phuonganh/img/ic_4.png') }}" alt="Dược Phương Anh" />
                    </div>
                    <div>Tìm nhà thuốc</div>
                </button>
                <button type="button" class="lc-quick-item"
                onclick="window.location.href='{{ route('website.near-branches') }}'">
                    <div class="lc-quick-item-icon">
                        <img style="width:45px;" src="{{ asset('phuonganh/img/ic_5.png') }}" alt="Dược Phương Anh" />
                    </div>
                    <div>Nhà thuốc gần bạn</div>
                </button>
                <button
                    type="button"
                    class="lc-quick-item"
                    onclick="window.location.href='{{ route('website.reward_exchange_v1.index') }}'"
                >
                    <div class="lc-quick-item-icon">
                        <img style="width:45px;" src="{{ asset('phuonganh/img/ic_6.png') }}" alt="Dược Phương Anh" />
                    </div>
                    <div>Tích điểm - Đổi quà</div>
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

    const prevBtn = document.getElementById('paHomeHeroPrev');
    const nextBtn = document.getElementById('paHomeHeroNext');
    const dots = Array.from(document.querySelectorAll('#paHomeHeroDots .pa-home-hero__dot'));
    const progress = document.getElementById('paHomeHeroProgress');

    let currentIndex = 0;
    let autoTimer = null;
    const autoDelay = 5000;

    function setActive(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('is-active', i === index);
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle('is-active', i === index);
        });
    }

    function resetProgress() {
        if (!progress) return;
        progress.style.transition = 'none';
        progress.style.width = '0%';
        void progress.offsetWidth;
        progress.style.transition = `width ${autoDelay}ms linear`;
        progress.style.width = '100%';
    }

    function goTo(index) {
        currentIndex = (index + total) % total;
        track.style.transform = `translate3d(-${currentIndex * 100}%, 0, 0)`;
        setActive(currentIndex);
        resetProgress();
    }

    function nextSlide() {
        goTo(currentIndex + 1);
    }

    function prevSlide() {
        goTo(currentIndex - 1);
    }

    function stopAutoPlay() {
        if (autoTimer) {
            clearInterval(autoTimer);
            autoTimer = null;
        }
    }

    function startAutoPlay() {
        stopAutoPlay();
        resetProgress();
        autoTimer = setInterval(nextSlide, autoDelay);
    }

    prevBtn?.addEventListener('click', function () {
        prevSlide();
        startAutoPlay();
    });

    nextBtn?.addEventListener('click', function () {
        nextSlide();
        startAutoPlay();
    });

    dots.forEach((dot) => {
        dot.addEventListener('click', function () {
            const index = Number(this.getAttribute('data-slide'));
            if (!Number.isNaN(index)) {
                goTo(index);
                startAutoPlay();
            }
        });
    });

    slider.addEventListener('mouseenter', stopAutoPlay);
    slider.addEventListener('mouseleave', startAutoPlay);
    slider.addEventListener('touchstart', stopAutoPlay, { passive: true });
    slider.addEventListener('touchend', startAutoPlay, { passive: true });

    let touchStartX = 0;
    slider.addEventListener('touchstart', function (e) {
        touchStartX = e.changedTouches[0].clientX;
    }, { passive: true });

    slider.addEventListener('touchend', function (e) {
        const touchEndX = e.changedTouches[0].clientX;
        const delta = touchEndX - touchStartX;

        if (Math.abs(delta) > 40) {
            if (delta < 0) {
                nextSlide();
            } else {
                prevSlide();
            }
            startAutoPlay();
        }
    }, { passive: true });

    goTo(0);
    startAutoPlay();
});
</script>