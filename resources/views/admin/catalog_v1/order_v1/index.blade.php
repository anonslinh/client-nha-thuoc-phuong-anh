@extends('Layout.index')

@section('content')
<div class="pa-admin-order-page">
    <div class="pa-admin-order-head">
        <div>
            <h1>Quản trị đơn hàng</h1>
            <p>Quản lý tập trung đơn hàng website, theo dõi trạng thái xử lý, thanh toán và đồng bộ KiotViet.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="pa-admin-alert pa-admin-alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="pa-admin-alert pa-admin-alert-danger">{{ session('error') }}</div>
    @endif

    <div class="pa-admin-order-stats">
        <div class="pa-admin-stat-card">
            <div class="label">Tổng đơn</div>
            <div class="value">{{ $summary['total'] }}</div>
        </div>
        <div class="pa-admin-stat-card">
            <div class="label">Đơn mới</div>
            <div class="value">{{ $summary['new'] }}</div>
        </div>
        <div class="pa-admin-stat-card">
            <div class="label">Đang xử lý</div>
            <div class="value">{{ $summary['processing'] }}</div>
        </div>
        <div class="pa-admin-stat-card">
            <div class="label">Hoàn thành</div>
            <div class="value">{{ $summary['completed'] }}</div>
        </div>
        <div class="pa-admin-stat-card">
            <div class="label">Sync lỗi</div>
            <div class="value text-danger">{{ $summary['sync_error'] }}</div>
        </div>
    </div>

    <div class="pa-admin-card">
        <form method="GET" class="pa-admin-filter-grid">
            <div class="pa-admin-form-group pa-admin-col-2">
                <label>Từ khóa</label>
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Mã đơn, tên khách, SĐT, email">
            </div>

            <div class="pa-admin-form-group">
                <label>Trạng thái đơn</label>
                <select name="order_status">
                    <option value="">-- Tất cả --</option>
                    @foreach($filterOptions['order_statuses'] as $key => $label)
                        <option value="{{ $key }}" {{ request('order_status') !== null && request('order_status') !== '' && (int) request('order_status') === (int) $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pa-admin-form-group">
                <label>Sync KiotViet</label>
                <select name="sync_kiotviet_status">
                    <option value="">-- Tất cả --</option>
                    @foreach($filterOptions['sync_statuses'] as $key => $label)
                        <option value="{{ $key }}" {{ request('sync_kiotviet_status') !== null && request('sync_kiotviet_status') !== '' && (int) request('sync_kiotviet_status') === (int) $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pa-admin-form-group">
                <label>Phương thức thanh toán</label>
                <select name="payment_method">
                    <option value="">-- Tất cả --</option>
                    @foreach($filterOptions['payment_methods'] as $key => $label)
                        <option value="{{ $key }}" {{ request('payment_method') !== null && request('payment_method') !== '' && (int) request('payment_method') === (int) $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pa-admin-form-group">
                <label>Trạng thái thanh toán</label>
                <select name="payment_status">
                    <option value="">-- Tất cả --</option>
                    @foreach($filterOptions['payment_statuses'] as $key => $label)
                        <option value="{{ $key }}" {{ request('payment_status') !== null && request('payment_status') !== '' && (int) request('payment_status') === (int) $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pa-admin-form-group">
                <label>Hình thức nhận</label>
                <select name="receive_type">
                    <option value="">-- Tất cả --</option>
                    @foreach($filterOptions['receive_types'] as $key => $label)
                        <option value="{{ $key }}" {{ request('receive_type') !== null && request('receive_type') !== '' && (int) request('receive_type') === (int) $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pa-admin-form-group">
                <label>Từ ngày</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}">
            </div>

            <div class="pa-admin-form-group">
                <label>Đến ngày</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}">
            </div>

            <div class="pa-admin-form-actions pa-admin-col-2">
                <button type="submit" class="pa-btn pa-btn-primary">Lọc dữ liệu</button>
                <a href="{{ route('catalog_v1.admin.order_v1.index') }}" class="pa-btn pa-btn-light">Xóa lọc</a>
            </div>
        </form>
    </div>

    <div class="pa-admin-card">
        <div class="pa-admin-table-wrap">
            <table class="pa-admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Sản phẩm</th>
                        <th>Nhận hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái đơn</th>
                        <th>Thanh toán</th>
                        <th>Sync</th>
                        <th>Ngày tạo</th>
                        <th style="width:120px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>
                                <strong>{{ $order->order_code }}</strong>
                                @if(!empty($order->kiotviet_invoice_code))
                                    <div class="pa-admin-subtext">KV: {{ $order->kiotviet_invoice_code }}</div>
                                @endif
                            </td>
                            <td>
                                <div><strong>{{ $order->customer_name }}</strong></div>
                                <div class="pa-admin-subtext">{{ $order->customer_phone }}</div>
                                @if(!empty($order->customer_email))
                                    <div class="pa-admin-subtext">{{ $order->customer_email }}</div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $order->total_items }}</strong> SP
                            </td>
                            <td>
                                <div>{{ $order->receive_type_label }}</div>
                                @if((int)$order->receive_type === 2 && !empty($order->pickup_branch_name))
                                    <div class="pa-admin-subtext">{{ $order->pickup_branch_name }}</div>
                                @elseif((int)$order->receive_type === 1)
                                    <div class="pa-admin-subtext">Giao tận nơi</div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $order->total_amount_format }}</strong>
                            </td>
                            <td>
                                <span class="pa-badge {{ $order->order_status_class }}">{{ $order->order_status_label }}</span>
                            </td>
                            <td>
                                <div>{{ $order->payment_method_label }}</div>
                                <div style="margin-top:6px;">
                                    <span class="pa-badge {{ $order->payment_status_class }}">{{ $order->payment_status_label }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="pa-badge {{ $order->sync_status_class }}">{{ $order->sync_status_label }}</span>
                            </td>
                            <td>{{ $order->created_at_format }}</td>
                            <td>
                                <a href="{{ route('catalog_v1.admin.order_v1.show', $order->id) }}" class="pa-btn pa-btn-sm pa-btn-primary">
                                    Chi tiết
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11">
                                <div class="pa-admin-empty">Chưa có đơn hàng phù hợp với bộ lọc hiện tại.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="pa-admin-pagination">
                {{ $orders->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('style')
<style>
    .pa-admin-order-page{padding:20px}
    .pa-admin-order-head{display:flex;justify-content:space-between;align-items:flex-end;gap:16px;flex-wrap:wrap;margin-bottom:20px}
    .pa-admin-order-head h1{margin:0 0 8px;font-size:28px;font-weight:800;color:#0f172a}
    .pa-admin-order-head p{margin:0;color:#64748b;line-height:1.7}
    .pa-admin-alert{padding:14px 16px;border-radius:14px;margin-bottom:16px;font-weight:700}
    .pa-admin-alert-success{background:#ecfdf5;color:#15803d;border:1px solid #bbf7d0}
    .pa-admin-alert-danger{background:#fef2f2;color:#dc2626;border:1px solid #fecaca}

    .pa-admin-order-stats{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:16px;margin-bottom:20px}
    .pa-admin-stat-card{background:#fff;border-radius:18px;padding:18px;border:1px solid #edf2f7;box-shadow:0 10px 24px rgba(15,23,42,.05)}
    .pa-admin-stat-card .label{font-size:13px;color:#64748b;margin-bottom:10px;font-weight:700}
    .pa-admin-stat-card .value{font-size:30px;line-height:1;font-weight:900;color:#0f172a}
    .pa-admin-stat-card .value.text-danger{color:#dc2626}

    .pa-admin-card{background:#fff;border-radius:20px;padding:18px;border:1px solid #edf2f7;box-shadow:0 10px 24px rgba(15,23,42,.05);margin-bottom:20px}
    .pa-admin-filter-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px}
    .pa-admin-col-2{grid-column:span 2}
    .pa-admin-form-group{display:flex;flex-direction:column;gap:8px}
    .pa-admin-form-group label{font-size:13px;font-weight:700;color:#334155}
    .pa-admin-form-group input,
    .pa-admin-form-group select{width:100%;min-height:42px;border:1px solid #dbe4f0;border-radius:12px;padding:0 12px;font-size:14px;color:#0f172a;background:#fff;outline:none}
    .pa-admin-form-group input:focus,
    .pa-admin-form-group select:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.08)}
    .pa-admin-form-actions{display:flex;align-items:flex-end;gap:10px}

    .pa-btn{display:inline-flex;align-items:center;justify-content:center;min-height:42px;padding:0 14px;border-radius:12px;border:0;text-decoration:none;font-size:14px;font-weight:800;cursor:pointer}
    .pa-btn:hover{text-decoration:none}
    .pa-btn-primary{background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);color:#fff}
    .pa-btn-light{background:#f8fafc;color:#334155;border:1px solid #dbe4f0}
    .pa-btn-sm{min-height:36px;padding:0 12px;font-size:13px}

    .pa-admin-table-wrap{overflow:auto}
    .pa-admin-table{width:100%;border-collapse:collapse;min-width:1200px}
    .pa-admin-table th,
    .pa-admin-table td{padding:14px 12px;border-bottom:1px solid #edf2f7;vertical-align:top;font-size:14px}
    .pa-admin-table th{background:#f8fafc;color:#334155;font-weight:800;white-space:nowrap}
    .pa-admin-subtext{font-size:12px;color:#64748b;margin-top:3px}
    .pa-admin-empty{text-align:center;padding:30px 16px;color:#64748b}

    .pa-badge{display:inline-flex;align-items:center;justify-content:center;min-height:30px;padding:0 10px;border-radius:999px;font-size:12px;font-weight:800}
    .pa-badge.is-new{background:#eff6ff;color:#1d4ed8}
    .pa-badge.is-confirmed{background:#eef2ff;color:#4338ca}
    .pa-badge.is-processing{background:#fff7ed;color:#c2410c}
    .pa-badge.is-syncwait{background:#fef3c7;color:#92400e}
    .pa-badge.is-synced{background:#dcfce7;color:#166534}
    .pa-badge.is-shipping{background:#ecfeff;color:#0f766e}
    .pa-badge.is-completed{background:#ecfdf5;color:#15803d}
    .pa-badge.is-cancelled{background:#fef2f2;color:#dc2626}
    .pa-badge.is-default{background:#f1f5f9;color:#334155}
    .pa-badge.is-warning{background:#fef3c7;color:#92400e}
    .pa-badge.is-success{background:#dcfce7;color:#166534}
    .pa-badge.is-danger{background:#fef2f2;color:#dc2626}
    .pa-badge.is-info{background:#e0f2fe;color:#075985}

    .pa-admin-pagination{margin-top:18px;display:flex;justify-content:center}
    .pa-admin-pagination .pagination{margin-bottom:0}

    @media (max-width:1200px){
        .pa-admin-order-stats{grid-template-columns:repeat(3,minmax(0,1fr))}
        .pa-admin-filter-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
    }

    @media (max-width:768px){
        .pa-admin-order-page{padding:14px}
        .pa-admin-order-stats{grid-template-columns:repeat(2,minmax(0,1fr))}
        .pa-admin-filter-grid{grid-template-columns:1fr}
        .pa-admin-col-2{grid-column:span 1}
        .pa-admin-form-actions{flex-direction:column;align-items:stretch}
    }
</style>
@endsection

@section('script')
<script>
</script>
@endsection