@extends('Layout.index')

@section('content')
<div class="pa-admin-prescription-page">
    <div class="pa-admin-page-head">
        <div>
            <h1>Yêu cầu cần mua thuốc</h1>
            <p>Quản lý các yêu cầu khách hàng gửi ảnh đơn thuốc, nội dung cần mua và thông tin liên hệ.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="pa-alert pa-alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="pa-alert pa-alert-danger">{{ session('error') }}</div>
    @endif

    <div class="pa-stats-grid">
        <div class="pa-stat-card">
            <div class="pa-stat-label">Tổng yêu cầu</div>
            <div class="pa-stat-value">{{ $summary['total'] }}</div>
        </div>

        <div class="pa-stat-card">
            <div class="pa-stat-label">Chưa xác nhận</div>
            <div class="pa-stat-value text-warning">{{ $summary['pending'] }}</div>
        </div>

        <div class="pa-stat-card">
            <div class="pa-stat-label">Đã xác nhận</div>
            <div class="pa-stat-value text-info">{{ $summary['confirmed'] }}</div>
        </div>

        <div class="pa-stat-card">
            <div class="pa-stat-label">Đã xử lý</div>
            <div class="pa-stat-value text-success">{{ $summary['processed'] }}</div>
        </div>
    </div>

    <div class="pa-admin-card">
        <form method="GET" class="pa-filter-grid">
            <div class="pa-form-group pa-col-2">
                <label>Từ khóa</label>
                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="Mã yêu cầu, tên khách, số điện thoại, nội dung đơn thuốc..."
                >
            </div>

            <div class="pa-form-group">
                <label>Trạng thái</label>
                <select name="status">
                    <option value="">-- Tất cả --</option>
                    @foreach($statusOptions as $key => $label)
                        <option value="{{ $key }}" {{ request('status') !== null && request('status') !== '' && (int) request('status') === (int) $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pa-form-group">
                <label>Chi nhánh xử lý</label>
                <select name="branch_id">
                    <option value="">-- Tất cả --</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ request('branch_id') !== null && request('branch_id') !== '' && (int) request('branch_id') === (int) $branch->id ? 'selected' : '' }}>
                            {{ $branch->branch_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pa-form-group">
                <label>Từ ngày</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}">
            </div>

            <div class="pa-form-group">
                <label>Đến ngày</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}">
            </div>

            <div class="pa-filter-actions pa-col-2">
                <button type="submit" class="pa-btn pa-btn-primary">Lọc dữ liệu</button>
                <a href="{{ route('catalog_v1.prescription_request_v1.index') }}" class="pa-btn pa-btn-light">Xóa lọc</a>
            </div>
        </form>
    </div>

    <div class="pa-admin-card">
        <div class="pa-table-wrap">
            <table class="pa-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã yêu cầu</th>
                        <th>Khách hàng</th>
                        <th>Ảnh đơn</th>
                        <th>Nội dung yêu cầu</th>
                        <th>Chi nhánh</th>
                        <th>Trạng thái</th>
                        <th>Ngày gửi</th>
                        <th style="width:120px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $item)
                        <tr>
                            <td>#{{ $item->id }}</td>

                            <td>
                                <strong>{{ $item->request_code }}</strong>
                            </td>

                            <td>
                                <div><strong>{{ $item->customer_name }}</strong></div>
                                <div class="pa-subtext">{{ $item->customer_phone }}</div>

                                @if(!empty($item->customer_address))
                                    <div class="pa-subtext pa-line-clamp-2">{{ $item->customer_address }}</div>
                                @endif
                            </td>

                            <td>
                                @if(!empty($item->prescription_image))
                                    <a href="{{ $item->image_url }}" target="_blank" class="pa-request-thumb">
                                        <img src="{{ $item->image_url }}" alt="{{ $item->request_code }}">
                                    </a>
                                @else
                                    <span class="pa-no-image">Không có ảnh</span>
                                @endif
                            </td>

                            <td>
                                <div class="pa-line-clamp-3">
                                    {{ $item->prescription_content ?: 'Khách chưa nhập nội dung, vui lòng xem ảnh đơn thuốc.' }}
                                </div>

                                @if(!empty($item->note))
                                    <div class="pa-subtext pa-line-clamp-2">
                                        Ghi chú: {{ $item->note }}
                                    </div>
                                @endif
                            </td>

                            <td>
                                {{ $item->branch_name ?: 'Chưa phân chi nhánh' }}
                            </td>

                            <td>
                                <span class="pa-badge {{ $item->status_class }}">
                                    {{ $item->status_label }}
                                </span>
                            </td>

                            <td>{{ $item->created_at_format }}</td>

                            <td>
                                <a href="{{ route('catalog_v1.prescription_request_v1.show', $item->id) }}" class="pa-btn pa-btn-sm pa-btn-primary">
                                    Chi tiết
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="pa-empty">Chưa có yêu cầu mua thuốc phù hợp.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
            <div class="pa-pagination">
                {{ $requests->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('style')
<style>
    .pa-admin-prescription-page{
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

    .pa-stats-grid{
        display:grid;
        grid-template-columns:repeat(4,minmax(0,1fr));
        gap:16px;
        margin-bottom:20px;
    }

    .pa-stat-card{
        background:#fff;
        border-radius:18px;
        padding:18px;
        border:1px solid #edf2f7;
        box-shadow:0 10px 24px rgba(15,23,42,.05);
    }

    .pa-stat-label{
        font-size:13px;
        color:#64748b;
        margin-bottom:10px;
        font-weight:700;
    }

    .pa-stat-value{
        font-size:30px;
        line-height:1;
        font-weight:900;
        color:#0f172a;
    }

    .pa-stat-value.text-warning{color:#c2410c;}
    .pa-stat-value.text-info{color:#1d4ed8;}
    .pa-stat-value.text-success{color:#15803d;}

    .pa-admin-card{
        background:#fff;
        border-radius:20px;
        padding:18px;
        border:1px solid #edf2f7;
        box-shadow:0 10px 24px rgba(15,23,42,.05);
        margin-bottom:20px;
    }

    .pa-filter-grid{
        display:grid;
        grid-template-columns:repeat(4,minmax(0,1fr));
        gap:16px;
    }

    .pa-col-2{
        grid-column:span 2;
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
    .pa-form-group select{
        width:100%;
        min-height:42px;
        border:1px solid #dbe4f0;
        border-radius:12px;
        padding:0 12px;
        font-size:14px;
        color:#0f172a;
        background:#fff;
        outline:none;
    }

    .pa-form-group input:focus,
    .pa-form-group select:focus{
        border-color:#2563eb;
        box-shadow:0 0 0 3px rgba(37,99,235,.08);
    }

    .pa-filter-actions{
        display:flex;
        align-items:flex-end;
        gap:10px;
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

    .pa-btn-sm{
        min-height:36px;
        padding:0 12px;
        font-size:13px;
    }

    .pa-table-wrap{
        overflow:auto;
    }

    .pa-table{
        width:100%;
        border-collapse:collapse;
        min-width:1180px;
    }

    .pa-table th,
    .pa-table td{
        padding:14px 12px;
        border-bottom:1px solid #edf2f7;
        vertical-align:top;
        font-size:14px;
    }

    .pa-table th{
        background:#f8fafc;
        color:#334155;
        font-weight:800;
        white-space:nowrap;
    }

    .pa-subtext{
        font-size:12px;
        color:#64748b;
        margin-top:4px;
        line-height:1.5;
    }

    .pa-line-clamp-2,
    .pa-line-clamp-3{
        display:-webkit-box;
        -webkit-box-orient:vertical;
        overflow:hidden;
    }

    .pa-line-clamp-2{
        -webkit-line-clamp:2;
    }

    .pa-line-clamp-3{
        -webkit-line-clamp:3;
    }

    .pa-request-thumb{
        width:70px;
        height:70px;
        border-radius:14px;
        display:block;
        overflow:hidden;
        border:1px solid #e2e8f0;
        background:#fff;
    }

    .pa-request-thumb img{
        width:100%;
        height:100%;
        object-fit:cover;
    }

    .pa-no-image{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-height:30px;
        padding:0 10px;
        border-radius:999px;
        background:#f1f5f9;
        color:#64748b;
        font-size:12px;
        font-weight:700;
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

    .pa-empty{
        text-align:center;
        padding:28px 16px;
        color:#64748b;
        font-weight:700;
    }

    .pa-pagination{
        margin-top:18px;
        display:flex;
        justify-content:center;
    }

    .pa-pagination .pagination{
        margin-bottom:0;
    }

    @media(max-width:1200px){
        .pa-stats-grid{
            grid-template-columns:repeat(2,minmax(0,1fr));
        }

        .pa-filter-grid{
            grid-template-columns:repeat(2,minmax(0,1fr));
        }
    }

    @media(max-width:768px){
        .pa-admin-prescription-page{
            padding:14px;
        }

        .pa-filter-grid{
            grid-template-columns:1fr;
        }

        .pa-col-2{
            grid-column:span 1;
        }

        .pa-filter-actions{
            flex-direction:column;
            align-items:stretch;
        }
    }
</style>
@endsection

@section('script')
<script>
</script>
@endsection