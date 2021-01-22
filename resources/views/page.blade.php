@extends('layouts.main')

@section('header')
    @include( $configTemplate['headerType'], ['configTemplate' => $configTemplate] )
@endsection

@section('content')

    {!! $html !!}

@endsection


@section('footer')
    @include('parts.footer', ['configTemplate' => $configTemplate])
@endsection

