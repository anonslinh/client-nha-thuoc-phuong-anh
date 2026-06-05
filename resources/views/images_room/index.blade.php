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
          <h4 class="mb-4 mb-sm-0 card-title">Ảnh phòng</h4>
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

  {{-- Bộ lọc nhỏ --}}
  <div class="card mb-3">
    <div class="card-body">
      <form class="row g-2" method="get" action="{{ route('images-room.listDataImagesRoom') }}">
        <div class="col-md-3">
          <select name="room_id" class="form-control selectpicker" data-live-search="true" title="-- Chọn phòng --">
            @foreach($rooms as $room)
              <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                {{ $room->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <select name="status" class="form-control">
            <option value="">-- Trạng thái --</option>
            <option value="1" {{ request('status')==='1' ? 'selected' : '' }}>Hiển thị</option>
            <option value="0" {{ request('status')==='0' ? 'selected' : '' }}>Ẩn</option>
          </select>
        </div>
        <div class="col-md-2 d-grid">
          <button class="btn btn-primary">Lọc</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap align-middle">
          <thead>
          <tr>
            <th style="width:60px">STT</th>
            <th>Ảnh</th>
            <th>Phòng</th>
            <th>Nổi bật</th>
            <th>Vị trí</th>
            <th>Trạng thái</th>
            <th style="width:160px">Thao tác</th>
          </tr>
          </thead>
          <tbody>
          @if($listData->total() > 0)
            @foreach($listData as $k => $value)
              @php
                $roomName = optional($rooms->firstWhere('id', $value->id_room))->name ?? 'N/A';
              @endphp
              <tr>
                <td>{{ ($listData->currentPage()-1)*$listData->perPage() + $k + 1 }}</td>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="{{ $value->link_image }}" class="rounded-2" width="72" height="54" style="object-fit:cover;">
                  </div>
                </td>
                <td>{{ $roomName }}</td>
                <td>
                  @if($value->is_featured) <span class="badge bg-success">Featured</span>
                  @else <span class="badge bg-secondary">Normal</span>
                  @endif
                </td>
                <td>{{ $value->sort_order }}</td>
                <td>
                  @if($value->status) <span class="badge bg-primary">Hiển thị</span>
                  @else <span class="badge bg-warning text-dark">Ẩn</span>
                  @endif
                </td>
                <td>
                  {{-- Modal update --}}
                  <div class="modal fade" id="modalUpdate{{ $value->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <form action="{{ route('images-room.updateImagesRoom', $value->id) }}"
                            method="post" class="modal-content" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header d-flex align-items-center">
                          <h4 class="modal-title">Cập nhật ảnh phòng</h4>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group mb-2">
                            <label class="form-label d-block">Phòng</label>
                            <select name="id_room" class="form-control selectpicker" data-live-search="true" required>
                              @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ $room->id == $value->id_room ? 'selected' : '' }}>
                                  {{ $room->name }}
                                </option>
                              @endforeach
                            </select>
                          </div>

                          <div class="form-group mb-2">
                            <label class="d-block form-label">Ảnh hiện tại</label>
                            <img src="{{ $value->link_image }}" class="rounded-2" style="width:200px;margin:8px 0;object-fit:cover;">
                          </div>

                          <div class="form-group mb-2">
                            <label class="form-label d-block">Upload ảnh mới (tùy chọn)</label>
                            <input class="form-control" type="file" accept="image/*" name="image">
                            <small class="text-muted">Hoặc nhập URL ảnh bên dưới</small>
                          </div>

                          <div class="form-group mb-2">
                            <label class="form-label">URL ảnh (tùy chọn)</label>
                            <input class="form-control" name="link_image" value="{{ $value->link_image }}">
                          </div>

                          <div class="form-group mb-2">
                            <label class="form-label">Vị trí (sort_order)</label>
                            <input class="form-control" name="sort_order" type="number" value="{{ $value->sort_order }}">
                          </div>

                          <div class="form-group mb-2">
                            <label class="form-label">Nổi bật</label>
                            <select name="is_featured" class="form-control">
                              <option value="0" {{ $value->is_featured == 0 ? 'selected' : '' }}>Không</option>
                              <option value="1" {{ $value->is_featured == 1 ? 'selected' : '' }}>Có</option>
                            </select>
                          </div>

                          <div class="form-group mb-2">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-control">
                              <option value="1" {{ $value->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                              <option value="0" {{ $value->status == 0 ? 'selected' : '' }}>Ẩn</option>
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

                  <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $value->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-pencil-square" viewBox="0 0 16 16">
                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293z"/>
                      <path fill-rule="evenodd"
                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5z"/>
                    </svg>
                  </button>

                  <a href="{{ route('images-room.ImagesRoom', $value->id) }}"
                     class="btn btn-danger btn-sa-confirm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-trash" viewBox="0 0 16 16">
                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                      <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM2.5 3h11V2h-11z"/>
                    </svg>
                  </a>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="7"><p class="m-0 text-danger text-center">Không có dữ liệu</p></td>
            </tr>
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

{{-- Modal tạo mới --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
  <div class="modal-dialog" role="document">
    <form action="{{ route('images-room.storeImagesRoom') }}" method="post"
          class="modal-content" enctype="multipart/form-data">
      @csrf
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title">Thêm ảnh phòng</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-2">
          <label class="form-label d-block">Phòng</label>
          <select name="id_room" class="form-control selectpicker" data-live-search="true" required>
            @foreach($rooms as $room)
              <option value="{{ $room->id }}">{{ $room->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="alert alert-info py-2">
          Bạn có thể <b>upload ảnh</b> HOẶC nhập <b>URL ảnh</b>. Nếu có cả hai, hệ thống ưu tiên ảnh upload.
        </div>

        <div class="form-group mb-2">
          <label class="form-label">Upload ảnh</label>
          <input class="form-control" type="file" accept="image/*" name="image">
        </div>

        <div class="form-group mb-2">
          <label class="form-label">URL ảnh</label>
          <input class="form-control" name="link_image" placeholder="https://...">
        </div>

        <div class="form-group mb-2">
          <label class="form-label">Vị trí (sort_order)</label>
          <input class="form-control" name="sort_order" type="number" value="0">
        </div>

        <div class="form-group mb-2">
          <label class="form-label">Nổi bật</label>
          <select name="is_featured" class="form-control">
            <option value="0" selected>Không</option>
            <option value="1">Có</option>
          </select>
        </div>

        <div class="form-group mb-2">
          <label class="form-label">Trạng thái</label>
          <select name="status" class="form-control">
            <option value="1" selected>Hiển thị</option>
            <option value="0">Ẩn</option>
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

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
  $('.selectpicker').selectpicker();
</script>
@endsection
