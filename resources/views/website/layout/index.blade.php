<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nhà thuốc Phương Anh')</title>

    <link rel="shortcut icon" href="{{ asset('phuonganh/img/logo-pa.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">

    {{-- css dùng chung --}}
    <link rel="stylesheet" href="{{ asset('phuonganh/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('phuonganh/css/footer.css') }}">

    {{-- css riêng từng trang --}}
    @yield('style')
    @stack('styles')
    @include('website.partials.luxury-theme')
</head>
<body>
    @include('website.partials.header')

    <main>
        @yield('content')
    </main>

    @include('website.partials.footer')

    {{-- js dùng chung --}}
    <script>
        (function () {
            const items = document.querySelectorAll(".lc-header-nav-inner .lc-nav-item");
            if (!items.length) return;

            items.forEach(function (item) {
                item.addEventListener("click", function () {
                    items.forEach(function (i) {
                        i.classList.remove("lc-nav-item--active");
                    });
                    item.classList.add("lc-nav-item--active");
                });
            });
        })();
    </script>

    {{-- js riêng từng trang --}}
    @include('website.partials.luxury-theme-scripts')
    @yield('script')
    @stack('scripts')
</body>
</html>
