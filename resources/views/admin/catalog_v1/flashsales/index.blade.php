@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <h4 class="mb-0 card-title">Flash Sale - Tháng {{ $monthLabel }}</h4>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-primary" href="{{ route('catalog_v1.flashsales.index', ['month' => $prevMonth]) }}">Tháng trước</a>
                <a class="btn btn-outline-primary" href="{{ route('catalog_v1.flashsales.index', ['month' => $nextMonth]) }}">Tháng sau</a>
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCreate">Tạo khung giờ</button>
            </div>
        </div>
        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{session('success')}}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{session('error')}}</div> @endif
    </div>

    {{-- Calendar --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr class="text-center">
                            <th>T2</th><th>T3</th><th>T4</th><th>T5</th><th>T6</th><th>T7</th><th>CN</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($weeks as $week)
                        <tr>
                        @foreach($week as $day)
                            @php
                                $dateStr = $day->toDateString();
                                $inMonth = $day->format('Y-m') === $monthCarbon->format('Y-m');
                                $list = $byDate[$dateStr] ?? collect();
                            @endphp
                            <td style="min-width:160px; vertical-align:top" class="{{ $inMonth ? '' : 'table-secondary' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>{{ $day->format('d') }}</strong>
                                    <button type="button" class="btn btn-sm btn-outline-info btnCreateSlot"
                                            data-date="{{ $dateStr }}" data-bs-toggle="modal" data-bs-target="#modalCreate">
                                        +
                                    </button>
                                </div>

                                <div class="mt-2 d-flex flex-column gap-2">
                                    @foreach($list as $s)
                                        @php $cnt = $countMap[$s->id] ?? 0; @endphp
                                        <div class="p-2 border rounded">
                                            <div class="d-flex justify-content-between">
                                                <span class="badge bg-primary">{{ substr($s->start_time,0,5) }} - {{ substr($s->end_time,0,5) }}</span>
                                                <span class="badge {{ $s->status==1?'bg-success':'bg-danger' }}">{{ $s->status==1?'ON':'OFF' }}</span>
                                            </div>
                                            <div class="small text-muted mt-1">{{ $s->title }}</div>
                                            <div class="small mt-1">SP: <b>{{ $cnt }}</b></div>
                                            <div class="mt-2 d-flex gap-1">
                                                <a class="btn btn-sm btn-primary" href="{{ route('catalog_v1.flashsales.items',$s->id) }}">Sản phẩm</a>
                                                <button class="btn btn-sm btn-success"
                                                        data-bs-toggle="modal" data-bs-target="#modalUpdate{{$s->id}}">
                                                    Sửa
                                                </button>
                                                <a class="btn btn-sm btn-danger btn-sa-confirm"
                                                   href="{{ route('catalog_v1.flashsales.destroy',$s->id) }}">
                                                    Xóa
                                                </a>
                                            </div>
                                        </div>

                                        {{-- Modal update --}}
                                        <div class="modal fade" id="modalUpdate{{$s->id}}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <form action="{{ route('catalog_v1.flashsales.update',$s->id) }}" method="post" class="modal-content">
                                                    @csrf
                                                    <div class="modal-header d-flex align-items-center">
                                                        <h4 class="modal-title">Cập nhật Flash Sale</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-2">
                                                                <label class="form-label">Ngày</label>
                                                                <input type="date" class="form-control" name="sale_date" value="{{ $s->sale_date }}" required>
                                                            </div>
                                                            <div class="col-md-3 mb-2">
                                                                <label class="form-label">Bắt đầu</label>
                                                                <input type="time" class="form-control" name="start_time" value="{{ substr($s->start_time,0,5) }}" required>
                                                            </div>
                                                            <div class="col-md-3 mb-2">
                                                                <label class="form-label">Kết thúc</label>
                                                                <input type="time" class="form-control" name="end_time" value="{{ substr($s->end_time,0,5) }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label">Tiêu đề</label>
                                                            <input class="form-control" name="title" value="{{ $s->title }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label">Status</label>
                                                            <select class="form-control" name="status">
                                                                <option value="1" {{ $s->status==1?'selected':'' }}>1</option>
                                                                <option value="0" {{ $s->status==0?'selected':'' }}>0</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Hủy</button>
                                                        <button class="btn btn-primary">Xác nhận</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- List sessions (table) --}}
            <hr>
            <h5 class="mb-3">Danh sách khung giờ trong tháng</h5>
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap">
                    <thead>
                        <tr>
                            <th>Ngày</th>
                            <th>Khung giờ</th>
                            <th>Tiêu đề</th>
                            <th>Status</th>
                            <th>Sản phẩm</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sessions as $s)
                            @php $cnt = $countMap[$s->id] ?? 0; @endphp
                            <tr>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($s->sale_date)->format('d/m/Y') }}</td>
                                <td class="align-middle">{{ substr($s->start_time,0,5) }} - {{ substr($s->end_time,0,5) }}</td>
                                <td class="align-middle">{{ $s->title }}</td>
                                <td class="align-middle">
                                    <span class="badge {{ $s->status==1?'bg-success':'bg-danger' }}">{{ $s->status==1?'ON':'OFF' }}</span>
                                </td>
                                <td class="align-middle"><span class="badge bg-primary">{{ $cnt }}</span></td>
                                <td class="align-middle">
                                    <a class="btn btn-sm btn-primary" href="{{ route('catalog_v1.flashsales.items',$s->id) }}">Sản phẩm</a>
                                    <a class="btn btn-sm btn-danger btn-sa-confirm" href="{{ route('catalog_v1.flashsales.destroy',$s->id) }}">Xóa</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-danger">Chưa có khung giờ</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- Modal create --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form action="{{ route('catalog_v1.flashsales.store') }}" method="post" class="modal-content">
            @csrf
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title">Tạo Flash Sale khung giờ</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Ngày</label>
                        <input type="date" class="form-control" id="create_sale_date" name="sale_date" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Bắt đầu</label>
                        <input type="time" class="form-control" name="start_time" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Kết thúc</label>
                        <input type="time" class="form-control" name="end_time" required>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label">Tiêu đề</label>
                    <input class="form-control" name="title" placeholder="VD: Flash sale tối">
                </div>
                <div class="mb-2">
                    <label class="form-label">Status</label>
                    <select class="form-control" name="status">
                        <option value="1" selected>1</option>
                        <option value="0">0</option>
                    </select>
                </div>
                <div class="small text-muted">Tip: click dấu “+” trong lịch để tự điền ngày.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Hủy</button>
                <button class="btn btn-primary">Tạo</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
  $(function(){
    // set default date = today when open create
    $('#modalCreate').on('show.bs.modal', function(){
      if(!$('#create_sale_date').val()){
        const d = new Date();
        const yyyy = d.getFullYear();
        const mm = String(d.getMonth()+1).padStart(2,'0');
        const dd = String(d.getDate()).padStart(2,'0');
        $('#create_sale_date').val(`${yyyy}-${mm}-${dd}`);
      }
    });

    // click "+" in calendar
    $('.btnCreateSlot').click(function(){
      const date = $(this).data('date');
      $('#create_sale_date').val(date);
    });
  });
</script>
@endsection