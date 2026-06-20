@extends('website.layout.index')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">

<style>
    .pa-rx-page{
        background:#f5f7fb;
        padding:28px 0 44px;
    }

    .pa-rx-container{
        width:min(1320px, calc(100% - 32px));
        margin:0 auto;
    }

    .pa-rx-hero{
        background:linear-gradient(135deg,#0f8f65 0%,#2563eb 100%);
        color:#fff;
        border-radius:28px;
        padding:30px;
        margin-bottom:24px;
        position:relative;
        overflow:hidden;
        box-shadow:0 18px 40px rgba(37,99,235,.18);
        display:grid;
        grid-template-columns:minmax(0,1fr) 430px;
        gap:28px;
        align-items:center;
    }

    .pa-rx-hero::after{
        content:"";
        position:absolute;
        width:260px;
        height:260px;
        right:-70px;
        top:-80px;
        border-radius:50%;
        background:rgba(255,255,255,.16);
    }

    .pa-rx-hero::before{
        content:"";
        position:absolute;
        width:180px;
        height:180px;
        right:160px;
        bottom:-90px;
        border-radius:50%;
        background:rgba(255,255,255,.08);
    }

    .pa-rx-hero-content{
        position:relative;
        z-index:2;
        max-width:780px;
    }

    .pa-rx-hero-badge{
        display:inline-flex;
        align-items:center;
        gap:8px;
        min-height:36px;
        padding:0 14px;
        border-radius:999px;
        background:rgba(255,255,255,.18);
        color:#fff;
        font-size:13px;
        font-weight:800;
        margin-bottom:14px;
        backdrop-filter: blur(6px);
    }

    .pa-rx-hero-badge i{
        font-size:18px;
        line-height:1;
    }

    .pa-rx-hero h1{
        margin:0 0 12px;
        font-size:40px;
        line-height:1.18;
        font-weight:900;
        letter-spacing:-.02em;
    }

    .pa-rx-hero p{
        margin:0;
        max-width:760px;
        font-size:16px;
        line-height:1.8;
        color:rgba(255,255,255,.92);
    }

    .pa-rx-hero-tags{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
        margin-top:18px;
    }

    .pa-rx-hero-tags span{
        min-height:36px;
        padding:0 13px;
        border-radius:999px;
        background:rgba(255,255,255,.16);
        display:inline-flex;
        align-items:center;
        gap:7px;
        font-size:13px;
        font-weight:800;
        backdrop-filter: blur(6px);
    }

    .pa-rx-hero-tags i{
        font-size:17px;
        line-height:1;
    }

    .pa-rx-hero-visual{
        position:relative;
        z-index:2;
        border-radius:26px;
        overflow:hidden;
        background:rgba(255,255,255,.16);
        border:1px solid rgba(255,255,255,.22);
        box-shadow:0 24px 52px rgba(15,23,42,.22);
    }

    .pa-rx-hero-visual img{
        display:block;
        width:100%;
        aspect-ratio:16 / 11;
        object-fit:cover;
    }

    .pa-rx-flow{
        display:grid;
        grid-template-columns:repeat(3,minmax(0,1fr));
        gap:14px;
        margin:-4px 0 24px;
    }

    .pa-rx-flow-item{
        background:#fff;
        border:1px solid #e2e8f0;
        border-radius:22px;
        padding:18px;
        box-shadow:0 12px 30px rgba(15,23,42,.05);
        display:grid;
        grid-template-columns:48px minmax(0,1fr);
        gap:14px;
        align-items:start;
    }

    .pa-rx-flow-num{
        width:48px;
        height:48px;
        border-radius:16px;
        background:#eaf7f3;
        color:#0f8f65;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:20px;
        font-weight:900;
    }

    .pa-rx-flow-item:nth-child(2) .pa-rx-flow-num{
        background:#eff6ff;
        color:#2563eb;
    }

    .pa-rx-flow-item:nth-child(3) .pa-rx-flow-num{
        background:#fff7ed;
        color:#ea580c;
    }

    .pa-rx-flow-item h3{
        margin:0 0 6px;
        color:#0f172a;
        font-size:16px;
        font-weight:900;
    }

    .pa-rx-flow-item p{
        margin:0;
        color:#64748b;
        font-size:13px;
        line-height:1.65;
    }

    .pa-rx-layout{
        display:grid;
        grid-template-columns:minmax(0,1fr) 390px;
        gap:22px;
        align-items:start;
    }

    .pa-rx-card{
        background:#fff;
        border-radius:24px;
        padding:22px;
        border:1px solid #edf2f7;
        box-shadow:0 14px 35px rgba(15,23,42,.06);
    }

    .pa-rx-card-title{
        margin:0 0 16px;
        font-size:24px;
        font-weight:900;
        color:#0f172a;
        letter-spacing:-.01em;
        display:flex;
        align-items:center;
        gap:10px;
    }

    .pa-rx-card-title i{
        width:38px;
        height:38px;
        border-radius:14px;
        background:#eff6ff;
        color:#2563eb;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        font-size:21px;
        flex:0 0 38px;
    }

    .pa-rx-card-sub{
        margin:-8px 0 18px;
        color:#64748b;
        font-size:14px;
        line-height:1.7;
    }

    .pa-alert{
        padding:14px 16px;
        border-radius:16px;
        font-size:14px;
        font-weight:800;
        margin-bottom:18px;
        line-height:1.6;
        display:flex;
        align-items:flex-start;
        gap:10px;
    }

    .pa-alert i{
        font-size:20px;
        line-height:1.3;
        flex:0 0 auto;
    }

    .pa-alert-success{
        background:#ecfdf5;
        color:#15803d;
        border:1px solid #bbf7d0;
    }

    .pa-alert-danger{
        background:#fef2f2;
        color:#dc2626;
        border:1px solid #fecaca;
    }

    .pa-rx-form-grid{
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:16px;
    }

    .pa-rx-form-group{
        display:flex;
        flex-direction:column;
        gap:8px;
    }

    .pa-rx-form-group.full{
        grid-column:1 / -1;
    }

    .pa-rx-form-group label{
        font-size:14px;
        font-weight:900;
        color:#0f172a;
        display:flex;
        align-items:center;
        gap:7px;
    }

    .pa-rx-form-group label i{
        color:#2563eb;
        font-size:17px;
        line-height:1;
    }

    .pa-rx-form-group input,
    .pa-rx-form-group textarea{
        width:100%;
        border:1px solid #dbe4f0;
        border-radius:16px;
        background:#fff;
        color:#0f172a;
        outline:none;
        font-size:15px;
        font-family: ui-sans-serif, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
        letter-spacing:-.01em;
        transition:border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .pa-rx-form-group input{
        min-height:50px;
        padding:0 14px;
    }

    .pa-rx-form-group textarea{
        min-height:120px;
        resize:vertical;
        padding:13px 14px;
        line-height:1.7;
    }

    .pa-rx-form-group input::placeholder,
    .pa-rx-form-group textarea::placeholder{
        color:#94a3b8;
        font-family: ui-sans-serif, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
    }

    .pa-rx-form-group input:focus,
    .pa-rx-form-group textarea:focus{
        border-color:#2563eb;
        box-shadow:0 0 0 3px rgba(37,99,235,.08);
        background:#fff;
    }

    .pa-rx-error{
        font-size:13px;
        color:#dc2626;
        font-weight:800;
        display:flex;
        align-items:center;
        gap:6px;
    }

    .pa-rx-error::before{
        content:"\ea0f";
        font-family:"remixicon";
        font-size:15px;
        line-height:1;
    }

    .pa-upload-box{
        border:1px dashed #bcd1f5;
        border-radius:20px;
        background:#f8fbff;
        padding:18px;
        text-align:center;
        position:relative;
        transition:border-color .2s ease, background .2s ease;
    }

    .pa-upload-box:hover{
        border-color:#7da7f4;
        background:#f3f8ff;
    }

    .pa-upload-box input[type="file"]{
        display:none;
    }

    .pa-upload-label{
        min-height:120px;
        border-radius:18px;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        gap:8px;
        cursor:pointer;
        color:#334155;
    }

    .pa-upload-icon{
        width:58px;
        height:58px;
        border-radius:50%;
        background:#eff6ff;
        color:#2563eb;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:28px;
    }

    .pa-upload-icon i{
        font-size:30px;
        line-height:1;
    }

    .pa-upload-title{
        font-size:16px;
        font-weight:900;
        color:#0f172a;
    }

    .pa-upload-desc{
        font-size:13px;
        color:#64748b;
        line-height:1.6;
    }

    .pa-photo-guide{
        margin-top:14px;
        display:grid;
        grid-template-columns:repeat(3,minmax(0,1fr));
        gap:10px;
    }

    .pa-photo-guide span{
        min-height:40px;
        border-radius:14px;
        background:#fff;
        border:1px solid #e2e8f0;
        color:#334155;
        font-size:12px;
        font-weight:800;
        display:flex;
        align-items:center;
        gap:7px;
        padding:8px 10px;
        line-height:1.35;
    }

    .pa-photo-guide i{
        color:#0f8f65;
        font-size:17px;
        flex:0 0 auto;
    }

    .pa-preview-wrap{
        display:none;
        margin-top:14px;
        text-align:left;
    }

    .pa-preview-wrap.show{
        display:block;
    }

    .pa-preview-image{
        width:100%;
        max-height:380px;
        border-radius:18px;
        object-fit:contain;
        background:#fff;
        border:1px solid #e2e8f0;
        display:block;
    }

    .pa-preview-actions{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:10px;
        margin-top:10px;
        flex-wrap:wrap;
    }

    .pa-preview-name{
        color:#64748b;
        font-size:13px;
        font-weight:700;
        display:flex;
        align-items:center;
        gap:6px;
    }

    .pa-preview-name::before{
        content:"\ec9e";
        font-family:"remixicon";
        color:#2563eb;
        font-size:16px;
    }

    .pa-remove-preview{
        border:0;
        background:#fef2f2;
        color:#dc2626;
        min-height:36px;
        padding:0 12px;
        border-radius:999px;
        font-weight:800;
        cursor:pointer;
        display:inline-flex;
        align-items:center;
        gap:6px;
    }

    .pa-remove-preview i{
        font-size:16px;
    }

    .pa-submit-btn{
        width:100%;
        min-height:56px;
        border:0;
        border-radius:999px;
        background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);
        color:#fff;
        font-size:17px;
        font-weight:900;
        cursor:pointer;
        box-shadow:0 14px 28px rgba(37,99,235,.2);
        margin-top:18px;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:9px;
        transition:transform .2s ease, box-shadow .2s ease, opacity .2s ease;
    }

    .pa-submit-btn i{
        font-size:20px;
        line-height:1;
    }

    .pa-submit-btn:hover{
        transform:translateY(-1px);
        box-shadow:0 18px 34px rgba(37,99,235,.24);
    }

    .pa-submit-btn:active{
        transform:translateY(0);
    }

    .pa-contact-box{
        display:grid;
        gap:16px;
        position:sticky;
        top:18px;
    }

    .pa-guide-card{
        background:#fff;
        border-radius:24px;
        padding:20px;
        border:1px solid #edf2f7;
        box-shadow:0 14px 35px rgba(15,23,42,.06);
    }

    .pa-guide-card img{
        width:100%;
        border-radius:20px;
        display:block;
        border:1px solid #e2e8f0;
        margin-bottom:16px;
    }

    .pa-guide-card h3{
        margin:0 0 12px;
        color:#0f172a;
        font-size:20px;
        font-weight:900;
        display:flex;
        align-items:center;
        gap:8px;
    }

    .pa-guide-card h3 i{
        color:#0f8f65;
        font-size:22px;
    }

    .pa-guide-list{
        display:grid;
        gap:10px;
        margin:0;
        padding:0;
        list-style:none;
    }

    .pa-guide-list li{
        display:grid;
        grid-template-columns:28px minmax(0,1fr);
        gap:10px;
        align-items:start;
        color:#334155;
        font-size:14px;
        line-height:1.6;
    }

    .pa-guide-list i{
        width:28px;
        height:28px;
        border-radius:10px;
        background:#ecfdf5;
        color:#16a34a;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:16px;
    }

    .pa-contact-item{
        background:#fff;
        border-radius:24px;
        padding:20px;
        border:1px solid #edf2f7;
        box-shadow:0 14px 35px rgba(15,23,42,.06);
    }

    .pa-contact-icon{
        width:56px;
        height:56px;
        border-radius:18px;
        background:#eff6ff;
        color:#2563eb;
        display:flex;
        align-items:center;
        justify-content:center;
        margin-bottom:14px;
    }

    .pa-contact-icon i{
        font-size:29px;
        line-height:1;
    }

    .pa-contact-item h3{
        margin:0 0 8px;
        font-size:20px;
        font-weight:900;
        color:#0f172a;
        display:flex;
        align-items:center;
        gap:8px;
    }

    .pa-contact-item h3 i{
        font-size:20px;
        color:#2563eb;
    }

    .pa-contact-item p{
        margin:0 0 16px;
        color:#64748b;
        font-size:14px;
        line-height:1.7;
    }

    .pa-contact-btn{
        min-height:46px;
        padding:0 16px;
        border-radius:999px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        text-decoration:none;
        font-size:15px;
        font-weight:900;
        width:100%;
    }

    .pa-contact-btn i{
        font-size:19px;
        line-height:1;
    }

    .pa-contact-btn.primary{
        background:linear-gradient(135deg,#16a34a 0%,#15803d 100%);
        color:#fff;
    }

    .pa-contact-btn.zalo{
        background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);
        color:#fff;
    }

    .pa-list-section{
        margin-top:24px;
    }

    .pa-list-head{
        display:flex;
        justify-content:space-between;
        align-items:flex-end;
        gap:16px;
        flex-wrap:wrap;
        margin-bottom:16px;
    }

    .pa-list-head h2{
        margin:0 0 6px;
        font-size:28px;
        font-weight:900;
        color:#0f172a;
        letter-spacing:-.01em;
        display:flex;
        align-items:center;
        gap:10px;
    }

    .pa-list-head h2 i{
        width:40px;
        height:40px;
        border-radius:14px;
        background:#eff6ff;
        color:#2563eb;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        font-size:22px;
    }

    .pa-list-head p{
        margin:0;
        color:#64748b;
        line-height:1.7;
        font-size:14px;
    }

    .pa-request-stats{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
    }

    .pa-request-stat{
        min-height:38px;
        padding:0 12px;
        border-radius:999px;
        background:#fff;
        border:1px solid #e2e8f0;
        color:#334155;
        display:inline-flex;
        align-items:center;
        gap:6px;
        font-size:13px;
        font-weight:800;
    }

    .pa-request-stat i{
        font-size:16px;
        color:#2563eb;
    }

    .pa-request-list{
        display:grid;
        gap:16px;
    }

    .pa-request-card{
        background:#fff;
        border:1px solid #edf2f7;
        border-radius:24px;
        padding:18px;
        box-shadow:0 14px 35px rgba(15,23,42,.06);
    }

    .pa-request-card-head{
        display:flex;
        justify-content:space-between;
        gap:14px;
        flex-wrap:wrap;
        margin-bottom:14px;
    }

    .pa-request-code{
        margin:0 0 6px;
        font-size:20px;
        font-weight:900;
        color:#0f172a;
        display:flex;
        align-items:center;
        gap:8px;
    }

    .pa-request-code i{
        color:#2563eb;
        font-size:21px;
    }

    .pa-request-date{
        color:#64748b;
        font-size:13px;
        font-weight:700;
        display:flex;
        align-items:center;
        gap:6px;
    }

    .pa-request-date i{
        font-size:16px;
        color:#94a3b8;
    }

    .pa-badge{
        min-height:34px;
        padding:0 12px;
        border-radius:999px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:6px;
        font-size:13px;
        font-weight:900;
    }

    .pa-badge i{
        font-size:15px;
        line-height:1;
    }

    .pa-badge.is-pending{
        background:#fff7ed;
        color:#c2410c;
    }

    .pa-badge.is-confirmed{
        background:#eff6ff;
        color:#1d4ed8;
    }

    .pa-badge.is-processed{
        background:#ecfdf5;
        color:#15803d;
    }

    .pa-badge.is-default{
        background:#f1f5f9;
        color:#334155;
    }

    .pa-request-main{
        display:grid;
        grid-template-columns:110px minmax(0,1fr);
        gap:14px;
        align-items:start;
    }

    .pa-request-thumb{
        width:110px;
        height:110px;
        border-radius:18px;
        overflow:hidden;
        background:#f8fafc;
        border:1px solid #e2e8f0;
    }

    .pa-request-thumb img{
        width:100%;
        height:100%;
        object-fit:cover;
    }

    .pa-request-noimg{
        width:110px;
        height:110px;
        border-radius:18px;
        background:#f8fafc;
        border:1px dashed #cbd5e1;
        color:#64748b;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        text-align:center;
        padding:10px;
        font-size:12px;
        font-weight:800;
        gap:6px;
    }

    .pa-request-noimg i{
        font-size:24px;
        color:#94a3b8;
    }

    .pa-request-text{
        color:#334155;
        font-size:14px;
        line-height:1.8;
    }

    .pa-request-text strong{
        color:#0f172a;
        display:inline-flex;
        align-items:center;
        gap:5px;
    }

    .pa-request-text strong i{
        color:#2563eb;
        font-size:15px;
    }

    .pa-request-extra{
        display:none;
        margin-top:14px;
        padding-top:14px;
        border-top:1px dashed #dbe4f0;
    }

    .pa-request-extra.show{
        display:block;
    }

    .pa-request-response{
        background:#f8fafc;
        border:1px solid #e2e8f0;
        border-radius:16px;
        padding:14px;
        color:#334155;
        line-height:1.8;
        font-size:14px;
    }

    .pa-request-response strong{
        color:#0f172a;
    }

    .pa-request-actions{
        display:flex;
        justify-content:flex-end;
        margin-top:14px;
    }

    .pa-toggle-btn{
        border:0;
        background:#eff6ff;
        color:#1d4ed8;
        min-height:40px;
        padding:0 14px;
        border-radius:999px;
        font-size:14px;
        font-weight:900;
        cursor:pointer;
        display:inline-flex;
        align-items:center;
        gap:7px;
    }

    .pa-toggle-btn i{
        font-size:17px;
    }

    .pa-empty-box{
        background:#fff;
        border:1px dashed #dbe4f0;
        border-radius:24px;
        padding:30px 20px;
        text-align:center;
        color:#64748b;
        line-height:1.8;
    }

    .pa-empty-box i{
        display:flex;
        width:56px;
        height:56px;
        margin:0 auto 12px;
        border-radius:50%;
        background:#eff6ff;
        color:#2563eb;
        align-items:center;
        justify-content:center;
        font-size:28px;
    }

    .pa-brand-box{
        margin-top:24px;
        border-radius:28px;
        background:linear-gradient(135deg,#ecfdf5 0%,#eff6ff 100%);
        border:1px solid #dbeafe;
        padding:26px;
        display:grid;
        grid-template-columns:80px minmax(0,1fr);
        gap:18px;
        align-items:center;
    }

    .pa-brand-icon{
        width:80px;
        height:80px;
        border-radius:26px;
        background:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#16a34a;
        box-shadow:0 12px 24px rgba(15,23,42,.08);
    }

    .pa-brand-icon i{
        font-size:42px;
        line-height:1;
    }

    .pa-brand-box h2{
        margin:0 0 8px;
        color:#0f172a;
        font-size:26px;
        font-weight:900;
        letter-spacing:-.01em;
    }

    .pa-brand-box p{
        margin:0;
        color:#334155;
        line-height:1.8;
        font-size:15px;
    }

    @media(max-width:1100px){
        .pa-rx-hero{
            grid-template-columns:1fr;
        }

        .pa-rx-hero-visual{
            max-width:620px;
        }

        .pa-rx-flow{
            grid-template-columns:1fr;
        }

        .pa-rx-layout{
            grid-template-columns:1fr;
        }

        .pa-contact-box{
            position:static;
            grid-template-columns:repeat(2,minmax(0,1fr));
        }
    }

    @media(max-width:768px){
        .pa-rx-page{
            padding:18px 0 30px;
        }

        .pa-rx-container{
            width:min(100%, calc(100% - 20px));
        }

        .pa-rx-hero{
            border-radius:22px;
            padding:22px;
        }

        .pa-rx-hero h1{
            font-size:28px;
        }

        .pa-rx-form-grid,
        .pa-photo-guide,
        .pa-contact-box{
            grid-template-columns:1fr;
        }

        .pa-request-main{
            grid-template-columns:1fr;
        }

        .pa-request-thumb,
        .pa-request-noimg{
            width:100%;
            height:220px;
        }

        .pa-brand-box{
            grid-template-columns:1fr;
            text-align:center;
        }

        .pa-brand-icon{
            margin:0 auto;
        }

        .pa-list-head h2{
            font-size:24px;
        }
    }
</style>
@endsection

@section('content')
<section class="pa-rx-page">
    <div class="pa-rx-container">
        <div class="pa-rx-hero">
            <div class="pa-rx-hero-content">
                <div class="pa-rx-hero-badge">
                    <i class="ri-capsule-line"></i>
                    <span>Dược sĩ hỗ trợ 24/7</span>
                </div>

                <h1>Gửi đơn thuốc cho Dược Phương Anh</h1>

                <p>
                    Chụp ảnh đơn thuốc hoặc nhập nội dung thuốc cần mua, dược sĩ Nhà thuốc Phương Anh sẽ kiểm tra
                    và liên hệ tư vấn lại cho bạn trong thời gian sớm nhất.
                </p>

                <div class="pa-rx-hero-tags">
                    <span><i class="ri-shield-check-line"></i> Bảo mật thông tin khách hàng</span>
                    <span><i class="ri-chat-smile-2-line"></i> Hỗ trợ qua Zalo OA</span>
                    <span><i class="ri-nurse-line"></i> Tư vấn bởi dược sĩ</span>
                </div>
            </div>

            <div class="pa-rx-hero-visual">
                <img
                    src="{{ asset('phuonganh/img/prescription-guide-v2.png') }}"
                    alt="Minh họa quy trình gửi đơn thuốc và nhận tư vấn từ dược sĩ"
                    loading="eager"
                >
            </div>
        </div>

        <div class="pa-rx-flow" aria-label="Quy trình gửi yêu cầu mua thuốc">
            <div class="pa-rx-flow-item">
                <div class="pa-rx-flow-num">1</div>
                <div>
                    <h3>Gửi ảnh hoặc nội dung đơn</h3>
                    <p>Chụp rõ đơn thuốc, nhập thêm tên thuốc, số lượng và ghi chú nếu cần tư vấn thay thế.</p>
                </div>
            </div>

            <div class="pa-rx-flow-item">
                <div class="pa-rx-flow-num">2</div>
                <div>
                    <h3>Dược sĩ kiểm tra</h3>
                    <p>Đội ngũ dược sĩ đối chiếu thông tin, kiểm tra thuốc kê đơn và liên hệ lại khi cần xác nhận.</p>
                </div>
            </div>

            <div class="pa-rx-flow-item">
                <div class="pa-rx-flow-num">3</div>
                <div>
                    <h3>Nhận tư vấn và mua thuốc</h3>
                    <p>Bạn được báo tình trạng thuốc, hướng dẫn sử dụng phù hợp và chọn nhận tại nhà thuốc hoặc giao hàng.</p>
                </div>
            </div>
        </div>

        <div class="pa-rx-layout">
            <div class="pa-rx-card">
                <h2 class="pa-rx-card-title">
                    <i class="ri-file-list-3-line"></i>
                    <span>Thông tin yêu cầu mua thuốc</span>
                </h2>

                <div class="pa-rx-card-sub">
                    Bạn có thể upload ảnh đơn thuốc, nhập thêm nội dung hoặc ghi chú để dược sĩ tư vấn chính xác hơn.
                </div>

                @if(session('success'))
                    <div class="pa-alert pa-alert-success">
                        <i class="ri-checkbox-circle-line"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="pa-alert pa-alert-danger">
                        <i class="ri-error-warning-line"></i>
                        <span>Vui lòng kiểm tra lại thông tin trong form.</span>
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('website.prescription_request_v1.store') }}"
                    enctype="multipart/form-data"
                    id="paPrescriptionForm"
                >
                    @csrf

                    <div class="pa-rx-form-grid">
                        <div class="pa-rx-form-group">
                            <label>
                                <i class="ri-user-3-line"></i>
                                Họ và tên *
                            </label>
                            <input
                                type="text"
                                name="customer_name"
                                value="{{ old('customer_name', $guestCheckoutInfo['customer_name'] ?? '') }}"
                                placeholder="Nhập họ và tên"
                            >
                            @error('customer_name') <div class="pa-rx-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="pa-rx-form-group">
                            <label>
                                <i class="ri-phone-line"></i>
                                Số điện thoại *
                            </label>
                            <input
                                type="text"
                                name="customer_phone"
                                value="{{ old('customer_phone', $guestCheckoutInfo['customer_phone'] ?? '') }}"
                                placeholder="Nhập số điện thoại"
                            >
                            @error('customer_phone') <div class="pa-rx-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="pa-rx-form-group full">
                            <label>
                                <i class="ri-map-pin-line"></i>
                                Địa chỉ liên hệ / nhận thuốc
                            </label>
                            <textarea
                                name="customer_address"
                                placeholder="Nhập địa chỉ liên hệ hoặc địa chỉ nhận thuốc"
                            >{{ old('customer_address', $customerAddress ?? '') }}</textarea>
                            @error('customer_address') <div class="pa-rx-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="pa-rx-form-group full">
                            <label>
                                <i class="ri-image-add-line"></i>
                                Ảnh đơn thuốc
                            </label>

                            <div class="pa-upload-box">
                                <input
                                    type="file"
                                    name="prescription_image"
                                    id="paPrescriptionImage"
                                    accept="image/jpeg,image/png,image/webp,image/jpg"
                                >

                                <label for="paPrescriptionImage" class="pa-upload-label" id="paUploadLabel">
                                    <div class="pa-upload-icon">
                                        <i class="ri-camera-line"></i>
                                    </div>
                                    <div class="pa-upload-title">Chọn ảnh đơn thuốc</div>
                                    <div class="pa-upload-desc">
                                        Hỗ trợ JPG, PNG, WEBP. Dung lượng tối đa 5MB.
                                    </div>
                                </label>

                                <div class="pa-photo-guide">
                                    <span><i class="ri-focus-3-line"></i> Chụp đủ 4 góc đơn thuốc</span>
                                    <span><i class="ri-sun-line"></i> Ảnh đủ sáng, không bị lóa</span>
                                    <span><i class="ri-eye-line"></i> Tên thuốc và liều dùng đọc rõ</span>
                                </div>

                                <div class="pa-preview-wrap" id="paPreviewWrap">
                                    <img src="" alt="Ảnh đơn thuốc" class="pa-preview-image" id="paPreviewImage">

                                    <div class="pa-preview-actions">
                                        <div class="pa-preview-name" id="paPreviewName"></div>
                                        <button type="button" class="pa-remove-preview" id="paRemovePreview">
                                            <i class="ri-delete-bin-line"></i>
                                            Xóa ảnh
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @error('prescription_image') <div class="pa-rx-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="pa-rx-form-group full">
                            <label>
                                <i class="ri-medicine-bottle-line"></i>
                                Nội dung đơn thuốc / thuốc cần mua
                            </label>
                            <textarea
                                name="prescription_content"
                                placeholder="Nhập tên thuốc, số lượng hoặc nội dung trên đơn thuốc nếu bạn muốn bổ sung thêm thông tin..."
                            >{{ old('prescription_content') }}</textarea>
                            @error('prescription_content') <div class="pa-rx-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="pa-rx-form-group full">
                            <label>
                                <i class="ri-sticky-note-line"></i>
                                Ghi chú thêm
                            </label>
                            <textarea
                                name="note"
                                placeholder="Ví dụ: Tôi muốn được tư vấn thuốc tương đương, giao trong hôm nay, gọi lại sau 18h..."
                            >{{ old('note') }}</textarea>
                            @error('note') <div class="pa-rx-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <button type="submit" class="pa-submit-btn">
                        <i class="ri-send-plane-2-line"></i>
                        Gửi yêu cầu cho dược sĩ
                    </button>
                </form>
            </div>

            <aside class="pa-contact-box">
                <div class="pa-guide-card">
                    <img
                        src="{{ asset('phuonganh/img/prescription-guide-v2.png') }}"
                        alt="Hướng dẫn gửi đơn thuốc cho Nhà thuốc Phương Anh"
                        loading="lazy"
                    >

                    <h3>
                        <i class="ri-compass-3-line"></i>
                        Gửi đơn sao cho dược sĩ xử lý nhanh
                    </h3>

                    <ul class="pa-guide-list">
                        <li>
                            <i class="ri-checkbox-circle-line"></i>
                            <span>Điền đúng số điện thoại để dược sĩ gọi xác nhận khi đơn cần tư vấn thêm.</span>
                        </li>
                        <li>
                            <i class="ri-checkbox-circle-line"></i>
                            <span>Ghi rõ nhu cầu: mua đúng đơn, cần thuốc tương đương, hoặc muốn giao trong ngày.</span>
                        </li>
                        <li>
                            <i class="ri-checkbox-circle-line"></i>
                            <span>Với thuốc kê đơn, chuẩn bị ảnh đơn còn rõ ngày kê và thông tin bác sĩ nếu có.</span>
                        </li>
                    </ul>
                </div>

                <div class="pa-contact-item">
                    <div class="pa-contact-icon">
                        <i class="ri-phone-line"></i>
                    </div>
                    <h3>
                        <i class="ri-customer-service-2-line"></i>
                        Cần hỗ trợ gấp?
                    </h3>
                    <p>Gọi trực tiếp cho dược sĩ Nhà thuốc Phương Anh để được tư vấn nhanh hơn.</p>
                    <a href="tel:0858845845" class="pa-contact-btn primary">
                        <i class="ri-phone-fill"></i>
                        Gọi điện ngay: 085 884 5845
                    </a>
                </div>

                <div class="pa-contact-item">
                    <div class="pa-contact-icon">
                        <i class="ri-chat-3-line"></i>
                    </div>
                    <h3>
                        <i class="ri-message-3-line"></i>
                        Nhắn tin với dược sĩ
                    </h3>
                    <p>Bạn có thể gửi ảnh đơn thuốc qua Zalo OA để dược sĩ hỗ trợ nhanh chóng.</p>
                    <a href="https://zalo.me/4374437222076872555" target="_blank" class="pa-contact-btn zalo">
                        <i class="ri-chat-smile-2-fill"></i>
                        Nhắn tin Zalo OA
                    </a>
                </div>
            </aside>
        </div>

        <div class="pa-list-section">
            <div class="pa-list-head">
                <div>
                    <h2>
                        <i class="ri-clipboard-line"></i>
                        Yêu cầu tư vấn của bạn
                    </h2>
                    <p>Danh sách các yêu cầu mua thuốc đã gửi theo số điện thoại đã lưu trên hệ thống.</p>
                </div>

                @if(!empty($customerPhone))
                    <div class="pa-request-stats">
                        <div class="pa-request-stat">
                            <i class="ri-list-check-3"></i>
                            Tổng: {{ $summary['total'] }}
                        </div>
                        <div class="pa-request-stat">
                            <i class="ri-time-line"></i>
                            Chưa xác nhận: {{ $summary['pending'] }}
                        </div>
                        <div class="pa-request-stat">
                            <i class="ri-check-double-line"></i>
                            Đã xác nhận: {{ $summary['confirmed'] }}
                        </div>
                        <div class="pa-request-stat">
                            <i class="ri-checkbox-circle-line"></i>
                            Đã xử lý: {{ $summary['processed'] }}
                        </div>
                    </div>
                @endif
            </div>

            @if(empty($customerPhone))
                <div class="pa-empty-box">
                    <i class="ri-user-search-line"></i>
                    Vui lòng cập nhật thông tin khách hàng bằng nút <strong>Đăng nhập</strong> ở header
                    hoặc nhập số điện thoại trong form để hệ thống hiển thị lại các yêu cầu đã gửi.
                </div>
            @elseif($requests->count() > 0)
                <div class="pa-request-list">
                    @foreach($requests as $item)
                        <article class="pa-request-card">
                            <div class="pa-request-card-head">
                                <div>
                                    <h3 class="pa-request-code">
                                        <i class="ri-file-text-line"></i>
                                        Yêu cầu #{{ $item->request_code }}
                                    </h3>
                                    <div class="pa-request-date">
                                        <i class="ri-calendar-event-line"></i>
                                        Gửi lúc: {{ $item->created_at_format }}
                                    </div>
                                </div>

                                <span class="pa-badge {{ $item->status_class }}">
                                    @if((int)$item->status === 0)
                                        <i class="ri-time-line"></i>
                                    @elseif((int)$item->status === 1)
                                        <i class="ri-check-double-line"></i>
                                    @elseif((int)$item->status === 2)
                                        <i class="ri-checkbox-circle-line"></i>
                                    @else
                                        <i class="ri-information-line"></i>
                                    @endif
                                    {{ $item->status_label }}
                                </span>
                            </div>

                            <div class="pa-request-main">
                                @if(!empty($item->prescription_image))
                                    <a href="{{ $item->image_url }}" target="_blank" class="pa-request-thumb">
                                        <img src="{{ $item->image_url }}" alt="{{ $item->request_code }}">
                                    </a>
                                @else
                                    <div class="pa-request-noimg">
                                        <i class="ri-image-line"></i>
                                        Không có ảnh đơn thuốc
                                    </div>
                                @endif

                                <div class="pa-request-text">
                                    <div>
                                        <strong>
                                            <i class="ri-medicine-bottle-line"></i>
                                            Nội dung:
                                        </strong>
                                        {{ \Illuminate\Support\Str::limit($item->prescription_content ?: 'Khách chưa nhập nội dung, vui lòng xem ảnh đơn thuốc.', 220) }}
                                    </div>

                                    @if(!empty($item->note))
                                        <div style="margin-top:8px;">
                                            <strong>
                                                <i class="ri-sticky-note-line"></i>
                                                Ghi chú:
                                            </strong>
                                            {{ \Illuminate\Support\Str::limit($item->note, 180) }}
                                        </div>
                                    @endif

                                    @if(!empty($item->pharmacist_response))
                                        <div style="margin-top:8px;">
                                            <strong>
                                                <i class="ri-nurse-line"></i>
                                                Phản hồi:
                                            </strong>
                                            {{ \Illuminate\Support\Str::limit($item->pharmacist_response, 160) }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="pa-request-extra" id="paRequestExtra{{ $item->id }}">
                                <div class="pa-request-response">
                                    <strong>Thông tin chi tiết</strong><br>
                                    <strong>Họ tên:</strong> {{ $item->customer_name }}<br>
                                    <strong>Số điện thoại:</strong> {{ $item->customer_phone }}<br>
                                    <strong>Địa chỉ:</strong> {{ $item->customer_address ?: 'Chưa cập nhật' }}<br>
                                    <strong>Nội dung đơn thuốc:</strong><br>
                                    {!! nl2br(e($item->prescription_content ?: 'Khách chưa nhập nội dung.')) !!}

                                    @if(!empty($item->note))
                                        <br><strong>Ghi chú:</strong><br>
                                        {!! nl2br(e($item->note)) !!}
                                    @endif

                                    @if(!empty($item->pharmacist_response))
                                        <br><strong>Phản hồi từ dược sĩ:</strong><br>
                                        {!! nl2br(e($item->pharmacist_response)) !!}
                                    @else
                                        <br><strong>Phản hồi từ dược sĩ:</strong><br>
                                        Đang chờ dược sĩ tiếp nhận và phản hồi.
                                    @endif
                                </div>
                            </div>

                            <div class="pa-request-actions">
                                <button
                                    type="button"
                                    class="pa-toggle-btn"
                                    data-target="paRequestExtra{{ $item->id }}"
                                >
                                    <i class="ri-arrow-down-s-line"></i>
                                    <span>Xem chi tiết</span>
                                </button>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="pa-empty-box">
                    <i class="ri-inbox-line"></i>
                    Chưa có yêu cầu mua thuốc nào theo số điện thoại <strong>{{ $customerPhone }}</strong>.
                    Bạn có thể gửi yêu cầu mới bằng form phía trên.
                </div>
            @endif
        </div>

        <div class="pa-brand-box">
            <div class="pa-brand-icon">
                <i class="ri-heart-pulse-line"></i>
            </div>
            <div>
                <h2>Nhà thuốc Phương Anh luôn sát cánh cùng sức khỏe cộng đồng</h2>
                <p>
                    Nhà thuốc Phương Anh không chỉ cung cấp thuốc và vật tư y tế, chúng tôi còn gửi gắm trong từng dịch vụ
                    sự tận tâm, niềm tin và sự ân cần dành cho khách hàng. Luôn sát cánh cùng sức khỏe cộng đồng,
                    đội ngũ dược sĩ 24/7 của Nhà thuốc Phương Anh hân hạnh được phục vụ Quý khách.
                </p>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        const fileInput = document.getElementById('paPrescriptionImage');
        const previewWrap = document.getElementById('paPreviewWrap');
        const previewImage = document.getElementById('paPreviewImage');
        const previewName = document.getElementById('paPreviewName');
        const removePreview = document.getElementById('paRemovePreview');

        if (fileInput) {
            fileInput.addEventListener('change', function () {
                const file = this.files && this.files[0] ? this.files[0] : null;

                if (!file) {
                    resetPreview();
                    return;
                }

                if (!file.type.startsWith('image/')) {
                    alert('Vui lòng chọn file hình ảnh.');
                    this.value = '';
                    resetPreview();
                    return;
                }

                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('Ảnh đơn thuốc tối đa 5MB.');
                    this.value = '';
                    resetPreview();
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewName.textContent = file.name;
                    previewWrap.classList.add('show');
                };

                reader.readAsDataURL(file);
            });
        }

        function resetPreview() {
            if (previewImage) previewImage.src = '';
            if (previewName) previewName.textContent = '';
            if (previewWrap) previewWrap.classList.remove('show');
        }

        removePreview?.addEventListener('click', function () {
            if (fileInput) fileInput.value = '';
            resetPreview();
        });

        const toggleButtons = document.querySelectorAll('.pa-toggle-btn');

        toggleButtons.forEach((button) => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const target = document.getElementById(targetId);
                const text = this.querySelector('span');
                const icon = this.querySelector('i');

                if (!target) return;

                const isShow = target.classList.contains('show');

                if (isShow) {
                    target.classList.remove('show');
                    if (text) text.textContent = 'Xem chi tiết';
                    if (icon) icon.className = 'ri-arrow-down-s-line';
                } else {
                    target.classList.add('show');
                    if (text) text.textContent = 'Thu gọn';
                    if (icon) icon.className = 'ri-arrow-up-s-line';
                }
            });
        });
    })();
</script>
@endsection
