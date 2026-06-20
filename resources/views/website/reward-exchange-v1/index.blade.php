@extends('website.layout.index')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">

<style>
    .pa-reward-page{
        background:#f5f7fb;
        padding:28px 0 44px;
        font-family:ui-sans-serif,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,"Apple Color Emoji","Segoe UI Emoji";
    }

    .pa-reward-container{
        width:min(1320px, calc(100% - 32px));
        margin:0 auto;
    }

    .pa-reward-hero{
        position:relative;
        overflow:hidden;
        border-radius:30px;
        padding:34px;
        color:#fff;
        background:
            radial-gradient(circle at 92% 10%, rgba(255,255,255,.22), transparent 28%),
            radial-gradient(circle at 8% 92%, rgba(255,255,255,.14), transparent 30%),
            linear-gradient(135deg,#0f8f65 0%,#2563eb 100%);
        box-shadow:0 20px 45px rgba(37,99,235,.18);
        margin-bottom:22px;
    }

    .pa-reward-hero-inner{
        position:relative;
        z-index:2;
        max-width:900px;
    }

    .pa-reward-badge{
        display:inline-flex;
        align-items:center;
        gap:8px;
        min-height:36px;
        padding:0 14px;
        border-radius:999px;
        background:rgba(255,255,255,.18);
        color:#fff;
        font-size:13px;
        font-weight:900;
        margin-bottom:14px;
        backdrop-filter:blur(6px);
    }

    .pa-reward-badge i{
        font-size:18px;
    }

    .pa-reward-hero h1{
        margin:0 0 12px;
        font-size:42px;
        line-height:1.16;
        font-weight:950;
        letter-spacing:-.025em;
    }

    .pa-reward-hero p{
        margin:0;
        max-width:820px;
        font-size:16px;
        line-height:1.85;
        color:rgba(255,255,255,.93);
    }

    .pa-reward-tags{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
        margin-top:20px;
    }

    .pa-reward-tags span{
        min-height:36px;
        padding:0 13px;
        border-radius:999px;
        background:rgba(255,255,255,.16);
        display:inline-flex;
        align-items:center;
        gap:7px;
        font-size:13px;
        font-weight:850;
    }

    .pa-reward-layout{
        display:grid;
        grid-template-columns:360px minmax(0,1fr);
        gap:22px;
        align-items:start;
    }

    .pa-reward-side,
    .pa-reward-main{
        background:#fff;
        border:1px solid #edf2f7;
        border-radius:26px;
        padding:22px;
        box-shadow:0 14px 35px rgba(15,23,42,.06);
    }

    .pa-reward-side{
        position:sticky;
        top:18px;
        overflow:hidden;
    }

    .pa-reward-side::before{
        content:"";
        position:absolute;
        left:0;
        top:0;
        width:100%;
        height:5px;
        background:linear-gradient(90deg,#0f8f65,#2563eb);
    }

    .pa-side-title{
        margin:0 0 12px;
        font-size:22px;
        font-weight:950;
        color:#0f172a;
        display:flex;
        align-items:center;
        gap:10px;
    }

    .pa-side-title i{
        width:42px;
        height:42px;
        border-radius:15px;
        background:#eff6ff;
        color:#2563eb;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        font-size:23px;
    }

    .pa-side-desc{
        margin:0 0 16px;
        color:#64748b;
        font-size:14px;
        line-height:1.75;
    }

    .pa-balance-box{
        border-radius:22px;
        background:linear-gradient(135deg,#ecfdf5 0%,#eff6ff 100%);
        border:1px solid #dbeafe;
        padding:18px;
        margin-bottom:14px;
    }

    .pa-balance-label{
        display:flex;
        align-items:center;
        gap:7px;
        color:#334155;
        font-size:14px;
        font-weight:900;
        margin-bottom:10px;
    }

    .pa-balance-label i{
        color:#2563eb;
        font-size:18px;
    }

    .pa-balance-value{
        font-size:36px;
        font-weight:950;
        color:#0f8f65;
        line-height:1;
        letter-spacing:-.03em;
    }

    .pa-phone-status{
        width:100%;
        border:1px solid #e2e8f0;
        background:#f8fafc;
        color:#334155;
        min-height:44px;
        padding:0 14px;
        border-radius:999px;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        font-size:13px;
        font-weight:900;
        cursor:pointer;
    }

    .pa-phone-status .dot{
        width:8px;
        height:8px;
        border-radius:50%;
        background:#ef4444;
    }

    .pa-phone-status.logged-in{
        background:#ecfdf5;
        color:#15803d;
        border-color:#bbf7d0;
    }

    .pa-phone-status.logged-in .dot{
        background:#22c55e;
    }

    .pa-side-actions{
        display:grid;
        gap:10px;
        margin-top:16px;
    }

    .pa-action-btn{
        min-height:46px;
        border-radius:999px;
        border:0;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        text-decoration:none;
        cursor:pointer;
        font-size:14px;
        font-weight:950;
    }

    .pa-action-btn.primary{
        color:#fff;
        background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);
        box-shadow:0 12px 24px rgba(37,99,235,.18);
    }

    .pa-action-btn.light{
        background:#eff6ff;
        color:#1d4ed8;
    }

    .pa-action-btn.soft{
        background:#f8fafc;
        color:#334155;
        border:1px solid #e2e8f0;
    }

    .pa-tabs{
        display:grid;
        grid-template-columns:repeat(3,minmax(0,1fr));
        gap:10px;
        margin-top:16px;
    }

    .pa-tab-card{
        border:1px solid #edf2f7;
        background:#fff;
        border-radius:18px;
        padding:12px;
        display:grid;
        gap:8px;
        text-decoration:none;
        color:#334155;
        cursor:pointer;
        transition:transform .2s ease, border-color .2s ease, background .2s ease;
    }

    .pa-tab-card:hover{
        transform:translateY(-2px);
        border-color:#cfe0ff;
        text-decoration:none;
    }

    .pa-tab-card.active{
        background:linear-gradient(135deg,#ecfdf5 0%,#eff6ff 100%);
        border-color:#bfdbfe;
    }

    .pa-tab-icon{
        width:38px;
        height:38px;
        border-radius:14px;
        background:#eff6ff;
        color:#2563eb;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .pa-tab-icon i{
        font-size:21px;
    }

    .pa-tab-title{
        font-size:13px;
        font-weight:950;
        color:#0f172a;
        line-height:1.35;
    }

    .pa-main-head{
        display:flex;
        justify-content:space-between;
        align-items:flex-end;
        gap:16px;
        flex-wrap:wrap;
        margin-bottom:18px;
    }

    .pa-main-title{
        margin:0 0 6px;
        font-size:28px;
        font-weight:950;
        color:#0f172a;
        display:flex;
        align-items:center;
        gap:10px;
    }

    .pa-main-title i{
        width:42px;
        height:42px;
        border-radius:15px;
        background:#eff6ff;
        color:#2563eb;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        font-size:23px;
    }

    .pa-main-sub{
        margin:0;
        font-size:14px;
        color:#64748b;
        line-height:1.7;
    }

    .pa-reward-filter{
        position:relative;
        width:min(100%, 360px);
    }

    .pa-reward-filter i{
        position:absolute;
        left:15px;
        top:50%;
        transform:translateY(-50%);
        color:#64748b;
        font-size:19px;
    }

    .pa-reward-filter input{
        width:100%;
        min-height:46px;
        border:1px solid #dbe4f0;
        border-radius:999px;
        padding:0 14px 0 43px;
        outline:none;
        color:#0f172a;
        font-size:14px;
        font-family:ui-sans-serif,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial;
    }

    .pa-reward-filter input:focus{
        border-color:#2563eb;
        box-shadow:0 0 0 3px rgba(37,99,235,.08);
    }

    .pa-gift-grid{
        display:grid;
        grid-template-columns:repeat(3,minmax(0,1fr));
        gap:16px;
    }

    .pa-gift-card{
        background:#fff;
        border:1px solid #edf2f7;
        border-radius:24px;
        overflow:hidden;
        box-shadow:0 12px 28px rgba(15,23,42,.05);
        display:flex;
        flex-direction:column;
        transition:transform .2s ease, border-color .2s ease, box-shadow .2s ease;
    }

    .pa-gift-card:hover{
        transform:translateY(-3px);
        border-color:#cfe0ff;
        box-shadow:0 18px 40px rgba(37,99,235,.10);
    }

    .pa-gift-image-wrap{
        position:relative;
        padding-top:82%;
        background:linear-gradient(135deg,#f8fafc,#edf2f7);
        overflow:hidden;
    }

    .pa-gift-image{
        position:absolute;
        inset:0;
        width:100%;
        height:100%;
        object-fit:contain;
    }

    .pa-gift-stock{
        position:absolute;
        left:12px;
        top:12px;
        min-height:30px;
        padding:0 10px;
        border-radius:999px;
        background:rgba(15,23,42,.78);
        color:#fff;
        display:inline-flex;
        align-items:center;
        gap:6px;
        font-size:12px;
        font-weight:900;
        backdrop-filter:blur(6px);
    }

    .pa-gift-info{
        padding:15px;
        display:flex;
        flex-direction:column;
        gap:10px;
        flex:1;
    }

    .pa-gift-name{
        margin:0;
        color:#0f172a;
        font-size:16px;
        font-weight:950;
        line-height:1.45;
        min-height:46px;
        display:-webkit-box;
        -webkit-line-clamp:2;
        -webkit-box-orient:vertical;
        overflow:hidden;
    }

    .pa-gift-meta{
        display:grid;
        gap:7px;
        color:#64748b;
        font-size:13px;
    }

    .pa-gift-meta-row{
        display:flex;
        align-items:center;
        gap:7px;
        font-weight:800;
    }

    .pa-gift-meta-row i{
        color:#2563eb;
        font-size:17px;
    }

    .pa-gift-points{
        color:#0f8f65;
        font-weight:950;
    }

    .pa-redeem-btn{
        margin-top:auto;
        width:100%;
        min-height:44px;
        border-radius:999px;
        border:0;
        background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);
        color:#fff;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        font-size:14px;
        font-weight:950;
        cursor:pointer;
        box-shadow:0 12px 24px rgba(37,99,235,.16);
    }

    .pa-redeem-btn:disabled{
        background:#cbd5e1;
        color:#fff;
        box-shadow:none;
        cursor:not-allowed;
    }

    .pa-empty-state{
        grid-column:1 / -1;
        background:#fff;
        border:1px dashed #dbe4f0;
        border-radius:24px;
        padding:34px 22px;
        text-align:center;
        color:#64748b;
        line-height:1.8;
    }

    .pa-empty-state i{
        width:62px;
        height:62px;
        border-radius:50%;
        background:#eff6ff;
        color:#2563eb;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:31px;
        margin:0 auto 12px;
    }

    .pa-modal-backdrop{
        position:fixed;
        inset:0;
        background:rgba(15,23,42,.52);
        display:none;
        align-items:center;
        justify-content:center;
        z-index:9999;
        padding:16px;
        box-sizing:border-box;
        backdrop-filter:blur(3px);
    }

    .pa-modal{
        width:min(92vw,480px);
        background:#fff;
        border-radius:26px;
        padding:24px;
        box-shadow:0 24px 70px rgba(15,23,42,.28);
        position:relative;
        overflow:hidden;
        animation:paModalFade .25s ease;
        max-height:92vh;
        overflow-y:auto;
    }

    @keyframes paModalFade{
        from{opacity:0;transform:translateY(16px)}
        to{opacity:1;transform:translateY(0)}
    }

    .pa-modal::before{
        content:"";
        position:absolute;
        left:0;
        top:0;
        width:100%;
        height:5px;
        background:linear-gradient(90deg,#0f8f65,#2563eb);
    }

    .pa-modal-close{
        position:absolute;
        right:14px;
        top:14px;
        width:38px;
        height:38px;
        border-radius:50%;
        border:0;
        background:#f1f5f9;
        color:#0f172a;
        cursor:pointer;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:20px;
    }

    .pa-modal-title{
        margin:6px 42px 18px 0;
        color:#0f172a;
        font-size:24px;
        font-weight:950;
        display:flex;
        align-items:center;
        gap:10px;
    }

    .pa-modal-title i{
        width:42px;
        height:42px;
        border-radius:15px;
        background:#eff6ff;
        color:#2563eb;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        font-size:23px;
    }

    .pa-modal-gift{
        text-align:center;
        background:#f8fafc;
        border:1px solid #e2e8f0;
        border-radius:22px;
        padding:16px;
        margin-bottom:16px;
    }

    .pa-modal-gift img{
        width:120px;
        height:120px;
        border-radius:18px;
        object-fit:cover;
        background:#fff;
        display:block;
        margin:0 auto 10px;
        border:1px solid #edf2f7;
    }

    .pa-modal-gift-name{
        font-size:18px;
        font-weight:950;
        color:#0f172a;
        margin-bottom:5px;
    }

    .pa-modal-gift-points{
        color:#0f8f65;
        font-size:14px;
        font-weight:950;
    }

    .pa-form-group{
        display:flex;
        flex-direction:column;
        gap:8px;
        margin-bottom:12px;
    }

    .pa-form-group label{
        font-size:14px;
        font-weight:900;
        color:#0f172a;
        display:flex;
        align-items:center;
        gap:7px;
    }

    .pa-form-group label i{
        color:#2563eb;
        font-size:18px;
    }

    .pa-input,
    .pa-select{
        width:100%;
        min-height:50px;
        border:1px solid #dbe4f0;
        border-radius:16px;
        padding:0 14px;
        background:#fff;
        outline:none;
        color:#0f172a;
        font-size:15px;
        box-sizing:border-box;
        font-family:ui-sans-serif,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial;
    }

    .pa-input:focus,
    .pa-select:focus{
        border-color:#2563eb;
        box-shadow:0 0 0 3px rgba(37,99,235,.08);
    }

    .pa-stock-badge{
        display:none;
        width:max-content;
        margin:2px 0 12px;
        padding:6px 10px;
        border-radius:999px;
        background:#ecfdf5;
        color:#15803d;
        font-size:12px;
        font-weight:950;
    }

    .pa-submit-btn{
        width:100%;
        min-height:52px;
        border:0;
        border-radius:999px;
        background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);
        color:#fff;
        font-size:15px;
        font-weight:950;
        cursor:pointer;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        margin-top:10px;
        box-shadow:0 12px 24px rgba(37,99,235,.18);
    }

    .pa-submit-btn:disabled{
        opacity:.65;
        cursor:not-allowed;
    }

    .pa-modal-phone-icon{
        width:62px;
        height:62px;
        border-radius:22px;
        background:linear-gradient(135deg,#ecfdf5,#eff6ff);
        display:flex;
        align-items:center;
        justify-content:center;
        margin:0 auto 14px;
        color:#2563eb;
    }

    .pa-modal-phone-icon i{
        font-size:33px;
    }

    .pa-phone-modal{
        text-align:center;
    }

    .pa-phone-modal h3{
        margin:6px 0 8px;
        font-size:24px;
        font-weight:950;
        color:#0f172a;
    }

    .pa-phone-modal p{
        margin:0 0 18px;
        color:#64748b;
        font-size:14px;
        line-height:1.7;
    }

    .pa-btn-row{
        display:flex;
        gap:10px;
        justify-content:center;
        margin-top:16px;
        flex-wrap:wrap;
    }

    .pa-small-btn{
        min-height:46px;
        border-radius:999px;
        border:0;
        padding:0 16px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        cursor:pointer;
        font-size:14px;
        font-weight:950;
    }

    .pa-small-btn.primary{
        background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);
        color:#fff;
    }

    .pa-small-btn.ghost{
        background:#f8fafc;
        color:#334155;
        border:1px solid #dbe4f0;
    }

    .pa-small-btn.danger{
        background:#fef2f2;
        color:#dc2626;
        border:1px solid #fecaca;
    }

    .pa-history-list{
        max-height:62vh;
        overflow:auto;
        display:grid;
        gap:12px;
        padding-right:4px;
    }

    .pa-history-item{
        display:grid;
        grid-template-columns:74px minmax(0,1fr) auto;
        gap:12px;
        align-items:center;
        background:#fff;
        border:1px solid #edf2f7;
        border-radius:18px;
        padding:12px;
    }

    .pa-history-img{
        width:74px;
        height:74px;
        border-radius:16px;
        object-fit:cover;
        background:#f1f5f9;
    }

    .pa-history-name{
        color:#0f172a;
        font-weight:950;
        line-height:1.4;
        margin-bottom:5px;
    }

    .pa-history-meta{
        font-size:12px;
        color:#64748b;
        line-height:1.6;
    }

    .pa-status-badge{
        display:inline-flex;
        align-items:center;
        width:max-content;
        padding:3px 9px;
        border-radius:999px;
        font-size:11px;
        font-weight:950;
        margin-top:6px;
    }

    .pa-status-requested,
    .pa-status-pending{
        background:#fff7ed;
        color:#c2410c;
    }

    .pa-status-approved{
        background:#ecfdf5;
        color:#15803d;
    }

    .pa-status-fulfilled{
        background:#eff6ff;
        color:#1d4ed8;
    }

    .pa-status-cancelled{
        background:#fef2f2;
        color:#dc2626;
    }

    .pa-qr-btn{
        border:1px solid #e2e8f0;
        background:#fff;
        color:#0f172a;
        min-height:38px;
        padding:0 11px;
        border-radius:999px;
        font-size:12px;
        font-weight:950;
        cursor:pointer;
        display:inline-flex;
        align-items:center;
        gap:6px;
        white-space:nowrap;
    }

    .pa-qr-wrap{
        background:linear-gradient(135deg,#0f172a,#111827);
        color:#fff;
        border-radius:26px;
        padding:22px;
        text-align:center;
        box-shadow:0 24px 70px rgba(15,23,42,.4);
    }

    .pa-qr-brand{
        font-weight:950;
        letter-spacing:.12em;
        color:#a7f3d0;
        font-size:12px;
    }

    .pa-qr-gift{
        margin-top:8px;
        font-size:18px;
        font-weight:950;
    }

    .pa-qr-points{
        margin-top:3px;
        font-size:13px;
        color:#bfdbfe;
    }

    .pa-qr-img{
        width:260px;
        height:260px;
        background:#fff;
        border-radius:18px;
        margin:16px auto 0;
        display:block;
        object-fit:contain;
        padding:10px;
        box-sizing:border-box;
    }

    .pa-qr-branch{
        margin-top:12px;
        font-size:13px;
        color:#cbd5e1;
    }

    .pa-toast{
        position:fixed;
        left:50%;
        transform:translateX(-50%);
        bottom:24px;
        background:#0f172a;
        color:#fff;
        padding:11px 16px;
        border-radius:999px;
        font-size:13px;
        font-weight:850;
        opacity:0;
        pointer-events:none;
        transition:opacity .25s ease, transform .25s ease;
        z-index:10000;
        max-width:88vw;
        text-align:center;
        box-shadow:0 14px 30px rgba(15,23,42,.22);
    }

    .pa-toast.show{
        opacity:1;
        transform:translateX(-50%) translateY(-4px);
    }

    .pa-toast.ok{
        background:#15803d;
    }

    .pa-toast.err{
        background:#dc2626;
    }

    @media(max-width:1180px){
        .pa-reward-layout{
            grid-template-columns:1fr;
        }

        .pa-reward-side{
            position:static;
        }

        .pa-gift-grid{
            grid-template-columns:repeat(2,minmax(0,1fr));
        }
    }

    @media(max-width:768px){
        .pa-reward-page{
            padding:18px 0 30px;
        }

        .pa-reward-container{
            width:min(100%, calc(100% - 20px));
        }

        .pa-reward-hero{
            border-radius:22px;
            padding:22px;
        }

        .pa-reward-hero h1{
            font-size:30px;
        }

        .pa-reward-side,
        .pa-reward-main{
            border-radius:22px;
            padding:18px;
        }

        .pa-tabs{
            grid-template-columns:1fr 1fr 1fr;
        }

        .pa-tab-card{
            padding:10px;
        }

        .pa-tab-icon{
            width:34px;
            height:34px;
        }

        .pa-tab-title{
            font-size:12px;
        }

        .pa-main-head{
            align-items:flex-start;
        }

        .pa-main-title{
            font-size:24px;
        }

        .pa-reward-filter{
            width:100%;
        }

        .pa-gift-grid{
            gap:12px;
        }

        .pa-gift-name{
            font-size:14px;
            min-height:42px;
        }

        .pa-gift-info{
            padding:12px;
        }

        .pa-history-item{
            grid-template-columns:62px minmax(0,1fr);
        }

        .pa-history-img{
            width:62px;
            height:62px;
        }

        .pa-qr-btn{
            grid-column:2 / 3;
            width:max-content;
        }

        .pa-btn-row{
            flex-direction:column;
        }

        .pa-small-btn{
            width:100%;
        }
    }

    @media(max-width:420px){
        .pa-gift-grid{
            grid-template-columns:repeat(2,minmax(0,1fr));
        }

        .pa-gift-image-wrap{
            padding-top:92%;
        }

        .pa-gift-meta-row{
            font-size:12px;
        }

        .pa-redeem-btn{
            min-height:40px;
            font-size:13px;
        }

        .pa-modal{
            width:100%;
            padding:20px 16px;
            border-radius:22px;
        }

        .pa-qr-img{
            width:230px;
            height:230px;
        }
    }
</style>
@endsection

@section('content')
<section class="pa-reward-page">
    <div class="pa-reward-container">
        <div class="pa-reward-hero">
            <div class="pa-reward-hero-inner">
                <div class="pa-reward-badge">
                    <i class="ri-gift-line"></i>
                    <span>Đổi quà thành viên</span>
                </div>

                <h1>Đổi quà từ điểm tích lũy Nhà thuốc Phương Anh</h1>

                <p>
                    Sử dụng điểm tích lũy từ lịch sử mua hàng để đổi các phần quà chăm sóc sức khỏe.
                    Chọn quà, chọn chi nhánh nhận quà và lưu QR để nhân viên xác nhận tại quầy.
                </p>

                <div class="pa-reward-tags">
                    <span><i class="ri-coins-line"></i> Theo dõi điểm khả dụng</span>
                    <span><i class="ri-store-2-line"></i> Chọn chi nhánh nhận quà</span>
                    <span><i class="ri-qr-code-line"></i> Có QR xác nhận đổi quà</span>
                </div>
            </div>
        </div>

        <div class="pa-reward-layout">
            <aside class="pa-reward-side">
                <h2 class="pa-side-title">
                    <i class="ri-vip-crown-line"></i>
                    Thành viên Phương Anh
                </h2>

                <p class="pa-side-desc">
                    Nhập số điện thoại để kiểm tra điểm khả dụng, đổi quà và xem lại lịch sử quà đã đổi.
                </p>

                <div class="pa-balance-box">
                    <div class="pa-balance-label">
                        <i class="ri-coins-line"></i>
                        Điểm khả dụng
                    </div>
                    <div id="paPointsValue" class="pa-balance-value">— điểm</div>
                </div>

                <button id="paHeaderStatus" type="button" class="pa-phone-status" title="Bấm để đổi số điện thoại">
                    <span class="dot"></span>
                    <span id="paStatusText">Chưa nhập SĐT</span>
                </button>

                <div class="pa-side-actions">
                    <button type="button" class="pa-action-btn primary" id="paChangePhoneBtn">
                        <i class="ri-phone-line"></i>
                        Nhập / đổi số điện thoại
                    </button>

                    <button type="button" class="pa-action-btn light" id="paBtnHistory">
                        <i class="ri-ticket-2-line"></i>
                        Quà đã đổi
                    </button>

                    <a href="https://zalo.me/4374437222076872555" target="_blank" class="pa-action-btn soft">
                        <i class="ri-chat-smile-2-line"></i>
                        Cần hỗ trợ đổi quà?
                    </a>
                </div>

                <div class="pa-tabs">
                    <a href="{{ route('website.loyalty_point_v1.index') }}" class="pa-tab-card">
                        <div class="pa-tab-icon"><i class="ri-coins-line"></i></div>
                        <div class="pa-tab-title">Điểm</div>
                    </a>

                    <button type="button" class="pa-tab-card js-dev-feature">
                        <div class="pa-tab-icon"><i class="ri-star-smile-line"></i></div>
                        <div class="pa-tab-title">Đánh giá</div>
                    </button>

                    <button type="button" class="pa-tab-card active">
                        <div class="pa-tab-icon"><i class="ri-gift-2-line"></i></div>
                        <div class="pa-tab-title">Đổi quà</div>
                    </button>
                </div>
            </aside>

            <main class="pa-reward-main">
                <div class="pa-main-head">
                    <div>
                        <h2 class="pa-main-title">
                            <i class="ri-gift-2-line"></i>
                            Quà tặng hiện có
                        </h2>
                        <p class="pa-main-sub">
                            Danh sách quà tặng đang có trong hệ thống. Số lượng có thể thay đổi theo từng chi nhánh.
                        </p>
                    </div>

                    <div class="pa-reward-filter">
                        <i class="ri-search-line"></i>
                        <input type="text" id="paGiftSearch" placeholder="Tìm quà tặng...">
                    </div>
                </div>

                <div class="pa-gift-grid" id="paRewardsGrid">
                    <div class="pa-empty-state">
                        <i class="ri-loader-4-line"></i>
                        Đang tải danh sách quà...
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div id="paPhoneLoginModal" class="pa-modal-backdrop" role="dialog" aria-modal="true">
        <div class="pa-modal pa-phone-modal">
            <button type="button" class="pa-modal-close" id="paClosePhoneX">
                <i class="ri-close-line"></i>
            </button>

            <div class="pa-modal-phone-icon">
                <i class="ri-phone-line"></i>
            </div>

            <h3>Nhập số điện thoại</h3>

            <p>
                Hệ thống sẽ dùng số điện thoại để tra cứu điểm khả dụng, đổi quà và xem lịch sử quà đã đổi.
            </p>

            <div class="pa-form-group" style="text-align:left;">
                <label for="paInpPhone">
                    <i class="ri-smartphone-line"></i>
                    Số điện thoại
                </label>
                <input id="paInpPhone" class="pa-input" type="tel" placeholder="VD: 0912345678" inputmode="numeric" autocomplete="tel">
                <div style="font-size:12px;color:#64748b;margin-top:2px;">
                    Có thể nhập dạng 0912345678 hoặc 84912345678.
                </div>
            </div>

            <div class="pa-btn-row">
                <button id="paBtnSubmitPhone" class="pa-small-btn primary" type="button">
                    <i class="ri-arrow-right-line"></i>
                    Tiếp tục
                </button>

                <button id="paBtnClosePhone" class="pa-small-btn ghost" type="button">
                    Để sau
                </button>
            </div>

            <div class="pa-btn-row" id="paLogoutRow" style="display:none;margin-top:8px">
                <button id="paBtnClearPhone" class="pa-small-btn danger" type="button">
                    <i class="ri-delete-bin-line"></i>
                    Xóa số đã lưu
                </button>
            </div>
        </div>
    </div>

    <div id="paRedeemModal" class="pa-modal-backdrop" role="dialog" aria-modal="true">
        <div class="pa-modal">
            <button type="button" class="pa-modal-close" id="paCloseRedeemX">
                <i class="ri-close-line"></i>
            </button>

            <h3 class="pa-modal-title">
                <i class="ri-gift-line"></i>
                Xác nhận đổi quà
            </h3>

            <div class="pa-modal-gift">
                <img id="paModalRewardImg" src="" alt="">
                <div id="paModalRewardName" class="pa-modal-gift-name">—</div>
                <div id="paModalRewardPoints" class="pa-modal-gift-points">— điểm</div>
            </div>

            <div class="pa-form-group">
                <label for="paBranchSelect">
                    <i class="ri-store-2-line"></i>
                    Chi nhánh nhận quà
                </label>
                <select id="paBranchSelect" class="pa-select">
                    <option value="">Chọn chi nhánh nhận quà</option>
                </select>
            </div>

            <div id="paBranchQtyBadge" class="pa-stock-badge">Tồn: 0</div>

            <div class="pa-form-group">
                <label for="paCustomerName">
                    <i class="ri-user-3-line"></i>
                    Họ và tên
                </label>
                <input type="text" id="paCustomerName" class="pa-input" placeholder="Nhập họ và tên">
            </div>

            <div class="pa-form-group">
                <label for="paCustomerPhone">
                    <i class="ri-phone-line"></i>
                    Số điện thoại
                </label>
                {{-- Khoá theo tài khoản đã đăng nhập OTP, không cho sửa để tránh đổi quà bằng điểm của người khác --}}
                <input type="tel" id="paCustomerPhone" class="pa-input" readonly disabled>
            </div>

            <button class="pa-submit-btn" id="paBtnSubmitRedeem">
                <i class="ri-checkbox-circle-line"></i>
                Xác nhận đổi quà
            </button>
        </div>
    </div>

    <div id="paHistoryModal" class="pa-modal-backdrop" role="dialog" aria-modal="true">
        <div class="pa-modal" style="width:min(92vw,620px);">
            <button type="button" class="pa-modal-close" id="paCloseHistoryX">
                <i class="ri-close-line"></i>
            </button>

            <h3 class="pa-modal-title">
                <i class="ri-ticket-2-line"></i>
                Quà đã đổi
            </h3>

            <div id="paHistoryList" class="pa-history-list"></div>

            <button class="pa-submit-btn" style="margin-top:16px;" id="paCloseHistoryBtn">
                Đóng
            </button>
        </div>
    </div>

    <div id="paQrModal" class="pa-modal-backdrop" role="dialog" aria-modal="true">
        <div style="width:min(92vw,420px);">
            <div class="pa-qr-wrap">
                <div class="pa-qr-brand">PHUONG ANH REWARDS</div>
                <div id="paQrGiftName" class="pa-qr-gift">—</div>
                <div id="paQrPoints" class="pa-qr-points">— điểm</div>
                <img id="paQrImg" class="pa-qr-img" alt="QR">
                <div id="paQrBranch" class="pa-qr-branch">—</div>
                <button class="pa-small-btn ghost" style="margin-top:14px;background:#fff;color:#0f172a;" id="paCloseQrBtn">
                    Đóng
                </button>
            </div>
        </div>
    </div>

    <div id="paToast" class="pa-toast" role="status" aria-live="polite"></div>
</section>

<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>

<script>
    const PA_INITIAL_PHONE = @json($initialPhone ?? '');
    const PA_INITIAL_NAME = @json($initialName ?? '');
    const PA_ASSET_BASE = @json(url('/'));
    const PA_NO_IMAGE = @json(asset('assets/images/no-image.png'));

    const PA_APP = {
        balance:0,
        gifts:[],
        branches:[],
        stocks:[],
        stockMap:{},
        selected:{
            id:null,
            name:'',
            points:0,
            img:''
        }
    };

    function paEscapeHtml(value){
        return String(value ?? '')
            .replace(/&/g,'&amp;')
            .replace(/</g,'&lt;')
            .replace(/>/g,'&gt;')
            .replace(/"/g,'&quot;')
            .replace(/'/g,'&#039;');
    }

    function paBuildImageUrl(path){
        const value = String(path || '').trim();

        if(!value) return PA_NO_IMAGE;

        if(/^https?:\/\//i.test(value)){
            return value;
        }

        if(value.startsWith('/')){
            return PA_ASSET_BASE + value;
        }

        return 'https://outtech.io.vn' + '/' + value.replace(/^\/+/, '');
    }

    function paMaskPhone(phone){
        if(!phone) return '';
        const s = String(phone).replace(/\D/g,'');
        if(s.length < 7) return phone;
        return s.slice(0,3) + '****' + s.slice(-3);
    }

    function paNormalizePhone(input){
        let s = String(input || '').replace(/\D/g,'');

        if(s.startsWith('0084')){
            s = '0' + s.slice(4);
        }else if(s.startsWith('84')){
            s = '0' + s.slice(2);
        }else if(s.length === 9 && /^[35789]/.test(s)){
            s = '0' + s;
        }

        return s;
    }

    function paIsValidPhone(phone){
        return /^0\d{9,10}$/.test(phone);
    }

    function paFormatPoints(points){
        return (Number(points) || 0).toLocaleString('vi-VN') + ' điểm';
    }

    function paSavePhone(phone){
        localStorage.setItem('user_phone', phone);
        sessionStorage.setItem('user_phone', phone);
    }

    function paGetSavedPhone(){
        return localStorage.getItem('user_phone') || sessionStorage.getItem('user_phone') || null;
    }

    function paClearSavedPhone(){
        localStorage.removeItem('user_phone');
        sessionStorage.removeItem('user_phone');
    }

    function paGetQueryParam(name){
        const url = new URL(window.location.href);
        return url.searchParams.get(name);
    }

    function paClearPhoneParam(){
        const url = new URL(window.location.href);
        url.searchParams.delete('phone');
        history.replaceState({}, document.title, url.pathname + url.search + url.hash);
    }

    function paShowToast(message, type = 'ok'){
        const toast = document.getElementById('paToast');
        if(!toast) return;

        toast.textContent = message;
        toast.classList.remove('ok','err');
        toast.classList.add(type === 'err' ? 'err' : 'ok');
        toast.classList.add('show');

        clearTimeout(window.__paRewardToastTimer);
        window.__paRewardToastTimer = setTimeout(() => {
            toast.classList.remove('show');
        }, 2500);
    }

    function paOpenModal(id){
        const modal = document.getElementById(id);
        if(modal){
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function paCloseModal(id){
        const modal = document.getElementById(id);
        if(modal){
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    function paOpenPhoneModal(){
        const cachedPhone = paGetSavedPhone();

        paOpenModal('paPhoneLoginModal');

        const input = document.getElementById('paInpPhone');
        const logoutRow = document.getElementById('paLogoutRow');

        if(input) input.value = cachedPhone || '';
        if(logoutRow) logoutRow.style.display = cachedPhone ? 'flex' : 'none';

        setTimeout(() => input?.focus(), 80);
    }

    function paUpdateHeaderStatus(phone){
        const wrap = document.getElementById('paHeaderStatus');
        const text = document.getElementById('paStatusText');

        if(phone){
            wrap?.classList.add('logged-in');
            if(text) text.textContent = paMaskPhone(phone);
        }else{
            wrap?.classList.remove('logged-in');
            if(text) text.textContent = 'Chưa nhập SĐT';
        }
    }

    function paSetBalanceUI(points){
        PA_APP.balance = Number(points) || 0;

        const el = document.getElementById('paPointsValue');
        if(el) el.textContent = paFormatPoints(PA_APP.balance);

        paReevaluateButtons();
    }

    function paResetScreen(){
        PA_APP.balance = 0;

        const el = document.getElementById('paPointsValue');
        if(el) el.textContent = '— điểm';

        paUpdateHeaderStatus(null);
        paReevaluateButtons();
    }

    async function paCallApi(url, payload, method = 'POST'){
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || @json(csrf_token());

        const response = await fetch(url, {
            method,
            headers:{
                'Content-Type':'application/json',
                'Accept':'application/json',
                ...(csrf ? {'X-CSRF-TOKEN': csrf} : {})
            },
            body:method === 'GET' ? undefined : JSON.stringify(payload || {})
        });

        const text = await response.text();

        try{
            return JSON.parse(text);
        }catch(e){
            return {
                ok:false,
                msg:'API trả về dữ liệu không hợp lệ.',
                raw:text
            };
        }
    }

    async function paLoadPoints(phone){
        try{
            const response = await paCallApi('https://outtech.io.vn/api/zalo/points', {
                phone:phone,
                zid:null
            });

            if(response.ok){
                paSetBalanceUI(response.points || 0);

                if(response.customer?.name){
                    sessionStorage.setItem('customer_name', response.customer.name);
                }
            }else{
                paSetBalanceUI(0);
                paShowToast(response.msg || 'Không lấy được điểm.', 'err');
            }
        }catch(e){
            paSetBalanceUI(0);
            paShowToast('Không thể tải điểm.', 'err');
        }
    }

    async function paLoadGifts(){
        const grid = document.getElementById('paRewardsGrid');

        try{
            const response = await fetch('https://outtech.io.vn/api/gifts', {
                method:'GET',
                headers:{
                    'Accept':'application/json'
                }
            });

            const data = await response.json();

            if(!data.ok){
                throw new Error('gift_failed');
            }

            PA_APP.gifts = data.gifts || [];
            PA_APP.branches = data.branches || [];
            PA_APP.stocks = data.stocks || [];
            PA_APP.stockMap = {};

            for(const stock of PA_APP.stocks){
                if(!PA_APP.stockMap[stock.product_gift_id]){
                    PA_APP.stockMap[stock.product_gift_id] = {};
                }

                PA_APP.stockMap[stock.product_gift_id][stock.branch_id] = stock.qty;
            }

            paRenderGifts();
        }catch(e){
            if(grid){
                grid.innerHTML = `
                    <div class="pa-empty-state">
                        <i class="ri-wifi-off-line"></i>
                        Không tải được danh sách quà. Vui lòng thử lại sau.
                    </div>
                `;
            }
        }
    }

    async function paSubmitPhone(){
        const input = document.getElementById('paInpPhone');
        const raw = input ? input.value.trim() : '';
        const phone = paNormalizePhone(raw);

        if(!phone){
            paShowToast('Vui lòng nhập số điện thoại.', 'err');
            return;
        }

        if(!paIsValidPhone(phone)){
            paShowToast('Số điện thoại không hợp lệ.', 'err');
            return;
        }

        paSavePhone(phone);
        paUpdateHeaderStatus(phone);
        paCloseModal('paPhoneLoginModal');
        paShowToast('Đã lưu số điện thoại.', 'ok');

        await paLoadPoints(phone);
    }

    function paReevaluateButtons(){
        const hasPhone = !!paGetSavedPhone();

        document.querySelectorAll('.pa-redeem-btn').forEach((btn) => {
            const need = parseInt(btn.dataset.points || '0', 10);
            const soldout = btn.dataset.soldout === '1';

            if(soldout){
                btn.disabled = true;
                btn.innerHTML = '<i class="ri-close-circle-line"></i> Hết quà';
                return;
            }

            if(!hasPhone){
                btn.disabled = false;
                btn.innerHTML = '<i class="ri-phone-line"></i> Nhập SĐT để đổi';
                return;
            }

            if(PA_APP.balance < need){
                btn.disabled = true;
                btn.innerHTML = '<i class="ri-lock-line"></i> Không đủ điểm';
                return;
            }

            btn.disabled = false;
            btn.innerHTML = '<i class="ri-gift-line"></i> Đổi ngay';
        });
    }

    function paRenderGifts(){
        const grid = document.getElementById('paRewardsGrid');

        if(!grid) return;

        if(!PA_APP.gifts.length){
            grid.innerHTML = `
                <div class="pa-empty-state">
                    <i class="ri-gift-line"></i>
                    Chưa có quà tặng nào trong hệ thống.
                </div>
            `;
            return;
        }

        grid.innerHTML = PA_APP.gifts.map((gift) => {
            const id = gift.id;
            const name = gift.name || 'Quà tặng';
            const image = gift.image_url || '';
            const points = gift.points ?? 0;
            const total = gift.total_qty ?? 0;
            const soldout = total <= 0;

            return `
                <article class="pa-gift-card" data-search="${paEscapeHtml(String(name).toLowerCase())}">
                    <div class="pa-gift-image-wrap">
                        <img src="${paBuildImageUrl(image)}" class="pa-gift-image" alt="${paEscapeHtml(name)}">
                        <div class="pa-gift-stock">
                            <i class="ri-store-2-line"></i>
                            Còn ${paEscapeHtml(total)}
                        </div>
                    </div>

                    <div class="pa-gift-info">
                        <h3 class="pa-gift-name">${paEscapeHtml(name)}</h3>

                        <div class="pa-gift-meta">
                            <div class="pa-gift-meta-row">
                                <i class="ri-coins-line"></i>
                                <span>Cần: <span class="pa-gift-points">${paFormatPoints(points)}</span></span>
                            </div>

                            <div class="pa-gift-meta-row">
                                <i class="ri-archive-line"></i>
                                <span>Số lượng: ${paEscapeHtml(total)}</span>
                            </div>
                        </div>

                        <button
                            class="pa-redeem-btn"
                            data-giftid="${paEscapeHtml(id)}"
                            data-name="${paEscapeHtml(name)}"
                            data-points="${paEscapeHtml(points)}"
                            data-img="${paEscapeHtml(image)}"
                            data-soldout="${soldout ? 1 : 0}"
                        >
                            ${soldout ? '<i class="ri-close-circle-line"></i> Hết quà' : '<i class="ri-gift-line"></i> Đổi ngay'}
                        </button>
                    </div>
                </article>
            `;
        }).join('');

        grid.querySelectorAll('.pa-redeem-btn').forEach((btn) => {
            btn.addEventListener('click', paHandleOpenRedeem);
        });

        paReevaluateButtons();
    }

    function paRenderBranchesForGift(giftId){
        const select = document.getElementById('paBranchSelect');
        const badge = document.getElementById('paBranchQtyBadge');
        const stocks = PA_APP.stockMap[giftId] || {};

        if(!select || !badge) return;

        select.innerHTML = '<option value="">Chọn chi nhánh nhận quà</option>' + (PA_APP.branches || []).map((branch) => {
            const branchId = branch.id;
            const branchName = branch.name || branch.branch_name || 'Chi nhánh';
            const qty = stocks[branchId] ?? 0;

            return `<option value="${paEscapeHtml(branchId)}" data-qty="${paEscapeHtml(qty)}">${paEscapeHtml(branchName)} — Tồn: ${paEscapeHtml(qty)}</option>`;
        }).join('');

        badge.style.display = 'none';

        select.onchange = function () {
            const option = select.options[select.selectedIndex];
            const qty = parseInt(option?.dataset?.qty || '0', 10);

            if(!select.value){
                badge.style.display = 'none';
                return;
            }

            badge.textContent = `Tồn tại chi nhánh: ${qty}`;
            badge.style.display = 'inline-flex';

            if(qty <= 0){
                paShowToast('Quà tại chi nhánh này đã hết.', 'err');
            }
        };
    }

    function paHandleOpenRedeem(event){
        const phone = paGetSavedPhone();

        if(!phone){
            paShowToast('Vui lòng nhập số điện thoại trước khi đổi quà.', 'err');
            paOpenPhoneModal();
            return;
        }

        const btn = event.currentTarget;
        const need = parseInt(btn.dataset.points || '0', 10);
        const name = btn.dataset.name || 'Quà tặng';
        const image = btn.dataset.img || '';
        const id = btn.dataset.giftid;

        if(btn.disabled){
            return;
        }

        if(PA_APP.balance < need){
            paShowToast('Không đủ điểm để đổi quà.', 'err');
            return;
        }

        PA_APP.selected = {
            id:id,
            name:name,
            points:need,
            img:image
        };

        document.getElementById('paModalRewardName').textContent = name;
        document.getElementById('paModalRewardPoints').textContent = paFormatPoints(need);
        document.getElementById('paModalRewardImg').src = paBuildImageUrl(image);

        const customerName = sessionStorage.getItem('customer_name') || PA_INITIAL_NAME || '';

        document.getElementById('paCustomerPhone').value = phone;
        document.getElementById('paCustomerName').value = customerName;

        paRenderBranchesForGift(+id);
        paOpenModal('paRedeemModal');
    }

    async function paSubmitRedeem(){
        const btn = document.getElementById('paBtnSubmitRedeem');
        const select = document.getElementById('paBranchSelect');

        const branchId = select.value;
        const selectedQty = parseInt(select.options[select.selectedIndex]?.dataset?.qty || '0', 10);
        const customerName = document.getElementById('paCustomerName').value.trim();
        const customerPhone = paNormalizePhone(document.getElementById('paCustomerPhone').value);

        if(!PA_APP.selected.id){
            paShowToast('Chưa chọn quà.', 'err');
            return;
        }

        if(!branchId || !customerName || !customerPhone){
            paShowToast('Vui lòng điền đủ thông tin.', 'err');
            return;
        }

        if(!paIsValidPhone(customerPhone)){
            paShowToast('Số điện thoại không hợp lệ.', 'err');
            return;
        }

        if(selectedQty <= 0){
            paShowToast('Quà tại chi nhánh này đã hết.', 'err');
            return;
        }

        if(PA_APP.balance < PA_APP.selected.points){
            paShowToast('Điểm không đủ.', 'err');
            return;
        }

        try{
            btn.disabled = true;
            btn.innerHTML = '<i class="ri-loader-4-line"></i> Đang xử lý...';

            const response = await paCallApi('https://outtech.io.vn/api/zalo/redeem', {
                zid:null,
                phone:customerPhone,
                gift_id:PA_APP.selected.id,
                branch_id:branchId,
                customer_name:customerName
            });

            if(!response.ok){
                paShowToast(response.msg || 'Đổi quà thất bại.', 'err');
                return;
            }

            const balance = typeof response.balance === 'number'
                ? response.balance
                : PA_APP.balance - PA_APP.selected.points;

            paSavePhone(customerPhone);
            paUpdateHeaderStatus(customerPhone);
            paSetBalanceUI(balance);

            sessionStorage.setItem('customer_name', customerName);

            paShowToast(response.msg || 'Đổi quà thành công!', 'ok');
            paCloseModal('paRedeemModal');

            await paLoadGifts();
        }catch(e){
            paShowToast('Không thể gửi yêu cầu đổi quà.', 'err');
        }finally{
            btn.disabled = false;
            btn.innerHTML = '<i class="ri-checkbox-circle-line"></i> Xác nhận đổi quà';
        }
    }

    function paStatusLabel(status){
        switch(status){
            case 'approved':
                return 'Đã duyệt';
            case 'cancelled':
                return 'Đã huỷ';
            case 'pending':
                return 'Chờ duyệt';
            case 'fulfilled':
                return 'Hoàn thành';
            case 'requested':
                return 'Đã yêu cầu';
            default:
                return status || 'Đã yêu cầu';
        }
    }

    function paStatusClass(status){
        if(status === 'approved') return 'pa-status-approved';
        if(status === 'fulfilled') return 'pa-status-fulfilled';
        if(status === 'cancelled') return 'pa-status-cancelled';
        if(status === 'pending') return 'pa-status-pending';
        return 'pa-status-requested';
    }

    async function paLoadHistory(){
        const phone = paGetSavedPhone();

        if(!phone){
            paShowToast('Vui lòng nhập số điện thoại để xem quà đã đổi.', 'err');
            paOpenPhoneModal();
            return;
        }

        try{
            const params = new URLSearchParams();
            params.set('phone', phone);

            const response = await fetch('https://outtech.io.vn/api/gifts/history?' + params.toString(), {
                method:'GET',
                headers:{
                    'Accept':'application/json'
                }
            });

            const data = await response.json();

            if(!data.ok){
                paShowToast(data.msg || 'Không tải được lịch sử.', 'err');
                return;
            }

            const list = data.items || [];
            const wrap = document.getElementById('paHistoryList');

            if(!list.length){
                wrap.innerHTML = `
                    <div class="pa-empty-state" style="padding:24px 16px;">
                        <i class="ri-inbox-line"></i>
                        Chưa có lượt đổi quà nào.
                    </div>
                `;
            }else{
                wrap.innerHTML = list.map((item) => {
                    const image = paBuildImageUrl(item.gift_image_url || '');
                    const statusClass = paStatusClass(item.status || 'requested');

                    return `
                        <div class="pa-history-item">
                            <img class="pa-history-img" src="${image}" alt="">

                            <div>
                                <div class="pa-history-name">${paEscapeHtml(item.gift_name || 'Quà tặng')}</div>
                                <div class="pa-history-meta">${paFormatPoints(item.points_cost || 0)} · SL: ${paEscapeHtml(item.quantity || 1)} · ${paEscapeHtml(item.branch_name || '')}</div>
                                <div class="pa-history-meta">${paEscapeHtml(item.created_at || '')}</div>
                                <span class="pa-status-badge ${statusClass}">${paEscapeHtml(paStatusLabel(item.status || 'requested'))}</span>
                            </div>

                            <button class="pa-qr-btn" data-id="${paEscapeHtml(item.id)}">
                                <i class="ri-qr-code-line"></i>
                                QR
                            </button>
                        </div>
                    `;
                }).join('');

                wrap.querySelectorAll('.pa-qr-btn').forEach((button) => {
                    button.addEventListener('click', function () {
                        const id = button.dataset.id;
                        const item = list.find((x) => String(x.id) === String(id)) || {};
                        paOpenQRForItem(id, item);
                    });
                });
            }

            paOpenModal('paHistoryModal');
        }catch(e){
            paShowToast('Không thể tải lịch sử.', 'err');
        }
    }

    function paOpenQRForItem(id, item){
        const payload = `EG:${id}`;
        const imgEl = document.getElementById('paQrImg');

        document.getElementById('paQrGiftName').textContent = item.gift_name || 'Quà tặng';
        document.getElementById('paQrPoints').textContent = paFormatPoints(item.points_cost || 0);
        document.getElementById('paQrBranch').textContent = item.branch_name ? ('Nhận tại: ' + item.branch_name) : '';

        if(window.QRCode && typeof QRCode.toDataURL === 'function'){
            QRCode.toDataURL(payload, {
                width:260,
                margin:1,
                errorCorrectionLevel:'M'
            })
            .then((url) => {
                imgEl.src = url;
                paOpenModal('paQrModal');
            })
            .catch(() => {
                imgEl.src = 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=' + encodeURIComponent(payload);
                paOpenModal('paQrModal');
            });
        }else{
            imgEl.src = 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=' + encodeURIComponent(payload);
            paOpenModal('paQrModal');
        }
    }

    function paFilterGifts(){
        const input = document.getElementById('paGiftSearch');
        const keyword = String(input?.value || '').toLowerCase().trim();

        document.querySelectorAll('.pa-gift-card').forEach((card) => {
            const text = String(card.dataset.search || '').toLowerCase();
            card.style.display = !keyword || text.includes(keyword) ? '' : 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        // SĐT được khoá theo tài khoản đã đăng nhập OTP, không cho phép tự đổi sang số khác.
        document.getElementById('paChangePhoneBtn')?.addEventListener('click', function () {
            paShowToast('Số điện thoại được lấy từ tài khoản đã đăng nhập, không thể đổi tại đây.', 'ok');
        });
        document.getElementById('paBtnClosePhone')?.addEventListener('click', () => paCloseModal('paPhoneLoginModal'));
        document.getElementById('paClosePhoneX')?.addEventListener('click', () => paCloseModal('paPhoneLoginModal'));

        document.getElementById('paBtnSubmitRedeem')?.addEventListener('click', paSubmitRedeem);
        document.getElementById('paCloseRedeemX')?.addEventListener('click', () => paCloseModal('paRedeemModal'));

        document.getElementById('paBtnHistory')?.addEventListener('click', paLoadHistory);
        document.getElementById('paCloseHistoryX')?.addEventListener('click', () => paCloseModal('paHistoryModal'));
        document.getElementById('paCloseHistoryBtn')?.addEventListener('click', () => paCloseModal('paHistoryModal'));

        document.getElementById('paCloseQrBtn')?.addEventListener('click', () => paCloseModal('paQrModal'));

        document.getElementById('paGiftSearch')?.addEventListener('input', paFilterGifts);

        document.getElementById('paInpPhone')?.addEventListener('keydown', function (event) {
            if(event.key === 'Enter'){
                event.preventDefault();
                paSubmitPhone();
            }
        });

        document.querySelectorAll('.js-dev-feature').forEach((button) => {
            button.addEventListener('click', function () {
                paShowToast('Tính năng đang được phát triển.', 'ok');
            });
        });

        window.addEventListener('click', function (event) {
            if(event.target === document.getElementById('paRedeemModal')) paCloseModal('paRedeemModal');
            if(event.target === document.getElementById('paPhoneLoginModal')) paCloseModal('paPhoneLoginModal');
            if(event.target === document.getElementById('paHistoryModal')) paCloseModal('paHistoryModal');
            if(event.target === document.getElementById('paQrModal')) paCloseModal('paQrModal');
        });

        paLoadGifts();

        // Bảo mật: trang này chỉ truy cập được khi đã đăng nhập OTP (middleware website_customer.auth).
        // SĐT luôn lấy từ tài khoản đã xác thực phía server (PA_INITIAL_PHONE), KHÔNG cho phép đổi
        // sang SĐT khác qua URL/localStorage/nhập tay để tránh xem/đổi điểm của người khác.
        paClearPhoneParam();
        paClearSavedPhone();

        const verifiedPhone = paNormalizePhone(PA_INITIAL_PHONE);

        if(verifiedPhone && paIsValidPhone(verifiedPhone)){
            paSavePhone(verifiedPhone);
            paUpdateHeaderStatus(verifiedPhone);
            paLoadPoints(verifiedPhone);
        }
    });
</script>
@endsection