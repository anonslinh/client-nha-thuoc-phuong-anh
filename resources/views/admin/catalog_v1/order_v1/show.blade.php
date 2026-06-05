@extends('Layout.index')

@section('content')
<div class="pa-admin-order-show-page">
    <div class="pa-admin-order-show-head">
        <div>
            <h1>Chi tiết đơn hàng #{{ $order->order_code }}</h1>
            <p>Theo dõi thông tin khách hàng, sản phẩm, trạng thái xử lý và nhật ký đồng bộ.</p>
        </div>

        <div class="pa-admin-order-show-actions">
            <a href="{{ route('catalog_v1.admin.order_v1.index') }}" class="pa-btn pa-btn-light">Quay lại danh sách</a>
        </div>
    </div>

    @if(session('success'))
        <div class="pa-admin-alert pa-admin-alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="pa-admin-alert pa-admin-alert-danger">{{ session('error') }}</div>
    @endif

    <div class="pa-admin-order-overview">
        <div class="pa-admin-overview-card">
            <div class="label">Tổng thanh toán</div>
            <div class="value">{{ $order->total_amount_format }}</div>
        </div>
        <div class="pa-admin-overview-card">
            <div class="label">Trạng thái đơn</div>
            <div class="value small"><span class="pa-badge {{ $order->order_status_class }}">{{ $order->order_status_label }}</span></div>
        </div>
        <div class="pa-admin-overview-card">
            <div class="label">Thanh toán</div>
            <div class="value small"><span class="pa-badge {{ $order->payment_status_class }}">{{ $order->payment_status_label }}</span></div>
        </div>
        <div class="pa-admin-overview-card">
            <div class="label">Sync KiotViet</div>
            <div class="value small"><span class="pa-badge {{ $order->sync_status_class }}">{{ $order->sync_status_label }}</span></div>
        </div>
    </div>

    <div class="pa-admin-order-show-grid">
        <div class="pa-admin-card">
            <h3 class="pa-card-title">Thông tin khách hàng</h3>
            <div class="pa-info-list">
                <div><strong>Khách hàng:</strong> {{ $order->customer_name }}</div>
                <div><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</div>
                <div><strong>Email:</strong> {{ $order->customer_email ?: 'Không có' }}</div>
                <div><strong>Hình thức nhận:</strong> {{ $order->receive_type_label }}</div>

                @if((int)$order->receive_type === 2)
                    <div><strong>Chi nhánh nhận:</strong> {{ $order->pickup_branch_name ?: 'Chưa chọn' }}</div>
                @else
                    <div><strong>Địa chỉ giao:</strong> {{ $order->delivery_address_text ?: 'Chưa có địa chỉ' }}</div>
                @endif

                @if(!empty($order->note))
                    <div><strong>Ghi chú khách:</strong> {{ $order->note }}</div>
                @endif
            </div>
        </div>

        <div class="pa-admin-card">
            <h3 class="pa-card-title">Thông tin nghiệp vụ</h3>
            <div class="pa-info-list">
                <div><strong>Phương thức thanh toán:</strong> {{ $order->payment_method_label }}</div>
                <div><strong>Tạm tính:</strong> {{ $order->subtotal_amount_format }}</div>
                <div><strong>Giảm giá:</strong> {{ $order->discount_amount_format }}</div>
                <div><strong>Phí giao hàng:</strong> {{ $order->shipping_fee_format }}</div>
                <div><strong>Tổng thanh toán:</strong> {{ $order->total_amount_format }}</div>
                <div><strong>Chi nhánh xử lý:</strong> {{ $order->process_branch_name ?: 'Chưa chọn' }}</div>
                <div><strong>Cần tư vấn:</strong> {{ (int)$order->requires_consult === 1 ? 'Có' : 'Không' }}</div>
                <div><strong>Invoice KiotViet:</strong> {{ $order->kiotviet_invoice_code ?: 'Chưa có' }}</div>
            </div>
        </div>
    </div>

    <div class="pa-admin-card">
        <h3 class="pa-card-title">Chi tiết sản phẩm</h3>

        <div class="pa-admin-table-wrap">
            <table class="pa-admin-table">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Mã SP</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td style="width:90px;">
                                <div class="pa-product-thumb">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->product_name_snapshot }}">
                                </div>
                            </td>
                            <td>{{ $item->product_code_snapshot ?: '---' }}</td>
                            <td><strong>{{ $item->product_name_snapshot }}</strong></td>
                            <td>{{ (int) $item->quantity }}</td>
                            <td>{{ $item->price_snapshot_format }}</td>
                            <td><strong>{{ $item->line_total_format }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="pa-admin-card">
        <h3 class="pa-card-title">Cập nhật đơn hàng</h3>

        <form method="POST" action="{{ route('catalog_v1.admin.order_v1.update', $order->id) }}" class="pa-admin-update-form">
            @csrf

            <div class="pa-admin-form-grid">
                <div class="pa-admin-form-group">
                    <label>Trạng thái đơn</label>
                    <select name="order_status">
                        @foreach($formOptions['order_statuses'] as $key => $label)
                            <option value="{{ $key }}" {{ (int) old('order_status', $order->order_status) === (int) $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('order_status') <div class="pa-error">{{ $message }}</div> @enderror
                </div>

                <div class="pa-admin-form-group">
                    <label>Trạng thái thanh toán</label>
                    <select name="payment_status">
                        @foreach($formOptions['payment_statuses'] as $key => $label)
                            <option value="{{ $key }}" {{ (int) old('payment_status', $order->payment_status) === (int) $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('payment_status') <div class="pa-error">{{ $message }}</div> @enderror
                </div>

                <div class="pa-admin-form-group">
                    <label>Trạng thái sync KiotViet</label>
                    <select name="sync_kiotviet_status">
                        @foreach($formOptions['sync_statuses'] as $key => $label)
                            <option value="{{ $key }}" {{ (int) old('sync_kiotviet_status', $order->sync_kiotviet_status) === (int) $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('sync_kiotviet_status') <div class="pa-error">{{ $message }}</div> @enderror
                </div>

                <div class="pa-admin-form-group">
                    <label>Cần tư vấn</label>
                    <select name="requires_consult">
                        <option value="0" {{ (int) old('requires_consult', $order->requires_consult) === 0 ? 'selected' : '' }}>Không</option>
                        <option value="1" {{ (int) old('requires_consult', $order->requires_consult) === 1 ? 'selected' : '' }}>Có</option>
                    </select>
                    @error('requires_consult') <div class="pa-error">{{ $message }}</div> @enderror
                </div>

                <div class="pa-admin-form-group pa-col-2">
                    <label>Chi nhánh xử lý</label>
                    <select name="id_branch_process">
                        <option value="">-- Chưa chọn --</option>
                        @foreach($formOptions['branches'] as $branch)
                            <option value="{{ $branch->id }}" {{ (int) old('id_branch_process', $order->id_branch_process) === (int) $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_branch_process') <div class="pa-error">{{ $message }}</div> @enderror
                </div>

                <div class="pa-admin-form-group pa-col-2">
                    <label>Ghi chú nội bộ</label>
                    <textarea name="admin_note" rows="4" placeholder="Ghi chú xử lý đơn, liên hệ khách, kiểm tra tồn kho...">{{ old('admin_note', $order->admin_note) }}</textarea>
                    @error('admin_note') <div class="pa-error">{{ $message }}</div> @enderror
                </div>

                <div class="pa-admin-form-group pa-col-2">
                    <label>Lý do hủy đơn (nếu có)</label>
                    <textarea name="cancel_reason" rows="3" placeholder="Nhập lý do hủy nếu chuyển trạng thái sang Đã hủy">{{ old('cancel_reason', $order->cancel_reason) }}</textarea>
                    @error('cancel_reason') <div class="pa-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="pa-admin-form-actions">
                <button type="submit" class="pa-btn pa-btn-primary">Lưu cập nhật</button>
            </div>
        </form>
    </div>

    <div class="pa-admin-order-show-grid">
        <div class="pa-admin-card">
            <h3 class="pa-card-title">Lịch sử trạng thái</h3>

            @if($order->statusLogs->count() > 0)
                <div class="pa-log-list">
                    @foreach($order->statusLogs as $log)
                        <div class="pa-log-item">
                            <div class="pa-log-time">{{ $log->created_at_format }}</div>
                            <div class="pa-log-content">
                                <strong>{{ $log->from_status_label }}</strong> → <strong>{{ $log->to_status_label }}</strong>
                                @if(!empty($log->note))
                                    <div class="pa-log-note">{{ $log->note }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="pa-admin-empty">Chưa có log trạng thái.</div>
            @endif
        </div>

        <div class="pa-admin-card">
            <h3 class="pa-card-title">Lịch sử sync KiotViet</h3>

            @if($order->syncLogs->count() > 0)
                <div class="pa-sync-log-list">
                    @foreach($order->syncLogs as $log)
                        <div class="pa-sync-log-item">
                            <div class="pa-sync-log-top">
                                <strong>{{ $log->sync_type_label }}</strong>
                                <span class="pa-badge {{ $log->status_class }}">{{ $log->status_label }}</span>
                            </div>
                            <div class="pa-sync-log-meta">{{ $log->created_at_format }}</div>

                            @if(!empty($log->error_message))
                                <div class="pa-sync-log-error">{{ $log->error_message }}</div>
                            @endif

                            @if(!empty($log->request_payload))
                                <details>
                                    <summary>Request payload</summary>
                                    <pre>{{ $log->request_payload }}</pre>
                                </details>
                            @endif

                            @if(!empty($log->response_payload))
                                <details>
                                    <summary>Response payload</summary>
                                    <pre>{{ $log->response_payload }}</pre>
                                </details>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="pa-admin-empty">Chưa có log sync KiotViet.</div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .pa-admin-order-show-page{padding:20px}
    .pa-admin-order-show-head{display:flex;justify-content:space-between;align-items:flex-end;gap:16px;flex-wrap:wrap;margin-bottom:20px}
    .pa-admin-order-show-head h1{margin:0 0 8px;font-size:28px;font-weight:800;color:#0f172a}
    .pa-admin-order-show-head p{margin:0;color:#64748b;line-height:1.7}

    .pa-admin-alert{padding:14px 16px;border-radius:14px;margin-bottom:16px;font-weight:700}
    .pa-admin-alert-success{background:#ecfdf5;color:#15803d;border:1px solid #bbf7d0}
    .pa-admin-alert-danger{background:#fef2f2;color:#dc2626;border:1px solid #fecaca}

    .pa-admin-order-overview{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;margin-bottom:20px}
    .pa-admin-overview-card{background:#fff;border-radius:18px;padding:18px;border:1px solid #edf2f7;box-shadow:0 10px 24px rgba(15,23,42,.05)}
    .pa-admin-overview-card .label{font-size:13px;color:#64748b;margin-bottom:10px;font-weight:700}
    .pa-admin-overview-card .value{font-size:28px;line-height:1;font-weight:900;color:#0f172a}
    .pa-admin-overview-card .value.small{font-size:16px}

    .pa-admin-order-show-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px}
    .pa-admin-card{background:#fff;border-radius:20px;padding:18px;border:1px solid #edf2f7;box-shadow:0 10px 24px rgba(15,23,42,.05);margin-bottom:20px}
    .pa-card-title{margin:0 0 16px;font-size:20px;font-weight:800;color:#0f172a}

    .pa-info-list{display:grid;gap:10px;font-size:14px;color:#334155;line-height:1.8}
    .pa-info-list strong{color:#0f172a}

    .pa-admin-table-wrap{overflow:auto}
    .pa-admin-table{width:100%;border-collapse:collapse;min-width:780px}
    .pa-admin-table th,.pa-admin-table td{padding:14px 12px;border-bottom:1px solid #edf2f7;vertical-align:top;font-size:14px}
    .pa-admin-table th{background:#f8fafc;color:#334155;font-weight:800;white-space:nowrap}

    .pa-product-thumb{width:64px;height:64px;border-radius:12px;overflow:hidden;border:1px solid #edf2f7;background:#fff}
    .pa-product-thumb img{width:100%;height:100%;object-fit:contain}

    .pa-admin-update-form .pa-admin-form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}
    .pa-admin-form-group{display:flex;flex-direction:column;gap:8px}
    .pa-admin-form-group label{font-size:13px;font-weight:700;color:#334155}
    .pa-admin-form-group input,
    .pa-admin-form-group select,
    .pa-admin-form-group textarea{width:100%;border:1px solid #dbe4f0;border-radius:12px;padding:12px;font-size:14px;color:#0f172a;background:#fff;outline:none}
    .pa-admin-form-group select{min-height:42px;padding:0 12px}
    .pa-admin-form-group input:focus,
    .pa-admin-form-group select:focus,
    .pa-admin-form-group textarea:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.08)}
    .pa-col-2{grid-column:span 2}
    .pa-admin-form-actions{margin-top:16px}
    .pa-error{font-size:12px;color:#dc2626;font-weight:700}

    .pa-btn{display:inline-flex;align-items:center;justify-content:center;min-height:42px;padding:0 14px;border-radius:12px;border:0;text-decoration:none;font-size:14px;font-weight:800;cursor:pointer}
    .pa-btn:hover{text-decoration:none}
    .pa-btn-primary{background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);color:#fff}
    .pa-btn-light{background:#f8fafc;color:#334155;border:1px solid #dbe4f0}

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

    .pa-log-list,.pa-sync-log-list{display:grid;gap:12px}
    .pa-log-item,.pa-sync-log-item{border:1px solid #edf2f7;border-radius:16px;padding:14px;background:#fff}
    .pa-log-time,.pa-sync-log-meta{font-size:12px;color:#64748b;margin-bottom:6px}
    .pa-log-content{font-size:14px;color:#334155;line-height:1.7}
    .pa-log-note{margin-top:6px;color:#64748b}
    .pa-sync-log-top{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:6px}
    .pa-sync-log-error{padding:10px 12px;border-radius:12px;background:#fef2f2;color:#dc2626;font-size:13px;font-weight:700;margin-top:8px}
    .pa-sync-log-item details{margin-top:10px}
    .pa-sync-log-item summary{cursor:pointer;font-weight:700;color:#1d4ed8}
    .pa-sync-log-item pre{margin-top:8px;padding:12px;background:#0f172a;color:#f8fafc;border-radius:12px;font-size:12px;white-space:pre-wrap;word-break:break-word}

    .pa-admin-empty{text-align:center;padding:20px 16px;color:#64748b}

    @media (max-width:1200px){
        .pa-admin-order-overview{grid-template-columns:repeat(2,minmax(0,1fr))}
        .pa-admin-order-show-grid{grid-template-columns:1fr}
    }

    @media (max-width:768px){
        .pa-admin-order-show-page{padding:14px}
        .pa-admin-overview-card .value{font-size:22px}
        .pa-admin-update-form .pa-admin-form-grid{grid-template-columns:1fr}
        .pa-col-2{grid-column:span 1}
    }
</style>
@endsection

@section('script')
<script>
</script>
@endsection