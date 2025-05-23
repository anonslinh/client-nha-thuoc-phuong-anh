@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Thêm voucher</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a class="text-muted text-decoration-none d-flex">
                                        <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{route('voucher.store')}}" method="post" class="w-100" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tên</label>
                        <input class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hình ảnh(Tỷ lệ 2:1 1000x500px)</label>
                        <input class="form-control" type="file" accept="image/png" name="image" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Điểm quy đổi</label>
                        <input class="form-control" name="points_required" type="number" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số tiền</label>
                        <input class="form-control" name="discount_amount" type="number" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày hết hạn</label>
                        <input class="form-control" name="expiry_date" type="date" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mã phát hành voucher theo tài khoản</label>
                        <div class="list-branch table-responsive">
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên chi nhánh</th>
                                    <th>Mã phát hành</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($account_branches as $key => $value)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$value->code}}</td>
                                        <td>
                                            <input name="branch[{{$key}}][code]" value="{{$value->code}}" hidden>
                                            <input name="branch[{{$key}}][release_code]" type="text" class="form-control releaseCode">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hạng thẻ</label>
                        <select name="rank_id" class="form-control">
                            <option value="">Áp dụng cho tất hạng</option>
                            @foreach($rank as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea id="mymce" name="description" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-primary">Tạo mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="assets/libs/tinymce/tinymce.min.js"></script>
    <script src="assets/js/forms/tinymce-init.js"></script>
@endsection
