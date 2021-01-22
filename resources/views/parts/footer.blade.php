<footer class="{{ $configTemplate['footerClassName'] }}">
    <div class="wrap">
        <div class="row">
            <div class="col-8">
                <ul class="menu d-flex align-items-start">
                    @foreach($footerMenuItem as $menuItem)
                        <li class="">
                            <a href="#">{{ $menuItem->text }}</a>
                            <ul class="sub-menu">
                                @foreach($menuItem->subMenus as $footerSubMenuItem)
                                    <li>
                                        <a href="{{ $footerSubMenuItem->formatted_link }}">{{ $footerSubMenuItem->text }}</a></li>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-1"></div>
            <div class="col-3">
                <div class="social d-flex justify-content-between">
                    @foreach ($socialMenu as $menuItem)
                        <a href="{{ $menuItem->link }}">
                            <i class="{{ $socialMenuIcons[$menuItem->text] ?? '' }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="copy text-right">
            IslamicHelp   2020 <span>|</span>

            @foreach ($additionalFooterMenuItem as $menuItem)
                <a href="{{ $menuItem->link }}">{{ $menuItem->text }}</a> <span>|</span>
            @endforeach
            Registered Charity Number:  1160490 <span>|</span> Company Number:  0938212
        </div>
    </div>
</footer>
@include('parts.modal_cart')
@include('parts.modal_login')
