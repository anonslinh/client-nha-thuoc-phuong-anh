@once
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">
@endonce

@php
    $flashSaleSessions = collect(optional($flashSaleProducts)->sessions ?? []);
    $activeFlashSaleId = optional($flashSaleProducts)->active_session_id;
    $activeFlashSale = optional($flashSaleProducts)->active_session;
@endphp

@once
<style>
    :root{
        --pa-brand: #0c585c;
        --pa-brand-2: #0c8f75;
        --pa-brand-3: #12a6b5;
        --pa-text: #0f172a;
        --pa-muted: #64748b;
        --pa-soft: rgba(12, 88, 92, .07);
        --pa-border: #dbe7e5;
        --pa-orange: #ff5722;
        --pa-bg-soft: #eaf7f3;
    }

    #homeFlashSaleSection,
    #homeFlashSaleSection *{
        box-sizing: border-box;
    }

    #homeFlashSaleSection i{
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 400 !important;
        -webkit-text-stroke: 0 !important;
    }

    #homeFlashSaleSection .lc-flashsale-panel[hidden]{
        display: none !important;
    }

    #homeFlashSaleSection{
        position: relative;
        width: 100%;
        padding: 30px 0;
        margin: 0;
        overflow: hidden;
        background:
            radial-gradient(circle at 8% 12%, rgba(12, 143, 117, .16), transparent 28%),
            radial-gradient(circle at 92% 18%, rgba(18, 166, 181, .14), transparent 30%),
            linear-gradient(135deg, #eaf7f3 0%, #f3fffb 48%, #e8f8f6 100%) !important;
    }

    #homeFlashSaleSection::before{
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(90deg, rgba(12, 88, 92, .04), transparent 35%, rgba(12, 143, 117, .05));
        pointer-events: none;
    }

    #homeFlashSaleSection .lc-container{
        position: relative;
        z-index: 1;
    }

    #homeFlashSaleSection .lc-flashsale-box{
        position: relative;
        overflow: hidden;
        border-radius: 30px;
        padding: 26px 28px 28px;
        background:
            radial-gradient(circle at 12% -10%, rgba(12, 143, 117, .14), transparent 30%),
            radial-gradient(circle at 88% 0%, rgba(18, 166, 181, .10), transparent 28%),
            linear-gradient(180deg, #f2fffc 0%, #ffffff 58%) !important;
        border: 1px solid rgba(12, 88, 92, .10);
        box-shadow: 0 18px 44px rgba(12, 88, 92, .10);
    }

    #homeFlashSaleSection .lc-flashsale-box::before{
        content: "";
        position: absolute;
        right: -120px;
        top: -120px;
        width: 280px;
        height: 280px;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(18, 166, 181, .14), transparent 68%);
        pointer-events: none;
    }

    #homeFlashSaleSection .lc-flashsale-header{
        position: relative;
        z-index: 1;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 18px;
    }

    #homeFlashSaleSection .lc-flashsale-title-area{
        min-width: 0;
    }

    #homeFlashSaleSection .lc-flashsale-label-pill{
        width: fit-content;
        min-height: 34px;
        padding: 0 14px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(12, 143, 117, .08);
        border: 1px solid rgba(12, 143, 117, .16);
        color: var(--pa-brand-2);
        text-transform: uppercase;
        letter-spacing: .12em;
        font-size: 12px;
        font-weight: 800;
    }

    #homeFlashSaleSection .lc-flashsale-label-pill i{
        font-size: 15px;
    }

    #homeFlashSaleSection .lc-flashsale-title{
        margin: 14px 0 7px;
        color: #092f30;
        font-size: 34px;
        line-height: 1.12;
        font-weight: 850;
        letter-spacing: -.035em;
    }

    #homeFlashSaleSection .lc-flashsale-desc{
        margin: 0;
        color: #667879;
        font-size: 15px;
        line-height: 1.5;
        font-weight: 450;
    }

    #homeFlashSaleSection .lc-flashsale-countdown{
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        white-space: nowrap;
    }

    #homeFlashSaleSection .lc-flashsale-countdown-label{
        color: #667879;
        font-size: 14px;
        font-weight: 700;
    }

    #homeFlashSaleSection .lc-flashsale-timer{
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    #homeFlashSaleSection .lc-flashsale-timer-box{
        width: 44px;
        height: 38px;
        border-radius: 13px;
        background: var(--pa-brand);
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        line-height: 1;
        font-weight: 850;
        letter-spacing: .04em;
        box-shadow: 0 10px 22px rgba(12, 88, 92, .18);
    }

    #homeFlashSaleSection .lc-flashsale-timer-sep{
        color: var(--pa-brand);
        font-size: 18px;
        font-weight: 900;
        opacity: .75;
    }

    #homeFlashSaleSection .lc-flashsale-tabs{
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 10px;
        overflow-x: auto;
        scrollbar-width: none;
        padding: 0 0 16px;
        margin-bottom: 4px;
    }

    #homeFlashSaleSection .lc-flashsale-tabs::-webkit-scrollbar{
        display: none;
    }

    #homeFlashSaleSection .lc-flashsale-tab{
        flex: 0 0 auto;
        min-width: 138px;
        min-height: 56px;
        border-radius: 18px;
        border: 1px solid rgba(12, 88, 92, .11);
        background: rgba(255,255,255,.82);
        color: #0f172a;
        box-shadow: 0 10px 24px rgba(15,23,42,.045);
        display: grid;
        grid-template-columns: 1fr auto;
        grid-template-areas:
            "time status"
            "date status";
        align-items: center;
        gap: 2px 8px;
        padding: 10px 12px;
        cursor: pointer;
        text-align: left;
        transition: background .2s ease, border-color .2s ease, transform .2s ease, box-shadow .2s ease;
    }

    #homeFlashSaleSection .lc-flashsale-tab:hover{
        transform: translateY(-1px);
        border-color: rgba(12, 143, 117, .22);
    }

    #homeFlashSaleSection .lc-flashsale-tab--active{
        background: linear-gradient(135deg, rgba(12, 143, 117, .13), rgba(18, 166, 181, .08));
        border-color: rgba(12, 143, 117, .32);
        box-shadow: 0 14px 28px rgba(12, 88, 92, .08);
    }

    #homeFlashSaleSection .lc-flashsale-tab-time{
        grid-area: time;
        color: #083d3f;
        font-size: 14px;
        line-height: 1.2;
        font-weight: 800;
    }

    #homeFlashSaleSection .lc-flashsale-tab-date{
        grid-area: date;
        color: #64748b;
        font-size: 12px;
        line-height: 1.2;
        font-weight: 600;
    }

    #homeFlashSaleSection .lc-flashsale-tab-status{
        grid-area: status;
        min-height: 24px;
        padding: 0 8px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        line-height: 1;
        font-weight: 800;
        white-space: nowrap;
    }

    #homeFlashSaleSection .lc-flashsale-tab-status--active{
        background: rgba(12, 143, 117, .12);
        color: #08745f;
    }

    #homeFlashSaleSection .lc-flashsale-tab-status--upcoming{
        background: rgba(18, 166, 181, .12);
        color: #087b87;
    }

    #homeFlashSaleSection .lc-flashsale-tab-status--ended{
        background: #eef2f7;
        color: #667085;
    }

    #homeFlashSaleSection .lc-flashsale-products-wrap{
        position: relative;
        z-index: 1;
    }

    #homeFlashSaleSection .lc-flashsale-products{
        display: flex;
        gap: 16px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 2px 4px 10px;
        scrollbar-width: none;
    }

    #homeFlashSaleSection .lc-flashsale-products::-webkit-scrollbar{
        display: none;
    }

    #homeFlashSaleSection .lc-product-card--flash{
        position: relative;
        flex: 0 0 248px;
        min-height: 342px;
        border-radius: 22px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, .95);
        box-shadow: 0 12px 30px rgba(15, 23, 42, .065);
        display: flex;
        flex-direction: column;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    #homeFlashSaleSection .lc-product-card--flash:hover{
        transform: translateY(-3px);
        box-shadow: 0 18px 38px rgba(15, 23, 42, .10);
        border-color: rgba(12, 143, 117, .28);
    }

    #homeFlashSaleSection .lc-product-card--flash.is-sold-out{
        opacity: .72;
    }

    #homeFlashSaleSection .lc-product-discount-badge{
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 3;
        min-height: 28px;
        padding: 0 11px;
        border-radius: 999px;
        background: var(--pa-orange);
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 800;
        box-shadow: 0 8px 18px rgba(255, 87, 34, .20);
    }

    #homeFlashSaleSection .pa-flash-hot-badge{
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 3;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        min-height: 28px;
        padding: 0 10px;
        border-radius: 999px;
        background: rgba(15, 23, 42, .86);
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        backdrop-filter: blur(8px);
    }

    #homeFlashSaleSection .pa-flash-hot-badge i{
        font-size: 14px;
        animation: paFlashFlame .9s ease-in-out infinite;
    }

    #homeFlashSaleSection .pa-flash-hot-badge--soldout{
        background: rgba(100, 116, 139, .94);
    }

    #homeFlashSaleSection .lc-product-image-wrap{
        height: 132px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        text-decoration: none;
        border-bottom: 1px solid #edf2f7;
    }

    #homeFlashSaleSection .lc-product-image-wrap img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .25s ease;
    }

    #homeFlashSaleSection .lc-product-card--flash:hover .lc-product-image-wrap img{
        transform: scale(1.035);
    }

    #homeFlashSaleSection .lc-product-body{
        padding: 12px 13px 13px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    #homeFlashSaleSection .lc-product-name{
        margin: 0;
        min-height: 40px;
        color: var(--pa-text);
        font-size: 15px;
        line-height: 1.36;
        font-weight: 750;
    }

    #homeFlashSaleSection .lc-product-name a,
    #homeFlashSaleSection .lc-product-name span{
        color: inherit;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #homeFlashSaleSection .lc-product-name a:hover{
        color: var(--pa-brand);
        text-decoration: none;
    }

    #homeFlashSaleSection .lc-product-desc{
        margin: 6px 0 8px;
        min-height: 34px;
        color: #718081;
        font-size: 12px;
        line-height: 1.42;
        font-weight: 400;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #homeFlashSaleSection .lc-product-price-row{
        margin-top: auto;
        display: flex;
        align-items: baseline;
        gap: 7px;
        flex-wrap: wrap;
        min-height: 26px;
    }

    #homeFlashSaleSection .lc-product-price-sale{
        color: #007d68;
        font-size: 18px;
        line-height: 1.2;
        font-weight: 850;
        letter-spacing: -.015em;
    }

    #homeFlashSaleSection .lc-product-price-sale small{
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
    }

    #homeFlashSaleSection .lc-product-price-original{
        color: #94a3b8;
        font-size: 13px;
        line-height: 1.2;
        font-weight: 500;
        text-decoration: line-through;
    }

    #homeFlashSaleSection .lc-product-unit-pill{
        display: none;
    }

    #homeFlashSaleSection .pa-flash-stock{
        margin-top: 8px;
        padding: 0;
        border-radius: 0;
        background: transparent;
        border: 0;
    }

    #homeFlashSaleSection .pa-flash-stock-top{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 5px;
        font-size: 11px;
        line-height: 1.2;
        font-weight: 650;
    }

    #homeFlashSaleSection .pa-flash-stock-sold{
        color: #64748b;
    }

    #homeFlashSaleSection .pa-flash-stock-remain{
        color: #b54708;
    }

    #homeFlashSaleSection .pa-flash-progress{
        position: relative;
        height: 6px;
        border-radius: 999px;
        background: #e8f4f1;
        overflow: hidden;
    }

    #homeFlashSaleSection .pa-flash-progress-bar{
        position: absolute;
        inset: 0 auto 0 0;
        border-radius: inherit;
        background: linear-gradient(90deg, #0c8f75 0%, #12a6b5 100%);
    }

    #homeFlashSaleSection .pa-flash-progress-bar--hot{
        background: linear-gradient(90deg, #ff8a00 0%, #ff4d2d 60%, #ff174b 100%);
        box-shadow: 0 0 14px rgba(255, 102, 0, .35);
        animation: paFlashPulse 1.1s ease-in-out infinite;
    }

    #homeFlashSaleSection .pa-flash-fire{
        position: absolute;
        right: 4px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 11px;
        animation: paFlashFlame .9s ease-in-out infinite;
        filter: drop-shadow(0 0 8px rgba(255, 125, 0, .5));
    }

    #homeFlashSaleSection .lc-product-btn-buy{
        width: 100%;
        min-height: 38px;
        margin-top: 10px;
        border: 0;
        border-radius: 14px;
        background: rgba(12, 143, 117, .10) !important;
        color: var(--pa-brand);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        text-align: center;
        text-decoration: none;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        transition: transform .2s ease, background .2s ease, color .2s ease;
    }

    #homeFlashSaleSection .lc-product-btn-buy i{
        font-size: 16px;
    }

    #homeFlashSaleSection .lc-product-btn-buy:hover{
        color: #ffffff;
        background: linear-gradient(135deg, #0c8f75 0%, #0c585c 100%) !important;
        text-decoration: none;
        transform: translateY(-1px);
    }

    #homeFlashSaleSection .lc-product-btn-buy.is-disabled{
        background: #e2e8f0 !important;
        color: #64748b;
        pointer-events: none;
    }

    #homeFlashSaleSection .lc-flashsale-next{
        position: absolute;
        top: 50%;
        right: -14px;
        transform: translateY(-50%);
        z-index: 5;
        width: 46px;
        height: 46px;
        border-radius: 999px;
        border: 1px solid rgba(226, 232, 240, .95);
        background: rgba(255, 255, 255, .96);
        color: var(--pa-brand);
        box-shadow: 0 14px 30px rgba(15, 23, 42, .12);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    #homeFlashSaleSection .lc-flashsale-next i{
        font-size: 24px;
    }

    #homeFlashSaleSection .lc-flashsale-next:hover{
        background: var(--pa-brand);
        color: #ffffff;
        border-color: var(--pa-brand);
    }

    #homeFlashSaleSection .lc-flashsale-viewall{
        position: relative;
        z-index: 1;
        margin-top: 12px;
        display: flex;
        justify-content: center;
    }

    #homeFlashSaleSection .lc-flashsale-viewall a{
        min-height: 42px;
        padding: 0 18px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        background: #ffffff;
        border: 1px solid rgba(12, 88, 92, .14);
        color: var(--pa-brand);
        text-decoration: none;
        font-size: 14px;
        font-weight: 750;
        box-shadow: 0 10px 24px rgba(15, 23, 42, .05);
    }

    #homeFlashSaleSection .lc-flashsale-viewall a:hover{
        color: #ffffff;
        background: var(--pa-brand);
        border-color: var(--pa-brand);
        text-decoration: none;
    }

    #homeFlashSaleSection .lc-flashsale-empty{
        border-radius: 20px;
        background: #ffffff;
        border: 1px dashed #cbd5e1;
        padding: 24px;
        text-align: center;
        color: #64748b;
        font-weight: 600;
    }

    @keyframes paFlashPulse{
        0%, 100%{ filter: brightness(1); }
        50%{ filter: brightness(1.2); }
    }

    @keyframes paFlashFlame{
        0%, 100%{ transform: translateY(-50%) rotate(-4deg) scale(1); opacity: 1; }
        50%{ transform: translateY(-50%) rotate(4deg) scale(1.14); opacity: .92; }
    }

    @media (max-width: 991px){
        #homeFlashSaleSection{
            padding: 24px 0;
        }

        #homeFlashSaleSection .lc-flashsale-box{
            border-radius: 26px;
            padding: 24px 20px 26px;
        }

        #homeFlashSaleSection .lc-flashsale-header{
            align-items: flex-start;
        }

        #homeFlashSaleSection .lc-flashsale-title{
            font-size: 29px;
        }
    }

    @media (max-width: 767px){
        #homeFlashSaleSection{
            padding: 20px 0;
            overflow: hidden;
            background:
                radial-gradient(circle at 12% 5%, rgba(12, 143, 117, .18), transparent 32%),
                linear-gradient(135deg, #eaf7f3 0%, #f6fffc 52%, #e8f8f6 100%) !important;
        }

        #homeFlashSaleSection .lc-flashsale-box{
            border-radius: 24px;
            padding: 20px 0 20px 16px;
        }

        #homeFlashSaleSection .lc-flashsale-header{
            padding-right: 16px;
            display: block;
            margin-bottom: 16px;
        }

        #homeFlashSaleSection .lc-flashsale-label-pill{
            min-height: 30px;
            padding: 0 12px;
            font-size: 11px;
        }

        #homeFlashSaleSection .lc-flashsale-title{
            margin-top: 12px;
            font-size: 24px;
            line-height: 1.18;
        }

        #homeFlashSaleSection .lc-flashsale-desc{
            font-size: 13px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        #homeFlashSaleSection .lc-flashsale-countdown{
            margin-top: 14px;
            width: 100%;
            justify-content: space-between;
        }

        #homeFlashSaleSection .lc-flashsale-countdown-label{
            font-size: 13px;
        }

        #homeFlashSaleSection .lc-flashsale-timer{
            gap: 5px;
        }

        #homeFlashSaleSection .lc-flashsale-timer-box{
            width: 36px;
            height: 32px;
            border-radius: 11px;
            font-size: 14px;
        }

        #homeFlashSaleSection .lc-flashsale-timer-sep{
            font-size: 14px;
        }

        #homeFlashSaleSection .lc-flashsale-tabs{
            gap: 8px;
            padding-right: 16px;
            padding-bottom: 14px;
        }

        #homeFlashSaleSection .lc-flashsale-tab{
            min-width: 122px;
            min-height: 52px;
            border-radius: 16px;
            padding: 9px 10px;
        }

        #homeFlashSaleSection .lc-flashsale-tab-time{
            font-size: 13px;
        }

        #homeFlashSaleSection .lc-flashsale-tab-date{
            font-size: 11px;
        }

        #homeFlashSaleSection .lc-flashsale-tab-status{
            min-height: 22px;
            padding: 0 7px;
            font-size: 9px;
        }

        #homeFlashSaleSection .lc-flashsale-products{
            gap: 13px;
            padding: 2px 18px 10px 0;
            scroll-snap-type: x mandatory;
        }

        #homeFlashSaleSection .lc-product-card--flash{
            flex-basis: 168px;
            min-height: 300px;
            border-radius: 20px;
            scroll-snap-align: start;
        }

        #homeFlashSaleSection .lc-product-image-wrap{
            height: 108px;
        }

        #homeFlashSaleSection .lc-product-discount-badge,
        #homeFlashSaleSection .pa-flash-hot-badge{
            top: 8px;
            min-height: 23px;
            padding: 0 7px;
            font-size: 10px;
        }

        #homeFlashSaleSection .lc-product-discount-badge{
            left: 8px;
        }

        #homeFlashSaleSection .pa-flash-hot-badge{
            right: 8px;
        }

        #homeFlashSaleSection .pa-flash-hot-badge span:last-child{
            display: none;
        }

        #homeFlashSaleSection .lc-product-body{
            padding: 10px;
        }

        #homeFlashSaleSection .lc-product-name{
            min-height: 37px;
            font-size: 13px;
            line-height: 1.42;
            font-weight: 700;
        }

        #homeFlashSaleSection .lc-product-desc{
            margin: 5px 0 7px;
            min-height: 32px;
            font-size: 11.5px;
            line-height: 1.4;
        }

        #homeFlashSaleSection .lc-product-price-row{
            min-height: 23px;
            gap: 5px;
        }

        #homeFlashSaleSection .lc-product-price-sale{
            font-size: 15px;
        }

        #homeFlashSaleSection .lc-product-price-sale small{
            font-size: 10px;
        }

        #homeFlashSaleSection .lc-product-price-original{
            font-size: 11px;
        }

        #homeFlashSaleSection .pa-flash-stock-top{
            font-size: 10px;
        }

        #homeFlashSaleSection .lc-product-btn-buy{
            min-height: 35px;
            margin-top: 8px;
            border-radius: 13px;
            font-size: 12px;
            gap: 5px;
        }

        #homeFlashSaleSection .lc-product-btn-buy i{
            font-size: 15px;
        }

        #homeFlashSaleSection .lc-flashsale-next{
            display: none;
        }

        #homeFlashSaleSection .lc-flashsale-viewall{
            padding-right: 16px;
        }

        #homeFlashSaleSection .lc-flashsale-viewall a{
            width: 100%;
            min-height: 40px;
            font-size: 13px;
        }
    }
</style>
@endonce

<section class="lc-flashsale" aria-label="Flash Sale giá tốt" id="homeFlashSaleSection">
    <div class="lc-container">
        <div class="lc-flashsale-box">
            @if($flashSaleSessions->count() > 0)
                <div class="lc-flashsale-header">
                    <div class="lc-flashsale-title-area">
                        <div class="lc-flashsale-label-pill">
                            <i class="ri-flashlight-line" aria-hidden="true"></i>
                            <span>Flash Sale</span>
                        </div>

                        <h2 class="lc-flashsale-title">
                            Sản phẩm đang sale
                        </h2>

                        <p class="lc-flashsale-desc">
                            Các sản phẩm chăm sóc sức khỏe gia đình đang có ưu đãi tốt trong hôm nay.
                        </p>
                    </div>

                    <div class="lc-flashsale-countdown">
                        <div class="lc-flashsale-countdown-label" data-flashsale-label>
                            {{ $activeFlashSale && $activeFlashSale->status_key === 'upcoming' ? 'Bắt đầu sau' : 'Kết thúc sau' }}
                        </div>

                        <div class="lc-flashsale-timer">
                            <div class="lc-flashsale-timer-box" data-unit="hours">00</div>
                            <div class="lc-flashsale-timer-sep">:</div>
                            <div class="lc-flashsale-timer-box" data-unit="minutes">00</div>
                            <div class="lc-flashsale-timer-sep">:</div>
                            <div class="lc-flashsale-timer-box" data-unit="seconds">00</div>
                        </div>
                    </div>
                </div>

                <div class="lc-flashsale-tabs">
                    @foreach($flashSaleSessions as $session)
                        <button
                            class="lc-flashsale-tab {{ $activeFlashSaleId == $session->id ? 'lc-flashsale-tab--active' : '' }}"
                            type="button"
                            data-flashsale-tab="{{ $session->id }}"
                            data-status="{{ $session->status_key }}"
                            data-start-at="{{ $session->start_at_iso }}"
                            data-end-at="{{ $session->end_at_iso }}"
                        >
                            <span class="lc-flashsale-tab-time">{{ $session->time_label }}</span>
                            <span class="lc-flashsale-tab-date">{{ $session->date_label }}</span>
                            <span class="lc-flashsale-tab-status {{ $session->status_class }}">
                                {{ $session->status_label }}
                            </span>
                        </button>
                    @endforeach
                </div>

                @foreach($flashSaleSessions as $session)
                    <div
                        class="lc-flashsale-panel"
                        data-flashsale-panel="{{ $session->id }}"
                        @if($activeFlashSaleId != $session->id) hidden @endif
                    >
                        <div class="lc-flashsale-products-wrap">
                            <div class="lc-flashsale-products" data-flashsale-products>
                                @forelse($session->products as $product)
                                    @php
                                        $quantity = (int) ($product->quantity ?? 0);
                                        $sold = (int) ($product->sold ?? 0);
                                        $remaining = isset($product->remaining)
                                            ? (int) $product->remaining
                                            : max($quantity - $sold, 0);

                                        $progressPercent = isset($product->progress_percent)
                                            ? (int) $product->progress_percent
                                            : ($quantity > 0 ? min(100, round(($sold / $quantity) * 100)) : 0);

                                        $isHot = $quantity > 0 && $remaining > 0 && ($progressPercent >= 75 || $remaining <= 5);
                                        $isSoldOut = $quantity > 0 && $remaining <= 0;

                                        $productDescription = '';
                                        if (!empty($product->description)) {
                                            $productDescription = \Illuminate\Support\Str::limit(strip_tags($product->description), 82);
                                        }
                                    @endphp

                                    <article class="lc-product-card--flash {{ $isSoldOut ? 'is-sold-out' : '' }}">
                                        @if(!empty($product->discount_percent))
                                            <div class="lc-product-discount-badge">
                                                -{{ $product->discount_percent }}%
                                            </div>
                                        @endif

                                        @if($isSoldOut)
                                            <div class="pa-flash-hot-badge pa-flash-hot-badge--soldout">
                                                <i class="ri-close-circle-line" aria-hidden="true"></i>
                                                <span>Tạm hết</span>
                                            </div>
                                        @elseif($isHot)
                                            <div class="pa-flash-hot-badge">
                                                <i class="ri-fire-line" aria-hidden="true"></i>
                                                <span>Cháy hàng</span>
                                            </div>
                                        @endif

                                        <a href="{{ $product->product_url }}" class="lc-product-image-wrap">
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}" loading="lazy" />
                                        </a>

                                        <div class="lc-product-body">
                                            <h3 class="lc-product-name">
                                                <a href="{{ $product->product_url }}">
                                                    {{ $product->name }}
                                                </a>
                                            </h3>

                                            @if(!empty($productDescription))
                                                <p class="lc-product-desc">
                                                    {{ $productDescription }}
                                                </p>
                                            @else
                                                <p class="lc-product-desc">
                                                    Ưu đãi Flash Sale tại Nhà thuốc Phương Anh.
                                                </p>
                                            @endif

                                            <div class="lc-product-price-row">
                                                <div class="lc-product-price-sale">
                                                    @if(($product->flash_price ?? 0) > 0)
                                                        {{ number_format($product->flash_price, 0, ',', '.') }}đ
                                                    @else
                                                        Liên hệ
                                                    @endif

                                                    @if(!empty($product->unit_label))
                                                        <small>/ {{ $product->unit_label }}</small>
                                                    @endif
                                                </div>

                                                @if(($product->original_price ?? 0) > 0)
                                                    <div class="lc-product-price-original">
                                                        {{ number_format($product->original_price, 0, ',', '.') }}đ
                                                    </div>
                                                @endif

                                                @if(!empty($product->unit_label))
                                                    <div class="lc-product-unit-pill">
                                                        {{ $product->unit_label }}
                                                    </div>
                                                @endif
                                            </div>

                                            @if($quantity > 0)
                                                <div class="pa-flash-stock">
                                                    <div class="pa-flash-stock-top">
                                                        <div class="pa-flash-stock-sold">
                                                            Đã bán {{ number_format($sold, 0, ',', '.') }}
                                                        </div>

                                                        <div class="pa-flash-stock-remain">
                                                            @if($isSoldOut)
                                                                Hết hàng
                                                            @else
                                                                Còn {{ number_format($remaining, 0, ',', '.') }}
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="pa-flash-progress">
                                                        <div
                                                            class="pa-flash-progress-bar {{ $isHot ? 'pa-flash-progress-bar--hot' : '' }}"
                                                            style="width: {{ $progressPercent }}%;"
                                                        >
                                                            @if($isHot && !$isSoldOut)
                                                                <span class="pa-flash-fire">🔥</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <a
                                                href="{{ $product->product_url }}"
                                                class="lc-product-btn-buy {{ $isSoldOut ? 'is-disabled' : '' }}"
                                            >
                                                @if($isSoldOut)
                                                    <i class="ri-close-circle-line" aria-hidden="true"></i>
                                                    <span>Tạm hết hàng</span>
                                                @else
                                                    <i class="ri-shopping-cart-2-line" aria-hidden="true"></i>
                                                    <span>Chọn mua</span>
                                                @endif
                                            </a>
                                        </div>
                                    </article>
                                @empty
                                    <article class="lc-product-card--flash">
                                        <a href="javascript:void(0)" class="lc-product-image-wrap">
                                            <img src="{{ asset('phuonganh/img/fl1.jpg') }}" alt="Flash Sale" />
                                        </a>

                                        <div class="lc-product-body">
                                            <h3 class="lc-product-name">
                                                <span>Phiên flash sale này hiện chưa có sản phẩm</span>
                                            </h3>

                                            <p class="lc-product-desc">
                                                Vui lòng cập nhật thêm sản phẩm cho phiên sale.
                                            </p>

                                            <div class="lc-product-price-row">
                                                <div class="lc-product-price-sale">
                                                    Đang cập nhật
                                                </div>
                                            </div>

                                            <button class="lc-product-btn-buy is-disabled" type="button">
                                                <i class="ri-refresh-line" aria-hidden="true"></i>
                                                <span>Đang cập nhật</span>
                                            </button>
                                        </div>
                                    </article>
                                @endforelse
                            </div>

                            <button
                                class="lc-flashsale-next"
                                type="button"
                                data-flashsale-next
                                aria-label="Xem thêm sản phẩm flash sale"
                            >
                                <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                @endforeach

                <div class="lc-flashsale-viewall">
                    <a href="{{ route('website.flash-sale.index', ['session' => optional($flashSaleProducts)->active_session_id]) }}">
                        <span>Xem tất cả sản phẩm Flash Sale</span>
                        <i class="ri-arrow-right-line" aria-hidden="true"></i>
                    </a>
                </div>
            @else
                <div class="lc-flashsale-empty">
                    Hiện chưa có phiên Flash Sale nào.
                </div>
            @endif
        </div>
    </div>
</section>

@once
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
            countdownLabel.textContent = statusKey === 'upcoming'
                ? 'Bắt đầu sau'
                : 'Kết thúc sau';
        }

        function tick() {
            const now = new Date().getTime();
            const target = new Date(targetIso).getTime();
            let diff = Math.floor((target - now) / 1000);

            if (diff <= 0) {
                hoursEl.textContent = '00';
                minutesEl.textContent = '00';
                secondsEl.textContent = '00';

                if (timer) {
                    clearInterval(timer);
                    timer = null;
                }

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

            if (active) {
                activeTab = tab;
            }
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

            const card = slider.querySelector('.lc-product-card--flash');
            const gap = window.innerWidth <= 767 ? 13 : 16;
            const scrollAmount = card ? card.offsetWidth + gap : 264;

            slider.scrollBy({
                left: scrollAmount,
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
@endonce