@extends('website.layout.index')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">

<style>
    .pa-loyalty-page{
        background:#f5f7fb;
        padding:28px 0 44px;
        font-family: ui-sans-serif, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
    }

    .pa-loyalty-container{
        width:min(1320px, calc(100% - 32px));
        margin:0 auto;
    }

    .pa-loyalty-hero{
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

    .pa-loyalty-hero-inner{
        position:relative;
        z-index:2;
        max-width:900px;
    }

    .pa-loyalty-badge{
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

    .pa-loyalty-badge i{
        font-size:18px;
    }

    .pa-loyalty-hero h1{
        margin:0 0 12px;
        font-size:42px;
        line-height:1.16;
        font-weight:950;
        letter-spacing:-.025em;
    }

    .pa-loyalty-hero p{
        margin:0;
        max-width:780px;
        font-size:16px;
        line-height:1.85;
        color:rgba(255,255,255,.93);
    }

    .pa-loyalty-tags{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
        margin-top:20px;
    }

    .pa-loyalty-tags span{
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

    .pa-loyalty-main-grid{
        display:grid;
        grid-template-columns:390px minmax(0,1fr);
        gap:22px;
        align-items:start;
    }

    .pa-loyalty-card{
        background:#fff;
        border:1px solid #edf2f7;
        border-radius:26px;
        padding:22px;
        box-shadow:0 14px 35px rgba(15,23,42,.06);
    }

    .pa-points-card{
        position:sticky;
        top:18px;
        overflow:hidden;
    }

    .pa-points-card::before{
        content:"";
        position:absolute;
        left:0;
        top:0;
        width:100%;
        height:5px;
        background:linear-gradient(90deg,#0f8f65,#2563eb);
    }

    .pa-points-head{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        margin-bottom:14px;
    }

    .pa-points-title{
        margin:0;
        font-size:21px;
        font-weight:950;
        color:#0f172a;
        display:flex;
        align-items:center;
        gap:9px;
    }

    .pa-points-title i{
        width:38px;
        height:38px;
        border-radius:14px;
        background:#eff6ff;
        color:#2563eb;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        font-size:21px;
    }

    .pa-login-status{
        border:0;
        background:#f8fafc;
        border:1px solid #e2e8f0;
        color:#334155;
        min-height:36px;
        padding:0 12px;
        border-radius:999px;
        display:inline-flex;
        align-items:center;
        gap:7px;
        font-size:12px;
        font-weight:900;
        cursor:pointer;
        white-space:nowrap;
    }

    .pa-login-status .dot{
        width:8px;
        height:8px;
        border-radius:50%;
        background:#ef4444;
    }

    .pa-login-status.logged-in{
        background:#ecfdf5;
        color:#15803d;
        border-color:#bbf7d0;
    }

    .pa-login-status.logged-in .dot{
        background:#22c55e;
    }

    .pa-points-value{
        margin:10px 0 8px;
        font-size:64px;
        line-height:1;
        font-weight:950;
        color:#0f8f65;
        letter-spacing:-.04em;
    }

    .pa-points-label{
        color:#64748b;
        font-size:14px;
        line-height:1.7;
        margin-bottom:16px;
    }

    .pa-progress-wrap{
        width:100%;
        height:9px;
        border-radius:999px;
        background:#eef2f7;
        overflow:hidden;
        margin:12px 0 10px;
    }

    .pa-progress-bar{
        height:100%;
        width:0%;
        border-radius:999px;
        background:linear-gradient(90deg,#0f8f65,#2563eb);
        transition:width .45s ease;
    }

    .pa-points-subtext{
        color:#64748b;
        font-size:13px;
        line-height:1.7;
    }

    .pa-quick-actions{
        display:grid;
        grid-template-columns:1fr;
        gap:10px;
        margin-top:18px;
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

    .pa-action-btn.danger{
        background:#fef2f2;
        color:#dc2626;
    }

    .pa-section-head{
        display:flex;
        justify-content:space-between;
        align-items:flex-end;
        gap:16px;
        flex-wrap:wrap;
        margin-bottom:16px;
    }

    .pa-section-title{
        margin:0 0 6px;
        font-size:28px;
        font-weight:950;
        color:#0f172a;
        display:flex;
        align-items:center;
        gap:10px;
    }

    .pa-section-title i{
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

    .pa-section-sub{
        margin:0;
        font-size:14px;
        color:#64748b;
        line-height:1.7;
    }

    .pa-history-list{
        display:grid;
        gap:14px;
    }

    .pa-history-item{
        background:#fff;
        border:1px solid #edf2f7;
        border-radius:24px;
        padding:18px;
        box-shadow:0 14px 35px rgba(15,23,42,.06);
        transition:transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .pa-history-item:hover{
        transform:translateY(-2px);
        border-color:#cfe0ff;
        box-shadow:0 18px 40px rgba(37,99,235,.10);
    }

    .pa-history-top{
        display:flex;
        justify-content:space-between;
        gap:14px;
        flex-wrap:wrap;
        padding-bottom:12px;
        margin-bottom:12px;
        border-bottom:1px dashed #e2e8f0;
    }

    .pa-history-bill{
        margin:0 0 6px;
        font-size:19px;
        font-weight:950;
        color:#0f172a;
        display:flex;
        align-items:center;
        gap:8px;
    }

    .pa-history-bill i{
        color:#2563eb;
    }

    .pa-history-date{
        color:#64748b;
        font-size:13px;
        font-weight:750;
        display:flex;
        align-items:center;
        gap:6px;
    }

    .pa-history-total{
        text-align:right;
    }

    .pa-history-total-label{
        font-size:12px;
        color:#64748b;
        font-weight:800;
        margin-bottom:5px;
    }

    .pa-history-total-value{
        font-size:22px;
        font-weight:950;
        color:#2563eb;
    }

    .pa-history-branch{
        display:grid;
        grid-template-columns:22px minmax(0,1fr);
        gap:8px;
        color:#334155;
        font-size:14px;
        line-height:1.65;
        margin-bottom:12px;
    }

    .pa-history-branch i{
        color:#0f8f65;
        font-size:18px;
        margin-top:2px;
    }

    .pa-products-list{
        display:grid;
        gap:8px;
        max-height:160px;
        overflow:auto;
        padding-right:5px;
    }

    .pa-products-list::-webkit-scrollbar{
        width:4px;
    }

    .pa-products-list::-webkit-scrollbar-track{
        background:#f1f5f9;
        border-radius:999px;
    }

    .pa-products-list::-webkit-scrollbar-thumb{
        background:#93c5fd;
        border-radius:999px;
    }

    .pa-product-row{
        display:grid;
        grid-template-columns:minmax(0,1fr) auto;
        gap:12px;
        padding:9px 10px;
        border-radius:14px;
        background:#f8fafc;
        color:#334155;
        font-size:13px;
    }

    .pa-product-name{
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }

    .pa-product-amount{
        font-weight:950;
        color:#0f172a;
        white-space:nowrap;
    }

    .pa-empty-state{
        background:#fff;
        border:1px dashed #dbe4f0;
        border-radius:24px;
        padding:34px 22px;
        text-align:center;
        color:#64748b;
        line-height:1.8;
        box-shadow:0 14px 35px rgba(15,23,42,.04);
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

    .pa-empty-state strong{
        display:block;
        color:#0f172a;
        font-size:17px;
        margin-bottom:5px;
    }

    .pa-loyalty-tabs{
        margin-top:22px;
        display:grid;
        grid-template-columns:repeat(3,minmax(0,1fr));
        gap:14px;
    }

    .pa-tab-card{
        background:#fff;
        border:1px solid #edf2f7;
        border-radius:22px;
        padding:16px;
        box-shadow:0 14px 35px rgba(15,23,42,.06);
        display:flex;
        align-items:center;
        gap:12px;
        cursor:pointer;
        text-align:left;
        transition:transform .2s ease, border-color .2s ease;
    }

    .pa-tab-card:hover{
        transform:translateY(-2px);
        border-color:#cfe0ff;
    }

    .pa-tab-card.active{
        background:linear-gradient(135deg,#ecfdf5 0%,#eff6ff 100%);
        border-color:#bfdbfe;
    }

    .pa-tab-icon{
        width:48px;
        height:48px;
        border-radius:17px;
        background:#eff6ff;
        color:#2563eb;
        display:flex;
        align-items:center;
        justify-content:center;
        flex:0 0 48px;
    }

    .pa-tab-icon i{
        font-size:25px;
    }

    .pa-tab-title{
        color:#0f172a;
        font-weight:950;
        font-size:15px;
        margin-bottom:3px;
    }

    .pa-tab-desc{
        color:#64748b;
        font-size:12px;
        line-height:1.5;
    }

    .pa-phone-modal-backdrop{
        position:fixed;
        inset:0;
        background:rgba(15,23,42,.48);
        display:none;
        align-items:center;
        justify-content:center;
        z-index:9999;
        padding:16px;
        box-sizing:border-box;
        backdrop-filter:blur(3px);
    }

    .pa-phone-modal{
        width:min(92vw,460px);
        background:#fff;
        border-radius:26px;
        padding:24px;
        box-shadow:0 24px 70px rgba(15,23,42,.28);
        text-align:center;
        position:relative;
        overflow:hidden;
    }

    .pa-phone-modal::before{
        content:"";
        position:absolute;
        top:0;
        left:0;
        right:0;
        height:5px;
        background:linear-gradient(90deg,#0f8f65,#2563eb);
    }

    .pa-phone-icon{
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

    .pa-phone-icon i{
        font-size:33px;
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

    .pa-input-wrap{
        text-align:left;
        margin-top:12px;
    }

    .pa-input-label{
        display:flex;
        align-items:center;
        gap:7px;
        font-size:14px;
        font-weight:900;
        color:#0f172a;
        margin-bottom:8px;
    }

    .pa-input-label i{
        color:#2563eb;
        font-size:18px;
    }

    .pa-input{
        width:100%;
        box-sizing:border-box;
        padding:0 14px;
        min-height:52px;
        border:1px solid #dbe4f0;
        border-radius:16px;
        font-size:16px;
        outline:none;
        background:#fff;
        color:#0f172a;
        font-family: ui-sans-serif, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial;
    }

    .pa-input::placeholder{
        color:#94a3b8;
    }

    .pa-input:focus{
        border-color:#2563eb;
        box-shadow:0 0 0 3px rgba(37,99,235,.08);
    }

    .pa-input-note{
        font-size:12px;
        color:#64748b;
        margin-top:7px;
        line-height:1.5;
    }

    .pa-btn-row{
        display:flex;
        gap:10px;
        justify-content:center;
        margin-top:16px;
        flex-wrap:wrap;
    }

    .pa-modal-btn{
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

    .pa-modal-btn.primary{
        background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);
        color:#fff;
    }

    .pa-modal-btn.ghost{
        background:#f8fafc;
        color:#334155;
        border:1px solid #dbe4f0;
    }

    .pa-modal-btn.danger{
        background:#fef2f2;
        color:#dc2626;
        border:1px solid #fecaca;
    }

    .pa-modal-btn:disabled{
        opacity:.65;
        cursor:not-allowed;
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

    @media(max-width:1100px){
        .pa-loyalty-main-grid{
            grid-template-columns:1fr;
        }

        .pa-points-card{
            position:static;
        }

        .pa-loyalty-tabs{
            grid-template-columns:1fr;
        }
    }

    @media(max-width:768px){
        .pa-loyalty-page{
            padding:18px 0 30px;
        }

        .pa-loyalty-container{
            width:min(100%, calc(100% - 20px));
        }

        .pa-loyalty-hero{
            border-radius:22px;
            padding:22px;
        }

        .pa-loyalty-hero h1{
            font-size:30px;
        }

        .pa-loyalty-main-grid{
            gap:16px;
        }

        .pa-loyalty-card{
            border-radius:22px;
            padding:18px;
        }

        .pa-points-head{
            align-items:flex-start;
            flex-direction:column;
        }

        .pa-points-value{
            font-size:52px;
        }

        .pa-history-total{
            text-align:left;
            width:100%;
        }

        .pa-phone-modal{
            padding:22px 18px;
            border-radius:22px;
        }

        .pa-btn-row{
            flex-direction:column;
        }

        .pa-modal-btn{
            width:100%;
        }
    }
</style>
@endsection

@section('content')
<section class="pa-loyalty-page">
    <div class="pa-loyalty-container">
        <div class="pa-loyalty-hero">
            <div class="pa-loyalty-hero-inner">
                <div class="pa-loyalty-badge">
                    <i class="ri-gift-line"></i>
                    <span>Tích điểm - Đổi quà</span>
                </div>

                <h1>Theo dõi điểm tích lũy của bạn</h1>

                <p>
                    Kiểm tra điểm hiện tại, lịch sử mua hàng và hành trình tích điểm tại Nhà thuốc Phương Anh.
                    Hệ thống sử dụng số điện thoại để tra cứu dữ liệu nhanh chóng và thuận tiện.
                </p>

                <div class="pa-loyalty-tags">
                    <span><i class="ri-shield-check-line"></i> Bảo mật thông tin khách hàng</span>
                    <span><i class="ri-history-line"></i> Theo dõi lịch sử đơn hàng</span>
                    <span><i class="ri-vip-crown-line"></i> Tích điểm nhận quà VIP</span>
                </div>
            </div>
        </div>

        <div class="pa-loyalty-main-grid">
            <aside class="pa-loyalty-card pa-points-card">
                <div class="pa-points-head">
                    <h2 class="pa-points-title">
                        <i class="ri-coins-line"></i>
                        Điểm hiện tại
                    </h2>

                    <button id="paHeaderStatus" type="button" class="pa-login-status" title="Bấm để đổi số điện thoại">
                        <span class="dot"></span>
                        <span id="paStatusText">Chưa nhập SĐT</span>
                    </button>
                </div>

                <div id="paPointsValue" class="pa-points-value">—</div>

                <div class="pa-points-label">
                    Điểm tích lũy được ghi nhận theo số điện thoại khách hàng.
                </div>

                <div class="pa-progress-wrap">
                    <div id="paProgressBar" class="pa-progress-bar"></div>
                </div>

                <div id="paPointsSubtext" class="pa-points-subtext">
                    Nhập số điện thoại để theo dõi điểm.
                </div>

                <div class="pa-quick-actions">
                    <button type="button" class="pa-action-btn primary" id="paChangePhoneBtn">
                        <i class="ri-phone-line"></i>
                        Nhập / đổi số điện thoại
                    </button>

                    <a href="https://zalo.me/4374437222076872555" target="_blank" class="pa-action-btn light">
                        <i class="ri-chat-smile-2-line"></i>
                        Cần hỗ trợ điểm?
                    </a>
                </div>
            </aside>

            <main>
                <div class="pa-section-head">
                    <div>
                        <h2 class="pa-section-title">
                            <i class="ri-file-list-3-line"></i>
                            Lịch sử đơn hàng
                        </h2>
                        <p class="pa-section-sub">
                            Danh sách đơn hàng được tra cứu từ hệ thống theo số điện thoại bạn đã nhập.
                        </p>
                    </div>
                </div>

                <div id="paHistoryList" class="pa-history-list"></div>

                <div class="pa-loyalty-tabs">
                    <button type="button" class="pa-tab-card active">
                        <div class="pa-tab-icon">
                            <i class="ri-coins-line"></i>
                        </div>
                        <div>
                            <div class="pa-tab-title">Điểm tích lũy</div>
                            <div class="pa-tab-desc">Theo dõi điểm và lịch sử mua hàng.</div>
                        </div>
                    </button>

                    <button type="button" class="pa-tab-card js-dev-feature">
                        <div class="pa-tab-icon">
                            <i class="ri-star-smile-line"></i>
                        </div>
                        <div>
                            <div class="pa-tab-title">Đánh giá</div>
                            <div class="pa-tab-desc">Tính năng đang được phát triển.</div>
                        </div>
                    </button>

                    <button type="button" class="pa-tab-card js-dev-feature">
                        <div class="pa-tab-icon">
                            <i class="ri-gift-2-line"></i>
                        </div>
                        <div>
                            <div class="pa-tab-title">Đổi quà</div>
                            <div class="pa-tab-desc">Tính năng đang được phát triển.</div>
                        </div>
                    </button>
                </div>
            </main>
        </div>
    </div>

    <div id="paPhoneLoginModal" class="pa-phone-modal-backdrop" role="dialog" aria-modal="true">
        <div class="pa-phone-modal">
            <div class="pa-phone-icon">
                <i class="ri-phone-line"></i>
            </div>

            <h3>Nhập số điện thoại</h3>

            <p>
                Hệ thống sẽ dùng số điện thoại để tra cứu điểm tích lũy và lịch sử đơn hàng của bạn.
            </p>

            <div class="pa-input-wrap">
                <label class="pa-input-label" for="paInpPhone">
                    <i class="ri-smartphone-line"></i>
                    Số điện thoại
                </label>

                <input
                    id="paInpPhone"
                    class="pa-input"
                    type="tel"
                    placeholder="VD: 0912345678"
                    inputmode="numeric"
                    autocomplete="tel"
                >

                <div class="pa-input-note">
                    Có thể nhập dạng 0912345678 hoặc 84912345678.
                </div>
            </div>

            <div class="pa-btn-row">
                <button id="paBtnSubmitPhone" class="pa-modal-btn primary" type="button">
                    <i class="ri-search-line"></i>
                    Xem điểm ngay
                </button>

                <button id="paBtnClosePhone" class="pa-modal-btn ghost" type="button">
                    Để sau
                </button>
            </div>

            <div class="pa-btn-row" id="paLogoutRow" style="display:none;margin-top:8px">
                <button id="paBtnClearPhone" class="pa-modal-btn danger" type="button">
                    <i class="ri-delete-bin-line"></i>
                    Xóa số đã lưu
                </button>
            </div>
        </div>
    </div>

    <div id="paToast" class="pa-toast" role="status" aria-live="polite"></div>
</section>

<script>
    const PA_INITIAL_PHONE = @json($initialPhone ?? '');

    function paEscapeHtml(value){
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
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

    function paShowToast(message, type = 'ok'){
        const toast = document.getElementById('paToast');
        if(!toast) return;

        toast.textContent = message;
        toast.classList.remove('ok','err');
        toast.classList.add(type === 'err' ? 'err' : 'ok');
        toast.classList.add('show');

        clearTimeout(window.__paToastTimer);
        window.__paToastTimer = setTimeout(() => {
            toast.classList.remove('show');
        }, 2500);
    }

    function paOpenPhoneModal(){
        const cachedPhone = paGetSavedPhone();

        const modal = document.getElementById('paPhoneLoginModal');
        const input = document.getElementById('paInpPhone');
        const logoutRow = document.getElementById('paLogoutRow');

        if(modal) modal.style.display = 'flex';
        if(input) input.value = cachedPhone || '';
        if(logoutRow) logoutRow.style.display = cachedPhone ? 'flex' : 'none';

        setTimeout(() => {
            input?.focus();
        }, 80);
    }

    function paClosePhoneModal(){
        const modal = document.getElementById('paPhoneLoginModal');
        if(modal) modal.style.display = 'none';
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

    function paGetQueryParam(name){
        const url = new URL(window.location.href);
        return url.searchParams.get(name);
    }

    function paClearPhoneParam(){
        const url = new URL(window.location.href);
        url.searchParams.delete('phone');
        history.replaceState({}, document.title, url.pathname + url.search + url.hash);
    }

    function paFormatMoney(value){
        return (Number(value) || 0).toLocaleString('vi-VN') + 'đ';
    }

    function paFormatDateTime(value){
        try{
            const d = new Date(value);
            if(isNaN(d.getTime())) return value || '';
            return d.toLocaleString('vi-VN');
        }catch(_){
            return value || '';
        }
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

    function paResetScreen(){
        const pointsValue = document.getElementById('paPointsValue');
        const progressBar = document.getElementById('paProgressBar');
        const subtext = document.getElementById('paPointsSubtext');

        if(pointsValue) pointsValue.textContent = '—';
        if(progressBar) progressBar.style.width = '0%';
        if(subtext) subtext.textContent = 'Nhập số điện thoại để theo dõi điểm.';

        paRenderEmptyHistory('Nhập số điện thoại để xem lịch sử đơn hàng.');
    }

    function paRenderPoints(data){
        const pointsValue = document.getElementById('paPointsValue');
        const subtext = document.getElementById('paPointsSubtext');
        const progressBar = document.getElementById('paProgressBar');

        const points = Number(data.points ?? 0);
        const progress = Number(data.progress ?? 0);
        const remaining = Number(data.remaining ?? 0);
        const vipTarget = Number(data.vipTarget ?? 0);

        if(pointsValue) pointsValue.textContent = points.toLocaleString('vi-VN');
        if(progressBar) progressBar.style.width = Math.max(0, Math.min(100, progress)) + '%';

        if(subtext){
            if(vipTarget > 0){
                subtext.textContent = `Còn ${remaining.toLocaleString('vi-VN')} điểm để đạt quà VIP (${vipTarget.toLocaleString('vi-VN')} điểm).`;
            }else{
                subtext.textContent = 'Điểm tích lũy đã được cập nhật từ hệ thống.';
            }
        }
    }

    function paRenderEmptyHistory(message){
        const wrap = document.getElementById('paHistoryList');
        if(!wrap) return;

        wrap.innerHTML = `
            <div class="pa-empty-state">
                <i class="ri-inbox-line"></i>
                <strong>Chưa có dữ liệu</strong>
                ${paEscapeHtml(message || 'Chưa có đơn hàng.')}
            </div>
        `;
    }

    function paRenderHistory(list){
        const wrap = document.getElementById('paHistoryList');
        if(!wrap) return;

        wrap.innerHTML = '';

        if(!list || !list.length){
            paRenderEmptyHistory('Chưa có đơn hàng phù hợp với số điện thoại này.');
            return;
        }

        list.forEach((historyItem) => {
            const itemsHtml = (historyItem.items || []).map((product) => {
                const qty = Number(product.qty || 0);
                const qtyText = Number.isInteger(qty) ? parseInt(qty) : qty;

                return `
                    <div class="pa-product-row">
                        <div class="pa-product-name">${paEscapeHtml(qtyText)} × ${paEscapeHtml(product.name || '')}</div>
                        <div class="pa-product-amount">${paFormatMoney(product.amount || 0)}</div>
                    </div>
                `;
            }).join('');

            const element = document.createElement('article');
            element.className = 'pa-history-item';

            element.innerHTML = `
                <div class="pa-history-top">
                    <div>
                        <h3 class="pa-history-bill">
                            <i class="ri-receipt-line"></i>
                            ${paEscapeHtml(historyItem.bill || 'Đơn hàng')}
                        </h3>

                        <div class="pa-history-date">
                            <i class="ri-calendar-event-line"></i>
                            ${paEscapeHtml(paFormatDateTime(historyItem.datetime))}
                        </div>
                    </div>

                    <div class="pa-history-total">
                        <div class="pa-history-total-label">Tổng đơn hàng</div>
                        <div class="pa-history-total-value">${paFormatMoney(historyItem.total || 0)}</div>
                    </div>
                </div>

                <div class="pa-history-branch">
                    <i class="ri-store-2-line"></i>
                    <div>Chi nhánh: ${paEscapeHtml(historyItem.branch || 'Đang cập nhật')}</div>
                </div>

                <div class="pa-products-list">
                    ${itemsHtml || '<div style="font-size:13px;color:#64748b">Không có danh sách sản phẩm.</div>'}
                </div>
            `;

            wrap.appendChild(element);
        });
    }

    async function paCallApi(url, payload){
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || @json(csrf_token());

        const response = await fetch(url, {
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'Accept':'application/json',
                ...(csrf ? {'X-CSRF-TOKEN': csrf} : {})
            },
            body: JSON.stringify(payload || {})
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

    async function paLoadUserData(phone){
        const submitBtn = document.getElementById('paBtnSubmitPhone');
        const subtext = document.getElementById('paPointsSubtext');

        try{
            if(submitBtn){
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="ri-loader-4-line"></i> Đang tải...';
            }

            paUpdateHeaderStatus(phone);

            if(subtext){
                subtext.textContent = 'Đang tải dữ liệu tích điểm...';
            }

            const pointResponse = await paCallApi('https://outtech.io.vn/api/zalo/points', {
                phone: phone,
                zid: null
            });

            if(pointResponse.ok){
                paRenderPoints(pointResponse);
            }else{
                paRenderPoints({
                    points:0,
                    progress:0,
                    remaining:0,
                    vipTarget:0
                });

                paShowToast(pointResponse.msg || 'Không lấy được điểm.', 'err');
            }

            const orderResponse = await paCallApi('https://outtech.io.vn/api/zalo/orders', {
                phone: phone,
                zid: null,
                limit: 20
            });

            if(orderResponse.ok){
                paRenderHistory(orderResponse.history || []);
            }else{
                paRenderEmptyHistory(orderResponse.msg || 'Không lấy được lịch sử đơn hàng.');
                paShowToast(orderResponse.msg || 'Không lấy được lịch sử đơn.', 'err');
            }
        }catch(e){
            paRenderPoints({
                points:0,
                progress:0,
                remaining:0,
                vipTarget:0
            });

            paRenderEmptyHistory('Không thể tải dữ liệu. Vui lòng kiểm tra kết nối mạng.');
            paShowToast('Không thể tải dữ liệu. Vui lòng kiểm tra mạng.', 'err');
        }finally{
            if(submitBtn){
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="ri-search-line"></i> Xem điểm ngay';
            }
        }
    }

    async function paSubmitPhone(){
        const input = document.getElementById('paInpPhone');
        const rawPhone = input ? input.value.trim() : '';
        const phone = paNormalizePhone(rawPhone);

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
        paClosePhoneModal();
        paShowToast('Đã lưu số điện thoại.', 'ok');

        await paLoadUserData(phone);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const headerStatus = document.getElementById('paHeaderStatus');
        const changePhoneBtn = document.getElementById('paChangePhoneBtn');
        const closePhoneBtn = document.getElementById('paBtnClosePhone');
        const submitPhoneBtn = document.getElementById('paBtnSubmitPhone');
        const clearPhoneBtn = document.getElementById('paBtnClearPhone');
        const phoneInput = document.getElementById('paInpPhone');

        headerStatus?.addEventListener('click', paOpenPhoneModal);
        changePhoneBtn?.addEventListener('click', paOpenPhoneModal);
        closePhoneBtn?.addEventListener('click', paClosePhoneModal);
        submitPhoneBtn?.addEventListener('click', paSubmitPhone);

        phoneInput?.addEventListener('keydown', function (event) {
            if(event.key === 'Enter'){
                event.preventDefault();
                paSubmitPhone();
            }
        });

        clearPhoneBtn?.addEventListener('click', function () {
            paClearSavedPhone();
            paClosePhoneModal();
            paUpdateHeaderStatus(null);
            paResetScreen();
            paShowToast('Đã xóa số điện thoại đã lưu.', 'ok');
        });

        document.querySelectorAll('.js-dev-feature').forEach((button) => {
            button.addEventListener('click', function () {
                paShowToast('Tính năng đang được phát triển.', 'ok');
            });
        });

        paResetScreen();

        const phoneFromUrl = paGetQueryParam('phone');

        if(phoneFromUrl){
            const phone = paNormalizePhone(phoneFromUrl);

            if(paIsValidPhone(phone)){
                paSavePhone(phone);
                paUpdateHeaderStatus(phone);
                paLoadUserData(phone);
                paClearPhoneParam();
                return;
            }
        }

        const phoneFromSession = paNormalizePhone(PA_INITIAL_PHONE);

        if(phoneFromSession && paIsValidPhone(phoneFromSession)){
            paSavePhone(phoneFromSession);
            paUpdateHeaderStatus(phoneFromSession);
            paLoadUserData(phoneFromSession);
            return;
        }

        const cachedPhone = paGetSavedPhone();

        if(cachedPhone && paIsValidPhone(cachedPhone)){
            paUpdateHeaderStatus(cachedPhone);
            paLoadUserData(cachedPhone);
            return;
        }

        paUpdateHeaderStatus(null);
        paOpenPhoneModal();
    });
</script>
@endsection