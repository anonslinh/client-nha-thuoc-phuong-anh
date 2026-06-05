@extends('Layout.index')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
@endsection

@section('content')
<div class="container-fluid">

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="card card-body py-3">
    <div class="d-sm-flex align-items-center justify-space-between">
      <h4 class="mb-4 mb-sm-0 card-title">Quản lý đặt phòng</h4>
      <nav aria-label="breadcrumb" class="ms-auto">
        <ol class="breadcrumb">
          <li class="breadcrumb-item" aria-current="page">
            <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center"
                    data-bs-toggle="modal" data-bs-target="#modalCreate">
              <i class="ti ti-send fs-4 me-2"></i>
              Thêm booking
            </button>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  {{-- Bộ lọc --}}
  <div class="card mb-3">
    <div class="card-body">
      <form class="row g-2" method="get" action="{{ route('booking.bookings.listData') }}">
        <div class="col-md-3">
          <input name="kw" class="form-control" value="{{ request('kw') }}" placeholder="Tìm mã booking / tên / sđt">
        </div>
        <div class="col-md-2">
          <select name="status" class="form-control">
            <option value="">-- Trạng thái --</option>
            <option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option>
            <option value="confirmed" {{ request('status')==='confirmed'?'selected':'' }}>Confirmed</option>
            <option value="checked_in" {{ request('status')==='checked_in'?'selected':'' }}>Checked-in</option>
            <option value="checked_out" {{ request('status')==='checked_out'?'selected':'' }}>Checked-out</option>
            <option value="cancelled" {{ request('status')==='cancelled'?'selected':'' }}>Cancelled</option>
            <option value="no_show" {{ request('status')==='no_show'?'selected':'' }}>No-show</option>
          </select>
        </div>
        <div class="col-md-2 d-grid">
          <button class="btn btn-primary">Lọc</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Bảng dữ liệu --}}
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap align-middle">
          <thead>
          <tr>
            <th style="width:60px">STT</th>
            <th>Mã</th>
            <th>Khách</th>
            <th>Ngày ở</th>
            <th>Phòng</th>
            <th>Trạng thái</th>
            <th>Thanh toán</th>
            <th style="width:220px">Thao tác</th>
          </tr>
          </thead>
          <tbody>
          @if($listData->total() > 0)
            @foreach($listData as $k => $b)
              <tr>
                <td>{{ ($listData->currentPage()-1)*$listData->perPage() + $k + 1 }}</td>
                <td><b>{{ $b->code }}</b></td>
                <td>
                  <div><b>{{ $b->customer_name }}</b></div>
                  <div class="text-muted">{{ $b->phone }}</div>
                </td>
                <td>
                  {{ optional($b->check_in_date)->format('d/m/Y') }}
                  →
                  {{ optional($b->check_out_date)->format('d/m/Y') }}
                </td>
                <td>
                  @foreach($b->bookingRooms as $br)
                    <span class="badge bg-light text-dark">{{ optional($br->room)->name ?? 'N/A' }}</span>
                  @endforeach
                </td>
                <td>
                  @php $st = $b->status; @endphp
                  @if($st==='pending') <span class="badge bg-warning text-dark">PENDING</span>
                  @elseif($st==='confirmed') <span class="badge bg-primary">CONFIRMED</span>
                  @elseif($st==='checked_in') <span class="badge bg-success">CHECKED-IN</span>
                  @elseif($st==='checked_out') <span class="badge bg-dark">CHECKED-OUT</span>
                  @elseif($st==='cancelled') <span class="badge bg-secondary">CANCELLED</span>
                  @elseif($st==='no_show') <span class="badge bg-danger">NO-SHOW</span>
                  @else <span class="badge bg-secondary">{{ strtoupper($st) }}</span>
                  @endif
                </td>
                <td>
                  <span class="badge bg-info">{{ strtoupper($b->payment_status) }}</span>
                </td>
                <td class="d-flex gap-2">
                  {{-- Update modal --}}
                  <div class="modal fade" id="modalUpdate{{ $b->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <form action="{{ route('booking.bookings.update', $b->id) }}" method="post" class="modal-content">
                        @csrf
                        <div class="modal-header">
                          <h4 class="modal-title">Cập nhật booking {{ $b->code }}</h4>
                          <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-2">
                            <label class="form-label">Tên khách</label>
                            <input class="form-control" name="customer_name" value="{{ $b->customer_name }}" required>
                          </div>
                          <div class="row">
                            <div class="col-md-6 mb-2">
                              <label class="form-label">SĐT</label>
                              <input class="form-control" name="phone" value="{{ $b->phone }}" required>
                            </div>
                            <div class="col-md-6 mb-2">
                              <label class="form-label">Email</label>
                              <input class="form-control" name="email" value="{{ $b->email }}">
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6 mb-2">
                              <label class="form-label">Người lớn</label>
                              <input class="form-control" type="number" name="adults" value="{{ $b->adults }}" min="1">
                            </div>
                            <div class="col-md-6 mb-2">
                              <label class="form-label">Trẻ em</label>
                              <input class="form-control" type="number" name="children" value="{{ $b->children }}" min="0">
                            </div>
                          </div>

                          <div class="mb-2">
                            <label class="form-label">Payment status</label>
                            <select name="payment_status" class="form-control">
                              <option value="unpaid" {{ $b->payment_status==='unpaid'?'selected':'' }}>UNPAID</option>
                              <option value="partial" {{ $b->payment_status==='partial'?'selected':'' }}>PARTIAL</option>
                              <option value="paid" {{ $b->payment_status==='paid'?'selected':'' }}>PAID</option>
                              <option value="refunded" {{ $b->payment_status==='refunded'?'selected':'' }}>REFUNDED</option>
                            </select>
                          </div>

                          <div class="mb-2">
                            <label class="form-label">Đổi status nhanh</label>
                            <select name="status" class="form-control">
                              <option value="">-- Giữ nguyên --</option>
                              <option value="checked_in">CHECKED-IN</option>
                              <option value="checked_out">CHECKED-OUT</option>
                              <option value="no_show">NO-SHOW</option>
                            </select>
                            <small class="text-muted d-block mt-1">Confirm/Cancel dùng nút riêng để cập nhật lịch ngày.</small>
                          </div>

                          <div class="mb-2">
                            <label class="form-label">Ghi chú</label>
                            <textarea class="form-control" name="note" rows="2">{{ $b->note }}</textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Hủy</button>
                          <button class="btn btn-primary">Xác nhận</button>
                        </div>
                      </form>
                    </div>
                  </div>

                  <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $b->id }}">Sửa</button>

                  @if($b->status === 'pending')
                    <form action="{{ route('booking.bookings.confirm', $b->id) }}" method="post">
                      @csrf
                      <button class="btn btn-primary" type="submit">Confirm</button>
                    </form>
                  @endif

                  @if(in_array($b->status, ['pending','confirmed']))
                    <form action="{{ route('booking.bookings.cancel', $b->id) }}" method="post">
                      @csrf
                      <button class="btn btn-warning" type="submit">Hủy</button>
                    </form>
                  @endif

                  <a href="{{ route('booking.bookings.delete', $b->id) }}" class="btn btn-danger btn-sa-confirm">Xóa</a>
                </td>
              </tr>
            @endforeach
          @else
            <tr><td colspan="8"><p class="m-0 text-danger text-center">Không có dữ liệu</p></td></tr>
          @endif
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-center">
        {{ $listData->appends(request()->all())->links('pagination') }}
      </div>
    </div>
  </div>
</div>

{{-- Modal tạo booking --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('booking.bookings.store') }}" method="post" class="modal-content">
      @csrf
      <div class="modal-header">
        <h4 class="modal-title">Thêm booking</h4>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-6 mb-2">
            <label class="form-label">Tên khách</label>
            <input class="form-control" name="customer_name" required>
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">SĐT</label>
            <input class="form-control" name="phone" required>
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label">Email</label>
          <input class="form-control" name="email">
        </div>

        <div class="row">
          <div class="col-md-6 mb-2">
            <label class="form-label">Check-in</label>
            <input type="date" class="form-control" name="check_in_date" required>
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">Check-out</label>
            <input type="date" class="form-control" name="check_out_date" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-2">
            <label class="form-label">Người lớn</label>
            <input type="number" class="form-control" name="adults" value="1" min="1">
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">Trẻ em</label>
            <input type="number" class="form-control" name="children" value="0" min="0">
          </div>
        </div>

        <div class="alert alert-info py-2">
          Hệ thống sẽ kiểm tra phòng trống theo <b>lịch ngày</b>. Nếu thiếu lịch, hệ thống tự tạo dòng <b>open</b> cho các ngày liên quan.
        </div>

        <div class="mb-2">
          <label class="form-label d-block">Chọn phòng</label>
          <select name="room_ids[]" class="form-control selectpicker" data-live-search="true" multiple required title="-- Chọn phòng --">
            @foreach($rooms as $r)
              <option value="{{ $r->id }}">{{ $r->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-2">
          <label class="form-label">Trạng thái tạo</label>
          <select name="status" class="form-control">
            <option value="pending" selected>Pending</option>
            <option value="confirmed">Confirmed (giữ lịch ngay)</option>
          </select>
        </div>

        <div class="mb-2">
          <label class="form-label">Ghi chú</label>
          <textarea class="form-control" name="note" rows="2"></textarea>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Hủy</button>
        <button class="btn btn-primary">Xác nhận</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script> $('.selectpicker').selectpicker(); </script>
@endsection
