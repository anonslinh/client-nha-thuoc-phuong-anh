@extends('Layout.index')
@section('content')
<div class="container-fluid">
  <div class="card card-body py-3">
    <div class="d-sm-flex align-items-center justify-space-between">
      <div>
        <h4 class="mb-1 card-title">Sản phẩm ưu tiên cho từ khóa: <span class="text-primary">{{ $keyword->key_search }}</span></h4>
        <div class="text-muted">Hiển thị trước khi tìm kiếm theo product_v1</div>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('catalog_v1.search_keywords.attach.page',$keyword->id) }}" class="btn btn-info">Thêm sản phẩm</a>
        <a href="{{ route('catalog_v1.search_keywords.index') }}" class="btn btn-danger">Quay lại</a>
      </div>
    </div>
    @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{session('success')}}</div> @endif
    @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{session('error')}}</div> @endif
  </div>

  <div class="card">
    <div class="card-body">

      <form method="post" action="{{ route('catalog_v1.search_keywords.detach',$keyword->id) }}" id="detachForm">
        @csrf

        <div class="table-responsive">
          <table class="table table-bordered text-nowrap">
            <thead>
              <tr>
                <th class="text-center" style="width:60px"><input type="checkbox" id="checkAll"></th>
                <th>Sản phẩm</th>
                <th>Sort</th>
                <th>Status</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              @if(count($maps) > 0)
                @foreach($maps as $m)
                  @php
                    $p = $productsMap[$m->product_id] ?? null;
                    $pname = $p?->name ?? $p?->full_name ?? ('#'.$m->product_id);
                    $img = $p?->img_avatar;
                    $src = $img ? (\Illuminate\Support\Str::startsWith($img,'http') ? $img : asset($img)) : null;
                  @endphp
                  <tr>
                    <td class="text-center align-middle">
                      <input type="checkbox" class="rowCheck" name="map_ids[]" value="{{ $m->id }}">
                    </td>
                    <td class="align-middle">
                      <div class="d-flex align-items-center gap-3">
                        @if($src)
                          <img src="{{ $src }}" style="width:52px;height:52px;border-radius:12px;object-fit:cover;">
                        @endif
                        <div>
                          <b>{{ $pname }}</b><br>
                          <span class="text-muted">Product ID: {{ $m->product_id }}</span>
                        </div>
                      </div>
                    </td>
                    <td class="align-middle">{{ $m->sort_order }}</td>
                    <td class="align-middle">
                      <span class="badge {{ $m->status==1?'bg-success':'bg-danger' }}">{{ $m->status==1?'ON':'OFF' }}</span>
                    </td>
                    <td class="align-middle">
                      <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$m->id}}">Sửa</button>

                      <div class="modal fade" id="modalUpdate{{$m->id}}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                          <form method="post" class="modal-content" action="{{ route('catalog_v1.search_keywords.product.update', [$keyword->id, $m->id]) }}">
                            @csrf
                            <div class="modal-header d-flex align-items-center">
                              <h4 class="modal-title">Cập nhật sản phẩm ưu tiên</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              <div class="mb-2">
                                <label class="form-label">Sort order</label>
                                <input class="form-control" name="sort_order" value="{{ $m->sort_order }}">
                              </div>
                              <div class="mb-2">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                  <option value="1" {{ $m->status==1?'selected':'' }}>1</option>
                                  <option value="0" {{ $m->status==0?'selected':'' }}>0</option>
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

                    </td>
                  </tr>
                @endforeach
              @else
                <tr><td colspan="5" class="text-danger text-center">Chưa cấu hình sản phẩm ưu tiên</td></tr>
              @endif
            </tbody>
          </table>
        </div>

        <button class="btn btn-danger">Gỡ khỏi danh sách ưu tiên</button>
      </form>

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
  $('#detachForm').on('submit', function(e){
    if($('.rowCheck:checked').length===0){
      e.preventDefault();
      alert('Vui lòng chọn ít nhất 1 sản phẩm để gỡ.');
    }
  });
});
</script>
@endsection