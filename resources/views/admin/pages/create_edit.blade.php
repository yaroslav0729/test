@php
    if (isset($page)) {

        $pageInstance = $page->actual_page_instance;
        if (isset($pageInstance)) {
            $pageTitle = 'Edit page id: ' . $page->id;
            $actionRoute = route('admin.pages.update', ['page' => $page->id]);
            $name = $pageInstance->name;
            $slug = $pageInstance->slug;
            $title = $pageInstance->title;
            $description = $pageInstance->description;
            $keywords = $pageInstance->keywords;
        } else {
            die('no page for this container');
        }
        
    } else {
        $pageTitle = 'Create page:';
        $actionRoute = route('admin.pages.store');
        $name = old('name');
        $slug = old('slug');
        $title = old('title');
        $description = old('description');
        $keywords = old('keywords');
    }
@endphp

@extends('layouts.admin')

@section('content')

<div id="admin_content" class="flex-auto">
    
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

    <form action="{{ $actionRoute }}" method="post" class="pb-3">
            @csrf

            @isset($pageInstance)
                @method('PUT')
            @endisset

            <h1>{{ $pageTitle }}</h1> 

            <div class="form-group">
            <label for="name">Name</label>
            <input id="name" name="name" required placeholder="Name of page" class="form-control" type="text" value="{{ $name }}" />
            </div>

            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="slug">Url name</label>
                        <input required id="slug" placeholder="Url of page" name="slug" class="form-control" type="text" value="{{ $slug }}" />
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input id="title" required name="title" placeholder="Title of page" class="form-control" type="text" value="{{ $title }}" />
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" placeholder="SEO - Description" name="description" id="description">{{ $description }}</textarea>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="keywords">Keywords</label>
                        <textarea class="form-control" rows="2" placeholder="SEO - Keywords" name="keywords" id="keywords">{{ $keywords }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="template">Template</label>
                <select name="template" class="form-control">
                    <option value="0">No template selected</option>
                    @foreach (\App\Models\Template::ALL_TEMPLATES as $template)
                        <option value="{{ $template }}"
                        @if(isset($pageInstance->template) && ($pageInstance->template === $template)) selected @endif
                        >{{ \App\Models\Template::getLabel($template) }}</option>    
                    @endforeach
                </select>
            </div>

            <hr>

            <h2 class="pt-4 pb-4">Template parameters:</h2>

            <div id="page_parameters"
                @isset($pageInstance)
                    data-current_page_instance_id={{ $pageInstance->id}}
                @endisset
            >
                @if(isset($pageInstance))
                    {{ $pageInstance->renderTemplateParametersForm() }}
                @endif
            </div>

            <hr>

            <button class="btn btn-info" type="submit">
                <i class="far fa-save"></i> Submit
            </button>
        </form>

</div>

@endsection

@section('scripts')

@endsection