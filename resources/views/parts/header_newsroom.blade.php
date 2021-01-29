@include('parts.header_menu')

<header class="dark-theme">
    <div class="top-bar">
        <div class="wrap">
            <div class="row align-items-center">
                <div class="col-6"><a href="#" class="logo"><span></span> Islamic Help Newsroom</a></div>
                <div class="col-6 text-right">
                    <svg version="1.1" class="ico-menu"  xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 412.053 412.053" style="enable-background:new 0 0 412.053 412.053;"
                         xml:space="preserve">
                        <path d="M213.387,241.387v170.667h170.667V241.387H213.387z M0.053,412.053H170.72V241.387H0.053V412.053z M0.053,28.053V198.72 H170.72V28.053H0.053z M291.36,0L170.72,120.747l120.64,120.64L412,120.747L291.36,0L291.36,0z"/>
                    </svg>

                </div>
            </div>
        </div>
        <div class="expand-bar">
            <div class="row align-items-center">
                <div class="col-8">
                    <ul class="d-flex justify-content-between">
                        @isset ($headerMenuItem[0])
                            @foreach($headerMenuItem[0] as $itemMenu)
                                <li><a href="@if($itemMenu->is_group)#@else{{ $itemMenu->link }}@endif"
                                    @if($itemMenu->is_group)
                                    class="open-head-menu"
                                    @endif data-id="{{$itemMenu->id}}">{{ $itemMenu->text }}</a></li>
                            @endforeach
                        @endisset
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>