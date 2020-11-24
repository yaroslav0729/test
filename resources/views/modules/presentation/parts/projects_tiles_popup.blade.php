@php

$singlePrices = \App\Models\Project::getSinglePrices($project);
$monthlyPrices = \App\Models\Project::getMonthlyPrices($project);

@endphp


<div class="form d-none tiles-popup_{{ $popupKey }}" tiles-popup>
    <i class="fal fa-check close"></i>
    <div class="name">Environmental sustainabilty</div>
    <form action="/">

        <div class="form-group">
            <select class="form-control" tiles-options data-key={{ $popupKey }}>
                @if(count($singlePrices))
                <option value="single">Single donation</option>
                @endif
                @if(count($monthlyPrices))
                <option value="monthly">Monthly donation</option>
                @endif
            </select>
        </div>

        @if(count($singlePrices))
        <div class="form-group tiles_options_single_{{ $popupKey }}" tiles-option>
            <select class="form-control">
                @foreach ($singlePrices as $price)
                    <option value="{{ $price }}"><b>£ {{ $price }}</b></option>     
                @endforeach
            </select>
        </div>
        @endif

        @if(count($monthlyPrices))
        <div class="form-group tiles_options_monthly_{{ $popupKey }} d-none" tiles-option>
            <select class="form-control">
                @foreach ($monthlyPrices as $price)
                    <option value="{{ $price }}"><b>£ {{ $price }}</b></option>     
                @endforeach
            </select>
        </div>
        @endif
        
        <div class="form-group">
            <select class="form-control">
                <option value="1">Category 1</option>
                <option value="1">Category 2</option>
            </select>
        </div>
        <div class="text-center pt-3">
            <a href="#" class="btn btn-danger">Add donation</a>
        </div>
    </form>
</div>