@extends('website.layout.index')

@section('style')
<style>
    .lc-checkout-success-page{
        padding: 36px 0 44px;
        background: #f5f7fb;
    }

    .lc-container{
        width: min(1080px, calc(100% - 32px));
        margin: 0 auto;
    }

    .lc-success-card{
        background: #fff;
        border-radius: 28px;
        padding: 28px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
    }

    .lc-success-top{
        text-align: center;
        margin-bottom: 24px;
    }

    .lc-success-icon{
        width: 86px;
        height: 86px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        font-weight: 900;
    }

    .lc-success-title{
        margin: 0 0 8px;
        font-size: 34px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-success-sub{
        font-size: 16px;
        color: #64748b;
        line-height: 1.8;
    }

    .lc-success-grid{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 24px;
    }

    .lc-info-box{
        background: #f8fbff;
        border: 1px solid #e3edff;
        border-radius: 20px;
        padding: 18px;
    }

    .lc-info-box h3{
        margin: 0 0 12px;
        font-size: 20px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-info-row{
        display: flex;
        justify-content: space-between;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px dashed #dbe4f0;
        font-size: 15px;
        color: #334155;
    }

    .lc-info-row:last-child{
        border-bottom: 0;
    }

    .lc-product-list{
        display: grid;
        gap: 12px;
    }

    .lc-product-item{
        display: grid;
        grid-template-columns: 64px minmax(0, 1fr);
        gap: 12px;
        align-items: start;
        padding: 12px;
        border-radius: 16px;
        border: 1px solid #edf2f7;
        background: #fff;
    }

    .lc-product-thumb{
        width: 64px;
        height: 64px;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #edf2f7;
        background: #fff;
    }

    .lc-product-thumb img{
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .lc-product-name{
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.5;
        margin-bottom: 4px;
    }

    .lc-product-meta{
        font-size: 13px;
        color: #64748b;
        line-height: 1.6;
    }

    .lc-success-actions{
        display: flex;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    .lc-btn{
        min-height: 48px;
        padding: 0 20px;
        border-radius: 999px;
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
    }

    .lc-btn-secondary{
        background: #eff6ff;
        color: #1d4ed8;
    }

    @media (max-width: 767px){
        .lc-checkout-success-page{
            padding: 20px 0 30px;
        }

        .lc-container{
            width: min(100%, calc(100% - 20px));
        }

        .lc-success-card{
            border-radius: 20px;
            padding: 20px;
        }

        .lc-success-title{
            font-size: 26px;
        }

        .lc-success-grid{
            grid-template-columns: 1fr;
        }
    }

    .lc-checkout-success-page{
        --pa-success-ink: #0b2430;
        --pa-success-deep: #073f45;
        --pa-success-teal: #0f8b7c;
        --pa-success-mint: #e8f7f1;
        --pa-success-line: rgba(9, 47, 48, .12);
        background:
            radial-gradient(circle at 12% 0%, rgba(15,139,124,.08), transparent 28%),
            linear-gradient(180deg, #f4faf8 0%, #ffffff 46%, #f4faf8 100%) !important;
        overflow-x: hidden;
    }

    .lc-checkout-success-page,
    .lc-checkout-success-page *{
        box-sizing: border-box;
    }

    .lc-success-card,
    .lc-info-box,
    .lc-product-item,
    .lc-product-thumb{
        border-color: var(--pa-success-line) !important;
    }

    .lc-success-card{
        border: 1px solid var(--pa-success-line);
        box-shadow: 0 18px 42px rgba(9,47,48,.08) !important;
    }

    .lc-success-icon,
    .lc-btn-primary{
        background: linear-gradient(135deg, var(--pa-success-teal), var(--pa-success-deep)) !important;
    }

    .lc-success-title,
    .lc-info-box h3,
    .lc-product-name{
        color: var(--pa-success-ink) !important;
    }

    .lc-info-box{
        background: #f8fcfa !important;
        border: 1px solid var(--pa-success-line) !important;
    }

    .lc-info-row{
        border-bottom-color: rgba(9,47,48,.12) !important;
    }

    .lc-product-thumb{
        background:
            radial-gradient(circle at 50% 45%, #ffffff 0%, #f5fbfb 58%, #edf7f4 100%) !important;
    }

    .lc-btn-secondary{
        background: var(--pa-success-mint) !important;
        color: var(--pa-success-deep) !important;
    }

    @media (max-width: 767px){
        .lc-checkout-success-page .lc-container{
            width: min(calc(100vw - 24px), 366px) !important;
            max-width: min(calc(100vw - 24px), 366px) !important;
            margin-left: 12px !important;
            margin-right: 12px !important;
            overflow: hidden;
        }

        .lc-success-card{
            padding: 16px !important;
            border-radius: 18px !important;
        }

        .lc-success-icon{
            width: 68px !important;
            height: 68px !important;
            margin-bottom: 12px !important;
            font-size: 32px !important;
        }

        .lc-success-title{
            font-size: 24px !important;
            line-height: 1.2 !important;
        }

        .lc-success-sub{
            font-size: 13px !important;
            line-height: 1.6 !important;
        }

        .lc-success-grid{
            gap: 12px !important;
            margin-bottom: 16px !important;
        }

        .lc-info-box{
            padding: 13px !important;
            border-radius: 16px !important;
        }

        .lc-info-box h3{
            font-size: 18px !important;
        }

        .lc-info-row{
            align-items: flex-start;
            font-size: 12.5px !important;
        }

        .lc-product-item{
            grid-template-columns: 52px minmax(0, 1fr) !important;
            gap: 9px !important;
            padding: 8px !important;
        }

        .lc-product-thumb{
            width: 52px !important;
            height: 52px !important;
        }

        .lc-product-name{
            font-size: 12.5px !important;
            line-height: 1.35 !important;
        }

        .lc-product-meta{
            font-size: 11.5px !important;
            line-height: 1.45 !important;
        }

        .lc-success-actions{
            gap: 9px !important;
            margin-top: 16px !important;
        }

        .lc-btn{
            width: 100%;
            min-height: 42px !important;
            font-size: 13px !important;
        }
    }
</style>
@endsection

@section('content')
<section class="lc-checkout-success-page">
    <div class="lc-container">
        <div class="lc-success-card">
            <div class="lc-success-top">
                <div class="lc-success-icon">✓</div>
                <h1 class="lc-success-title">Đặt hàng thành công</h1>
                <div class="lc-success-sub">
                    Cảm ơn bạn đã đặt hàng tại Dược Phương Anh. Đơn hàng của bạn đã được ghi nhận và sẽ được liên hệ xử lý sớm.
                </div>
            </div>

            <div class="lc-success-grid">
                <div class="lc-info-box">
                    <h3>Thông tin đơn hàng</h3>

                    <div class="lc-info-row">
                        <span>Mã đơn</span>
                        <strong>{{ $order->order_code }}</strong>
                    </div>

                    <div class="lc-info-row">
                        <span>Khách hàng</span>
                        <strong>{{ $order->customer_name }}</strong>
                    </div>

                    <div class="lc-info-row">
                        <span>Số điện thoại</span>
                        <strong>{{ $order->customer_phone }}</strong>
                    </div>

                    <div class="lc-info-row">
                        <span>Hình thức nhận</span>
                        <strong>{{ (int)$order->receive_type === 2 ? 'Nhận tại nhà thuốc' : 'Giao tận nơi' }}</strong>
                    </div>

                    <div class="lc-info-row">
                        <span>Thanh toán</span>
                        <strong>
                            @if((int)$order->payment_method === 1)
                                COD
                            @elseif((int)$order->payment_method === 2)
                                Chuyển khoản
                            @else
                                Thanh toán tại quầy
                            @endif
                        </strong>
                    </div>

                    <div class="lc-info-row">
                        <span>Tổng tiền</span>
                        <strong>{{ number_format((float)$order->total_amount, 0, ',', '.') }}đ</strong>
                    </div>
                </div>

                <div class="lc-info-box">
                    <h3>Sản phẩm trong đơn</h3>

                    <div class="lc-product-list">
                        @foreach($order->items as $item)
                            <div class="lc-product-item">
                                <div class="lc-product-thumb">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->product_name_snapshot }}">
                                </div>

                                <div>
                                    <div class="lc-product-name">{{ $item->product_name_snapshot }}</div>
                                    <div class="lc-product-meta">
                                        SL: {{ (int)$item->quantity }} <br>
                                        Đơn giá: {{ number_format((float)$item->price_snapshot, 0, ',', '.') }}đ <br>
                                        Thành tiền: {{ number_format((float)$item->line_total, 0, ',', '.') }}đ
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="lc-success-actions">
                <a href="{{ url('/') }}" class="lc-btn lc-btn-primary">Tiếp tục mua sắm</a>
                <a href="{{ route('website.cart.index') }}" class="lc-btn lc-btn-secondary">Xem giỏ hàng mới</a>
            </div>
        </div>
    </div>
</section>
@endsection
