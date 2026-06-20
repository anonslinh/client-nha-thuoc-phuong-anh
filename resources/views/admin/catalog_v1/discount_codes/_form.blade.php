@php
    $isEdit = !empty($row);
@endphp

<div class="modal-header d-flex align-items-center">
    <h4 class="modal-title">{{ $isEdit ? 'Cập nhật mã giảm giá' : 'Thêm mã giảm giá' }}</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-6 mb-2">
            <label class="form-label">Loại</label>
            <select class="form-control" name="type" required>
                <option value="1" {{ $isEdit && $row->type == 1 ? 'selected' : '' }}>Voucher (chọn từ danh sách)</option>
                <option value="2" {{ $isEdit && $row->type == 2 ? 'selected' : '' }}>Mã giảm giá (khách tự nhập mã)</option>
            </select>
        </div>
        <div class="col-md-6 mb-2">
            <label class="form-label">Mã (không dấu, không khoảng trắng)</label>
            <input class="form-control" name="code" value="{{ $isEdit ? $row->code : '' }}" placeholder="VD: SALE10K" required>
        </div>
    </div>

    <div class="mb-2">
        <label class="form-label">Tên hiển thị cho khách</label>
        <input class="form-control" name="title" value="{{ $isEdit ? $row->title : '' }}" placeholder="VD: Giảm 10.000đ cho đơn từ 200.000đ" required>
    </div>

    <div class="mb-2">
        <label class="form-label">Mô tả thêm (tuỳ chọn)</label>
        <textarea class="form-control" name="description">{{ $isEdit ? $row->description : '' }}</textarea>
    </div>

    <div class="row">
        <div class="col-md-4 mb-2">
            <label class="form-label">Hình thức giảm</label>
            <select class="form-control" name="discount_type" required>
                <option value="1" {{ $isEdit && $row->discount_type == 1 ? 'selected' : '' }}>Theo % đơn hàng</option>
                <option value="2" {{ $isEdit && $row->discount_type == 2 ? 'selected' : '' }}>Số tiền cố định</option>
            </select>
        </div>
        <div class="col-md-4 mb-2">
            <label class="form-label">Giá trị giảm (% hoặc đ)</label>
            <input type="number" step="0.01" class="form-control" name="discount_value" value="{{ $isEdit ? $row->discount_value : '' }}" required>
        </div>
        <div class="col-md-4 mb-2">
            <label class="form-label">Giảm tối đa (đ, áp dụng khi chọn %)</label>
            <input type="number" class="form-control" name="max_discount_amount" value="{{ $isEdit ? $row->max_discount_amount : '' }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-2">
            <label class="form-label">Đơn hàng tối thiểu để áp dụng (đ)</label>
            <input type="number" class="form-control" name="min_order_amount" value="{{ $isEdit ? $row->min_order_amount : 0 }}">
        </div>
        <div class="col-md-6 mb-2">
            <label class="form-label">Số lượt sử dụng tối đa (để trống = không giới hạn)</label>
            <input type="number" class="form-control" name="quantity" value="{{ $isEdit ? $row->quantity : '' }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-2">
            <label class="form-label">Ngày bắt đầu (tuỳ chọn)</label>
            <input type="date" class="form-control" name="start_date"
                   value="{{ $isEdit && $row->start_date ? \Carbon\Carbon::parse($row->start_date)->format('Y-m-d') : '' }}">
        </div>
        <div class="col-md-6 mb-2">
            <label class="form-label">Ngày kết thúc (tuỳ chọn)</label>
            <input type="date" class="form-control" name="end_date"
                   value="{{ $isEdit && $row->end_date ? \Carbon\Carbon::parse($row->end_date)->format('Y-m-d') : '' }}">
        </div>
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ (!$isEdit || $row->is_active == 1) ? 'checked' : '' }}>
        <label class="form-check-label">Đang bật</label>
    </div>
</div>
