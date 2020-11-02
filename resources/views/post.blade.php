@extends('layouts.blog')

@section('content')
    
<section class="blog-article-body">
    <div class="wrap">
        <div class="body">

            @foreach ($post->widgets as $widget)
                {!! $widget->render() !!}    
            @endforeach

        </div>
    </div>
</section>

@endsection