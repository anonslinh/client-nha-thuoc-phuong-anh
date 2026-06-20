@extends('Layout.index')
@section('content')
<div class="container-fluid">
    <div class="card card-body py-3">
        <h4 class="mb-0 card-title">Quản lý popup thử nghiệm</h4>

        @if(session('success')) <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div> @endif
    </div>

    <div class="card">
        <div class="card-body">
            <p class="text-muted">
                Popup này hiển thị trên <strong>trang chủ phiên bản mobile</strong>, thông báo cho khách hàng biết
                website đang trong giai đoạn thử nghiệm và mời khách góp ý qua Zalo. Khách có thể bấm
                "Không hiển thị lại" để ẩn vĩnh viễn trên trình duyệt của họ; nếu không bấm, popup sẽ hiện lại
                ở mỗi lần truy cập / tải lại trang chủ.
            </p>

            <div class="d-flex align-items-center gap-3 mt-3">
                <span class="fw-semibold">Trạng thái hiện tại:</span>

                @if($enabled == 1)
                    <span class="badge bg-success">Đang bật</span>
                @else
                    <span class="badge bg-secondary">Đang tắt</span>
                @endif
            </div>

            <form action="{{ route('catalog_v1.popup_test.update') }}" method="post" class="mt-3">
                @csrf

                @if($enabled == 1)
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-toggle-left me-1"></i> Tắt popup thử nghiệm
                    </button>
                @else
                    <button type="submit" class="btn btn-success">
                        <i class="ti ti-toggle-right me-1"></i> Bật popup thử nghiệm
                    </button>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
