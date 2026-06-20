@extends('website.layout.index')

@section('style')
<style>
    .lc-checkout-page{
        padding: 28px 0 40px;
        background: #f5f7fb;
    }

    .lc-container{
        width: min(1320px, calc(100% - 32px));
        margin: 0 auto;
    }

    .lc-checkout-head{
        margin-bottom: 20px;
    }

    .lc-checkout-title{
        margin: 0 0 8px;
        font-size: 34px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-checkout-sub{
        font-size: 15px;
        color: #64748b;
    }

    .lc-checkout-layout{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 390px;
        gap: 24px;
        align-items: start;
    }

    .lc-checkout-card,
    .lc-summary-card{
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
    }

    .lc-checkout-card{
        padding: 24px;
    }

    .lc-summary-card{
        padding: 22px;
        position: sticky;
        top: 20px;
    }

    .lc-block{
        margin-bottom: 24px;
    }

    .lc-block:last-child{
        margin-bottom: 0;
    }

    .lc-block-title{
        margin: 0 0 16px;
        font-size: 22px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-form-grid{
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .lc-form-group{
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .lc-form-group.full{
        grid-column: 1 / -1;
    }

    .lc-label{
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
    }

    .lc-input,
    .lc-select,
    .lc-textarea{
        width: 100%;
        min-height: 48px;
        border-radius: 14px;
        border: 1px solid #dbe4f0;
        background: #fff;
        padding: 0 14px;
        font-size: 15px;
        color: #0f172a;
        outline: none;
    }

    .lc-textarea{
        min-height: 110px;
        padding: 12px 14px;
        resize: vertical;
    }

    .lc-input:focus,
    .lc-select:focus,
    .lc-textarea:focus{
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
    }

    .lc-radio-grid{
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .lc-radio-card{
        position: relative;
    }

    .lc-radio-card input{
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .lc-radio-card-label{
        display: block;
        border: 1px solid #dbe4f0;
        border-radius: 18px;
        padding: 16px;
        cursor: pointer;
        transition: all .2s ease;
        min-height: 100%;
    }

    .lc-radio-card input:checked + .lc-radio-card-label{
        border-color: #2563eb;
        background: #eff6ff;
        box-shadow: 0 10px 22px rgba(37, 99, 235, 0.08);
    }

    .lc-radio-title{
        display: block;
        font-size: 16px;
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .lc-radio-desc{
        font-size: 13px;
        line-height: 1.6;
        color: #64748b;
    }

    .lc-hidden-block{
        display: none;
    }

    .lc-hidden-block.show{
        display: block;
    }

    .lc-error-text{
        font-size: 13px;
        color: #dc2626;
        font-weight: 700;
    }

    .lc-alert{
        border-radius: 16px;
        padding: 14px 16px;
        margin-bottom: 18px;
        font-size: 14px;
        font-weight: 700;
    }

    .lc-alert-danger{
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .lc-summary-title{
        margin: 0 0 16px;
        font-size: 24px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-summary-list{
        display: grid;
        gap: 12px;
        margin-bottom: 18px;
    }

    .lc-summary-item{
        display: grid;
        grid-template-columns: 64px minmax(0, 1fr);
        gap: 12px;
        align-items: start;
        padding: 12px;
        border-radius: 16px;
        border: 1px solid #edf2f7;
        background: #fff;
    }

    .lc-summary-item-thumb{
        width: 64px;
        height: 64px;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #edf2f7;
        background: #fff;
    }

    .lc-summary-item-thumb img{
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .lc-summary-item-name{
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.5;
        margin-bottom: 4px;
    }

    .lc-summary-item-meta{
        font-size: 13px;
        color: #64748b;
        line-height: 1.6;
    }

    .lc-summary-row{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px dashed #e2e8f0;
        color: #334155;
        font-size: 15px;
    }

    .lc-summary-total{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-top: 18px;
        margin-top: 8px;
    }

    .lc-summary-total span:first-child{
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
    }

    .lc-summary-total span:last-child{
        font-size: 30px;
        font-weight: 900;
        color: #2563eb;
    }

    .lc-submit-btn{
        width: 100%;
        min-height: 54px;
        border: 0;
        border-radius: 999px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
        font-size: 18px;
        font-weight: 900;
        cursor: pointer;
        margin-top: 18px;
        box-shadow: 0 14px 28px rgba(37, 99, 235, 0.2);
    }

    .lc-back-link{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        padding: 0 18px;
        border-radius: 999px;
        background: #eff6ff;
        color: #1d4ed8;
        text-decoration: none;
        font-size: 15px;
        font-weight: 800;
        margin-top: 12px;
    }

    @media (max-width: 991px){
        .lc-checkout-layout{
            grid-template-columns: 1fr;
        }

        .lc-summary-card{
            position: static;
        }
    }

    @media (max-width: 767px){
        .lc-checkout-page{
            padding: 18px 0 28px;
        }

        .lc-container{
            width: min(100%, calc(100% - 20px));
        }

        .lc-checkout-title{
            font-size: 26px;
        }

        .lc-form-grid,
        .lc-radio-grid{
            grid-template-columns: 1fr;
        }
    }

    .lc-checkout-page{
        --pa-checkout-ink: #0b2430;
        --pa-checkout-deep: #073f45;
        --pa-checkout-teal: #0f8b7c;
        --pa-checkout-teal-2: #0a6466;
        --pa-checkout-mint: #e8f7f1;
        --pa-checkout-line: rgba(9, 47, 48, .12);
        background:
            radial-gradient(circle at 12% 0%, rgba(15,139,124,.08), transparent 28%),
            linear-gradient(180deg, #f4faf8 0%, #ffffff 46%, #f4faf8 100%) !important;
        overflow-x: hidden;
    }

    .lc-checkout-page,
    .lc-checkout-page *{
        box-sizing: border-box;
    }

    .lc-checkout-title,
    .lc-block-title,
    .lc-label,
    .lc-radio-title,
    .lc-summary-title,
    .lc-summary-item-name,
    .lc-summary-total span:first-child{
        color: var(--pa-checkout-ink) !important;
    }

    .lc-checkout-card,
    .lc-summary-card{
        border: 1px solid var(--pa-checkout-line);
        box-shadow: 0 18px 42px rgba(9,47,48,.08) !important;
    }

    .lc-input,
    .lc-select,
    .lc-textarea,
    .lc-radio-card-label,
    .lc-summary-item,
    .lc-summary-item-thumb{
        border-color: var(--pa-checkout-line) !important;
    }

    .lc-input,
    .lc-select,
    .lc-textarea{
        color: var(--pa-checkout-ink) !important;
    }

    .lc-input:focus,
    .lc-select:focus,
    .lc-textarea:focus{
        border-color: rgba(15,139,124,.42) !important;
        box-shadow: 0 0 0 3px rgba(15,139,124,.12) !important;
    }

    .lc-radio-card input:checked + .lc-radio-card-label{
        border-color: rgba(15,139,124,.46) !important;
        background: var(--pa-checkout-mint) !important;
        box-shadow: 0 10px 22px rgba(9,47,48,.08) !important;
    }

    .lc-summary-item-thumb{
        background:
            radial-gradient(circle at 50% 45%, #ffffff 0%, #f5fbfb 58%, #edf7f4 100%) !important;
    }

    .lc-summary-row{
        border-bottom-color: rgba(9,47,48,.12) !important;
    }

    .lc-summary-total span:last-child{
        color: var(--pa-checkout-teal) !important;
    }

    .lc-submit-btn{
        background: linear-gradient(135deg, var(--pa-checkout-teal), var(--pa-checkout-deep)) !important;
        box-shadow: 0 14px 28px rgba(9,47,48,.18) !important;
    }

    .lc-back-link{
        background: var(--pa-checkout-mint) !important;
        color: var(--pa-checkout-deep) !important;
    }

    @media (max-width: 767px){
        .lc-checkout-page .lc-container{
            width: min(calc(100vw - 24px), 366px) !important;
            max-width: min(calc(100vw - 24px), 366px) !important;
            margin-left: 12px !important;
            margin-right: 12px !important;
            overflow: hidden;
        }

        .lc-checkout-head{
            margin-bottom: 14px !important;
        }

        .lc-checkout-title{
            font-size: 19px !important;
            line-height: 1.2 !important;
        }

        .lc-checkout-sub{
            font-size: 11.5px !important;
            line-height: 1.5 !important;
        }

        .lc-checkout-layout{
            gap: 10px !important;
        }

        .lc-checkout-card,
        .lc-summary-card{
            padding: 12px !important;
            border-radius: 16px !important;
        }

        .lc-block{
            margin-bottom: 14px !important;
        }

        .lc-block-title{
            margin-bottom: 8px !important;
            font-size: 14px !important;
            line-height: 1.3 !important;
        }

        .lc-form-grid,
        .lc-radio-grid{
            gap: 8px !important;
        }

        .lc-form-group{
            gap: 5px !important;
        }

        .lc-label{
            font-size: 11px !important;
        }

        .lc-input,
        .lc-select{
            min-height: 36px !important;
            border-radius: 10px !important;
            padding: 0 10px !important;
            font-size: 12px !important;
        }

        .lc-textarea{
            min-height: 68px !important;
            border-radius: 10px !important;
            padding: 8px 10px !important;
            font-size: 12px !important;
        }

        .lc-email-field{
            display: none !important;
        }

        .lc-radio-card-label{
            padding: 9px !important;
            border-radius: 12px !important;
        }

        .lc-radio-title{
            font-size: 12.5px !important;
        }

        .lc-radio-desc{
            font-size: 10.5px !important;
            line-height: 1.4 !important;
        }

        .lc-summary-title{
            margin-bottom: 8px !important;
            font-size: 15px !important;
        }

        .lc-summary-list{
            gap: 6px !important;
            margin-bottom: 10px !important;
        }

        .lc-summary-item{
            grid-template-columns: 44px minmax(0, 1fr) !important;
            gap: 7px !important;
            padding: 7px !important;
            border-radius: 12px !important;
        }

        .lc-summary-item-thumb{
            width: 44px !important;
            height: 44px !important;
            border-radius: 9px !important;
        }

        .lc-summary-item-name{
            font-size: 11.5px !important;
            line-height: 1.35 !important;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .lc-summary-item-meta{
            font-size: 10.5px !important;
            line-height: 1.4 !important;
        }

        .lc-summary-row{
            padding: 7px 0 !important;
            font-size: 11.5px !important;
        }

        .lc-summary-total{
            padding-top: 10px !important;
        }

        .lc-summary-total span:first-child{
            font-size: 13px !important;
        }

        .lc-summary-total span:last-child{
            font-size: 18px !important;
        }

        .lc-voucher-trigger{
            padding: 9px 11px !important;
            font-size: 11.5px !important;
            border-radius: 11px !important;
        }

        .lc-voucher-trigger-icon,
        .lc-voucher-trigger-arrow{
            font-size: 16px !important;
        }

        .lc-submit-btn{
            min-height: 40px !important;
            margin-top: 12px !important;
            font-size: 12.5px !important;
        }

        .lc-back-link{
            width: 100%;
            min-height: 36px !important;
            margin-top: 8px !important;
            font-size: 11.5px !important;
        }
    }

    /* ===== Giảm giá / Voucher ===== */
    .lc-summary-row-saving span,
    .lc-summary-row-saving strong{
        color: #16a34a;
        font-weight: 800;
    }

    .lc-voucher-trigger-wrap{
        padding: 4px 0 12px;
        border-bottom: 1px dashed #e2e8f0;
        margin-bottom: 4px;
    }

    .lc-voucher-trigger{
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px dashed #93c5fd;
        background: #eff6ff;
        border-radius: 14px;
        padding: 12px 14px;
        cursor: pointer;
        color: #1d4ed8;
        font-weight: 700;
        font-size: 14px;
    }

    .lc-voucher-trigger-icon{
        font-size: 20px;
        line-height: 1;
        flex: 0 0 auto;
    }

    .lc-voucher-trigger-text{
        flex: 1;
        text-align: left;
    }

    .lc-voucher-trigger-arrow{
        font-size: 20px;
        line-height: 1;
        flex: 0 0 auto;
    }

    /* ===== Popup voucher / mã giảm giá (dùng chung mobile + desktop) ===== */
    .lc-voucher-popup{
        position: fixed;
        inset: 0;
        z-index: 10060;
        display: none;
    }

    .lc-voucher-popup.show{
        display: block;
    }

    .lc-voucher-popup-backdrop{
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, .5);
        backdrop-filter: blur(2px);
    }

    .lc-voucher-popup-dialog{
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%) scale(.96);
        opacity: 0;
        width: min(520px, calc(100% - 32px));
        max-height: min(86vh, 640px);
        background: #fff;
        border-radius: 24px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(15, 23, 42, .28);
        transition: transform .22s ease, opacity .22s ease;
    }

    .lc-voucher-popup.show .lc-voucher-popup-dialog{
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }

    .lc-voucher-popup-head{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 18px 20px;
        border-bottom: 1px solid #eef2f7;
    }

    .lc-voucher-popup-head h3{
        margin: 0;
        font-size: 18px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-voucher-popup-close{
        width: 36px;
        height: 36px;
        border: 0;
        border-radius: 50%;
        background: #f1f5f9;
        color: #0f172a;
        font-size: 18px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
    }

    .lc-voucher-popup-body{
        padding: 16px 20px;
        overflow-y: auto;
        flex: 1;
    }

    .lc-voucher-tabs{
        display: flex;
        gap: 8px;
        background: #f1f5f9;
        border-radius: 999px;
        padding: 4px;
        margin-bottom: 16px;
    }

    .lc-voucher-tab{
        flex: 1;
        border: 0;
        background: transparent;
        border-radius: 999px;
        padding: 9px 10px;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
    }

    .lc-voucher-tab.is-active{
        background: #fff;
        color: #1d4ed8;
        box-shadow: 0 6px 14px rgba(15, 23, 42, .08);
    }

    .lc-voucher-tab-panel{
        display: none;
    }

    .lc-voucher-tab-panel.is-active{
        display: block;
    }

    .lc-voucher-item{
        display: flex;
        align-items: flex-start;
        gap: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 14px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: border-color .15s ease, background .15s ease;
    }

    .lc-voucher-item:hover{
        border-color: #93c5fd;
    }

    .lc-voucher-item.is-active{
        border-color: #2563eb;
        background: #eff6ff;
    }

    .lc-voucher-item input[type="radio"]{
        margin-top: 4px;
        flex: 0 0 auto;
    }

    .lc-voucher-item-icon{
        width: 36px;
        height: 36px;
        border-radius: 12px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex: 0 0 auto;
    }

    .lc-voucher-item-body{
        flex: 1;
        min-width: 0;
    }

    .lc-voucher-item-title{
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .lc-voucher-item-value{
        font-size: 13px;
        color: #2563eb;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .lc-voucher-item-condition{
        font-size: 12px;
        color: #64748b;
    }

    .lc-voucher-empty{
        text-align: center;
        color: #94a3b8;
        font-size: 14px;
        padding: 30px 10px;
    }

    .lc-voucher-coupon-label{
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
    }

    .lc-voucher-coupon-row{
        display: flex;
        gap: 8px;
    }

    .lc-voucher-coupon-input{
        flex: 1;
        min-width: 0;
        height: 46px;
        border: 1px solid #dbe4f0;
        border-radius: 12px;
        padding: 0 14px;
        font-size: 14px;
        text-transform: uppercase;
        outline: none;
    }

    .lc-voucher-coupon-input:focus{
        border-color: #2563eb;
    }

    .lc-voucher-coupon-apply{
        height: 46px;
        padding: 0 18px;
        border: 0;
        border-radius: 12px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
        font-weight: 800;
        font-size: 14px;
        cursor: pointer;
        flex: 0 0 auto;
    }

    .lc-voucher-coupon-msg{
        margin-top: 10px;
        font-size: 13px;
        font-weight: 700;
        min-height: 18px;
    }

    .lc-voucher-coupon-msg.success{
        color: #16a34a;
    }

    .lc-voucher-coupon-msg.error{
        color: #dc2626;
    }

    .lc-voucher-popup-foot{
        display: flex;
        gap: 10px;
        padding: 16px 20px;
        border-top: 1px solid #eef2f7;
    }

    .lc-voucher-btn{
        flex: 1;
        min-height: 46px;
        border-radius: 999px;
        border: 0;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
    }

    .lc-voucher-btn-primary{
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
    }

    .lc-voucher-btn-outline{
        background: #f1f5f9;
        color: #475569;
        flex: 0 0 auto;
        padding: 0 18px;
    }

    @media (max-width: 600px){
        .lc-voucher-popup-dialog{
            left: 50%;
            top: auto;
            bottom: 0;
            transform: translate(-50%, 100%);
            width: 100%;
            max-height: 80vh;
            border-radius: 22px 22px 0 0;
        }

        .lc-voucher-popup.show .lc-voucher-popup-dialog{
            transform: translate(-50%, 0);
        }

        .lc-voucher-popup-head{
            padding: 14px 16px !important;
        }

        .lc-voucher-popup-head h3{
            font-size: 15px !important;
        }

        .lc-voucher-popup-close{
            width: 30px !important;
            height: 30px !important;
            font-size: 15px !important;
        }

        .lc-voucher-popup-body{
            padding: 12px 16px !important;
        }

        .lc-voucher-tab{
            font-size: 11.5px !important;
            padding: 8px 8px !important;
        }

        .lc-voucher-item{
            padding: 10px !important;
            gap: 9px !important;
            border-radius: 13px !important;
        }

        .lc-voucher-item-icon{
            width: 30px !important;
            height: 30px !important;
            font-size: 14px !important;
            border-radius: 10px !important;
        }

        .lc-voucher-item-title{
            font-size: 12.5px !important;
        }

        .lc-voucher-item-value{
            font-size: 11.5px !important;
        }

        .lc-voucher-item-condition{
            font-size: 10.5px !important;
        }

        .lc-voucher-coupon-label{
            font-size: 11.5px !important;
        }

        .lc-voucher-coupon-input,
        .lc-voucher-coupon-apply{
            height: 38px !important;
            font-size: 12px !important;
        }

        .lc-voucher-coupon-msg{
            font-size: 11.5px !important;
        }

        .lc-voucher-popup-foot{
            padding: 12px 16px !important;
        }

        .lc-voucher-btn{
            min-height: 38px !important;
            font-size: 12px !important;
        }
    }
</style>
@endsection

@section('content')
<section class="lc-checkout-page">
    <div class="lc-container">
        <div class="lc-checkout-head">
            <h1 class="lc-checkout-title">Thông tin đặt hàng</h1>
            <div class="lc-checkout-sub">Vui lòng điền đầy đủ thông tin để Dược Phương Anh tiếp nhận và xử lý đơn hàng.</div>
        </div>

        <form action="{{ route('website.checkout.store') }}" method="POST">
            @csrf

            <div class="lc-checkout-layout">
                <div class="lc-checkout-card">
                    @if(session('error'))
                        <div class="lc-alert lc-alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="lc-block">
    <h2 class="lc-block-title">Thông tin khách hàng</h2>

    <div class="lc-form-grid">
        <div class="lc-form-group">
            <label class="lc-label">Họ và tên *</label>
            <input
                type="text"
                name="customer_name"
                class="lc-input"
                value="{{ old('customer_name', $guestCheckoutInfo['customer_name'] ?? '') }}"
            >
            @error('customer_name') <div class="lc-error-text">{{ $message }}</div> @enderror
        </div>

        <div class="lc-form-group">
            <label class="lc-label">Số điện thoại *</label>
            <input
                type="text"
                name="customer_phone"
                class="lc-input"
                value="{{ old('customer_phone', $guestCheckoutInfo['customer_phone'] ?? '') }}"
            >
            @error('customer_phone') <div class="lc-error-text">{{ $message }}</div> @enderror
        </div>

        <div class="lc-form-group full lc-email-field">
            <label class="lc-label">Email</label>
            <input
                type="text"
                name="customer_email"
                class="lc-input"
                value="{{ old('customer_email', $guestCheckoutInfo['customer_email'] ?? '') }}"
            >
            @error('customer_email') <div class="lc-error-text">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

<div class="lc-block">
    <h2 class="lc-block-title">Hình thức nhận hàng</h2>

    <div class="lc-radio-grid">
        <label class="lc-radio-card">
            <input type="radio" name="receive_type" value="1" {{ old('receive_type', '1') == '1' ? 'checked' : '' }}>
            <span class="lc-radio-card-label">
                <span class="lc-radio-title">Giao tận nơi</span>
                <span class="lc-radio-desc">Khách nhập đầy đủ địa chỉ giao hàng để nhà thuốc xử lý đơn.</span>
            </span>
        </label>

        <label class="lc-radio-card">
            <input type="radio" name="receive_type" value="2" {{ old('receive_type') == '2' ? 'checked' : '' }}>
            <span class="lc-radio-card-label">
                <span class="lc-radio-title">Nhận tại nhà thuốc</span>
                <span class="lc-radio-desc">Khách chọn chi nhánh đến nhận, phù hợp cho đơn cần lấy nhanh.</span>
            </span>
        </label>
    </div>
    @error('receive_type') <div class="lc-error-text" style="margin-top:8px;">{{ $message }}</div> @enderror
</div>

<div class="lc-block lc-hidden-block {{ old('receive_type', '1') == '1' ? 'show' : '' }}" id="lcDeliveryBlock">
    <h2 class="lc-block-title">Địa chỉ giao hàng</h2>

    <div class="lc-form-grid">
        <div class="lc-form-group">
            <label class="lc-label">Tỉnh / Thành *</label>
            <input
                type="text"
                name="province_name"
                class="lc-input"
                value="{{ old('province_name', $guestCheckoutInfo['province_name'] ?? 'Cao Bằng') }}"
            >
            @error('province_name') <div class="lc-error-text">{{ $message }}</div> @enderror
        </div>

        <div class="lc-form-group">
            <label class="lc-label">Quận / Huyện *</label>
            <input
                type="text"
                name="district_name"
                class="lc-input"
                value="{{ old('district_name', $guestCheckoutInfo['district_name'] ?? '') }}"
            >
            @error('district_name') <div class="lc-error-text">{{ $message }}</div> @enderror
        </div>

        <div class="lc-form-group">
            <label class="lc-label">Phường / Xã *</label>
            <input
                type="text"
                name="ward_name"
                class="lc-input"
                value="{{ old('ward_name', $guestCheckoutInfo['ward_name'] ?? '') }}"
            >
            @error('ward_name') <div class="lc-error-text">{{ $message }}</div> @enderror
        </div>

        <div class="lc-form-group full">
            <label class="lc-label">Địa chỉ chi tiết *</label>
            <textarea name="address_detail" class="lc-textarea">{{ old('address_detail', $guestCheckoutInfo['address_detail'] ?? '') }}</textarea>
            @error('address_detail') <div class="lc-error-text">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

                    <div class="lc-block lc-hidden-block {{ old('receive_type') == '2' ? 'show' : '' }}" id="lcPickupBlock">
                        <h2 class="lc-block-title">Chọn chi nhánh nhận hàng</h2>

                        <div class="lc-form-group">
                            <label class="lc-label">Chi nhánh *</label>
                            <select name="id_branch_pickup" class="lc-select">
                                <option value="">-- Chọn chi nhánh --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('id_branch_pickup') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_branch_pickup') <div class="lc-error-text">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="lc-block">
                        <h2 class="lc-block-title">Phương thức thanh toán</h2>

                        <div class="lc-radio-grid">
                            <label class="lc-radio-card">
                                <input type="radio" name="payment_method" value="1" {{ old('payment_method', '1') == '1' ? 'checked' : '' }}>
                                <span class="lc-radio-card-label">
                                    <span class="lc-radio-title">Thanh toán khi nhận hàng</span>
                                    <span class="lc-radio-desc">Thanh toán COD khi nhận hàng hoặc khi nhà thuốc giao thành công.</span>
                                </span>
                            </label>

                            <label class="lc-radio-card">
                                <input type="radio" name="payment_method" value="2" {{ old('payment_method') == '2' ? 'checked' : '' }}>
                                <span class="lc-radio-card-label">
                                    <span class="lc-radio-title">Chuyển khoản</span>
                                    <span class="lc-radio-desc">Nhà thuốc sẽ liên hệ xác nhận và gửi thông tin thanh toán sau.</span>
                                </span>
                            </label>
                        </div>
                        @error('payment_method') <div class="lc-error-text" style="margin-top:8px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="lc-block">
                        <h2 class="lc-block-title">Ghi chú thêm</h2>

                        <div class="lc-form-group">
                            <label class="lc-label">Ghi chú</label>
                            <textarea name="note" class="lc-textarea" placeholder="Ví dụ: Giao giờ hành chính, gọi trước khi giao...">{{ old('note') }}</textarea>
                            @error('note') <div class="lc-error-text">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="lc-summary-card">
                    <h2 class="lc-summary-title">Đơn hàng của bạn</h2>

                    <div class="lc-summary-list">
                        @foreach($cart->items as $item)
                            <div class="lc-summary-item">
                                <div class="lc-summary-item-thumb">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->product_name_snapshot }}">
                                </div>

                                <div>
                                    <div class="lc-summary-item-name">{{ $item->product_name_snapshot }}</div>
                                    <div class="lc-summary-item-meta">
                                        SL: {{ (int)$item->quantity }} <br>
                                        Đơn giá: {{ number_format((float)$item->price_snapshot, 0, ',', '.') }}đ <br>
                                        Thành tiền: {{ number_format((float)$item->line_total, 0, ',', '.') }}đ
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="lc-summary-row">
                        <span>Tổng số lượng</span>
                        <strong>{{ (int)$cart->total_quantity }}</strong>
                    </div>

                    <div class="lc-summary-row">
                        <span>Tạm tính</span>
                        <strong id="lcSummarySubtotal" data-value="{{ (float)$cart->subtotal_amount }}">
                            {{ number_format((float)$cart->subtotal_amount, 0, ',', '.') }}đ
                        </strong>
                    </div>

                    @if($autoDiscountAmount > 0)
                        <div class="lc-summary-row lc-summary-row-saving">
                            <span>Đã tiết kiệm (Flash Sale/Khuyến mãi)</span>
                            <strong>-{{ number_format($autoDiscountAmount, 0, ',', '.') }}đ</strong>
                        </div>
                    @endif

                    <div class="lc-summary-row">
                        <span>Giảm giá (Voucher/Mã giảm giá)</span>
                        <strong id="lcSummaryDiscount" data-value="{{ (float)($appliedDiscount['amount'] ?? 0) }}">
                            -{{ number_format((float)($appliedDiscount['amount'] ?? 0), 0, ',', '.') }}đ
                        </strong>
                    </div>

                    <div class="lc-voucher-trigger-wrap">
                        <button type="button" class="lc-voucher-trigger" id="lcOpenVoucherPopup">
                            <span class="lc-voucher-trigger-icon"><i class="ri-coupon-3-line"></i></span>
                            <span class="lc-voucher-trigger-text" id="lcVoucherTriggerText">
                                @if(!empty($appliedDiscount))
                                    Đã áp dụng: <strong>{{ $appliedDiscount['code'] }}</strong>
                                @else
                                    Chọn Voucher hoặc nhập mã giảm giá
                                @endif
                            </span>
                            <span class="lc-voucher-trigger-arrow"><i class="ri-arrow-right-s-line"></i></span>
                        </button>
                    </div>

                    <input type="hidden" name="voucher_code" id="lcVoucherCodeInput" value="{{ $appliedDiscount['code'] ?? '' }}">

                    <div class="lc-summary-row">
                        <span>Phí vận chuyển</span>
                        <strong id="lcSummaryShipping" data-value="{{ (float)$shippingInfo['fee'] }}">
                            {{ $shippingInfo['label'] }}
                        </strong>
                    </div>

                    <div class="lc-summary-total">
                        <span>Tổng thanh toán</span>
                        <span id="lcSummaryTotal">
                            {{ number_format(max(0, (float)$cart->subtotal_amount - (float)($appliedDiscount['amount'] ?? 0) + (float)$shippingInfo['fee']), 0, ',', '.') }}đ
                        </span>
                    </div>

                    <button type="submit" class="lc-submit-btn">Xác nhận đặt hàng</button>

                    <a href="{{ route('website.cart.index') }}" class="lc-back-link">
                        Quay lại giỏ hàng
                    </a>
                </div>
            </div>
        </form>
    </div>
</section>

<div class="lc-voucher-popup" id="lcVoucherPopup">
    <div class="lc-voucher-popup-backdrop" id="lcVoucherPopupBackdrop"></div>

    <div class="lc-voucher-popup-dialog" role="dialog" aria-modal="true">
        <div class="lc-voucher-popup-head">
            <h3>Voucher &amp; Mã giảm giá</h3>
            <button type="button" class="lc-voucher-popup-close" id="lcCloseVoucherPopup" aria-label="Đóng">
                <i class="ri-close-line"></i>
            </button>
        </div>

        <div class="lc-voucher-popup-body">
            <div class="lc-voucher-tabs">
                <button type="button" class="lc-voucher-tab is-active" data-voucher-tab="vouchers">Voucher khả dụng</button>
                <button type="button" class="lc-voucher-tab" data-voucher-tab="coupon">Nhập mã giảm giá</button>
            </div>

            <div class="lc-voucher-tab-panel is-active" id="lcVoucherTabVouchers">
                @forelse($availableVouchers as $voucher)
                    @php
                        $isPercent = (int) $voucher->discount_type === 1;
                        $valueLabel = $isPercent
                            ? 'Giảm ' . rtrim(rtrim(number_format((float)$voucher->discount_value, 2, '.', ''), '0'), '.') . '%'
                                . ($voucher->max_discount_amount ? ' (tối đa ' . number_format($voucher->max_discount_amount, 0, ',', '.') . 'đ)' : '')
                            : 'Giảm ' . number_format($voucher->discount_value, 0, ',', '.') . 'đ';
                        $isApplied = !empty($appliedDiscount) && $appliedDiscount['code'] === $voucher->code;
                    @endphp

                    <label class="lc-voucher-item {{ $isApplied ? 'is-active' : '' }}">
                        <input
                            type="radio"
                            name="lc_voucher_radio"
                            value="{{ $voucher->code }}"
                            data-title="{{ $voucher->title }}"
                            {{ $isApplied ? 'checked' : '' }}
                        >

                        <div class="lc-voucher-item-icon"><i class="ri-coupon-3-fill"></i></div>

                        <div class="lc-voucher-item-body">
                            <div class="lc-voucher-item-title">{{ $voucher->title }}</div>
                            <div class="lc-voucher-item-value">{{ $valueLabel }}</div>
                            @if($voucher->min_order_amount > 0)
                                <div class="lc-voucher-item-condition">
                                    Áp dụng cho đơn từ {{ number_format($voucher->min_order_amount, 0, ',', '.') }}đ
                                </div>
                            @endif
                        </div>
                    </label>
                @empty
                    <div class="lc-voucher-empty">Hiện chưa có voucher khả dụng.</div>
                @endforelse
            </div>

            <div class="lc-voucher-tab-panel" id="lcVoucherTabCoupon">
                <label class="lc-voucher-coupon-label">Nhập mã giảm giá</label>

                <div class="lc-voucher-coupon-row">
                    <input type="text" id="lcCouponInput" class="lc-voucher-coupon-input" placeholder="VD: SALE10K" autocomplete="off">
                    <button type="button" class="lc-voucher-coupon-apply" id="lcApplyCouponBtn">Áp dụng</button>
                </div>

                <div class="lc-voucher-coupon-msg" id="lcCouponMsg"></div>
            </div>
        </div>

        <div class="lc-voucher-popup-foot">
            @if(!empty($appliedDiscount))
                <button type="button" class="lc-voucher-btn lc-voucher-btn-outline" id="lcRemoveVoucherBtn">
                    Bỏ áp dụng
                </button>
            @endif

            <button type="button" class="lc-voucher-btn lc-voucher-btn-primary" id="lcConfirmVoucherBtn">
                Áp dụng voucher
            </button>
        </div>
    </div>
</div>

<script>
    (function () {
        const receiveInputs = document.querySelectorAll('input[name="receive_type"]');
        const deliveryBlock = document.getElementById('lcDeliveryBlock');
        const pickupBlock = document.getElementById('lcPickupBlock');

        function toggleReceiveBlocks() {
            const checked = document.querySelector('input[name="receive_type"]:checked');
            const value = checked ? checked.value : '1';

            if (value === '1') {
                deliveryBlock?.classList.add('show');
                pickupBlock?.classList.remove('show');
            } else {
                deliveryBlock?.classList.remove('show');
                pickupBlock?.classList.add('show');
            }
        }

        receiveInputs.forEach((input) => {
            input.addEventListener('change', toggleReceiveBlocks);
        });

        toggleReceiveBlocks();
    })();
</script>

<script>
    (function () {
        const APPLY_DISCOUNT_URL = @json(route('website.checkout.apply-discount'));
        const REMOVE_DISCOUNT_URL = @json(route('website.checkout.remove-discount'));
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        const popup = document.getElementById('lcVoucherPopup');
        const backdrop = document.getElementById('lcVoucherPopupBackdrop');
        const openBtn = document.getElementById('lcOpenVoucherPopup');
        const closeBtn = document.getElementById('lcCloseVoucherPopup');
        const confirmBtn = document.getElementById('lcConfirmVoucherBtn');
        const removeBtn = document.getElementById('lcRemoveVoucherBtn');
        const applyCouponBtn = document.getElementById('lcApplyCouponBtn');
        const couponInput = document.getElementById('lcCouponInput');
        const couponMsg = document.getElementById('lcCouponMsg');
        const voucherCodeInput = document.getElementById('lcVoucherCodeInput');
        const triggerText = document.getElementById('lcVoucherTriggerText');

        const subtotalEl = document.getElementById('lcSummarySubtotal');
        const shippingEl = document.getElementById('lcSummaryShipping');
        const discountEl = document.getElementById('lcSummaryDiscount');
        const totalEl = document.getElementById('lcSummaryTotal');

        function openPopup() {
            popup.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closePopup() {
            popup.classList.remove('show');
            document.body.style.overflow = '';
        }

        openBtn?.addEventListener('click', openPopup);
        closeBtn?.addEventListener('click', closePopup);
        backdrop?.addEventListener('click', closePopup);

        document.querySelectorAll('.lc-voucher-tab').forEach((tab) => {
            tab.addEventListener('click', function () {
                document.querySelectorAll('.lc-voucher-tab').forEach((t) => t.classList.remove('is-active'));
                document.querySelectorAll('.lc-voucher-tab-panel').forEach((p) => p.classList.remove('is-active'));

                this.classList.add('is-active');
                const target = this.getAttribute('data-voucher-tab');
                document.getElementById(target === 'vouchers' ? 'lcVoucherTabVouchers' : 'lcVoucherTabCoupon')
                    .classList.add('is-active');
            });
        });

        document.querySelectorAll('.lc-voucher-item').forEach((item) => {
            item.addEventListener('click', function () {
                document.querySelectorAll('.lc-voucher-item').forEach((i) => i.classList.remove('is-active'));
                this.classList.add('is-active');
            });
        });

        function formatMoney(value) {
            return Number(value || 0).toLocaleString('vi-VN') + 'đ';
        }

        function recalcTotal() {
            const subtotal = parseFloat(subtotalEl?.getAttribute('data-value') || 0);
            const shipping = parseFloat(shippingEl?.getAttribute('data-value') || 0);
            const discount = parseFloat(discountEl?.getAttribute('data-value') || 0);
            const total = Math.max(0, subtotal - discount + shipping);

            if (totalEl) totalEl.textContent = formatMoney(total);
        }

        async function applyCode(code) {
            if (!code) return;

            try {
                const response = await fetch(APPLY_DISCOUNT_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ code: code })
                });

                const result = await response.json();

                if (result.status) {
                    discountEl.setAttribute('data-value', result.discount_amount);
                    discountEl.textContent = '-' + result.discount_amount_label;
                    voucherCodeInput.value = result.discount_code;
                    triggerText.innerHTML = 'Đã áp dụng: <strong>' + result.discount_code + '</strong>';
                    recalcTotal();
                    closePopup();
                } else {
                    if (couponMsg) {
                        couponMsg.textContent = result.msg;
                        couponMsg.className = 'lc-voucher-coupon-msg error';
                    } else {
                        alert(result.msg);
                    }
                }
            } catch (error) {
                if (couponMsg) {
                    couponMsg.textContent = 'Có lỗi xảy ra, vui lòng thử lại.';
                    couponMsg.className = 'lc-voucher-coupon-msg error';
                }
            }
        }

        confirmBtn?.addEventListener('click', function () {
            const checked = document.querySelector('input[name="lc_voucher_radio"]:checked');

            if (!checked) {
                alert('Vui lòng chọn một voucher.');
                return;
            }

            applyCode(checked.value);
        });

        applyCouponBtn?.addEventListener('click', function () {
            const code = (couponInput?.value || '').trim();

            if (!code) {
                couponMsg.textContent = 'Vui lòng nhập mã giảm giá.';
                couponMsg.className = 'lc-voucher-coupon-msg error';
                return;
            }

            applyCode(code);
        });

        removeBtn?.addEventListener('click', async function () {
            try {
                await fetch(REMOVE_DISCOUNT_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
            } catch (error) {}

            discountEl.setAttribute('data-value', 0);
            discountEl.textContent = '-0đ';
            voucherCodeInput.value = '';
            triggerText.textContent = 'Chọn Voucher hoặc nhập mã giảm giá';
            recalcTotal();
            closePopup();
        });
    })();
</script>
@endsection
