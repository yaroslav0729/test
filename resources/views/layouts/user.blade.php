<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <link rel="stylesheet" href="{{ asset('css/app_admin.css') }}">
        <script src="{{ asset('js/admin.js') }}""></script>
        <link rel="stylesheet" href="{{ asset('css/admin_styles.css') }}">
        @livewireStyles
        @yield('head')
    </head>
    <body class="font-sans antialiased">
        <div class="wrapper" style="margin: 0; padding:0">

            <div class="d-flex">
                @include('parts.user_left_menu')
                <div class="flex-grow-1">
                    @yield('content')
                </div>
            </div>
            
        </div>

        @yield('scripts')

        @livewireScripts
    </body>
</html>
