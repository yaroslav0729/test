@extends('layouts.main')

@section('content')
    
<div class="container  mx-auto">
    <div class="p-5 pb-8">
        <h1>{{ $post->title}}</h1>
        {!! $post->data !!}
    </div>
</div>

@endsection