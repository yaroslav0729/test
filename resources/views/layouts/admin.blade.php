<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('css/app_admin.css') }}">
        <script src="{{ mix('js/app.js') }}"></script>
        {{-- <script src="{{ asset('js/admin.js') }}""></script> --}}
        <link rel="stylesheet" href="{{ mix('css/admin_styles.css') }}">
        @yield('head')
    </head>
    <body class="font-sans antialiased">
        <div class="wrapper h-100" style="padding-top:0">

            <div class="flex flex-row" id="app">
                @include('admin.parts.left-menu')
                <div class="flex-grow-1 pl-4">
                    @include('admin.parts.messages-block')
                          @yield('content')
                </div>
            </div>
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
