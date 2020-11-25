@php

$projPageInstance = $project->actual_page_instance;
$projectOptions = \App\Models\Project::getProjectOptions($projPageInstance);

$singlePrices = [];
$monthlyPrices = [];

if (isset($projectOptions['single'])) {

    foreach ($projectOptions['single'] as $key => $option) {
        $singlePrices[] = $option['price'];
    }
}

if (isset($projectOptions['monthly'])) {
    foreach ($projectOptions['monthly'] as $key => $price) {
        $monthlyPrices[] = $price['price'];
    }
}

@endphp

<div class="form d-none tiles-popup_{{ $popupKey }}" tiles-popup>
    <i class="fal fa-check close"></i>
    <div class="name">Environmental sustainabilty</div>

    <div class="project_popup_options alert alert-warning d-none">
        {{ json_encode($projectOptions) }}
    </div>

    <form action="/">

        <div class="form-group">
            <select name="type" class="form-control" tiles-options-type tiles-form-options data-key={{ $popupKey }}>
                @if(count($singlePrices))
                <option value="single">Single donation</option>
                @endif
                @if(count($monthlyPrices))
                <option value="monthly">Monthly donation</option>
                @endif
            </select>
        </div>

        @if(count($singlePrices))
        <div class="form-group tiles_options_single_{{ $popupKey }}" tiles-option-price>
            <select name="price_single" class="form-control" tiles-form-options>
                @foreach ($singlePrices as $price)
                    <option value="{{ $price }}"><b>£ {{ $price }}</b></option>     
                @endforeach
            </select>
        </div>
        @endif

        @if(count($monthlyPrices))
        <div class="form-group tiles_options_monthly_{{ $popupKey }} d-none" tiles-option-price >
            <select name="price_monthly" class="form-control" tiles-form-options>
                @foreach ($monthlyPrices as $price)
                    <option value="{{ $price }}"><b>£ {{ $price }}</b></option>     
                @endforeach
            </select>
        </div>
        @endif

        <div class="form-group">
            <select name="campaign" class="form-control" tiles-campaigns>
                {{-- will be filled in js --}}
            </select>
        </div>
        
        <div class="form-group">
            <select name="category" class="form-control" tiles-categories>
                {{-- will be filled in js --}}
            </select>
        </div>
        <div class="text-center pt-3">
            <a href="#" class="btn btn-danger">Add donation</a>
        </div>
    </form>
</div>