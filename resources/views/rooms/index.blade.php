@extends('Layout.index')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
@endsection

@section('content')
<div class="container-fluid">
  <div class="card card-body py-3">
    <div class="row align-items-center">
      <div class="col-12">
        <div class="d-sm-flex align-items-center justify-space-between">
          <h4 class="mb-4 mb-sm-0 card-title">Quản lý phòng</h4>
          <nav aria-label="breadcrumb" class="ms-auto">
            <ol class="breadcrumb">
              <li class="breadcrumb-item d-flex align-items-center">
                <a class="text-muted text-decoration-none d-flex">
                  <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                </a>
              </li>
              <li class="breadcrumb-item" aria-current="page">
                <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center"
                        data-bs-toggle="modal" data-bs-target="#modalCreate">
                  <i class="ti ti-send fs-4 me-2"></i>
                  Thêm mới
                </button>
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

  {{-- Filter --}}
  <div class="card mb-3">
    <div class="card-body">
      <form class="row g-2" method="get" action="{{ route('rooms.listDataRooms') }}">
        <div class="col-md-3">
          <input name="kw" class="form-control" value="{{ request('kw') }}" placeholder="Tìm theo tên phòng">
        </div>
        <div class="col-md-2">
          <select name="type" class="form-control">
            <option value="">-- Loại phòng --</option>
            <option value="1" {{ request('type')==='1'?'selected':'' }}>Phòng đơn</option>
            <option value="2" {{ request('type')==='2'?'selected':'' }}>Phòng đôi</option>
            <option value="3" {{ request('type')==='3'?'selected':'' }}>Phòng 3 giường</option>
            <option value="4" {{ request('type')==='3'?'selected':'' }}>Phòng 4 giường</option>
          </select>
        </div>
        <div class="col-md-2">
          <select name="is_active" class="form-control">
            <option value="">-- Hiển thị --</option>
            <option value="1" {{ request('is_active')==='1'?'selected':'' }}>Hiện</option>
            <option value="0" {{ request('is_active')==='0'?'selected':'' }}>Ẩn</option>
          </select>
        </div>
        <div class="col-md-2">
          <select name="status" class="form-control">
            <option value="">-- Tình trạng --</option>
            <option value="1" {{ request('status')==='1'?'selected':'' }}>Còn phòng</option>
            <option value="0" {{ request('status')==='0'?'selected':'' }}>Hết phòng</option>
          </select>
        </div>
        <div class="col-md-2 d-grid">
          <button class="btn btn-primary">Lọc</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Table --}}
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap align-middle">
          <thead>
          <tr>
            <th style="width:60px">STT</th>
            <th>Phòng</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Loại</th>
            <th>Hiển thị</th>
            <th>Tình trạng</th>
            <th style="width:160px">Thao tác</th>
          </tr>
          </thead>
          <tbody>
          @if($listData->total() > 0)
            @foreach($listData as $k => $value)
              <tr>
                <td>{{ ($listData->currentPage()-1)*$listData->perPage() + $k + 1 }}</td>
                <td>
                  <div class="d-flex align-items-center">
                    @if($value->img_avatar)
                      <img src="{{ $value->img_avatar }}" class="rounded-2" width="72" height="54" style="object-fit:cover;">
                    @else
                      <div class="rounded-2 bg-light d-flex align-items-center justify-content-center" style="width:72px;height:54px;">N/A</div>
                    @endif
                    <div class="ms-3">
                      <h6 class="fw-semibold mb-1">{{ $value->name }}</h6>
                      <small class="text-muted">code_url: {{ $value->code_url ?? '—' }}</small><br>
                      @if($value->img_banner)
                        <small class="text-muted">Banner: {{ $value->img_banner }}</small>
                      @endif
                    </div>
                  </div>
                </td>
                <td>{{ $value->number_rooms }}</td>
                <td>
                  <div><b>{{ number_format($value->price) }}</b></div>
                  <small class="text-muted"><del>{{ number_format($value->price_listed) }}</del></small>
                </td>
                <td>
                  @if($value->type==1) <span class="badge bg-secondary">Đơn</span>
                  @elseif($value->type==2) <span class="badge bg-info">Đôi</span>
                  @else <span class="badge bg-warning text-dark">3 giường</span>
                  @endif
                </td>
                <td>
                  @if($value->is_active) <span class="badge bg-primary">Hiện</span>
                  @else <span class="badge bg-dark">Ẩn</span>
                  @endif
                </td>
                <td>
                  @if($value->status) <span class="badge bg-success">Còn phòng</span>
                  @else <span class="badge bg-danger">Hết phòng</span>
                  @endif
                </td>
                <td>
                  {{-- Modal update --}}
                  <div class="modal fade" id="modalUpdate{{ $value->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <form action="{{ route('rooms.updateRoom', $value->id) }}"
                            method="post" class="modal-content" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header d-flex align-items-center">
                          <h4 class="modal-title">Cập nhật phòng</h4>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="mb-2">
                                <label class="form-label">Tên phòng</label>
                                <input class="form-control" name="name" value="{{ $value->name }}" required>
                              </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label class="form-label">Số lượng phòng</label>
                                    <input class="form-control" name="number_rooms" type="number" value="{{ $value->number_rooms }}" min="0" required>
                                </div>
                                </div>
                            <div class="col-md-3">
                              <div class="mb-2">
                                <label class="form-label">Giá</label>
                                <input class="form-control" name="price" type="number" value="{{ $value->price }}" required>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="mb-2">
                                <label class="form-label">Giá gốc</label>
                                <input class="form-control" name="price_listed" type="number" value="{{ $value->price_listed }}" required>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="mb-2">
                                <label class="d-block form-label">Avatar hiện tại</label>
                                @if($value->img_avatar)
                                  <img src="{{ $value->img_avatar }}" style="width:160px;object-fit:cover" class="rounded-2 mb-2">
                                @endif
                                <input class="form-control" type="file" accept="image/*" name="img_avatar">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="mb-2">
                                <label class="d-block form-label">Banner hiện tại</label>
                                @if($value->img_banner)
                                  <img src="{{ $value->img_banner }}" style="width:160px;object-fit:cover" class="rounded-2 mb-2">
                                @endif
                                <input class="form-control" type="file" accept="image/*" name="img_banner">
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="mb-2">
                                <label class="form-label">Link video</label>
                                <input class="form-control" name="link_video" value="{{ $value->link_video }}">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="mb-2">
                                <label class="form-label">Ghi chú dịch vụ</label>
                                <input class="form-control" name="note_services" value="{{ $value->note_services }}">
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-4">
                              <div class="mb-2">
                                <label class="form-label">Loại</label>
                                <select name="type" class="form-control">
                                  <option value="1" {{ $value->type==1?'selected':'' }}>Phòng đơn</option>
                                  <option value="2" {{ $value->type==2?'selected':'' }}>Phòng đôi</option>
                                  <option value="3" {{ $value->type==3?'selected':'' }}>Phòng 3 giường</option>
                                  <option value="4" {{ $value->type==4?'selected':'' }}>Phòng 4 giường</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="mb-2">
                                <label class="form-label">Hiển thị</label>
                                <select name="is_active" class="form-control">
                                  <option value="1" {{ $value->is_active==1?'selected':'' }}>Hiện</option>
                                  <option value="0" {{ $value->is_active==0?'selected':'' }}>Ẩn</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="mb-2">
                                <label class="form-label">Tình trạng</label>
                                <select name="status" class="form-control">
                                  <option value="1" {{ $value->status==1?'selected':'' }}>Còn phòng</option>
                                  <option value="0" {{ $value->status==0?'selected':'' }}>Hết phòng</option>
                                </select>
                              </div>
                            </div>
                          </div>

                          <div class="mb-2">
                            <label class="form-label">code_url (SEO) — để trống nếu giữ nguyên</label>
                            <input class="form-control" name="code_url" value="">
                            <small class="text-muted">Ví dụ: 1986hotels-phong-vip</small>
                          </div>

                          <div class="mb-2">
                            <label class="form-label">Mô tả</label>
                            <textarea class="form-control" name="description" rows="4">{{ $value->description }}</textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Hủy</button>
                          <button class="btn btn-primary">Xác nhận</button>
                        </div>
                      </form>
                    </div>
                  </div>

                  <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $value->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293z"/>
                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5z"/>
                    </svg>
                  </button>

                  <a href="{{ route('rooms.deleteRoom', $value->id) }}" class="btn btn-danger btn-sa-confirm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                      <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1z"/>
                    </svg>
                  </a>
                </td>
              </tr>
            @endforeach
          @else
            <tr><td colspan="7"><p class="m-0 text-danger text-center">Không có dữ liệu</p></td></tr>
          @endif
          </tbody>
        </table>
      </div>
      <div class="d-flex justify-content-center">{{ $listData->appends(request()->all())->links('pagination') }}</div>
    </div>
  </div>
</div>

{{-- Modal tạo mới --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
    <form action="{{ route('rooms.storeRoom') }}" method="post" class="modal-content" enctype="multipart/form-data">
      @csrf
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title">Thêm phòng</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-2">
              <label class="form-label">Tên phòng</label>
              <input class="form-control" name="name" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-2">
                <label class="form-label">Số lượng phòng</label>
                    <input class="form-control" name="number_rooms" type="number" value="1" min="0" required>
            </div>
        </div>

          <div class="col-md-3">
            <div class="mb-2">
              <label class="form-label">Giá</label>
              <input class="form-control" name="price" type="number" value="0" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-2">
              <label class="form-label">Giá gốc</label>
              <input class="form-control" name="price_listed" type="number" value="0" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="mb-2">
              <label class="form-label d-block">Upload avatar</label>
              <input class="form-control" type="file" accept="image/*" name="img_avatar">
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-2">
              <label class="form-label d-block">Upload banner</label>
              <input class="form-control" type="file" accept="image/*" name="img_banner">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="mb-2">
              <label class="form-label">Loại</label>
              <select name="type" class="form-control">
                <option value="1">Phòng đơn</option>
                <option value="2">Phòng đôi</option>
                <option value="3">Phòng 3 giường</option>
                <option value="4">Phòng 4 giường</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-2">
              <label class="form-label">Hiển thị</label>
              <select name="is_active" class="form-control">
                <option value="1" selected>Hiện</option>
                <option value="0">Ẩn</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-2">
              <label class="form-label">Tình trạng</label>
              <select name="status" class="form-control">
                <option value="1" selected>Còn phòng</option>
                <option value="0">Hết phòng</option>
              </select>
            </div>
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label">Link video</label>
          <input class="form-control" name="link_video">
        </div>

        <div class="mb-2">
          <label class="form-label">Ghi chú dịch vụ</label>
          <input class="form-control" name="note_services">
        </div>

        <div class="mb-2">
          <label class="form-label">code_url (SEO) — để trống sẽ tự sinh</label>
          <input class="form-control" name="code_url" >
        </div>

        <div class="mb-2">
          <label class="form-label">Mô tả</label>
          <textarea class="form-control" name="description" rows="4"></textarea>
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
