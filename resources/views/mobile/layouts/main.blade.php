<!DOCTYPE html>
<html lang="en">
<head>
    @include('parts.head')
</head>
<body class="mobile-template">

<div class="wrapper" id="app">
    <!--style-1 - default-->
    <!--style-2 - donate-->
    <!--style-3 - thank you-->
    <!--style-4 - project-->
 {{--   @yield('header')--}}

@php
    $cartSum = \App\Models\CartItem::getCartSum();
@endphp

    <header>
        <div class="top-bar {{ $configTemplate['headerMobileClassName'] ?? $configTemplate['headerClassName'] ?? '' }}">
            <div class="wrap">
                <div class="row align-items-center">
                    <div class="col-6">
                        <a href="{{ route('index') }}" class="logo"><span><img src="/img/logo.png" /></span> Islamic Help</a>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ url('/donate#about-donation') }}" class="basket"><i class=""></i>
                            <span class="@if($cartSum === 0) d-none @endif"></span>
                        </a>
                        <span class="open-head-menu"></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="header-menu" level="0">
        <div class="row top align-items-center">
            <div class="col-4"><a href="#" style="display: none" class="icon_left_1 back"><i class="moon-icons-arrow-left"></i></a></div>
            <div class="col-4 text-center"><a href="#" class="icon_search_1 d-none search-btn"><i class="fas fa-search"></i></a></div>
            <div class="col-4 text-right"><a href="#" class="close-menu"><i class="far fa-times"></i></a></div>
        </div>
        <a href="{{ route('index') }}" class="logo"><img src="/img/logo.png" /></a>
        <div class="level-0">
            <ul class="menu-1">
                @isset($headerMenuItem[0])
                    @foreach ($headerMenuItem[0] as $menuItem)
                        <li>
                            <a
                                @if ($menuItem->is_group)
                                    href="#"
                                    class="open-submenu"
                                    data-target="{{ $menuItem->id }}"
                                @else
                                    href="{{ $menuItem->link }}"
                                @endif
                            >
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
                <li><a href="#" class="search-btn"><i class="fas fa-search"></i></a></li>
            </ul>
        </div>

        <!-- level 1-->
        @isset ($headerMenuItem[1])
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
                                <a
                                    @if ($menuItem->is_group)
                                        href="#"
                                        class="item open-submenu"
                                        data-target="{{ $menuItem->id }}"
                                    @else
                                        href="{{ $menuItem->link }}"
                                        class="item"
                                    @endif
                                >
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
                                <li><a href="#" class="search-btn"><i class="fas fa-search"></i></a></li>
                            </ul>
                        </div>
                    @endif
                </div>
            @endforeach
        @endisset

        <!-- level 2-->
        @isset ($headerMenuItem[2])
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
                                    <a
                                        @if (!$menuItem->is_group)
                                            href="{{ $menuItem->formatted_link }}"
                                        @endif
                                    >{{ $menuItem->text }}
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

    @yield('content')
    @include('templates.presentation.parts.add_to_cart_popup')
    @include('templates.presentation.parts.at_least_5_popup')
    @include('cookieConsent::index')
    @include('parts.footer')
</div><!--wrapper-->
@yield('scripts')
</body>
</html>
