@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <h4 class="mb-0 card-title">Quản lý popup thử nghiệm</h4>

        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
        @if($errors->any())
            <div class="alert alert-danger mt-3 mb-0">
                @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <p class="text-muted">
                Popup này hiển thị trên <strong>trang chủ phiên bản mobile</strong>, thông báo cho khách hàng biết
                website đang trong giai đoạn thử nghiệm và mời khách góp ý qua Zalo.
            </p>

            <form action="{{ route('catalog_v1.popup_test.update') }}" method="post" class="mt-3">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tiêu đề popup</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $title) }}"
                           placeholder="VD: Website đang trong giai đoạn thử nghiệm" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nội dung mô tả</label>
                    <textarea name="description" class="form-control" rows="4" required
                              placeholder="Nội dung hiển thị bên dưới tiêu đề...">{{ old('description', $description) }}</textarea>
                </div>

                <hr>

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="enabledSwitch"
                           name="enabled" value="1" {{ old('enabled', $enabled) ? 'checked' : '' }}>
                    <label class="form-check-label" for="enabledSwitch">
                        <strong>Bật popup thử nghiệm</strong>
                        <div class="text-muted small">Tắt thì popup sẽ không hiển thị trên trang chủ.</div>
                    </label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="alwaysShowSwitch"
                           name="always_show" value="1" {{ old('always_show', $alwaysShow) ? 'checked' : '' }}>
                    <label class="form-check-label" for="alwaysShowSwitch">
                        <strong>Luôn hiển thị lại</strong>
                        <div class="text-muted small">
                            <u>Bật</u>: popup hiện lại ở <strong>mỗi lần</strong> khách truy cập/tải lại trang chủ
                            (ẩn nút "Không hiển thị lại").<br>
                            <u>Tắt</u>: hiện nút "Không hiển thị lại" — khách bấm thì sẽ không thấy popup ở các lần sau.
                        </div>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i> Lưu cấu hình
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
