@extends('Layout.index')
@section('content')
<div class="container-fluid">
  <div class="card card-body py-3">
    <div class="d-sm-flex align-items-center justify-space-between">
      <h4 class="card-title mb-0">Thêm sản phẩm từ KiotViet</h4>
      <a href="{{ route('catalog_v1.products.index') }}" class="btn btn-danger">Quay lại</a>
    </div>
    @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{session('success')}}</div> @endif
    @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{session('error')}}</div> @endif
  </div>

  <div class="card">
    <div class="card-body">

      <form method="get" action="{{ route('catalog_v1.products.kiotviet') }}" class="row">

        <div class="col-md-3 mb-2">
          <label class="form-label">Account KiotViet</label>
          <select name="account_code" class="form-control">
            @foreach($accounts as $acc)
              <option value="{{ $acc->code }}" {{ $account_code == $acc->code ? 'selected' : '' }}>
                {{ $acc->code }} ({{ $acc->retailer }})
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3 mb-2">
          <label class="form-label">Danh mục (Kiot)</label>
          <select name="categoryId" class="form-control">
            <option value="">-- Tất cả --</option>
            @foreach($categories as $c)
              @php
                $cid = $c['categoryId'] ?? null;
                $cname = $c['categoryName'] ?? $cid;
              @endphp
              @if($cid)
                <option value="{{ $cid }}" {{ (string)request('categoryId') === (string)$cid ? 'selected':'' }}>
                  {{ $cname }}
                </option>
              @endif
            @endforeach
          </select>
        </div>

        <div class="col-md-3 mb-2">
          <label class="form-label">Thương hiệu (Kiot)</label>
          <select name="tradeMarkId" class="form-control">
            <option value="">-- Tất cả --</option>
            @foreach($trademarks as $t)
              @php
                $tid = $t['tradeMarkId'] ?? ($t['id'] ?? null);
                $tname = $t['name'] ?? ($t['tradeMarkName'] ?? $tid);
              @endphp
              @if($tid)
                <option value="{{ $tid }}" {{ (string)request('tradeMarkId') === (string)$tid ? 'selected':'' }}>
                  {{ $tname }}
                </option>
              @endif
            @endforeach
          </select>
        </div>

        <div class="col-md-3 mb-2">
          <label class="form-label">Trạng thái đồng bộ</label>
          <select name="sync_status" class="form-control">
            <option value="unsynced" {{ $sync_status=='unsynced'?'selected':'' }}>Chưa đồng bộ</option>
            <option value="synced" {{ $sync_status=='synced'?'selected':'' }}>Đã đồng bộ</option>
            <option value="all" {{ $sync_status=='all'?'selected':'' }}>Tất cả</option>
          </select>
        </div>

        <div class="col-md-3 mb-2">
          <label class="form-label">Tên sản phẩm</label>
          <input name="name" class="form-control" value="{{ request('name') }}" placeholder="Nhập tên...">
        </div>

        <div class="col-md-12 mb-2">
          <button class="btn btn-primary" style="margin-right:10px">Lọc</button>
          <a href="{{ route('catalog_v1.products.kiotviet', ['account_code' => $account_code]) }}" class="btn btn-danger">Hủy</a>
        </div>
      </form>

      <form method="post" action="{{ route('catalog_v1.products.kiotviet.import') }}" id="importForm">
        @csrf
        <input type="hidden" name="account_code" value="{{ $account_code }}">

        <div class="table-responsive mt-3">
          <table class="table table-bordered text-nowrap">
            <thead>
              <tr>
                <th style="width:60px" class="text-center"><input type="checkbox" id="checkAll"></th>
                <th style="width:90px">Ảnh</th>
                <th>Mã</th>
                <th>Tên</th>
                <th>Danh mục</th>
                <th>Thương hiệu</th>
                <th>Giá</th>
                <th>Đồng bộ</th>
              </tr>
            </thead>
            <tbody>
            @if($listData->total() > 0)
              @foreach($listData as $p)
                @php
                  $synced = $p['_synced'] ?? false;
                  $img = null;
                  if (!empty($p['images']) && is_array($p['images']) && isset($p['images'][0])) $img = $p['images'][0];
                @endphp
                <tr class="{{ $synced ? 'table-secondary' : '' }}">
                  <td class="text-center align-middle">
                    <input type="checkbox" class="rowCheck" name="kiot_ids[]" value="{{ $p['id'] ?? '' }}"
                           {{ $synced ? 'disabled' : '' }}>
                  </td>
                  <td class="align-middle">
                    @if($img)
                      <img src="{{ $img }}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                    @else
                      <span class="text-muted">No image</span>
                    @endif
                  </td>
                  <td class="align-middle">{{ $p['code'] ?? '-' }}</td>
                  <td class="align-middle">
                    <h6 class="fw-semibold mb-1">{{ $p['fullName'] ?? $p['name'] ?? '-' }}</h6>
                    <span class="text-muted">Kiot ID: {{ $p['id'] ?? '-' }}</span>
                  </td>
                  <td class="align-middle">{{ $p['categoryName'] ?? '-' }}</td>
                  <td class="align-middle">{{ $p['tradeMarkName'] ?? '-' }}</td>
                  <td class="align-middle">{{ !empty($p['basePrice']) ? number_format($p['basePrice']).'đ' : '-' }}</td>
                  <td class="align-middle">
                    @if($synced)
                      <span class="badge bg-secondary">Đã đồng bộ</span>
                    @else
                      <span class="badge bg-info">Chưa đồng bộ</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            @else
              <tr><td colspan="8"><p class="m-0 text-danger text-center">Không có dữ liệu</p></td></tr>
            @endif
            </tbody>
          </table>
        </div>

        <button class="btn btn-primary">
          <i class="ti ti-download me-1"></i> Thêm vào product_v1
        </button>
      </form>

      <div class="d-flex justify-content-center mt-3">
        {{ $listData->appends(request()->all())->links('pagination') }}
      </div>

    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  $(function(){
    $('#checkAll').on('change', function(){
      $('.rowCheck:not(:disabled)').prop('checked', $(this).is(':checked'));
    });

    $('#importForm').on('submit', function(e){
      if ($('.rowCheck:checked').length === 0) {
        e.preventDefault();
        alert('Vui lòng chọn ít nhất 1 sản phẩm.');
      }
    });
  })
</script>
@endsection