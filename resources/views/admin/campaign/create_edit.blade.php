@php
    if (isset($campaign)) {
        $pageTitle = 'Edit campaign id: ' . $campaign->id;
        $actionRoute = route('admin.campaigns.update', ['campaign' => $campaign->id]);
        $name = $campaign->name;
        $description = $campaign->description;
        $startDate = $campaign->start_date;
        $endDate = $campaign->end_date;
        $countryId = $campaign->country_id;
    } else {
        $pageTitle = 'Create campaign:';
        $actionRoute = route('admin.campaigns.store');
        $name = old('name');
        $description = old('description');
        $startDate = old('startDate');
        $endDate = old('endDate');
        $countryId = null;
    }
@endphp

@extends('layouts.admin')

@section('content')

<div id="admin_content" class="bg-gray-100 flex-auto h-screen">
    <div class="p-5 pb-8 lg:w-1/2">
        <h1>{{ $pageTitle }}</h1>

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

            @isset($campaign)
                @method('PUT')
            @endisset

            <div class="form-group">
                <label for="name">Name</label><br>
                <input id="name" required name="name" class="form-control" type="text" value="{{ $name }}" /><br>
            </div>

            <div class="form-group">
                <label for="description">description</label><br>
                <textarea id="description" required class="form-control" name="description">{{ $description }}</textarea>
            </div>

            <div class="form-group">
                <label for="description">Country</label><br>
                <select name="country_id" class="form-control">
                    <option value="">Not selected</option>
                    @foreach (\App\Models\Country::getAllEnabled() as $country)
                      <option value="{{ $country->id }}"
                      @if($countryId === $country->id) selected @endif
                      >{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="name">Start date</label><br>
                <input id="name" required name="start_date" class="form-control" type="date" value="{{ $startDate }}" /><br>
            </div>

            <div class="form-group">
                <label for="name">End date</label><br>
                <input id="name" required name="end_date" class="form-control" type="date" value="{{ $endDate }}" /><br>
            </div>

            <button class="btn btn-info" type="submit">
                Submit
            </button>

        </form>

    </div>
</div>

@endsection