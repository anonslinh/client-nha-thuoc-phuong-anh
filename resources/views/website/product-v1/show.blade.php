@extends('website.layout.index')

@section('style')
<style>
    .lc-product-detail-page{
        padding: 28px 0 40px;
        background: #f5f7fb;
    }

    .lc-container{
        width: min(1380px, calc(100% - 32px));
        margin: 0 auto;
    }

    .lc-breadcrumb{
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        font-size: 14px;
        color: #64748b;
        margin-bottom: 18px;
    }

    .lc-breadcrumb a{
        color: #2563eb;
        text-decoration: none;
    }

    .lc-breadcrumb a:hover{
        text-decoration: underline;
    }

    .lc-product-hero{
        display: grid;
        grid-template-columns: 1.02fr 0.98fr;
        gap: 24px;
        align-items: start;
        margin-bottom: 26px;
    }

    .lc-gallery-card,
    .lc-info-card,
    .lc-detail-card,
    .lc-related-card-wrap{
        background: #fff;
        border-radius: 26px;
        box-shadow: 0 14px 40px rgba(15, 23, 42, 0.06);
    }

    .lc-gallery-card{
        padding: 22px;
    }

    .lc-main-image-wrap{
        position: relative;
        width: 100%;
        min-height: 620px;
        border-radius: 22px;
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #eef2f7;
    }

    .lc-main-image-wrap.is-zooming{
        cursor: zoom-in;
    }

    .lc-main-image{
        width: 100%;
        height: 100%;
        max-height: 620px;
        object-fit: contain;
        transform-origin: center center;
        transition: transform .16s ease;
        will-change: transform;
        user-select: none;
        pointer-events: none;
    }

    .lc-main-image-wrap.is-zooming .lc-main-image{
        transform: scale(1.85);
    }

    .lc-zoom-note{
        position: absolute;
        right: 14px;
        bottom: 14px;
        background: rgba(15, 23, 42, 0.72);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        padding: 8px 12px;
        border-radius: 999px;
        pointer-events: none;
    }

    .lc-thumb-list{
        margin-top: 18px;
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding-bottom: 4px;
    }

    .lc-thumb-list::-webkit-scrollbar{
        height: 8px;
    }

    .lc-thumb-list::-webkit-scrollbar-thumb{
        background: #d9e3f2;
        border-radius: 999px;
    }

    .lc-thumb-item{
        width: 88px;
        height: 88px;
        flex: 0 0 88px;
        border-radius: 18px;
        border: 2px solid #e5eaf2;
        background: #fff;
        padding: 8px;
        cursor: pointer;
        overflow: hidden;
        transition: all .2s ease;
    }

    .lc-thumb-item:hover{
        border-color: #94b8ff;
        transform: translateY(-2px);
    }

    .lc-thumb-item.is-active{
        border-color: #2563eb;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.14);
    }

    .lc-thumb-item img{
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    .lc-gallery-caption{
        margin-top: 14px;
        font-size: 14px;
        color: #64748b;
    }

    .lc-info-card{
        padding: 24px 26px;
    }

    .lc-brand-row{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px 14px;
        margin-bottom: 12px;
    }

    .lc-brand-chip{
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #f8fbff;
        border: 1px solid #dce8ff;
        border-radius: 999px;
        padding: 8px 14px;
        font-size: 14px;
        color: #1e293b;
        font-weight: 700;
    }

    .lc-brand-chip img{
        width: 26px;
        height: 26px;
        border-radius: 50%;
        object-fit: cover;
        background: #fff;
    }

    .lc-product-title{
        margin: 0 0 10px;
        font-size: 40px;
        line-height: 1.2;
        font-weight: 800;
        color: #0f172a;
    }

    .lc-product-meta{
        display: flex;
        flex-wrap: wrap;
        gap: 8px 16px;
        font-size: 15px;
        color: #64748b;
        margin-bottom: 18px;
    }

    .lc-price-box{
        display: flex;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 10px 16px;
        margin-bottom: 18px;
    }

    .lc-price-sale{
        font-size: 52px;
        line-height: 1;
        font-weight: 900;
        color: #2563eb;
    }

    .lc-price-original{
        font-size: 22px;
        line-height: 1;
        font-weight: 700;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .lc-price-discount{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 34px;
        padding: 0 12px;
        border-radius: 10px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
        font-size: 16px;
        font-weight: 800;
    }

    .lc-flash-sale-pill{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        height: 34px;
        padding: 0 12px;
        border-radius: 999px;
        background: linear-gradient(135deg, #f97316 0%, #ef4444 100%);
        color: #fff;
        font-size: 15px;
        font-weight: 900;
        box-shadow: 0 10px 22px rgba(239, 68, 68, 0.18);
    }

    .lc-flash-sale-pill::before{
        content: "⚡";
        font-size: 15px;
        line-height: 1;
    }

    .lc-price-note{
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: -4px;
        font-size: 13px;
        color: #64748b;
        font-weight: 700;
    }

    .lc-price-note strong{
        color: #ef4444;
    }

    .lc-short-desc{
        font-size: 16px;
        line-height: 1.7;
        color: #334155;
        margin-bottom: 18px;
    }

    .lc-info-grid{
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 22px;
    }

    .lc-info-item{
        border: 1px solid #e8edf5;
        border-radius: 18px;
        padding: 14px 16px;
        background: #fafcff;
    }

    .lc-info-item-label{
        font-size: 13px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .lc-info-item-value{
        font-size: 16px;
        color: #0f172a;
        font-weight: 700;
        line-height: 1.5;
        word-break: break-word;
    }

    .lc-quantity-row{
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .lc-quantity-label{
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
    }

    .lc-quantity-box{
        display: inline-flex;
        align-items: center;
        height: 52px;
        border-radius: 999px;
        border: 1px solid #dbe4f0;
        overflow: hidden;
        background: #fff;
    }

    .lc-qty-btn{
        width: 52px;
        height: 52px;
        border: 0;
        background: #f8fafc;
        color: #0f172a;
        font-size: 28px;
        cursor: pointer;
    }

    .lc-qty-input{
        width: 72px;
        height: 52px;
        border: 0;
        text-align: center;
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        outline: none;
    }

    .lc-action-row{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 22px;
    }

    .lc-action-btn{
        min-height: 58px;
        border-radius: 999px;
        border: 0;
        cursor: pointer;
        font-size: 22px;
        font-weight: 800;
        transition: all .2s ease;
    }

    .lc-action-btn.primary{
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
        box-shadow: 0 14px 30px rgba(37, 99, 235, 0.22);
    }

    .lc-action-btn.secondary{
        background: #eaf1ff;
        color: #1d4ed8;
    }

    .lc-action-btn:hover{
        transform: translateY(-2px);
    }

    .lc-action-btn.is-loading{
        opacity: .7;
        pointer-events: none;
    }

    .lc-policy-list{
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .lc-policy-item{
        border-radius: 18px;
        padding: 14px;
        background: #f8fbff;
        border: 1px solid #e1ebff;
        color: #334155;
        font-size: 14px;
        line-height: 1.6;
        font-weight: 600;
    }

    .lc-detail-card{
        padding: 24px;
        margin-bottom: 26px;
    }

    .lc-detail-layout{
        display: grid;
        grid-template-columns: 260px minmax(0, 1fr);
        gap: 24px;
    }

    .lc-tab-nav{
        display: flex;
        flex-direction: column;
        gap: 10px;
        position: sticky;
        top: 18px;
    }

    .lc-tab-btn{
        width: 100%;
        text-align: left;
        border: 1px solid #e7edf6;
        background: #fff;
        border-radius: 18px;
        padding: 18px 18px;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        cursor: pointer;
        transition: all .2s ease;
    }

    .lc-tab-btn:hover{
        border-color: #cfe0ff;
        background: #f8fbff;
    }

    .lc-tab-btn.is-active{
        background: #eef4ff;
        border-color: #2563eb;
        color: #1d4ed8;
        box-shadow: 0 10px 24px rgba(37, 99, 235, 0.08);
    }

    .lc-tab-panel{
        display: none;
        animation: fadeIn .25s ease;
    }

    .lc-tab-panel.is-active{
        display: block;
    }

    @keyframes fadeIn{
        from{opacity:0; transform: translateY(4px);}
        to{opacity:1; transform: translateY(0);}
    }

    .lc-section-title{
        margin: 0 0 18px;
        font-size: 28px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-product-article{
        color: #1e293b;
        font-size: 17px;
        line-height: 1.9;
    }

    .lc-product-article *{
        max-width: 100%;
    }

    .lc-product-article p{
        margin: 0 0 16px;
    }

    .lc-product-article h1,
    .lc-product-article h2,
    .lc-product-article h3,
    .lc-product-article h4,
    .lc-product-article h5,
    .lc-product-article h6{
        color: #0f172a;
        margin: 22px 0 12px;
        line-height: 1.35;
        font-weight: 800;
    }

    .lc-product-article ul,
    .lc-product-article ol{
        padding-left: 22px;
        margin: 0 0 16px;
    }

    .lc-product-article li{
        margin-bottom: 8px;
    }

    .lc-product-article img{
        display: block;
        max-width: 100%;
        height: auto;
        border-radius: 18px;
        margin: 20px auto;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
    }

    .lc-product-article table{
        width: 100%;
        border-collapse: collapse;
        margin: 18px 0;
        overflow: hidden;
        border-radius: 18px;
        background: #fff;
        border: 1px solid #e8edf5;
    }

    .lc-product-article table th,
    .lc-product-article table td{
        border: 1px solid #e8edf5;
        padding: 12px 14px;
        text-align: left;
        vertical-align: top;
    }

    .lc-brand-panel{
        display: grid;
        grid-template-columns: 300px minmax(0, 1fr);
        gap: 22px;
        align-items: start;
    }

    .lc-brand-card{
        border: 1px solid #e9edf5;
        border-radius: 24px;
        padding: 18px;
        background: #fff;
    }

    .lc-brand-logo{
        width: 100%;
        height: 220px;
        object-fit: contain;
        background: #f8fbff;
        border-radius: 18px;
        border: 1px solid #edf2f7;
        display: block;
    }

    .lc-brand-name{
        margin: 16px 0 8px;
        font-size: 28px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-brand-desc{
        font-size: 16px;
        line-height: 1.8;
        color: #334155;
    }

    .lc-brand-banner{
        width: 100%;
        display: block;
        border-radius: 22px;
        margin-bottom: 16px;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
    }

    .lc-gallery-grid{
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .lc-gallery-grid-item{
        border-radius: 22px;
        overflow: hidden;
        border: 1px solid #edf2f7;
        background: #fff;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
    }

    .lc-gallery-grid-item img{
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: contain;
        display: block;
        background: #fff;
    }

    .lc-reviewer-card{
        display: flex;
        gap: 18px;
        align-items: flex-start;
        padding: 20px;
        border-radius: 24px;
        background: linear-gradient(135deg, #f4f8ff 0%, #ecfdf5 100%);
        border: 1px solid #dde8ff;
    }

    .lc-reviewer-avatar{
        width: 88px;
        height: 88px;
        border-radius: 50%;
        object-fit: cover;
        flex: 0 0 88px;
        background: #fff;
        border: 3px solid #fff;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
    }

    .lc-reviewer-name{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px 16px;
        margin-bottom: 10px;
    }

    .lc-reviewer-name h3{
        margin: 0;
        font-size: 28px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-reviewer-badge{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: #ecfdf5;
        color: #15803d;
        border: 1px solid #bbf7d0;
        font-size: 14px;
        font-weight: 800;
    }

    .lc-reviewer-text{
        font-size: 17px;
        line-height: 1.8;
        color: #334155;
        margin: 0;
    }

    .lc-related-card-wrap{
        padding: 24px;
    }

    .lc-related-head{
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: center;
        margin-bottom: 18px;
    }

    .lc-related-head h2{
        margin: 0;
        font-size: 34px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-related-arrows{
        display: flex;
        gap: 10px;
    }

    .lc-related-arrow{
        width: 46px;
        height: 46px;
        border-radius: 50%;
        border: 0;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 24px;
        font-weight: 900;
        cursor: pointer;
    }

    .lc-related-scroll{
        display: flex;
        gap: 18px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding-bottom: 8px;
    }

    .lc-related-scroll::-webkit-scrollbar{
        height: 8px;
    }

    .lc-related-scroll::-webkit-scrollbar-thumb{
        background: #d7e3f3;
        border-radius: 999px;
    }

    .lc-related-item{
        min-width: 300px;
        max-width: 300px;
        flex: 0 0 300px;
        border-radius: 24px;
        background: #fff;
        border: 1px solid #edf2f7;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        overflow: hidden;
        position: relative;
    }

    .lc-related-discount{
        position: absolute;
        top: 14px;
        right: 14px;
        z-index: 3;
        height: 34px;
        padding: 0 12px;
        border-radius: 12px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
        font-size: 16px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .lc-related-flash{
        position: absolute;
        top: 14px;
        left: 14px;
        z-index: 3;
        height: 34px;
        padding: 0 12px;
        border-radius: 12px;
        background: linear-gradient(135deg, #f97316 0%, #ef4444 100%);
        color: #fff;
        font-size: 14px;
        font-weight: 900;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 22px rgba(239, 68, 68, 0.18);
    }

    .lc-related-flash::before{
        content: "⚡";
        margin-right: 5px;
    }

    .lc-related-thumb{
        display: block;
        width: 100%;
        height: 280px;
        background: #fff;
        padding: 20px;
    }

    .lc-related-thumb img{
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    .lc-related-body{
        padding: 0 18px 20px;
    }

    .lc-related-brand{
        color: #64748b;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .lc-related-name{
        display: block;
        min-height: 88px;
        color: #0f172a;
        text-decoration: none;
        font-size: 20px;
        line-height: 1.45;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .lc-related-name:hover{
        color: #2563eb;
    }

    .lc-related-price{
        display: flex;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 8px 12px;
        margin-bottom: 16px;
    }

    .lc-related-price-sale{
        font-size: 20px;
        font-weight: 900;
        color: #2563eb;
    }

    .lc-related-price-original{
        font-size: 16px;
        font-weight: 700;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .lc-related-btn{
        width: 100%;
        min-height: 48px;
        border: 0;
        border-radius: 999px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
        font-size: 20px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lc-related-btn:hover{
        color: #fff;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .lc-cart-toast{
        position: fixed;
        right: 20px;
        bottom: 20px;
        z-index: 9999;
        min-width: 280px;
        max-width: 360px;
        padding: 14px 16px;
        border-radius: 16px;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        box-shadow: 0 16px 32px rgba(15, 23, 42, 0.18);
        transform: translateY(20px);
        opacity: 0;
        pointer-events: none;
        transition: all .25s ease;
    }

    .lc-cart-toast.show{
        transform: translateY(0);
        opacity: 1;
    }

    .lc-cart-toast.success{
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
    }

    .lc-cart-toast.error{
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    @media (max-width: 1200px){
        .lc-product-title{
            font-size: 34px;
        }

        .lc-price-sale{
            font-size: 42px;
        }
    }

    @media (max-width: 991px){
        .lc-product-hero{
            grid-template-columns: 1fr;
        }

        .lc-detail-layout{
            grid-template-columns: 1fr;
        }

        .lc-tab-nav{
            position: static;
            flex-direction: row;
            overflow-x: auto;
            padding-bottom: 6px;
        }

        .lc-tab-btn{
            min-width: 220px;
        }

        .lc-brand-panel{
            grid-template-columns: 1fr;
        }

        .lc-policy-list{
            grid-template-columns: 1fr;
        }

        .lc-main-image-wrap{
            min-height: 460px;
        }
    }

    @media (max-width: 767px){
        .lc-product-detail-page{
            padding: 12px 0 96px;
            background: #f5f7fb;
        }

        .lc-container{
            width: min(100%, calc(100% - 20px));
        }

        .lc-breadcrumb{
            font-size: 11px;
            gap: 5px;
            margin-bottom: 10px;
            flex-wrap: nowrap;
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .lc-breadcrumb::-webkit-scrollbar{
            display: none;
        }

        .lc-breadcrumb span:last-child{
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 160px;
            white-space: nowrap;
        }

        .lc-product-hero{
            gap: 10px;
            margin-bottom: 10px;
        }

        .lc-gallery-card,
        .lc-info-card,
        .lc-detail-card,
        .lc-related-card-wrap{
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }

        .lc-gallery-card{
            padding: 10px;
        }

        .lc-main-image-wrap{
            min-height: 0;
            aspect-ratio: 1 / 1;
            border-radius: 12px;
        }

        .lc-main-image{
            max-height: none;
        }

        .lc-main-image-wrap.is-zooming .lc-main-image{
            transform: none;
        }

        .lc-zoom-note{
            display: none;
        }

        .lc-thumb-list{
            margin-top: 8px;
            gap: 7px;
        }

        .lc-thumb-item{
            width: 50px;
            height: 50px;
            flex: 0 0 50px;
            border-radius: 10px;
            padding: 4px;
        }

        .lc-gallery-caption{
            margin-top: 8px;
            font-size: 11px;
        }

        .lc-info-card{
            padding: 14px;
        }

        .lc-brand-row{
            gap: 6px 8px;
            margin-bottom: 8px;
        }

        .lc-brand-chip{
            padding: 5px 10px;
            font-size: 11px;
            gap: 6px;
            border-radius: 999px;
        }

        .lc-brand-chip img{
            width: 18px;
            height: 18px;
        }

        .lc-product-title{
            font-size: 16px;
            line-height: 1.4;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .lc-product-meta{
            font-size: 11px;
            gap: 4px 10px;
            margin-bottom: 10px;
        }

        .lc-price-box{
            gap: 6px 10px;
            margin-bottom: 10px;
        }

        .lc-price-sale{
            font-size: 22px;
        }

        .lc-price-original{
            font-size: 13px;
        }

        .lc-price-discount{
            height: 22px;
            padding: 0 8px;
            font-size: 11px;
            border-radius: 6px;
        }

        .lc-flash-sale-pill{
            height: 22px;
            padding: 0 8px;
            font-size: 11px;
            gap: 5px;
        }

        .lc-flash-sale-pill::before{
            font-size: 12px;
        }

        .lc-price-note{
            font-size: 11px;
        }

        .lc-short-desc{
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .lc-info-grid{
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin-bottom: 14px;
        }

        .lc-info-item{
            padding: 9px 10px;
            border-radius: 12px;
        }

        .lc-info-item-label{
            font-size: 10.5px;
            margin-bottom: 3px;
        }

        .lc-info-item-value{
            font-size: 13px;
        }

        .lc-quantity-row{
            gap: 10px;
            margin-bottom: 14px;
        }

        .lc-quantity-label{
            font-size: 13px;
        }

        .lc-quantity-box{
            height: 38px;
        }

        .lc-qty-btn{
            width: 38px;
            height: 38px;
            font-size: 18px;
        }

        .lc-qty-input{
            width: 44px;
            height: 38px;
            font-size: 14px;
        }

        /* Thanh hành động dính cố định kiểu app mua sắm */
        .lc-action-row{
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 60;
            grid-template-columns: 1fr 1.4fr;
            gap: 8px;
            margin-bottom: 0;
            background: #fff;
            padding: 10px 14px calc(10px + env(safe-area-inset-bottom, 0px));
            box-shadow: 0 -8px 24px rgba(15, 23, 42, 0.10);
        }

        .lc-action-btn{
            min-height: 44px;
            font-size: 14px;
            border-radius: 14px;
        }

        .lc-policy-list{
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .lc-policy-item{
            font-size: 11.5px;
            padding: 10px 12px;
            border-radius: 12px;
            line-height: 1.5;
        }

        .lc-detail-card{
            padding: 14px;
            margin-bottom: 14px;
        }

        .lc-detail-layout{
            gap: 12px;
        }

        .lc-tab-nav{
            gap: 6px;
        }

        .lc-tab-btn{
            min-width: auto;
            padding: 9px 14px;
            font-size: 12.5px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .lc-section-title{
            font-size: 16px;
            margin-bottom: 10px;
        }

        .lc-product-article{
            font-size: 13px;
            line-height: 1.7;
        }

        .lc-product-article img{
            border-radius: 12px;
            margin: 12px auto;
        }

        .lc-product-article h1,
        .lc-product-article h2,
        .lc-product-article h3,
        .lc-product-article h4,
        .lc-product-article h5,
        .lc-product-article h6{
            font-size: 15px;
            margin: 16px 0 8px;
        }

        .lc-brand-panel{
            gap: 12px;
        }

        .lc-brand-card{
            padding: 12px;
            border-radius: 16px;
        }

        .lc-brand-logo{
            height: 120px;
            border-radius: 12px;
        }

        .lc-brand-name{
            font-size: 16px;
            margin: 10px 0 6px;
        }

        .lc-brand-desc{
            font-size: 13px;
            line-height: 1.6;
        }

        .lc-brand-banner{
            border-radius: 14px;
            margin-bottom: 10px;
        }

        .lc-gallery-grid{
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .lc-gallery-grid-item{
            border-radius: 14px;
        }

        .lc-reviewer-card{
            flex-direction: row;
            align-items: center;
            padding: 12px;
            border-radius: 16px;
            gap: 10px;
        }

        .lc-reviewer-avatar{
            width: 48px;
            height: 48px;
            flex: 0 0 48px;
            border-width: 2px;
        }

        .lc-reviewer-name{
            gap: 6px 8px;
            margin-bottom: 6px;
        }

        .lc-reviewer-name h3{
            font-size: 13px;
        }

        .lc-reviewer-badge{
            font-size: 10.5px;
            padding: 4px 9px;
        }

        .lc-reviewer-text{
            font-size: 12.5px;
            line-height: 1.6;
        }

        .lc-related-card-wrap{
            padding: 14px;
        }

        .lc-related-head{
            margin-bottom: 12px;
        }

        .lc-related-head h2{
            font-size: 16px;
        }

        .lc-related-arrows{
            display: none;
        }

        .lc-related-scroll{
            gap: 10px;
        }

        .lc-related-item{
            min-width: 132px;
            max-width: 132px;
            flex-basis: 132px;
            border-radius: 14px;
        }

        .lc-related-discount,
        .lc-related-flash{
            height: 20px;
            padding: 0 7px;
            font-size: 10px;
            border-radius: 7px;
            top: 8px;
        }

        .lc-related-discount{
            right: 8px;
        }

        .lc-related-flash{
            left: 8px;
        }

        .lc-related-thumb{
            height: 110px;
            padding: 10px;
        }

        .lc-related-body{
            padding: 0 10px 10px;
        }

        .lc-related-brand{
            font-size: 10px;
            margin-bottom: 4px;
        }

        .lc-related-name{
            font-size: 12px;
            line-height: 1.35;
            min-height: 48px;
            margin-bottom: 6px;
        }

        .lc-related-price{
            gap: 4px 8px;
            margin-bottom: 8px;
        }

        .lc-related-price-sale{
            font-size: 13px;
        }

        .lc-related-price-original{
            font-size: 10px;
        }

        .lc-related-btn{
            font-size: 12px;
            min-height: 32px;
        }

        .lc-cart-toast{
            left: 10px;
            right: 10px;
            bottom: 84px;
            min-width: auto;
            max-width: none;
        }
    }
</style>
@endsection

@section('content')
@php
    $productDisplayPrice = (float) ($product->display_price ?? 0);
    $productOriginalPrice = (float) ($product->original_price ?? 0);
    $productDiscountPercent = (int) ($product->discount_percent ?? 0);
    $productIsFlashSale = !empty($product->is_flash_sale);
@endphp

<section class="lc-product-detail-page">
    <div class="lc-container">
        <div class="lc-breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>

            @if(!empty($product->main_category_id))
                <span>/</span>
                <a href="{{ route('website.main-category-v1.show', ['id' => $product->main_category_id]) }}">
                    {{ $product->main_category_name }}
                </a>
            @endif

            @if(!empty($product->category_name))
                <span>/</span>
                <span>{{ $product->category_name }}</span>
            @endif

            <span>/</span>
            <span>{{ $product->name }}</span>
        </div>

        <div class="lc-product-hero">
            <div class="lc-gallery-card">
                <div class="lc-main-image-wrap" id="lcMainImageWrap">
                    <img
                        id="lcMainImage"
                        class="lc-main-image"
                        src="{{ $galleryImages->first()['src'] }}"
                        alt="{{ $product->name }}"
                    >
                    <div class="lc-zoom-note">Rê chuột để phóng to</div>
                </div>

                <div class="lc-thumb-list" id="lcThumbList">
                    @foreach($galleryImages as $index => $image)
                        <button
                            type="button"
                            class="lc-thumb-item {{ $index === 0 ? 'is-active' : '' }}"
                            data-image="{{ $image['src'] }}"
                            aria-label="Ảnh sản phẩm {{ $index + 1 }}"
                        >
                            <img src="{{ $image['src'] }}" alt="{{ $product->name }} {{ $index + 1 }}">
                        </button>
                    @endforeach
                </div>

                <div class="lc-gallery-caption">
                    Bộ ảnh sản phẩm gồm {{ $galleryImages->count() }} hình ảnh.
                </div>
            </div>

            <div class="lc-info-card">
                <div class="lc-brand-row">
                    @if(!empty($product->trademark_name))
                        <div class="lc-brand-chip">
                            <img src="{{ $product->trademark_image_url }}" alt="{{ $product->trademark_name }}">
                            <span>Thương hiệu: {{ $product->trademark_name }}</span>
                        </div>
                    @endif

                    @if(!empty($product->category_name))
                        <div class="lc-brand-chip">
                            <span>Danh mục: {{ $product->category_name }}</span>
                        </div>
                    @endif
                </div>

                <h1 class="lc-product-title">{{ $product->full_name ?: $product->name }}</h1>

                <div class="lc-product-meta">
                    <span>Mã sản phẩm: {{ $product->product_code }}</span>
                    @if(!empty($product->created_at))
                        <span>Cập nhật: {{ \Carbon\Carbon::parse($product->updated_at ?? $product->created_at)->format('d/m/Y') }}</span>
                    @endif
                </div>

                <div class="lc-price-box">
                    @if($productIsFlashSale)
                        <div class="lc-flash-sale-pill">Flash Sale</div>
                    @endif

                    <div class="lc-price-sale">
                        {{ number_format($productDisplayPrice, 0, ',', '.') }}đ
                    </div>

                    @if($productOriginalPrice > 0 && $productOriginalPrice > $productDisplayPrice)
                        <div class="lc-price-original">
                            {{ number_format($productOriginalPrice, 0, ',', '.') }}đ
                        </div>

                        @if($productDiscountPercent > 0)
                            <div class="lc-price-discount">
                                -{{ $productDiscountPercent }}%
                            </div>
                        @endif
                    @endif

                    @if($productIsFlashSale)
                        <div class="lc-price-note">
                            <span><strong>Giá Flash Sale</strong> đang được áp dụng cho sản phẩm này.</span>
                        </div>
                    @endif
                </div>

                <div class="lc-short-desc">
                    {!! !empty($product->description)
                        ? \Illuminate\Support\Str::limit(strip_tags($product->description), 280)
                        : 'Sản phẩm hiện đang được phân phối tại hệ thống Dược Phương Anh. Nội dung chi tiết, hình ảnh và thông tin thương hiệu được hiển thị bên dưới để khách hàng dễ dàng tra cứu.' !!}
                </div>

                <div class="lc-info-grid">
                    <div class="lc-info-item">
                        <div class="lc-info-item-label">Tên hiển thị</div>
                        <div class="lc-info-item-value">{{ $product->name }}</div>
                    </div>

                    <div class="lc-info-item">
                        <div class="lc-info-item-label">Thương hiệu</div>
                        <div class="lc-info-item-value">{{ $product->trademark_name ?: 'Đang cập nhật' }}</div>
                    </div>

                    <div class="lc-info-item">
                        <div class="lc-info-item-label">Danh mục</div>
                        <div class="lc-info-item-value">{{ $product->category_name ?: 'Đang cập nhật' }}</div>
                    </div>

                    <div class="lc-info-item">
                        <div class="lc-info-item-label">Trạng thái</div>
                        <div class="lc-info-item-value">
                            {{ (!is_null($product->is_active) && (int)$product->is_active === 1) ? 'Đang kinh doanh' : 'Đang cập nhật' }}
                        </div>
                    </div>
                </div>

                <div class="lc-quantity-row">
                    <div class="lc-quantity-label">Số lượng</div>

                    <div class="lc-quantity-box">
                        <button type="button" class="lc-qty-btn" id="lcQtyMinus">−</button>
                        <input type="text" id="lcQtyInput" class="lc-qty-input" value="1">
                        <button type="button" class="lc-qty-btn" id="lcQtyPlus">+</button>
                    </div>
                </div>

                <div class="lc-action-row">
                    <button
                        type="button"
                        class="lc-action-btn primary"
                        id="lcAddToCartBtn"
                        data-product-id="{{ $product->id }}"
                    >
                        Chọn mua
                    </button>

                    <button
                        type="button"
                        class="lc-action-btn secondary"
                        onclick="window.location.href='{{ url('/') }}'"
                    >
                        Tìm nhà thuốc
                    </button>
                </div>

                <div class="lc-policy-list">
                    <div class="lc-policy-item">
                        Hỗ trợ tư vấn sản phẩm nhanh chóng tại hệ thống Dược Phương Anh.
                    </div>
                    <div class="lc-policy-item">
                        Hình ảnh và mô tả được cập nhật giúp khách hàng tra cứu dễ dàng hơn.
                    </div>
                    <div class="lc-policy-item">
                        Có thể thay đổi bao bì theo lô hàng và đợt cập nhật từ nhà sản xuất.
                    </div>
                </div>
            </div>
        </div>

        <div class="lc-detail-card">
            <div class="lc-detail-layout">
                <div class="lc-tab-nav">
                    <button type="button" class="lc-tab-btn is-active" data-tab="description">Mô tả sản phẩm</button>
                    <button type="button" class="lc-tab-btn" data-tab="brand">Thông tin thương hiệu</button>
                    <button type="button" class="lc-tab-btn" data-tab="gallery">Hình ảnh sản phẩm</button>
                    <button type="button" class="lc-tab-btn" data-tab="reviewer">Kiểm duyệt nội dung</button>
                </div>

                <div class="lc-tab-content">
                    <div class="lc-tab-panel is-active" id="tab-description">
                        <h2 class="lc-section-title">Mô tả sản phẩm</h2>

                        <div class="lc-product-article">
                            {!! !empty($product->description)
                                ? $product->description
                                : '<p>Nội dung mô tả sản phẩm đang được cập nhật.</p>' !!}
                        </div>
                    </div>

                    <div class="lc-tab-panel" id="tab-brand">
                        <h2 class="lc-section-title">Thông tin thương hiệu</h2>

                        <div class="lc-brand-panel">
                            <div class="lc-brand-card">
                                <img
                                    src="{{ $product->trademark_image_url }}"
                                    alt="{{ $product->trademark_name ?: 'Thương hiệu' }}"
                                    class="lc-brand-logo"
                                >

                                <div class="lc-brand-name">
                                    {{ $product->trademark_name ?: 'Đang cập nhật thương hiệu' }}
                                </div>

                                <div class="lc-brand-desc">
                                    {!! !empty($product->trademark_description)
                                        ? nl2br(e($product->trademark_description))
                                        : 'Thông tin mô tả thương hiệu đang được cập nhật.' !!}
                                </div>
                            </div>

                            <div>
                                @if(!empty($product->trademark_banner))
                                    <img
                                        src="{{ $product->trademark_banner_url }}"
                                        alt="{{ $product->trademark_name }}"
                                        class="lc-brand-banner"
                                    >
                                @endif

                                <div class="lc-product-article">
                                    {!! !empty($product->trademark_note)
                                        ? nl2br(e($product->trademark_note))
                                        : '<p>Hiện chưa có ghi chú chi tiết thêm cho thương hiệu này.</p>' !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lc-tab-panel" id="tab-gallery">
                        <h2 class="lc-section-title">Hình ảnh sản phẩm</h2>

                        <div class="lc-gallery-grid">
                            @foreach($galleryImages as $image)
                                <div class="lc-gallery-grid-item">
                                    <img src="{{ $image['src'] }}" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="lc-tab-panel" id="tab-reviewer">
                        <h2 class="lc-section-title">Kiểm duyệt nội dung</h2>

                        <div class="lc-reviewer-card">
                            <img
                                class="lc-reviewer-avatar"
                                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=300&q=80"
                                alt="Dược sĩ Đại học Nguyễn Mỹ Huyền"
                            >

                            <div>
                                <div class="lc-reviewer-name">
                                    <h3>Dược sĩ Đại học Nguyễn Mỹ Huyền</h3>
                                    <div class="lc-reviewer-badge">Đã kiểm duyệt nội dung</div>
                                </div>

                                <p class="lc-reviewer-text">
                                    Dược sĩ Đại học có nhiều năm kinh nghiệm trong việc tư vấn Dược phẩm và hỗ trợ giải đáp
                                    thắc mắc về Bệnh học. Hiện đang là giảng viên cho Dược sĩ tại Dược Phương Anh.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($relatedProducts->count() > 0)
            <div class="lc-related-card-wrap">
                <div class="lc-related-head">
                    <h2>Sản phẩm liên quan</h2>

                    <div class="lc-related-arrows">
                        <button type="button" class="lc-related-arrow" id="lcRelatedPrev">‹</button>
                        <button type="button" class="lc-related-arrow" id="lcRelatedNext">›</button>
                    </div>
                </div>

                <div class="lc-related-scroll" id="lcRelatedScroll">
                    @foreach($relatedProducts as $item)
                        @php
                            $itemDisplayPrice = (float) ($item->display_price ?? 0);
                            $itemOriginalPrice = (float) ($item->original_price ?? 0);
                            $itemDiscountPercent = (int) ($item->discount_percent ?? 0);
                            $itemIsFlashSale = !empty($item->is_flash_sale);
                            $itemDetailUrl = $item->detail_url ?? route('website.product-v1.show', ['id' => $item->id]);
                        @endphp

                        <div class="lc-related-item">
                            @if($itemIsFlashSale)
                                <div class="lc-related-flash">Flash Sale</div>
                            @endif

                            @if($itemDiscountPercent > 0)
                                <div class="lc-related-discount">-{{ $itemDiscountPercent }}%</div>
                            @endif

                            <a href="{{ $itemDetailUrl }}" class="lc-related-thumb">
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                            </a>

                            <div class="lc-related-body">
                                <div class="lc-related-brand">{{ $item->trademark_name ?: 'Dược Phương Anh' }}</div>

                                <a href="{{ $itemDetailUrl }}" class="lc-related-name">
                                    {{ $item->name }}
                                </a>

                                <div class="lc-related-price">
                                    <div class="lc-related-price-sale">
                                        {{ number_format($itemDisplayPrice, 0, ',', '.') }}đ
                                    </div>

                                    @if($itemOriginalPrice > 0 && $itemOriginalPrice > $itemDisplayPrice)
                                        <div class="lc-related-price-original">
                                            {{ number_format($itemOriginalPrice, 0, ',', '.') }}đ
                                        </div>
                                    @endif
                                </div>

                                <a href="{{ $itemDetailUrl }}" class="lc-related-btn">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<script>
    (function () {
        const mainWrap = document.getElementById('lcMainImageWrap');
        const mainImage = document.getElementById('lcMainImage');
        const thumbItems = document.querySelectorAll('.lc-thumb-item');

        thumbItems.forEach((item) => {
            item.addEventListener('click', function () {
                const image = this.getAttribute('data-image');
                if (!image || !mainImage) return;

                mainImage.setAttribute('src', image);

                thumbItems.forEach((thumb) => thumb.classList.remove('is-active'));
                this.classList.add('is-active');
            });
        });

        if (mainWrap && mainImage) {
            mainWrap.addEventListener('mousemove', function (e) {
                const rect = mainWrap.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;

                mainImage.style.transformOrigin = x + '% ' + y + '%';
                mainWrap.classList.add('is-zooming');
            });

            mainWrap.addEventListener('mouseleave', function () {
                mainWrap.classList.remove('is-zooming');
                mainImage.style.transformOrigin = 'center center';
            });
        }

        const tabButtons = document.querySelectorAll('.lc-tab-btn');
        const tabPanels = document.querySelectorAll('.lc-tab-panel');

        tabButtons.forEach((button) => {
            button.addEventListener('click', function () {
                const tab = this.getAttribute('data-tab');

                tabButtons.forEach((btn) => btn.classList.remove('is-active'));
                tabPanels.forEach((panel) => panel.classList.remove('is-active'));

                this.classList.add('is-active');

                const target = document.getElementById('tab-' + tab);
                if (target) {
                    target.classList.add('is-active');
                }
            });
        });

        const qtyInput = document.getElementById('lcQtyInput');
        const qtyMinus = document.getElementById('lcQtyMinus');
        const qtyPlus = document.getElementById('lcQtyPlus');

        function normalizeQty() {
            if (!qtyInput) return 1;

            let value = parseInt(qtyInput.value, 10);
            if (isNaN(value) || value < 1) value = 1;
            if (value > 999) value = 999;
            qtyInput.value = value;

            return value;
        }

        if (qtyInput) {
            qtyInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '');
                normalizeQty();
            });
        }

        if (qtyMinus && qtyInput) {
            qtyMinus.addEventListener('click', function () {
                const value = normalizeQty();
                qtyInput.value = Math.max(1, value - 1);
            });
        }

        if (qtyPlus && qtyInput) {
            qtyPlus.addEventListener('click', function () {
                const value = normalizeQty();
                qtyInput.value = Math.min(999, value + 1);
            });
        }

        const relatedScroll = document.getElementById('lcRelatedScroll');
        const relatedPrev = document.getElementById('lcRelatedPrev');
        const relatedNext = document.getElementById('lcRelatedNext');

        if (relatedPrev && relatedScroll) {
            relatedPrev.addEventListener('click', function () {
                relatedScroll.scrollBy({
                    left: -340,
                    behavior: 'smooth'
                });
            });
        }

        if (relatedNext && relatedScroll) {
            relatedNext.addEventListener('click', function () {
                relatedScroll.scrollBy({
                    left: 340,
                    behavior: 'smooth'
                });
            });
        }
    })();

    const ADD_TO_CART_URL = @json(route('website.cart.add'));
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    function showCartToast(message, type = 'success') {
        let toast = document.getElementById('lcCartToast');

        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'lcCartToast';
            toast.className = 'lc-cart-toast';
            document.body.appendChild(toast);
        }

        toast.className = 'lc-cart-toast ' + type;
        toast.textContent = message;

        requestAnimationFrame(() => {
            toast.classList.add('show');
        });

        clearTimeout(window.__lcCartToastTimer);
        window.__lcCartToastTimer = setTimeout(() => {
            toast.classList.remove('show');
        }, 2200);
    }

    const addToCartBtn = document.getElementById('lcAddToCartBtn');

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', async function () {
            const productId = Number(this.getAttribute('data-product-id'));
            const qtyInput = document.getElementById('lcQtyInput');
            let quantity = qtyInput ? parseInt(qtyInput.value, 10) : 1;

            if (isNaN(quantity) || quantity < 1) quantity = 1;
            if (quantity > 999) quantity = 999;

            this.classList.add('is-loading');
            const oldText = this.innerText;
            this.innerText = 'Đang thêm...';

            try {
                const response = await fetch(ADD_TO_CART_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                });

                const result = await response.json();

                if (result.status) {
                    showCartToast(result.msg || 'Đã thêm sản phẩm vào giỏ hàng.', 'success');

                    setTimeout(() => {
                        window.location.href = @json(route('website.cart.index'));
                    }, 700);
                } else {
                    showCartToast(result.msg || 'Không thể thêm vào giỏ hàng.', 'error');
                }
            } catch (error) {
                showCartToast('Có lỗi xảy ra khi thêm vào giỏ hàng.', 'error');
            } finally {
                this.classList.remove('is-loading');
                this.innerText = oldText;
            }
        });
    }
</script>
@endsection