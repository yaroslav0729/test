@php
    if (!$upsell) {
        $actionRoute = route('admin.upsells.store');
    } else {
        $actionRoute = route('admin.upsells.update', ['id' => $upsell->id]);
    }
@endphp

@extends('layouts.admin')

@section('content')
    <div id="admin_content" class="flex-auto">
        <div class="p-5 pb-8 lg:w-1/2">
            <h1>Banner</h1>

            <form action="{{ $actionRoute }}" method="post">
                @csrf

                @isset($upsell)
                    @method('PUT')
                @endisset

                 <div class="form-group">
                    <label for="title">Title</label><br>
                    <input id="title" required name="title" class="form-control" type="text"
                        value="{{ old('name', $upsell->title ?? null) }}">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input class="form-control" id="description"
                              name="description" value="{{ old('description', $upsell->description ?? null) }}" />
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input class="form-control" id="price" type="number"
                              name="price" value="{{ old('price', $upsell->price ?? null) }}" />
                </div>

                <div class="form-check">
                    <input class="form-check-input" id="active" name="active" type="checkbox" value="1"
                           @if (old('active', $upsell->active ?? false)) checked @endif>
                    <label for="active" class="form-check-label">Active</label>
                </div>

                <hr>
                <button class="btn btn-info" type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection
