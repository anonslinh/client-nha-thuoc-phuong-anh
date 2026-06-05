@extends('website.layout.index')

@section('style')
<style>
    .lc-myorder-page{
        padding: 28px 0 40px;
        background: #f5f7fb;
    }

    .lc-container{
        width: min(1320px, calc(100% - 32px));
        margin: 0 auto;
    }

    .lc-myorder-head{
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .lc-myorder-title{
        margin: 0 0 8px;
        font-size: 36px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-myorder-sub{
        font-size: 15px;
        color: #64748b;
        line-height: 1.7;
    }

    .lc-myorder-phone{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 42px;
        padding: 0 14px;
        border-radius: 999px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 14px;
        font-weight: 800;
    }

    .lc-myorder-stats{
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    .lc-myorder-stat{
        background: #fff;
        border-radius: 22px;
        padding: 18px;
        box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
    }

    .lc-myorder-stat-label{
        font-size: 14px;
        color: #64748b;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .lc-myorder-stat-value{
        font-size: 32px;
        line-height: 1;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-myorder-filter{
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .lc-myorder-filter-btn{
        min-height: 42px;
        padding: 0 16px;
        border-radius: 999px;
        background: #fff;
        border: 1px solid #dbe4f0;
        color: #334155;
        text-decoration: none;
        font-size: 14px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .lc-myorder-filter-btn:hover{
        border-color: #94b8ff;
        color: #1d4ed8;
        text-decoration: none;
    }

    .lc-myorder-filter-btn.is-active{
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 12px 24px rgba(37, 99, 235, 0.16);
    }

    .lc-myorder-list{
        display: grid;
        gap: 18px;
    }

    .lc-myorder-card{
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    .lc-myorder-card-head{
        display: flex;
        justify-content: space-between;
        gap: 18px;
        flex-wrap: wrap;
        padding: 20px 22px 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .lc-myorder-code{
        margin: 0 0 8px;
        font-size: 22px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-myorder-meta{
        display: flex;
        gap: 10px 18px;
        flex-wrap: wrap;
        font-size: 14px;
        color: #64748b;
    }

    .lc-myorder-head-right{
        text-align: right;
    }

    .lc-myorder-total{
        font-size: 30px;
        font-weight: 900;
        color: #2563eb;
        line-height: 1;
        margin-bottom: 10px;
    }

    .lc-order-badges{
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 8px;
    }

    .lc-badge{
        min-height: 34px;
        padding: 0 12px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 800;
        border: 1px solid transparent;
    }

    .lc-badge.is-new{ background: #eff6ff; color: #1d4ed8; }
    .lc-badge.is-confirmed{ background: #eef2ff; color: #4338ca; }
    .lc-badge.is-processing{ background: #fff7ed; color: #c2410c; }
    .lc-badge.is-shipping{ background: #ecfeff; color: #0f766e; }
    .lc-badge.is-completed{ background: #ecfdf5; color: #15803d; }
    .lc-badge.is-cancelled{ background: #fef2f2; color: #dc2626; }
    .lc-badge.is-default{ background: #f8fafc; color: #334155; }

    .lc-badge.is-unpaid{ background: #fef3c7; color: #92400e; }
    .lc-badge.is-paid{ background: #dcfce7; color: #166534; }
    .lc-badge.is-partial{ background: #e0f2fe; color: #075985; }
    .lc-badge.is-refunded{ background: #ede9fe; color: #6d28d9; }

    .lc-myorder-card-body{
        padding: 18px 22px 20px;
    }

    .lc-myorder-items{
        display: grid;
        gap: 12px;
        margin-bottom: 18px;
    }

    .lc-myorder-item{
        display: grid;
        grid-template-columns: 74px minmax(0, 1fr) auto;
        gap: 14px;
        align-items: center;
        padding: 12px;
        border-radius: 18px;
        border: 1px solid #edf2f7;
        background: #fafcff;
    }

    .lc-myorder-item-thumb{
        width: 74px;
        height: 74px;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #edf2f7;
        background: #fff;
    }

    .lc-myorder-item-thumb img{
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .lc-myorder-item-name{
        font-size: 15px;
        line-height: 1.5;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .lc-myorder-item-meta{
        font-size: 13px;
        line-height: 1.7;
        color: #64748b;
    }

    .lc-myorder-item-total{
        font-size: 16px;
        font-weight: 900;
        color: #0f172a;
        white-space: nowrap;
    }

    .lc-myorder-extra{
        display: none;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px dashed #dbe4f0;
    }

    .lc-myorder-extra.show{
        display: block;
    }

    .lc-myorder-extra-grid{
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .lc-myorder-info-box{
        border: 1px solid #edf2f7;
        border-radius: 18px;
        background: #fff;
        padding: 16px;
    }

    .lc-myorder-info-title{
        margin: 0 0 10px;
        font-size: 16px;
        font-weight: 900;
        color: #0f172a;
    }

    .lc-myorder-info-text{
        font-size: 14px;
        line-height: 1.8;
        color: #334155;
    }

    .lc-myorder-card-actions{
        margin-top: 16px;
        display: flex;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    .lc-myorder-card-note{
        font-size: 13px;
        color: #64748b;
    }

    .lc-myorder-toggle{
        min-height: 42px;
        padding: 0 16px;
        border-radius: 999px;
        background: #eff6ff;
        border: 0;
        color: #1d4ed8;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
    }

    .lc-myorder-empty,
    .lc-myorder-guest-empty{
        background: #fff;
        border-radius: 24px;
        padding: 32px 24px;
        text-align: center;
        box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
        border: 1px dashed #dbe4f0;
        color: #64748b;
        font-size: 16px;
        line-height: 1.8;
    }

    .lc-myorder-empty strong,
    .lc-myorder-guest-empty strong{
        color: #0f172a;
    }

    .lc-myorder-empty a,
    .lc-myorder-guest-empty a{
        color: #2563eb;
        font-weight: 800;
        text-decoration: none;
    }

    .lc-search-pagination{
        margin-top: 24px;
        display: flex;
        justify-content: center;
    }

    .lc-search-pagination nav{
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .lc-search-pagination .pagination{
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .lc-search-pagination .page-item .page-link{
        min-width: 42px;
        height: 42px;
        padding: 0 14px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        color: #0f172a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        background: #fff;
        font-weight: 700;
    }

    .lc-search-pagination .page-item.active .page-link{
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 10px 22px rgba(37, 99, 235, 0.2);
    }

    .lc-search-pagination .page-item .page-link:hover{
        background: #eef4ff;
        border-color: #cfe0ff;
    }

    @media (max-width: 991px){
        .lc-myorder-stats{
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .lc-myorder-extra-grid{
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px){
        .lc-myorder-page{
            padding: 18px 0 30px;
        }

        .lc-container{
            width: min(100%, calc(100% - 20px));
        }

        .lc-myorder-title{
            font-size: 28px;
        }

        .lc-myorder-stats{
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .lc-myorder-stat-value{
            font-size: 26px;
        }

        .lc-myorder-card-head{
            padding: 16px 16px 14px;
        }

        .lc-myorder-card-body{
            padding: 16px;
        }

        .lc-myorder-head-right{
            text-align: left;
            width: 100%;
        }

        .lc-order-badges{
            justify-content: flex-start;
        }

        .lc-myorder-item{
            grid-template-columns: 64px minmax(0, 1fr);
        }

        .lc-myorder-item-total{
            grid-column: 2 / 3;
            white-space: normal;
        }
    }
</style>
@endsection

@section('content')
@php
    $buildFilterUrl = function ($status) {
        return route('website.my-order.index', array_filter([
            'status' => $status !== 'all' ? $status : null
        ]));
    };
@endphp

<section class="lc-myorder-page">
    <div class="lc-container">
        <div class="lc-myorder-head">
            <div>
                <h1 class="lc-myorder-title">Đơn hàng của tôi</h1>
                <div class="lc-myorder-sub">
                    Theo dõi các đơn hàng đã đặt, trạng thái xử lý và thông tin giao nhận một cách rõ ràng, dễ tra cứu.
                </div>
            </div>

            @if(!empty($customerPhone))
                <div class="lc-myorder-phone">
                    Số điện thoại tra cứu: {{ $customerPhone }}
                </div>
            @endif
        </div>

        @if(empty($customerPhone))
            <div class="lc-myorder-guest-empty">
                <strong>Bạn chưa có thông tin khách hàng lưu trên hệ thống.</strong><br>
                Vui lòng cập nhật thông tin từ nút <strong>Đăng nhập</strong> ở phần header để hệ thống nhận diện và hiển thị đơn hàng của bạn.
            </div>
        @else
            <div class="lc-myorder-stats">
                <div class="lc-myorder-stat">
                    <div class="lc-myorder-stat-label">Tổng đơn hàng</div>
                    <div class="lc-myorder-stat-value">{{ $stats['total'] }}</div>
                </div>

                <div class="lc-myorder-stat">
                    <div class="lc-myorder-stat-label">Đang xử lý</div>
                    <div class="lc-myorder-stat-value">{{ $stats['processing'] }}</div>
                </div>

                <div class="lc-myorder-stat">
                    <div class="lc-myorder-stat-label">Hoàn thành</div>
                    <div class="lc-myorder-stat-value">{{ $stats['completed'] }}</div>
                </div>

                <div class="lc-myorder-stat">
                    <div class="lc-myorder-stat-label">Đã hủy</div>
                    <div class="lc-myorder-stat-value">{{ $stats['cancelled'] }}</div>
                </div>
            </div>

            <div class="lc-myorder-filter">
                @foreach($filterOptions as $key => $label)
                    <a href="{{ $buildFilterUrl($key) }}"
                       class="lc-myorder-filter-btn {{ $statusFilter === $key ? 'is-active' : '' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            @if($orders && $orders->count() > 0)
                <div class="lc-myorder-list">
                    @foreach($orders as $order)
                        <article class="lc-myorder-card">
                            <div class="lc-myorder-card-head">
                                <div>
                                    <h3 class="lc-myorder-code">Đơn #{{ $order->order_code }}</h3>
                                    <div class="lc-myorder-meta">
                                        <span>Ngày đặt: {{ $order->created_at_format }}</span>
                                        <span>{{ $order->receive_type_label }}</span>
                                        <span>{{ $order->payment_method_label }}</span>
                                    </div>
                                </div>

                                <div class="lc-myorder-head-right">
                                    <div class="lc-myorder-total">{{ $order->total_amount_format }}</div>

                                    <div class="lc-order-badges">
                                        <span class="lc-badge {{ $order->status_class }}">
                                            {{ $order->status_label }}
                                        </span>

                                        <span class="lc-badge {{ $order->payment_status_class }}">
                                            {{ $order->payment_status_label }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="lc-myorder-card-body">
                                <div class="lc-myorder-items">
                                    @foreach($order->items->take(2) as $item)
                                        <div class="lc-myorder-item">
                                            <div class="lc-myorder-item-thumb">
                                                <img src="{{ $item->image_url }}" alt="{{ $item->product_name_snapshot }}">
                                            </div>

                                            <div>
                                                <div class="lc-myorder-item-name">{{ $item->product_name_snapshot }}</div>
                                                <div class="lc-myorder-item-meta">
                                                    Số lượng: {{ (int) $item->quantity }}<br>
                                                    Đơn giá: {{ $item->price_snapshot_format }}
                                                </div>
                                            </div>

                                            <div class="lc-myorder-item-total">
                                                {{ $item->line_total_format }}
                                            </div>
                                        </div>
                                    @endforeach

                                    @if($order->items->count() > 2)
                                        <div class="lc-myorder-card-note">
                                            +{{ $order->items->count() - 2 }} sản phẩm khác trong đơn hàng này.
                                        </div>
                                    @endif
                                </div>

                                <div class="lc-myorder-extra" id="order-extra-{{ $order->id }}">
                                    <div class="lc-myorder-extra-grid">
                                        <div class="lc-myorder-info-box">
                                            <h4 class="lc-myorder-info-title">Thông tin giao / nhận</h4>
                                            <div class="lc-myorder-info-text">
                                                <strong>Hình thức:</strong> {{ $order->receive_type_label }}<br>

                                                @if((int) $order->receive_type === 2)
                                                    <strong>Chi nhánh:</strong> {{ $order->pickup_branch_name ?? 'Đang cập nhật' }}
                                                @else
                                                    <strong>Địa chỉ:</strong>
                                                    {{ $order->delivery_address_text ?: 'Đang cập nhật' }}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="lc-myorder-info-box">
                                            <h4 class="lc-myorder-info-title">Thông tin thanh toán</h4>
                                            <div class="lc-myorder-info-text">
                                                <strong>Phương thức:</strong> {{ $order->payment_method_label }}<br>
                                                <strong>Trạng thái:</strong> {{ $order->payment_status_label }}<br>
                                                <strong>Tạm tính:</strong> {{ $order->subtotal_amount_format }}<br>
                                                <strong>Tổng thanh toán:</strong> {{ $order->total_amount_format }}
                                            </div>
                                        </div>

                                        @if(!empty($order->note))
                                            <div class="lc-myorder-info-box" style="grid-column: 1 / -1;">
                                                <h4 class="lc-myorder-info-title">Ghi chú đơn hàng</h4>
                                                <div class="lc-myorder-info-text">
                                                    {{ $order->note }}
                                                </div>
                                            </div>
                                        @endif

                                        <div class="lc-myorder-info-box" style="grid-column: 1 / -1;">
                                            <h4 class="lc-myorder-info-title">Chi tiết sản phẩm</h4>

                                            <div class="lc-myorder-items" style="margin-bottom:0;">
                                                @foreach($order->items as $item)
                                                    <div class="lc-myorder-item">
                                                        <div class="lc-myorder-item-thumb">
                                                            <img src="{{ $item->image_url }}" alt="{{ $item->product_name_snapshot }}">
                                                        </div>

                                                        <div>
                                                            <div class="lc-myorder-item-name">{{ $item->product_name_snapshot }}</div>
                                                            <div class="lc-myorder-item-meta">
                                                                Số lượng: {{ (int) $item->quantity }}<br>
                                                                Đơn giá: {{ $item->price_snapshot_format }}
                                                            </div>
                                                        </div>

                                                        <div class="lc-myorder-item-total">
                                                            {{ $item->line_total_format }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="lc-myorder-card-actions">
                                    <div class="lc-myorder-card-note">
                                        Mã đơn: {{ $order->order_code }} • Khách hàng: {{ $order->customer_name }}
                                    </div>

                                    <button
                                        type="button"
                                        class="lc-myorder-toggle"
                                        data-target="order-extra-{{ $order->id }}"
                                    >
                                        Xem chi tiết
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="lc-search-pagination">
                    {{ $orders->onEachSide(1)->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="lc-myorder-empty">
                    <strong>Chưa tìm thấy đơn hàng nào.</strong><br>
                    Hệ thống hiện chưa có đơn hàng phù hợp với số điện thoại này. Bạn có thể <a href="{{ url('/') }}">tiếp tục mua sắm</a> hoặc kiểm tra lại thông tin khách hàng.
                </div>
            @endif
        @endif
    </div>
</section>

<script>
    (function () {
        const toggleButtons = document.querySelectorAll('.lc-myorder-toggle');

        toggleButtons.forEach((button) => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const target = document.getElementById(targetId);
                if (!target) return;

                const isShown = target.classList.contains('show');

                if (isShown) {
                    target.classList.remove('show');
                    this.textContent = 'Xem chi tiết';
                } else {
                    target.classList.add('show');
                    this.textContent = 'Thu gọn';
                }
            });
        });
    })();
</script>
@endsection