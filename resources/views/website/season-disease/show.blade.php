@extends('website.layout.index')

@section('style')
<style>
    .sd-page{
        background: linear-gradient(180deg, #f8fbff 0%, #f4f9ff 100%);
        padding-bottom: 40px;
    }

    .sd-container{
        width: min(1320px, calc(100% - 32px));
        margin: 0 auto;
    }

    .sd-hero{
        position: relative;
        border-radius: 34px;
        overflow: hidden;
        min-height: 380px;
        background:
            linear-gradient(100deg, rgba(8, 47, 73, .88) 0%, rgba(15, 23, 42, .62) 40%, rgba(15, 23, 42, .20) 100%),
            url('{{ $seasonDisease->banner_url }}') center/cover no-repeat;
        box-shadow: 0 28px 60px rgba(15, 23, 42, .14);
        margin-top: 22px;
    }

    .sd-hero__content{
        position: relative;
        z-index: 2;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        min-height: 380px;
        padding: 34px;
    }

    .sd-hero__left{
        max-width: 760px;
    }

    .sd-breadcrumb{
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        color: rgba(255,255,255,.88);
        font-size: 14px;
        font-weight: 600;
    }

    .sd-breadcrumb a{
        color: rgba(255,255,255,.92);
        text-decoration: none;
    }

    .sd-breadcrumb a:hover{
        text-decoration: underline;
    }

    .sd-badge{
        display: inline-flex;
        align-items: center;
        height: 36px;
        padding: 0 16px;
        border-radius: 999px;
        background: rgba(255,255,255,.16);
        backdrop-filter: blur(10px);
        color: #fff;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: .04em;
        margin-bottom: 14px;
    }

    .sd-title{
        margin: 0;
        font-size: 54px;
        line-height: 1.05;
        font-weight: 900;
        color: #fff;
        letter-spacing: -0.03em;
    }

    .sd-description{
        margin: 16px 0 0;
        color: rgba(255,255,255,.92);
        font-size: 18px;
        line-height: 1.75;
        max-width: 720px;
    }

    .sd-hero__actions{
        margin-top: 24px;
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .sd-btn{
        height: 50px;
        padding: 0 22px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 15px;
        font-weight: 800;
        transition: all .25s ease;
    }

    .sd-btn--primary{
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        color: #fff;
        box-shadow: 0 18px 30px rgba(37, 99, 235, .24);
    }

    .sd-btn--primary:hover{
        transform: translateY(-2px);
    }

    .sd-btn--ghost{
        background: rgba(255,255,255,.16);
        color: #fff;
        border: 1px solid rgba(255,255,255,.22);
        backdrop-filter: blur(10px);
    }

    .sd-btn--ghost:hover{
        background: rgba(255,255,255,.22);
    }

    .sd-hero__right{
        flex: 0 0 180px;
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
    }

    .sd-avatar-card{
        width: 180px;
        border-radius: 30px;
        padding: 12px;
        background: rgba(255,255,255,.18);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,.20);
        box-shadow: 0 18px 40px rgba(15, 23, 42, .12);
    }

    .sd-avatar-card img{
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        border-radius: 22px;
        display: block;
        background: #fff;
    }

    .sd-layout{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 22px;
        margin-top: 24px;
    }

    .sd-card{
        background: #fff;
        border-radius: 28px;
        border: 1px solid #e8eff6;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .06);
        overflow: hidden;
    }

    .sd-section{
        padding: 28px;
    }

    .sd-section__eyebrow{
        font-size: 12px;
        font-weight: 900;
        color: #0284c7;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 8px;
    }

    .sd-section__title{
        margin: 0 0 18px;
        font-size: 30px;
        line-height: 1.18;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .sd-content{
        color: #334155;
        font-size: 16px;
        line-height: 1.9;
    }

    .sd-content p{
        margin: 0 0 14px;
    }

    .sd-content h1,
    .sd-content h2,
    .sd-content h3,
    .sd-content h4,
    .sd-content h5,
    .sd-content h6{
        color: #0f172a;
        margin: 0 0 12px;
        line-height: 1.35;
        font-weight: 800;
    }

    .sd-content ul,
    .sd-content ol{
        padding-left: 20px;
        margin: 0 0 16px;
    }

    .sd-content img{
        max-width: 100%;
        height: auto;
        border-radius: 18px;
        display: block;
        margin: 18px 0;
    }

    .sd-content table{
        width: 100%;
        border-collapse: collapse;
        margin: 18px 0;
        overflow: hidden;
        border-radius: 16px;
    }

    .sd-content table td,
    .sd-content table th{
        border: 1px solid #e5edf5;
        padding: 12px 14px;
        text-align: left;
    }

    .sd-content blockquote{
        margin: 18px 0;
        padding: 18px 20px;
        border-left: 4px solid #38bdf8;
        background: #f8fbff;
        border-radius: 0 16px 16px 0;
        color: #334155;
    }

    .sd-sidebar{
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .sd-sidebar-card{
        background: #fff;
        border-radius: 28px;
        padding: 22px;
        border: 1px solid #e8eff6;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .06);
    }

    .sd-sidebar-card__label{
        font-size: 12px;
        font-weight: 900;
        color: #0284c7;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 8px;
    }

    .sd-sidebar-card__title{
        margin: 0 0 14px;
        font-size: 24px;
        line-height: 1.2;
        font-weight: 900;
        color: #0f172a;
    }

    .sd-sidebar-card__text{
        color: #475569;
        font-size: 15px;
        line-height: 1.85;
    }

    .sd-sidebar-banner{
        width: 100%;
        border-radius: 22px;
        overflow: hidden;
        background: #f8fbff;
        margin-top: 14px;
    }

    .sd-sidebar-banner img{
        width: 100%;
        display: block;
        object-fit: cover;
    }

    .sd-stats{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 18px;
    }

    .sd-stat{
        border-radius: 20px;
        padding: 16px;
        background: linear-gradient(135deg, #f8fbff, #eef7ff);
        border: 1px solid #e4eef7;
    }

    .sd-stat__value{
        font-size: 24px;
        font-weight: 900;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 8px;
    }

    .sd-stat__label{
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        line-height: 1.5;
    }

    .sd-products{
        margin-top: 24px;
    }

    .sd-products__head{
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 18px;
    }

    .sd-products__count{
        flex: 0 0 auto;
        padding: 10px 16px;
        border-radius: 999px;
        background: linear-gradient(135deg, #eff8ff, #e7f4ff);
        color: #0284c7;
        font-size: 13px;
        font-weight: 800;
    }

    .sd-products__grid{
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .sd-product{
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #e8eff6;
        box-shadow: 0 14px 32px rgba(15, 23, 42, .06);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .sd-product:hover{
        transform: translateY(-4px);
        box-shadow: 0 22px 42px rgba(15, 23, 42, .10);
    }

    .sd-product__image{
        display: flex;
        align-items: center;
        justify-content: center;
        aspect-ratio: 1 / 1;
        padding: 20px;
        background: linear-gradient(180deg, #f9fcff 0%, #f2f8fc 100%);
        text-decoration: none;
    }

    .sd-product__image img{
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }

    .sd-product__body{
        padding: 18px;
    }

    .sd-product__name{
        margin: 0 0 14px;
        min-height: 74px;
        font-size: 16px;
        line-height: 1.6;
        font-weight: 800;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .sd-product__name a{
        color: #0f172a;
        text-decoration: none;
    }

    .sd-product__name a:hover{
        color: #0284c7;
    }

    .sd-product__price{
        margin-bottom: 14px;
    }

    .sd-product__sale{
        font-size: 23px;
        line-height: 1.2;
        font-weight: 900;
        color: #06b6d4;
    }

    .sd-product__sale span{
        font-size: 13px;
        color: #64748b;
        font-weight: 800;
    }

    .sd-product__origin{
        margin-top: 6px;
        font-size: 14px;
        font-weight: 700;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .sd-product__btn{
        width: 100%;
        height: 46px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        background: linear-gradient(135deg, #f97316, #fb923c);
        color: #fff;
        font-size: 15px;
        font-weight: 900;
        box-shadow: 0 16px 26px rgba(249, 115, 22, .18);
    }

    .sd-empty{
        min-height: 240px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-radius: 22px;
        border: 1px dashed #d7e4ef;
        background: #fff;
        color: #64748b;
        font-size: 15px;
        font-weight: 700;
    }

    @media (max-width: 1200px){
        .sd-title{
            font-size: 46px;
        }

        .sd-products__grid{
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 991px){
        .sd-hero{
            min-height: 340px;
        }

        .sd-hero__content{
            min-height: 340px;
            flex-direction: column;
            align-items: flex-start;
        }

        .sd-hero__right{
            justify-content: flex-start;
        }

        .sd-layout{
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px){
        .sd-page{
            padding-bottom: 26px;
        }

        .sd-container{
            width: min(100%, calc(100% - 20px));
        }

        .sd-hero{
            border-radius: 24px;
            min-height: auto;
        }

        .sd-hero__content{
            min-height: auto;
            padding: 20px;
        }

        .sd-title{
            font-size: 30px;
        }

        .sd-description{
            font-size: 15px;
            line-height: 1.7;
        }

        .sd-avatar-card{
            width: 120px;
            border-radius: 22px;
        }

        .sd-section{
            padding: 20px;
        }

        .sd-section__title{
            font-size: 24px;
        }

        .sd-products__head{
            flex-direction: column;
            align-items: flex-start;
        }

        .sd-products__grid{
            grid-template-columns: 1fr;
        }

        .sd-product__name{
            min-height: auto;
        }

        .sd-sidebar-card{
            padding: 18px;
            border-radius: 22px;
        }
    }
</style>
@endsection

@section('content')
<section class="sd-page">
    <div class="sd-container">
        <div class="sd-hero">
            <div class="sd-hero__content">
                <div class="sd-hero__left">
                    <div class="sd-breadcrumb">
                        <a href="{{ url('/') }}">Trang chủ</a>
                        <span>/</span>
                        <a href="{{ url('/') }}">Bệnh theo mùa</a>
                        <span>/</span>
                        <span>{{ $seasonDisease->name }}</span>
                    </div>

                    <div class="sd-badge">Danh mục bệnh theo mùa</div>

                    <h1 class="sd-title">{{ $seasonDisease->name }}</h1>

                    <p class="sd-description">
                        {{ $seasonDisease->description ?: 'Đang cập nhật mô tả cho danh mục bệnh này.' }}
                    </p>

                    <div class="sd-hero__actions">
                        <button type="button" class="sd-btn sd-btn--primary" id="scrollToProducts">
                            Xem sản phẩm phù hợp
                        </button>

                        <a href="{{ url('/') }}" class="sd-btn sd-btn--ghost">
                            Quay về trang chủ
                        </a>
                    </div>
                </div>

                <div class="sd-hero__right">
                    <div class="sd-avatar-card">
                        <img src="{{ $seasonDisease->avatar_url }}" alt="{{ $seasonDisease->name }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="sd-layout">
            <div class="sd-main">
                <div class="sd-card">
                    <div class="sd-section">
                        <div class="sd-section__eyebrow">Thông tin chi tiết</div>
                        <h2 class="sd-section__title">Nội dung tư vấn về {{ $seasonDisease->name }}</h2>

                        <div class="sd-content">
                            @if(!empty($seasonDisease->content))
                                {!! $seasonDisease->content !!}
                            @else
                                <p>Đang cập nhật nội dung chi tiết cho danh mục bệnh này.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="sd-products" id="sdProducts">
                    <div class="sd-products__head">
                        <div>
                            <div class="sd-section__eyebrow">Sản phẩm theo bệnh</div>
                            <h2 class="sd-section__title" style="margin-bottom:0;">Danh sách sản phẩm gợi ý</h2>
                        </div>

                        <div class="sd-products__count">
                            {{ count($products) }} sản phẩm
                        </div>
                    </div>

                    @if(count($products) > 0)
                        <div class="sd-products__grid">
                            @foreach($products as $product)
                                <article class="sd-product">
                                    <a href="{{ $product['url'] }}" class="sd-product__image">
                                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                                    </a>

                                    <div class="sd-product__body">
                                        <h3 class="sd-product__name">
                                            <a href="{{ $product['url'] }}">
                                                {{ $product['name'] }}
                                            </a>
                                        </h3>

                                        <div class="sd-product__price">
                                            <div class="sd-product__sale">
                                                {{ number_format((float) $product['display_price'], 0, ',', '.') }}đ
                                                <span>/ {{ $product['unit_name'] }}</span>
                                            </div>

                                            @if(!empty($product['original_price']))
                                                <div class="sd-product__origin">
                                                    {{ number_format((float) $product['original_price'], 0, ',', '.') }}đ
                                                </div>
                                            @endif
                                        </div>

                                        <a href="{{ route('website.product-v1.show', $product['id']) }}" class="sd-product__btn">
                                            Chọn mua
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="sd-empty">
                            Chưa có sản phẩm cho danh mục bệnh này.
                        </div>
                    @endif
                </div>
            </div>

            <aside class="sd-sidebar">
                <div class="sd-sidebar-card">
                    <div class="sd-sidebar-card__label">Hình ảnh bệnh</div>
                    <h3 class="sd-sidebar-card__title">{{ $seasonDisease->name }}</h3>

                    <div class="sd-sidebar-banner">
                        <img src="{{ $seasonDisease->avatar_url }}" alt="{{ $seasonDisease->name }}">
                    </div>
                </div>

                <div class="sd-sidebar-card">
                    <div class="sd-sidebar-card__label">Banner danh mục</div>
                    <div class="sd-sidebar-banner">
                        <img src="{{ $seasonDisease->banner_url }}" alt="Banner {{ $seasonDisease->name }}">
                    </div>
                </div>

                <div class="sd-sidebar-card">
                    <div class="sd-sidebar-card__label">Tổng quan</div>
                    <h3 class="sd-sidebar-card__title">Thông tin nhanh</h3>

                    <div class="sd-sidebar-card__text">
                        {{ $seasonDisease->description ?: 'Đang cập nhật thông tin mô tả ngắn.' }}
                    </div>

                    <div class="sd-stats">
                        <div class="sd-stat">
                            <div class="sd-stat__value">{{ count($products) }}</div>
                            <div class="sd-stat__label">Sản phẩm gợi ý</div>
                        </div>

                        <div class="sd-stat">
                            <div class="sd-stat__value">01</div>
                            <div class="sd-stat__label">Danh mục hiện tại</div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scrollButton = document.getElementById('scrollToProducts');
        const productsSection = document.getElementById('sdProducts');

        if (scrollButton && productsSection) {
            scrollButton.addEventListener('click', function () {
                productsSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        }
    });
</script>
@endsection