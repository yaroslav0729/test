@extends('layouts.admin')

@section('content')

<div id="admin_content" class="bg-gray-100 flex-auto h-screen">
    <div class="p-5 pb-8 md:w-1/3">
        <h1>Edit post id: {{ $post->id }}</h1>

        <form action="{{ route('admin.post.update', ['post' => $post->id]) }}" method="post">
            @csrf
            @method('PUT')

            <label for="title">Title</label><br>
            <input id="title" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $post->title }}" /><br>
            
            <label for="slug">Slug</label><br>
            <input id="slug" name="slug" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $post->slug }}" /><br>
            
            <label for="data">Slug</label><br>
            <textarea id="data" name="data" style="min-width:450px; min-height: 300px;">{{ $post->data }}</textarea>
            
            <br><br>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Submit
            </button>

        </form>

    </div>
</div>

@endsection