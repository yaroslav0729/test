@php
    if (isset($redirect)) {
        $pageTitle = 'Edit redirect id: ' . $redirect->id;
        $actionRoute = route('admin.redirects.update', ['redirect' => $redirect->id]);
    } else {
        $pageTitle = 'Create redirect:';
        $actionRoute = route('admin.redirects.store');
    }
@endphp

@extends('layouts.admin')

@section('content')

<div id="admin_content" class="bg-gray-100 flex-auto">
    <div class="p-5 pb-8 lg:w-1/2">
        <h1>{{ $pageTitle }}</h1>

        <form action="{{ $actionRoute }}" method="post" prices-form>
            @csrf

            @isset($redirect)
                @method('PUT')
            @endisset

            <div class="form-group">
                <label for="url_from">Url from</label><br>
                <input id="url_from" required name="url_from" class="form-control" type="text" value="{{ old('url_from', $redirect->url_from ?? null) }}" /><br>
            </div>

            <div class="form-group">
                <label for="url_to">Url to</label><br>
                <input id="url_to" required name="url_to" class="form-control" type="text" value="{{ old('url_to', $redirect->url_to ?? null) }}" /><br>
            </div>

            <div class="form-group">
                <label for="type">Type</label><br>
                <select name="type" class="form-control">
                    @foreach (\App\Models\Redirect::TYPES as $type => $typeLabel)
                      <option value="{{ $type }}"
                      @if(old('type', $redirect->type ?? null) === $type) selected @endif
                      >{{ $typeLabel }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-info" type="submit">
                Submit
            </button>

        </form>

    </div>
</div>

@endsection
