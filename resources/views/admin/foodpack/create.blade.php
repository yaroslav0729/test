@extends('layouts.admin')

@section('content')

    <div id="admin_content" class="flex-auto">
        <div class="p-5 pb-8">
            <h1>Food Pack Price Create</h1>

            <a href="{{ route('admin.foodpack.index') }}">
                <button class="btn btn-info mt-3 mb-3" type="button" title="Back">
                    <i class="fas fa-reply mr-2"></i>Back
                </button>
            </a>

            <form action="{{ route('admin.foodpack.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <label for="price">Price</label><br>
                <input id="price" name="price" class="form-control" type="text" value="{{ old('price') }}" /><br>

                <label for="country_id">Country</label><br>
                <select name="country_id" class="form-control mb-3">
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>

                <label for="campaign_name">Campaign Name</label><br>
                <input id="campaign_name" name="campaign_name" class="form-control" type="text" value="{{ old('campaign_name') }}" /><br>

                <label for="project_name">Project Name</label><br>
                <input id="project_name" name="project_name" class="form-control" type="text" value="{{ old('project_name') }}" /><br>

                <label for="program_name">Program Name</label><br>
                <input id="program_name" name="program_name" class="form-control" type="text" value="{{ old('program_name') }}" /><br>

                <label for="campaign_category_id">Category</label><br>
                <select name="campaign_category_id" class="form-control mb-3">
                    <option value="">Select Category</option>
                    @foreach(\App\Models\CampaignCategory::all() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <button class="btn btn-info" type="submit">
                    Submit
                </button>
            </form>

        </div>
    </div>

@endsection
