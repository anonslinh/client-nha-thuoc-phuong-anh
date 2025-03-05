@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Cài đặt đánh giá đơn hàng</h4>
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
                <form action="{{route('config.update-point-order-review',$data->id)}}" method="post" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-4">
                            <label class="form-label" for="name">Điểm mặc định</label>
                            <input type="number" class="form-control" value="{{$data->default_kpi}}" readonly>
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label" for="name">Min KPI</label>
                            <input type="number" class="form-control" value="{{$data->min_kpi}}" readonly>
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label" for="name">Max KPI</label>
                            <input type="number" class="form-control" value="{{$data->max_kpi}}" readonly>
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label" for="name">Số hóa đơn cần đánh giá</label>
                            <input type="number" class="form-control" name="orders_required" value="{{$data->orders_required}}">
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label" for="name">Giá trị tối thiểu hóa đơn</label>
                            <input type="number" class="form-control" name="min_order_value" value="{{$data->min_order_value}}">
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label" for="name">Điểm thưởng</label>
                            <input type="number" class="form-control" name="reward_points" value="{{$data->reward_points}}">
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label" for="name">Ngày bắt đầu tính đánh giá</label>
                            <input type="date" class="form-control" name="cutoff_date" value="{{$data->cutoff_date}}">
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label" for="name">⭐1 sao</label>
                            <input type="number" class="form-control" name="star_1" value="{{$data->star_1}}">
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label" for="name">⭐2 sao</label>
                            <input type="number" class="form-control" name="star_2" value="{{$data->star_2}}">
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label" for="name">⭐3 sao</label>
                            <input type="number" class="form-control" name="star_3" value="{{$data->star_3}}">
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label" for="name">⭐4 sao</label>
                            <input type="number" class="form-control" name="star_4" value="{{$data->star_4}}">
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label" for="name">⭐5 sao</label>
                            <input type="number" class="form-control" name="star_5" value="{{$data->star_5}}">
                        </div>
                        <div class="mb-3 col-md-12 hstack gap-6">
                            <button class="btn btn-primary hstack gap-6" type="submit">
                                <i class="ti ti-send fs-5"></i>
                                Cập nhật
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2 class="mb-3">📧 1. Tần suất gửi email</h2>
                <div class="alert alert-info">
                    💡 Chủ cửa hàng sẽ nhận email theo nhóm nhân viên, không gửi riêng lẻ từng người.
                </div>

                <table class="table table-bordered text-center">
                    <thead class="table-light">
                    <tr>
                        <th>KPI của nhân viên</th>
                        <th>Tần suất gửi email</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>< 40</td>
                        <td class="text-danger">📩 Gửi ngay lập tức, sau đó cứ 3 ngày gửi lại nếu vẫn dưới 40</td>
                    </tr>
                    <tr>
                        <td>40 ≤ KPI < 60</td>
                        <td>📩 Gửi 3 ngày/lần nếu vẫn dưới 60</td>
                    </tr>
                    <tr>
                        <td>60 ≤ KPI < 70</td>
                        <td>📩 Gửi 7 ngày/lần nếu vẫn dưới 70</td>
                    </tr>
                    <tr>
                        <td>≥ 70</td>
                        <td class="text-success">✅ Không gửi email</td>
                    </tr>
                    <tr>
                        <td>Báo Cáo Cuối Tháng – Hiệu Suất Nhân Viên</td>
                        <td>📩 Đúng 23h ngày cuối tháng, hệ thống sẽ tự động gửi email tổng kết, cung cấp danh sách nhân viên kèm theo điểm KPI và thống kê chi tiết số lần nhận đánh giá từ 1 đến 5 sao.</td>
                    </tr>
                    </tbody>
                </table>

                <h2 class="mt-4 mb-3">⚠️ 2. Gửi email khi có hóa đơn dưới 3 sao</h2>
                <div class="alert alert-warning">
                    ⚠️ Nếu khách hàng đánh giá hóa đơn dưới <strong>3 sao</strong>, email sẽ được gửi ngay lập tức đến quản lý cửa hàng.
                </div>
                <h2 class="mt-4 mb-3">⭐ 3.️ Chương Trình Thưởng Khi Đánh Giá Đơn Hàng</h2>

                <p><strong>📅 Thời gian áp dụng:</strong> Bắt đầu từ ngày mini app hoạt động (<em>Ví dụ: 08/03/2024</em>).</p>
                <p><strong>💰 Điều kiện:</strong> Chỉ áp dụng cho hóa đơn từ <strong>(Ví dụ: 0 VNĐ)</strong> trở lên.</p>

                <h3>📈 Cách tính điểm</h3>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Điều Kiện</th>
                        <th>Điểm Thưởng</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Mỗi 10 hóa đơn hợp lệ được đánh giá</td>
                        <td>+1 điểm</td>
                    </tr>
                    <tr>
                        <td>Hệ thống tự động kiểm tra và cộng điểm khi đạt đủ số lượng</td>
                        <td>✔️</td>
                    </tr>
                    <tr>
                        <td>Không tính lẻ (Ví dụ: 9 hóa đơn không được cộng điểm)</td>
                        <td>❌</td>
                    </tr>
                    </tbody>
                </table>

                <h3>📊 Các chỉ số có thể cài đặt</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Chỉ số</th>
                        <th>Giá trị</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Ngày bắt đầu chương trình</td>
                        <td>08/03/2024 (hoặc tùy chỉnh)</td>
                    </tr>
                    <tr>
                        <td>Số lượng hóa đơn yêu cầu</td>
                        <td>10 hóa đơn (có thể điều chỉnh)</td>
                    </tr>
                    <tr>
                        <td>Giá trị tối thiểu của hóa đơn</td>
                        <td>0 VNĐ (có thể điều chỉnh)</td>
                    </tr>
                    <tr>
                        <td>Số điểm nhận được</td>
                        <td>+1 điểm / 10 hóa đơn (có thể thay đổi)</td>
                    </tr>
                    </tbody>
                </table>

                <h3>📢 Lưu ý</h3>
                <ul>
                    <li>Chỉ tính hóa đơn từ ngày <strong>Ngày cài đặt</strong> trở đi.</li>
                    <li>Mỗi hóa đơn chỉ được tính điểm <strong>một lần duy nhất</strong>.</li>
                    <li><strong>Hệ thống sẽ tự động cập nhật</strong> số điểm trên ứng dụng khách hàng.</li>
                </ul>
            </div>
        </div>

        <!-- Gợi ý cách tính điểm KPI -->
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="mb-3">📌 Gợi Ý Cách Tính Điểm KPI Công Bằng và Hiệu Quả</h2>

                <h3 class="mt-4">🎯 1️⃣ Điểm Mặc Định</h3>
                <p>Mỗi nhân viên bắt đầu với <strong>70 điểm</strong> mỗi tháng.</p>
                <ul>
                    <li>Không phân biệt nhân viên cũ hay mới để đảm bảo công bằng.</li>
                    <li>Điểm KPI reset hàng tháng để đánh giá chính xác chất lượng dịch vụ.</li>
                </ul>

                <h3 class="mt-4">⭐ 2️⃣ Cách Tính Điểm Khi Nhận Đánh Giá</h3>
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                    <tr>
                        <th>Số sao khách hàng đánh giá</th>
                        <th>Điểm thay đổi</th>
                        <th>Lý do</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>⭐⭐⭐⭐⭐ (5 sao)</td>
                        <td class="text-success">+3 điểm</td>
                        <td>Tạo động lực phục vụ tốt hơn nhưng tránh buff điểm quá nhanh.</td>
                    </tr>
                    <tr>
                        <td>⭐⭐⭐⭐ (4 sao)</td>
                        <td>+1 điểm</td>
                        <td>Dịch vụ ổn vẫn được cộng nhẹ để khuyến khích nhân viên.</td>
                    </tr>
                    <tr>
                        <td>⭐⭐⭐ (3 sao)</td>
                        <td class="text-warning">-3 điểm</td>
                        <td>Dịch vụ trung bình, cần cải thiện.</td>
                    </tr>
                    <tr>
                        <td>⭐⭐ (2 sao)</td>
                        <td class="text-danger">-7 điểm</td>
                        <td>Dịch vụ kém, cần có cảnh báo.</td>
                    </tr>
                    <tr>
                        <td>⭐ (1 sao)</td>
                        <td class="text-danger">-12 điểm</td>
                        <td>Trải nghiệm tệ, cần xử lý mạnh.</td>
                    </tr>
                    </tbody>
                </table>

                <h3 class="mt-4">📉 3️⃣ Giới Hạn Điểm (Min - Max)</h3>
                <p>🔹 <strong>Tối đa:</strong> 120 điểm → Ngăn nhân viên tích điểm quá cao.</p>
                <p>🔻 <strong>Tối thiểu:</strong> 30 điểm → Nếu dưới 30, cần đào tạo lại hoặc xem xét sa thải.</p>

                <h3 class="mt-4">📊 4️⃣ Xếp Loại Nhân Viên Theo Điểm KPI</h3>
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                    <tr>
                        <th>Khoảng điểm KPI</th>
                        <th>Xếp loại</th>
                        <th>Hành động quản lý</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>≥ 120 điểm</td>
                        <td class="text-success">🌟 Xuất sắc</td>
                        <td>Thưởng nóng, xét tăng lương, ưu tiên thăng chức.</td>
                    </tr>
                    <tr>
                        <td>90 - 119 điểm</td>
                        <td>✅ Tốt</td>
                        <td>Nhận lời khen, có thể được ưu tiên ca làm tốt hơn.</td>
                    </tr>
                    <tr>
                        <td>60 - 89 điểm</td>
                        <td>🔹 Đạt yêu cầu</td>
                        <td>Giữ mức lương và công việc ổn định.</td>
                    </tr>
                    <tr>
                        <td>30 - 59 điểm</td>
                        <td class="text-warning">⚠ Cảnh báo</td>
                        <td>Gặp quản lý để thảo luận, có thể bị giám sát chặt hơn.</td>
                    </tr>
                    <tr>
                        <td>< 30 điểm</td>
                        <td class="text-danger">❌ Kém</td>
                        <td>Nguy cơ đình chỉ hoặc sa thải.</td>
                    </tr>
                    </tbody>
                </table>

                <h3 class="mt-4">🏆 5️⃣ Chính Sách Thưởng & Phạt</h3>
                <ul>
                    <li>✔ <strong>Nhân viên đạt từ 100 điểm trở lên:</strong> Thưởng tiền mặt, xét tăng lương nếu duy trì 3 tháng liên tiếp.</li>
                    <li>✔ <strong>Nhân viên xuất sắc trên 120 điểm:</strong> Xét tăng lương sớm, ưu tiên thăng chức.</li>
                    <li>🚨 <strong>Nhân viên dưới 50 điểm:</strong> Bị cảnh báo, cần cải thiện.</li>
                    <li>⚠ <strong>Nhân viên dưới 30 điểm:</strong> Bắt buộc đào tạo lại, có nguy cơ đình chỉ nếu duy trì dưới 30 điểm trong 2 tháng.</li>
                </ul>

                <h3 class="mt-4">✅ 6️⃣ Kết Luận</h3>
                <p>🚀 Hệ thống KPI giúp:</p>
                <ul>
                    <li>Đảm bảo công bằng giữa nhân viên cũ và mới.</li>
                    <li>Tạo động lực phát triển nhưng vẫn kiểm soát chặt chẽ chất lượng dịch vụ.</li>
                    <li>Reset điểm hàng tháng để tránh chênh lệch không công bằng.</li>
                    <li>Nhân viên dưới 30 điểm là mức báo động đỏ cần xử lý.</li>
                    <li>Nhân viên trên 100 điểm có cơ hội nhận thưởng hoặc tăng lương.</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
