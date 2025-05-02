@extends('layouts.admin')

@section('content')

    <div id="admin_content" class="flex-auto">
        <div class="p-5 pb-8">
            <h1>Food Pack Qurbani Price Edit #{{ $foodpack->id }}</h1>

            <a href="{{ route('admin.foodpack-qurbanies.index') }}">
                <button class="btn btn-info mt-3 mb-3" type="button" title="Back">
                    <i class="fas fa-reply mr-2"></i>Back
                </button>
            </a>

            <form action="{{ route('admin.foodpack-qurbanies.update', $foodpack->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <label for="country_id">Country</label><br>
                <select name="country_id" class="form-control mb-3">
                    @foreach($countries as $country)
                        <option @if($foodpack->country_id == $country->id) selected @endif value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>

                <label for="campaign_id">Campaign</label><br>
                <select id="campaign_id" name="campaign_id" class="form-control mb-3">
                    <option value="">Select Campaign</option>
                    @foreach($campaigns as $campaign)
                        <option value="{{ $campaign->id }}" {{ $foodpack->campaign_id == $campaign->id ? 'selected' : '' }}>
                            {{ $campaign->name }}
                        </option>
                    @endforeach
                </select><br>

                <label for="project_name">Project Name</label><br>
                <input id="project_name" name="project_name" class="form-control" type="text" value="{{ $foodpack->project_name }}" /><br>

                <label for="program_name">Program Name</label><br>
                <input id="program_name" name="program_name" class="form-control" type="text" value="{{ $foodpack->program_name }}" /><br>

                <label for="campaign_category_id">Category</label><br>
                <select name="campaign_category_id" class="form-control mb-3">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if($foodpack->campaign_category_id == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                @foreach($foodpack->types as $type)
                    <label for="name">Price Of {{ $type->name }}</label><br>
                    <input type="hidden" name="types[]" value="{{ $type->id }}">
                    <input id="price" name="prices[]" required class="form-control" value="{{ $type->pivot->price }}" type="text" /><br>
                @endforeach

                <button class="btn btn-info" type="submit">
                    Submit
                </button>
            </form>

        </div>
    </div>

@endsection
