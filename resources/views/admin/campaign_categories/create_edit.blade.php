@php
    if (isset($campaignCategory)) {
        $pageTitle = 'Edit campaign category id: ' . $campaignCategory->id;
        $actionRoute = route('admin.campaign_categories.update', ['campaign_category' => $campaignCategory->id]);
    } else {
        $pageTitle = 'Create campaign category:';
        $actionRoute = route('admin.campaign_categories.store');
    }
@endphp

@extends('layouts.admin')

@section('content')

<div id="admin_content" class="bg-gray-100 flex-auto">
    <div class="p-5 pb-8 lg:w-1/2">
        <h1>{{ $pageTitle }}</h1>

        <form action="{{ $actionRoute }}" method="post">
            @csrf

            @isset($campaignCategory)
                @method('PUT')
            @endisset

            <div class="form-group">
                <label for="name">Name</label><br>
                <input id="name" required name="name" class="form-control" type="text" value="{{ old('name', $campaignCategory->name ?? null) }}" /><br>
            </div>

            <button class="btn btn-info" type="submit">
                Submit
            </button>

        </form>

    </div>
</div>

@endsection
