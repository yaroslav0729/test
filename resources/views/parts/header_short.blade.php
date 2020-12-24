<header  class="only-menu">
    <div class="down-bar">
        <div class="wrap">
            <div class="row align-items-center">
                <div class="col-9">
                    <a href="{{ route('index') }}" class="logo">
                        <span>
                            <img src="/img/logo.png" width="35" height="35" style="margin: 8px 0 0 8px" />
                        </span>
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
                        <li><a href="#"><i class="fas fa-search"></i></a></li>
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

@include('parts.header_menu')