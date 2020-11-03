@extends('layouts.blog')

@section('content')
    
    @foreach ($post->widgets as $widget)
        {!! $widget->render() !!}    
    @endforeach

@endsection