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
            background: #f5fbfa !important;
        }

        main {
            overflow-x: hidden;
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
            font-size: 28px !important;
            line-height: 1.2 !important;
            font-weight: 850 !important;
        }

        #homeFlashSaleSection {
            margin-top: 24px !important;
            background: #f5fbfa !important;
        }

        #homeFlashSaleSection .lc-flashsale-box,
        #homeBestSellerSection .lc-bestseller-box {
            border-radius: 8px !important;
        }

        #homeFlashSaleSection .lc-flashsale-box {
            background: #ffffff !important;
            border: 1px solid #dbe7e5 !important;
            box-shadow: 0 16px 42px rgba(12, 88, 92, .08) !important;
        }

        #homeBestSellerSection {
            background: #f5fbfa !important;
        }

        #homeBestSellerSection .lc-bestseller-box {
            background: #0c8f75 !important;
            box-shadow: 0 16px 42px rgba(12, 88, 92, .12) !important;
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

        #homeFlashSaleSection .lc-product-btn-buy,
        #homeBestSellerSection .lc-product-btn-buy,
        #homeFlashSaleSection .lc-flashsale-viewall a {
            border-radius: 8px !important;
        }

        .lc-featured {
            background: #ffffff !important;
        }

        .lc-featured-grid {
            gap: 14px !important;
        }

        .lc-featured-card {
            border: 1px solid #dbe7e5 !important;
            background: #ffffff !important;
        }

        .lc-featured-icon-circle {
            border-radius: 8px !important;
            background: rgba(12, 143, 117, .08) !important;
        }

        .lc-featured-icon-circle img {
            border-radius: 8px !important;
        }

        @media (max-width: 767px) {
            main .lc-container {
                width: calc(100% - 24px) !important;
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
    </style>
    <main>
        <!-- ========== BANNER HERO ==========
         Nền full width, nội dung căn giữa 80% -->
        @include('website.home.section-banner-hero')

        <!-- ========== FLASH SALE GIÁ TỐT ========== -->
        @include('website.home.section-flash-sale')

        <!-- ========== SẢN PHẨM BÁN CHẠY ========== -->
        @include('website.home.section-best-seller')

        <!-- ========== DANH MỤC NỔI BẬT ========== -->
        @include('website.home.section-best-category')

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
</body>

</html>
