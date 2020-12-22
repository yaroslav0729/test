<footer class="{{ $footerClass }}">
    <div class="wrap">
        <div class="toggle-menu"><b>EXPAND NAVIGATION</b></div>
        <div style="display: none">
            <ul class="menu">
                @foreach ($footerMenuItem as $menuItem)
                    <li>
                        <a 
                            href="#"
                        >
                            {{ $menuItem->text }}
                        </a>
                        @if ($menuItem->is_group)
                            <ul class="sub-menu">
                                @foreach ($menuItem->orderedSubMenus as $subMenuItem)
                                    <li><a href="{{ $subMenuItem->link }}">{{ $subMenuItem->text }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="copy">
            Copyright 2020 <b>Islamic Help</b><br>
            Registered Charity Number: 1160490<br>
            Tel: 020 800 8000
        </div>

        <div class="social d-flex justify-content-between">
            @foreach ($socialMenu as $menuItem)
                <a href="{{ $menuItem->link }}">
                    <i class="{{ $socialMenuIcons[$menuItem->text] ?? '' }}"></i>
                </a>
            @endforeach
        </div>
    </div>
</footer>

@include('parts.modal_cart')
