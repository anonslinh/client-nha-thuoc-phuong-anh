@extends('Layout.index')
@section('content')
<div class="container-fluid">
  <div class="card card-body py-3">
    <div class="d-sm-flex align-items-center justify-space-between">
      <h4 class="mb-0 card-title">Từ khóa tìm kiếm</h4>
      <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCreate">
        <i class="ti ti-plus me-1"></i> Thêm mới
      </button>
    </div>
    @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{session('success')}}</div> @endif
    @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{session('error')}}</div> @endif
  </div>

  <div class="card">
    <div class="card-body">

      <form action="{{ route('catalog_v1.search_keywords.index') }}" method="get" class="row">
        <div class="col-md-4 mb-2">
          <input name="key_search" class="form-control" placeholder="Tìm theo từ khóa..."
                 value="{{ request('key_search') }}">
        </div>
        <div class="col-md-4 mb-2">
          <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
          <a href="{{ route('catalog_v1.search_keywords.index') }}" class="btn btn-danger">Hủy</a>
        </div>
      </form>

      <div class="table-responsive mt-3">
        <table class="table table-bordered text-nowrap">
          <thead>
            <tr>
              <th>STT</th>
              <th>Từ khóa</th>
              <th>Key liên quan</th>
              <th>Type</th>
              <th>Sort</th>
              <th>SP ưu tiên</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
          @if($listData->total() > 0)
            @foreach($listData as $k => $row)
              @php
                $rels = $row->related_keywords ?? [];
                $relsText = is_array($rels) ? implode(', ', array_slice($rels,0,5)) : '';
                $cnt = $countMap[$row->id] ?? 0;
              @endphp
              <tr>
                <td class="align-middle">{{ $k+1 }}</td>
                <td class="align-middle">
                  <b>{{ $row->key_search }}</b>
                </td>
                <td class="align-middle">
                  @if(is_array($rels) && count($rels)>0)
                    <span class="text-muted">{{ $relsText }}@if(count($rels)>5) ... @endif</span>
                    <div class="small text-primary">({{ count($rels) }} key)</div>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td class="align-middle">
                  <span class="badge {{ $row->type==1?'bg-success':'bg-danger' }}">{{ $row->type==1?'Hiện':'Ẩn' }}</span>
                </td>
                <td class="align-middle">{{ $row->sort_order }}</td>
                <td class="align-middle">
                  <span class="badge bg-primary">{{ $cnt }}</span>
                </td>
                <td class="align-middle">
                  <a class="btn btn-primary btn-sm" style="margin-right:8px"
                     href="{{ route('catalog_v1.search_keywords.products',$row->id) }}">Sản phẩm ưu tiên</a>

                  <button class="btn btn-success btn-sm" style="margin-right:8px"
                          data-bs-toggle="modal" data-bs-target="#modalUpdate{{$row->id}}">Sửa</button>

                  <a class="btn btn-danger btn-sm btn-sa-confirm" href="{{ route('catalog_v1.search_keywords.destroy',$row->id) }}">Xóa</a>

                  {{-- Modal update --}}
                  <div class="modal fade" id="modalUpdate{{$row->id}}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <form action="{{ route('catalog_v1.search_keywords.update',$row->id) }}" method="post" class="modal-content">
                        @csrf
                        <div class="modal-header d-flex align-items-center">
                          <h4 class="modal-title">Cập nhật từ khóa</h4>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-2">
                            <label class="form-label">Từ khóa chính</label>
                            <input class="form-control" name="key_search" value="{{ $row->key_search }}" required>
                          </div>
                          <div class="mb-2">
                            <label class="form-label">Key liên quan (mỗi dòng 1 key hoặc phân tách bằng dấu phẩy)</label>
                            <textarea class="form-control" name="related_keywords" style="height:160px"
                            >{{ is_array($rels) ? implode("\n",$rels) : '' }}</textarea>
                          </div>
                          <div class="row">
                            <div class="col-md-6 mb-2">
                              <label class="form-label">Type</label>
                              <select class="form-control" name="type">
                                <option value="1" {{ $row->type==1?'selected':'' }}>Hiện</option>
                                <option value="0" {{ $row->type==0?'selected':'' }}>Ẩn</option>
                              </select>
                            </div>
                            <div class="col-md-6 mb-2">
                              <label class="form-label">Sort order</label>
                              <input class="form-control" name="sort_order" value="{{ $row->sort_order }}" required>
                            </div>
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
            <tr><td colspan="7" class="text-danger text-center">Không có dữ liệu</td></tr>
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

{{-- Modal create --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <form action="{{ route('catalog_v1.search_keywords.store') }}" method="post" class="modal-content">
      @csrf
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title">Thêm từ khóa</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label class="form-label">Từ khóa chính</label>
          <input class="form-control" name="key_search" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Key liên quan (mỗi dòng 1 key hoặc phân tách bằng dấu phẩy)</label>
          <textarea class="form-control" name="related_keywords" style="height:160px"
                    placeholder="omega3 nutreral&#10;omega3 pháp&#10;omega3 đức"></textarea>
        </div>
        <div class="row">
          <div class="col-md-6 mb-2">
            <label class="form-label">Type</label>
            <select class="form-control" name="type">
              <option value="1" selected>Hiện</option>
              <option value="0">Ẩn</option>
            </select>
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">Sort order</label>
            <input class="form-control" name="sort_order" value="0" required>
          </div>
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