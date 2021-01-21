<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('parts.head')
    </head>
    <body class="font-sans antialiased">
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

            @yield('content')
            @include('cookieConsent::index')
            @include('parts.footer')
        </div>
        @include('templates.presentation.parts.add_to_cart_popup')
        @include('templates.presentation.parts.at_least_5_popup')
        @yield('scripts')
    </body>
</html>
