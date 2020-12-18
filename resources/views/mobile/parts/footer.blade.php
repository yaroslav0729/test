<footer class="style-4">
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
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
    </div>
</footer>

@include('parts.modal_cart')
