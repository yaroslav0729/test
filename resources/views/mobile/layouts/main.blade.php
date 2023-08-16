@php
$bodyClassName = Request::path();
if (isset($configTemplate['bodyClassName'])) {
    $bodyClassName = $configTemplate['bodyClassName'];
}
if ($bodyClassName === 'who-we-are') {
    $bodyClassName = $bodyClassName . '-page';
}
$banner = App\Models\Banner::find(['id' => 1])->first();
$showBanner = false;
if ($banner && $banner->is_active) {
    $showBanner = $banner->is_active;
}
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('parts.head')
</head>

<body class="mobile-template {{ $bodyClassName }}  @if (isset($template)) {{ $template . '-template' }} @endif">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K436QMB" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="wrapper pt-0" id="app">
        <!--style-1 - default-->
        <!--style-2 - donate-->
        <!--style-3 - thank you-->
        <!--style-4 - project-->
        {{-- @yield('header') --}}

        @php
            $cartSum = \App\Models\CartItem::getCartSum();
        @endphp

        @if ($showBanner)
            <div class="global-banner" style="background-color: {{ $banner->color }};">{!! $banner->content !!}</div>
        @endif

        <header>
            <div
                class="top-bar {{ $configTemplate['headerMobileClassName'] ?? ($configTemplate['headerClassName'] ?? '') }}">
                <div class="wrap">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <a href="{{ route('index') }}" class="logo"><span><img
                                        src="/img/logo.png" /></span>
                                Islamic Help</a>
                        </div>
                        <div class="col-6 text-right">
                            <span class="basket basket-mobile @if ($cartSum === 0) d-none @endif"><i class="___class_+?10___"></i>
                                <span class="___class_+?11___"></span>
                            </span>
                            <span class="open-head-menu"></span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="header-menu" level="0">
            <div class="row top align-items-center">
                <div class="col-4"><a href="#" style="display: none" class="icon_left_1 back"><i
                            class="moon-icons-arrow-left"></i></a></div>
                <div class="col-4 text-center"><a href="#" class="icon_search_1 d-none search-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448.098 448.098" fill="currentColor"
                            width="20px" height="20px">
                            <path
                                d="M184.08 0C82.46 0 .08 82.38.08 184s82.38 184 184 184 184-82.38 184-184C367.992 82.416 285.664.088 184.08 0zm0 304c-66.274 0-120-53.726-120-120s53.726-120 120-120 120 53.726 120 120c-.088 66.238-53.762 119.912-120 120zM438.64 393.44l-64-64c-12.504-12.504-32.776-12.504-45.28 0s-12.504 32.776 0 45.28l64 64c12.504 12.504 32.776 12.504 45.28 0s12.504-32.776 0-45.28z" />
                        </svg>
                    </a></div>
                <div class="col-4 text-right"><a href="#" class="close-menu"><svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 212.982 212.982" fill="currentColor" width="20px" height="20px">
                            <path
                                d="M131.804 106.491l75.936-75.936c6.99-6.99 6.99-18.323 0-25.312-6.99-6.99-18.322-6.99-25.312 0L106.491 81.18 30.554 5.242c-6.99-6.99-18.322-6.99-25.312 0-6.989 6.99-6.989 18.323 0 25.312l75.937 75.936-75.937 75.937c-6.989 6.99-6.989 18.323 0 25.312 6.99 6.99 18.322 6.99 25.312 0l75.937-75.937 75.937 75.937c6.989 6.99 18.322 6.99 25.312 0 6.99-6.99 6.99-18.322 0-25.312l-75.936-75.936z"
                                fill-rule="evenodd" clip-rule="evenodd" />
                        </svg></i></a></div>
            </div>
            <a href="{{ route('index') }}" class="logo"><img src="/img/logo.png" /></a>
            <div class="level-0">
                <ul class="menu-1">
                    @isset($headerMenuItem[0])
                        @foreach ($headerMenuItem[0] as $menuItem)
                            <li>
                                <a @if ($menuItem->is_group) href="#"
                                    class="open-submenu"
                                    data-target="{{ $menuItem->id }}"
                                @else
                                    href="{{ $menuItem->link }}"
                        @endif>
                        {{ $menuItem->text }}
                        </a>
                        </li>
                        @endforeach
                    @endisset
                </ul>
                <div class="line"></div>
                <ul class="menu-2">
                    @foreach ($additionalHeaderMenuItem as $menuItem)
                        <li><a href="{{ $menuItem->formatted_link }}">{{ $menuItem->text }}</a></li>
                    @endforeach
                    <li><a href="#" data-toggle="modal" data-target="#loginModal">Login</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#createModal">+ Create Account</a></li>
                    <li>HOTLINE: <b class="text-info">0121 446 5682</b></li>
                    <li class="menu-search-item"><a href="#" class="search-btn">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 448.098 448.098"
                                style="enable-background:new 0 0 448.098 448.098;" xml:space="preserve"
                                fill="currentColor">
                                <g>
                                    <g>
                                        <path
                                            d="M184.08,0c-101.62,0-184,82.38-184,184s82.38,184,184,184s184-82.38,184-184C367.992,82.416,285.664,0.088,184.08,0z
                                    M184.08,304c-66.274,0-120-53.726-120-120s53.726-120,120-120s120,53.726,120,120C303.992,250.238,250.318,303.912,184.08,304z" />
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path d="M438.64,393.44l-64-64c-12.504-12.504-32.776-12.504-45.28,0s-12.504,32.776,0,45.28l64,64
                                    c12.504,12.504,32.776,12.504,45.28,0S451.144,405.944,438.64,393.44z" />
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- level 1-->
            @isset($headerMenuItem[1])
                @foreach ($headerMenuItem[1] as $groupId => $menuGroupItem)
                    <div style="display: none" class="level-1" data-group-id="{{ $groupId }}">
                        <div class="title">
                            <a href="#" class="icon_left_2 back"><i class="moon-icons-arrow-left"></i></a>
                            {{ $menuGroupItem['parent_text'] }}
                        </div>
                        <div class="line"></div>
                        @if ($menuGroupItem['max_depth'] >= 2)
                            <div class="projects-group-swiper">
                                @foreach ($menuGroupItem['items'] as $menuItem)
                                    <a @if ($menuItem->is_group) href="#"
                                        class="item open-submenu"
                                        data-target="{{ $menuItem->id }}"
                                    @else
                                        href="{{ $menuItem->link }}"
                                        class="item"
                                @endif>
                                {{ $menuItem->text }}
                                @if ($menuItem->is_group)
                                    <i class="far fa-plus"></i>
                                @endif
                                </a>
                        @endforeach
                    </div>
                @else
                    <div>
                        <ul class="menu">
                            @foreach ($menuGroupItem['items'] as $menuItem)
                                <li><a href="{{ $menuItem->link }}">{{ $menuItem->text }}</a></li>
                            @endforeach
                            <li class="menu-search-item"><a href="#" class="search-btn">
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        viewBox="0 0 448.098 448.098" style="enable-background:new 0 0 448.098 448.098;"
                                        xml:space="preserve" fill="currentColor">
                                        <g>
                                            <g>
                                                <path
                                                    d="M184.08,0c-101.62,0-184,82.38-184,184s82.38,184,184,184s184-82.38,184-184C367.992,82.416,285.664,0.088,184.08,0z
                                                                                            M184.08,304c-66.274,0-120-53.726-120-120s53.726-120,120-120s120,53.726,120,120C303.992,250.238,250.318,303.912,184.08,304z" />
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path
                                                    d="M438.64,393.44l-64-64c-12.504-12.504-32.776-12.504-45.28,0s-12.504,32.776,0,45.28l64,64
                                                                                            c12.504,12.504,32.776,12.504,45.28,0S451.144,405.944,438.64,393.44z" />
                                            </g>
                                        </g>
                                    </svg>
                                </a></li>
                        </ul>
                    </div>
                @endif
            </div>
            @endforeach
        @endisset

        <!-- level 2-->
        @isset($headerMenuItem[2])
            @foreach ($headerMenuItem[2] as $groupId => $menuGroupItem)
                <div style="display: none" class="level-2" data-group-id="{{ $groupId }}">
                    <div class="title">
                        <a href="#" class="icon_left_2 back"><i class="moon-icons-arrow-left"></i></a>
                        {{ $menuGroupItem['parent_text'] }}
                    </div>
                    <div class="line"></div>
                    <div class="categories">
                        <ul>
                            @foreach ($menuGroupItem['items'] as $menuItem)
                                <li>
                                    <a @if (!$menuItem->is_group) href="{{ $menuItem->formatted_link }}" @endif>{{ $menuItem->text }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        @endisset
    </div>

    <div id="quick_donation_widget">
        @include('modules.presentation.quick_donation')
    </div>

    @if (\Session::has('success'))
        <div class="container p-3">
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        </div>
    @endif

    @if (\Session::has('error'))
        <div class="container p-3">
            <div class="alert alert-danger">
                <ul>
                    <li>{!! \Session::get('error') !!}</li>
                </ul>
            </div>
        </div>
    @endif

    @yield('content')
    @include('widgets.food-pack')
    @include('widgets.food-pack-qurbani')
    @include('templates.presentation.parts.add_to_cart_popup')
    @include('templates.presentation.parts.at_least_5_popup')
    @include('cookieConsent::index')
    @include('parts.footer')
    </div>
    <!--wrapper-->
    @yield('scripts')
</body>

</html>
