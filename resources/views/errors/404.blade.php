@extends('layouts.main')

@section('header')
    @include('parts.header_short')
@endsection

@section('content')
    <div class="page-404">
        <div class="text">
            <div class="row text-left">
                <p class="col-12 mt-5 mb-5"> <span class="text-dark">404 | </span> Not found</p>
            </div>
        </div>
    </div>
@endsection
