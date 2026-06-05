@extends('website.layout.index')

@section('title', $seoTitle)
@section('meta_description', $seoDescription)
@section('meta_image', $seoImage)

@section('style')
<style>
    .wt-page{
        background: linear-gradient(180deg, #f7fbff 0%, #f5f9fd 100%);
        padding: 22px 0 42px;
    }

    .wt-container{
        width: min(1320px, calc(100% - 32px));
        margin: 0 auto;
    }

    .wt-breadcrumb{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
    }

    .wt-breadcrumb a{
        color: #475569;
        text-decoration: none;
    }

    .wt-breadcrumb a:hover{
        color: #0284c7;
    }

    .wt-hero{
        position: relative;
        overflow: hidden;
        border-radius: 34px;
        min-height: 380px;
        background:
            linear-gradient(100deg, rgba(8, 47, 73, .88) 0%, rgba(15, 23, 42, .62) 42%, rgba(15, 23, 42, .16) 100%),
            url('{{ $trademark->banner_url }}') center/cover no-repeat;
        box-shadow: 0 28px 60px rgba(15, 23, 42, .14);
    }

    .wt-hero__content{
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 220px;
        gap: 28px;
        align-items: end;
        min-height: 380px;
        padding: 34px;
    }

    .wt-badge{
        display: inline-flex;
        align-items: center;
        height: 38px;
        padding: 0 16px;
        border-radius: 999px;
        background: rgba(255,255,255,.14);
        backdrop-filter: blur(10px);
        color: #fff;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: .05em;
        margin-bottom: 14px;
    }

    .wt-title{
        margin: 0;
        font-size: 54px;
        line-height: 1.04;
        font-weight: 900;
        color: #fff;
        letter-spacing: -0.03em;
    }

    .wt-short-desc{
        margin: 16px 0 0;
        font-size: 18px;
        line-height: 1.8;
        color: rgba(255,255,255,.92);
        max-width: 780px;
    }

    .wt-meta{
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 24px;
    }

    .wt-meta__item{
        min-width: 150px;
        padding: 15px 18px;
        border-radius: 20px;
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.18);
        backdrop-filter: blur(10px);
    }

    .wt-meta__value{
        font-size: 24px;
        font-weight: 900;
        line-height: 1;
        color: #fff;
        margin-bottom: 8px;
    }

    .wt-meta__label{
        font-size: 13px;
        font-weight: 700;
        color: rgba(255,255,255,.82);
    }

    .wt-logo-card{
        background: rgba(255,255,255,.18);
        border: 1px solid rgba(255,255,255,.20);
        backdrop-filter: blur(14px);
        padding: 14px;
        border-radius: 28px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .12);
    }

    .wt-logo-card img{
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: contain;
        display: block;
        border-radius: 22px;
        background: #fff;
        padding: 16px;
    }

    .wt-layout{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 330px;
        gap: 22px;
        margin-top: 24px;
    }

    .wt-main{
        min-width: 0;
    }

    .wt-sidebar{
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .wt-card{
        background: #fff;
        border-radius: 28px;
        border: 1px solid #e8eff6;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .06);
        overflow: hidden;
    }

    .wt-section{
        padding: 28px;
    }

    .wt-section__eyebrow{
        font-size: 12px;
        font-weight: 900;
        color: #0284c7;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 8px;
    }

    .wt-section__title{
        margin: 0 0 18px;
        font-size: 30px;
        line-height: 1.18;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .wt-content{
        color: #334155;
        font-size: 16px;
        line-height: 1.9;
    }

    .wt-content p{
        margin: 0 0 14px;
    }

    .wt-content h1,
    .wt-content h2,
    .wt-content h3,
    .wt-content h4,
    .wt-content h5,
    .wt-content h6{
        color: #0f172a;
        margin: 0 0 12px;
        line-height: 1.35;
        font-weight: 800;
    }

    .wt-content img{
        max-width: 100%;
        height: auto;
        border-radius: 18px;
        display: block;
        margin: 18px 0;
    }

    .wt-content ul,
    .wt-content ol{
        margin: 0 0 16px;
        padding-left: 20px;
    }

    .wt-content table{
        width: 100%;
        border-collapse: collapse;
        margin: 18px 0;
        overflow: hidden;
        border-radius: 16px;
    }

    .wt-content table td,
    .wt-content table th{
        border: 1px solid #e5edf5;
        padding: 12px 14px;
        text-align: left;
    }

    .wt-filter-card{
        padding: 22px;
        margin-top: 20px;
    }

    .wt-filter-head{
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 18px;
    }

    .wt-filter-title{
        margin: 0;
        font-size: 28px;
        line-height: 1.2;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .wt-filter-desc{
        margin: 8px 0 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .wt-filter-count{
        flex: 0 0 auto;
        padding: 10px 16px;
        border-radius: 999px;
        background: linear-gradient(135deg, #eff8ff, #e5f3ff);
        color: #0284c7;
        font-size: 13px;
        font-weight: 800;
    }

    .wt-filter-form{
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) 200px 170px 170px 130px;
        gap: 14px;
        margin-bottom: 16px;
    }

    .wt-input,
    .wt-select{
        width: 100%;
        height: 50px;
        border-radius: 16px;
        border: 1px solid #d8e4ef;
        background: #fff;
        padding: 0 16px;
        font-size: 15px;
        color: #0f172a;
        outline: none;
        transition: all .2s ease;
    }

    .wt-input:focus,
    .wt-select:focus{
        border-color: #38bdf8;
        box-shadow: 0 0 0 4px rgba(56,189,248,.12);
    }

    .wt-toolbar{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .wt-toolbar__left{
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
    }

    .wt-toolbar__right{
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .wt-view-toggle{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px;
        border-radius: 999px;
        background: #f5f9fd;
        border: 1px solid #dce8f2;
    }

    .wt-view-btn{
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 999px;
        background: transparent;
        color: #334155;
        cursor: pointer;
        font-size: 14px;
        font-weight: 900;
        transition: all .2s ease;
    }

    .wt-view-btn.is-active{
        color: #fff;
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        box-shadow: 0 12px 22px rgba(37,99,235,.16);
    }

    .wt-btn{
        height: 50px;
        border: none;
        border-radius: 16px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        transition: all .25s ease;
    }

    .wt-btn--primary{
        color: #fff;
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        box-shadow: 0 16px 28px rgba(37, 99, 235, .18);
    }

    .wt-btn--primary:hover{
        transform: translateY(-2px);
    }

    .wt-btn--light{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 16px;
        text-decoration: none;
        background: #f8fbff;
        color: #334155;
        border: 1px solid #d9e5ef;
        box-shadow: none;
    }

    .wt-btn--light:hover{
        border-color: #38bdf8;
        color: #0284c7;
    }

    .wt-products-grid{
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .wt-products-grid.is-grid-3{
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .wt-products-grid.is-grid-4{
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }

    .wt-product{
        background: #fff;
        border-radius: 24px;
        border: 1px solid #e8eff6;
        overflow: hidden;
        box-shadow: 0 14px 32px rgba(15, 23, 42, .06);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .wt-product:hover{
        transform: translateY(-4px);
        box-shadow: 0 22px 42px rgba(15, 23, 42, .10);
    }

    .wt-product__image{
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        aspect-ratio: 1 / 1;
        padding: 20px;
        background: linear-gradient(180deg, #f9fcff 0%, #f2f8fc 100%);
        text-decoration: none;
    }

    .wt-product__image img{
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }

    .wt-product__sale-badge{
        position: absolute;
        top: 12px;
        left: 12px;
        height: 32px;
        padding: 0 12px;
        border-radius: 999px;
        background: linear-gradient(135deg, #f97316, #fb923c);
        color: #fff;
        font-size: 12px;
        font-weight: 900;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 20px rgba(249,115,22,.18);
    }

    .wt-product__body{
        padding: 18px;
    }

    .wt-product__name{
        margin: 0 0 10px;
        min-height: 74px;
        font-size: 16px;
        line-height: 1.6;
        font-weight: 800;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .wt-product__name a{
        color: #0f172a;
        text-decoration: none;
    }

    .wt-product__name a:hover{
        color: #0284c7;
    }

    .wt-product__desc{
        margin-bottom: 12px;
        min-height: 48px;
        font-size: 14px;
        line-height: 1.7;
        color: #64748b;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .wt-product__price{
        margin-bottom: 14px;
    }

    .wt-product__sale{
        font-size: 23px;
        line-height: 1.2;
        font-weight: 900;
        color: #06b6d4;
    }

    .wt-product__sale span{
        font-size: 13px;
        color: #64748b;
        font-weight: 800;
    }

    .wt-product__origin{
        margin-top: 6px;
        font-size: 14px;
        font-weight: 700;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .wt-product__actions{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .wt-product__btn{
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

    .wt-product__btn--ghost{
        background: #f8fbff;
        color: #0f172a;
        border: 1px solid #d9e5ef;
        box-shadow: none;
    }

    .wt-product__btn--ghost:hover{
        color: #0284c7;
        border-color: #38bdf8;
    }

    .wt-empty{
        min-height: 260px;
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

    .wt-sidebar-card{
        padding: 22px;
    }

    .wt-sidebar-label{
        font-size: 12px;
        font-weight: 900;
        color: #0284c7;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 8px;
    }

    .wt-sidebar-title{
        margin: 0 0 14px;
        font-size: 24px;
        line-height: 1.2;
        font-weight: 900;
        color: #0f172a;
    }

    .wt-sidebar-text{
        color: #475569;
        font-size: 15px;
        line-height: 1.85;
    }

    .wt-sidebar-banner{
        width: 100%;
        border-radius: 22px;
        overflow: hidden;
        background: #f8fbff;
        margin-top: 14px;
    }

    .wt-sidebar-banner img{
        width: 100%;
        display: block;
        object-fit: cover;
    }

    .wt-category-list{
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .wt-category-chip{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 40px;
        padding: 0 14px;
        border-radius: 999px;
        background: #f8fbff;
        color: #0f172a;
        border: 1px solid #d9e5ef;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
    }

    .wt-category-chip:hover{
        color: #0284c7;
        border-color: #38bdf8;
    }

    .wt-category-chip span{
        color: #64748b;
        font-size: 12px;
        font-weight: 800;
    }

    .wt-related-list{
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .wt-related-item{
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

    .wt-related-item:hover{
        background: #f8fbff;
        border-color: #e4eef7;
        transform: translateX(3px);
    }

    .wt-related-item img{
        width: 52px;
        height: 52px;
        object-fit: cover;
        border-radius: 14px;
        background: #f4f8fb;
        flex: 0 0 auto;
    }

    .wt-related-item-name{
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.5;
    }

    .wt-related-item-desc{
        margin-top: 4px;
        font-size: 12px;
        color: #64748b;
        line-height: 1.5;
    }

    .wt-pagination{
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    .wt-pagination__item{
        min-width: 42px;
        height: 42px;
        padding: 0 12px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: 1px solid #d9e5ef;
        background: #fff;
        color: #0f172a;
        font-size: 14px;
        font-weight: 800;
    }

    .wt-pagination__item:hover{
        border-color: #38bdf8;
        color: #0284c7;
    }

    .wt-pagination__item.is-active{
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 12px 22px rgba(37,99,235,.16);
    }

    .wt-pagination__item.is-disabled{
        opacity: .45;
        pointer-events: none;
    }

    .wt-toast{
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

    .wt-toast.show{
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .wt-toast.success{
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .wt-toast.error{
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    @media (max-width: 1280px){
        .wt-products-grid,
        .wt-products-grid.is-grid-4{
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .wt-products-grid.is-grid-3{
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .wt-filter-form{
            grid-template-columns: minmax(0, 1fr) 1fr 1fr;
        }

        .wt-filter-form .wt-btn{
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 991px){
        .wt-container{
            width: min(100%, calc(100% - 24px));
        }

        .wt-hero__content{
            grid-template-columns: 1fr;
            min-height: auto;
            padding: 22px;
        }

        .wt-layout{
            grid-template-columns: 1fr;
        }

        .wt-products-grid,
        .wt-products-grid.is-grid-3,
        .wt-products-grid.is-grid-4{
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .wt-filter-form{
            grid-template-columns: 1fr 1fr;
        }

        .wt-filter-form .wt-btn{
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 767px){
        .wt-page{
            padding: 18px 0 28px;
        }

        .wt-hero{
            min-height: auto;
            border-radius: 24px;
        }

        .wt-title{
            font-size: 30px;
        }

        .wt-short-desc{
            font-size: 15px;
            line-height: 1.75;
        }

        .wt-logo-card{
            width: 130px;
        }

        .wt-filter-head{
            flex-direction: column;
            align-items: flex-start;
        }

        .wt-filter-title{
            font-size: 24px;
        }

        .wt-filter-form{
            grid-template-columns: 1fr;
        }

        .wt-toolbar{
            flex-direction: column;
            align-items: flex-start;
        }

        .wt-products-grid,
        .wt-products-grid.is-grid-3,
        .wt-products-grid.is-grid-4{
            grid-template-columns: 1fr;
        }

        .wt-product__name{
            min-height: auto;
        }

        .wt-product__actions{
            grid-template-columns: 1fr;
        }

        .wt-toast{
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
<section class="wt-page">
    <div class="wt-container">
        <div class="wt-breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <span>/</span>
            <a href="{{ url('/') }}">Thương hiệu yêu thích</a>
            <span>/</span>
            <span>{{ $trademark->name }}</span>
        </div>

        <div class="wt-hero">
            <div class="wt-hero__content">
                <div class="wt-hero__left">
                    <div class="wt-badge">Thương hiệu nổi bật</div>
                    <h1 class="wt-title">{{ $trademark->name }}</h1>

                    <p class="wt-short-desc">
                        {{ $trademark->short_desc ?: ($trademark->description ?: 'Khám phá thương hiệu cùng danh sách sản phẩm nổi bật đang được phân phối tại Nhà thuốc Phương Anh.') }}
                    </p>

                    <div class="wt-meta">
                        <div class="wt-meta__item">
                            <div class="wt-meta__value">{{ number_format($totalProducts, 0, ',', '.') }}</div>
                            <div class="wt-meta__label">Sản phẩm thuộc thương hiệu</div>
                        </div>

                        <div class="wt-meta__item">
                            <div class="wt-meta__value">{{ number_format($topCategoriesInBrand->count(), 0, ',', '.') }}</div>
                            <div class="wt-meta__label">Danh mục liên quan</div>
                        </div>
                    </div>
                </div>

                <div class="wt-hero__right">
                    <div class="wt-logo-card">
                        <img src="{{ $trademark->logo_url }}" alt="{{ $trademark->name }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="wt-layout">
            <div class="wt-main">
                <div class="wt-card">
                    <div class="wt-section">
                        <div class="wt-section__eyebrow">Giới thiệu thương hiệu</div>
                        <h2 class="wt-section__title">{{ $trademark->name }}</h2>

                        <div class="wt-content">
                            @if(!empty($trademark->note))
                                {!! $trademark->note !!}
                            @elseif(!empty($trademark->description))
                                <p>{{ $trademark->description }}</p>
                            @else
                                <p>Đang cập nhật thông tin giới thiệu chi tiết cho thương hiệu này.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="wt-card wt-filter-card">
                    <div class="wt-filter-head">
                        <div>
                            <h2 class="wt-filter-title">Sản phẩm thuộc thương hiệu</h2>
                            <div class="wt-filter-desc">
                                Tìm kiếm nhanh, lọc khoảng giá, sắp xếp linh hoạt và chọn cách hiển thị phù hợp.
                            </div>
                        </div>

                        <div class="wt-filter-count">
                            {{ number_format($products->total(), 0, ',', '.') }} sản phẩm
                        </div>
                    </div>

                    <form method="GET" action="{{ route('website.trademark.show', $trademark->id) }}" class="wt-filter-form">
                        <input
                            type="text"
                            name="q"
                            class="wt-input"
                            placeholder="Tìm theo tên sản phẩm hoặc mã sản phẩm..."
                            value="{{ $search }}"
                        >

                        <input
                            type="number"
                            name="min_price"
                            class="wt-input"
                            placeholder="Giá từ"
                            value="{{ $minPrice }}"
                            min="0"
                        >

                        <input
                            type="number"
                            name="max_price"
                            class="wt-input"
                            placeholder="Giá đến"
                            value="{{ $maxPrice }}"
                            min="0"
                        >

                        <select name="sort" class="wt-select" id="trademarkSort">
                            <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                            <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                            <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                            <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                        </select>

                        <button type="submit" class="wt-btn wt-btn--primary">Lọc sản phẩm</button>
                    </form>

                    <div class="wt-toolbar">
                        <div class="wt-toolbar__left">
                            Hiển thị các sản phẩm phù hợp theo bộ lọc hiện tại.
                        </div>

                        <div class="wt-toolbar__right">
                            <a href="{{ route('website.trademark.show', $trademark->id) }}" class="wt-btn wt-btn--light">
                                Xóa lọc
                            </a>

                            <div class="wt-view-toggle">
                                <button type="button" class="wt-view-btn {{ $viewMode === '3' ? 'is-active' : '' }}" data-view-mode="3">3</button>
                                <button type="button" class="wt-view-btn {{ $viewMode !== '3' ? 'is-active' : '' }}" data-view-mode="4">4</button>
                            </div>
                        </div>
                    </div>
                </div>

                @if($products->count() > 0)
                    <div class="wt-products-grid {{ $viewMode === '3' ? 'is-grid-3' : 'is-grid-4' }}" id="wtProductsGrid">
                        @foreach($products as $product)
                            @php
                                $discountPercent = null;
                                if (!empty($product->original_price) && $product->original_price > $product->display_price && $product->original_price > 0) {
                                    $discountPercent = round((($product->original_price - $product->display_price) / $product->original_price) * 100);
                                }
                            @endphp

                            <article class="wt-product">
                                <a href="{{ $product->url }}" class="wt-product__image">
                                    @if(!empty($discountPercent))
                                        <span class="wt-product__sale-badge">-{{ $discountPercent }}%</span>
                                    @endif

                                    <img src="{{ $product->image_url }}" alt="{{ $product->display_name }}">
                                </a>

                                <div class="wt-product__body">
                                    <h3 class="wt-product__name">
                                        <a href="{{ $product->url }}">
                                            {{ $product->display_name }}
                                        </a>
                                    </h3>

                                    <div class="wt-product__desc">
                                        {{ $product->short_description ?: 'Đang cập nhật thông tin mô tả cho sản phẩm này.' }}
                                    </div>

                                    <div class="wt-product__price">
                                        <div class="wt-product__sale">
                                            {{ number_format((float) $product->display_price, 0, ',', '.') }}đ
                                            <span>/ sản phẩm</span>
                                        </div>

                                        @if(!empty($product->original_price))
                                            <div class="wt-product__origin">
                                                {{ number_format((float) $product->original_price, 0, ',', '.') }}đ
                                            </div>
                                        @endif
                                    </div>

                                    <div class="wt-product__actions">
                                        <button
                                            style=" font-size: 12px; "
                                            type="button"
                                            class="wt-product__btn js-add-to-cart"
                                            data-product-id="{{ $product->id }}"
                                        >
                                            Thêm vào giỏ
                                        </button>

                                        <a style=" font-size: 12px; "
                                            href="{{ route('website.product-v1.show', $product->id) }}" class="wt-product__btn wt-product__btn--ghost">
                                            Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if($products->lastPage() > 1)
                        @php
                            $currentPage = $products->currentPage();
                            $lastPage = $products->lastPage();
                            $start = max(1, $currentPage - 2);
                            $end = min($lastPage, $currentPage + 2);
                        @endphp

                        <div class="wt-pagination">
                            <a href="{{ $products->previousPageUrl() ?: 'javascript:void(0)' }}"
                               class="wt-pagination__item {{ $products->onFirstPage() ? 'is-disabled' : '' }}">
                                ‹
                            </a>

                            @if($start > 1)
                                <a href="{{ $products->url(1) }}" class="wt-pagination__item">1</a>
                                @if($start > 2)
                                    <span class="wt-pagination__item is-disabled">...</span>
                                @endif
                            @endif

                            @for($page = $start; $page <= $end; $page++)
                                <a href="{{ $products->url($page) }}"
                                   class="wt-pagination__item {{ $page === $currentPage ? 'is-active' : '' }}">
                                    {{ $page }}
                                </a>
                            @endfor

                            @if($end < $lastPage)
                                @if($end < $lastPage - 1)
                                    <span class="wt-pagination__item is-disabled">...</span>
                                @endif
                                <a href="{{ $products->url($lastPage) }}" class="wt-pagination__item">{{ $lastPage }}</a>
                            @endif

                            <a href="{{ $products->nextPageUrl() ?: 'javascript:void(0)' }}"
                               class="wt-pagination__item {{ $products->hasMorePages() ? '' : 'is-disabled' }}">
                                ›
                            </a>
                        </div>
                    @endif
                @else
                    <div class="wt-empty">
                        Không tìm thấy sản phẩm nào thuộc thương hiệu này.
                    </div>
                @endif
            </div>

            <aside class="wt-sidebar">
                <div class="wt-card wt-sidebar-card">
                    <div class="wt-sidebar-label">Hình ảnh thương hiệu</div>
                    <h3 class="wt-sidebar-title">{{ $trademark->name }}</h3>

                    <div class="wt-sidebar-banner">
                        <img src="{{ $trademark->featured_image_url }}" alt="{{ $trademark->name }}">
                    </div>
                </div>

                <div class="wt-card wt-sidebar-card">
                    <div class="wt-sidebar-label">Danh mục trong thương hiệu</div>
                    <h3 class="wt-sidebar-title">Khám phá theo nhóm</h3>

                    @if($topCategoriesInBrand->count() > 0)
                        <div class="wt-category-list">
                            @foreach($topCategoriesInBrand as $item)
                                <a href="{{ $item['url'] }}" class="wt-category-chip">
                                    {{ $item['name'] }}
                                    <span>{{ $item['total_products'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="wt-sidebar-text">
                            Chưa có danh mục liên quan để hiển thị.
                        </div>
                    @endif
                </div>

                <div class="wt-card wt-sidebar-card">
                    <div class="wt-sidebar-label">Thương hiệu liên quan</div>
                    <h3 class="wt-sidebar-title">Bạn có thể thích</h3>

                    @if($relatedTrademarks->count() > 0)
                        <div class="wt-related-list">
                            @foreach($relatedTrademarks as $item)
                                <a href="{{ $item['url'] }}" class="wt-related-item">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">

                                    <div>
                                        <div class="wt-related-item-name">{{ $item['name'] }}</div>
                                        <div class="wt-related-item-desc">
                                            {{ $item['short_desc'] ?: 'Thương hiệu nổi bật' }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="wt-sidebar-text">
                            Chưa có thương hiệu liên quan để hiển thị.
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </div>
</section>

<div class="wt-toast" id="wtToast"></div>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": @json($seoTitle),
    "description": @json($seoDescription),
    "url": @json($canonicalUrl),
    "image": @json($seoImage),
    "mainEntity": {
        "@type": "Brand",
        "name": @json($trademark->name)
    }
}
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const trademarkSort = document.getElementById('trademarkSort');
        const grid = document.getElementById('wtProductsGrid');
        const viewButtons = document.querySelectorAll('.wt-view-btn');
        const toast = document.getElementById('wtToast');

        function showToast(message, type = 'success') {
            if (!toast) return;
            toast.textContent = message || '';
            toast.className = 'wt-toast ' + type + ' show';

            clearTimeout(window.__wtToastTimer);
            window.__wtToastTimer = setTimeout(() => {
                toast.classList.remove('show');
            }, 2600);
        }

        if (trademarkSort) {
            trademarkSort.addEventListener('change', function () {
                this.form.submit();
            });
        }

        viewButtons.forEach(button => {
            button.addEventListener('click', function () {
                const mode = this.getAttribute('data-view-mode');

                viewButtons.forEach(btn => btn.classList.remove('is-active'));
                this.classList.add('is-active');

                if (grid) {
                    grid.classList.remove('is-grid-3', 'is-grid-4');
                    grid.classList.add(mode === '3' ? 'is-grid-3' : 'is-grid-4');
                }

                const url = new URL(window.location.href);
                url.searchParams.set('view', mode);
                window.history.replaceState({}, '', url.toString());
                localStorage.setItem('wt_trademark_view_mode', mode);
            });
        });

        const savedViewMode = localStorage.getItem('wt_trademark_view_mode');
        if (savedViewMode && !new URL(window.location.href).searchParams.get('view')) {
            const matchedBtn = document.querySelector('.wt-view-btn[data-view-mode="' + savedViewMode + '"]');
            if (matchedBtn) {
                matchedBtn.click();
            }
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