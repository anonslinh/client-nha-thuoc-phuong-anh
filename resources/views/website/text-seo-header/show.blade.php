@extends('website.layout.index')

@section('title', ($item->seo_title ?: 'Thông tin nổi bật') . ' | Nhà thuốc Phương Anh')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($item->seo_description ?: $item->article_content ?: 'Thông tin nổi bật từ Nhà thuốc Phương Anh'), 160))
@section('meta_image', $item->banner_url ?? asset('images/no-image.png'))

@section('style')
<style>
    .tsh-page{
        background: linear-gradient(180deg, #f7fbff 0%, #f4f9fd 100%);
        padding: 22px 0 42px;
    }

    .tsh-container{
        width: min(1320px, calc(100% - 32px));
        margin: 0 auto;
    }

    .tsh-breadcrumb{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
    }

    .tsh-breadcrumb a{
        color: #475569;
        text-decoration: none;
    }

    .tsh-breadcrumb a:hover{
        color: #0284c7;
    }

    .tsh-hero{
        position: relative;
        overflow: hidden;
        border-radius: 34px;
        min-height: 420px;
        background:
            linear-gradient(100deg, rgba(8, 47, 73, .88) 0%, rgba(15, 23, 42, .62) 42%, rgba(15, 23, 42, .16) 100%),
            url('{{ $item->banner_url ?? asset('images/no-image.png') }}') center/cover no-repeat;
        box-shadow: 0 28px 60px rgba(15, 23, 42, .14);
    }

    .tsh-hero__content{
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 300px;
        gap: 28px;
        align-items: end;
        min-height: 420px;
        padding: 34px;
    }

    .tsh-badge{
        display: inline-flex;
        align-items: center;
        min-height: 40px;
        padding: 0 16px;
        border-radius: 999px;
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.18);
        backdrop-filter: blur(10px);
        color: #fff;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: .05em;
        margin-bottom: 14px;
    }

    .tsh-title{
        margin: 0;
        font-size: 54px;
        line-height: 1.04;
        font-weight: 900;
        color: #fff;
        letter-spacing: -0.03em;
        text-shadow: 0 10px 30px rgba(0,0,0,.15);
    }

    .tsh-desc{
        margin: 16px 0 0;
        font-size: 18px;
        line-height: 1.85;
        color: rgba(255,255,255,.92);
        max-width: 760px;
    }

    .tsh-actions{
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    .tsh-btn{
        min-height: 48px;
        padding: 0 20px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: 0;
        font-size: 15px;
        font-weight: 900;
        transition: all .25s ease;
        cursor: pointer;
    }

    .tsh-btn--primary{
        color: #fff;
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        box-shadow: 0 18px 30px rgba(37, 99, 235, .22);
    }

    .tsh-btn--primary:hover{
        transform: translateY(-2px);
    }

    .tsh-btn--ghost{
        color: #fff;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.18);
        backdrop-filter: blur(10px);
    }

    .tsh-btn--ghost:hover{
        background: rgba(255,255,255,.18);
    }

    .tsh-hero__card{
        background: rgba(255,255,255,.16);
        border: 1px solid rgba(255,255,255,.18);
        backdrop-filter: blur(12px);
        border-radius: 28px;
        padding: 18px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .12);
        color: #fff;
        align-self: center;
    }

    .tsh-hero__card-title{
        font-size: 12px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 10px;
        color: rgba(255,255,255,.82);
    }

    .tsh-hero__card-text{
        font-size: 15px;
        line-height: 1.8;
        color: rgba(255,255,255,.94);
    }

    .tsh-layout{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 330px;
        gap: 22px;
        margin-top: 24px;
    }

    .tsh-main{
        min-width: 0;
    }

    .tsh-sidebar{
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .tsh-card{
        background: #fff;
        border-radius: 28px;
        border: 1px solid #e8eff6;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .06);
        overflow: hidden;
    }

    .tsh-section{
        padding: 28px;
    }

    .tsh-section__eyebrow{
        font-size: 12px;
        font-weight: 900;
        color: #0284c7;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 8px;
    }

    .tsh-section__title{
        margin: 0 0 18px;
        font-size: 30px;
        line-height: 1.18;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .tsh-content{
        color: #334155;
        font-size: 16px;
        line-height: 1.9;
    }

    .tsh-content p{
        margin: 0 0 14px;
    }

    .tsh-content h1,
    .tsh-content h2,
    .tsh-content h3,
    .tsh-content h4,
    .tsh-content h5,
    .tsh-content h6{
        color: #0f172a;
        margin: 0 0 12px;
        line-height: 1.35;
        font-weight: 800;
    }

    .tsh-content ul,
    .tsh-content ol{
        margin: 0 0 16px;
        padding-left: 20px;
    }

    .tsh-content img{
        max-width: 100%;
        height: auto;
        border-radius: 18px;
        display: block;
        margin: 18px 0;
    }

    .tsh-content table{
        width: 100%;
        border-collapse: collapse;
        margin: 18px 0;
        overflow: hidden;
        border-radius: 16px;
    }

    .tsh-content table td,
    .tsh-content table th{
        border: 1px solid #e5edf5;
        padding: 12px 14px;
        text-align: left;
    }

    .tsh-products-card{
        padding: 22px;
        margin-top: 20px;
    }

    .tsh-products-head{
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 18px;
    }

    .tsh-products-count{
        flex: 0 0 auto;
        padding: 10px 16px;
        border-radius: 999px;
        background: linear-gradient(135deg, #eff8ff, #e5f3ff);
        color: #0284c7;
        font-size: 13px;
        font-weight: 800;
    }

    .tsh-products-grid{
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .tsh-product{
        background: #fff;
        border-radius: 24px;
        border: 1px solid #e8eff6;
        overflow: hidden;
        box-shadow: 0 14px 32px rgba(15, 23, 42, .06);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .tsh-product:hover{
        transform: translateY(-4px);
        box-shadow: 0 22px 42px rgba(15, 23, 42, .10);
    }

    .tsh-product__image{
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        aspect-ratio: 1 / 1;
        padding: 20px;
        background: linear-gradient(180deg, #f9fcff 0%, #f2f8fc 100%);
        text-decoration: none;
    }

    .tsh-product__image img{
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }

    .tsh-product__body{
        padding: 18px;
    }

    .tsh-product__name{
        margin: 0 0 12px;
        min-height: 74px;
        font-size: 16px;
        line-height: 1.6;
        font-weight: 800;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .tsh-product__name a{
        color: #0f172a;
        text-decoration: none;
    }

    .tsh-product__name a:hover{
        color: #0284c7;
    }

    .tsh-product__price{
        margin-bottom: 14px;
    }

    .tsh-product__sale{
        font-size: 23px;
        line-height: 1.2;
        font-weight: 900;
        color: #06b6d4;
    }

    .tsh-product__origin{
        margin-top: 6px;
        font-size: 14px;
        font-weight: 700;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .tsh-product__actions{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .tsh-product__btn{
        width: 100%;
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: linear-gradient(135deg, #f97316, #fb923c);
        color: #fff;
        text-decoration: none;
        font-size: 14px;
        font-weight: 900;
        box-shadow: 0 16px 26px rgba(249, 115, 22, .18);
        border: none;
        cursor: pointer;
    }

    .tsh-product__btn--ghost{
        background: #f8fbff;
        color: #0f172a;
        border: 1px solid #d9e5ef;
        box-shadow: none;
    }

    .tsh-product__btn--ghost:hover{
        color: #0284c7;
        border-color: #38bdf8;
    }

    .tsh-empty{
        min-height: 220px;
        border-radius: 26px;
        border: 1px dashed #d7e4ef;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #64748b;
        font-size: 15px;
        font-weight: 700;
        padding: 20px;
    }

    .tsh-sidebar-card{
        padding: 22px;
    }

    .tsh-sidebar-label{
        font-size: 12px;
        font-weight: 900;
        color: #0284c7;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 8px;
    }

    .tsh-sidebar-title{
        margin: 0 0 14px;
        font-size: 24px;
        line-height: 1.2;
        font-weight: 900;
        color: #0f172a;
    }

    .tsh-sidebar-text{
        color: #475569;
        font-size: 15px;
        line-height: 1.85;
    }

    .tsh-sidebar-banner{
        width: 100%;
        border-radius: 22px;
        overflow: hidden;
        background: #f8fbff;
        margin-top: 14px;
    }

    .tsh-sidebar-banner img{
        width: 100%;
        display: block;
        object-fit: cover;
    }

    .tsh-related-list{
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .tsh-related-item{
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px;
        border-radius: 18px;
        text-decoration: none;
        color: inherit;
        transition: all .22s ease;
        border: 1px solid transparent;
    }

    .tsh-related-item:hover{
        background: #f8fbff;
        border-color: #e4eef7;
        transform: translateX(3px);
    }

    .tsh-related-item img{
        width: 76px;
        height: 58px;
        object-fit: cover;
        border-radius: 12px;
        background: #f4f8fb;
        flex: 0 0 auto;
    }

    .tsh-related-item-title{
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.55;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .tsh-toast{
        position: fixed;
        top: 22px;
        right: 22px;
        z-index: 99999;
        min-width: 280px;
        max-width: 420px;
        padding: 16px 18px;
        border-radius: 16px;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        box-shadow: 0 18px 42px rgba(15,23,42,.18);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all .25s ease;
    }

    .tsh-toast.show{
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .tsh-toast.success{
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .tsh-toast.error{
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    @media (max-width: 1200px){
        .tsh-products-grid{
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 991px){
        .tsh-container{
            width: min(100%, calc(100% - 24px));
        }

        .tsh-hero__content{
            grid-template-columns: 1fr;
            min-height: auto;
            padding: 22px;
        }

        .tsh-layout{
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px){
        .tsh-page{
            padding: 18px 0 28px;
        }

        .tsh-hero{
            min-height: auto;
            border-radius: 24px;
        }

        .tsh-title{
            font-size: 30px;
        }

        .tsh-desc{
            font-size: 15px;
            line-height: 1.75;
        }

        .tsh-section,
        .tsh-sidebar-card,
        .tsh-products-card{
            padding: 20px;
        }

        .tsh-section__title{
            font-size: 24px;
        }

        .tsh-products-head{
            flex-direction: column;
            align-items: flex-start;
        }

        .tsh-products-grid{
            grid-template-columns: 1fr;
        }

        .tsh-product__name{
            min-height: auto;
        }

        .tsh-product__actions{
            grid-template-columns: 1fr;
        }

        .tsh-toast{
            left: 12px;
            right: 12px;
            top: 12px;
            min-width: 0;
            max-width: none;
        }
    }
</style>
@endsection

@section('content')
<section class="tsh-page">
    <div class="tsh-container">
        <div class="tsh-breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <span>/</span>
            <a href="javascript:void(0)">Thông tin nổi bật</a>
            <span>/</span>
            <span>{{ $item->seo_title ?: 'Chi tiết nội dung' }}</span>
        </div>

        <div class="tsh-hero">
            <div class="tsh-hero__content">
                <div class="tsh-hero__left">
                    <div class="tsh-badge">Thông tin nổi bật</div>

                    <h1 class="tsh-title">
                        {{ $item->seo_title ?: 'Nội dung nổi bật từ Nhà thuốc Phương Anh' }}
                    </h1>

                    <p class="tsh-desc">
                        {{ $item->seo_description ?: 'Khám phá các thông tin đang được khách hàng quan tâm cùng nội dung tư vấn được biên soạn rõ ràng và dễ tiếp cận.' }}
                    </p>

                    <div class="tsh-actions">
                        @if(!empty($item->see_more_link))
                            <a href="{{ $item->see_more_link }}"
                               target="_blank"
                               class="tsh-btn tsh-btn--primary">
                                Xem thêm
                            </a>
                        @endif

                        @if((int) $item->has_product_list === 1 && $products->count() > 0)
                            <button type="button" class="tsh-btn tsh-btn--ghost" id="scrollToProducts">
                                Xem sản phẩm liên quan
                            </button>
                        @endif
                    </div>
                </div>

                <div class="tsh-hero__card">
                    <div class="tsh-hero__card-title">Thông tin nhanh</div>
                    <div class="tsh-hero__card-text">
                        {{ \Illuminate\Support\Str::limit(strip_tags($item->seo_description ?: $item->article_content ?: 'Đang cập nhật nội dung.'), 160) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="tsh-layout">
            <div class="tsh-main">
                <div class="tsh-card">
                    <div class="tsh-section">
                        <div class="tsh-section__eyebrow">Nội dung chi tiết</div>
                        <h2 class="tsh-section__title">
                            {{ $item->seo_title ?: 'Thông tin chi tiết' }}
                        </h2>

                        <div class="tsh-content">
                            @php
                                $articleContent = trim((string) ($item->article_content ?? ''));
                            @endphp

                            @if(!empty($articleContent))
                                @if($articleContent !== strip_tags($articleContent))
                                    {!! $articleContent !!}
                                @else
                                    @foreach(array_filter(preg_split('/\r\n|\r|\n/', $articleContent)) as $line)
                                        <p>{{ $line }}</p>
                                    @endforeach
                                @endif
                            @else
                                <p>Đang cập nhật nội dung cho bài viết này.</p>
                            @endif
                        </div>
                    </div>
                </div>

                @if((int) $item->has_product_list === 1)
                    <div class="tsh-card tsh-products-card" id="tshProductsBlock">
                        <div class="tsh-products-head">
                            <div>
                                <div class="tsh-section__eyebrow">Sản phẩm liên quan</div>
                                <h2 class="tsh-section__title" style="margin-bottom:0;">Danh sách gợi ý</h2>
                            </div>

                            <div class="tsh-products-count">
                                {{ $products->count() }} sản phẩm
                            </div>
                        </div>

                        @if($products->count() > 0)
                            <div class="tsh-products-grid">
                                @foreach($products as $product)
                                    <article class="tsh-product">
                                        <a href="javascript:void(0)" class="tsh-product__image">
                                            <img src="{{ $product->image_url }}" alt="{{ $product->full_name ?: $product->name }}">
                                        </a>

                                        <div class="tsh-product__body">
                                            <h3 class="tsh-product__name">
                                                <a href="javascript:void(0)">
                                                    {{ $product->full_name ?: $product->name }}
                                                </a>
                                            </h3>

                                            <div class="tsh-product__price">
                                                <div class="tsh-product__sale">
                                                    {{ number_format((float) $product->display_price, 0, ',', '.') }}đ
                                                </div>

                                                @if(!empty($product->original_price))
                                                    <div class="tsh-product__origin">
                                                        {{ number_format((float) $product->original_price, 0, ',', '.') }}đ
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="tsh-product__actions">
                                                <button
                                                    type="button"
                                                    class="tsh-product__btn js-add-to-cart"
                                                    data-product-id="{{ $product->id }}"
                                                >
                                                    Thêm vào giỏ
                                                </button>

                                                <a href="javascript:void(0)" class="tsh-product__btn tsh-product__btn--ghost">
                                                    Xem chi tiết
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="tsh-empty">
                                Chưa có sản phẩm liên quan để hiển thị.
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <aside class="tsh-sidebar">
                <div class="tsh-card tsh-sidebar-card">
                    <div class="tsh-sidebar-label">Banner nội dung</div>
                    <h3 class="tsh-sidebar-title">{{ $item->seo_title ?: 'Thông tin nổi bật' }}</h3>

                    <div class="tsh-sidebar-banner">
                        <img src="{{ $item->banner_url }}" alt="{{ $item->seo_title }}">
                    </div>
                </div>

                <div class="tsh-card tsh-sidebar-card">
                    <div class="tsh-sidebar-label">Liên kết ngoài</div>
                    <h3 class="tsh-sidebar-title">Xem thêm thông tin</h3>

                    <div class="tsh-sidebar-text">
                        @if(!empty($item->see_more_link))
                            Nội dung này có liên kết mở rộng để bạn xem thêm thông tin liên quan.
                        @else
                            Nội dung này hiện chưa gắn liên kết ngoài.
                        @endif
                    </div>

                    @if(!empty($item->see_more_link))
                        <div style="margin-top:16px;">
                            <a href="{{ $item->see_more_link }}" target="_blank" class="tsh-btn tsh-btn--primary">
                                Mở liên kết
                            </a>
                        </div>
                    @endif
                </div>

                <div class="tsh-card tsh-sidebar-card">
                    <div class="tsh-sidebar-label">Bài viết khác</div>
                    <h3 class="tsh-sidebar-title">Bạn có thể quan tâm</h3>

                    @if($otherSeoHeaders->count() > 0)
                        <div class="tsh-related-list">
                            @foreach($otherSeoHeaders as $seo)
                                <a href="{{ $seo->detail_url }}" class="tsh-related-item">
                                    <img src="{{ $seo->banner_url }}" alt="{{ $seo->seo_title }}">
                                    <div class="tsh-related-item-title">
                                        {{ $seo->seo_title ?: 'Thông tin nổi bật' }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="tsh-sidebar-text">
                            Chưa có bài viết liên quan để hiển thị.
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </div>
</section>

<div class="tsh-toast" id="tshToast"></div>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": @json($item->seo_title ?: 'Thông tin nổi bật'),
    "description": @json(\Illuminate\Support\Str::limit(strip_tags($item->seo_description ?: $item->article_content ?: ''), 160)),
    "image": @json($item->banner_url),
    "mainEntityOfPage": @json(route('website.text_seo_header.show', $item->id))
}
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scrollBtn = document.getElementById('scrollToProducts');
        const productsBlock = document.getElementById('tshProductsBlock');
        const toast = document.getElementById('tshToast');

        function showToast(message, type = 'success') {
            if (!toast) return;
            toast.textContent = message || '';
            toast.className = 'tsh-toast ' + type + ' show';

            clearTimeout(window.__tshToastTimer);
            window.__tshToastTimer = setTimeout(() => {
                toast.classList.remove('show');
            }, 2600);
        }

        if (scrollBtn && productsBlock) {
            scrollBtn.addEventListener('click', function () {
                productsBlock.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        }

        document.querySelectorAll('.js-add-to-cart').forEach(button => {
            button.addEventListener('click', async function () {
                const productId = this.getAttribute('data-product-id');
                const originalText = this.textContent;

                this.disabled = true;
                this.textContent = 'Đang thêm...';

                try {
                    const formData = new FormData();
                    formData.append('product_id', productId);
                    formData.append('quantity', 1);

                    const response = await fetch('{{ route('website.cart.add') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.status) {
                        showToast(data.msg || 'Đã thêm vào giỏ hàng.', 'success');
                    } else {
                        showToast(data.msg || 'Không thể thêm vào giỏ hàng.', 'error');
                    }
                } catch (error) {
                    showToast('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
                } finally {
                    this.disabled = false;
                    this.textContent = originalText;
                }
            });
        });
    });
</script>
@endsection