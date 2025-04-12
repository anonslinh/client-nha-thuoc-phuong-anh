<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Winbaby - Vòng quay may mắn</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png">
    <!-- Nhúng React và ReactDOM -->
    <script src="https://cdn.jsdelivr.net/npm/react@18/umd/react.development.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/react-dom@18/umd/react-dom.development.js"></script>
    <!-- Nhúng Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Nhúng Babel để dùng JSX -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/@babel/standalone/babel.min.js"></script>
    <!-- CSS cơ bản (có thể thay bằng file CSS riêng) -->
    <base href="{{asset('')}}">
    <link rel="stylesheet" href="assets/css/rotation.css" />
</head>

<body>
<div id="root"></div>

<!-- Script chứa code React -->
<script type="text/babel" src="assets/js/lucky-wheel.jsx"></script>
</body>

</html>
