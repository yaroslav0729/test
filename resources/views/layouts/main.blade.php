<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('parts.head')
    </head>
    <body class="font-sans antialiased">
        <div class="wrapper" id="app">
            @yield('header')
            @yield('content')
            @include('parts.footer')
        </div>
        @yield('scripts')
    </body>
</html>
