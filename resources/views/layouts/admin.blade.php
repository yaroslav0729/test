<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}""></script>
        {{-- <script src="{{ asset('js/admin.js') }}""></script> --}}
        <link rel="stylesheet" href="{{ asset('css/admin_styles.css') }}">
        @yield('head')
    </head>
    <body class="font-sans antialiased">
        <div class="wrapper">

            @include('parts.header')

            <div class="d-flex">
                @include('admin.parts.left-menu')
                <div class="flex-grow-1">
                    @yield('content')
                </div>
            </div>
            
            @include('parts.footer')
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal-wrap" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                {{-- @include('admin.modals.add_widget') --}}
            </div>
        </div>

        @yield('scripts')
    </body>
</html>
