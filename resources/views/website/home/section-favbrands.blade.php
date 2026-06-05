@once
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">
@endonce

<section class="lc-favbrands" aria-label="Thương hiệu yêu thích">
    <div class="lc-container">
        <header class="lc-section-header">
            <div class="lc-section-header-icon lc-section-header-icon-remix">
                <i class="ri-medal-line" aria-hidden="true"></i>
            </div>

            <h2 class="lc-section-header-title">Thương hiệu yêu thích</h2>
        </header>

        <div
            class="lc-favbrands-intro"
            style="--favbrands-bg: url('{{ asset('phuonganh/img/favbrands-medical-bg.jpg') }}');"
        >
            <div class="lc-favbrands-intro-content">
                <div class="lc-favbrands-intro-badge">
                    <i class="ri-shield-star-line" aria-hidden="true"></i>
                    <span>Đối tác thương hiệu uy tín</span>
                </div>

                <h3>Thương hiệu nổi bật</h3>

                <p>
                    Hệ thống nhà thuốc Phương Anh là đơn vị chuỗi hệ thống nhà thuốc số 1 tại Tỉnh Cao Bằng
                    với hàng nghìn nhãn hàng lớn trong và ngoài nước.
                </p>
            </div>

            <div class="lc-favbrands-intro-side">
                <div class="lc-favbrands-intro-side-icon">
                    <i class="ri-hand-heart-line" aria-hidden="true"></i>
                </div>

                <strong>Tiên phong đồng hành cùng nhãn hàng</strong>
            </div>
        </div>

        <div class="lc-favbrands-wrap">
            @if(!empty($favoriteBrands) && count($favoriteBrands) > 0)
                <div class="lc-favbrands-list" id="favBrandsList">
                    @foreach($favoriteBrands as $brand)
                        <a href="{{ $brand['url'] }}" class="lc-favbrands-card">
                            <div class="lc-favbrands-top">
                                <img
                                    src="{{ $brand['featured_image'] }}"
                                    alt="{{ $brand['name'] }}"
                                />
                            </div>

                            <div class="lc-favbrands-bottom">
                                <div class="lc-favbrands-logo-pill">
                                    <img
                                        src="{{ $brand['logo'] }}"
                                        alt="{{ $brand['name'] }}"
                                    />
                                    <span>{{ $brand['name'] }}</span>
                                </div>

                                <div class="lc-favbrands-discount">
                                    {{ $brand['short_desc'] ?: 'Thương hiệu nổi bật' }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <button
                    class="lc-favbrands-next"
                    type="button"
                    id="favBrandsNext"
                    aria-label="Xem thêm thương hiệu yêu thích"
                >
                    <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
                </button>
            @else
                <div class="lc-favbrands-empty">
                    Đang cập nhật thương hiệu yêu thích.
                </div>
            @endif
        </div>
    </div>
</section>

@once
<style>
    :root{
        --pa-brand: #0c585c;
        --pa-brand-2: #0c8f75;
        --pa-brand-3: #12a6b5;
        --pa-soft: rgba(12, 88, 92, .08);
        --pa-text: #0f172a;
        --pa-muted: #64748b;
    }

    .lc-favbrands i{
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 400 !important;
        -webkit-text-stroke: 0 !important;
    }

    .lc-section-header-icon-remix{
        color: var(--pa-brand);
        background: var(--pa-soft);
    }

    .lc-section-header-icon-remix i{
        font-size: 19px;
    }

    .lc-favbrands-intro{
        position: relative;
        overflow: hidden;
        min-height: 260px;
        border-radius: 30px;
        margin-bottom: 26px;
        padding: 42px 44px;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 330px;
        gap: 32px;
        align-items: center;
        background:
            linear-gradient(115deg, #1fb2b3 0%, rgb(88 208 211) 52%, rgb(66 194 196) 100% 100%), var(--favbrands-bg);
        background-size: cover;
        background-position: center;
        box-shadow: 0 22px 50px rgba(12, 88, 92, .18);
    }

    .lc-favbrands-intro::before{
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 72% 18%, rgba(255,255,255,.20), transparent 30%),
            radial-gradient(circle at 28% 92%, rgba(255,255,255,.12), transparent 34%);
        pointer-events: none;
    }

    .lc-favbrands-intro-content,
    .lc-favbrands-intro-side{
        position: relative;
        z-index: 1;
    }

    .lc-favbrands-intro-badge{
        width: fit-content;
        max-width: 100%;
        min-height: 42px;
        padding: 0 18px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 9px;
        color: #ffffff;
        background: rgba(255, 255, 255, .13);
        border: 1px solid rgba(255, 255, 255, .22);
        backdrop-filter: blur(10px);
        margin-bottom: 18px;
    }

    .lc-favbrands-intro-badge i{
        font-size: 18px;
    }

    .lc-favbrands-intro-badge span{
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .01em;
    }

    .lc-favbrands-intro h3{
        margin: 0;
        color: #ffffff;
        font-size: clamp(32px, 3.8vw, 58px);
        line-height: 1.08;
        font-weight: 850;
        letter-spacing: -.035em;
    }

    .lc-favbrands-intro p{
        margin: 18px 0 0;
        max-width: 780px;
        color: rgba(255, 255, 255, .88);
        font-size: 18px;
        line-height: 1.65;
        font-weight: 500;
    }

    .lc-favbrands-intro-side{
        min-height: 170px;
        border-radius: 28px;
        padding: 26px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 18px;
        color: #ffffff;
        background: rgba(255, 255, 255, .15);
        border: 1px solid rgba(255, 255, 255, .22);
        backdrop-filter: blur(14px);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.12);
    }

    .lc-favbrands-intro-side-icon{
        width: 54px;
        height: 54px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, .16);
        border: 1px solid rgba(255, 255, 255, .18);
    }

    .lc-favbrands-intro-side-icon i{
        font-size: 25px;
    }

    .lc-favbrands-intro-side strong{
        display: block;
        font-size: 24px;
        line-height: 1.35;
        font-weight: 800;
        letter-spacing: -.015em;
    }

    .lc-favbrands-wrap{
        position: relative;
    }

    .lc-favbrands-list{
        display: flex;
        gap: 18px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 4px 6px 14px;
        scrollbar-width: none;
    }

    .lc-favbrands-list::-webkit-scrollbar{
        display: none;
    }

    .lc-favbrands-card{
        flex: 0 0 300px;
        min-height: 360px;
        border-radius: 24px;
        overflow: hidden;
        background: #ffffff;
        color: inherit;
        text-decoration: none;
        box-shadow: 0 14px 34px rgba(15, 23, 42, .08);
        border: 1px solid rgba(226, 232, 240, .92);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .lc-favbrands-card:hover{
        transform: translateY(-3px);
        box-shadow: 0 20px 42px rgba(15, 23, 42, .12);
        border-color: rgba(12, 143, 117, .22);
        text-decoration: none;
    }

    .lc-favbrands-top{
        height: 165px;
        background: #f8fafc;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .lc-favbrands-top img{
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    .lc-favbrands-bottom{
        padding: 18px;
    }

    .lc-favbrands-logo-pill{
        width: fit-content;
        max-width: 100%;
        min-height: 40px;
        border-radius: 999px;
        border: 1px solid #e6edf2;
        background: #ffffff;
        padding: 6px 14px 6px 10px;
        display: inline-flex;
        align-items: center;
        gap: 9px;
        box-shadow: 0 8px 20px rgba(15, 23, 42, .04);
    }

    .lc-favbrands-logo-pill img{
        width: 24px;
        height: 24px;
        object-fit: contain;
        border-radius: 6px;
        flex: 0 0 auto;
    }

    .lc-favbrands-logo-pill span{
        min-width: 0;
        color: var(--pa-text);
        font-size: 15px;
        font-weight: 700;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .lc-favbrands-discount{
        margin-top: 16px;
        color: #0ea5b4;
        font-size: 15px;
        line-height: 1.55;
        font-weight: 650;

        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .lc-favbrands-next{
        position: absolute;
        top: 50%;
        right: -14px;
        transform: translateY(-50%);
        width: 48px;
        height: 48px;
        border-radius: 999px;
        border: 1px solid rgba(226, 232, 240, .95);
        background: rgba(255, 255, 255, .96);
        color: var(--pa-brand);
        box-shadow: 0 14px 30px rgba(15, 23, 42, .12);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 2;
    }

    .lc-favbrands-next i{
        font-size: 24px;
    }

    .lc-favbrands-next:hover{
        background: var(--pa-brand);
        color: #ffffff;
        border-color: var(--pa-brand);
    }

    .lc-favbrands-empty{
        border-radius: 20px;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        color: #64748b;
        padding: 24px;
        text-align: center;
        font-weight: 600;
    }

    @media (max-width: 991px){
        .lc-favbrands-intro{
            grid-template-columns: 1fr;
            padding: 34px 28px;
            border-radius: 26px;
        }

        .lc-favbrands-intro-side{
            min-height: unset;
            max-width: 420px;
        }
    }

    @media (max-width: 767px){
        .lc-favbrands{
            overflow: hidden;
        }

        .lc-section-header-icon-remix i{
            font-size: 18px;
        }

        .lc-favbrands-intro{
            min-height: auto;
            margin-bottom: 20px;
            padding: 24px 20px;
            border-radius: 22px;
            gap: 20px;
            background:
                linear-gradient(135deg, rgba(5, 81, 70, .96) 0%, rgba(11, 134, 112, .90) 58%, rgba(18, 166, 181, .74) 100%),
                var(--favbrands-bg);
            background-size: cover;
            background-position: center;
        }

        .lc-favbrands-intro-badge{
            min-height: 36px;
            padding: 0 13px;
            margin-bottom: 14px;
        }

        .lc-favbrands-intro-badge i{
            font-size: 16px;
        }

        .lc-favbrands-intro-badge span{
            font-size: 12px;
        }

        .lc-favbrands-intro h3{
            font-size: 30px;
            line-height: 1.12;
        }

        .lc-favbrands-intro p{
            margin-top: 12px;
            font-size: 14px;
            line-height: 1.65;
            font-weight: 500;
        }

        .lc-favbrands-intro-side{
            border-radius: 20px;
            padding: 18px;
            gap: 12px;
        }

        .lc-favbrands-intro-side-icon{
            width: 44px;
            height: 44px;
            border-radius: 15px;
        }

        .lc-favbrands-intro-side-icon i{
            font-size: 21px;
        }

        .lc-favbrands-intro-side strong{
            font-size: 18px;
            line-height: 1.35;
        }

        .lc-favbrands-list{
            gap: 14px;
            padding: 2px 18px 12px 2px;
            margin-right: -18px;
        }

        .lc-favbrands-card{
            flex-basis: 245px;
            min-height: 322px;
            border-radius: 20px;
        }

        .lc-favbrands-top{
            height: 132px;
        }

        .lc-favbrands-bottom{
            padding: 15px;
        }

        .lc-favbrands-logo-pill{
            min-height: 36px;
            padding: 5px 12px 5px 8px;
        }

        .lc-favbrands-logo-pill img{
            width: 22px;
            height: 22px;
        }

        .lc-favbrands-logo-pill span{
            font-size: 14px;
        }

        .lc-favbrands-discount{
            margin-top: 13px;
            font-size: 14px;
            line-height: 1.5;
            font-weight: 600;
        }

        .lc-favbrands-next{
            display: none;
        }
    }
</style>
@endonce

@once
<script>
    (function () {
        const list = document.getElementById('favBrandsList');
        const nextBtn = document.getElementById('favBrandsNext');

        if (!list || !nextBtn) {
            return;
        }

        nextBtn.addEventListener('click', function () {
            const card = list.querySelector('.lc-favbrands-card');
            const gap = 18;
            const scrollAmount = card ? card.offsetWidth + gap : 320;

            list.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });
    })();
</script>
@endonce