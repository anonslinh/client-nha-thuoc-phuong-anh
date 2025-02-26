<table>
    <thead>
    <tr>
        <th>Tài khoản</th>
        <th>Họ tên</th>
        <th>Điểm số trong tháng</th>
        <th>Đánh giá nguy hiểm</th>
        <th>1 sao</th>
        <th>2 sao</th>
        <th>3 sao</th>
        <th>4 sao</th>
        <th>5 sao</th>
    </tr>
    </thead>
    <tbody>
    @foreach($listData as $item)
        <tr>
            <td>{{ $item->user_name }}</td>
            <td>{{ $item->given_name }}</td>
            <td>{{ $item->kpi_points }}</td>
            <td>{{ $item->low_ratings }}</td>
            <td>{{ $item->rating_1 }}</td>
            <td>{{ $item->rating_2 }}</td>
            <td>{{ $item->rating_3 }}</td>
            <td>{{ $item->rating_4 }}</td>
            <td>{{ $item->rating_5 }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
