<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảnh báo KPI Nhân Viên</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
        .header { text-align: center; margin-bottom: 20px; }
        .info-table { width: 100%; border-collapse: collapse;}
        .info-table td { padding: 8px; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img style="max-width: 150px; height: auto;" src="https://baseminiapp.winwingroup.vn/assets/images/logos/logo_win_baby_login.png" alt="Win Baby Logo"/>
        <h2>Cảnh báo KPI Nhân Viên</h2>
        <span>Ngày gửi: {{ now()->format('H:i d/m/Y') }}</span>
    </div>

    <table class="info-table">
        <thead>
        <tr>
            <th>STT</th>
            <th>Tài khoản</th>
            <th>Điểm số</th>
            <th>Nguy hiểm</th>
        </tr>
        </thead>
        <tbody>
        @foreach($employeesToNotify as $k => $employee)
            <tr>
                <td style="text-align: center">{{$k + 1}}</td>
                <td>
                    <span>{{optional($employee->employee)->user_name}}</span><br>
                    <span>{{optional($employee->employee)->given_name}}</span>
                </td>
                <td style="text-align: center">{{$employee->points}}</td>
                <td style="font-weight: bold; text-align: center;
                @if($employee->points < 40) color: red;
                @elseif($employee->points < 60) color: orange;
                @elseif($employee->points < 70) color: green;
                @else color: black;
                @endif">
                    @if($employee->points < 40)
                        Cao
                    @elseif($employee->points < 60)
                        Trung bình
                    @elseif($employee->points < 70)
                        Thấp
                    @else
                        Ổn định
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
</body>
</html>
