@extends('website.layout.index')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">

<style>
    .pa-pharm-page{
        background:#f5f7fb;
        padding:28px 0 44px;
        font-family: ui-sans-serif, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
    }

    .pa-pharm-container{
        width:min(1320px, calc(100% - 32px));
        margin:0 auto;
    }

    .pa-pharm-hero{
        position:relative;
        overflow:hidden;
        border-radius:30px;
        padding:34px;
        color:#fff;
        background:
            radial-gradient(circle at 92% 12%, rgba(255,255,255,.22), transparent 28%),
            radial-gradient(circle at 12% 92%, rgba(255,255,255,.14), transparent 30%),
            linear-gradient(135deg,#0f8f65 0%,#2563eb 100%);
        box-shadow:0 20px 45px rgba(37,99,235,.18);
        margin-bottom:24px;
    }

    .pa-pharm-hero-inner{
        position:relative;
        z-index:2;
        max-width:900px;
    }

    .pa-pharm-badge{
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

    .pa-pharm-badge i{
        font-size:18px;
    }

    .pa-pharm-hero h1{
        margin:0 0 12px;
        font-size:42px;
        line-height:1.18;
        font-weight:950;
        letter-spacing:-.025em;
    }

    .pa-pharm-hero p{
        margin:0;
        max-width:820px;
        font-size:16px;
        line-height:1.85;
        color:rgba(255,255,255,.93);
    }

    .pa-pharm-tags{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
        margin-top:20px;
    }

    .pa-pharm-tags span{
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

    .pa-pharm-tags i{
        font-size:17px;
    }

    .pa-pharm-toolbar{
        background:#fff;
        border:1px solid #edf2f7;
        border-radius:24px;
        padding:18px;
        box-shadow:0 14px 35px rgba(15,23,42,.06);
        margin-bottom:20px;
        display:grid;
        grid-template-columns:minmax(0,1fr) auto;
        gap:14px;
        align-items:center;
    }

    .pa-pharm-search{
        position:relative;
    }

    .pa-pharm-search i{
        position:absolute;
        left:16px;
        top:50%;
        transform:translateY(-50%);
        color:#64748b;
        font-size:20px;
    }

    .pa-pharm-search input{
        width:100%;
        min-height:52px;
        border:1px solid #dbe4f0;
        border-radius:999px;
        padding:0 18px 0 46px;
        outline:none;
        color:#0f172a;
        font-size:15px;
        font-family: ui-sans-serif, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial;
        letter-spacing:-.01em;
        transition:border-color .2s ease, box-shadow .2s ease;
    }

    .pa-pharm-search input::placeholder{
        color:#94a3b8;
    }

    .pa-pharm-search input:focus{
        border-color:#2563eb;
        box-shadow:0 0 0 3px rgba(37,99,235,.08);
    }

    .pa-pharm-count{
        min-height:42px;
        padding:0 14px;
        border-radius:999px;
        background:#eff6ff;
        color:#1d4ed8;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:7px;
        font-size:14px;
        font-weight:900;
        white-space:nowrap;
    }

    .pa-pharm-section-head{
        display:flex;
        justify-content:space-between;
        align-items:flex-end;
        gap:16px;
        flex-wrap:wrap;
        margin:22px 0 16px;
    }

    .pa-pharm-section-title{
        margin:0 0 6px;
        color:#0f172a;
        font-size:30px;
        font-weight:950;
        letter-spacing:-.02em;
        display:flex;
        align-items:center;
        gap:10px;
    }

    .pa-pharm-section-title i{
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

    .pa-pharm-section-sub{
        margin:0;
        color:#64748b;
        line-height:1.7;
        font-size:14px;
    }

    .pa-branch-grid{
        display:grid;
        grid-template-columns:repeat(3,minmax(0,1fr));
        gap:18px;
    }

    .pa-branch-card{
        background:#fff;
        border:1px solid #edf2f7;
        border-radius:24px;
        padding:18px;
        box-shadow:0 14px 35px rgba(15,23,42,.06);
        display:flex;
        flex-direction:column;
        min-height:100%;
        transition:transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .pa-branch-card:hover{
        transform:translateY(-3px);
        border-color:#cfe0ff;
        box-shadow:0 18px 40px rgba(37,99,235,.12);
    }

    .pa-branch-top{
        display:flex;
        gap:13px;
        align-items:flex-start;
        margin-bottom:14px;
    }

    .pa-branch-icon{
        width:52px;
        height:52px;
        border-radius:18px;
        background:linear-gradient(135deg,#eff6ff 0%,#ecfdf5 100%);
        color:#2563eb;
        display:flex;
        align-items:center;
        justify-content:center;
        flex:0 0 52px;
    }

    .pa-branch-icon i{
        font-size:27px;
    }

    .pa-branch-name{
        margin:0 0 5px;
        font-size:19px;
        font-weight:950;
        color:#0f172a;
        line-height:1.35;
    }

    .pa-branch-label{
        display:inline-flex;
        align-items:center;
        gap:5px;
        min-height:28px;
        padding:0 10px;
        border-radius:999px;
        background:#ecfdf5;
        color:#15803d;
        font-size:12px;
        font-weight:900;
    }

    .pa-branch-info{
        display:grid;
        gap:10px;
        margin:8px 0 16px;
        flex:1;
    }

    .pa-branch-row{
        display:grid;
        grid-template-columns:22px minmax(0,1fr);
        gap:8px;
        color:#334155;
        font-size:14px;
        line-height:1.65;
    }

    .pa-branch-row i{
        color:#2563eb;
        font-size:18px;
        margin-top:2px;
    }

    .pa-branch-phone{
        font-weight:900;
        color:#0f172a;
    }

    .pa-branch-actions{
        display:grid;
        grid-template-columns:1fr;
        gap:10px;
        margin-top:auto;
    }

    .pa-call-btn{
        min-height:48px;
        border-radius:999px;
        border:0;
        text-decoration:none;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        font-size:15px;
        font-weight:950;
        background:linear-gradient(135deg,#16a34a 0%,#15803d 100%);
        color:#fff;
        box-shadow:0 12px 24px rgba(22,163,74,.18);
        transition:transform .2s ease, box-shadow .2s ease;
    }

    .pa-call-btn:hover{
        color:#fff;
        text-decoration:none;
        transform:translateY(-1px);
        box-shadow:0 16px 30px rgba(22,163,74,.24);
    }

    .pa-call-btn i{
        font-size:19px;
    }

    .pa-empty-branch{
        grid-column:1 / -1;
        background:#fff;
        border:1px dashed #dbe4f0;
        border-radius:24px;
        padding:34px 22px;
        text-align:center;
        color:#64748b;
        line-height:1.8;
    }

    .pa-empty-branch i{
        width:60px;
        height:60px;
        border-radius:50%;
        background:#eff6ff;
        color:#2563eb;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:30px;
        margin:0 auto 12px;
    }

    .pa-bottom-contact{
        margin-top:24px;
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:18px;
    }

    .pa-bottom-card{
        background:#fff;
        border:1px solid #edf2f7;
        border-radius:26px;
        padding:22px;
        box-shadow:0 14px 35px rgba(15,23,42,.06);
        display:grid;
        grid-template-columns:62px minmax(0,1fr);
        gap:16px;
        align-items:center;
    }

    .pa-bottom-icon{
        width:62px;
        height:62px;
        border-radius:21px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#eff6ff;
        color:#2563eb;
    }

    .pa-bottom-icon.green{
        background:#ecfdf5;
        color:#16a34a;
    }

    .pa-bottom-icon i{
        font-size:32px;
    }

    .pa-bottom-card h3{
        margin:0 0 6px;
        font-size:21px;
        font-weight:950;
        color:#0f172a;
    }

    .pa-bottom-card p{
        margin:0 0 14px;
        color:#64748b;
        line-height:1.7;
        font-size:14px;
    }

    .pa-bottom-actions{
        display:flex;
        gap:10px;
        flex-wrap:wrap;
    }

    .pa-bottom-btn{
        min-height:44px;
        padding:0 15px;
        border-radius:999px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        text-decoration:none;
        font-size:14px;
        font-weight:950;
    }

    .pa-bottom-btn.zalo{
        background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);
        color:#fff;
    }

    .pa-bottom-btn.call{
        background:linear-gradient(135deg,#16a34a 0%,#15803d 100%);
        color:#fff;
    }

    .pa-bottom-btn:hover{
        color:#fff;
        text-decoration:none;
        opacity:.94;
    }

    @media(max-width:1100px){
        .pa-branch-grid{
            grid-template-columns:repeat(2,minmax(0,1fr));
        }

        .pa-bottom-contact{
            grid-template-columns:1fr;
        }
    }

    @media(max-width:768px){
        .pa-pharm-page{
            padding:18px 0 30px;
        }

        .pa-pharm-container{
            width:min(100%, calc(100% - 20px));
        }

        .pa-pharm-hero{
            border-radius:22px;
            padding:22px;
        }

        .pa-pharm-hero h1{
            font-size:29px;
        }

        .pa-pharm-toolbar{
            grid-template-columns:1fr;
            border-radius:20px;
        }

        .pa-pharm-count{
            justify-content:flex-start;
        }

        .pa-branch-grid{
            grid-template-columns:1fr;
        }

        .pa-pharm-section-title{
            font-size:24px;
        }

        .pa-bottom-card{
            grid-template-columns:1fr;
            text-align:center;
        }

        .pa-bottom-icon{
            margin:0 auto;
        }

        .pa-bottom-actions{
            justify-content:center;
        }
    }
</style>
@endsection

@section('content')
<section class="pa-pharm-page">
    <div class="pa-pharm-container">
        <div class="pa-pharm-hero">
            <div class="pa-pharm-hero-inner">
                <div class="pa-pharm-badge">
                    <i class="ri-nurse-line"></i>
                    <span>Dược sĩ Nhà thuốc Phương Anh</span>
                </div>

                <h1>Tư vấn dược sĩ - Hệ thống dược sĩ chuyên môn cao Nhà thuốc Phương Anh</h1>

                <p>
                    Nhà thuốc Phương Anh tại Cao Bằng là đơn vị nhà thuốc số 1 tại tỉnh Cao Bằng với 30 năm phát triển
                    cùng đội ngũ dược sĩ dày dặn kinh nghiệm. Chúng tôi luôn sẵn sàng phục vụ cho sức khỏe cộng đồng,
                    cần hỗ trợ hãy để các dược sĩ chúng tôi tư vấn.
                </p>

                <div class="pa-pharm-tags">
                    <span><i class="ri-heart-pulse-line"></i> Tận tâm với sức khỏe cộng đồng</span>
                    <span><i class="ri-capsule-line"></i> Tư vấn thuốc an toàn</span>
                    <span><i class="ri-customer-service-2-line"></i> Hỗ trợ nhanh qua hotline</span>
                </div>
            </div>
        </div>

        <div class="pa-pharm-toolbar">
            <div class="pa-pharm-search">
                <i class="ri-search-line"></i>
                <input
                    type="text"
                    id="paBranchSearch"
                    placeholder="Tìm chi nhánh theo tên, địa chỉ hoặc số điện thoại..."
                >
            </div>

            <div class="pa-pharm-count">
                <i class="ri-store-2-line"></i>
                <span>{{ $branches->count() }} chi nhánh sẵn sàng hỗ trợ</span>
            </div>
        </div>

        <div class="pa-pharm-section-head">
            <div>
                <h2 class="pa-pharm-section-title">
                    <i class="ri-map-pin-2-line"></i>
                    Danh sách chi nhánh tư vấn
                </h2>
                <p class="pa-pharm-section-sub">
                    Chọn chi nhánh phù hợp và bấm “Gặp dược sĩ” để gọi trực tiếp tới hotline chăm sóc khách hàng.
                </p>
            </div>
        </div>

        <div class="pa-branch-grid" id="paBranchGrid">
            @forelse($branches as $branch)
                <article
                    class="pa-branch-card"
                    data-search="{{ mb_strtolower(($branch->branch_name ?? '') . ' ' . ($branch->address_text ?? '') . ' ' . ($branch->display_phone ?? '')) }}"
                >
                    <div class="pa-branch-top">
                        <div class="pa-branch-icon">
                            <i class="ri-store-3-line"></i>
                        </div>

                        <div>
                            <h3 class="pa-branch-name">{{ $branch->branch_name }}</h3>
                            <div class="pa-branch-label">
                                <i class="ri-verified-badge-line"></i>
                                Dược sĩ trực tư vấn
                            </div>
                        </div>
                    </div>

                    <div class="pa-branch-info">
                        <div class="pa-branch-row">
                            <i class="ri-map-pin-line"></i>
                            <div>{{ $branch->address_text }}</div>
                        </div>

                        <div class="pa-branch-row">
                            <i class="ri-phone-line"></i>
                            <div>
                                Hotline:
                                <span class="pa-branch-phone">{{ $branch->display_phone }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pa-branch-actions">
                        <a href="tel:{{ $branch->tel_phone }}" class="pa-call-btn">
                            <i class="ri-phone-fill"></i>
                            Gặp dược sĩ
                        </a>
                    </div>
                </article>
            @empty
                <div class="pa-empty-branch">
                    <i class="ri-inbox-line"></i>
                    Hiện chưa có dữ liệu chi nhánh. Vui lòng quay lại sau hoặc liên hệ tổng đài 085 884 5845.
                </div>
            @endforelse
        </div>

        <div class="pa-empty-branch" id="paNoBranchResult" style="display:none; margin-top:18px;">
            <i class="ri-search-eye-line"></i>
            Không tìm thấy chi nhánh phù hợp với từ khóa bạn nhập.
        </div>

        <div class="pa-bottom-contact">
            <div class="pa-bottom-card">
                <div class="pa-bottom-icon">
                    <i class="ri-chat-smile-2-line"></i>
                </div>

                <div>
                    <h3>Nhắn tin với dược sĩ</h3>
                    <p>
                        Gửi câu hỏi, ảnh đơn thuốc hoặc nhu cầu cần hỗ trợ qua Zalo OA để dược sĩ Nhà thuốc Phương Anh tư vấn.
                    </p>

                    <div class="pa-bottom-actions">
                        <a href="https://zalo.me/4374437222076872555" target="_blank" class="pa-bottom-btn zalo">
                            <i class="ri-chat-3-fill"></i>
                            Mở Zalo OA
                        </a>
                    </div>
                </div>
            </div>

            <div class="pa-bottom-card">
                <div class="pa-bottom-icon green">
                    <i class="ri-phone-line"></i>
                </div>

                <div>
                    <h3>Gọi tổng đài tư vấn</h3>
                    <p>
                        Cần được hỗ trợ ngay? Gọi tổng đài chung của Nhà thuốc Phương Anh để được kết nối và hướng dẫn nhanh.
                    </p>

                    <div class="pa-bottom-actions">
                        <a href="tel:0858845845" class="pa-bottom-btn call">
                            <i class="ri-phone-fill"></i>
                            085 884 5845
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        const searchInput = document.getElementById('paBranchSearch');
        const branchCards = document.querySelectorAll('.pa-branch-card');
        const noResult = document.getElementById('paNoBranchResult');

        function normalizeText(text) {
            return String(text || '')
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/đ/g, 'd');
        }

        function filterBranches() {
            const keyword = normalizeText(searchInput?.value || '');
            let visibleCount = 0;

            branchCards.forEach((card) => {
                const text = normalizeText(card.getAttribute('data-search') || '');
                const matched = keyword === '' || text.includes(keyword);

                card.style.display = matched ? '' : 'none';

                if (matched) {
                    visibleCount++;
                }
            });

            if (noResult) {
                noResult.style.display = visibleCount === 0 && keyword !== '' ? 'block' : 'none';
            }
        }

        searchInput?.addEventListener('input', filterBranches);
    })();
</script>
@endsection