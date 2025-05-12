<?php
    use App\Models\GeneralSettings;
    $type_point = GeneralSettings::where('code', 'type_point')->first()->value ?? 1;
?>
<!-- Sidebar Start -->
<aside class="side-mini-panel with-vertical">
    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
    <div class="iconbar">
        <div>
            <div class="mini-nav">
                <div class="brand-logo d-flex align-items-center justify-content-center">
                    <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                        <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-7"></iconify-icon>
                    </a>
                </div>
                <ul class="mini-nav-ul" data-simplebar>
                    @foreach(config('menu') as $key => $value)
                        <li class="mini-nav-item" id="mini-{{$key + 1}}">
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-placement="right" data-bs-title="{{$value['name']}}">
                                <iconify-icon icon="{{$value['icon']}}" class="fs-7"></iconify-icon>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="sidebarmenu">
                <div class="brand-logo d-flex align-items-center nav-logo">
                    <a href="{{route('index')}}" class="text-nowrap logo-img">
                        <img src="../assets/images/logos/logo_win_baby.svg" alt="Logo" />
                    </a>
                </div>
                @foreach(config('menu') as $key => $value)
                    <nav class="sidebar-nav" id="menu-right-mini-{{$key + 1}}" data-simplebar>
                        <ul class="sidebar-menu" id="sidebarnav">
                            <li class="nav-small-cap">
                                <span class="hide-menu">{{$value['name']}}</span>
                            </li>
                            @foreach($value['submenu'] as $k => $item)
                                @if(isset($item['type']) && $item['type'] == 'title')
                                    <li>
                                        <span class="sidebar-divider lg"></span>
                                    </li>
                                    <li class="nav-small-cap">
                                        <span class="hide-menu">{{$item['name']}}</span>
                                    </li>
                                    @elseif(isset($item['type']) && $item['type'] == 'type_point')
{{--                                    Kiểm tra ẩn hiện menu Tích điểm theo từng sản phẩm--}}
                                    @if($type_point == 2)
                                    <li>
                                        <span class="sidebar-divider lg"></span>
                                    </li>
                                    <li class="nav-small-cap">
                                        <span class="hide-menu">{{$item['name']}}</span>
                                    </li>
                                    @endif
                                    @else
                                    @if($type_point == 1)
                                        @if(empty($item['type_point']))
                                            @if($key == 0)
                                                <li class="sidebar-item">
                                                    <a class="sidebar-link" href="{{route($item['route'])}}" @if($k == 0) id="get-url" @endif aria-expanded="false">
                                                        <iconify-icon icon="{{$item['icon']}}"></iconify-icon>
                                                        <span class="hide-menu">{{$item['name']}}</span>
                                                    </a>
                                                </li>
                                            @else
                                                <li class="sidebar-item">
                                                    <a href="{{route($item['route'])}}" class="sidebar-link">
                                                        <iconify-icon icon="{{$item['icon']}}"></iconify-icon>
                                                        <span class="hide-menu">{{$item['name']}}</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                        @else
                                        @if($key == 0)
                                            <li class="sidebar-item">
                                                <a class="sidebar-link" href="{{route($item['route'])}}" @if($k == 0) id="get-url" @endif aria-expanded="false">
                                                    <iconify-icon icon="{{$item['icon']}}"></iconify-icon>
                                                    <span class="hide-menu">{{$item['name']}}</span>
                                                </a>
                                            </li>
                                        @else
                                            <li class="sidebar-item">
                                                <a href="{{route($item['route'])}}" class="sidebar-link">
                                                    <iconify-icon icon="{{$item['icon']}}"></iconify-icon>
                                                    <span class="hide-menu">{{$item['name']}}</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </nav>
                @endforeach
            </div>
        </div>
    </div>
</aside>
<!--  Sidebar End -->
