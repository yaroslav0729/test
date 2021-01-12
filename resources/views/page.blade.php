@extends('layouts.main')

@section('header')
    @include($headerTemplate ?? 'parts.header')
@endsection

@section('content')
    
    {!! $html !!}

@endsection