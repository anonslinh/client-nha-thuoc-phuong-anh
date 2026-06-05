@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="d-sm-flex align-items-center justify-space-between">
            <div>
                <h4 class="mb-1 card-title">Cài đặt danh mục KiotViet</h4>
                <div class="text-muted">Danh mục hệ thống: {{ $category->name }}</div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('catalog_v1.categories.products',$category->id) }}" class="btn btn-primary">
                    DS sản phẩm
                </a>
                <a href="{{ route('catalog_v1.categories.index') }}" class="btn btn-danger">
                    Quay lại
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('catalog_v1.categories.attach.kiot.store',$category->id) }}" id="attachKiotForm">
                @csrf

                <div class="mb-3">
                    <div class="alert alert-info mb-0">
                        <b>Cài đặt lại mapping danh mục KiotViet</b> cho danh mục hệ thống <b>{{ $category->name }}</b>.
                        <br>- Danh mục nào đang map sẽ được tick sẵn
                        <br>- Bỏ tick = ngừng map danh mục đó
                        <br>- Tick thêm = thêm danh mục Kiot mới
                        <br>- Sau khi lưu, hệ thống sẽ đồng bộ lại sản phẩm theo cấu hình mới
                    </div>
                </div>

                <div class="row">
                    @forelse($listData as $row)
                        @php
                            $kiotCategoryId = $row['categoryId'] ?? null;
                            $kiotCategoryName = $row['categoryName'] ?? 'Danh mục KiotViet';
                            $isSelected = in_array((string)$kiotCategoryId, $selectedMap ?? []);
                        @endphp

                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card h-100 shadow-sm border-0 {{ $isSelected ? 'bg-light' : '' }}" style="border-radius:18px;">
                                <div class="card-body">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input rowCheck"
                                               type="checkbox"
                                               name="kiot_category_ids[]"
                                               value="{{ $kiotCategoryId }}"
                                               id="kiot_{{ $kiotCategoryId }}"
                                               {{ $isSelected ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="kiot_{{ $kiotCategoryId }}">
                                            {{ $isSelected ? 'Đang map' : 'Chọn danh mục' }}
                                        </label>
                                    </div>

                                    <h5 class="fw-semibold mb-2">{{ $kiotCategoryName }}</h5>
                                    <div class="small text-muted mb-1">Kiot Category ID: {{ $kiotCategoryId }}</div>

                                    @if(!empty($row['parentId']))
                                        <div class="small text-muted">Parent ID: {{ $row['parentId'] }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-danger text-center">Không có danh mục KiotViet</p>
                        </div>
                    @endforelse
                </div>

                @if($listData->count() > 0)
                    <button class="btn btn-warning">
                        Lưu cấu hình Kiot và đồng bộ
                    </button>
                @endif

                <div class="d-flex justify-content-center mt-3">
                    {{ $listData->appends(request()->all())->links('pagination') }}
                </div>
            </form>
        </div>
    </div>
</div>
@endsection