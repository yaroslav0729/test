@php
    if (isset($pGroup)) {
        $pageTitle = 'Edit post group id: ' . $pGroup->id;
        $actionRoute = route('admin.post_group.update', ['post_group' => $pGroup->id]);
        $name = $pGroup->name;
        $slug = $pGroup->slug;
    } else {
        $pageTitle = 'Create post group';
        $actionRoute = route('admin.post_group.store');
        $name = old('name');
        $slug = old('slug');
    }
@endphp

@extends('layouts.admin')

@section('content')

<div id="admin_content" class="bg-gray-100 flex-auto h-screen">
    <div class="p-5 pb-8 lg:w-1/2">
        <h1>{{ $pageTitle }}</h1>

        <form action="{{ $actionRoute }}" method="post">
            @csrf

            @isset($pGroup)
                @method('PUT')
            @endisset

            <label for="name">Name</label><br>
            <input id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $name }}" /><br>
            
            <label for="slug">Slug</label><br>
            <input id="slug" name="slug" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $slug }}" /><br>
            
            <br><br>
            <button class="btn btn-info" type="submit">
                Submit
            </button>

        </form>

    </div>
</div>

@endsection