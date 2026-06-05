@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <h4 class="mb-0 card-title">Chọn sản phẩm bán chạy (từ product_v1)</h4>
            <a href="{{ route('catalog_v1.best_sellers.index') }}" class="btn btn-danger">Quay lại</a>
        </div>
        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{session('success')}}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{session('error')}}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">

            <form method="get" class="row" action="{{ route('catalog_v1.best_sellers.attach.page') }}">
                <div class="col-md-4 mb-2">
                    <input name="key_search" class="form-control" placeholder="Tên, full name, code kiot..."
                           value="{{ request('key_search') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
                    <a class="btn btn-danger" href="{{ route('catalog_v1.best_sellers.attach.page') }}">Hủy</a>
                </div>
            </form>

            <div class="row mb-2">
                <div class="col-md-3">
                    <label class="form-label">Default giá sale</label>
                    <input class="form-control" id="default_price" placeholder="VD: 129000">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Default đơn vị</label>
                    <input class="form-control" id="default_unit" placeholder="VD: chai/lọ/vỉ/chiếc">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Default sort</label>
                    <input class="form-control" id="default_sort" placeholder="VD: 1">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-primary" id="applyDefault">Áp dụng cho dòng đã tick</button>
                </div>
            </div>

            <form method="post" action="{{ route('catalog_v1.best_sellers.attach.store') }}" id="addForm">
                @csrf

                <div class="table-responsive mt-3">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:60px"><input type="checkbox" id="checkAll"></th>
                                <th>Sản phẩm</th>
                                <th style="width:180px">Giá sale</th>
                                <th style="width:160px">Đơn vị</th>
                                <th style="width:120px">Sort</th>
                                <th>Đã có?</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($listData->total() > 0)
                            @foreach($listData as $p)
                                @php $already = isset($existMap[$p->id]); @endphp
                                <tr class="{{ $already ? 'table-secondary' : '' }}">
                                    <td class="text-center align-middle">
                                        <input type="checkbox" class="rowCheck" name="product_ids[]" value="{{ $p->id }}" {{ $already ? 'disabled' : '' }}>
                                    </td>
                                    <td class="align-middle">
                                        <b>{{ $p->name ?? '-' }}</b><br>
                                        <span class="text-muted">{{ $p->full_name ?? '' }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <input class="form-control priceInput" name="items[{{ $p->id }}][sale_price]" placeholder="Giá sale" {{ $already ? 'disabled' : '' }}>
                                    </td>
                                    <td class="align-middle">
                                        <input class="form-control unitInput" name="items[{{ $p->id }}][unit]" placeholder="chai/lọ/vỉ..." {{ $already ? 'disabled' : '' }}>
                                    </td>
                                    <td class="align-middle">
                                        <input class="form-control sortInput" name="items[{{ $p->id }}][sort_order]" placeholder="0" {{ $already ? 'disabled' : '' }}>
                                    </td>
                                    <td class="align-middle">
                                        @if($already)
                                            <span class="badge bg-secondary">Đã có</span>
                                        @else
                                            <span class="badge bg-info">Chưa có</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="6" class="text-danger text-center">Không có dữ liệu</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                <button class="btn btn-primary">
                    <i class="ti ti-download me-1"></i> Thêm sản phẩm bán chạy
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
    $('#checkAll').on('change', function(){
        $('.rowCheck:not(:disabled)').prop('checked', $(this).is(':checked'));
    });

    $('#applyDefault').click(function(){
        const price = $('#default_price').val();
        const unit = $('#default_unit').val();
        const sort = $('#default_sort').val();

        $('.rowCheck:checked').each(function(){
            const tr = $(this).closest('tr');
            if(price) tr.find('.priceInput').val(price);
            if(unit) tr.find('.unitInput').val(unit);
            if(sort) tr.find('.sortInput').val(sort);
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