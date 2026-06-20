@extends('website.layout.index')

@section('title', $seoTitle)
@section('meta_description', $seoDescription)

@section('style')
<style>
    .ws-page{
        background: linear-gradient(180deg, #f7fbff 0%, #f4f9fd 100%);
        padding: 22px 0 42px;
    }

    .ws-container{
        width: min(1320px, calc(100% - 32px));
        margin: 0 auto;
    }

    .ws-breadcrumb{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
    }

    .ws-breadcrumb a{
        color: #475569;
        text-decoration: none;
    }

    .ws-breadcrumb a:hover{
        color: #0284c7;
    }

    .ws-hero{
        background: linear-gradient(135deg, #dbf2ff 0%, #cfeeff 45%, #dff6ff 100%);
        border-radius: 32px;
        padding: 28px;
        box-shadow: 0 26px 60px rgba(15, 23, 42, .08);
        overflow: hidden;
        position: relative;
    }

    .ws-hero::before{
        content: '';
        position: absolute;
        right: -80px;
        bottom: -80px;
        width: 260px;
        height: 260px;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(59,130,246,.18) 0%, rgba(59,130,246,0) 70%);
        pointer-events: none;
    }

    .ws-hero__badge{
        display: inline-flex;
        align-items: center;
        height: 36px;
        padding: 0 16px;
        border-radius: 999px;
        background: rgba(255,255,255,.72);
        color: #0284c7;
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 14px;
    }

    .ws-hero__title{
        margin: 0;
        font-size: 44px;
        line-height: 1.08;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.03em;
    }

    .ws-hero__desc{
        margin: 14px 0 0;
        color: #475569;
        font-size: 17px;
        line-height: 1.8;
        max-width: 820px;
    }

    .ws-search-form{
        margin-top: 22px;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 220px 150px;
        gap: 14px;
    }

    .ws-input,
    .ws-select{
        width: 100%;
        height: 52px;
        border-radius: 16px;
        border: 1px solid #d8e4ef;
        background: #fff;
        padding: 0 16px;
        font-size: 15px;
        color: #0f172a;
        outline: none;
        transition: all .2s ease;
    }

    .ws-input:focus,
    .ws-select:focus{
        border-color: #38bdf8;
        box-shadow: 0 0 0 4px rgba(56,189,248,.12);
    }

    .ws-btn{
        height: 52px;
        border: none;
        border-radius: 16px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        transition: all .25s ease;
    }

    .ws-btn--primary{
        color: #fff;
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        box-shadow: 0 16px 28px rgba(37, 99, 235, .18);
    }

    .ws-btn--primary:hover{
        transform: translateY(-2px);
    }

    .ws-section{
        margin-top: 24px;
    }

    .ws-section__head{
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 16px;
    }

    .ws-section__eyebrow{
        font-size: 12px;
        font-weight: 900;
        color: #0284c7;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 8px;
    }

    .ws-section__title{
        margin: 0;
        font-size: 30px;
        line-height: 1.18;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .ws-count{
        flex: 0 0 auto;
        padding: 10px 16px;
        border-radius: 999px;
        background: linear-gradient(135deg, #eff8ff, #e5f3ff);
        color: #0284c7;
        font-size: 13px;
        font-weight: 800;
    }

    .ws-smart-grid{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .ws-card{
        background: #fff;
        border-radius: 26px;
        border: 1px solid #e8eff6;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .06);
        overflow: hidden;
    }

    .ws-card__body{
        padding: 22px;
    }

    .ws-pills{
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .ws-pill{
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        border-radius: 18px;
        text-decoration: none;
        color: inherit;
        border: 1px solid #e3edf6;
        background: #f9fcff;
        transition: all .22s ease;
        min-width: 0;
    }

    .ws-pill:hover{
        border-color: #38bdf8;
        background: #fff;
        transform: translateY(-2px);
    }

    .ws-pill img{
        width: 46px;
        height: 46px;
        border-radius: 14px;
        object-fit: cover;
        background: #fff;
        flex: 0 0 auto;
    }

    .ws-pill__content{
        min-width: 0;
    }

    .ws-pill__name{
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.4;
    }

    .ws-pill__meta{
        margin-top: 4px;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
    }

    .ws-products-grid{
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .ws-product{
        background: #fff;
        border-radius: 24px;
        border: 1px solid #e8eff6;
        overflow: hidden;
        box-shadow: 0 14px 32px rgba(15, 23, 42, .06);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .ws-product:hover{
        transform: translateY(-4px);
        box-shadow: 0 22px 42px rgba(15, 23, 42, .10);
    }

    .ws-product__image{
        display: flex;
        align-items: center;
        justify-content: center;
        aspect-ratio: 1 / 1;
        padding: 20px;
        background: linear-gradient(180deg, #f9fcff 0%, #f2f8fc 100%);
        text-decoration: none;
    }

    .ws-product__image img{
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }

    .ws-product__body{
        padding: 18px;
    }

    .ws-product__tags{
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 10px;
    }

    .ws-product__tag{
        display: inline-flex;
        align-items: center;
        min-height: 28px;
        padding: 0 10px;
        border-radius: 999px;
        background: #f0f8ff;
        color: #0284c7;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
    }

    .ws-product__name{
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

    .ws-product__name a{
        color: #0f172a;
        text-decoration: none;
    }

    .ws-product__desc{
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

    .ws-product__price{
        margin-bottom: 14px;
    }

    .ws-product__sale{
        font-size: 23px;
        line-height: 1.2;
        font-weight: 900;
        color: #06b6d4;
    }

    .ws-product__origin{
        margin-top: 6px;
        font-size: 14px;
        font-weight: 700;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .ws-product__actions{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .ws-product__btn{
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

    .ws-product__btn--ghost{
        background: #f8fbff;
        color: #0f172a;
        border: 1px solid #d9e5ef;
        box-shadow: none;
    }

    .ws-product__btn--ghost:hover{
        color: #0284c7;
        border-color: #38bdf8;
    }

    .ws-empty{
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

    .ws-pagination{
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    .ws-pagination__item{
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

    .ws-pagination__item:hover{
        border-color: #38bdf8;
        color: #0284c7;
    }

    .ws-pagination__item.is-active{
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 12px 22px rgba(37,99,235,.16);
    }

    .ws-pagination__item.is-disabled{
        opacity: .45;
        pointer-events: none;
    }

    .ws-toast{
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

    .ws-toast.show{
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .ws-toast.success{
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .ws-toast.error{
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    @media (max-width: 1200px){
        .ws-products-grid{
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991px){
        .ws-container{
            width: min(100%, calc(100% - 24px));
        }

        .ws-search-form{
            grid-template-columns: 1fr 1fr;
        }

        .ws-search-form .ws-btn{
            grid-column: 1 / -1;
        }

        .ws-smart-grid{
            grid-template-columns: 1fr;
        }

        .ws-products-grid{
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px){
        .ws-page{
            padding: 18px 0 28px;
        }

        .ws-hero{
            padding: 20px;
            border-radius: 24px;
        }

        .ws-hero__title{
            font-size: 30px;
        }

        .ws-hero__desc{
            font-size: 15px;
            line-height: 1.75;
        }

        .ws-search-form{
            grid-template-columns: 1fr;
        }

        .ws-section__head{
            flex-direction: column;
            align-items: flex-start;
        }

        .ws-section__title{
            font-size: 24px;
        }

        .ws-products-grid{
            grid-template-columns: 1fr;
        }

        .ws-product__name{
            min-height: auto;
        }

        .ws-product__actions{
            grid-template-columns: 1fr;
        }

        .ws-toast{
            left: 12px;
            right: 12px;
            top: 12px;
            min-width: 0;
            max-width: none;
        }
    }

    .ws-page{
        --pa-search-ink: #0b2430;
        --pa-search-deep: #073f45;
        --pa-search-teal: #0f8b7c;
        --pa-search-teal-2: #0a6466;
        --pa-search-mint: #e8f7f1;
        --pa-search-soft: #f4faf8;
        --pa-search-line: rgba(9, 47, 48, .12);
        --pa-search-shadow: 0 20px 50px rgba(9, 47, 48, .10);
        background:
            radial-gradient(circle at 12% 0%, rgba(15, 139, 124, .08), transparent 28%),
            linear-gradient(180deg, #f4faf8 0%, #ffffff 44%, #f4faf8 100%) !important;
        overflow-x: hidden;
    }

    .ws-page,
    .ws-page *{
        box-sizing: border-box;
    }

    .ws-breadcrumb a,
    .ws-section__eyebrow,
    .ws-count,
    .ws-product__sale,
    .ws-product__btn--ghost:hover,
    .ws-pagination__item:hover{
        color: var(--pa-search-teal) !important;
    }

    .ws-breadcrumb a{
        font-weight: 800;
    }

    .ws-breadcrumb a:hover{
        color: var(--pa-search-deep) !important;
    }

    .ws-hero{
        background:
            radial-gradient(circle at 88% 0%, rgba(255,255,255,.16), transparent 34%),
            linear-gradient(135deg, var(--pa-search-deep) 0%, var(--pa-search-teal-2) 58%, var(--pa-search-teal) 100%) !important;
        border: 1px solid rgba(255,255,255,.16);
        box-shadow: var(--pa-search-shadow) !important;
        color: #ffffff;
    }

    .ws-hero::before{
        background: radial-gradient(circle, rgba(255,255,255,.16) 0%, rgba(255,255,255,0) 70%) !important;
    }

    .ws-hero__badge{
        background: rgba(255,255,255,.14) !important;
        border: 1px solid rgba(255,255,255,.18);
        color: #ffffff !important;
    }

    .ws-hero__title{
        color: #ffffff !important;
        letter-spacing: 0 !important;
    }

    .ws-hero__desc{
        color: rgba(255,255,255,.88) !important;
    }

    .ws-input,
    .ws-select{
        border-color: var(--pa-search-line) !important;
        color: var(--pa-search-ink) !important;
    }

    .ws-input:focus,
    .ws-select:focus{
        border-color: rgba(15, 139, 124, .42) !important;
        box-shadow: 0 0 0 4px rgba(15, 139, 124, .12) !important;
    }

    .ws-btn--primary,
    .ws-product__btn,
    .ws-pagination__item.is-active{
        background: linear-gradient(135deg, var(--pa-search-teal), var(--pa-search-deep)) !important;
        box-shadow: 0 16px 28px rgba(9, 47, 48, .16) !important;
    }

    .ws-section__title,
    .ws-pill__name,
    .ws-product__name a,
    .ws-product__btn--ghost,
    .ws-pagination__item{
        color: var(--pa-search-ink) !important;
    }

    .ws-count,
    .ws-product__tag{
        background: var(--pa-search-mint) !important;
        color: var(--pa-search-deep) !important;
    }

    .ws-card,
    .ws-pill,
    .ws-product,
    .ws-product__btn--ghost,
    .ws-pagination__item{
        border-color: var(--pa-search-line) !important;
    }

    .ws-card,
    .ws-product{
        box-shadow: 0 14px 34px rgba(9, 47, 48, .07) !important;
    }

    .ws-pill{
        background: #f8fcfa !important;
    }

    .ws-pill:hover,
    .ws-product__btn--ghost:hover,
    .ws-pagination__item:hover{
        border-color: rgba(15, 139, 124, .38) !important;
    }

    .ws-product:hover{
        box-shadow: 0 22px 42px rgba(9, 47, 48, .11) !important;
    }

    .ws-product__image{
        background:
            radial-gradient(circle at 50% 45%, #ffffff 0%, #f5fbfb 58%, #edf7f4 100%) !important;
    }

    .ws-product__btn--ghost{
        background: #f8fcfa !important;
        box-shadow: none !important;
    }

    .ws-empty{
        border-color: rgba(9, 47, 48, .18) !important;
    }

    @media (max-width: 767px){
        .ws-container{
            width: min(calc(100vw - 24px), 366px) !important;
            max-width: min(calc(100vw - 24px), 366px) !important;
            margin-left: 12px !important;
            margin-right: 12px !important;
            overflow: hidden;
        }

        .ws-hero{
            padding: 18px !important;
            border-radius: 22px !important;
        }

        .ws-hero__badge{
            height: 32px;
            padding: 0 12px;
            font-size: 12px;
        }

        .ws-hero__title{
            font-size: 26px !important;
            line-height: 1.16 !important;
        }

        .ws-hero__desc{
            font-size: 14px !important;
            line-height: 1.65 !important;
        }

        .ws-search-form{
            gap: 10px !important;
        }

        .ws-input,
        .ws-select,
        .ws-btn{
            height: 44px !important;
            border-radius: 14px !important;
            font-size: 13px !important;
        }

        .ws-section{
            margin-top: 18px !important;
        }

        .ws-section__head{
            gap: 10px !important;
            margin-bottom: 12px !important;
        }

        .ws-section__title{
            font-size: 21px !important;
            line-height: 1.25 !important;
        }

        .ws-count{
            padding: 8px 12px !important;
            font-size: 12px !important;
        }

        .ws-products-grid{
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 10px !important;
        }

        .ws-product{
            border-radius: 16px !important;
            min-width: 0;
        }

        .ws-product__image{
            aspect-ratio: auto !important;
            height: 102px !important;
            padding: 8px !important;
        }

        .ws-product__body{
            padding: 9px !important;
        }

        .ws-product__tags{
            margin-bottom: 6px !important;
            gap: 4px !important;
        }

        .ws-product__tag{
            min-height: 22px !important;
            max-width: 100%;
            padding: 0 7px !important;
            font-size: 10px !important;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ws-product__tags .ws-product__tag:nth-child(n+2){
            display: none !important;
        }

        .ws-product__name{
            min-height: 40px !important;
            margin-bottom: 6px !important;
            font-size: 12px !important;
            line-height: 1.35 !important;
            -webkit-line-clamp: 2 !important;
        }

        .ws-product__desc{
            display: none !important;
        }

        .ws-product__price{
            margin-bottom: 8px !important;
        }

        .ws-product__sale{
            font-size: 14px !important;
            line-height: 1.2 !important;
        }

        .ws-product__origin{
            margin-top: 3px !important;
            font-size: 10px !important;
        }

        .ws-product__actions{
            grid-template-columns: 1fr !important;
            gap: 6px !important;
        }

        .ws-product__btn{
            height: 30px !important;
            min-height: 30px !important;
            border-radius: 999px !important;
            font-size: 10.5px !important;
            padding: 0 6px !important;
            box-shadow: none !important;
        }

        .ws-product__btn--ghost{
            display: none !important;
        }

        .ws-smart-grid{
            gap: 12px !important;
        }

        .ws-card{
            border-radius: 18px !important;
        }

        .ws-card__body{
            padding: 14px !important;
        }

        .ws-pills{
            gap: 8px !important;
        }

        .ws-pill{
            width: 100%;
            padding: 8px 10px !important;
            border-radius: 14px !important;
        }

        .ws-pill img{
            width: 38px !important;
            height: 38px !important;
            border-radius: 12px !important;
        }
    }
</style>
@endsection

@section('content')
<section class="ws-page">
    <div class="ws-container">
        <div class="ws-breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <span>/</span>
            <span>Tìm kiếm</span>
        </div>

        <div class="ws-hero">
            <div class="ws-hero__badge">Tìm kiếm sản phẩm thông minh</div>

            <h1 class="ws-hero__title">
                @if($hasQuery)
                    Kết quả cho: "{{ $query }}"
                @else
                    Tìm kiếm sản phẩm, danh mục, thương hiệu
                @endif
            </h1>

            <p class="ws-hero__desc">
                @if($hasQuery)
                    Hệ thống ưu tiên hiển thị các sản phẩm có tên liên quan nhất, đồng thời gợi ý thêm danh mục và thương hiệu phù hợp với từ khóa bạn đang tìm.
                @else
                    Nhập từ khóa để tìm sản phẩm, thương hiệu hoặc danh mục phù hợp với nhu cầu của bạn.
                @endif
            </p>

            <form method="GET" action="{{ route('website.search.index') }}" class="ws-search-form">
                <input
                    type="text"
                    name="q"
                    class="ws-input"
                    placeholder="Nhập tên sản phẩm, thương hiệu, danh mục..."
                    value="{{ $query }}"
                >

                <select name="sort" class="ws-select" id="wsSort">
                    <option value="relevance" {{ $sort === 'relevance' ? 'selected' : '' }}>Liên quan nhất</option>
                    <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                    <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                </select>

                <button type="submit" class="ws-btn ws-btn--primary">
                    Tìm kiếm
                </button>
            </form>
        </div>

        @if($hasQuery)
            @if($matchedCategories->count() > 0 || $matchedTrademarks->count() > 0)
                <div class="ws-section">
                    <div class="ws-section__head">
                        <div>
                            <div class="ws-section__eyebrow">Gợi ý thông minh</div>
                            <h2 class="ws-section__title">Bạn có thể đang tìm</h2>
                        </div>
                    </div>

                    <div class="ws-smart-grid">
                        <div class="ws-card">
                            <div class="ws-card__body">
                                <div class="ws-section__eyebrow">Danh mục phù hợp</div>
                                <h3 class="ws-section__title" style="font-size:24px; margin-bottom:16px;">Danh mục liên quan</h3>

                                @if($matchedCategories->count() > 0)
                                    <div class="ws-pills">
                                        @foreach($matchedCategories as $category)
                                            <a href="{{ $category['url'] }}" class="ws-pill">
                                                <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}">
                                                <div class="ws-pill__content">
                                                    <div class="ws-pill__name">{{ $category['name'] }}</div>
                                                    <div class="ws-pill__meta">{{ $category['product_count'] }} sản phẩm</div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="ws-empty">Không tìm thấy danh mục phù hợp.</div>
                                @endif
                            </div>
                        </div>

                        <div class="ws-card">
                            <div class="ws-card__body">
                                <div class="ws-section__eyebrow">Thương hiệu phù hợp</div>
                                <h3 class="ws-section__title" style="font-size:24px; margin-bottom:16px;">Thương hiệu liên quan</h3>

                                @if($matchedTrademarks->count() > 0)
                                    <div class="ws-pills">
                                        @foreach($matchedTrademarks as $trademark)
                                            <a href="{{ $trademark['url'] }}" class="ws-pill">
                                                <img src="{{ $trademark['image'] }}" alt="{{ $trademark['name'] }}">
                                                <div class="ws-pill__content">
                                                    <div class="ws-pill__name">{{ $trademark['name'] }}</div>
                                                    <div class="ws-pill__meta">{{ $trademark['product_count'] }} sản phẩm</div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="ws-empty">Không tìm thấy thương hiệu phù hợp.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="ws-section">
                <div class="ws-section__head">
                    <div>
                        <div class="ws-section__eyebrow">Kết quả sản phẩm</div>
                        <h2 class="ws-section__title">Sản phẩm liên quan nhất</h2>
                    </div>

                    <div class="ws-count">
                        {{ number_format($products->total(), 0, ',', '.') }} sản phẩm
                    </div>
                </div>

                @if($products->count() > 0)
                    <div class="ws-products-grid">
                        @foreach($products as $product)
                            <article class="ws-product">
                                <a href="{{ $product->url }}" class="ws-product__image">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->display_name }}">
                                </a>

                                <div class="ws-product__body">
                                    <div class="ws-product__tags">
                                        @if(!empty($product->category_name))
                                            <a href="{{ $product->category_url }}" class="ws-product__tag">
                                                {{ $product->category_name }}
                                            </a>
                                        @endif

                                        @if(!empty($product->trademark_name))
                                            <a href="{{ $product->trademark_url }}" class="ws-product__tag">
                                                {{ $product->trademark_name }}
                                            </a>
                                        @endif
                                    </div>

                                    <h3 class="ws-product__name">
                                        <a href="{{ $product->url }}">
                                            {{ $product->display_name }}
                                        </a>
                                    </h3>

                                    <div class="ws-product__desc">
                                        {{ $product->short_description ?: 'Đang cập nhật thông tin mô tả cho sản phẩm này.' }}
                                    </div>

                                    <div class="ws-product__price">
                                        <div class="ws-product__sale">
                                            {{ number_format((float) $product->display_price, 0, ',', '.') }}đ
                                        </div>

                                        @if(!empty($product->original_price))
                                            <div class="ws-product__origin">
                                                {{ number_format((float) $product->original_price, 0, ',', '.') }}đ
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ws-product__actions">
                                        <button
                                            type="button"
                                            class="ws-product__btn js-add-to-cart"
                                            data-product-id="{{ $product->id }}"
                                        >
                                            Thêm vào giỏ
                                        </button>

                                        <a href="{{ $product->trademark_url ?: 'javascript:void(0)' }}" class="ws-product__btn ws-product__btn--ghost">
                                            Xem thương hiệu
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

                        <div class="ws-pagination">
                            <a href="{{ $products->previousPageUrl() ?: 'javascript:void(0)' }}"
                               class="ws-pagination__item {{ $products->onFirstPage() ? 'is-disabled' : '' }}">
                                ‹
                            </a>

                            @if($start > 1)
                                <a href="{{ $products->url(1) }}" class="ws-pagination__item">1</a>
                                @if($start > 2)
                                    <span class="ws-pagination__item is-disabled">...</span>
                                @endif
                            @endif

                            @for($page = $start; $page <= $end; $page++)
                                <a href="{{ $products->url($page) }}"
                                   class="ws-pagination__item {{ $page === $currentPage ? 'is-active' : '' }}">
                                    {{ $page }}
                                </a>
                            @endfor

                            @if($end < $lastPage)
                                @if($end < $lastPage - 1)
                                    <span class="ws-pagination__item is-disabled">...</span>
                                @endif
                                <a href="{{ $products->url($lastPage) }}" class="ws-pagination__item">{{ $lastPage }}</a>
                            @endif

                            <a href="{{ $products->nextPageUrl() ?: 'javascript:void(0)' }}"
                               class="ws-pagination__item {{ $products->hasMorePages() ? '' : 'is-disabled' }}">
                                ›
                            </a>
                        </div>
                    @endif
                @else
                    <div class="ws-empty">
                        Không tìm thấy sản phẩm phù hợp với từ khóa "{{ $query }}".
                    </div>
                @endif
            </div>
        @else
            <div class="ws-section">
                <div class="ws-section__head">
                    <div>
                        <div class="ws-section__eyebrow">Gợi ý khám phá</div>
                        <h2 class="ws-section__title">Danh mục và thương hiệu nổi bật</h2>
                    </div>
                </div>

                <div class="ws-smart-grid">
                    <div class="ws-card">
                        <div class="ws-card__body">
                            <div class="ws-section__eyebrow">Danh mục phổ biến</div>
                            <h3 class="ws-section__title" style="font-size:24px; margin-bottom:16px;">Danh mục nổi bật</h3>

                            <div class="ws-pills">
                                @foreach($popularCategories as $category)
                                    <a href="{{ $category['url'] }}" class="ws-pill">
                                        <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}">
                                        <div class="ws-pill__content">
                                            <div class="ws-pill__name">{{ $category['name'] }}</div>
                                            <div class="ws-pill__meta">{{ $category['product_count'] }} sản phẩm</div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="ws-card">
                        <div class="ws-card__body">
                            <div class="ws-section__eyebrow">Thương hiệu phổ biến</div>
                            <h3 class="ws-section__title" style="font-size:24px; margin-bottom:16px;">Thương hiệu nổi bật</h3>

                            <div class="ws-pills">
                                @foreach($popularTrademarks as $trademark)
                                    <a href="{{ $trademark['url'] }}" class="ws-pill">
                                        <img src="{{ $trademark['image'] }}" alt="{{ $trademark['name'] }}">
                                        <div class="ws-pill__content">
                                            <div class="ws-pill__name">{{ $trademark['name'] }}</div>
                                            <div class="ws-pill__meta">{{ $trademark['product_count'] }} sản phẩm</div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<div class="ws-toast" id="wsToast"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toast = document.getElementById('wsToast');

        function showToast(message, type = 'success') {
            if (!toast) return;
            toast.textContent = message || '';
            toast.className = 'ws-toast ' + type + ' show';

            clearTimeout(window.__wsToastTimer);
            window.__wsToastTimer = setTimeout(() => {
                toast.classList.remove('show');
            }, 2600);
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
