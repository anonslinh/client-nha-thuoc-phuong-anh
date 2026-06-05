@extends('website.layout.index')

@section('style')
<style>
    .lc-search-page{
        padding: 28px 0 48px;
        background: #f5f7fb;
    }

    .lc-container{
        width: min(1280px, calc(100% - 32px));
        margin: 0 auto;
    }

    .lc-search-page-head{
        background: linear-gradient(135deg, #0ea5c6 0%, #0b89b8 100%);
        border-radius: 24px;
        padding: 28px 28px 24px;
        color: #fff;
        box-shadow: 0 18px 40px rgba(14, 165, 198, 0.18);
        margin-bottom: 24px;
    }

    .lc-search-breadcrumb{
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        margin-bottom: 12px;
        color: rgba(255,255,255,0.88);
        flex-wrap: wrap;
    }

    .lc-search-breadcrumb a{
        color: #fff;
        text-decoration: none;
        opacity: .92;
    }

    .lc-search-breadcrumb a:hover{
        opacity: 1;
        text-decoration: underline;
    }

    .lc-search-page-title{
        margin: 0 0 8px;
        font-size: 30px;
        line-height: 1.2;
        font-weight: 800;
    }

    .lc-search-page-sub{
        margin: 0;
        font-size: 15px;
        color: rgba(255,255,255,0.92);
    }

    .lc-search-keyword-highlight{
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.14);
        border: 1px solid rgba(255,255,255,0.24);
        color: #fff;
        padding: 8px 14px;
        border-radius: 999px;
        margin-top: 16px;
        font-weight: 700;
        font-size: 14px;
    }

    .lc-search-related-tags{
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
    }

    .lc-search-tag{
        display: inline-flex;
        align-items: center;
        min-height: 36px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(255,255,255,0.14);
        border: 1px solid rgba(255,255,255,0.22);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
    }

    .lc-search-result-block{
        background: #fff;
        border-radius: 24px;
        padding: 22px;
        box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
        margin-bottom: 22px;
    }

    .lc-search-result-head{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .lc-search-result-heading{
        margin: 0;
        font-size: 24px;
        line-height: 1.2;
        font-weight: 800;
        color: #0f172a;
    }

    .lc-search-result-count{
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 999px;
        background: #eef8ff;
        color: #0b7fab;
        font-size: 13px;
        font-weight: 700;
    }

    .lc-priority-wrap{
        padding: 16px;
        border-radius: 22px;
        background: linear-gradient(180deg, #f3fbff 0%, #ffffff 100%);
        border: 1px solid #dff3fb;
    }

    .lc-search-priority-row{
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 18px;
    }

    .lc-search-result-grid{
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 18px;
    }

    .lc-product-card{
        position: relative;
        display: flex;
        flex-direction: column;
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 22px;
        overflow: hidden;
        min-height: 100%;
        transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
    }

    .lc-product-card:hover{
        transform: translateY(-4px);
        border-color: #ccecf7;
        box-shadow: 0 18px 35px rgba(15, 23, 42, 0.1);
    }

    .lc-product-card--priority{
        border-color: #c9eef8;
        box-shadow: 0 16px 34px rgba(14, 165, 198, 0.12);
    }

    .lc-product-card-top{
        position: relative;
        padding: 14px;
        background: linear-gradient(180deg, #f8fbfd 0%, #ffffff 100%);
    }

    .lc-product-badge{
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        padding: 7px 10px;
        border-radius: 999px;
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        box-shadow: 0 8px 18px rgba(244, 63, 94, 0.25);
    }

    .lc-product-priority-badge{
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        box-shadow: 0 8px 18px rgba(8, 145, 178, 0.22);
    }

    .lc-product-image-wrap{
        width: 100%;
        aspect-ratio: 1 / 1;
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lc-product-image-wrap img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .3s ease;
    }

    .lc-product-card:hover .lc-product-image-wrap img{
        transform: scale(1.04);
    }

    .lc-product-body{
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 16px 16px 18px;
    }

    .lc-product-name{
        margin: 0 0 8px;
        font-size: 16px;
        line-height: 1.45;
        font-weight: 700;
        color: #0f172a;

        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 46px;
    }

    .lc-product-subname{
        margin: 0 0 12px;
        font-size: 13px;
        line-height: 1.5;
        color: #64748b;

        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 39px;
    }

    .lc-product-code{
        margin-bottom: 12px;
        font-size: 12px;
        color: #94a3b8;
        min-height: 18px;
    }

    .lc-product-price-row{
        display: flex;
        align-items: flex-end;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: auto;
        margin-bottom: 16px;
    }

    .lc-product-price-sale{
        font-size: 20px;
        line-height: 1;
        font-weight: 800;
        color: #0ea5c6;
    }

    .lc-product-price-original{
        font-size: 14px;
        color: #94a3b8;
        text-decoration: line-through;
        font-weight: 600;
    }

    .lc-product-actions{
        display: flex;
        gap: 10px;
    }

    .lc-product-btn-buy,
    .lc-product-btn-view{
        border: 0;
        outline: none;
        min-height: 44px;
        border-radius: 999px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s ease;
    }

    .lc-product-btn-buy{
        flex: 1;
        background: linear-gradient(135deg, #0ea5c6 0%, #0891b2 100%);
        color: #fff;
        box-shadow: 0 10px 20px rgba(8, 145, 178, 0.18);
    }

    .lc-product-btn-buy:hover{
        transform: translateY(-1px);
        box-shadow: 0 14px 24px rgba(8, 145, 178, 0.24);
    }

    .lc-product-btn-view{
        width: 44px;
        flex: 0 0 44px;
        background: #eef8ff;
        color: #0b7fab;
    }

    .lc-product-btn-view:hover{
        background: #dff3fb;
    }

    .lc-search-empty{
        padding: 22px;
        border-radius: 18px;
        background: #f8fafc;
        text-align: center;
        color: #64748b;
        font-size: 15px;
        border: 1px dashed #d9e2ec;
    }

    .lc-search-pagination{
        margin-top: 26px;
        display: flex;
        justify-content: center;
    }

    .lc-search-pagination nav{
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .lc-search-pagination .pagination{
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .lc-search-pagination .page-item .page-link{
        min-width: 42px;
        height: 42px;
        padding: 0 14px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        color: #0f172a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        background: #fff;
        font-weight: 700;
        transition: all .2s ease;
        box-shadow: none;
    }

    .lc-search-pagination .page-item.active .page-link{
        background: linear-gradient(135deg, #0ea5c6 0%, #0891b2 100%);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 10px 22px rgba(8, 145, 178, 0.2);
    }

    .lc-search-pagination .page-item .page-link:hover{
        background: #eef8ff;
        border-color: #cfe8f3;
    }

    @media (max-width: 1200px){
        .lc-search-priority-row,
        .lc-search-result-grid{
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 992px){
        .lc-search-page-title{
            font-size: 26px;
        }

        .lc-search-priority-row,
        .lc-search-result-grid{
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px){
        .lc-search-page{
            padding: 18px 0 34px;
        }

        .lc-container{
            width: min(100%, calc(100% - 20px));
        }

        .lc-search-page-head{
            border-radius: 18px;
            padding: 20px 16px;
        }

        .lc-search-page-title{
            font-size: 22px;
        }

        .lc-search-result-block{
            padding: 16px;
            border-radius: 18px;
        }

        .lc-priority-wrap{
            padding: 10px;
            border-radius: 16px;
        }

        .lc-search-priority-row,
        .lc-search-result-grid{
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .lc-product-name{
            font-size: 15px;
        }

        .lc-product-price-sale{
            font-size: 18px;
        }
    }

    @media (max-width: 480px){
        .lc-search-priority-row,
        .lc-search-result-grid{
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .lc-product-body{
            padding: 14px;
        }

        .lc-product-name{
            min-height: 42px;
        }

        .lc-product-subname{
            min-height: 36px;
            font-size: 12px;
        }
    }
</style>
@endsection

@section('content')
    <section class="lc-search-page">
        <div class="lc-container">
            <div class="lc-search-page-head">
                <div class="lc-search-breadcrumb">

                    <span>/</span>
                    <span>Chi tiết từ khóa</span>
                </div>

                <h1 class="lc-search-page-title">Khám phá sản phẩm theo từ khóa</h1>
                <p class="lc-search-page-sub">
                    Hệ thống đang gợi ý nhóm sản phẩm phù hợp nhất dựa trên từ khóa mà tôi đang quan tâm.
                </p>

                <div class="lc-search-keyword-highlight">
                    <span>Từ khóa:</span>
                    <strong>{{ $keyword->key_search }}</strong>
                </div>

                @if(!empty($relatedKeywords) && count($relatedKeywords) > 0)
                    <div class="lc-search-related-tags">
                        @foreach($relatedKeywords as $tag)
                            <span class="lc-search-tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            @if(($priorityProducts ?? collect())->count() > 0)
                <div class="lc-search-result-block">
                    <div class="lc-search-result-head">
                        <h2 class="lc-search-result-heading">Sản phẩm ưu tiên</h2>
                        <span class="lc-search-result-count">{{ $priorityProducts->count() }} sản phẩm</span>
                    </div>

                    <div class="lc-priority-wrap">
                        <div class="lc-search-priority-row">
                            @foreach($priorityProducts as $product)
                                <article class="lc-product-card lc-product-card--priority">
                                    <div class="lc-product-card-top">
                                        <span class="lc-product-badge lc-product-priority-badge">Ưu tiên</span>

                                        <div class="lc-product-image-wrap">
                                            <img src="{{ $product->image_url }}"
                                                 alt="{{ $product->name }}">
                                        </div>
                                    </div>

                                    <div class="lc-product-body">
                                        <h3 class="lc-product-name">{{ $product->name }}</h3>

                                        <div class="lc-product-subname">
                                            {{ \Illuminate\Support\Str::limit($product->full_name ?: $product->name, 70) }}
                                        </div>

                                        <div class="lc-product-code">
                                            {{ $product->code_product_kiovet ? 'Mã: '.$product->code_product_kiovet : '' }}
                                        </div>

                                        <div class="lc-product-price-row">
                                            <div class="lc-product-price-sale">
                                                {{ number_format((float)($product->display_price ?? 0), 0, ',', '.') }}đ
                                            </div>

                                            @if(!empty($product->original_price))
                                                <div class="lc-product-price-original">
                                                    {{ number_format((float)$product->original_price, 0, ',', '.') }}đ
                                                </div>
                                            @endif
                                        </div>

                                        <div class="lc-product-actions">
                                            <button class="lc-product-btn-buy" type="button">Chọn mua</button>
                                            <button class="lc-product-btn-view" type="button">›</button>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="lc-search-result-block">
                <div class="lc-search-result-head">
                    <h2 class="lc-search-result-heading">Sản phẩm liên quan</h2>
                    <span class="lc-search-result-count">{{ $searchProducts->total() }} sản phẩm</span>
                </div>

                @if($searchProducts->count() > 0)
                    <div class="lc-search-result-grid">
                        @foreach($searchProducts as $product)
                            <article class="lc-product-card">
                                <div class="lc-product-card-top">
                                    @if(!empty($product->original_price) && (float)$product->original_price > (float)$product->display_price)
                                        @php
                                            $percent = round((($product->original_price - $product->display_price) / $product->original_price) * 100);
                                        @endphp
                                        <span class="lc-product-badge">-{{ $percent }}%</span>
                                    @endif

                                    <div class="lc-product-image-wrap">
                                        <img src="{{ $product->image_url }}"
                                             alt="{{ $product->name }}">
                                    </div>
                                </div>

                                <div class="lc-product-body">
                                    <h3 class="lc-product-name">{{ $product->name }}</h3>

                                    <div class="lc-product-subname">
                                        {{ \Illuminate\Support\Str::limit($product->full_name ?: $product->name, 70) }}
                                    </div>

                                    <div class="lc-product-code">
                                        {{ $product->code_product_kiovet ? 'Mã: '.$product->code_product_kiovet : '' }}
                                    </div>

                                    <div class="lc-product-price-row">
                                        <div class="lc-product-price-sale">
                                            {{ number_format((float)($product->display_price ?? 0), 0, ',', '.') }}đ
                                        </div>

                                        @if(!empty($product->original_price))
                                            <div class="lc-product-price-original">
                                                {{ number_format((float)$product->original_price, 0, ',', '.') }}đ
                                            </div>
                                        @endif
                                    </div>

                                    <div class="lc-product-actions">
                                        <button class="lc-product-btn-buy" type="button">Chọn mua</button>
                                        <button class="lc-product-btn-view" type="button">›</button>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="lc-search-pagination">
                        {{ $searchProducts->links() }}
                    </div>
                @else
                    <div class="lc-search-empty">Không có sản phẩm liên quan theo từ khóa này.</div>
                @endif
            </div>
        </div>
    </section>
@endsection