<footer class="{{ $configTemplate['footerClassName'] ?? 'bg-primary' }}">
    <div class="wrap">
        <div class="row">
            <div class="col-12 col-lg-9">
                <ul class="menu d-flex align-items-start">
                    @foreach($footerMenuItem as $menuItem)
                        <li class="">
                            <a href="#">{{ $menuItem->text }}</a>
                            <ul class="sub-menu">
                                @foreach($menuItem->subMenus as $footerSubMenuItem)
                                    <li>
                                        <a href="{{ $footerSubMenuItem->formatted_link }}">{{ $footerSubMenuItem->text }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
{{--            <div class="col-12 col-lg-1"></div>--}}
            <div class="col-12 col-lg-3">
                <div class="social d-flex justify-content-between pl-5 pr-3">
                    @foreach ($socialMenu as $menuItem)
                        <a href="{{ $menuItem->link }}">
                            {!! $socialMenuIcons[$menuItem->text] !!}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="copy text-right mt-5">
            @foreach ($additionalFooterMenuItem as $key => $menuItem)
                <a href="{{ $menuItem->link }}">{!! $menuItem->text !!}</a> @if(count($additionalFooterMenuItem)-1 > $key)
                    <span>|</span> @endif
            @endforeach
            <span>|</span> Registered Charity Number: {{ Setting::get(Setting::REGISTERED_CHARITY_NUMBER) ?? '' }}
            <span>|</span><a>Company Number: {{ Setting::get(Setting::COMPANY_NUMBER) ?? '' }}</a>
            <span>|</span><a href="https://www.regentbranding.co.uk/">Site by Regent</a>
        </div>
    </div>
</footer>
@include('parts.modal_cart')
@include('parts.modal_login')
