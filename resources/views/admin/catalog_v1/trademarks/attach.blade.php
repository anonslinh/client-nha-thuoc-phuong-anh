@extends('Layout.index')
@section('content')
<div class="container-fluid">
  <div class="card card-body py-3">
    <div class="d-sm-flex align-items-center justify-space-between">
      <h4 class="mb-0 card-title">Thêm sản phẩm vào thương hiệu: {{ $trademark->name }}</h4>
      <div class="d-flex gap-2">
        <a href="{{ route('catalog_v1.trademarks.products',$trademark->id) }}" class="btn btn-primary">DS sản phẩm</a>
        <a href="{{ route('catalog_v1.trademarks.index') }}" class="btn btn-danger">Quay lại</a>
      </div>
    </div>
    @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{session('success')}}</div> @endif
    @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{session('error')}}</div> @endif
  </div>

  <div class="card">
    <div class="card-body">
      <form method="get" class="row" action="{{ route('catalog_v1.trademarks.attach.page',$trademark->id) }}">
        <div class="col-md-4 mb-2">
          <input name="key_search" class="form-control" placeholder="Tên, full name, code kiot..."
                 value="{{ request('key_search') }}">
        </div>
        <div class="col-md-4 mb-2">
          <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
          <a class="btn btn-danger" href="{{ route('catalog_v1.trademarks.attach.page',$trademark->id) }}">Hủy</a>
        </div>
      </form>

      <form method="post" action="{{ route('catalog_v1.trademarks.attach',$trademark->id) }}" id="attachForm">
        @csrf

        <div class="table-responsive mt-3">
          <table class="table table-bordered text-nowrap">
            <thead>
              <tr>
                <th class="text-center" style="width:60px"><input type="checkbox" id="checkAll"></th>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Kiot</th>
              </tr>
            </thead>
            <tbody>
            @if($listData->total() > 0)
              @foreach($listData as $p)
                @php
                  $img = $p->img_avatar;
                  $src = $img ? (\Illuminate\Support\Str::startsWith($img,'http') ? $img : asset($img)) : null;
                @endphp
                <tr>
                  <td class="text-center align-middle">
                    <input type="checkbox" class="rowCheck" name="product_ids[]" value="{{$p->id}}">
                  </td>
                  <td class="align-middle">
                    @if($src)
                      <img src="{{ $src }}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                    @else
                      <span class="text-muted">No image</span>
                    @endif
                  </td>
                  <td class="align-middle">
                    <h6 class="fw-semibold mb-1">{{ $p->name ?? '-' }}</h6>
                    <span class="text-muted">{{ $p->full_name ?? '' }}</span>
                  </td>
                  <td class="align-middle">{{ $p->price ? number_format($p->price).'đ' : '-' }}</td>
                  <td class="align-middle">
                    @if($p->id_product_kiotviet)
                      <span class="badge bg-info">Kiot ID: {{ $p->id_product_kiotviet }}</span><br>
                      <span class="text-muted">{{ $p->code_product_kiovet }}</span>
                    @else
                      <span class="badge bg-secondary">Thủ công</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            @else
              <tr><td colspan="5"><p class="m-0 text-danger text-center">Không có dữ liệu</p></td></tr>
            @endif
            </tbody>
          </table>
        </div>

        <button class="btn btn-primary">Thêm vào thương hiệu</button>
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
      $('.rowCheck').prop('checked', $(this).is(':checked'));
    });
    $('#attachForm').on('submit', function(e){
      if ($('.rowCheck:checked').length === 0) {
        e.preventDefault();
        alert('Vui lòng chọn ít nhất 1 sản phẩm.');
      }
    });
  });
</script>
@endsection