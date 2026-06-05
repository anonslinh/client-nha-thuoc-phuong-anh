<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nhà thuốc Phương Anh')</title>

    <link rel="shortcut icon" href="{{ asset('phuonganh/img/logo-pa.png') }}">

    {{-- css dùng chung --}}
    <link rel="stylesheet" href="{{ asset('phuonganh/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('phuonganh/css/footer.css') }}">

    {{-- css riêng từng trang --}}
    @yield('style')
    @stack('styles')
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
    @yield('script')
    @stack('scripts')
</body>
</html>