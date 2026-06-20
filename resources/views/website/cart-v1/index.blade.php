@extends('website.layout.index')

@section('style')
<style>
    .lc-cart-page{
        padding: 28px 0 40px;
        background: #f5f7fb;
    }

    .lc-container{
        width: min(1320px, calc(100% - 32px));
        margin: 0 auto;
    }

    .lc-cart-head{
        margin-bottom: 20px;
    }

    .lc-cart-title{
        margin: 0 0 8px;
        font-size: 34px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-cart-sub{
        font-size: 15px;
        color: #64748b;
    }

    .lc-cart-layout{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        gap: 24px;
        align-items: start;
    }

    .lc-cart-card,
    .lc-cart-summary{
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
    }

    .lc-cart-card{
        padding: 22px;
    }

    .lc-cart-summary{
        padding: 22px;
        position: sticky;
        top: 20px;
    }

    .lc-cart-list{
        display: grid;
        gap: 16px;
    }

    .lc-cart-item{
        display: grid;
        grid-template-columns: 112px minmax(0, 1fr) auto;
        gap: 16px;
        align-items: center;
        padding: 16px;
        border: 1px solid #edf2f7;
        border-radius: 20px;
        background: #fff;
    }

    .lc-cart-thumb{
        width: 112px;
        height: 112px;
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
        border: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lc-cart-thumb img{
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .lc-cart-name{
        display: block;
        margin: 0 0 8px;
        font-size: 18px;
        line-height: 1.5;
        font-weight: 800;
        color: #0f172a;
        text-decoration: none;
    }

    .lc-cart-name:hover{
        color: #2563eb;
    }

    .lc-cart-code{
        margin-bottom: 10px;
        font-size: 13px;
        color: #64748b;
    }

    .lc-cart-price{
        font-size: 20px;
        font-weight: 900;
        color: #2563eb;
        margin-bottom: 12px;
    }

    .lc-cart-qty-wrap{
        display: inline-flex;
        align-items: center;
        border: 1px solid #dbe4f0;
        border-radius: 999px;
        overflow: hidden;
        height: 42px;
    }

    .lc-cart-qty-btn{
        width: 42px;
        height: 42px;
        border: 0;
        background: #f8fafc;
        font-size: 22px;
        cursor: pointer;
    }

    .lc-cart-qty-input{
        width: 58px;
        border: 0;
        outline: none;
        text-align: center;
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
    }

    .lc-cart-right{
        min-width: 160px;
        text-align: right;
    }

    .lc-cart-line-total{
        font-size: 20px;
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 12px;
    }

    .lc-cart-remove{
        border: 0;
        background: #fef2f2;
        color: #dc2626;
        height: 40px;
        padding: 0 14px;
        border-radius: 999px;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
    }

    .lc-cart-summary-title{
        margin: 0 0 18px;
        font-size: 24px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-summary-row{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px dashed #e2e8f0;
        font-size: 15px;
        color: #334155;
    }

    .lc-summary-row strong{
        color: #0f172a;
        font-size: 18px;
    }

    .lc-summary-total{
        padding-top: 16px;
        margin-top: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
    }

    .lc-summary-total .lc-total-price{
        font-size: 30px;
        font-weight: 900;
        color: #2563eb;
    }

    .lc-summary-actions{
        margin-top: 18px;
        display: grid;
        gap: 12px;
    }

    .lc-btn{
        min-height: 50px;
        border-radius: 999px;
        border: 0;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 16px;
        font-weight: 800;
    }

    .lc-btn-primary{
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
        box-shadow: 0 12px 24px rgba(37, 99, 235, 0.2);
    }

    .lc-btn-secondary{
        background: #eff6ff;
        color: #1d4ed8;
    }

    .lc-btn-danger{
        background: #fef2f2;
        color: #dc2626;
    }

    .lc-cart-empty{
        padding: 38px 24px;
        text-align: center;
        border: 1px dashed #dbe4f0;
        border-radius: 20px;
        color: #64748b;
        font-size: 16px;
    }

    .lc-cart-empty a{
        color: #2563eb;
        font-weight: 800;
        text-decoration: none;
    }

    @media (max-width: 991px){
        .lc-cart-layout{
            grid-template-columns: 1fr;
        }

        .lc-cart-summary{
            position: static;
        }
    }

    @media (max-width: 767px){
        .lc-cart-page{
            padding: 18px 0 28px;
        }

        .lc-container{
            width: min(100%, calc(100% - 20px));
        }

        .lc-cart-title{
            font-size: 26px;
        }

        .lc-cart-item{
            grid-template-columns: 1fr;
            text-align: left;
        }

        .lc-cart-right{
            text-align: left;
            min-width: 100%;
        }
    }

    .lc-cart-page{
        --pa-cart-ink: #0b2430;
        --pa-cart-deep: #073f45;
        --pa-cart-teal: #0f8b7c;
        --pa-cart-teal-2: #0a6466;
        --pa-cart-mint: #e8f7f1;
        --pa-cart-soft: #f4faf8;
        --pa-cart-line: rgba(9, 47, 48, .12);
        background:
            radial-gradient(circle at 12% 0%, rgba(15,139,124,.08), transparent 28%),
            linear-gradient(180deg, #f4faf8 0%, #ffffff 46%, #f4faf8 100%) !important;
        overflow-x: hidden;
    }

    .lc-cart-page,
    .lc-cart-page *{
        box-sizing: border-box;
    }

    .lc-cart-title,
    .lc-cart-summary-title,
    .lc-cart-name,
    .lc-cart-line-total,
    .lc-summary-row strong,
    .lc-summary-total{
        color: var(--pa-cart-ink) !important;
    }

    .lc-cart-name:hover,
    .lc-cart-price,
    .lc-summary-total .lc-total-price,
    .lc-cart-empty a{
        color: var(--pa-cart-teal) !important;
    }

    .lc-cart-card,
    .lc-cart-summary{
        border: 1px solid var(--pa-cart-line);
        box-shadow: 0 18px 42px rgba(9,47,48,.08) !important;
    }

    .lc-cart-item,
    .lc-cart-thumb,
    .lc-cart-qty-wrap{
        border-color: var(--pa-cart-line) !important;
    }

    .lc-cart-thumb{
        background:
            radial-gradient(circle at 50% 45%, #ffffff 0%, #f5fbfb 58%, #edf7f4 100%) !important;
    }

    .lc-cart-qty-btn{
        background: #f8fcfa !important;
        color: var(--pa-cart-deep);
    }

    .lc-cart-qty-input{
        color: var(--pa-cart-ink) !important;
    }

    .lc-summary-row{
        border-bottom-color: rgba(9,47,48,.12) !important;
    }

    .lc-btn-primary{
        background: linear-gradient(135deg, var(--pa-cart-teal), var(--pa-cart-deep)) !important;
        box-shadow: 0 14px 28px rgba(9,47,48,.18) !important;
    }

    .lc-btn-secondary{
        background: var(--pa-cart-mint) !important;
        color: var(--pa-cart-deep) !important;
    }

    .lc-cart-remove,
    .lc-btn-danger{
        background: #fff3f3 !important;
        color: #c81e1e !important;
    }

    .lc-cart-empty{
        border-color: rgba(9,47,48,.18) !important;
        background: #ffffff;
    }

    @media (max-width: 767px){
        .lc-cart-page .lc-container{
            width: min(calc(100vw - 24px), 366px) !important;
            max-width: min(calc(100vw - 24px), 366px) !important;
            margin-left: 12px !important;
            margin-right: 12px !important;
            overflow: hidden;
        }

        .lc-cart-head{
            margin-bottom: 14px !important;
        }

        .lc-cart-title{
            font-size: 25px !important;
            line-height: 1.18 !important;
        }

        .lc-cart-sub{
            font-size: 13px !important;
            line-height: 1.55 !important;
        }

        .lc-cart-layout{
            gap: 14px !important;
        }

        .lc-cart-card,
        .lc-cart-summary{
            padding: 12px !important;
            border-radius: 18px !important;
        }

        .lc-cart-list{
            gap: 10px !important;
        }

        .lc-cart-item{
            grid-template-columns: 78px minmax(0, 1fr) !important;
            gap: 10px !important;
            align-items: start !important;
            padding: 10px !important;
            border-radius: 16px !important;
        }

        .lc-cart-thumb{
            width: 78px !important;
            height: 78px !important;
            border-radius: 14px !important;
        }

        .lc-cart-name{
            margin-bottom: 5px !important;
            font-size: 13px !important;
            line-height: 1.35 !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
        }

        .lc-cart-code{
            display: none !important;
        }

        .lc-cart-price{
            margin-bottom: 8px !important;
            font-size: 14px !important;
        }

        .lc-cart-qty-wrap{
            height: 34px !important;
        }

        .lc-cart-qty-btn{
            width: 34px !important;
            height: 34px !important;
            font-size: 18px !important;
        }

        .lc-cart-qty-input{
            width: 42px !important;
            font-size: 14px !important;
        }

        .lc-cart-right{
            grid-column: 1 / -1 !important;
            min-width: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 10px !important;
            padding-top: 8px !important;
            border-top: 1px dashed rgba(9,47,48,.12);
        }

        .lc-cart-line-total{
            margin-bottom: 0 !important;
            font-size: 15px !important;
        }

        .lc-cart-remove{
            height: 32px !important;
            padding: 0 10px !important;
            font-size: 12px !important;
        }

        .lc-cart-summary-title{
            margin-bottom: 10px !important;
            font-size: 20px !important;
        }

        .lc-summary-row{
            padding: 9px 0 !important;
            font-size: 13px !important;
        }

        .lc-summary-row strong{
            font-size: 15px !important;
        }

        .lc-summary-total .lc-total-price{
            font-size: 23px !important;
        }

        .lc-summary-actions{
            gap: 9px !important;
            margin-top: 14px !important;
        }

        .lc-btn{
            min-height: 42px !important;
            font-size: 13px !important;
        }
    }
</style>
@endsection

@section('content')
<section class="lc-cart-page">
    <div class="lc-container">
        <div class="lc-cart-head">
            <h1 class="lc-cart-title">Giỏ hàng của bạn</h1>
            <div class="lc-cart-sub">Kiểm tra sản phẩm, cập nhật số lượng và chuẩn bị sang bước đặt hàng.</div>
        </div>

        <div class="lc-cart-layout">
            <div class="lc-cart-card">
                @if($cart->items->count() > 0)
                    <div class="lc-cart-list" id="lcCartList">
                        @foreach($cart->items as $item)
                            <div class="lc-cart-item" data-item-id="{{ $item->id }}">
                                <a href="{{ $item->detail_url }}" class="lc-cart-thumb">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->product_name_snapshot }}">
                                </a>

                                <div>
                                    <a href="{{ $item->detail_url }}" class="lc-cart-name">
                                        {{ $item->product_name_snapshot }}
                                    </a>

                                    <div class="lc-cart-code">
                                        {{ $item->product_code_snapshot ? 'Mã: '.$item->product_code_snapshot : '' }}
                                    </div>

                                    <div class="lc-cart-price">
                                        {{ number_format((float)$item->price_snapshot, 0, ',', '.') }}đ
                                    </div>

                                    <div class="lc-cart-qty-wrap">
                                        <button type="button" class="lc-cart-qty-btn js-qty-minus">−</button>
                                        <input
                                            type="text"
                                            class="lc-cart-qty-input js-qty-input"
                                            value="{{ (int)$item->quantity }}"
                                        >
                                        <button type="button" class="lc-cart-qty-btn js-qty-plus">+</button>
                                    </div>
                                </div>

                                <div class="lc-cart-right">
                                    <div class="lc-cart-line-total">
                                        {{ number_format((float)$item->line_total, 0, ',', '.') }}đ
                                    </div>

                                    <button type="button" class="lc-cart-remove js-remove-item">
                                        Xóa sản phẩm
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="lc-cart-empty">
                        Giỏ hàng hiện đang trống. <a href="{{ url('/') }}">Tiếp tục mua sắm</a>
                    </div>
                @endif
            </div>

            <div class="lc-cart-summary">
                <h2 class="lc-cart-summary-title">Tóm tắt đơn hàng</h2>

                <div class="lc-summary-row">
                    <span>Tổng số lượng</span>
                    <strong id="lcSummaryQty">{{ (int)$cart->total_quantity }}</strong>
                </div>

                <div class="lc-summary-row">
                    <span>Tạm tính</span>
                    <strong id="lcSummarySubtotal">{{ number_format((float)$cart->subtotal_amount, 0, ',', '.') }}đ</strong>
                </div>

                <div class="lc-summary-total">
                    <span>Tổng cộng</span>
                    <span class="lc-total-price" id="lcSummaryTotal">
                        {{ number_format((float)$cart->subtotal_amount, 0, ',', '.') }}đ
                    </span>
                </div>

                <div class="lc-summary-actions">
                    <a href="{{ url('/') }}" class="lc-btn lc-btn-secondary">Tiếp tục mua sắm</a>

                    <a href="{{ route('website.checkout.index') }}" class="lc-btn lc-btn-primary">
                        Sang bước đặt hàng
                    </a>

                    @if($cart->items->count() > 0)
                        <button type="button" class="lc-btn lc-btn-danger" id="lcClearCartBtn">
                            Xóa toàn bộ giỏ hàng
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        const UPDATE_URL = @json(route('website.cart.update'));
        const REMOVE_URL = @json(route('website.cart.remove'));
        const CLEAR_URL = @json(route('website.cart.clear'));
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        function formatMoney(value) {
            const num = Number(value || 0);
            return num.toLocaleString('vi-VN') + 'đ';
        }

        function postData(url, data = {}) {
            return fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(res => res.json());
        }

        function updateSummary(data) {
            if (!data) return;

            const qtyEl = document.getElementById('lcSummaryQty');
            const subtotalEl = document.getElementById('lcSummarySubtotal');
            const totalEl = document.getElementById('lcSummaryTotal');

            if (qtyEl) qtyEl.textContent = data.total_quantity ?? 0;
            if (subtotalEl) subtotalEl.textContent = formatMoney(data.subtotal_amount ?? 0);
            if (totalEl) totalEl.textContent = formatMoney(data.subtotal_amount ?? 0);
        }

        document.querySelectorAll('.lc-cart-item').forEach((row) => {
            const itemId = Number(row.getAttribute('data-item-id'));
            const qtyInput = row.querySelector('.js-qty-input');
            const btnMinus = row.querySelector('.js-qty-minus');
            const btnPlus = row.querySelector('.js-qty-plus');
            const btnRemove = row.querySelector('.js-remove-item');

            function normalizeInput() {
                let value = parseInt(qtyInput.value, 10);
                if (isNaN(value) || value < 1) value = 1;
                if (value > 999) value = 999;
                qtyInput.value = value;
                return value;
            }

            function sendUpdate() {
                const quantity = normalizeInput();

                postData(UPDATE_URL, {
                    item_id: itemId,
                    quantity: quantity
                }).then((result) => {
                    if (!result.status) {
                        alert(result.msg || 'Không thể cập nhật giỏ hàng.');
                        return;
                    }
                    window.location.reload();
                }).catch(() => {
                    alert('Có lỗi xảy ra khi cập nhật giỏ hàng.');
                });
            }

            btnMinus?.addEventListener('click', function () {
                let value = normalizeInput();
                qtyInput.value = Math.max(1, value - 1);
                sendUpdate();
            });

            btnPlus?.addEventListener('click', function () {
                let value = normalizeInput();
                qtyInput.value = Math.min(999, value + 1);
                sendUpdate();
            });

            qtyInput?.addEventListener('change', function () {
                sendUpdate();
            });

            qtyInput?.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '');
            });

            btnRemove?.addEventListener('click', function () {
                if (!confirm('Bạn muốn xóa sản phẩm này khỏi giỏ hàng?')) return;

                postData(REMOVE_URL, {
                    item_id: itemId
                }).then((result) => {
                    if (!result.status) {
                        alert(result.msg || 'Không thể xóa sản phẩm.');
                        return;
                    }
                    window.location.reload();
                }).catch(() => {
                    alert('Có lỗi xảy ra khi xóa sản phẩm.');
                });
            });
        });

        const clearBtn = document.getElementById('lcClearCartBtn');
        clearBtn?.addEventListener('click', function () {
            if (!confirm('Bạn muốn xóa toàn bộ giỏ hàng?')) return;

            postData(CLEAR_URL, {}).then((result) => {
                if (!result.status) {
                    alert(result.msg || 'Không thể xóa toàn bộ giỏ hàng.');
                    return;
                }
                window.location.reload();
            }).catch(() => {
                alert('Có lỗi xảy ra khi xóa giỏ hàng.');
            });
        });
    })();
</script>
@endsection
