@extends('Layout.index')

@section('content')
<div class="pa-admin-prescription-show-page">
    <div class="pa-admin-page-head">
        <div>
            <h1>Chi tiết yêu cầu #{{ $requestItem->request_code }}</h1>
            <p>Xem nội dung đơn thuốc, thông tin khách hàng và cập nhật trạng thái xử lý.</p>
        </div>

        <div>
            <a href="{{ route('catalog_v1.prescription_request_v1.index') }}" class="pa-btn pa-btn-light">
                Quay lại danh sách
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="pa-alert pa-alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="pa-alert pa-alert-danger">{{ session('error') }}</div>
    @endif

    <div class="pa-overview-grid">
        <div class="pa-overview-card">
            <div class="label">Mã yêu cầu</div>
            <div class="value">{{ $requestItem->request_code }}</div>
        </div>

        <div class="pa-overview-card">
            <div class="label">Trạng thái</div>
            <div class="value small">
                <span class="pa-badge {{ $requestItem->status_class }}">
                    {{ $requestItem->status_label }}
                </span>
            </div>
        </div>

        <div class="pa-overview-card">
            <div class="label">Ngày gửi</div>
            <div class="value small-text">{{ $requestItem->created_at_format }}</div>
        </div>

        <div class="pa-overview-card">
            <div class="label">Chi nhánh xử lý</div>
            <div class="value small-text">{{ $requestItem->branch_name ?: 'Chưa phân chi nhánh' }}</div>
        </div>
    </div>

    <div class="pa-detail-grid">
        <div class="pa-admin-card">
            <h3 class="pa-card-title">Thông tin khách hàng</h3>

            <div class="pa-info-list">
                <div><strong>Họ tên:</strong> {{ $requestItem->customer_name }}</div>
                <div><strong>Số điện thoại:</strong> {{ $requestItem->customer_phone }}</div>
                <div><strong>Địa chỉ:</strong> {{ $requestItem->customer_address ?: 'Chưa có địa chỉ' }}</div>
                <div><strong>Thời gian xác nhận:</strong> {{ $requestItem->confirmed_at_format ?: 'Chưa xác nhận' }}</div>
                <div><strong>Thời gian xử lý:</strong> {{ $requestItem->processed_at_format ?: 'Chưa xử lý' }}</div>
            </div>

            <div class="pa-contact-actions">
                <a href="tel:{{ $requestItem->customer_phone }}" class="pa-btn pa-btn-primary">
                    Gọi khách hàng
                </a>

                <a href="https://zalo.me/{{ $requestItem->customer_phone }}" target="_blank" class="pa-btn pa-btn-light">
                    Mở Zalo theo SĐT
                </a>
            </div>
        </div>

        <div class="pa-admin-card">
            <h3 class="pa-card-title">Ảnh đơn thuốc</h3>

            @if(!empty($requestItem->prescription_image))
                <a href="{{ $requestItem->image_url }}" target="_blank" class="pa-prescription-image">
                    <img src="{{ $requestItem->image_url }}" alt="{{ $requestItem->request_code }}">
                </a>

                <a href="{{ $requestItem->image_url }}" target="_blank" class="pa-open-image-link">
                    Mở ảnh kích thước lớn
                </a>
            @else
                <div class="pa-no-prescription-image">
                    Khách chưa upload ảnh đơn thuốc.
                </div>
            @endif
        </div>
    </div>

    <div class="pa-detail-grid">
        <div class="pa-admin-card">
            <h3 class="pa-card-title">Nội dung đơn thuốc / nhu cầu mua thuốc</h3>

            <div class="pa-content-box">
                {!! nl2br(e($requestItem->prescription_content ?: 'Khách chưa nhập nội dung. Vui lòng kiểm tra ảnh đơn thuốc nếu có.')) !!}
            </div>
        </div>

        <div class="pa-admin-card">
            <h3 class="pa-card-title">Ghi chú của khách</h3>

            <div class="pa-content-box">
                {!! nl2br(e($requestItem->note ?: 'Không có ghi chú thêm.')) !!}
            </div>
        </div>
    </div>

    <div class="pa-admin-card">
        <h3 class="pa-card-title">Cập nhật xử lý yêu cầu</h3>

        <form method="POST" action="{{ route('catalog_v1.prescription_request_v1.update', $requestItem->id) }}" class="pa-update-form">
            @csrf

            <div class="pa-form-grid">
                <div class="pa-form-group">
                    <label>Trạng thái xử lý</label>
                    <select name="status">
                        @foreach($statusOptions as $key => $label)
                            <option value="{{ $key }}" {{ (int) old('status', $requestItem->status) === (int) $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status') <div class="pa-error">{{ $message }}</div> @enderror
                </div>

                <div class="pa-form-group">
                    <label>Chi nhánh xử lý</label>
                    <select name="branch_id">
                        <option value="">-- Chưa phân chi nhánh --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ (int) old('branch_id', $requestItem->branch_id) === (int) $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id') <div class="pa-error">{{ $message }}</div> @enderror
                </div>

                <div class="pa-form-group">
                    <label>ID đơn hàng đã tạo nếu có</label>
                    <input
                        type="number"
                        name="created_order_id"
                        value="{{ old('created_order_id', $requestItem->created_order_id) }}"
                        placeholder="Ví dụ: 125"
                    >
                    @error('created_order_id') <div class="pa-error">{{ $message }}</div> @enderror
                </div>

                <div class="pa-form-group pa-col-2">
                    <label>Phản hồi / tư vấn từ dược sĩ</label>
                    <textarea
                        name="pharmacist_response"
                        rows="5"
                        placeholder="Nhập nội dung tư vấn, hướng xử lý, thuốc thay thế, hướng dẫn cho khách..."
                    >{{ old('pharmacist_response', $requestItem->pharmacist_response) }}</textarea>
                    @error('pharmacist_response') <div class="pa-error">{{ $message }}</div> @enderror
                </div>

                <div class="pa-form-group pa-col-2">
                    <label>Ghi chú nội bộ</label>
                    <textarea
                        name="admin_note"
                        rows="5"
                        placeholder="Ghi chú nội bộ: đã gọi khách, khách hẹn lại, thiếu ảnh đơn, cần kiểm tồn kho..."
                    >{{ old('admin_note', $requestItem->admin_note) }}</textarea>
                    @error('admin_note') <div class="pa-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="pa-form-actions">
                <button type="submit" class="pa-btn pa-btn-primary">
                    Lưu cập nhật
                </button>
            </div>
        </form>
    </div>

    <div class="pa-admin-card">
        <h3 class="pa-card-title">Thông tin phản hồi hiện tại</h3>

        <div class="pa-response-grid">
            <div>
                <h4>Phản hồi dược sĩ</h4>
                <div class="pa-content-box">
                    {!! nl2br(e($requestItem->pharmacist_response ?: 'Chưa có phản hồi từ dược sĩ.')) !!}
                </div>
            </div>

            <div>
                <h4>Ghi chú nội bộ</h4>
                <div class="pa-content-box">
                    {!! nl2br(e($requestItem->admin_note ?: 'Chưa có ghi chú nội bộ.')) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .pa-admin-prescription-show-page{
        padding:20px;
    }

    .pa-admin-page-head{
        display:flex;
        justify-content:space-between;
        align-items:flex-end;
        gap:16px;
        flex-wrap:wrap;
        margin-bottom:20px;
    }

    .pa-admin-page-head h1{
        margin:0 0 8px;
        font-size:28px;
        font-weight:800;
        color:#0f172a;
    }

    .pa-admin-page-head p{
        margin:0;
        color:#64748b;
        line-height:1.7;
    }

    .pa-alert{
        padding:14px 16px;
        border-radius:14px;
        margin-bottom:16px;
        font-weight:700;
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

    .pa-overview-grid{
        display:grid;
        grid-template-columns:repeat(4,minmax(0,1fr));
        gap:16px;
        margin-bottom:20px;
    }

    .pa-overview-card{
        background:#fff;
        border-radius:18px;
        padding:18px;
        border:1px solid #edf2f7;
        box-shadow:0 10px 24px rgba(15,23,42,.05);
    }

    .pa-overview-card .label{
        font-size:13px;
        color:#64748b;
        margin-bottom:10px;
        font-weight:700;
    }

    .pa-overview-card .value{
        font-size:22px;
        line-height:1.2;
        font-weight:900;
        color:#0f172a;
    }

    .pa-overview-card .value.small,
    .pa-overview-card .value.small-text{
        font-size:15px;
        line-height:1.5;
    }

    .pa-detail-grid{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:20px;
        margin-bottom:20px;
    }

    .pa-admin-card{
        background:#fff;
        border-radius:20px;
        padding:18px;
        border:1px solid #edf2f7;
        box-shadow:0 10px 24px rgba(15,23,42,.05);
        margin-bottom:20px;
    }

    .pa-card-title{
        margin:0 0 16px;
        font-size:20px;
        font-weight:800;
        color:#0f172a;
    }

    .pa-info-list{
        display:grid;
        gap:10px;
        color:#334155;
        font-size:14px;
        line-height:1.7;
    }

    .pa-info-list strong{
        color:#0f172a;
    }

    .pa-contact-actions{
        display:flex;
        gap:10px;
        flex-wrap:wrap;
        margin-top:18px;
    }

    .pa-prescription-image{
        display:block;
        width:100%;
        max-height:420px;
        border-radius:18px;
        overflow:hidden;
        background:#f8fafc;
        border:1px solid #e2e8f0;
    }

    .pa-prescription-image img{
        width:100%;
        max-height:420px;
        object-fit:contain;
        display:block;
        background:#fff;
    }

    .pa-open-image-link{
        display:inline-flex;
        margin-top:12px;
        color:#2563eb;
        font-weight:800;
        text-decoration:none;
    }

    .pa-no-prescription-image{
        min-height:160px;
        border:1px dashed #dbe4f0;
        border-radius:18px;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#64748b;
        font-weight:700;
        background:#f8fafc;
    }

    .pa-content-box{
        background:#f8fafc;
        border:1px solid #e2e8f0;
        border-radius:16px;
        padding:16px;
        color:#334155;
        line-height:1.8;
        font-size:14px;
        min-height:80px;
    }

    .pa-form-grid{
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:16px;
    }

    .pa-form-group{
        display:flex;
        flex-direction:column;
        gap:8px;
    }

    .pa-form-group label{
        font-size:13px;
        font-weight:700;
        color:#334155;
    }

    .pa-form-group input,
    .pa-form-group select,
    .pa-form-group textarea{
        width:100%;
        border:1px solid #dbe4f0;
        border-radius:12px;
        padding:12px;
        font-size:14px;
        color:#0f172a;
        background:#fff;
        outline:none;
    }

    .pa-form-group select{
        min-height:44px;
        padding:0 12px;
    }

    .pa-form-group input:focus,
    .pa-form-group select:focus,
    .pa-form-group textarea:focus{
        border-color:#2563eb;
        box-shadow:0 0 0 3px rgba(37,99,235,.08);
    }

    .pa-col-2{
        grid-column:span 2;
    }

    .pa-form-actions{
        margin-top:16px;
    }

    .pa-response-grid{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:18px;
    }

    .pa-response-grid h4{
        margin:0 0 10px;
        font-size:16px;
        font-weight:800;
        color:#0f172a;
    }

    .pa-error{
        font-size:12px;
        color:#dc2626;
        font-weight:700;
    }

    .pa-btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-height:42px;
        padding:0 14px;
        border-radius:12px;
        border:0;
        text-decoration:none;
        font-size:14px;
        font-weight:800;
        cursor:pointer;
        white-space:nowrap;
    }

    .pa-btn:hover{
        text-decoration:none;
    }

    .pa-btn-primary{
        background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);
        color:#fff;
    }

    .pa-btn-light{
        background:#f8fafc;
        color:#334155;
        border:1px solid #dbe4f0;
    }

    .pa-badge{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-height:30px;
        padding:0 10px;
        border-radius:999px;
        font-size:12px;
        font-weight:800;
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

    @media(max-width:1200px){
        .pa-overview-grid{
            grid-template-columns:repeat(2,minmax(0,1fr));
        }

        .pa-detail-grid,
        .pa-response-grid{
            grid-template-columns:1fr;
        }
    }

    @media(max-width:768px){
        .pa-admin-prescription-show-page{
            padding:14px;
        }

        .pa-overview-grid{
            grid-template-columns:1fr;
        }

        .pa-form-grid{
            grid-template-columns:1fr;
        }

        .pa-col-2{
            grid-column:span 1;
        }
    }
</style>
@endsection

@section('script')
<script>
</script>
@endsection