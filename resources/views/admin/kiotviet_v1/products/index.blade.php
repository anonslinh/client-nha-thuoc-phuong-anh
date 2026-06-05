@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="mb-4 mb-sm-0 card-title">Đồng bộ sản phẩm KiotViet (V1)</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <form action="{{ route('kiotviet_v1.categories.sync') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="account_code" value="{{ $account_code }}">
                                    <button class="justify-content-center badge fw-medium fs-2 btn btn-rounded btn-info d-flex align-items-center">
                                        <i class="ti ti-refresh fs-4 me-2"></i>
                                        Đồng bộ danh mục
                                    </button>
                                </form>
                            </li>
                        </ol>
                    </nav>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            {{-- FILTER --}}
            <form action="{{ route('kiotviet_v1.products.index') }}" method="get" class="row">
                <div class="col-md-3 mb-2">
                    <label class="form-label">Tài khoản Kiot (Account Code)</label>
                    <select name="account_code" class="form-control">
                        @foreach($accounts as $acc)
                            <option value="{{ $acc->code }}" {{ $account_code == $acc->code ? 'selected' : '' }}>
                                {{ $acc->code }} ({{ $acc->retailer }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <label class="form-label">Danh mục (Kiot)</label>
                    <select name="category_id" class="form-control">
                        <option value="">-- Tất cả --</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->kiotviet_id }}" {{ request('category_id') == $c->kiotviet_id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <label class="form-label">Thương hiệu (Kiot)</label>
                    <select name="brand_id" class="form-control">
                        <option value="">-- Tất cả --</option>
                        @foreach($brands as $b)
                            @php
                                $bName = $b->name ?? $b->brand_name ?? $b->trademark_name ?? ('Brand#'.$b->id);
                                $bKiotId = $b->kiotviet_id ?? null;
                            @endphp
                            @if($bKiotId)
                                <option value="{{ $bKiotId }}" {{ request('brand_id') == $bKiotId ? 'selected' : '' }}>
                                    {{ $bName }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <label class="form-label">Trạng thái</label>
                    <select name="is_active" class="form-control">
                        <option value="1" {{ request('is_active', 1) == 1 ? 'selected' : '' }}>Đang kinh doanh</option>
                        <option value="0" {{ request('is_active') === "0" ? 'selected' : '' }}>Ngừng kinh doanh</option>
                        <option value="" {{ request('is_active') === "" ? 'selected' : '' }}>Tất cả</option>
                    </select>
                </div>

                <div class="col-md-4 mb-2">
                    <label class="form-label">Tìm kiếm</label>
                    <input name="key_search" class="form-control" placeholder="Tên sản phẩm..."
                           value="{{ request('key_search') }}">
                </div>

                <div class="col-md-4 mb-2 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="hideSynced"
                               name="hide_synced" {{ (int)request('hide_synced', 1) === 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="hideSynced">
                            Ẩn sản phẩm đã đồng bộ
                        </label>
                    </div>
                </div>

                <div class="col-md-4 mb-2 d-flex align-items-end">
                    <button class="btn btn-primary" style="margin-right: 10px">Tìm kiếm</button>
                    <a href="{{ route('kiotviet_v1.products.index') }}" class="btn btn-danger" style="margin-right: 10px">Hủy</a>
                </div>
            </form>

            {{-- LIST + ACTIONS --}}
            <form method="post" id="syncForm">
                @csrf
                <input type="hidden" name="account_code" value="{{ $account_code }}">

                <div class="table-responsive mt-4">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                        <tr>
                            <th style="width: 60px" class="text-center">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th style="width: 90px">Ảnh</th>
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>Giá</th>
                            <th>Trạng thái</th>
                            <th>Đồng bộ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listData->total() > 0)
                            @foreach($listData as $key => $p)
                                @php
                                    $sync = $p['_sync_status'] ?? 'unsynced';
                                    $disabled = $sync === 'synced';
                                    $img = $p['image'] ?? $p['imageUrl'] ?? ($p['images'][0]['url'] ?? null);
                                @endphp
                                <tr class="{{ $disabled ? 'table-secondary' : '' }}">
                                    <td class="text-center align-middle">
                                        <input type="checkbox"
                                               class="rowCheck"
                                               name="kiot_ids[]"
                                               value="{{ $p['id'] ?? '' }}"
                                               {{ $disabled ? 'disabled' : '' }}>
                                    </td>
                                    <td class="align-middle">
                                        @if($img)
                                            <img src="{{ $img }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <span>{{ $p['code'] ?? '-' }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <h6 class="fw-semibold mb-1">{{ $p['fullName'] ?? ($p['name'] ?? '-') }}</h6>
                                        <span class="fw-normal text-muted">Kiot ID: {{ $p['id'] ?? '-' }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span>{{ !empty($p['basePrice']) ? number_format($p['basePrice']) . 'đ' : '-' }}</span>
                                    </td>
                                    <td class="align-middle">
                                        @if(!empty($p['isActive']))
                                            <span class="badge bg-success">Đang KD</span>
                                        @else
                                            <span class="badge bg-danger">Ngừng</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if($sync === 'synced')
                                            <span class="badge bg-secondary">Đã đồng bộ</span>
                                        @elseif($sync === 'needs_update')
                                            <span class="badge bg-warning">Cần cập nhật</span>
                                        @else
                                            <span class="badge bg-info">Chưa đồng bộ</span>
                                        @endif
                                        @if(!empty($p['_synced_at']))
                                            <div class="text-muted" style="font-size: 12px;">
                                                Synced: {{ \Carbon\Carbon::parse($p['_synced_at'])->format('d/m/Y H:i') }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">
                                    <p class="m-0 text-danger text-center">Không có dữ liệu</p>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <button type="submit"
                            formaction="{{ route('kiotviet_v1.products.import') }}"
                            class="btn btn-primary">
                        <i class="ti ti-download me-1"></i> Đồng bộ về hệ thống
                    </button>

                    <button type="submit"
                            formaction="{{ route('kiotviet_v1.products.resync') }}"
                            class="btn btn-warning">
                        <i class="ti ti-refresh me-1"></i> Resync dữ liệu
                    </button>

                    <span class="ms-auto text-muted">Tổng Kiot: {{ $total }}</span>
                </div>
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
    $(document).ready(function () {
        $('#checkAll').on('change', function(){
            $('.rowCheck:not(:disabled)').prop('checked', $(this).is(':checked'));
        });

        // nếu user tick/un-tick thủ công -> cập nhật checkAll
        $('.rowCheck').on('change', function(){
            let total = $('.rowCheck:not(:disabled)').length;
            let checked = $('.rowCheck:not(:disabled):checked').length;
            $('#checkAll').prop('checked', total > 0 && total === checked);
        });

        // cảnh báo trước khi submit nếu chưa chọn
        $('#syncForm').on('submit', function(e){
            let checked = $('.rowCheck:checked').length;
            if(checked === 0){
                e.preventDefault();
                alert('Vui lòng chọn ít nhất 1 sản phẩm.');
                return false;
            }
        });
    });
</script>
@endsection