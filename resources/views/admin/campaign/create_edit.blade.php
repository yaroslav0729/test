@php
    if (isset($campaign)) {
        $pageTitle = 'Edit campaign id: ' . $campaign->id;
        $actionRoute = route('admin.campaigns.update', ['campaign' => $campaign->id]);
    } else {
        $pageTitle = 'Create campaign:';
        $actionRoute = route('admin.campaigns.store');
    }
@endphp

@extends('layouts.admin')

@section('content')

    <div id="admin_content" class="flex-auto">
        <div class="p-5 pb-8 lg:w-1/2">
            <h1>{{ $pageTitle }}</h1>

            <form action="{{ $actionRoute }}" method="post" prices-form>
                @csrf

                @isset($campaign)
                    @method('PUT')
                @endisset

                <div class="form-group">
                    <label for="name">Name</label><br>
                    <input id="name" required name="name" class="form-control" type="text"
                        value="{{ old('name', $campaign->name ?? null) }}" /><br>
                </div>

                <div class="form-group">
                    <label for="description">description</label><br>
                    <textarea id="description" required class="form-control" name="description">{{ old('description', $campaign->description ?? null) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="country_id">Country</label><br>
                    <select name="country_id" class="form-control">
                        <option value="">Not selected</option>
                        @foreach (\App\Models\Country::getAllEnabled() as $country)
                            <option value="{{ $country->id }}" @if (old('countryId', $campaign->country_id ?? null) === $country->id) selected @endif>
                                {{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">MNA</label><br>
                    <select name="most_needed_area" class="form-control">
                        <option value="">Not selected</option>
                        @foreach (\App\Models\Country::getAllEnabled() as $country)
                            <option value="{{ $country->id }}" @if (old('mostNeededArea', $campaign->most_needeed_area ?? null) === $country->id) selected @endif>
                                {{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="project_name">Project name</label><br>
                    <input id="project_name" name="project_name" class="form-control" type="text"
                        value="{{ old('project_name', $campaign->project_name ?? null) }}" /><br>
                </div>

                <div class="form-group">
                    <label for="program_name">Program name</label><br>
                    <input id="program_name" name="program_name" class="form-control" type="text"
                        value="{{ old('program_name', $campaign->program_name ?? null) }}" /><br>
                </div>

                <div class="form-group">
                    <label for="name">Start date</label><br>
                    <input id="name" required name="start_date" class="form-control" type="date"
                        value="{{ old('start_date', $campaign->start_date ?? null) }}" /><br>
                </div>

                <div class="form-group">
                    <label for="name">End date</label><br>
                    <input id="name" required name="end_date" class="form-control" type="date"
                        value="{{ old('end_date', $campaign->end_date ?? null) }}" /><br>
                </div>

                {{-- @php
                $getProgramList = getProgramList();
                $getallCountries = getallCountries();
                @endphp
                 <div class="form-group">
                    <label for="description">Icharme Program List</label><br>
                    <select name="icharm_program_id" class="form-control">
                        <option value="">Not selected</option>
                        @foreach ($getProgramList as $programList)
                            <option value="{{ $programList['program_id'] }}" @if (old('icharm_program_id', $campaign->icharm_program_id ?? null) === $programList['program_id']) selected @endif>{{ $programList['program_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Icharme Country List</label><br>
                    <select name="icharm_country_id" class="form-control">
                        <option value="">Not selected</option>
                        @foreach ($getallCountries as $countryList)
                            <option  value="{{ $countryList['country_id'] }}" @if (old('icharm_country_id', $campaign->icharm_country_id ?? null) === $countryList['country_id']) selected @endif >{{ $countryList['country_name'] }}</option>
                        @endforeach
                    </select>
                </div> --}}

                <div class="form-group">
                    <label for="is_emergency">Is emergency</label>
                    <input type="hidden" name="is_emergency" value="0">
                    <input id="is_emergency" name="is_emergency" value="1" type="checkbox"
                        @if (old('is_emergency', $campaign->is_emergency ?? null)) checked @endif /><br>
                </div>

                <div price-container>
                    <label for="groups">Campaign prices</label><br>
                    <button price-add class="btn btn-success mb-3" type="button">Add new price</button>

                    <div class="d-none" price-stub stub-fields>
                        <div class="form-group form-inline price">
                            <input name="prices_new[]" class="form-control mr-2" placeholder="Add price here"
                                type="number" />
                            <select name="price_types_new[]" class="form-control mr-2">
                                @foreach (\App\Models\CampaignPrice::ALL_TYPES as $priceId => $priceLabel)
                                    <option value="{{ $priceId }}" />{{ $priceLabel }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-danger" price-delete title="delete price" type="button"><i
                                    class="far fa-trash-alt"></i></button>
                        </div>
                    </div>

                    <div class="" price-list>
                        @isset($campaign)
                            @foreach ($campaign->campaign_prices as $price)
                                <div class="form-group form-inline price">
                                    <input name="prices[{{ $price->id }}]" required class="form-control mr-2" type="number"
                                        value="{{ $price->value }}">
                                    <select name="price_types[{{ $price->id }}]" class="form-control mr-2">
                                        @foreach (\App\Models\CampaignPrice::ALL_TYPES as $priceId => $priceLabel)
                                            <option value="{{ $priceId }}"
                                                @if ($price->type === $priceId) selected @endif />
                                            {{ $priceLabel }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-danger" price-delete title="delete price" type="button"><i
                                            class="far fa-trash-alt"></i></button>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>

                <div class="form-group">
                    <label for="groups">Campaign categories</label>
                    <select id="groups" name="categories[]" multiple class="form-control">
                        @foreach (\App\Models\CampaignCategory::all() as $category)
                            @php
                                $selected = false;
                                if (isset($campaign) && in_array($category->id, $campaign->campaign_categories_ids)) {
                                    $selected = true;
                                }
                            @endphp
                            <option value="{{ $category->id }}" @if ($selected) selected @endif>
                                {{ $category->name }}</option>
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
