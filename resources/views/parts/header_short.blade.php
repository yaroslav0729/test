@php

$cartSum = \App\Models\CartItem::getCartSum(); 

@endphp

<header  class="only-menu">
    <div class="down-bar">
        <div class="wrap">
            <div class="row align-items-center">
                <div class="col-8">
                    <a href="{{ route('index') }}" class="logo">
                        <span>
                            <img src="/img/logo.png" width="35" height="35" style="margin: 8px 0 0 8px" />
                        </span>
                    </a>
                    <ul class="d-flex justify-content-between">
                        <li><a href="#" class="open-head-menu">our story</a></li>
                        <li><a href="#">Projects</a></li>
                        <li><a href="#">Get Involved</a></li>
                        <li><a href="#">newsroom</a></li>
                        <li><a href="#">appeals</a></li>
                        <li><a href="#"><i class="fas fa-search"></i></a></li>
                    </ul>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ \App\Models\Page::getProjectsUrl() }}" class="btn btn-danger" data-toggle="modal" data-target="#foodPack">Donate</a>
                    <div class="basket" data-toggle="modal" data-target="#cartModal"><i></i> 
                        @if($cartSum > 0)
                            <span>£{{ $cartSum }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>