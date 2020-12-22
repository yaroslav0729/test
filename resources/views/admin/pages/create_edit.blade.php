@php
    $pageInstance = $page->actual_page_instance ?? null;
    $footerClass = $pageInstance->parameters['footer_class'] ?? null;

if (isset($page)) {

    if (isset($pageInstance)) {
        $pageTitle = 'Edit page id: ' . $page->id;
        $actionRoute = route('admin.pages.update', ['page' => $page->id]);
        $name = $pageInstance->name;
        $slug = $pageInstance->slug;
        $previewText = $pageInstance->preview_text;
        $previewImg = $pageInstance->preview_img;
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
    $previewText = old('preview_text');
    $previewImg = old('preview_img');
    $title = old('title');
    $description = old('description');
    $keywords = old('keywords');
}

//dd($pageInstance->parameters['amount']);

@endphp

@extends('layouts.admin')

@section('content')

<div id="admin_content" class="flex-auto">

    <div class="alert alert-danger" style="display: none;">
        <ul id="modal-errors">
        </ul>
    </div>

    <form action="{{ $actionRoute }}" method="post" class="pb-3" modal-form>
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
                        <label for="preview_text">Preview text</label>
                        <textarea id="preview_text" name="preview_text" placeholder="Preview text" class="form-control">{{ $previewText }}</textarea>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="preview_img">Preview image</label>
                        <input id="preview_img" name="preview_img" placeholder="Preview image" class="form-control" type="text" value="{{ $previewImg }}" />
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
                <label for="groups">Categories</label>
                <select id="groups" name="categories[]" multiple class="form-control">
                    @foreach ($categories as $category)

                        @php
                            $selected = false;
                            if ((isset($pageInstance)) && (in_array($category->id, $pageInstance->category_ids))) {
                                $selected = true;
                            }
                        @endphp

                        <option value="{{ $category->id }}" @if($selected) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="footer_class">Footer Class</label>
                <select id="footer_class" name="parameters[footer_class]" class="form-control">
                    @foreach ($footerClasses as $class)
                        <option @if ($class === $footerClass) selected @endif value="{{ $class }}">{{ $class }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="template">Template</label>
                <select name="template" class="form-control">
                    <option value="0">No template selected</option>
                    @foreach (\App\Models\Template::ALL_TEMPLATES as $template)
                        <option value="{{ $template }}"
                        @if((int)old('template', $pageInstance->template ?? 0) === $template) selected @endif
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
