@extends('Layout.index')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<style>
  .cal-grid { display:grid; grid-template-columns: repeat(7, 1fr); gap:8px; }
  .cal-cell { border:1px solid #e5e7eb; border-radius:12px; padding:10px; min-height:110px; cursor:pointer; }
  .cal-cell--muted { opacity: .45; background: #fafafa; cursor: default; }
  .cal-head { font-weight:600; text-align:center; padding:6px 0; }
  .cal-day { font-weight:700; }
  .cal-meta { font-size:12px; line-height:1.25rem; }
</style>
@endsection

@section('content')
<div class="container-fluid">

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

  <div class="card card-body py-3">
    <div class="d-sm-flex align-items-center justify-space-between">
      <h4 class="mb-0 card-title">Cấu hình lịch phòng (Theo tháng)</h4>
      <nav aria-label="breadcrumb" class="ms-auto">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <button class="badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center"
                    data-bs-toggle="modal" data-bs-target="#modalSeedMonth">
              <i class="ti ti-calendar fs-4 me-2"></i> Tạo lịch tháng
            </button>
          </li>
          <li class="breadcrumb-item">
            <button class="badge fw-medium fs-2 btn btn-rounded btn-warning d-flex align-items-center"
                    data-bs-toggle="modal" data-bs-target="#modalBulkUpdate">
              <i class="ti ti-edit fs-4 me-2"></i> Cập nhật hàng loạt
            </button>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  {{-- Filter --}}
  <div class="card mb-3">
    <div class="card-body">
      <form class="row g-2" method="get" action="{{ route('booking.calendar.listData') }}">
        <div class="col-md-2">
          <input type="month" name="month" class="form-control" value="{{ $month }}">
        </div>
        <div class="col-md-6">
          <select name="room_id" class="form-control selectpicker" data-live-search="true" title="-- Chọn loại phòng --">
            @foreach($rooms as $r)
              <option value="{{ $r->id }}" {{ (string)$roomId === (string)$r->id ? 'selected' : '' }}>
                {{ $r->name }} (SL: {{ $r->number_rooms ?? 0 }})
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2 d-grid">
          <button class="btn btn-primary">Xem lịch</button>
        </div>
      </form>
    </div>
  </div>

  @php
    $cursor = $startGrid->copy();
    $monthFirst = \Carbon\Carbon::createFromFormat('Y-m', $month)->startOfMonth();
    $monthLast  = \Carbon\Carbon::createFromFormat('Y-m', $month)->endOfMonth();
    $weekdays = ['T2','T3','T4','T5','T6','T7','CN'];
  @endphp

  {{-- Week header --}}
  <div class="cal-grid mb-2">
    @foreach($weekdays as $w)
      <div class="cal-head">{{ $w }}</div>
    @endforeach
  </div>

  {{-- Calendar grid --}}
  <div class="cal-grid">
    @while($cursor->lte($endGrid))
      @php
        $dateStr = $cursor->toDateString();
        $inMonth = $cursor->betweenIncluded($monthFirst, $monthLast);
        $row = $items->get($dateStr);

        $status = $row->status ?? 'open';
        $total  = (int)($row->total_qty ?? 0);
        $booked = (int)($row->booked_qty ?? 0);
        $hold   = (int)($row->hold_qty ?? 0);
        $remain = max($total - $booked - $hold, 0);

        $badge = 'bg-success';
        if ($status === 'closed') $badge = 'bg-dark';
        if ($status === 'maintenance') $badge = 'bg-warning text-dark';
        if ($inMonth && $remain <= 0 && $status === 'open') $badge = 'bg-danger';
      @endphp

      <div class="cal-cell {{ !$inMonth ? 'cal-cell--muted' : '' }}"
           @if($inMonth && $row)
              data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $row->id }}"
           @endif
      >
        <div class="d-flex justify-content-between align-items-center">
          <div class="cal-day">{{ $cursor->day }}</div>
          @if($inMonth)
            <span class="badge {{ $badge }}">
              @if($status==='open')
                {{ $remain<=0 ? 'FULL' : 'OPEN' }}
              @elseif($status==='closed') CLOSED
              @elseif($status==='maintenance') MAINT
              @else {{ strtoupper($status) }}
              @endif
            </span>
          @endif
        </div>

        @if($inMonth)
          <div class="cal-meta mt-2">
            <div><b>Đã đặt:</b> {{ $booked }}</div>
            <div><b>Trống:</b> {{ $remain }}</div>
            <div><b>Tổng:</b> {{ $total }}</div>
            @if($row && $row->price)
              <div class="text-muted"><b>Giá:</b> {{ number_format($row->price) }}</div>
            @endif
          </div>

          @if(!$row)
            <div class="text-danger mt-2" style="font-size:12px;">Chưa seed lịch</div>
          @endif
        @endif
      </div>

      {{-- Modal update từng ngày --}}
      @if($inMonth && $row)
        <div class="modal fade" id="modalUpdate{{ $row->id }}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('booking.calendar.update', $row->id) }}" method="post" class="modal-content">
              @csrf
              <div class="modal-header">
                <h4 class="modal-title">
                  {{ optional($roomSelected)->name ?? 'Phòng' }} — {{ $row->date->format('d/m/Y') }}
                </h4>
                <button class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-2">
                  <label class="form-label">Trạng thái</label>
                  <select name="status" class="form-control">
                    <option value="open" {{ $row->status==='open'?'selected':'' }}>Open</option>
                    <option value="closed" {{ $row->status==='closed'?'selected':'' }}>Closed</option>
                    <option value="maintenance" {{ $row->status==='maintenance'?'selected':'' }}>Maintenance</option>
                  </select>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-2">
                    <label class="form-label">Tổng phòng bán (total_qty)</label>
                    <input type="number" min="0" class="form-control" name="total_qty" value="{{ $row->total_qty }}">
                    <small class="text-muted d-block mt-1">Không được nhỏ hơn <b>booked_qty={{ $row->booked_qty }}</b></small>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label class="form-label">Giá theo ngày</label>
                    <input class="form-control" name="price" value="{{ $row->price }}">
                  </div>
                </div>

                <div class="mb-2">
                  <label class="form-label">Ghi chú</label>
                  <input class="form-control" name="note" value="{{ $row->note }}">
                </div>

                <div class="alert alert-info py-2">
                  <b>Booked:</b> {{ $row->booked_qty }} • <b>Hold:</b> {{ $row->hold_qty }} •
                  <b>Trống:</b> {{ max($row->total_qty - $row->booked_qty - $row->hold_qty, 0) }}
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Hủy</button>
                <button class="btn btn-primary">Xác nhận</button>
              </div>
            </form>
          </div>
        </div>
      @endif

      @php $cursor->addDay(); @endphp
    @endwhile
  </div>
</div>

{{-- Modal seed month --}}
<div class="modal fade" id="modalSeedMonth" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('booking.calendar.seedMonth') }}" method="post" class="modal-content">
      @csrf
      <div class="modal-header">
        <h4 class="modal-title">Tạo lịch tháng</h4>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info py-2">
          Seed lịch theo tháng + tự set <b>total_qty = rooms.number_rooms</b>.
        </div>

        <div class="mb-2">
          <label class="form-label">Tháng</label>
          <input type="month" name="month" class="form-control" value="{{ $month }}" required>
        </div>

        <div class="mb-2">
          <label class="form-label">Loại phòng (để trống = tất cả)</label>
          <select name="room_id" class="form-control selectpicker" data-live-search="true" title="-- Tất cả --">
            @foreach($rooms as $r)
              <option value="{{ $r->id }}">{{ $r->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Hủy</button>
        <button class="btn btn-primary">Tạo</button>
      </div>
    </form>
  </div>
</div>

{{-- Modal bulk update --}}
<div class="modal fade" id="modalBulkUpdate" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('booking.calendar.bulkUpdate') }}" method="post" class="modal-content">
      @csrf
      <div class="modal-header">
        <h4 class="modal-title">Cập nhật hàng loạt</h4>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label class="form-label">Loại phòng (để trống = tất cả)</label>
          <select name="room_id" class="form-control selectpicker" data-live-search="true" title="-- Tất cả --">
            @foreach($rooms as $r)
              <option value="{{ $r->id }}">{{ $r->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="row">
          <div class="col-md-6 mb-2">
            <label class="form-label">Từ ngày</label>
            <input type="date" name="date_from" class="form-control" required>
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">Đến ngày</label>
            <input type="date" name="date_to" class="form-control" required>
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label">Trạng thái</label>
          <select name="status" class="form-control">
            <option value="">-- Không đổi --</option>
            <option value="open">Open</option>
            <option value="closed">Closed</option>
            <option value="maintenance">Maintenance</option>
          </select>
        </div>

        <div class="mb-2">
          <label class="form-label">Giá</label>
          <input name="price" class="form-control" placeholder="Để trống nếu không đổi">
        </div>

        <div class="mb-2">
          <label class="form-label">Tổng phòng bán (total_qty)</label>
          <input name="total_qty" class="form-control" type="number" min="0" placeholder="Để trống nếu không đổi">
        </div>

        <div class="mb-2">
          <label class="form-label">Ghi chú</label>
          <input name="note" class="form-control" placeholder="Tuỳ chọn">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Hủy</button>
        <button class="btn btn-primary">Cập nhật</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script> $('.selectpicker').selectpicker(); </script>
@endsection
