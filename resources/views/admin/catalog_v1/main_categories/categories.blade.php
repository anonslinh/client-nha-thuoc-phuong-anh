@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <div>
                <h4 class="mb-1 card-title">Danh mục con</h4>
                <div class="text-muted">{{ $mainCategory->name }}</div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('catalog_v1.main_categories.attach.page',$mainCategory->id) }}" class="btn btn-info">Gán thêm danh mục</a>
                <a href="{{ route('catalog_v1.main_categories.index') }}" class="btn btn-danger">Quay lại</a>
            </div>
        </div>

        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('catalog_v1.main_categories.categories',$mainCategory->id) }}" method="get" class="row">
                <div class="col-md-4 mb-2">
                    <input name="key_search" class="form-control" placeholder="Tìm theo tên danh mục con..."
                           value="{{ request('key_search') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary" style="margin-right:10px">Tìm kiếm</button>
                    <a href="{{ route('catalog_v1.main_categories.categories',$mainCategory->id) }}" class="btn btn-danger">Hủy</a>
                </div>
            </form>

            <form method="post" action="{{ route('catalog_v1.main_categories.detach',$mainCategory->id) }}" id="detachForm">
                @csrf

                <div class="row mt-3">
                    @forelse($listData as $row)
                        @php
                            $img = $row->img ? (\Illuminate\Support\Str::startsWith($row->img,'http') ? $row->img : asset($row->img)) : null;
                        @endphp

                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card h-100 shadow-sm border-0" style="border-radius:18px;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input rowCheck" type="checkbox" name="category_ids[]" value="{{ $row->id }}">
                                            <label class="form-check-label fw-semibold">Chọn</label>
                                        </div>
                                        <span class="badge bg-secondary">Sort: {{ $row->sort_order }}</span>
                                    </div>

                                    <div class="d-flex gap-3">
                                        <div style="width:82px;flex:0 0 82px;">
                                            @if($img)
                                                <img src="{{ $img }}" style="width:82px;height:82px;object-fit:cover;border-radius:16px;">
                                            @else
                                                <div style="width:82px;height:82px;border-radius:16px;background:#f2f5f9;display:flex;align-items:center;justify-content:center;color:#999;">
                                                    No image
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex-grow-1">
                                            <h5 class="mb-1 fw-semibold">{{ $row->name }}</h5>
                                            @if($row->description)
                                                <div class="text-muted small" style="line-height:1.7;">
                                                    {{ \Illuminate\Support\Str::limit($row->description, 90) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-danger text-center">Chưa có danh mục con nào</p>
                        </div>
                    @endforelse
                </div>

                @if($listData->count() > 0)
                    <button class="btn btn-danger">Gỡ danh mục đã chọn</button>
                @endif
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
$(function(){
    $('#detachForm').on('submit', function(e){
        if($('.rowCheck:checked').length === 0){
            e.preventDefault();
            alert('Vui lòng chọn ít nhất 1 danh mục để gỡ.');
        }
    });
});
</script>
@endsection