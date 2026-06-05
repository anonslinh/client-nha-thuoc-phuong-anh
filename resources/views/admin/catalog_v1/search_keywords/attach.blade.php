@extends('Layout.index')
@section('content')
<div class="container-fluid">
  <div class="card card-body py-3">
    <div class="d-sm-flex align-items-center justify-space-between">
      <h4 class="mb-0 card-title">Thêm sản phẩm ưu tiên cho: <span class="text-primary">{{ $keyword->key_search }}</span></h4>
      <div class="d-flex gap-2">
        <a href="{{ route('catalog_v1.search_keywords.products',$keyword->id) }}" class="btn btn-primary">DS ưu tiên</a>
        <a href="{{ route('catalog_v1.search_keywords.index') }}" class="btn btn-danger">Quay lại</a>
      </div>
    </div>
    @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{session('success')}}</div> @endif
    @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{session('error')}}</div> @endif
  </div>

  <div class="card">
    <div class="card-body">

      <form method="get" class="row" action="{{ route('catalog_v1.search_keywords.attach.page',$keyword->id) }}">
        <div class="col-md-4 mb-2">
          <input name="key_search" class="form-control" placeholder="Tên, full name, code kiot..."
                 value="{{ request('key_search') }}">
        </div>
        <div class="col-md-4 mb-2">
          <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
          <a class="btn btn-danger" href="{{ route('catalog_v1.search_keywords.attach.page',$keyword->id) }}">Hủy</a>
        </div>
      </form>

      <div class="row mb-2">
        <div class="col-md-3">
          <label class="form-label">Default sort</label>
          <input class="form-control" id="default_sort" placeholder="VD: 1">
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <button type="button" class="btn btn-outline-primary" id="applyDefault">Áp dụng sort cho dòng đã tick</button>
        </div>
      </div>

      <form method="post" action="{{ route('catalog_v1.search_keywords.attach',$keyword->id) }}" id="addForm">
        @csrf

        <div class="table-responsive mt-3">
          <table class="table table-bordered text-nowrap">
            <thead>
              <tr>
                <th class="text-center" style="width:60px"><input type="checkbox" id="checkAll"></th>
                <th>Sản phẩm</th>
                <th style="width:160px">Sort</th>
                <th>Đã có?</th>
              </tr>
            </thead>
            <tbody>
            @if($listData->total() > 0)
              @foreach($listData as $p)
                @php
                  $already = isset($existMap[$p->id]);
                  $img = $p->img_avatar;
                  $src = $img ? (\Illuminate\Support\Str::startsWith($img,'http') ? $img : asset($img)) : null;
                @endphp
                <tr class="{{ $already ? 'table-secondary' : '' }}">
                  <td class="text-center align-middle">
                    <input type="checkbox" class="rowCheck" name="product_ids[]" value="{{ $p->id }}" {{ $already?'disabled':'' }}>
                  </td>
                  <td class="align-middle">
                    <div class="d-flex align-items-center gap-3">
                      @if($src)
                        <img src="{{ $src }}" style="width:52px;height:52px;border-radius:12px;object-fit:cover;">
                      @endif
                      <div>
                        <b>{{ $p->name ?? '-' }}</b><br>
                        <span class="text-muted">{{ $p->full_name ?? '' }}</span>
                      </div>
                    </div>
                  </td>
                  <td class="align-middle">
                    <input class="form-control sortInput" name="items[{{ $p->id }}][sort_order]" placeholder="0" {{ $already?'disabled':'' }}>
                  </td>
                  <td class="align-middle">
                    @if($already)
                      <span class="badge bg-secondary">Đã có</span>
                    @else
                      <span class="badge bg-info">Chưa có</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            @else
              <tr><td colspan="4" class="text-danger text-center">Không có dữ liệu</td></tr>
            @endif
            </tbody>
          </table>
        </div>

        <button class="btn btn-primary">
          <i class="ti ti-download me-1"></i> Thêm vào ưu tiên
        </button>

        <div class="d-flex justify-content-center mt-3">
          {{ $listData->appends(request()->all())->links('pagination') }}
        </div>
      </form>

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

  $('#applyDefault').click(function(){
    const s = $('#default_sort').val();
    $('.rowCheck:checked').each(function(){
      const tr = $(this).closest('tr');
      if(s) tr.find('.sortInput').val(s);
    });
  });

  $('#addForm').on('submit', function(e){
    if($('.rowCheck:checked').length===0){
      e.preventDefault();
      alert('Vui lòng chọn ít nhất 1 sản phẩm.');
    }
  });
});
</script>
@endsection