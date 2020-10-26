@php
    if (isset($post)) {
        $pageTitle = 'Edit post id: ' . $post->id;
        $actionRoute = route('admin.post.update', ['post' => $post->id]);
        $name = $post->name;
        $slug = $post->slug;
        $title = $post->title;
        $description = $post->description;
        $keywords = $post->keywords;
    } else {
        $pageTitle = 'Create post:';
        $actionRoute = route('admin.post.store');
        $name = old('name');
        $slug = old('slug');
        $title = old('title');
        $description = old('description');
        $keywords = old('keywords');
    }
@endphp

@extends('layouts.admin')

@section('head')

    {{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector: '.widget_{{ \App\Models\Widget::WIDGET_RICH_TEXT }}' });</script> --}}

@endsection

@section('content')

<div id="admin_content" class="bg-gray-100 flex-auto">
    
    @if ($errors->any())
        <div class="p-3">
            <div class="alert alert-danger" role="alert">
                <strong class="font-bold">Validation errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ $actionRoute }}" method="post">
            @csrf

            @isset($post)
                @method('PUT')
            @endisset

            <div class="p-5 pb-8 lg:w-1/2">

            <h1>{{ $pageTitle }}</h1> 

            <label for="name">Name</label><br>
            <input id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $name }}" /><br>
            
            <label for="slug">Slug</label><br>
            <input required id="slug" name="slug" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $slug }}" /><br>
            
            <label for="title">Title</label><br>
            <input id="title" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $title }}" /><br>

            <label for="description">Description</label><br>
            <textarea class="w-full" name="description" id="description">{{ $description }}</textarea>
            <br>

            <label for="keywords">Keywords</label><br>
            <textarea class="w-full" name="keywords" id="keywords">{{ $keywords }}</textarea>
            <br>

            <label for="groups">Post groups</label>
            <br>

            
            <select id="groups" name="groups[]" multiple class="w-full">
                @foreach ($groups as $group)

                    @php
                        $selected = false;
                        if ((isset($post)) && (in_array($group->id, $post->group_ids))) {
                            $selected = true;
                        }
                    @endphp

                    <option value="{{ $group->id }}" @if($selected) selected @endif>{{ $group->name }}</option>   
                @endforeach
            </select>

            </div>
            <br>

            <input type="hidden" name="widgets" :value="widgetsString" />

            <hr>

            <div class="p-5 pb-8">
            <h3 class="mb-3">Post content:</h3>

            @isset($post)
                @foreach ($post->widgets as $wKey => $widget)
                    <div class="border border-dark rounded p-3 smb-3"
                        id="widget_{{ $wKey + 1 }}" data-id="{{ $widget->id }}">
                        {!! $widget->render() !!}
                    </div>
                    <div class="border mb-3 mt-3 p-3 widget_buttons">
                        <button type="button" class="btn btn-success"><i class="fas fa-arrow-down"></i></button>
                        <button type="button" class="btn btn-success"><i class="fas fa-arrow-up"></i></button>
                        <button type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                    </div>
                @endforeach
            @endisset

            <button class="btn btn-info" type="submit">
                Submit
            </button>

            <button class="btn btn-success" type="button"
                modal-call
                path="{{ route('admin.modal.getWidgetModal') }}"
                data-toggle="modal" data-target="#modal-wrap">
                <i class="fas fa-plus"></i> New widget
            </button>

            </div>

        </form>

</div>

@endsection

@section('scripts')
<script>





</script>
@endsection