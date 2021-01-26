@extends('layouts.main')

@section('header')
    @include('parts.header')
@endsection

@section('content')
    <div class="page-404">
        <div class="text">
            <p><span class="text-dark">404 | </span> Not found</p>
        </div>
    </div>
@endsection

@section('footer')
    @include('parts.footer')
@endsection

<script>

    function setHeight() {
        var wH = $(window).height(),
            hH = $('header').outerHeight(),
            fH = $('footer').outerHeight();

        if (!$('body').hasClass('mobile-template')) {
            $('.page-404').height(wH - hH -fH)
        }
    }

    window.addEventListener('load', function() {
        setHeight();
    })

</script>

