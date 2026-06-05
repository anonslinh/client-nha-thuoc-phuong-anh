<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đặt phòng thành công</title>
  <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/bootstrap.min.css') }}">
</head>
<body class="p-4">
<div class="container">
  <div class="alert alert-success">
    <h4 class="mb-2">✅ Đã ghi nhận yêu cầu đặt phòng!</h4>
    <div>Mã đơn: <b>{{ $booking->code }}</b></div>
    <div>Trạng thái: <b>{{ $booking->status }}</b> (Admin sẽ xác nhận)</div>
  </div>

  <a class="btn btn-primary" href="{{ route('client.rooms.index') }}">Quay lại danh sách phòng</a>
</div>
</body>
</html>
