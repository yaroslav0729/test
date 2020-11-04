<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="{{ mix('js/app.js') }}""></script>

        {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
        {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}

        {{-- <link rel="stylesheet" href="/libs/bootstrap/css/bootstrap.css"> --}}
        {{-- <script src="/libs/bootstrap/js/bootstrap.js"></script> --}}
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> --}}
        
        {{-- <script src="/libs/bootstrap-input-spinner.js"></script> --}}
        
        {{-- <link href="/libs/fontawesome-pro-5.14.0/css/all.css" rel="stylesheet"> --}}
        {{-- <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script> --}}


        {{-- <script src="/js/functions.js"></script> --}}

        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Serif:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">

        {{-- <link type="text/css" href="{{ asset('css/styles.css') }}" rel="stylesheet" media="all" /> --}}

        @yield('head')
    </head>
    <body class="font-sans antialiased">
        <div class="wrapper" id="app">
            @include('parts.header')
            @yield('content')
            @include('parts.footer')
        </div>
        @yield('scripts')
    </body>
</html>
