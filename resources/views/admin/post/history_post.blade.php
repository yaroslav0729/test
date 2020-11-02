@php
    $pageTitle = 'Post history';
    $actionRoute = route('admin.post.restore', ['id' => $post->id]);
    $name = $post->name;
    $slug = $post->slug;
    $title = $post->title;
    $description = $post->description;
    $keywords = $post->keywords;
@endphp

@extends('layouts.admin')

@section('content')

<div id="admin_content" class="bg-gray-100 flex-auto">
    
    @if ($errors->any())
        <div class="p-3">
            <div class="alert alert-danger" role="alert">
                <strong class="font-weight-bold">Validation errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

            <h1>{{ $pageTitle }}</h1> 
            @if($post->actual)
                <h2 class="text-danger">current version</h2>
            @else 
                <form action="{{ $actionRoute }}" method="post">
                    @csrf
                    <button class="btn btn-info mb-3 mt-3" type="submit">
                        <i class="fas fa-trash-restore"></i> Restore this version
                    </button>
                </form>
            @endif

            <div class="form-group">
            <label for="name">Name</label>
            <input id="name" readonly name="name" class="form-control" type="text" value="{{ $name }}" />
            </div>

            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input readonly required id="slug" name="slug" class="form-control" type="text" value="{{ $slug }}" />
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input readonly id="title" name="title" class="form-control" type="text" value="{{ $title }}" />
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea readonly class="form-control" name="description" id="description">{{ $description }}</textarea>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="keywords">Keywords</label>
                        <textarea readonly class="form-control" rows="2" name="keywords" id="keywords">{{ $keywords }}</textarea>
                    </div>
                </div>

                
            </div>

            
                <div class="form-group">
                    <label for="groups">Post groups</label>
                    <select id="groups" name="groups[]" multiple class="form-control">
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

            <hr>

            <h2>Post content</h2>

            <div id="widget-items-wrapper" class="mb-3">
                @isset($post)
                    @foreach ($post->widgets as $wKey => $widget)
                        {!! $widget->renderWithElements() !!}
                    @endforeach
                @endisset
            </div>

            <div id="response-content" class="d-none">
            </div>

        @if(!$post->actual)
            <form action="{{ $actionRoute }}" method="post">
                @csrf
                <button class="btn btn-info" type="submit">
                    <i class="fas fa-trash-restore"></i> Restore this version
                </button>
            </form>
        @endif

</div>

@endsection

@section('scripts')

@endsection