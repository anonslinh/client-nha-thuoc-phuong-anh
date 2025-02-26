<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh giá hóa đơn</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { max-width: 150px; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 8px; border-bottom: 1px solid #ddd; }
        .rating { color: #ff9800; font-size: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img style="width: 368px; height: auto;" src="https://baseminiapp.winwingroup.vn/assets/images/logos/logo_win_baby_login.svg" alt="Win Baby Logo"/>
        <h2>Hóa Đơn - Đánh Giá Nguy Hiểm</h2>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Mã Hóa Đơn:</strong></td>
            <td>{{ $invoice->code }}</td>
        </tr>
        <tr>
            <td><strong>Tổng Tiền:</strong></td>
            <td>{{ number_format($invoice->total_payment, 0, ',', '.') }} VND</td>
        </tr>
        <tr>
            <td><strong>Ngày Tạo:</strong></td>
            <td>{{ \Carbon\Carbon::parse($invoice->created_date)->format('H:i d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>Tên Khách Hàng:</strong></td>
            <td>{{ $invoice->customer_name }}</td>
        </tr>
        <tr>
            <td><strong>Số Điện Thoại:</strong></td>
            <td>{{ optional($invoice_rating->customer)->contact_number }}</td>
        </tr>
        <tr>
            <td><strong>Đánh Giá:</strong></td>
            <td class="rating">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $invoice_rating->rating) ★ @else ☆ @endif
                @endfor
            </td>
        </tr>
        <tr>
            <td><strong>Ngày Đánh Giá:</strong></td>
            <td>{{ optional($invoice_rating->created_at)->format('H:i d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>Mã Nhân Viên:</strong></td>
            <td>{{ $invoice->sold_by_id }}</td>
        </tr>
        <tr>
            <td><strong>Tên Nhân Viên:</strong></td>
            <td>{{ $invoice->sold_by_name }}</td>
        </tr>
        <tr>
            <td><strong>Chi Nhánh:</strong></td>
            <td>{{ $invoice->branch_name }}</td>
        </tr>
        <tr>
            <td><strong>Nội dung đánh giá:</strong></td>
            <td>
                <textarea style="width: 100%; height: 100px; padding: 5px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px;" readonly>{{ $invoice_rating->comment }}</textarea>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
