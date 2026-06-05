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

        <div class="lc-form-group full">
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
                        <strong>{{ number_format((float)$cart->subtotal_amount, 0, ',', '.') }}đ</strong>
                    </div>

                    <div class="lc-summary-row">
                        <span>Phí vận chuyển</span>
                        <strong>0đ</strong>
                    </div>

                    <div class="lc-summary-total">
                        <span>Tổng thanh toán</span>
                        <span>{{ number_format((float)$cart->subtotal_amount, 0, ',', '.') }}đ</span>
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
@endsection