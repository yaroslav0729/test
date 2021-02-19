@php

    $cartSum = \App\Models\CartItem::getCartSum();

    if (isset($configTemplate['headerClassName'])) {
        $headerClassName = $configTemplate['headerClassName'];
    }

    if (!isset($headerClassName)) {
        $headerClassName = 'blue';
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
                            <img src="/img/logo.png" width="35" height="35" style="margin: 8px 0 0 8px"/>
                        </span> Islamic Help
                    </a>
                </div>
                <div class="col-8 col-lg-6 text-right">
                    <div class="phone">0121 446 5682 <i></i></div>
                    @include('parts.basket')
                </div>
            </div>
        </div>
    </div>
    <div class="down-bar {{$headerClassName}}">
        <div class="wrap">
            <div class="row align-items-center">
                <div class="col-9">
                    <a href="{{ route('index') }}" class="logo">
                        <img src="/img/logo.png"/>
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
                        <li>
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarToggleExternalContent"
                                    aria-controls="navbarToggleExternalContent" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                <i class="ico-search"></i>
                            </button>
                        </li>
                    </ul>
                    <div class="collapse mt-3 @isset($search) show @endisset " id="navbarToggleExternalContent">
                        <form class="form-inline my-2 my-lg-0 w-100" action="{{ route('search.index') }}" method="get">
                            <input class="form-control mr-sm-2 bg-white search-input w-100" type="search" placeholder="Search.."
                                   aria-label="Search" name="keyword" value="{{ old('search') }}" autocomplete="off">
                        </form>
                    </div>
                </div>

                <div class="col-3 text-right">
                    <a href="{{ \App\Models\Page::getSinglePageUrl(\App\Models\Template::PROJECTS_PAGE) }}"
                       class="btn btn-danger">Donate</a>

                    @include('parts.basket')
                </div>
            </div>
        </div>
    </div>
</header>



