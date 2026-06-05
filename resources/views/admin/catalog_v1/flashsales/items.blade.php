@extends('Layout.index')

@section('style')
<style>
    .fs-admin-hero{
        border-radius: 18px;
        background: linear-gradient(135deg, #0ea5c6 0%, #2563eb 100%);
        color: #fff;
        padding: 22px;
        box-shadow: 0 16px 34px rgba(37, 99, 235, .18);
    }

    .fs-admin-hero h4{
        color: #fff;
        margin: 0 0 8px;
        font-weight: 800;
    }

    .fs-admin-hero p{
        margin: 0;
        opacity: .92;
    }

    .fs-item-thumb{
        width: 76px;
        height: 76px;
        border-radius: 16px;
        overflow: hidden;
        background: #f1f5f9;
        border: 1px solid #e5e7eb;
    }

    .fs-item-thumb img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .fs-item-title{
        font-weight: 800;
        color: #111827;
        line-height: 1.45;
    }

    .fs-item-sub{
        font-size: 13px;
        color: #6b7280;
        line-height: 1.5;
        margin-top: 4px;
    }

    .fs-item-badge{
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-height: 28px;
        padding: 0 10px;
        border-radius: 999px;
        background: #eef8ff;
        color: #0284c7;
        font-size: 12px;
        font-weight: 800;
    }

    .fs-price{
        font-weight: 800;
        color: #0ea5c6;
    }

    .fs-origin-price{
        font-size: 13px;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .fs-product-row:hover{
        background: #f8fafc;
    }

    .fs-image-preview{
        width: 100%;
        aspect-ratio: 1 / 1;
        border-radius: 20px;
        overflow: hidden;
        background: #f1f5f9;
        border: 1px solid #e5e7eb;
    }

    .fs-image-preview img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .fs-form-note{
        font-size: 12px;
        color: #64748b;
        line-height: 1.55;
        margin-top: 5px;
    }

    .fs-table-fixed{
        min-width: 1100px;
    }
</style>
@endsection

@section('content')
@php
    $flashDate = \Carbon\Carbon::parse($flashSale->sale_date)->format('d/m/Y');
    $flashTime = substr($flashSale->start_time, 0, 5) . ' - ' . substr($flashSale->end_time, 0, 5);
@endphp

<div class="container-fluid">
    <div class="fs-admin-hero mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h4>Quản lý sản phẩm Flash Sale</h4>
                <p>
                    Phiên: <strong>{{ $flashSale->title ?: 'Flash Sale' }}</strong>
                    · Ngày: <strong>{{ $flashDate }}</strong>
                    · Khung giờ: <strong>{{ $flashTime }}</strong>
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('catalog_v1.flashsales.index') }}" class="btn btn-light">
                    ← Quay lại
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mt-3 mb-0">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-3">Tìm sản phẩm để thêm vào Flash Sale</h5>

            <form action="{{ route('catalog_v1.flashsales.items', $flashSale->id) }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-9">
                    <label class="form-label">Tìm theo tên, tên đầy đủ hoặc mã KiotViet</label>
                    <input
                        type="text"
                        name="key_search"
                        class="form-control"
                        value="{{ request('key_search') }}"
                        placeholder="Nhập tên sản phẩm hoặc mã sản phẩm..."
                    >
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary w-100">
                        Tìm kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <form action="{{ route('catalog_v1.flashsales.items.store', $flashSale->id) }}" method="POST">
        @csrf

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <h5 class="mb-1">Danh sách sản phẩm có thể thêm</h5>
                        <div class="text-muted small">
                            Tích chọn sản phẩm, nhập giá Flash Sale và số lượng rồi bấm thêm vào phiên.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        + Thêm sản phẩm đã chọn
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle fs-table-fixed">
                        <thead>
                            <tr>
                                <th style="width: 55px;">Chọn</th>
                                <th style="width: 90px;">Ảnh</th>
                                <th>Sản phẩm</th>
                                <th style="width: 150px;">Giá gốc</th>
                                <th style="width: 170px;">Giá Flash</th>
                                <th style="width: 140px;">Số lượng</th>
                                <th style="width: 110px;">Đã có</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($listData as $product)
                                @php
                                    $productName = $product->full_name ?: $product->name;
                                    $productImage = $product->img_avatar;

                                    if ($productImage && !\Illuminate\Support\Str::startsWith($productImage, ['http://', 'https://'])) {
                                        $productImage = asset($productImage);
                                    }

                                    if (!$productImage) {
                                        $productImage = asset('phuonganh/img/fl1.jpg');
                                    }

                                    $basePrice = $product->price_sale && $product->price_sale > 0
                                        ? $product->price_sale
                                        : $product->price;

                                    $suggestFlashPrice = $basePrice && $basePrice > 0
                                        ? round($basePrice * 0.9)
                                        : 0;

                                    $existed = isset($existMap[$product->id]);
                                @endphp

                                <tr class="fs-product-row">
                                    <td class="text-center">
                                        <input
                                            type="checkbox"
                                            name="product_ids[]"
                                            value="{{ $product->id }}"
                                            class="form-check-input"
                                            {{ $existed ? 'checked' : '' }}
                                        >
                                    </td>

                                    <td>
                                        <div class="fs-item-thumb">
                                            <img src="{{ $productImage }}" alt="{{ $productName }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="fs-item-title">{{ $productName }}</div>
                                        <div class="fs-item-sub">
                                            ID: {{ $product->id }}
                                            @if(!empty($product->code_product_kiovet))
                                                · Mã: {{ $product->code_product_kiovet }}
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        @if($basePrice > 0)
                                            <div class="fs-price">{{ number_format($basePrice, 0, ',', '.') }}đ</div>
                                        @else
                                            <span class="text-muted">Chưa có giá</span>
                                        @endif
                                    </td>

                                    <td>
                                        <input
                                            type="number"
                                            name="items[{{ $product->id }}][flash_price]"
                                            class="form-control"
                                            value="{{ $suggestFlashPrice }}"
                                            min="0"
                                        >
                                    </td>

                                    <td>
                                        <input
                                            type="number"
                                            name="items[{{ $product->id }}][quantity]"
                                            class="form-control"
                                            value="10"
                                            min="0"
                                        >
                                    </td>

                                    <td>
                                        @if($existed)
                                            <span class="badge bg-success">Đã có</span>
                                        @else
                                            <span class="badge bg-light text-dark">Chưa thêm</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Không tìm thấy sản phẩm.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $listData->onEachSide(1)->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </form>

<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Sản phẩm đang có trong Flash Sale</h5>

        <div class="table-responsive">
            <table class="table table-bordered align-middle fs-table-fixed">
                <thead>
                    <tr>
                        <th style="width: 95px;">Ảnh item</th>
                        <th>Thông tin item Flash Sale</th>
                        <th style="width: 140px;">Giá Flash</th>
                        <th style="width: 110px;">Số lượng</th>
                        <th style="width: 100px;">Đã bán</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 190px;">Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($items as $item)
                        @php
                            $product = $productsMap[$item->product_id] ?? null;

                            $productName = $product['full_name'] ?? $product['name'] ?? 'Không tìm thấy sản phẩm gốc';
                            $productImage = $product['img_avatar'] ?? null;

                            $displayName = $item->item_name ?: $productName;
                            $displayImage = $item->item_image ?: $productImage;

                            if ($displayImage && !\Illuminate\Support\Str::startsWith($displayImage, ['http://', 'https://'])) {
                                $displayImage = asset($displayImage);
                            }

                            if (!$displayImage) {
                                $displayImage = asset('phuonganh/img/fl1.jpg');
                            }

                            $originalPrice = $product['price_sale'] ?? $product['price'] ?? 0;
                        @endphp

                        <tr>
                            <td>
                                <div style="width:76px;height:76px;border-radius:16px;overflow:hidden;background:#f1f5f9;border:1px solid #e5e7eb;">
                                    <img src="{{ $displayImage }}"
                                         alt="{{ $displayName }}"
                                         style="width:100%;height:100%;object-fit:cover;display:block;">
                                </div>
                            </td>

                            <td>
                                <div style="font-weight:800;color:#111827;line-height:1.45;">
                                    {{ $displayName }}
                                </div>

                                <div style="font-size:13px;color:#6b7280;line-height:1.5;margin-top:4px;">
                                    Sản phẩm gốc: {{ $productName }}
                                </div>

                                <div style="font-size:13px;color:#6b7280;line-height:1.5;margin-top:2px;">
                                    Product ID: {{ $item->product_id }} · Item ID: {{ $item->id }}
                                </div>

                                @if(!empty($item->item_image))
                                    <div style="margin-top:8px;">
                                        <span class="badge bg-info">Đang dùng ảnh riêng</span>
                                    </div>
                                @endif
                            </td>

                            <td>
                                <div style="font-weight:800;color:#0ea5c6;">
                                    {{ number_format($item->flash_price, 0, ',', '.') }}đ
                                </div>

                                @if($originalPrice > 0)
                                    <div style="font-size:13px;color:#94a3b8;text-decoration:line-through;">
                                        {{ number_format($originalPrice, 0, ',', '.') }}đ
                                    </div>
                                @endif
                            </td>

                            <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>

                            <td>{{ number_format($item->sold, 0, ',', '.') }}</td>

                            <td>
                                @if($item->status == 1)
                                    <span class="badge bg-success">ON</span>
                                @else
                                    <span class="badge bg-danger">OFF</span>
                                @endif
                            </td>

                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditItem{{ $item->id }}"
                                >
                                    Sửa item
                                </button>

                                <a
                                    href="{{ route('catalog_v1.flashsales.items.destroy', [$flashSale->id, $item->id]) }}"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Xóa sản phẩm này khỏi Flash Sale?')"
                                >
                                    Xóa
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Chưa có sản phẩm nào trong Flash Sale.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

    @foreach($items as $item)
        @php
            $product = $productsMap[$item->product_id] ?? null;

            $productName = $product['full_name'] ?? $product['name'] ?? 'Không tìm thấy sản phẩm gốc';
            $productImage = $product['img_avatar'] ?? null;

            $displayName = $item->item_name ?: $productName;
            $displayImage = $item->item_image ?: $productImage;

            if ($displayImage && !\Illuminate\Support\Str::startsWith($displayImage, ['http://', 'https://'])) {
                $displayImage = asset($displayImage);
            }

            if (!$displayImage) {
                $displayImage = asset('phuonganh/img/fl1.jpg');
            }
        @endphp

        <div class="modal fade" id="modalEditItem{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <form
                    action="{{ route('catalog_v1.flashsales.items.update', [$flashSale->id, $item->id]) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="modal-content"
                >
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật item Flash Sale</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label">Ảnh đang hiển thị</label>
                                <div class="fs-image-preview">
                                    <img src="{{ $displayImage }}" alt="{{ $displayName }}">
                                </div>

                                <div class="fs-form-note">
                                    Ảnh này chỉ dùng cho Flash Sale. Không làm thay đổi ảnh gốc của sản phẩm.
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Tên item Flash Sale</label>
                                    <input
                                        type="text"
                                        name="item_name"
                                        class="form-control"
                                        value="{{ $displayName }}"
                                        placeholder="Nhập tên hiển thị riêng trong Flash Sale"
                                    >
                                    <div class="fs-form-note">
                                        Tên này chỉ dùng trong Flash Sale. Sản phẩm gốc vẫn giữ nguyên tên ban đầu.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Upload ảnh item Flash Sale</label>
                                    <input
                                        type="file"
                                        name="item_image"
                                        class="form-control"
                                        accept="image/*"
                                    >
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Giá Flash</label>
                                        <input
                                            type="number"
                                            name="flash_price"
                                            class="form-control"
                                            value="{{ $item->flash_price }}"
                                            min="0"
                                            required
                                        >
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Số lượng</label>
                                        <input
                                            type="number"
                                            name="quantity"
                                            class="form-control"
                                            value="{{ $item->quantity }}"
                                            min="0"
                                            required
                                        >
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Đã bán</label>
                                        <input
                                            type="number"
                                            name="sold"
                                            class="form-control"
                                            value="{{ $item->sold }}"
                                            min="0"
                                        >
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Trạng thái</label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>ON</option>
                                            <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>OFF</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="alert alert-info mt-3 mb-0">
                                    <strong>Sản phẩm gốc:</strong> {{ $productName }} <br>
                                    <strong>Product ID:</strong> {{ $item->product_id }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">
                            Hủy
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Lưu cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('script')
<script>
    $(function () {
        $('input[name="product_ids[]"]').on('change', function () {
            const row = $(this).closest('tr');

            if ($(this).is(':checked')) {
                row.addClass('table-success');
            } else {
                row.removeClass('table-success');
            }
        });

        $('input[name="product_ids[]"]:checked').each(function () {
            $(this).closest('tr').addClass('table-success');
        });
    });
</script>
@endsection