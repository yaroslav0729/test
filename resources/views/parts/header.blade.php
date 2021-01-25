@php

$cartSum = \App\Models\CartItem::getCartSum(); 

if (!isset($headerColorClass)) {
    $headerColorClass = 'blue';
}

@endphp

@include('parts.header_menu')


<header>
    <div class="top-bar">
        <div class="wrap">
            <div class="row align-items-center">
                <div class="col-4 col-lg-6">
                    <a href="{{ route('index') }}" class="logo">
                        <span>
                            <img src="/img/logo.png" width="35" height="35" style="margin: 8px 0 0 8px" />
                        </span> Islamic Help
                    </a>
                </div>
                <div class="col-8 col-lg-6 text-right">
                    <div class="phone">020 5000 2400 <i></i></div>
                    @include('parts.basket')
                </div>
            </div>
        </div>
    </div>
    <div class="down-bar {{$headerColorClass}}">
        <div class="wrap">
            <div class="row align-items-center">
                <div class="col-9">
                    <a href="{{ route('index') }}" class="logo">
                        <img src="/img/logo.png" width="35" height="35" />
                    </a>
                    <ul class="d-flex justify-content-between">
                        @isset ($headerMenuItem[0])
                            @foreach($headerMenuItem[0] as $itemMenu)
                                <li><a href="@if($itemMenu->is_group)#@else{{ $itemMenu->link }}@endif"
                                    @if($itemMenu->is_group)
                                    class="open-head-menu"
                                    @endif data-id="{{$itemMenu->id}}">{{ $itemMenu->text }}</a></li>
                            @endforeach
                        @endisset
                        <li><a href="#"><i class="ico-search"></i></li>
                    </ul>
                </div>
                <div class="col-3 text-right">
                    <a href="{{ \App\Models\Page::getSinglePageUrl(\App\Models\Template::PROJECTS_PAGE) }}" class="btn btn-danger">Donate</a>

                    @include('parts.basket')
                </div>
            </div>
        </div>
    </div>
</header>



