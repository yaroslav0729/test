@php
if (!$banner) {
    $actionRoute = route('admin.banner.store');
} else {
    $actionRoute = route('admin.banner.update', ['id' => $banner->id]);
}
@endphp

@extends('layouts.admin')

@section('content')
    <div id="admin_content" class="flex-auto">
        <div class="p-5 pb-8 lg:w-1/2">
            <h1>Banner</h1>

            <form action="{{ $actionRoute }}" method="post">
                @csrf

                @isset($banner)
                    @method('PUT')
                @endisset

                {{-- <div class="form-group">
                    <label for="name">Name</label><br>
                    <input id="name" required name="name" class="form-control" type="text"
                        value="{{ old('name', $banner->name ?? null) }}">
                </div> --}}

                <div class="form-group">
                    <label for="color">Background color</label>
                    <div id="colorpicker" class="input-group"
                        data-color="{{ old('color', $banner->color ?? '#FFFFFF') }}">
                        <input id="color" name="color" class="form-control" type="text">
                        <span class="input-group-append">
                            <span class="input-group-text colorpicker-input-addon"><i></i></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea wysiwyg-editor class="form-control" id="main_html"
                        name="content">{{ old('content', $banner->content ?? null) }}</textarea>
                </div>

                <div class="form-check">
                    <input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="1"
                        @if (old('is_active', $banner->is_active ?? false)) checked @endif>
                    <label for="is_active" class="form-check-label">Active</label>
                </div>

                <hr>
                <button class="btn btn-info" type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection
