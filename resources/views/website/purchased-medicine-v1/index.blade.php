@extends('website.layout.index')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">

<style>
    .pa-bought-page{
        background:#f5f7fb;
        padding:28px 0 44px;
        font-family: ui-sans-serif, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
    }

    .pa-bought-container{
        width:min(1320px, calc(100% - 32px));
        margin:0 auto;
    }

    .pa-bought-hero{
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

    .pa-bought-hero-inner{
        position:relative;
        z-index:2;
        max-width:900px;
    }

    .pa-bought-badge{
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

    .pa-bought-badge i{
        font-size:18px;
    }

    .pa-bought-hero h1{
        margin:0 0 12px;
        font-size:42px;
        line-height:1.16;
        font-weight:950;
        letter-spacing:-.025em;
    }

    .pa-bought-hero p{
        margin:0;
        max-width:820px;
        font-size:16px;
        line-height:1.85;
        color:rgba(255,255,255,.93);
    }

    .pa-bought-tags{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
        margin-top:20px;
    }

    .pa-bought-tags span{
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

    .pa-bought-layout{
        display:grid;
        grid-template-columns:360px minmax(0,1fr);
        gap:22px;
        align-items:start;
    }

    .pa-bought-side-card,
    .pa-bought-main-card{
        background:#fff;
        border:1px solid #edf2f7;
        border-radius:26px;
        padding:22px;
        box-shadow:0 14px 35px rgba(15,23,42,.06);
    }

    .pa-bought-side-card{
        position:sticky;
        top:18px;
        overflow:hidden;
    }

    .pa-bought-side-card::before{
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

    .pa-action-btn.danger{
        background:#fef2f2;
        color:#dc2626;
    }

    .pa-main-head{
        display:flex;
        justify-content:space-between;
        align-items:flex-end;
        gap:16px;
        flex-wrap:wrap;
        margin-bottom:16px;
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

    .pa-history-summary{
        display:flex;
        gap:10px;
        flex-wrap:wrap;
    }

    .pa-summary-pill{
        min-height:38px;
        padding:0 13px;
        border-radius:999px;
        background:#f8fafc;
        border:1px solid #e2e8f0;
        color:#334155;
        display:inline-flex;
        align-items:center;
        gap:7px;
        font-size:13px;
        font-weight:900;
    }

    .pa-summary-pill i{
        color:#2563eb;
        font-size:17px;
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
        box-shadow:0 12px 28px rgba(15,23,42,.05);
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
        max-height:170px;
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
        .pa-bought-layout{
            grid-template-columns:1fr;
        }

        .pa-bought-side-card{
            position:static;
        }
    }

    @media(max-width:768px){
        .pa-bought-page{
            padding:18px 0 30px;
        }

        .pa-bought-container{
            width:min(100%, calc(100% - 20px));
        }

        .pa-bought-hero{
            border-radius:22px;
            padding:22px;
        }

        .pa-bought-hero h1{
            font-size:30px;
        }

        .pa-bought-side-card,
        .pa-bought-main-card{
            border-radius:22px;
            padding:18px;
        }

        .pa-history-total{
            text-align:left;
            width:100%;
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
<section class="pa-bought-page">
    <div class="pa-bought-container">
        <div class="pa-bought-hero">
            <div class="pa-bought-hero-inner">
                <div class="pa-bought-badge">
                    <i class="ri-receipt-line"></i>
                    <span>Đơn thuốc đã mua</span>
                </div>

                <h1>Theo dõi đơn thuốc và lịch sử mua hàng</h1>

                <p>
                    Tra cứu nhanh các đơn thuốc, sản phẩm y tế và lịch sử mua hàng tại Nhà thuốc Phương Anh
                    theo số điện thoại của bạn.
                </p>

                <div class="pa-bought-tags">
                    <span><i class="ri-shield-check-line"></i> Bảo mật thông tin khách hàng</span>
                    <span><i class="ri-history-line"></i> Theo dõi lịch sử mua hàng</span>
                    <span><i class="ri-store-2-line"></i> Hiển thị chi nhánh đã mua</span>
                </div>
            </div>
        </div>

        <div class="pa-bought-layout">
            <aside class="pa-bought-side-card">
                <h2 class="pa-side-title">
                    <i class="ri-smartphone-line"></i>
                    Số điện thoại tra cứu
                </h2>

                <p class="pa-side-desc">
                    Hệ thống sử dụng số điện thoại để tìm lại các đơn hàng, đơn thuốc và sản phẩm bạn đã mua tại Nhà thuốc Phương Anh.
                </p>

                <button id="paHeaderStatus" type="button" class="pa-phone-status" title="Bấm để đổi số điện thoại">
                    <span class="dot"></span>
                    <span id="paStatusText">Chưa nhập SĐT</span>
                </button>

                <div class="pa-side-actions">
                    <button type="button" class="pa-action-btn primary" id="paChangePhoneBtn">
                        <i class="ri-phone-line"></i>
                        Nhập / đổi số điện thoại
                    </button>

                    <a href="https://zalo.me/4374437222076872555" target="_blank" class="pa-action-btn light">
                        <i class="ri-chat-smile-2-line"></i>
                        Cần hỗ trợ tra cứu?
                    </a>
                </div>
            </aside>

            <main class="pa-bought-main-card">
                <div class="pa-main-head">
                    <div>
                        <h2 class="pa-main-title">
                            <i class="ri-file-list-3-line"></i>
                            Lịch sử đơn hàng
                        </h2>
                        <p class="pa-main-sub">
                            Danh sách đơn thuốc và sản phẩm đã mua được tra cứu từ hệ thống theo số điện thoại.
                        </p>
                    </div>

                    <div class="pa-history-summary" id="paHistorySummary" style="display:none;">
                        <div class="pa-summary-pill">
                            <i class="ri-shopping-bag-3-line"></i>
                            <span id="paTotalOrders">0 đơn</span>
                        </div>

                        <div class="pa-summary-pill">
                            <i class="ri-money-dollar-circle-line"></i>
                            <span id="paTotalAmount">0đ</span>
                        </div>
                    </div>
                </div>

                <div id="paHistoryList" class="pa-history-list"></div>
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
                Hệ thống sẽ dùng số điện thoại để tra cứu đơn thuốc đã mua và lịch sử đơn hàng của bạn.
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
                    Xem đơn đã mua
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
        const summary = document.getElementById('paHistorySummary');
        const totalOrders = document.getElementById('paTotalOrders');
        const totalAmount = document.getElementById('paTotalAmount');

        if(summary) summary.style.display = 'none';
        if(totalOrders) totalOrders.textContent = '0 đơn';
        if(totalAmount) totalAmount.textContent = '0đ';

        paRenderEmptyHistory('Nhập số điện thoại để xem đơn thuốc đã mua.');
    }

    function paRenderSummary(list){
        const summary = document.getElementById('paHistorySummary');
        const totalOrders = document.getElementById('paTotalOrders');
        const totalAmount = document.getElementById('paTotalAmount');

        const total = (list || []).reduce((sum, item) => {
            return sum + (Number(item.total) || 0);
        }, 0);

        if(summary) summary.style.display = list && list.length ? 'flex' : 'none';
        if(totalOrders) totalOrders.textContent = `${(list || []).length} đơn`;
        if(totalAmount) totalAmount.textContent = paFormatMoney(total);
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
        paRenderSummary(list || []);

        if(!list || !list.length){
            paRenderEmptyHistory('Chưa có đơn thuốc hoặc đơn hàng phù hợp với số điện thoại này.');
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

    async function paLoadOrderHistory(phone){
        const submitBtn = document.getElementById('paBtnSubmitPhone');

        try{
            if(submitBtn){
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="ri-loader-4-line"></i> Đang tải...';
            }

            paUpdateHeaderStatus(phone);

            const orderResponse = await paCallApi('https://outtech.io.vn/api/zalo/orders', {
                phone: phone,
                zid: null,
                limit: 30
            });

            if(orderResponse.ok){
                paRenderHistory(orderResponse.history || []);
            }else{
                paRenderSummary([]);
                paRenderEmptyHistory(orderResponse.msg || 'Không lấy được lịch sử đơn hàng.');
                paShowToast(orderResponse.msg || 'Không lấy được lịch sử đơn.', 'err');
            }
        }catch(e){
            paRenderSummary([]);
            paRenderEmptyHistory('Không thể tải dữ liệu. Vui lòng kiểm tra kết nối mạng.');
            paShowToast('Không thể tải dữ liệu. Vui lòng kiểm tra mạng.', 'err');
        }finally{
            if(submitBtn){
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="ri-search-line"></i> Xem đơn đã mua';
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

        await paLoadOrderHistory(phone);
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

        paResetScreen();

        const phoneFromUrl = paGetQueryParam('phone');

        if(phoneFromUrl){
            const phone = paNormalizePhone(phoneFromUrl);

            if(paIsValidPhone(phone)){
                paSavePhone(phone);
                paUpdateHeaderStatus(phone);
                paLoadOrderHistory(phone);
                paClearPhoneParam();
                return;
            }
        }

        const phoneFromSession = paNormalizePhone(PA_INITIAL_PHONE);

        if(phoneFromSession && paIsValidPhone(phoneFromSession)){
            paSavePhone(phoneFromSession);
            paUpdateHeaderStatus(phoneFromSession);
            paLoadOrderHistory(phoneFromSession);
            return;
        }

        const cachedPhone = paGetSavedPhone();

        if(cachedPhone && paIsValidPhone(cachedPhone)){
            paUpdateHeaderStatus(cachedPhone);
            paLoadOrderHistory(cachedPhone);
            return;
        }

        paUpdateHeaderStatus(null);
        paOpenPhoneModal();
    });
</script>
@endsection