@extends('website.layout.index')

@section('style')
@once
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">
@endonce

<style>
    :root{
        --pa-brand: #0c585c;
        --pa-brand-2: #0c8f75;
        --pa-brand-3: #12a6b5;
        --pa-bg-soft: #eaf7f3;
        --pa-text: #0f172a;
        --pa-muted: #64748b;
        --pa-border: #dbe7e5;
        --pa-orange: #ff5722;
        --pa-danger: #ef4444;
    }

    .lc-maincat-page,
    .lc-maincat-page *{
        box-sizing: border-box;
    }

    .lc-maincat-page i{
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 400 !important;
        -webkit-text-stroke: 0 !important;
    }

    .lc-maincat-page{
        padding: 28px 0 48px;
        background:
            radial-gradient(circle at 8% 2%, rgba(12, 143, 117, .10), transparent 28%),
            linear-gradient(180deg, #f4fffb 0%, #f7fbff 48%, #f5f9fd 100%);
        overflow-x: hidden;
    }

    .lc-maincat-page .lc-container{
        width: min(1320px, calc(100% - 32px));
        margin: 0 auto;
    }

    .lc-maincat-head{
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at 90% 0%, rgba(255,255,255,.22), transparent 34%),
            linear-gradient(135deg, var(--pa-brand) 0%, var(--pa-brand-2) 58%, var(--pa-brand-3) 100%);
        border-radius: 28px;
        padding: 30px;
        color: #fff;
        margin-bottom: 24px;
        box-shadow: 0 22px 54px rgba(12, 88, 92, 0.16);
    }

    .lc-maincat-head::before{
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(90deg, rgba(255,255,255,.08), transparent 40%, rgba(255,255,255,.10)),
            radial-gradient(circle at 20% 90%, rgba(255,255,255,.14), transparent 30%);
        pointer-events: none;
    }

    .lc-maincat-breadcrumb,
    .lc-maincat-title,
    .lc-maincat-sub{
        position: relative;
        z-index: 1;
    }

    .lc-maincat-breadcrumb{
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        font-size: 13px;
        margin-bottom: 12px;
        color: rgba(255,255,255,.9);
    }

    .lc-maincat-breadcrumb a{
        color: #fff;
        text-decoration: none;
        font-weight: 700;
    }

    .lc-maincat-breadcrumb a:hover{
        text-decoration: underline;
    }

    .lc-maincat-title{
        margin: 0 0 8px;
        font-size: 34px;
        font-weight: 850;
        line-height: 1.18;
        letter-spacing: -.02em;
    }

    .lc-maincat-sub{
        margin: 0;
        font-size: 15px;
        line-height: 1.75;
        color: rgba(255,255,255,.88);
        max-width: 920px;
    }

    .lc-subcat-block{
        margin-bottom: 24px;
    }

    .lc-subcat-slider{
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .lc-subcat-arrow{
        width: 44px;
        height: 44px;
        border: 0;
        border-radius: 999px;
        background: #fff;
        color: var(--pa-brand);
        cursor: pointer;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
        flex: 0 0 44px;
        font-size: 24px;
        line-height: 1;
    }

    .lc-subcat-arrow:hover{
        background: var(--pa-brand);
        color: #fff;
    }

    .lc-subcat-scroll{
        display: flex;
        gap: 14px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 4px 2px 10px;
        width: 100%;
        scrollbar-width: none;
    }

    .lc-subcat-scroll::-webkit-scrollbar{
        display: none;
    }

    .lc-subcat-card{
        min-width: 210px;
        max-width: 210px;
        background: #fff;
        border: 1px solid #e5edf0;
        border-radius: 22px;
        padding: 18px 16px;
        text-decoration: none;
        color: var(--pa-text);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        transition: all .22s ease;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
    }

    .lc-subcat-card:hover{
        transform: translateY(-3px);
        border-color: rgba(12, 143, 117, .28);
        box-shadow: 0 16px 32px rgba(12, 88, 92, 0.10);
        text-decoration: none;
    }

    .lc-subcat-card.is-active{
        border-color: rgba(12, 143, 117, .55);
        background: linear-gradient(180deg, #f2fffc 0%, #ffffff 100%);
        box-shadow: 0 16px 32px rgba(12, 88, 92, 0.13);
    }

    .lc-subcat-icon{
        width: 62px;
        height: 62px;
        border-radius: 18px;
        background: rgba(12, 143, 117, .08);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 14px;
    }

    .lc-subcat-icon img{
        width: 38px;
        height: 38px;
        object-fit: contain;
    }

    .lc-subcat-name{
        font-size: 15px;
        font-weight: 750;
        line-height: 1.45;
        margin-bottom: 6px;
        min-height: 44px;
        color: var(--pa-text);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .lc-subcat-count{
        font-size: 12px;
        color: var(--pa-muted);
        font-weight: 600;
    }

    .lc-maincat-layout{
        display: grid;
        grid-template-columns: 300px minmax(0, 1fr);
        gap: 22px;
        align-items: start;
    }

    .lc-filter-card{
        background: #fff;
        border-radius: 24px;
        padding: 22px;
        box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
        border: 1px solid #e8eff2;
        position: sticky;
        top: 20px;
    }

    .lc-filter-title{
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 20px;
        font-size: 19px;
        font-weight: 850;
        color: var(--pa-text);
    }

    .lc-filter-title::before{
        content: "\f0d1";
        font-family: "remixicon";
        width: 34px;
        height: 34px;
        border-radius: 12px;
        background: rgba(12, 143, 117, .10);
        color: var(--pa-brand);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 400;
    }

    .lc-filter-group{
        margin-bottom: 24px;
    }

    .lc-filter-group:last-child{
        margin-bottom: 0;
    }

    .lc-filter-label{
        margin: 0 0 14px;
        font-size: 16px;
        font-weight: 850;
        color: var(--pa-text);
    }

    .lc-filter-price-list{
        display: grid;
        gap: 12px;
    }

    .lc-filter-price-item{
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 50px;
        padding: 12px 16px;
        border-radius: 14px;
        border: 1px solid #dbe7e5;
        background: #fff;
        color: var(--pa-text);
        text-decoration: none;
        font-size: 14px;
        font-weight: 750;
        transition: all .2s ease;
    }

    .lc-filter-price-item:hover{
        border-color: rgba(12, 143, 117, .35);
        color: var(--pa-brand);
        background: #f5fffc;
        text-decoration: none;
    }

    .lc-filter-price-item.is-active{
        border-color: var(--pa-brand-2);
        background: rgba(12, 143, 117, .10);
        color: var(--pa-brand);
        box-shadow: inset 0 0 0 1px rgba(12, 143, 117, .18);
    }

    .lc-filter-clear{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 0 16px;
        border-radius: 999px;
        background: #f1f5f9;
        color: #334155;
        text-decoration: none;
        font-size: 14px;
        font-weight: 750;
    }

    .lc-filter-clear:hover{
        background: rgba(12, 88, 92, .08);
        color: var(--pa-brand);
        text-decoration: none;
    }

    .lc-product-panel{
        min-width: 0;
    }

    .lc-product-panel-head{
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 14px;
        padding: 18px;
        border-radius: 24px;
        background: #fff;
        border: 1px solid #e8eff2;
        box-shadow: 0 12px 30px rgba(15, 23, 42, .045);
    }

    .lc-product-panel-title{
        margin: 0;
        font-size: 22px;
        font-weight: 850;
        color: var(--pa-text);
        letter-spacing: -.01em;
    }

    .lc-product-panel-note{
        margin: 6px 0 0;
        font-size: 14px;
        line-height: 1.55;
        color: var(--pa-muted);
    }

    .lc-product-tools{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .lc-product-search-form{
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .lc-product-search-input{
        width: 320px;
        max-width: 100%;
        height: 42px;
        border-radius: 999px;
        border: 1px solid #dbe7e5;
        background: #fff;
        padding: 0 16px;
        font-size: 14px;
        color: var(--pa-text);
        outline: none;
    }

    .lc-product-search-input:focus{
        border-color: var(--pa-brand-2);
        box-shadow: 0 0 0 3px rgba(12, 143, 117, 0.10);
    }

    .lc-product-search-btn{
        height: 42px;
        padding: 0 18px;
        border: 0;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--pa-brand-2) 0%, var(--pa-brand) 100%);
        color: #fff;
        font-size: 14px;
        font-weight: 750;
        cursor: pointer;
        box-shadow: 0 10px 22px rgba(12, 143, 117, .16);
    }

    .lc-product-search-reset{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 42px;
        padding: 0 16px;
        border-radius: 999px;
        background: #f1f5f9;
        color: #334155;
        text-decoration: none;
        font-size: 14px;
        font-weight: 750;
    }

    .lc-sort-box{
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .lc-sort-label{
        font-size: 14px;
        font-weight: 750;
        color: #334155;
    }

    .lc-sort-actions{
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .lc-sort-btn{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 0 18px;
        border-radius: 999px;
        text-decoration: none;
        border: 1px solid #dbe7e5;
        background: #fff;
        color: var(--pa-text);
        font-size: 14px;
        font-weight: 750;
        transition: all .2s ease;
    }

    .lc-sort-btn:hover{
        border-color: rgba(12, 143, 117, .35);
        color: var(--pa-brand);
        text-decoration: none;
    }

    .lc-sort-btn.is-active{
        border-color: var(--pa-brand-2);
        background: rgba(12, 143, 117, .10);
        color: var(--pa-brand);
        box-shadow: inset 0 0 0 1px rgba(12, 143, 117, .18);
    }

    .lc-product-grid{
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .lc-product-card{
        position: relative;
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
        transition: all .22s ease;
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }

    .lc-product-card:hover{
        transform: translateY(-4px);
        border-color: rgba(12, 143, 117, .28);
        box-shadow: 0 18px 35px rgba(15, 23, 42, 0.1);
    }

    .lc-product-top{
        position: relative;
        padding: 14px 14px 8px;
    }

    .lc-product-badge{
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        background: linear-gradient(135deg, #ff6b35 0%, #ef4444 100%);
        color: #fff;
        font-size: 12px;
        font-weight: 850;
        box-shadow: 0 8px 18px rgba(239, 68, 68, .18);
    }

    .lc-product-thumb{
        width: 100%;
        aspect-ratio: 1 / 1;
        background: linear-gradient(180deg, #f9fcff 0%, #f3faf8 100%);
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .lc-product-thumb img{
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 8px;
        transition: transform .28s ease;
    }

    .lc-product-card:hover .lc-product-thumb img{
        transform: scale(1.04);
    }

    .lc-product-body{
        padding: 14px 16px 18px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .lc-product-name{
        margin: 0 0 8px;
        font-size: 15px;
        line-height: 1.45;
        font-weight: 750;
        color: var(--pa-text);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 44px;
    }

    .lc-product-code{
        margin-bottom: 10px;
        font-size: 12px;
        color: var(--pa-muted);
        min-height: 18px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .lc-product-price{
        margin-top: auto;
        margin-bottom: 12px;
        display: flex;
        align-items: flex-end;
        gap: 8px;
        flex-wrap: wrap;
    }

    .lc-product-price-sale{
        font-size: 18px;
        font-weight: 850;
        color: var(--pa-brand);
        line-height: 1;
        letter-spacing: -.01em;
    }

    .lc-product-price-original{
        font-size: 13px;
        color: #94a3b8;
        text-decoration: line-through;
        font-weight: 700;
    }

    .lc-product-actions{
        display: flex;
        gap: 10px;
    }

    .lc-product-buy{
        flex: 1;
        min-height: 42px;
        border: 0;
        border-radius: 999px;
        background: rgba(12, 143, 117, .10);
        color: var(--pa-brand);
        font-size: 14px;
        font-weight: 850;
        cursor: pointer;
        box-shadow: 0 10px 22px rgba(12, 143, 117, 0.10);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        text-decoration: none;
        transition: all .2s ease;
    }

    .lc-product-buy::before{
        content: "\ef48";
        font-family: "remixicon";
        font-size: 17px;
        font-weight: 400;
    }

    .lc-product-buy:hover{
        color: #fff;
        background: linear-gradient(135deg, var(--pa-brand-2) 0%, var(--pa-brand) 100%);
        text-decoration: none;
        transform: translateY(-1px);
    }

    .lc-empty-box{
        padding: 28px;
        border-radius: 18px;
        background: #fff;
        border: 1px dashed var(--pa-border);
        text-align: center;
        color: var(--pa-muted);
        font-size: 15px;
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
        color: var(--pa-text);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        background: #fff;
        font-weight: 750;
    }

    .lc-search-pagination .page-item.active .page-link{
        background: linear-gradient(135deg, var(--pa-brand-2) 0%, var(--pa-brand) 100%);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 10px 22px rgba(12, 143, 117, 0.18);
    }

    .lc-search-pagination .page-item .page-link:hover{
        background: #f2fffc;
        border-color: rgba(12, 143, 117, .28);
        color: var(--pa-brand);
    }

    @media (max-width: 1200px){
        .lc-product-grid{
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 992px){
        .lc-maincat-layout{
            grid-template-columns: 1fr;
        }

        .lc-filter-card{
            position: static;
        }
    }

    @media (max-width: 767px){
        html,
        body{
            max-width: 100%;
            overflow-x: hidden !important;
        }

        .lc-maincat-page{
            padding: 14px 0 30px;
            background: #f5fbf9;
            overflow-x: hidden;
        }

        .lc-maincat-page .lc-container{
            width: 100% !important;
            max-width: 100% !important;
            padding-left: 12px !important;
            padding-right: 12px !important;
            overflow: hidden;
        }

        .lc-maincat-head{
            border-radius: 22px;
            padding: 20px 16px;
            margin-bottom: 16px;
        }

        .lc-maincat-breadcrumb{
            flex-wrap: nowrap;
            overflow-x: auto;
            white-space: nowrap;
            scrollbar-width: none;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .lc-maincat-breadcrumb::-webkit-scrollbar{
            display: none;
        }

        .lc-maincat-title{
            font-size: 25px;
            line-height: 1.18;
        }

        .lc-maincat-sub{
            font-size: 13px;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .lc-subcat-block{
            margin-bottom: 16px;
            margin-right: -12px;
        }

        .lc-subcat-slider{
            display: block;
        }

        .lc-subcat-arrow{
            display: none;
        }

        .lc-subcat-scroll{
            gap: 10px;
            padding: 2px 12px 8px 0;
            scrollbar-width: none;
        }

        .lc-subcat-scroll::-webkit-scrollbar{
            display: none;
        }

        .lc-subcat-card{
            min-width: 138px;
            max-width: 138px;
            border-radius: 18px;
            padding: 12px 10px;
        }

        .lc-subcat-icon{
            width: 46px;
            height: 46px;
            border-radius: 14px;
            margin-bottom: 9px;
        }

        .lc-subcat-icon img{
            width: 30px;
            height: 30px;
        }

        .lc-subcat-name{
            font-size: 12px;
            line-height: 1.35;
            min-height: 32px;
            margin-bottom: 4px;
        }

        .lc-subcat-count{
            font-size: 10.5px;
        }

        .lc-maincat-layout,
        .lc-product-panel{
            width: 100%;
            max-width: 100%;
            min-width: 0;
            display: block;
            overflow: hidden;
        }

        .lc-filter-card{
            width: 100%;
            max-width: 100%;
            border-radius: 20px;
            padding: 14px;
            margin-bottom: 14px;
            box-shadow: 0 10px 26px rgba(15, 23, 42, .045);
        }

        .lc-filter-title{
            font-size: 17px;
            margin-bottom: 12px;
        }

        .lc-filter-title::before{
            width: 30px;
            height: 30px;
            border-radius: 11px;
            font-size: 16px;
        }

        .lc-filter-group{
            margin-bottom: 12px;
        }

        .lc-filter-label{
            display: none;
        }

        .lc-filter-price-list{
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 3px;
            scrollbar-width: none;
        }

        .lc-filter-price-list::-webkit-scrollbar{
            display: none;
        }

        .lc-filter-price-item{
            flex: 0 0 auto;
            min-height: 36px;
            padding: 0 12px;
            border-radius: 999px;
            font-size: 12px;
            white-space: nowrap;
        }

        .lc-filter-clear{
            min-height: 36px;
            padding: 0 12px;
            font-size: 12px;
            width: fit-content;
        }

        .lc-product-panel-head{
            border-radius: 20px;
            padding: 14px;
            margin-bottom: 12px;
            display: block;
        }

        .lc-product-panel-title{
            font-size: 19px;
        }

        .lc-product-panel-note{
            font-size: 12.5px;
            line-height: 1.55;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .lc-sort-box{
            margin-top: 12px;
            display: block;
        }

        .lc-sort-label{
            display: block;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .lc-sort-actions{
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 8px;
            scrollbar-width: none;
        }

        .lc-sort-actions::-webkit-scrollbar{
            display: none;
        }

        .lc-sort-btn{
            flex: 0 0 auto;
            min-height: 34px;
            padding: 0 12px;
            font-size: 12px;
        }

        .lc-product-tools{
            display: block;
            margin-bottom: 12px;
        }

        .lc-product-search-form{
            width: 100%;
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 8px;
        }

        .lc-product-search-input{
            width: 100%;
            height: 40px;
            font-size: 13px;
            padding: 0 12px;
        }

        .lc-product-search-btn{
            height: 40px;
            padding: 0 13px;
            font-size: 12px;
        }

        .lc-product-search-reset{
            grid-column: 1 / -1;
            width: fit-content;
            height: 34px;
            font-size: 12px;
            padding: 0 12px;
        }

        .lc-product-grid{
            width: 100% !important;
            max-width: 100% !important;
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 10px !important;
            overflow: visible !important;
        }

        .lc-product-card{
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            border-radius: 18px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .055);
        }

        .lc-product-card:hover{
            transform: none;
        }

        .lc-product-top{
            padding: 9px 9px 6px;
        }

        .lc-product-badge{
            top: 8px;
            left: 8px;
            padding: 4px 7px;
            font-size: 10px;
        }

        .lc-product-thumb{
            height: 116px;
            aspect-ratio: auto;
            border-radius: 15px;
        }

        .lc-product-thumb img{
            padding: 6px;
        }

        .lc-product-body{
            padding: 9px 10px 10px;
        }

        .lc-product-name{
            min-height: 38px;
            margin-bottom: 6px;
            font-size: 12.5px;
            line-height: 1.42;
            font-weight: 750;
            -webkit-line-clamp: 2;
        }

        .lc-product-code{
            min-height: 16px;
            margin-bottom: 7px;
            font-size: 10.5px;
            line-height: 1.3;
        }

        .lc-product-price{
            margin-bottom: 8px;
            gap: 5px;
        }

        .lc-product-price-sale{
            font-size: 14.5px;
            line-height: 1.2;
        }

        .lc-product-price-original{
            font-size: 10.5px;
        }

        .lc-product-buy{
            min-height: 34px;
            border-radius: 12px;
            font-size: 12px;
            gap: 5px;
            box-shadow: none;
        }

        .lc-product-buy::before{
            font-size: 14px;
        }

        .lc-empty-box{
            padding: 20px;
            border-radius: 18px;
            font-size: 13px;
        }

        .lc-search-pagination{
            margin-top: 18px;
            justify-content: flex-start;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .lc-search-pagination::-webkit-scrollbar{
            display: none;
        }

        .lc-search-pagination nav{
            justify-content: flex-start;
        }

        .lc-search-pagination .pagination{
            flex-wrap: nowrap;
            gap: 6px;
        }

        .lc-search-pagination .page-item .page-link{
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            border-radius: 11px;
            font-size: 12px;
        }
    }

    @media (max-width: 390px){
        .lc-maincat-page .lc-container{
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        .lc-product-grid{
            gap: 8px !important;
        }

        .lc-product-thumb{
            height: 108px;
        }

        .lc-product-body{
            padding: 8px;
        }

        .lc-product-name{
            font-size: 12px;
        }

        .lc-product-price-sale{
            font-size: 13.5px;
        }

        .lc-product-buy{
            min-height: 32px;
            font-size: 11.5px;
        }
    }
</style>
@endsection

@section('content')
@php
    $buildUrl = function(array $params = []) use ($mainCategory, $selectedCategoryId, $price, $sort, $keyword) {
        $query = array_merge([
            'category_id' => $selectedCategoryId ?: null,
            'price' => $price ?: null,
            'sort' => $sort ?: null,
            'keyword' => $keyword ?: null,
        ], $params);

        $query = array_filter($query, function ($value) {
            return !is_null($value) && $value !== '';
        });

        return route('website.main-category-v1.show', array_merge(['id' => $mainCategory->id], $query));
    };
@endphp

<section class="lc-maincat-page">
    <div class="lc-container">
        <div class="lc-maincat-head">
            <div class="lc-maincat-breadcrumb">
                <a href="{{ url('/') }}">Trang chủ</a>
                <span>/</span>
                <span>{{ $mainCategory->name }}</span>
            </div>

            <h1 class="lc-maincat-title">{{ $mainCategory->name }}</h1>

            <p class="lc-maincat-sub">
                {{ $mainCategory->description ?: 'Khám phá các nhóm sản phẩm phù hợp theo danh mục tổng.' }}
            </p>
        </div>

        @if($subCategories->count() > 0)
            <div class="lc-subcat-block">
                <div class="lc-subcat-slider">
                    <button class="lc-subcat-arrow" type="button" onclick="scrollSubCategory(-1)">‹</button>

                    <div class="lc-subcat-scroll" id="lcSubCategoryScroll">
                        <a href="{{ $buildUrl(['category_id' => null]) }}"
                           class="lc-subcat-card {{ $selectedCategoryId === 0 ? 'is-active' : '' }}">
                            <div class="lc-subcat-icon">
                                <img src="{{ asset('assets/images/no-image.png') }}" alt="Tất cả">
                            </div>
                            <div class="lc-subcat-name">Tất cả sản phẩm</div>
                            <div class="lc-subcat-count">{{ $products->total() }} sản phẩm</div>
                        </a>

                        @foreach($subCategories as $item)
                            <a href="{{ $buildUrl(['category_id' => $item->id]) }}"
                               class="lc-subcat-card {{ $selectedCategoryId === (int)$item->id ? 'is-active' : '' }}">
                                <div class="lc-subcat-icon">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                                </div>
                                <div class="lc-subcat-name">{{ $item->name }}</div>
                                <div class="lc-subcat-count">{{ $item->total_products }} sản phẩm</div>
                            </a>
                        @endforeach
                    </div>

                    <button class="lc-subcat-arrow" type="button" onclick="scrollSubCategory(1)">›</button>
                </div>
            </div>
        @endif

        <div class="lc-maincat-layout">
            <aside class="lc-filter-card">
                <h2 class="lc-filter-title">Bộ lọc nâng cao</h2>

                <div class="lc-filter-group">
                    <h3 class="lc-filter-label">Giá bán</h3>

                    <div class="lc-filter-price-list">
                        <a href="{{ $buildUrl(['price' => null]) }}"
                           class="lc-filter-price-item {{ $price === '' ? 'is-active' : '' }}">
                            Tất cả
                        </a>

                        @foreach($priceOptions as $key => $label)
                            <a href="{{ $buildUrl(['price' => $key]) }}"
                               class="lc-filter-price-item {{ $price === $key ? 'is-active' : '' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('website.main-category-v1.show', ['id' => $mainCategory->id]) }}"
                   class="lc-filter-clear">
                    Xóa bộ lọc
                </a>
            </aside>

            <div class="lc-product-panel">
                <div class="lc-product-panel-head">
                    <div>
                        <h2 class="lc-product-panel-title">Danh sách sản phẩm</h2>
                        <p class="lc-product-panel-note">
                            Lưu ý: Thuốc kê đơn và một số sản phẩm sẽ cần tư vấn từ dược sĩ.
                        </p>
                    </div>

                    <div class="lc-sort-box">
                        <span class="lc-sort-label">Sắp xếp theo:</span>

                        <div class="lc-sort-actions">
                            <a href="{{ $buildUrl(['sort' => 'popular']) }}"
                               class="lc-sort-btn {{ $sort === 'popular' ? 'is-active' : '' }}">
                                Bán chạy
                            </a>

                            <a href="{{ $buildUrl(['sort' => 'price_asc']) }}"
                               class="lc-sort-btn {{ $sort === 'price_asc' ? 'is-active' : '' }}">
                                Giá thấp
                            </a>

                            <a href="{{ $buildUrl(['sort' => 'price_desc']) }}"
                               class="lc-sort-btn {{ $sort === 'price_desc' ? 'is-active' : '' }}">
                                Giá cao
                            </a>
                        </div>
                    </div>
                </div>

                <div class="lc-product-tools">
                    <form method="GET"
                          action="{{ route('website.main-category-v1.show', ['id' => $mainCategory->id]) }}"
                          class="lc-product-search-form">
                        @if($selectedCategoryId)
                            <input type="hidden" name="category_id" value="{{ $selectedCategoryId }}">
                        @endif

                        @if($price)
                            <input type="hidden" name="price" value="{{ $price }}">
                        @endif

                        @if($sort)
                            <input type="hidden" name="sort" value="{{ $sort }}">
                        @endif

                        <input
                            type="text"
                            name="keyword"
                            class="lc-product-search-input"
                            placeholder="Tìm kiếm tên sản phẩm..."
                            value="{{ $keyword }}"
                        >

                        <button type="submit" class="lc-product-search-btn">Tìm kiếm</button>

                        @if($keyword !== '')
                            <a href="{{ $buildUrl(['keyword' => null]) }}" class="lc-product-search-reset">
                                Xóa từ khóa
                            </a>
                        @endif
                    </form>
                </div>

                @if($products->count() > 0)
                    <div class="lc-product-grid">
                        @foreach($products as $product)
                            @php
                                $detailUrl = route('website.product-v1.show', ['id' => $product->id]);
                            @endphp

                            <article class="lc-product-card">
                                <div class="lc-product-top">
                                    @if(!empty($product->original_price) && (float)$product->original_price > (float)$product->display_price)
                                        @php
                                            $percent = round((($product->original_price - $product->display_price) / $product->original_price) * 100);
                                        @endphp
                                        <span class="lc-product-badge">-{{ $percent }}%</span>
                                    @endif

                                    <a href="{{ $detailUrl }}" class="lc-product-thumb">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                                    </a>
                                </div>

                                <div class="lc-product-body">
                                    <h3 class="lc-product-name">
                                        <a href="{{ $detailUrl }}" style="color: inherit; text-decoration: none;">
                                            {{ $product->name }}
                                        </a>
                                    </h3>

                                    <div class="lc-product-code">
                                        {{ $product->code_product_kiovet ? 'Mã: '.$product->code_product_kiovet : '' }}
                                    </div>

                                    <div class="lc-product-price">
                                        <div class="lc-product-price-sale">
                                            {{ number_format((float)$product->display_price, 0, ',', '.') }}đ
                                        </div>

                                        @if(!empty($product->original_price))
                                            <div class="lc-product-price-original">
                                                {{ number_format((float)$product->original_price, 0, ',', '.') }}đ
                                            </div>
                                        @endif
                                    </div>

                                    <div class="lc-product-actions">
                                        <a href="{{ $detailUrl }}" class="lc-product-buy">
                                            Chọn mua
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="lc-search-pagination">
                        {{ $products->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <div class="lc-empty-box">
                        Hiện chưa có sản phẩm phù hợp trong danh mục này.
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<script>
    function scrollSubCategory(direction) {
        const wrap = document.getElementById('lcSubCategoryScroll');

        if (!wrap) {
            return;
        }

        const scrollAmount = window.innerWidth <= 767 ? 148 : 320;

        wrap.scrollBy({
            left: scrollAmount * direction,
            behavior: 'smooth'
        });
    }
</script>
@endsection