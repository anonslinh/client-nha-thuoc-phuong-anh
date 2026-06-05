@extends('Layout.index')

@section('content')
<div class="container-fluid">

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

  <div class="card card-body py-3">
    <div class="d-sm-flex align-items-center justify-space-between">
      <h4 class="mb-4 mb-sm-0 card-title">Quản lý chuyên mục</h4>

      <nav aria-label="breadcrumb" class="ms-auto">
        <ol class="breadcrumb">
          <li class="breadcrumb-item" aria-current="page">
            <a class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-secondary d-flex align-items-center"
               href="{{ route('blog.posts.index') }}">
              <i class="ti ti-article fs-4 me-2"></i>
              Quản lý bài viết
            </a>
          </li>
          <li class="breadcrumb-item" aria-current="page">
            <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center"
                    data-bs-toggle="modal" data-bs-target="#modalCreate">
              <i class="ti ti-plus fs-4 me-2"></i>
              Thêm chuyên mục
            </button>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  {{-- Bộ lọc --}}
  <div class="card mb-3">
    <div class="card-body">
      <form class="row g-2" method="get" action="{{ route('blog.categories.index') }}">
        <div class="col-md-6">
          <input name="kw" class="form-control" value="{{ request('kw') }}" placeholder="Tìm tên / slug">
        </div>
        <div class="col-md-3">
          <select name="status" class="form-control">
            <option value="">-- Trạng thái --</option>
            <option value="active" {{ request('status')==='active'?'selected':'' }}>ACTIVE</option>
            <option value="inactive" {{ request('status')==='inactive'?'selected':'' }}>INACTIVE</option>
          </select>
        </div>
        <div class="col-md-3 d-grid">
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
            <th>Tên</th>
            <th style="width:240px">Slug</th>
            <th style="width:120px">Bài viết</th>
            <th style="width:140px">Trạng thái</th>
            <th style="width:260px">Thao tác</th>
          </tr>
          </thead>
          <tbody>
          @if($listData->total() > 0)
            @foreach($listData as $k => $c)
              <tr>
                <td>{{ ($listData->currentPage()-1)*$listData->perPage() + $k + 1 }}</td>
                <td><b>{{ $c->name }}</b></td>
                <td class="text-muted">{{ $c->slug }}</td>
                <td><span class="badge bg-light text-dark">{{ $c->posts_count ?? 0 }}</span></td>
                <td>
                  @if($c->status==='active') <span class="badge bg-success">ACTIVE</span>
                  @else <span class="badge bg-secondary">INACTIVE</span>
                  @endif
                </td>
                <td class="d-flex gap-2">

                  {{-- Modal Update --}}
                  <div class="modal fade" id="modalUpdate{{ $c->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <form action="{{ route('blog.categories.update', $c->id) }}" method="post" class="modal-content">
                        @csrf
                        <div class="modal-header">
                          <h4 class="modal-title">Cập nhật chuyên mục</h4>
                          <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-2">
                            <label class="form-label">Tên</label>
                            <input class="form-control" name="name" value="{{ $c->name }}" required>
                          </div>
                          <div class="mb-2">
                            <label class="form-label">Slug (để trống sẽ tự tạo)</label>
                            <input class="form-control" name="slug" value="{{ $c->slug }}">
                          </div>
                          <div class="mb-2">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-control">
                              <option value="active" {{ $c->status==='active'?'selected':'' }}>ACTIVE</option>
                              <option value="inactive" {{ $c->status==='inactive'?'selected':'' }}>INACTIVE</option>
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

                  <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $c->id }}">Sửa</button>

                  <form action="{{ route('blog.categories.toggle', $c->id) }}" method="post">
                    @csrf
                    <button class="btn btn-warning" type="submit">
                      {{ $c->status==='active' ? 'Tắt' : 'Bật' }}
                    </button>
                  </form>

                  <a href="{{ route('blog.categories.delete', $c->id) }}" class="btn btn-danger btn-sa-confirm">Xóa</a>
                </td>
              </tr>
            @endforeach
          @else
            <tr><td colspan="6"><p class="m-0 text-danger text-center">Không có dữ liệu</p></td></tr>
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

{{-- Modal tạo --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form action="{{ route('blog.categories.store') }}" method="post" class="modal-content">
      @csrf
      <div class="modal-header">
        <h4 class="modal-title">Thêm chuyên mục</h4>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label class="form-label">Tên</label>
          <input class="form-control" name="name" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Slug (để trống sẽ tự tạo)</label>
          <input class="form-control" name="slug">
        </div>
        <div class="mb-2">
          <label class="form-label">Trạng thái</label>
          <select name="status" class="form-control">
            <option value="active" selected>ACTIVE</option>
            <option value="inactive">INACTIVE</option>
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
@endsection
