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
            <a href="tel: {{ Setting::get(Setting::COMPANY_NUMBER) ?? '' }}">Tel: {{ Setting::get(Setting::COMPANY_NUMBER) ?? '' }}</a>
        </div>

        <div class="social d-flex">
            @foreach ($socialMenu as $menuItem)
                <a href="{{ $menuItem->link }}" class="mr-4">
                    <i class="{{ $socialMenuIcons[$menuItem->text] ?? '' }}"></i>
                </a>
            @endforeach
        </div>
    </div>
</footer>

@include('parts.modal_cart')
@include('parts.modal_login')
