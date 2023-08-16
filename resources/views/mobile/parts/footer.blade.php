<footer class="{{ $configTemplate['footerClassName'] ?? 'bg-primary' }}">
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
            Copyright {{ \Carbon\Carbon::now()->year }} <b>Islamic Help</b><br>
            Registered Charity Number: {{ Setting::get(Setting::REGISTERED_CHARITY_NUMBER) ?? '' }}<br>
            <a href="tel: 0121 446 5682">Tel: 0121 446 5682</a><br>
            <a href="tel: {{ Setting::get(Setting::COMPANY_NUMBER) ?? '' }}">Company Number: {{ Setting::get(Setting::COMPANY_NUMBER) ?? '' }}</a><br>
            <a href="https://www.regentbranding.co.uk/">Site by Regent</a>
        </div>

        <div class="social d-flex">
            @foreach ($socialMenu as $menuItem)
                <a href="{{ $menuItem->link }}" class="mr-4 {{ $menuItem->text }}">
                    {!! $socialMenuIcons[$menuItem->text] !!}
                </a>
            @endforeach
        </div>
    </div>
</footer>

@include('parts.modal_cart')
@include('parts.modal_login')
