@extends('layouts.main')

@section('content')
    
<div class="container  mx-auto">
    <div class="p-5 pb-8">
        @foreach ($post->widgets as $widget)
            {!! $widget->render() !!}    
        @endforeach
    </div>
</div>

@endsection