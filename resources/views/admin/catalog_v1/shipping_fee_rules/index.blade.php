@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <h4 class="mb-0 card-title">Cấu hình phí vận chuyển</h4>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCreate">
                <i class="ti ti-plus me-1"></i> Thêm khoảng giá
            </button>
        </div>
        <p class="text-muted mt-2 mb-0">
            Phí ship được tính theo giá trị đơn hàng (tạm tính). Hệ thống sẽ tự chọn khoảng giá phù hợp nhất khi khách đặt hàng tại
            <code>/dat-hang</code>. Nhập phí = 0 để hiển thị "Miễn phí vận chuyển".
        </p>
        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Từ giá trị đơn hàng</th>
                            <th>Đến giá trị đơn hàng</th>
                            <th>Phí ship</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($listData as $k => $row)
                        <tr>
                            <td class="align-middle">{{ $k + 1 }}</td>
                            <td class="align-middle">{{ number_format($row->min_amount, 0, ',', '.') }}đ</td>
                            <td class="align-middle">
                                {{ $row->max_amount !== null ? number_format($row->max_amount, 0, ',', '.') . 'đ' : 'Trở lên' }}
                            </td>
                            <td class="align-middle">
                                @if((float) $row->fee <= 0)
                                    <span class="badge bg-success">Miễn phí ship</span>
                                @else
                                    {{ number_format($row->fee, 0, ',', '.') }}đ
                                @endif
                            </td>
                            <td class="align-middle">
                                <span class="badge {{ $row->is_active == 1 ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $row->is_active == 1 ? 'Đang áp dụng' : 'Tắt' }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <button class="btn btn-success btn-sm" style="margin-right:8px"
                                        data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $row->id }}">Sửa</button>

                                <a class="btn btn-danger btn-sm btn-sa-confirm"
                                   href="{{ route('catalog_v1.shipping_fee.destroy', $row->id) }}">Xóa</a>

                                <div class="modal fade" id="modalUpdate{{ $row->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form action="{{ route('catalog_v1.shipping_fee.update', $row->id) }}" method="post" class="modal-content">
                                            @csrf
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title">Cập nhật khoảng phí ship</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label">Từ giá trị đơn hàng (đ)</label>
                                                        <input type="number" class="form-control" name="min_amount" value="{{ $row->min_amount }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label">Đến giá trị đơn hàng (đ, để trống = không giới hạn)</label>
                                                        <input type="number" class="form-control" name="max_amount" value="{{ $row->max_amount }}">
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Phí ship (đ, nhập 0 = miễn phí ship)</label>
                                                    <input type="number" class="form-control" name="fee" value="{{ $row->fee }}" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Thứ tự sắp xếp</label>
                                                    <input type="number" class="form-control" name="sort_order" value="{{ $row->sort_order }}">
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $row->is_active == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label">Đang áp dụng</label>
                                                </div>
                                            </div>
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
                        <tr><td colspan="6" class="text-danger text-center">Chưa có khoảng phí ship nào, hãy thêm mới.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('catalog_v1.shipping_fee.store') }}" method="post" class="modal-content">
            @csrf
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title">Thêm khoảng phí ship</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Từ giá trị đơn hàng (đ)</label>
                        <input type="number" class="form-control" name="min_amount" value="0" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Đến giá trị đơn hàng (đ, để trống = không giới hạn)</label>
                        <input type="number" class="form-control" name="max_amount">
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label">Phí ship (đ, nhập 0 = miễn phí ship)</label>
                    <input type="number" class="form-control" name="fee" value="0" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Thứ tự sắp xếp</label>
                    <input type="number" class="form-control" name="sort_order" value="0">
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                    <label class="form-check-label">Đang áp dụng</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Hủy</button>
                <button class="btn btn-primary">Tạo</button>
            </div>
        </form>
    </div>
</div>
@endsection
