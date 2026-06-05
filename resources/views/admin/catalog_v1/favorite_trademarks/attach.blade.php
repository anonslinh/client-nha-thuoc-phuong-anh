@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <h4 class="mb-0 card-title">Chọn thương hiệu yêu thích (từ trademark_v1)</h4>
            <a href="{{ route('catalog_v1.favorite_trademarks.index') }}" class="btn btn-danger">Quay lại</a>
        </div>
        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{session('success')}}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{session('error')}}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">

            <form method="get" class="row" action="{{ route('catalog_v1.favorite_trademarks.attach.page') }}">
                <div class="col-md-4 mb-2">
                    <input name="key_search" class="form-control" placeholder="Tìm theo tên thương hiệu..."
                           value="{{ request('key_search') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
                    <a class="btn btn-danger" href="{{ route('catalog_v1.favorite_trademarks.attach.page') }}">Hủy</a>
                </div>
            </form>

            <div class="row mb-2">
                <div class="col-md-3">
                    <label class="form-label">Default mô tả ngắn</label>
                    <input class="form-control" id="default_desc" placeholder="VD: Giảm đến 20%">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Default sort</label>
                    <input class="form-control" id="default_sort" placeholder="VD: 1">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-primary" id="applyDefault">Áp dụng cho dòng đã tick</button>
                </div>
            </div>

            <form method="post" action="{{ route('catalog_v1.favorite_trademarks.attach.store') }}" id="addForm">
                @csrf

                <div class="table-responsive mt-3">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:60px"><input type="checkbox" id="checkAll"></th>
                                <th>Thương hiệu</th>
                                <th style="width:280px">Mô tả ngắn</th>
                                <th style="width:120px">Sort</th>
                                <th>Đã có?</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($listData->total() > 0)
                            @foreach($listData as $t)
                                @php
                                    $already = isset($existMap[$t->id]);
                                    $logo = $t->img ?? null;
                                    $logoSrc = $logo ? (\Illuminate\Support\Str::startsWith($logo,'http') ? $logo : asset($logo)) : null;
                                @endphp
                                <tr class="{{ $already ? 'table-secondary' : '' }}">
                                    <td class="text-center align-middle">
                                        <input type="checkbox" class="rowCheck" name="trademark_ids[]" value="{{ $t->id }}" {{ $already ? 'disabled' : '' }}>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($logoSrc)
                                                <img src="{{ $logoSrc }}" style="width:44px;height:44px;border-radius:12px;object-fit:cover;">
                                            @endif
                                            <div>
                                                <b>{{ $t->name ?? '-' }}</b><br>
                                                <span class="text-muted">ID: {{ $t->id }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <input class="form-control descInput" name="items[{{ $t->id }}][short_desc]" placeholder="VD: Giảm đến 20%" {{ $already ? 'disabled' : '' }}>
                                    </td>
                                    <td class="align-middle">
                                        <input class="form-control sortInput" name="items[{{ $t->id }}][sort_order]" placeholder="0" {{ $already ? 'disabled' : '' }}>
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
                            <tr><td colspan="5" class="text-danger text-center">Không có dữ liệu</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                <button class="btn btn-primary">
                    <i class="ti ti-download me-1"></i> Thêm thương hiệu yêu thích
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
        const desc = $('#default_desc').val();
        const sort = $('#default_sort').val();

        $('.rowCheck:checked').each(function(){
            const tr = $(this).closest('tr');
            if(desc) tr.find('.descInput').val(desc);
            if(sort) tr.find('.sortInput').val(sort);
        });
    });

    $('#addForm').on('submit', function(e){
        if ($('.rowCheck:checked').length === 0) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất 1 thương hiệu.');
        }
    });
});
</script>
@endsection