@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <div>
                <h4 class="mb-1 card-title">Thêm sản phẩm vào thông tin nổi bật</h4>
                <div class="text-muted">{{ $item->seo_title }}</div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('catalog_v1.text_seo_header.products',$item->id) }}" class="btn btn-primary">DS sản phẩm</a>
                <a href="{{ route('catalog_v1.text_seo_header.index') }}" class="btn btn-danger">Quay lại</a>
            </div>
        </div>
        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">
            <form method="get" class="row" action="{{ route('catalog_v1.text_seo_header.attach.page',$item->id) }}">
                <div class="col-md-4 mb-2">
                    <input name="key_search" class="form-control" placeholder="Tên, full name, code kiot..."
                           value="{{ request('key_search') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
                    <a class="btn btn-danger" href="{{ route('catalog_v1.text_seo_header.attach.page',$item->id) }}">Hủy</a>
                </div>
            </form>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Default sort</label>
                    <input class="form-control" id="default_sort" placeholder="VD: 1">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-primary" id="applyDefault">Áp dụng cho item đã tick</button>
                </div>
            </div>

            <form method="post" action="{{ route('catalog_v1.text_seo_header.attach.store',$item->id) }}" id="addForm">
                @csrf

                <div class="row">
                    @forelse($listData as $p)
                        @php
                            $already = isset($existMap[$p->id]);
                            $img = $p->img_avatar;
                            $src = $img ? (\Illuminate\Support\Str::startsWith($img,'http') ? $img : asset($img)) : null;
                        @endphp

                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card h-100 shadow-sm border-0 {{ $already ? 'bg-light' : '' }}" style="border-radius:18px;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input rowCheck"
                                                   type="checkbox"
                                                   name="product_ids[]"
                                                   value="{{ $p->id }}"
                                                   {{ $already ? 'disabled' : '' }}>
                                            <label class="form-check-label fw-semibold">
                                                Chọn sản phẩm
                                            </label>
                                        </div>

                                        @if($already)
                                            <span class="badge bg-secondary">Đã có</span>
                                        @else
                                            <span class="badge bg-info">Chưa có</span>
                                        @endif
                                    </div>

                                    <div class="d-flex gap-3">
                                        <div style="width:96px; flex:0 0 96px;">
                                            @if($src)
                                                <img src="{{ $src }}" style="width:96px;height:96px;border-radius:14px;object-fit:cover;">
                                            @else
                                                <div style="width:96px;height:96px;border-radius:14px;background:#f0f3f7;display:flex;align-items:center;justify-content:center;color:#999;">
                                                    No image
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex-grow-1">
                                            <h6 class="fw-semibold mb-1" style="line-height:1.4;">{{ $p->name ?? '-' }}</h6>
                                            <div class="small text-muted mb-1">{{ $p->full_name ?? '' }}</div>
                                            <div class="small text-muted mb-1">Code: {{ $p->code_product_kiovet ?? '-' }}</div>
                                            <div class="small text-primary">
                                                Giá: {{ $p->price ? number_format($p->price).'đ' : '-' }}
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="mb-2">
                                        <label class="form-label">Sort order</label>
                                        <input class="form-control sortInput"
                                               name="items[{{ $p->id }}][sort_order]"
                                               placeholder="0"
                                               {{ $already ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-danger text-center">Không có dữ liệu</p>
                        </div>
                    @endforelse
                </div>

                <button class="btn btn-primary">
                    <i class="ti ti-download me-1"></i> Thêm sản phẩm
                </button>

                <div class="d-flex justify-content-center mt-3">
                    {{ $listData->appends(request()->all())->links('pagination') }}
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(function(){
    $('#applyDefault').click(function(){
        const sort = $('#default_sort').val();

        $('.rowCheck:checked').each(function(){
            const card = $(this).closest('.card-body');
            if(sort) card.find('.sortInput').val(sort);
        });
    });

    $('#addForm').on('submit', function(e){
        if ($('.rowCheck:checked').length === 0) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất 1 sản phẩm.');
        }
    });
});
</script>
@endsection