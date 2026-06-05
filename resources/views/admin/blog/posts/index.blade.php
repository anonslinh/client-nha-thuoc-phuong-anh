@extends('Layout.index')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<style>
  .thumb-mini{ width:84px; height:54px; object-fit:cover; border-radius:8px; border:1px solid #eee; }
  .text-clip-2{
    display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;
    overflow:hidden;
  }
</style>
@endsection

@section('content')
<div class="container-fluid">

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

  <div class="card card-body py-3">
    <div class="d-sm-flex align-items-center justify-space-between">
      <h4 class="mb-4 mb-sm-0 card-title">Quản lý bài viết</h4>

      <nav aria-label="breadcrumb" class="ms-auto">
        <ol class="breadcrumb">
          <li class="breadcrumb-item" aria-current="page">
            <a class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-secondary d-flex align-items-center"
               href="{{ route('blog.categories.index') }}">
              <i class="ti ti-folder fs-4 me-2"></i>
              Quản lý chuyên mục
            </a>
          </li>
          <li class="breadcrumb-item" aria-current="page">
            <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center"
                    data-bs-toggle="modal" data-bs-target="#modalCreate">
              <i class="ti ti-plus fs-4 me-2"></i>
              Thêm bài viết
            </button>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  {{-- Bộ lọc --}}
  <div class="card mb-3">
    <div class="card-body">
      <form class="row g-2" method="get" action="{{ route('blog.posts.index') }}">
        <div class="col-md-4">
          <input name="kw" class="form-control" value="{{ request('kw') }}" placeholder="Tìm tiêu đề / slug / mô tả">
        </div>
        <div class="col-md-3">
          <select name="category" class="form-control selectpicker" data-live-search="true" title="-- Chuyên mục --">
            <option value="">-- Tất cả chuyên mục --</option>
            @foreach($categories as $c)
              <option value="{{ $c->id }}" {{ (string)request('category')===(string)$c->id ? 'selected':'' }}>
                {{ $c->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <select name="status" class="form-control">
            <option value="">-- Trạng thái --</option>
            <option value="draft" {{ request('status')==='draft'?'selected':'' }}>DRAFT</option>
            <option value="published" {{ request('status')==='published'?'selected':'' }}>PUBLISHED</option>
            <option value="archived" {{ request('status')==='archived'?'selected':'' }}>ARCHIVED</option>
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
            <th style="width:110px">Ảnh</th>
            <th>Tiêu đề</th>
            <th style="width:170px">Chuyên mục</th>
            <th style="width:130px">Trạng thái</th>
            <th style="width:140px">Ngày đăng</th>
            <th style="width:260px">Thao tác</th>
          </tr>
          </thead>
          <tbody>
          @if($listData->total() > 0)
            @foreach($listData as $k => $p)
              @php
                $thumb = $p->thumbnail_url ?? $p->image_url ?? '/assets/assetsclient/img/blog/blog-1.jpg';
              @endphp
              <tr>
                <td>{{ ($listData->currentPage()-1)*$listData->perPage() + $k + 1 }}</td>
                <td>
                  <img class="thumb-mini" src="{{ $thumb }}" alt="{{ $p->title }}">
                </td>
                <td>
                  <div><b>{{ $p->title }}</b></div>
                  <div class="text-muted">/{{ $p->slug }}</div>
                  @if(!empty($p->excerpt))
                    <div class="text-clip-2" style="color:#666; max-width:520px;">{{ $p->excerpt }}</div>
                  @endif
                </td>
                <td>
                  <span class="badge bg-light text-dark">
                    {{ optional($p->category)->name ?? 'Chưa chọn' }}
                  </span>
                </td>
                <td>
                  @if($p->status==='published') <span class="badge bg-success">PUBLISHED</span>
                  @elseif($p->status==='draft') <span class="badge bg-warning text-dark">DRAFT</span>
                  @elseif($p->status==='archived') <span class="badge bg-secondary">ARCHIVED</span>
                  @else <span class="badge bg-dark">{{ strtoupper($p->status) }}</span>
                  @endif
                </td>
                <td>
                  {{ optional($p->published_at ?? $p->created_at)->format('d/m/Y') }}
                </td>
                <td class="d-flex gap-2">

                  {{-- Modal Update --}}
                  <div class="modal fade" id="modalUpdate{{ $p->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                      <form action="{{ route('blog.posts.update', $p->id) }}" method="post" class="modal-content">
                        @csrf
                        <div class="modal-header">
                          <h4 class="modal-title">Cập nhật bài viết</h4>
                          <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">

                          <div class="row">
                            <div class="col-md-8 mb-2">
                              <label class="form-label">Tiêu đề</label>
                              <input class="form-control" name="title" value="{{ $p->title }}" required>
                            </div>
                            <div class="col-md-4 mb-2">
                              <label class="form-label">Slug (để trống sẽ tự tạo)</label>
                              <input class="form-control" name="slug" value="{{ $p->slug }}">
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-4 mb-2">
                              <label class="form-label">Chuyên mục</label>
                              <select name="category_id" class="form-control selectpicker" data-live-search="true" title="-- Chọn --">
                                <option value="">-- Không --</option>
                                @foreach($categories as $c)
                                  <option value="{{ $c->id }}" {{ (string)$p->category_id===(string)$c->id ? 'selected':'' }}>
                                    {{ $c->name }}
                                  </option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-3 mb-2">
                              <label class="form-label">Trạng thái</label>
                              <select name="status" class="form-control">
                                <option value="draft" {{ $p->status==='draft'?'selected':'' }}>DRAFT</option>
                                <option value="published" {{ $p->status==='published'?'selected':'' }}>PUBLISHED</option>
                                <option value="archived" {{ $p->status==='archived'?'selected':'' }}>ARCHIVED</option>
                              </select>
                            </div>
                            <div class="col-md-3 mb-2">
                              <label class="form-label">Ngày đăng</label>
                              <input type="datetime-local" class="form-control" name="published_at"
                                     value="{{ optional($p->published_at)->format('Y-m-d\TH:i') }}">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label class="form-label">Tác giả</label>
                              <input class="form-control" name="author_name" value="{{ $p->author_name }}">
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6 mb-2">
                              <label class="form-label">Thumbnail URL</label>
                              <input class="form-control" name="thumbnail_url" value="{{ $p->thumbnail_url }}">
                            </div>
                            <div class="col-md-6 mb-2">
                              <label class="form-label">Image URL</label>
                              <input class="form-control" name="image_url" value="{{ $p->image_url }}">
                            </div>
                          </div>

                          <div class="mb-2">
                            <label class="form-label">Mô tả ngắn (excerpt)</label>
                            <textarea class="form-control" name="excerpt" rows="2">{{ $p->excerpt }}</textarea>
                          </div>

                          <div class="mb-2">
                            <label class="form-label">Nội dung</label>
                            <textarea class="form-control" name="content" rows="10" required>{{ $p->content }}</textarea>
                            <small class="text-muted">Bạn có thể thay textarea bằng editor (CKEditor/Summernote) nếu muốn.</small>
                          </div>

                          <div class="row">
                            <div class="col-md-6 mb-2">
                              <label class="form-label">SEO title</label>
                              <input class="form-control" name="seo_title" value="{{ $p->seo_title }}">
                            </div>
                            <div class="col-md-6 mb-2">
                              <label class="form-label">Meta description</label>
                              <input class="form-control" name="meta_description" value="{{ $p->meta_description }}">
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

                  <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $p->id }}">Sửa</button>

                  <form action="{{ route('blog.posts.toggle', $p->id) }}" method="post">
                    @csrf
                    @if($p->status==='published')
                      <button class="btn btn-warning" type="submit">Ẩn (Draft)</button>
                    @else
                      <button class="btn btn-primary" type="submit">Đăng</button>
                    @endif
                  </form>

                  <a href="{{ route('blog.posts.delete', $p->id) }}" class="btn btn-danger btn-sa-confirm">Xóa</a>
                </td>
              </tr>
            @endforeach
          @else
            <tr><td colspan="7"><p class="m-0 text-danger text-center">Không có dữ liệu</p></td></tr>
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

{{-- Modal tạo bài viết --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <form action="{{ route('blog.posts.store') }}" method="post" class="modal-content">
      @csrf
      <div class="modal-header">
        <h4 class="modal-title">Thêm bài viết</h4>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-8 mb-2">
            <label class="form-label">Tiêu đề</label>
            <input class="form-control" name="title" required>
          </div>
          <div class="col-md-4 mb-2">
            <label class="form-label">Slug (để trống sẽ tự tạo)</label>
            <input class="form-control" name="slug">
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 mb-2">
            <label class="form-label">Chuyên mục</label>
            <select name="category_id" class="form-control selectpicker" data-live-search="true" title="-- Chọn --">
              <option value="">-- Không --</option>
              @foreach($categories as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 mb-2">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-control">
              <option value="draft" selected>DRAFT</option>
              <option value="published">PUBLISHED</option>
              <option value="archived">ARCHIVED</option>
            </select>
          </div>
          <div class="col-md-3 mb-2">
            <label class="form-label">Ngày đăng</label>
            <input type="datetime-local" class="form-control" name="published_at">
          </div>
          <div class="col-md-2 mb-2">
            <label class="form-label">Tác giả</label>
            <input class="form-control" name="author_name" placeholder="1986Hotels">
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-2">
            <label class="form-label">Thumbnail URL</label>
            <input class="form-control" name="thumbnail_url">
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">Image URL</label>
            <input class="form-control" name="image_url">
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label">Mô tả ngắn (excerpt)</label>
          <textarea class="form-control" name="excerpt" rows="2"></textarea>
        </div>

        <div class="mb-2">
          <label class="form-label">Nội dung</label>
          <textarea class="form-control" name="content" rows="10" required></textarea>
        </div>

        <div class="row">
          <div class="col-md-6 mb-2">
            <label class="form-label">SEO title</label>
            <input class="form-control" name="seo_title">
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">Meta description</label>
            <input class="form-control" name="meta_description">
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

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
  $('.selectpicker').selectpicker();
</script>
@endsection
