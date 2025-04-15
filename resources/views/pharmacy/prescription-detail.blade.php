@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Gửi đơn thuốc, hình ảnh</h4>
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

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="px-4 py-3 border-bottom">
                        <h4 class="card-title mb-0">Thông tin</h4>
                    </div>
                    <div class="card-body p-4 row">
                        <div class="mb-4 col-4">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" value="{{$data->full_name}}" readonly>
                        </div>
                        <div class="mb-4 col-4">
                            <label class="form-label">Tuổi</label>
                            <input type="text" class="form-control" value="{{$data->age}}" readonly>
                        </div>
                        <div class="mb-4 col-4">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" value="{{$data->phone}}" readonly>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" value="{{$data->address}}" readonly>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Ghi chú dành cho Dược sỹ:</label>
                            <textarea class="form-control" style="height: 150px" readonly>{{$data->note}}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Hình ảnh:</label>
                            <div>
                                @php
                                    $images = is_array(json_decode($data->image)) ? json_decode($data->image) : [$data->image];
                                @endphp

                                @foreach ($images as $img)
                                    <a href="{{ asset($img) }}" target="_blank">
                                        <img src="{{ asset($img) }}" alt="Đơn thuốc" style="width: 100%; max-width: 100%; height: auto; object-fit: cover; border-radius: 8px; border: 1px solid #ccc; margin-bottom: 10px;">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
