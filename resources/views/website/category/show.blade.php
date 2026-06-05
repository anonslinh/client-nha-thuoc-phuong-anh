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
    }

    .wc-page,
    .wc-page *{
        box-sizing: border-box;
    }

    .wc-page i{
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 400 !important;
        -webkit-text-stroke: 0 !important;
    }

    .wc-page{
        background:
            radial-gradient(circle at 8% 2%, rgba(12, 143, 117, .10), transparent 28%),
            linear-gradient(180deg, #f4fffb 0%, #f7fbff 48%, #f5f9fd 100%);
        padding: 22px 0 42px;
    }

    .wc-container{
        width: min(1320px, calc(100% - 32px));
        margin: 0 auto;
    }

    .wc-breadcrumb{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
    }

    .wc-breadcrumb a{
        color: #475569;
        text-decoration: none;
    }

    .wc-breadcrumb a:hover{
        color: var(--pa-brand);
    }

    .wc-hero{
        position: relative;
        overflow: hidden;
        border-radius: 32px;
        background:
            radial-gradient(circle at 88% 8%, rgba(255,255,255,.30), transparent 30%),
            linear-gradient(135deg, #0c585c 0%, #0c8f75 58%, #12a6b5 100%);
        box-shadow: 0 26px 60px rgba(12, 88, 92, .14);
        padding: 30px;
        color: #ffffff;
    }

    .wc-hero::before{
        content: '';
        position: absolute;
        inset: auto -80px -80px auto;
        width: 280px;
        height: 280px;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(255,255,255,.18) 0%, rgba(255,255,255,0) 70%);
        pointer-events: none;
    }

    .wc-hero__grid{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 290px;
        gap: 26px;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .wc-hero__eyebrow{
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 36px;
        padding: 0 16px;
        border-radius: 999px;
        background: rgba(255,255,255,.16);
        border: 1px solid rgba(255,255,255,.20);
        color: #ffffff;
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 14px;
        backdrop-filter: blur(10px);
    }

    .wc-hero__eyebrow::before{
        content: "\eb2a";
        font-family: "remixicon";
        font-size: 16px;
        font-weight: 400;
    }

    .wc-hero__title{
        margin: 0;
        font-size: 48px;
        line-height: 1.08;
        font-weight: 900;
        color: #ffffff;
        letter-spacing: -0.03em;
    }

    .wc-hero__desc{
        margin: 16px 0 0;
        color: rgba(255,255,255,.84);
        font-size: 17px;
        line-height: 1.8;
        max-width: 820px;
    }

    .wc-hero__meta{
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 22px;
    }

    .wc-hero__meta-item{
        min-width: 150px;
        padding: 15px 18px;
        border-radius: 20px;
        background: rgba(255,255,255,.16);
        border: 1px solid rgba(255,255,255,.22);
        box-shadow: 0 12px 26px rgba(15, 23, 42, .05);
        backdrop-filter: blur(10px);
    }

    .wc-hero__meta-value{
        font-size: 24px;
        line-height: 1;
        font-weight: 900;
        color: #ffffff;
        margin-bottom: 8px;
    }

    .wc-hero__meta-label{
        font-size: 13px;
        color: rgba(255,255,255,.78);
        font-weight: 700;
    }

    .wc-hero__image-card{
        background: rgba(255,255,255,.68);
        border: 1px solid rgba(255,255,255,.82);
        border-radius: 28px;
        padding: 14px;
        box-shadow: 0 18px 42px rgba(15, 23, 42, .08);
    }

    .wc-hero__image-card img{
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        display: block;
        border-radius: 22px;
        background: #fff;
    }

    .wc-layout{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 22px;
        margin-top: 24px;
    }

    .wc-main{
        min-width: 0;
    }

    .wc-sidebar{
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .wc-card{
        background: #fff;
        border-radius: 28px;
        border: 1px solid #e8eff6;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .06);
    }

    .wc-filter-card{
        padding: 22px;
        margin-bottom: 18px;
    }

    .wc-filter-head{
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 16px;
    }

    .wc-filter-title{
        margin: 0;
        font-size: 28px;
        line-height: 1.2;
        font-weight: 900;
        color: var(--pa-text);
        letter-spacing: -0.02em;
    }

    .wc-filter-desc{
        margin: 8px 0 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .wc-filter-count{
        flex: 0 0 auto;
        padding: 10px 16px;
        border-radius: 999px;
        background: rgba(12, 143, 117, .08);
        color: var(--pa-brand);
        font-size: 13px;
        font-weight: 800;
    }

    .wc-filter-form{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 220px 130px;
        gap: 14px;
    }

    .wc-input,
    .wc-select{
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

    .wc-input:focus,
    .wc-select:focus{
        border-color: var(--pa-brand-2);
        box-shadow: 0 0 0 4px rgba(12,143,117,.12);
    }

    .wc-btn{
        height: 50px;
        border: none;
        border-radius: 16px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        transition: all .25s ease;
    }

    .wc-btn--primary{
        color: #fff;
        background: linear-gradient(135deg, var(--pa-brand-2), var(--pa-brand));
        box-shadow: 0 16px 28px rgba(12, 143, 117, .18);
    }

    .wc-btn--primary:hover{
        transform: translateY(-2px);
    }

    .wc-products-grid{
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .wc-product{
        background: #fff;
        border-radius: 24px;
        border: 1px solid #e8eff6;
        overflow: hidden;
        box-shadow: 0 14px 32px rgba(15, 23, 42, .06);
        transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        display: flex;
        flex-direction: column;
    }

    .wc-product:hover{
        transform: translateY(-4px);
        box-shadow: 0 22px 42px rgba(15, 23, 42, .10);
        border-color: rgba(12, 143, 117, .25);
    }

    .wc-product__image{
        display: flex;
        align-items: center;
        justify-content: center;
        aspect-ratio: 1 / 1;
        padding: 18px;
        background: linear-gradient(180deg, #f9fcff 0%, #f2f8fc 100%);
        text-decoration: none;
        overflow: hidden;
    }

    .wc-product__image img{
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
        transition: transform .25s ease;
    }

    .wc-product:hover .wc-product__image img{
        transform: scale(1.04);
    }

    .wc-product__body{
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .wc-product__name{
        margin: 0 0 9px;
        min-height: 50px;
        font-size: 15px;
        line-height: 1.45;
        font-weight: 750;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .wc-product__name a{
        color: #0f172a;
        text-decoration: none;
    }

    .wc-product__name a:hover{
        color: var(--pa-brand);
    }

    .wc-product__desc{
        margin-bottom: 12px;
        min-height: 42px;
        font-size: 13px;
        line-height: 1.6;
        color: #64748b;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .wc-product__price{
        margin-top: auto;
        margin-bottom: 13px;
    }

    .wc-product__sale{
        font-size: 20px;
        line-height: 1.2;
        font-weight: 900;
        color: var(--pa-brand);
        letter-spacing: -.01em;
    }

    .wc-product__sale span{
        font-size: 12px;
        color: #64748b;
        font-weight: 700;
    }

    .wc-product__origin{
        margin-top: 5px;
        font-size: 13px;
        font-weight: 700;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .wc-product__btn{
        width: 100%;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border-radius: 999px;
        background: rgba(12, 143, 117, .10);
        color: var(--pa-brand);
        text-decoration: none;
        font-size: 14px;
        font-weight: 850;
        box-shadow: 0 12px 24px rgba(12, 143, 117, .10);
        transition: all .22s ease;
    }

    .wc-product__btn::before{
        content: "\ef48";
        font-family: "remixicon";
        font-size: 17px;
        font-weight: 400;
    }

    .wc-product__btn:hover{
        color: #fff;
        background: linear-gradient(135deg, var(--pa-brand-2), var(--pa-brand));
        text-decoration: none;
        transform: translateY(-1px);
    }

    .wc-empty{
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

    .wc-sidebar-card{
        padding: 22px;
    }

    .wc-sidebar-label{
        font-size: 12px;
        font-weight: 900;
        color: var(--pa-brand);
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 8px;
    }

    .wc-sidebar-title{
        margin: 0 0 14px;
        font-size: 24px;
        line-height: 1.2;
        font-weight: 900;
        color: #0f172a;
    }

    .wc-sidebar-text{
        color: #475569;
        font-size: 15px;
        line-height: 1.85;
    }

    .wc-related-list{
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .wc-related-item{
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

    .wc-related-item:hover{
        background: #f8fbff;
        border-color: #e4eef7;
        transform: translateX(3px);
    }

    .wc-related-item img{
        width: 52px;
        height: 52px;
        object-fit: cover;
        border-radius: 14px;
        background: #f4f8fb;
        flex: 0 0 auto;
    }

    .wc-related-item-name{
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.5;
    }

    .wc-pagination{
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    .wc-pagination__item{
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

    .wc-pagination__item:hover{
        border-color: var(--pa-brand-2);
        color: var(--pa-brand);
    }

    .wc-pagination__item.is-active{
        background: linear-gradient(135deg, var(--pa-brand-2), var(--pa-brand));
        color: #fff;
        border-color: transparent;
        box-shadow: 0 12px 22px rgba(12,143,117,.16);
    }

    .wc-pagination__item.is-disabled{
        opacity: .45;
        pointer-events: none;
    }

    @media (max-width: 1280px){
        .wc-products-grid{
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991px){
        .wc-container{
            width: min(100%, calc(100% - 24px));
        }

        .wc-hero__grid{
            grid-template-columns: 1fr;
        }

        .wc-layout{
            grid-template-columns: 1fr;
        }

        .wc-filter-form{
            grid-template-columns: 1fr 1fr;
        }

        .wc-filter-form .wc-btn{
            grid-column: 1 / -1;
        }

        .wc-products-grid{
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px){
        .wc-page{
            padding: 12px 0 28px;
            background: #f5fbf9;
        }

        .wc-container{
            width: min(100%, calc(100% - 20px));
        }

        .wc-breadcrumb{
            flex-wrap: nowrap;
            overflow-x: auto;
            white-space: nowrap;
            gap: 7px;
            margin-bottom: 12px;
            padding: 2px 0 4px;
            font-size: 12px;
            scrollbar-width: none;
        }

        .wc-breadcrumb::-webkit-scrollbar{
            display: none;
        }

        .wc-hero{
            padding: 18px;
            border-radius: 24px;
        }

        .wc-hero__grid{
            gap: 16px;
        }

        .wc-hero__eyebrow{
            min-height: 30px;
            padding: 0 12px;
            font-size: 11px;
            margin-bottom: 10px;
        }

        .wc-hero__title{
            font-size: 28px;
            line-height: 1.15;
        }

        .wc-hero__desc{
            margin-top: 10px;
            font-size: 13px;
            line-height: 1.65;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .wc-hero__meta{
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 14px;
        }

        .wc-hero__meta-item{
            min-width: 0;
            padding: 12px;
            border-radius: 16px;
        }

        .wc-hero__meta-value{
            font-size: 20px;
            margin-bottom: 5px;
        }

        .wc-hero__meta-label{
            font-size: 11px;
            line-height: 1.35;
        }

        .wc-hero__media{
            display: none;
        }

        .wc-layout{
            margin-top: 14px;
            gap: 16px;
        }

        .wc-card{
            border-radius: 22px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .05);
        }

        .wc-filter-card{
            padding: 14px;
            margin-bottom: 14px;
            position: sticky;
            top: 0;
            z-index: 10;
            border-radius: 20px;
        }

        .wc-filter-head{
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 12px;
        }

        .wc-filter-title{
            font-size: 18px;
            line-height: 1.25;
        }

        .wc-filter-desc{
            display: none;
        }

        .wc-filter-count{
            padding: 7px 10px;
            font-size: 11px;
            white-space: nowrap;
        }

        .wc-filter-form{
            grid-template-columns: 1fr;
            gap: 9px;
        }

        .wc-input,
        .wc-select{
            height: 42px;
            border-radius: 14px;
            padding: 0 12px;
            font-size: 13px;
        }

        .wc-btn{
            height: 42px;
            border-radius: 14px;
            font-size: 13px;
        }

        .wc-products-grid{
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .wc-product{
            border-radius: 18px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .055);
        }

        .wc-product:hover{
            transform: none;
        }

        .wc-product__image{
            aspect-ratio: 1 / .92;
            padding: 10px;
        }

        .wc-product__body{
            padding: 10px;
        }

        .wc-product__name{
            min-height: 38px;
            margin-bottom: 7px;
            font-size: 12.5px;
            line-height: 1.42;
            font-weight: 750;
            -webkit-line-clamp: 2;
        }

        .wc-product__desc{
            display: none;
        }

        .wc-product__price{
            margin-top: auto;
            margin-bottom: 9px;
        }

        .wc-product__sale{
            font-size: 14.5px;
            line-height: 1.25;
        }

        .wc-product__sale span{
            display: none;
        }

        .wc-product__origin{
            margin-top: 3px;
            font-size: 10.5px;
        }

        .wc-product__btn{
            height: 34px;
            border-radius: 12px;
            font-size: 12px;
            gap: 5px;
            box-shadow: none;
        }

        .wc-product__btn::before{
            font-size: 14px;
        }

        .wc-pagination{
            margin-top: 18px;
            gap: 6px;
            flex-wrap: nowrap;
            overflow-x: auto;
            justify-content: flex-start;
            padding-bottom: 4px;
            scrollbar-width: none;
        }

        .wc-pagination::-webkit-scrollbar{
            display: none;
        }

        .wc-pagination__item{
            min-width: 36px;
            height: 36px;
            border-radius: 11px;
            padding: 0 10px;
            font-size: 12px;
            flex: 0 0 auto;
        }

        .wc-sidebar{
            gap: 14px;
        }

        .wc-sidebar-card{
            padding: 16px;
            border-radius: 22px;
        }

        .wc-sidebar-label{
            font-size: 10px;
        }

        .wc-sidebar-title{
            font-size: 18px;
            margin-bottom: 9px;
        }

        .wc-sidebar-text{
            font-size: 13px;
            line-height: 1.65;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .wc-related-list{
            display: flex;
            flex-direction: row;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 4px;
            scrollbar-width: none;
        }

        .wc-related-list::-webkit-scrollbar{
            display: none;
        }

        .wc-related-item{
            flex: 0 0 132px;
            min-height: 132px;
            display: block;
            padding: 10px;
            border: 1px solid #eef2f7;
            border-radius: 18px;
            background: #fff;
        }

        .wc-related-item:hover{
            transform: none;
        }

        .wc-related-item img{
            width: 100%;
            height: 72px;
            border-radius: 14px;
            margin-bottom: 8px;
        }

        .wc-related-item-name{
            font-size: 12px;
            line-height: 1.35;
            font-weight: 700;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .wc-empty{
            min-height: 180px;
            border-radius: 22px;
            font-size: 13px;
            padding: 18px;
        }
    }

    @media (max-width: 390px){
        .wc-container{
            width: min(100%, calc(100% - 16px));
        }

        .wc-products-grid{
            gap: 8px;
        }

        .wc-product__body{
            padding: 9px;
        }

        .wc-product__name{
            font-size: 12px;
        }

        .wc-product__sale{
            font-size: 13.5px;
        }

        .wc-product__btn{
            height: 32px;
            font-size: 11.5px;
        }
    }
    /* =========================
   FIX MOBILE PRODUCT CATEGORY
   ========================= */
@media (max-width: 767px){
    html,
    body{
        max-width: 100%;
        overflow-x: hidden !important;
    }

    .wc-page{
        width: 100%;
        max-width: 100%;
        overflow-x: hidden !important;
        padding: 10px 0 28px;
        background: #f5fbf9;
    }

    .wc-container{
        width: 100% !important;
        max-width: 100% !important;
        padding-left: 12px !important;
        padding-right: 12px !important;
        margin-left: auto !important;
        margin-right: auto !important;
        overflow: hidden;
    }

    .wc-layout,
    .wc-main{
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        overflow: hidden;
    }

    .wc-layout{
        display: block !important;
        margin-top: 14px;
    }

    .wc-filter-card{
        width: 100%;
        max-width: 100%;
        padding: 14px;
        margin-bottom: 14px;
        border-radius: 20px;
    }

    .wc-filter-head{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 12px;
    }

    .wc-filter-title{
        font-size: 20px;
        line-height: 1.25;
        margin: 0;
    }

    .wc-filter-desc{
        display: none;
    }

    .wc-filter-count{
        flex: 0 0 auto;
        padding: 7px 10px;
        font-size: 11px;
        white-space: nowrap;
    }

    .wc-filter-form{
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 9px;
        width: 100%;
    }

    .wc-input,
    .wc-select,
    .wc-btn{
        width: 100%;
        height: 42px;
        border-radius: 14px;
        font-size: 13px;
    }

    .wc-products-grid{
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 10px !important;
        overflow: visible !important;
    }

    .wc-product{
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 24px rgba(15, 23, 42, .055);
    }

    .wc-product:hover{
        transform: none;
    }

    .wc-product__image{
        width: 100%;
        height: 128px !important;
        aspect-ratio: auto !important;
        padding: 9px !important;
        background: linear-gradient(180deg, #f9fcff 0%, #f2f8fc 100%);
    }

    .wc-product__image img{
        width: 100%;
        height: 100%;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }

    .wc-product__body{
        padding: 10px !important;
        min-width: 0;
    }

    .wc-product__name{
        min-height: 38px !important;
        margin: 0 0 8px !important;
        font-size: 12.5px !important;
        line-height: 1.42 !important;
        font-weight: 750 !important;

        display: -webkit-box !important;
        -webkit-line-clamp: 2 !important;
        -webkit-box-orient: vertical !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .wc-product__name a{
        color: #0f172a;
        text-decoration: none;
    }

    .wc-product__desc{
        display: none !important;
    }

    .wc-product__price{
        margin: 0 0 9px !important;
    }

    .wc-product__sale{
        font-size: 15px !important;
        line-height: 1.25 !important;
        font-weight: 900 !important;
        color: #0c585c !important;
        white-space: nowrap;
    }

    .wc-product__sale span{
        display: none !important;
    }

    .wc-product__origin{
        margin-top: 3px !important;
        font-size: 10.5px !important;
        line-height: 1.2 !important;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .wc-product__btn{
        width: 100%;
        height: 34px !important;
        min-height: 34px !important;
        border-radius: 12px !important;
        font-size: 12px !important;
        font-weight: 800;
        gap: 5px;
        box-shadow: none !important;
        white-space: nowrap;
    }

    .wc-product__btn::before{
        font-size: 14px !important;
    }

    .wc-sidebar{
        width: 100%;
        max-width: 100%;
        margin-top: 16px;
        overflow: hidden;
    }

    .wc-pagination{
        width: 100%;
        max-width: 100%;
        margin-top: 18px;
        display: flex;
        justify-content: flex-start;
        gap: 6px;
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 4px;
        scrollbar-width: none;
    }

    .wc-pagination::-webkit-scrollbar{
        display: none;
    }

    .wc-pagination__item{
        flex: 0 0 auto;
        min-width: 36px;
        height: 36px;
        border-radius: 11px;
        padding: 0 10px;
        font-size: 12px;
    }
}

@media (max-width: 390px){
    .wc-container{
        padding-left: 10px !important;
        padding-right: 10px !important;
    }

    .wc-products-grid{
        gap: 8px !important;
    }

    .wc-product__image{
        height: 118px !important;
    }

    .wc-product__body{
        padding: 9px !important;
    }

    .wc-product__name{
        font-size: 12px !important;
    }

    .wc-product__sale{
        font-size: 14px !important;
    }

    .wc-product__btn{
        height: 32px !important;
        min-height: 32px !important;
        font-size: 11.5px !important;
    }
}
</style>

@endsection

@section('content')
<section class="wc-page">
    <div class="wc-container">
        <div class="wc-breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <span>/</span>
            <a href="{{ url('/') }}">Danh mục nổi bật</a>
            <span>/</span>
            <span>{{ $category->name }}</span>
        </div>

        <div class="wc-hero">
            <div class="wc-hero__grid">
                <div class="wc-hero__content">
                    <div class="wc-hero__eyebrow">Danh mục sản phẩm</div>

                    <h1 class="wc-hero__title">{{ $category->name }}</h1>

                    <p class="wc-hero__desc">
                        {{ $category->description ?: 'Khám phá các sản phẩm nổi bật trong danh mục này với thông tin rõ ràng, giá bán minh bạch và trải nghiệm mua sắm thuận tiện.' }}
                    </p>

                    <div class="wc-hero__meta">
                        <div class="wc-hero__meta-item">
                            <div class="wc-hero__meta-value">{{ number_format($products->total(), 0, ',', '.') }}</div>
                            <div class="wc-hero__meta-label">Sản phẩm hiển thị</div>
                        </div>

                        <div class="wc-hero__meta-item">
                            <div class="wc-hero__meta-value">{{ number_format($products->currentPage(), 0, ',', '.') }}</div>
                            <div class="wc-hero__meta-label">Trang hiện tại</div>
                        </div>
                    </div>
                </div>

                <div class="wc-hero__media">
                    <div class="wc-hero__image-card">
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="wc-layout">
            <div class="wc-main">
                <div class="wc-card wc-filter-card">
                    <div class="wc-filter-head">
                        <div>
                            <h2 class="wc-filter-title">Danh sách sản phẩm</h2>
                            <div class="wc-filter-desc">
                                Tìm kiếm nhanh, sắp xếp linh hoạt và lựa chọn sản phẩm phù hợp theo nhu cầu.
                            </div>
                        </div>

                        <div class="wc-filter-count">
                            {{ number_format($products->total(), 0, ',', '.') }} sản phẩm
                        </div>
                    </div>

                    <form method="GET" action="{{ route('website.category.show', $category->id) }}" class="wc-filter-form">
                        <input
                            type="text"
                            name="q"
                            class="wc-input"
                            placeholder="Tìm theo tên sản phẩm hoặc mã sản phẩm..."
                            value="{{ $search }}"
                        >

                        <select name="sort" class="wc-select" id="categorySort">
                            <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                            <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                            <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                            <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                        </select>

                        <button type="submit" class="wc-btn wc-btn--primary">Lọc sản phẩm</button>
                    </form>
                </div>

                @if($products->count() > 0)
                    <div class="wc-products-grid">
                        @foreach($products as $product)
                            <article class="wc-product">
                                <a href="{{ route('website.product-v1.show', $product->id) }}" class="wc-product__image">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->display_name }}" loading="lazy">
                                </a>

                                <div class="wc-product__body">
                                    <h3 class="wc-product__name">
                                        <a href="{{ route('website.product-v1.show', $product->id) }}">
                                            {{ $product->display_name }}
                                        </a>
                                    </h3>

                                    <div class="wc-product__desc">
                                        {{ $product->short_description ?: 'Đang cập nhật thông tin mô tả cho sản phẩm này.' }}
                                    </div>

                                    <div class="wc-product__price">
                                        <div class="wc-product__sale">
                                            {{ number_format((float) $product->display_price, 0, ',', '.') }}đ
                                            <span>/ sản phẩm</span>
                                        </div>

                                        @if(!empty($product->original_price))
                                            <div class="wc-product__origin">
                                                {{ number_format((float) $product->original_price, 0, ',', '.') }}đ
                                            </div>
                                        @endif
                                    </div>

                                    <a href="{{ route('website.product-v1.show', $product->id) }}" class="wc-product__btn">
                                        Chọn mua
                                    </a>
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

                        <div class="wc-pagination">
                            <a href="{{ $products->previousPageUrl() ?: 'javascript:void(0)' }}"
                               class="wc-pagination__item {{ $products->onFirstPage() ? 'is-disabled' : '' }}">
                                ‹
                            </a>

                            @if($start > 1)
                                <a href="{{ $products->url(1) }}" class="wc-pagination__item">1</a>
                                @if($start > 2)
                                    <span class="wc-pagination__item is-disabled">...</span>
                                @endif
                            @endif

                            @for($page = $start; $page <= $end; $page++)
                                <a href="{{ $products->url($page) }}"
                                   class="wc-pagination__item {{ $page === $currentPage ? 'is-active' : '' }}">
                                    {{ $page }}
                                </a>
                            @endfor

                            @if($end < $lastPage)
                                @if($end < $lastPage - 1)
                                    <span class="wc-pagination__item is-disabled">...</span>
                                @endif
                                <a href="{{ $products->url($lastPage) }}" class="wc-pagination__item">{{ $lastPage }}</a>
                            @endif

                            <a href="{{ $products->nextPageUrl() ?: 'javascript:void(0)' }}"
                               class="wc-pagination__item {{ $products->hasMorePages() ? '' : 'is-disabled' }}">
                                ›
                            </a>
                        </div>
                    @endif
                @else
                    <div class="wc-empty">
                        Không tìm thấy sản phẩm nào trong danh mục này.
                    </div>
                @endif
            </div>

            <aside class="wc-sidebar">
                <div class="wc-card wc-sidebar-card">
                    <div class="wc-sidebar-label">Thông tin danh mục</div>
                    <h3 class="wc-sidebar-title">{{ $category->name }}</h3>
                    <div class="wc-sidebar-text">
                        {{ $category->description ?: 'Danh mục này đang được cập nhật thêm thông tin mô tả chi tiết.' }}
                    </div>
                </div>

                <div class="wc-card wc-sidebar-card">
                    <div class="wc-sidebar-label">Danh mục liên quan</div>
                    <h3 class="wc-sidebar-title">Khám phá thêm</h3>

                    @if($relatedCategories->count() > 0)
                        <div class="wc-related-list">
                            @foreach($relatedCategories as $related)
                                <a href="{{ $related['url'] }}" class="wc-related-item">
                                    @if(!empty($related['image']))
                                        <img src="{{ $related['image'] }}" alt="{{ $related['name'] }}">
                                    @else
                                        <img src="{{ asset('images/no-image.png') }}" alt="{{ $related['name'] }}">
                                    @endif

                                    <div class="wc-related-item-name">
                                        {{ $related['name'] }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="wc-sidebar-text">
                            Chưa có danh mục liên quan để hiển thị.
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categorySort = document.getElementById('categorySort');

        if (categorySort) {
            categorySort.addEventListener('change', function () {
                this.form.submit();
            });
        }
    });
</script>
@endsection