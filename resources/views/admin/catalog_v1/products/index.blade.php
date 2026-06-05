@extends('Layout.index')
@section('content')
<div class="container-fluid">
  <div class="card card-body py-3">
    <div class="row align-items-center">
      <div class="col-12">
        <div class="d-sm-flex align-items-center justify-space-between">
          <h4 class="mb-4 mb-sm-0 card-title">Sản phẩm (product_v1)</h4>
          <nav aria-label="breadcrumb" class="ms-auto">
            <ol class="breadcrumb">
              <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('catalog_v1.products.kiotviet') }}"
                   class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center">
                  <i class="ti ti-refresh fs-4 me-2"></i>
                  Thêm từ KiotViet
                </a>
              </li>
              <li class="breadcrumb-item" aria-current="page">
                <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-primary d-flex align-items-center"
                        data-bs-toggle="modal" data-bs-target="#modalCreate">
                  <i class="ti ti-send fs-4 me-2"></i>
                  Thêm thủ công
                </button>
              </li>
            </ol>
          </nav>
        </div>

        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{session('success')}}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{session('error')}}</div> @endif
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('catalog_v1.products.index') }}" method="get" class="row">
        <div class="col-md-4 mb-2">
          <input name="key_search" class="form-control" placeholder="Tên, full name, code kiot..."
                 value="{{ request('key_search') }}">
        </div>
        <div class="col-md-4 mb-2">
          <button class="btn btn-primary" style="margin-right: 10px">Tìm kiếm</button>
          <a href="{{ route('catalog_v1.products.index') }}" class="btn btn-danger">Hủy</a>
        </div>
      </form>

      <div class="row mt-4">
        @if($listData->total() > 0)
          @foreach($listData as $k => $p)
            @php
              $img = $p->img_avatar;
              $src = $img ? (\Illuminate\Support\Str::startsWith($img,'http') ? $img : asset($img)) : null;
              $categoryName = optional($categories->firstWhere('id', $p->id_category))->name;
              $tradeMarkName = optional($trademarks->firstWhere('id', $p->id_trade_mark))->name;
            @endphp

            <div class="col-md-6 col-xl-6 mb-4">
              <div class="card h-100 shadow-sm border-0" style="border-radius:18px;">
                <div class="card-body">
                  <div class="d-flex gap-3">
                    <div style="width:120px;flex:0 0 120px;">
                      @if($src)
                        <img src="{{ $src }}" style="width:120px;height:120px;object-fit:cover;border-radius:16px;">
                      @else
                        <div style="width:120px;height:120px;border-radius:16px;background:#f2f5f9;display:flex;align-items:center;justify-content:center;color:#999;">
                          No image
                        </div>
                      @endif
                    </div>

                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                        <div>
                          <h5 class="mb-1 fw-semibold" style="line-height:1.4;">{{ $p->name ?? '-' }}</h5>
                          @if($p->full_name)
                            <div class="text-muted small mb-1">{{ $p->full_name }}</div>
                          @endif
                        </div>

                        <span class="badge {{ $p->status == 1 ? 'bg-success' : 'bg-danger' }}">
                          {{ $p->status == 1 ? 'Hiện' : 'Ẩn' }}
                        </span>
                      </div>

                      <div class="mb-2 d-flex flex-wrap gap-2">
                        @if($categoryName)
                          <span class="badge bg-primary-subtle text-primary">{{ $categoryName }}</span>
                        @endif
                        @if($tradeMarkName)
                          <span class="badge bg-info-subtle text-info">{{ $tradeMarkName }}</span>
                        @endif

                        @if($p->is_active === 1 || $p->is_active === '1')
                          <span class="badge bg-success-subtle text-success">Đang kinh doanh</span>
                        @elseif($p->is_active === 0 || $p->is_active === '0')
                          <span class="badge bg-danger-subtle text-danger">Ngừng bán</span>
                        @endif
                      </div>

                      <div class="mb-2">
                        <span class="fw-semibold text-primary">
                          {{ $p->price ? number_format($p->price).'đ' : '-' }}
                        </span>

                        @if($p->price_sale)
                          <span class="ms-2 text-danger fw-semibold">
                            Sale: {{ number_format($p->price_sale) }}đ
                          </span>
                        @endif
                      </div>

                      <div class="small text-muted mb-2">
                        @if($p->id_product_kiotviet)
                          <div>Kiot ID: <b>{{ $p->id_product_kiotviet }}</b></div>
                          <div>Mã Kiot: {{ $p->code_product_kiovet }}</div>
                        @else
                          <span class="badge bg-secondary">Thủ công</span>
                        @endif
                      </div>

                      @if($p->description)
                        <div class="text-muted small mb-3" style="line-height:1.6;">
                          {{ \Illuminate\Support\Str::limit(strip_tags($p->description), 160) }}
                        </div>
                      @endif

                      <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('catalog_v1.products.show',$p->id) }}" target="_blank" class="btn btn-primary btn-sm">
                          Xem chi tiết
                        </a>

                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$p->id}}">
                          Sửa
                        </button>

                        <a href="{{ route('catalog_v1.products.destroy',$p->id) }}" class="btn btn-danger btn-sm btn-sa-confirm">
                          Xóa
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- Modal update --}}
            <div class="modal fade" id="modalUpdate{{$p->id}}" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <form action="{{ route('catalog_v1.products.update',$p->id) }}" method="post" class="modal-content" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title">Cập nhật sản phẩm</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-6 mb-2">
                        <label class="form-label">Danh mục</label>
                        <select name="id_category" class="form-control">
                          <option value="">-- chọn --</option>
                          @foreach($categories as $c)
                            <option value="{{$c->id}}" {{ $p->id_category == $c->id ? 'selected':'' }}>{{$c->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-6 mb-2">
                        <label class="form-label">Thương hiệu</label>
                        <select name="id_trade_mark" class="form-control">
                          <option value="">-- chọn --</option>
                          @foreach($trademarks as $t)
                            <option value="{{$t->id}}" {{ $p->id_trade_mark == $t->id ? 'selected':'' }}>{{$t->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="mb-2">
                      <label class="form-label">Tên</label>
                      <input class="form-control" name="name" value="{{$p->name}}">
                    </div>
                    <div class="mb-2">
                      <label class="form-label">Full name</label>
                      <input class="form-control" name="full_name" value="{{$p->full_name}}">
                    </div>
                    <div class="mb-2">
                      <label class="form-label">Mô tả</label>
                      <textarea class="form-control" name="description" style="height:120px">{{$p->description}}</textarea>
                    </div>

                    <div class="row">
                      <div class="col-md-6 mb-2">
                        <label class="form-label">Giá</label>
                        <input class="form-control" name="price" value="{{$p->price}}">
                      </div>
                      <div class="col-md-6 mb-2">
                        <label class="form-label">Giá sale</label>
                        <input class="form-control" name="price_sale" value="{{$p->price_sale}}">
                      </div>
                    </div>

                    <div class="mb-2">
                      <label class="form-label">Ảnh đại diện</label>
                      <input type="file" class="form-control" name="img_avatar">
                    </div>

                    <div class="mb-2">
                      <label class="form-label">Ảnh gallery (có thể chọn nhiều)</label>
                      <input type="file" class="form-control" name="images[]" multiple>
                    </div>

                    <div class="row">
                      <div class="col-md-6 mb-2">
                        <label class="form-label">is_active</label>
                        <select name="is_active" class="form-control">
                          <option value="">--</option>
                          <option value="1" {{ $p->is_active === 1 || $p->is_active === '1' ? 'selected':'' }}>true</option>
                          <option value="0" {{ $p->is_active === 0 || $p->is_active === '0' ? 'selected':'' }}>false</option>
                        </select>
                      </div>
                      <div class="col-md-6 mb-2">
                        <label class="form-label">status</label>
                        <select name="status" class="form-control">
                          <option value="">--</option>
                          <option value="1" {{ $p->status == 1 ? 'selected':'' }}>1</option>
                          <option value="0" {{ $p->status == 0 ? 'selected':'' }}>0</option>
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
          @endforeach
        @else
          <div class="col-12">
            <p class="m-0 text-danger text-center">Không có dữ liệu</p>
          </div>
        @endif
      </div>

      <div class="d-flex justify-content-center">
        {{$listData->appends(request()->all())->links('pagination')}}
      </div>
    </div>
  </div>
</div>

{{-- Modal create --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <form action="{{ route('catalog_v1.products.store') }}" method="post" class="modal-content" enctype="multipart/form-data">
      @csrf
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title">Thêm sản phẩm thủ công</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 mb-2">
            <label class="form-label">Danh mục</label>
            <select name="id_category" class="form-control">
              <option value="">-- chọn --</option>
              @foreach($categories as $c)
                <option value="{{$c->id}}">{{$c->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">Thương hiệu</label>
            <select name="id_trade_mark" class="form-control">
              <option value="">-- chọn --</option>
              @foreach($trademarks as $t)
                <option value="{{$t->id}}">{{$t->name}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label">Tên</label>
          <input class="form-control" name="name">
        </div>
        <div class="mb-2">
          <label class="form-label">Full name</label>
          <input class="form-control" name="full_name">
        </div>
        <div class="mb-2">
          <label class="form-label">Mô tả</label>
          <textarea class="form-control" name="description" style="height:120px"></textarea>
        </div>

        <div class="row">
          <div class="col-md-6 mb-2">
            <label class="form-label">Giá</label>
            <input class="form-control" name="price">
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">Giá sale</label>
            <input class="form-control" name="price_sale">
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label">Ảnh đại diện</label>
          <input type="file" class="form-control" name="img_avatar">
        </div>

        <div class="mb-2">
          <label class="form-label">Ảnh gallery (nhiều ảnh)</label>
          <input type="file" class="form-control" name="images[]" multiple>
        </div>

        <div class="row">
          <div class="col-md-6 mb-2">
            <label class="form-label">is_active</label>
            <select name="is_active" class="form-control">
              <option value="">--</option>
              <option value="1">true</option>
              <option value="0">false</option>
            </select>
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">status</label>
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