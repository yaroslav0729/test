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

    <form action="{{ $actionRoute }}" method="post">
            @csrf

            @isset($post)
                @method('PUT')
            @endisset

            <h1>{{ $pageTitle }}</h1> 

            <div class="form-group">
            <label for="name">Name</label>
            <input id="name" name="name" class="form-control" type="text" value="{{ $name }}" />
            </div>

            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input required id="slug" name="slug" class="form-control" type="text" value="{{ $slug }}" />
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input id="title" name="title" class="form-control" type="text" value="{{ $title }}" />
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description">{{ $description }}</textarea>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="keywords">Keywords</label>
                        <textarea class="form-control" rows="2" name="keywords" id="keywords">{{ $keywords }}</textarea>
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

            <div class="mb-3">
                <button class="btn btn-success" type="button"
                    modal-call
                    path="{{ route('admin.modal.getWidgetModal') }}"
                    data-toggle="modal" data-target="#modal-wrap">
                    <i class="fas fa-plus"></i> New widget
                </button>
            </div>

            <div id="widget-items-wrapper" class="mb-3">
                @isset($post)
                    @foreach ($post->widgets as $wKey => $widget)
                        {!! $widget->renderWithElements() !!}
                    @endforeach
                @endisset
            </div>

            <div id="response-content" class="d-none">
            </div>

            <button class="btn btn-info" type="submit">
                Submit
            </button>

            <button class="btn btn-success" type="button"
                modal-call
                path="{{ route('admin.modal.getWidgetModal') }}"
                data-toggle="modal" data-target="#modal-wrap">
                <i class="fas fa-plus"></i> New widget
            </button>


        </form>

</div>

@endsection

@section('scripts')
<script>





</script>
@endsection