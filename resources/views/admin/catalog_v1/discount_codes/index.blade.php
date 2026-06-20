@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <h4 class="mb-0 card-title">Quản lý Voucher &amp; Mã giảm giá</h4>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCreate">
                <i class="ti ti-plus me-1"></i> Thêm mới
            </button>
        </div>
        <p class="text-muted mt-2 mb-0">
            <strong>Voucher</strong>: hiển thị trong danh sách "Voucher khả dụng" ở trang đặt hàng, khách chỉ cần chọn.
            <strong>Mã giảm giá</strong>: khách phải tự nhập mã ở trang đặt hàng để áp dụng.
        </p>
        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('catalog_v1.discount_code.index') }}" method="get" class="row">
                <div class="col-md-3 mb-2">
                    <input name="key_search" class="form-control" placeholder="Tìm theo mã, tên..." value="{{ request('key_search') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <select name="type" class="form-control">
                        <option value="">-- Tất cả loại --</option>
                        <option value="1" {{ request('type') == '1' ? 'selected' : '' }}>Voucher</option>
                        <option value="2" {{ request('type') == '2' ? 'selected' : '' }}>Mã giảm giá</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
                    <a href="{{ route('catalog_v1.discount_code.index') }}" class="btn btn-danger">Hủy</a>
                </div>
            </form>

            <div class="table-responsive mt-3">
                <table class="table table-bordered text-nowrap">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Loại</th>
                            <th>Mã</th>
                            <th>Tên hiển thị</th>
                            <th>Giá trị giảm</th>
                            <th>Đơn tối thiểu</th>
                            <th>Số lượt dùng</th>
                            <th>Hiệu lực</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($listData as $k => $row)
                        <tr>
                            <td class="align-middle">{{ $listData->firstItem() + $k }}</td>
                            <td class="align-middle">
                                <span class="badge {{ $row->type == 1 ? 'bg-primary' : 'bg-warning text-dark' }}">
                                    {{ $row->type == 1 ? 'Voucher' : 'Mã giảm giá' }}
                                </span>
                            </td>
                            <td class="align-middle"><b>{{ $row->code }}</b></td>
                            <td class="align-middle">{{ $row->title }}</td>
                            <td class="align-middle">
                                @if($row->discount_type == 1)
                                    {{ (float) $row->discount_value }}%
                                    @if($row->max_discount_amount)
                                        <div class="small text-muted">Tối đa {{ number_format($row->max_discount_amount, 0, ',', '.') }}đ</div>
                                    @endif
                                @else
                                    {{ number_format($row->discount_value, 0, ',', '.') }}đ
                                @endif
                            </td>
                            <td class="align-middle">{{ number_format($row->min_order_amount, 0, ',', '.') }}đ</td>
                            <td class="align-middle">
                                {{ $row->used_count }}/{{ $row->quantity ?? '∞' }}
                            </td>
                            <td class="align-middle">
                                @if($row->start_date || $row->end_date)
                                    <div class="small">
                                        {{ $row->start_date ? \Carbon\Carbon::parse($row->start_date)->format('d/m/Y') : '...' }}
                                        -
                                        {{ $row->end_date ? \Carbon\Carbon::parse($row->end_date)->format('d/m/Y') : '...' }}
                                    </div>
                                @else
                                    <span class="text-muted">Không giới hạn</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <span class="badge {{ $row->is_active == 1 ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $row->is_active == 1 ? 'Đang bật' : 'Tắt' }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <button class="btn btn-success btn-sm" style="margin-right:8px"
                                        data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $row->id }}">Sửa</button>

                                <a class="btn btn-danger btn-sm btn-sa-confirm"
                                   href="{{ route('catalog_v1.discount_code.destroy', $row->id) }}">Xóa</a>

                                <div class="modal fade" id="modalUpdate{{ $row->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <form action="{{ route('catalog_v1.discount_code.update', $row->id) }}" method="post" class="modal-content">
                                            @csrf
                                            @include('admin.catalog_v1.discount_codes._form', ['row' => $row])
                                            <div class="modal-footer">
                                                <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Hủy</button>
                                                <button class="btn btn-primary">Xác nhận</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="text-danger text-center">Không có dữ liệu</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $listData->appends(request()->all())->links('pagination') }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form action="{{ route('catalog_v1.discount_code.store') }}" method="post" class="modal-content">
            @csrf
            @include('admin.catalog_v1.discount_codes._form', ['row' => null])
            <div class="modal-footer">
                <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Hủy</button>
                <button class="btn btn-primary">Tạo</button>
            </div>
        </form>
    </div>
</div>
@endsection
