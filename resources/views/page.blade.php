@extends('layouts.main')

@section('header')
{{--    @include($headerTemplate ?? 'parts.header')--}}

    @if (isset($headerTemplate))
        @include('parts.header', ['header_color' => $headerTemplate])
    @else
        @include('parts.header')
    @endif

@endsection

@section('content')
    
    {!! $html !!}

@endsection