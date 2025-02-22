@php
$bodyClassName = Request::path();
if (isset($configTemplate['bodyClassName'])) {
    $bodyClassName = $configTemplate['bodyClassName'];
}
if ($bodyClassName === 'who-we-are') {
    $bodyClassName = $bodyClassName . '-page';
}
$banner = App\Models\Banner::find(['is_active' => true])->first();
$showBanner = false;
if ($banner && $banner->is_active) {
    $showBanner = $banner->is_active;
}
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('parts.head')
</head>

<body class="font-sans antialiased {{ $bodyClassName }} @if (isset($template)) {{ $template . '-template' }} @endif">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K436QMB" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @if ($showBanner)
        <div class="global-banner" style="background-color: {{ $banner->color }};">{!! $banner->content !!}</div>
    @endif
    <div class="wrapper" id="app">
        @yield('header')

        @if (\Session::has('success'))
            <div class="container p-3">
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            </div>
        @endif

        @if (\Session::has('error'))
            <div class="container p-3">
                <div class="alert alert-danger">
                    <ul>
                        <li>{!! \Session::get('error') !!}</li>
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
        {{-- @include('cookieConsent::index') --}}
        @yield('footer')
    </div>
    @include('templates.presentation.parts.add_to_cart_popup')
    @include('templates.presentation.parts.at_least_5_popup')
    @include('widgets.food-pack')
    @include('widgets.food-pack-qurbani')
    @yield('scripts')
</body>

</html>
