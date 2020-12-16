@php

$cartSum = \App\Models\CartItem::getCartSum(); 

@endphp

<header>
    <div class="top-bar">
        <div class="wrap">
            <div class="row align-items-center">
                <div class="col-6">
                    <a href="{{ route('index') }}" class="logo">
                        <span>
                            <img src="/img/logo.png" width="35" height="35" style="margin: 8px 0 0 8px" />
                        </span> Islamic Help
                    </a>
                </div>
                <div class="col-6 text-right">
                    <div class="phone">020 5000 2400 <i></i></div>
                    @include('parts.basket')
                </div>
            </div>
        </div>
    </div>
    <div class="down-bar">
        <div class="wrap">
            <div class="row align-items-center">
                <div class="col-9">
                    <ul class="d-flex justify-content-between">
                        <li><a href="#" class="open-head-menu">our story</a></li>
                        <li><a href="#">Projects</a></li>
                        <li><a href="#">Get Involved</a></li>
                        <li><a href="#">newsroom</a></li>
                        <li><a href="#">appeals</a></li>
                        <li><a href="#"><i class="ico-search"></i></a></li>
                    </ul>
                </div>
                <div class="col-3 text-right">
                    <a href="{{ \App\Models\Page::getProjectsUrl() }}" class="btn btn-danger">Donate</a>
                </div>
            </div>
        </div>
    </div>
</header>

@include('parts.header_menu')

