@extends('Layout.index')
@section('content')
<div class="container-fluid">
  <div class="card card-body py-3">
    <div class="d-sm-flex align-items-center justify-space-between">
      <h4 class="mb-0 card-title">Thương hiệu (trademark_v1)</h4>
      <nav aria-label="breadcrumb" class="ms-auto">
        <ol class="breadcrumb">
          <li class="breadcrumb-item" aria-current="page">
            <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center"
                    data-bs-toggle="modal" data-bs-target="#modalCreate">
              <i class="ti ti-send fs-4 me-2"></i> Thêm mới
            </button>
          </li>
        </ol>
      </nav>
    </div>
    @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{session('success')}}</div> @endif
    @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{session('error')}}</div> @endif
  </div>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('catalog_v1.trademarks.index') }}" method="get" class="row">
        <div class="col-md-4 mb-2">
          <input name="key_search" class="form-control" placeholder="Tìm theo tên thương hiệu..."
                 value="{{ request('key_search') }}">
        </div>
        <div class="col-md-4 mb-2">
          <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
          <a href="{{ route('catalog_v1.trademarks.index') }}" class="btn btn-danger">Hủy</a>
        </div>
      </form>

      <div class="table-responsive mt-4">
        <table class="table table-bordered text-nowrap">
          <thead>
            <tr>
              <th>STT</th>
              <th>Thương hiệu</th>
              <th>Sort</th>
              <th>Status</th>
              <th>Sản phẩm</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
          @if($listData->total() > 0)
            @foreach($listData as $k => $t)
              @php
                $img = $t->img;
                $src = $img ? (\Illuminate\Support\Str::startsWith($img,'http') ? $img : asset($img)) : null;
                $count = $t->products_count ?? 0;
              @endphp
              <tr>
                <td class="align-middle">{{ $k+1 }}</td>
                <td class="align-middle">
                  <div class="d-flex align-items-center gap-3">
                    @if($src)
                      <img src="{{ $src }}" style="width:40px;height:40px;border-radius:10px;object-fit:cover;">
                    @endif
                    <div>
                      <h6 class="fw-semibold mb-1">{{ $t->name ?? '-' }}</h6>
                      <span class="text-muted">{{ $t->description ?? '' }}</span>
                    </div>
                  </div>
                </td>
                <td class="align-middle">{{ $t->sort_order }}</td>
                <td class="align-middle">
                  @if($t->status == 1) <span class="badge bg-success">1</span> @else <span class="badge bg-danger">0</span> @endif
                </td>
                <td class="align-middle">
                  <span class="badge bg-primary">{{ $count }}</span>
                </td>
                <td class="align-middle">
                  <a class="btn btn-info" style="margin-right:10px"
                     href="{{ route('catalog_v1.trademarks.attach.page',$t->id) }}">Thêm sản phẩm</a>

                  <a class="btn btn-primary" style="margin-right:10px"
                     href="{{ route('catalog_v1.trademarks.products',$t->id) }}">DS sản phẩm</a>

                  <button class="btn btn-success" style="margin-right:10px"
                          data-bs-toggle="modal" data-bs-target="#modalUpdate{{$t->id}}">Sửa</button>

                  <a href="{{ route('catalog_v1.trademarks.destroy',$t->id) }}" class="btn btn-danger btn-sa-confirm">Xóa</a>

                  {{-- Modal update --}}
                  <div class="modal fade" id="modalUpdate{{$t->id}}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <form action="{{ route('catalog_v1.trademarks.update',$t->id) }}" method="post" class="modal-content" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header d-flex align-items-center">
                          <h4 class="modal-title">Cập nhật thương hiệu</h4>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-2">
                            <label class="form-label">Tên</label>
                            <input class="form-control" name="name" value="{{$t->name}}">
                          </div>
                          <div class="mb-2">
                            <label class="form-label">Mô tả</label>
                            <textarea class="form-control" name="description" style="height:120px">{{$t->description}}</textarea>
                          </div>
                          <div class="mb-2">
                            <label class="form-label">Note (CKEditor)</label>
                            <textarea class="form-control" name="note" style="height:140px">{{$t->note}}</textarea>
                          </div>

                          <div class="mb-2">
                            <label class="form-label">Logo (upload hoặc nhập link)</label>
                            <input type="file" class="form-control mb-2" name="img">
                            <input class="form-control" name="img" value="{{$t->img}}" placeholder="Hoặc dán link/path">
                          </div>

                          <div class="mb-2">
                            <label class="form-label">Banner (upload hoặc nhập link)</label>
                            <input type="file" class="form-control mb-2" name="banner">
                            <input class="form-control" name="banner" value="{{$t->banner}}" placeholder="Hoặc dán link/path">
                          </div>

                          <div class="row">
                            <div class="col-md-6 mb-2">
                              <label class="form-label">Sort order</label>
                              <input class="form-control" name="sort_order" value="{{$t->sort_order}}" required>
                            </div>
                            <div class="col-md-6 mb-2">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                <option value="1" {{ $t->status==1?'selected':'' }}>1</option>
                                <option value="0" {{ $t->status==0?'selected':'' }}>0</option>
                              </select>
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
            <tr><td colspan="6"><p class="m-0 text-danger text-center">Không có dữ liệu</p></td></tr>
          @endif
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
    </div>
  </div>
</div>

{{-- Modal create --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <form action="{{ route('catalog_v1.trademarks.store') }}" method="post" class="modal-content" enctype="multipart/form-data">
      @csrf
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title">Thêm thương hiệu</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label class="form-label">Tên</label>
          <input class="form-control" name="name">
        </div>
        <div class="mb-2">
          <label class="form-label">Mô tả</label>
          <textarea class="form-control" name="description" style="height:120px"></textarea>
        </div>
        <div class="mb-2">
          <label class="form-label">Note (CKEditor)</label>
          <textarea class="form-control" name="note" style="height:140px"></textarea>
        </div>

        <div class="mb-2">
          <label class="form-label">Logo (upload hoặc nhập link)</label>
          <input type="file" class="form-control mb-2" name="img">
          <input class="form-control" name="img" placeholder="Hoặc dán link/path">
        </div>

        <div class="mb-2">
          <label class="form-label">Banner (upload hoặc nhập link)</label>
          <input type="file" class="form-control mb-2" name="banner">
          <input class="form-control" name="banner" placeholder="Hoặc dán link/path">
        </div>

        <div class="row">
          <div class="col-md-6 mb-2">
            <label class="form-label">Sort order</label>
            <input class="form-control" name="sort_order" required>
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
              <option value="1" selected>1</option>
              <option value="0">0</option>
            </select>
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
@endsection