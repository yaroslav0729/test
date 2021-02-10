@php

$projPageInstance = $project->actual_page_instance;

@endphp

<div class="form d-none tiles-popup_{{ $popupKey }}" tiles-popup>
    <i class="fal fa-check close"></i>
    <div class="name">Environmental sustainabilty</div>

    <form action="{{ route('cart.add') }}" method="post">
        @csrf
        <input type="hidden" name="project_id" value="{{ $popupKey }}">

        <div class="form-group tiles_options_single_{{ $popupKey }}" tiles-option-price>
            <select name="price_single" class="form-control font-weight-bold" tiles-form-options>
                {{-- will be filled in js --}}
            </select>
        </div>

        <div class="form-group tiles_options_monthly_{{ $popupKey }} d-none" tiles-option-price >
            <select name="price_monthly" class="form-control" tiles-form-options>
                {{-- will be filled in js --}}
            </select>
        </div>

        <div class="form-group">
            <select name="period" class="form-control" tiles-options-type tiles-form-options data-key={{ $popupKey }}>
                <option value="single">Single donation</option>
                <option value="monthly">Monthly donation</option>
            </select>
        </div>

        <input type="hidden" name="amount" >

        <div class="form-group">
            <select name="campaigns" class="form-control" tiles-campaigns>
                {{-- will be filled in js --}}
            </select>
        </div>

        <div class="form-group">
            <select name="categories" class="form-control" tiles-categories>
                {{-- will be filled in js --}}
            </select>
        </div>
        <div class="text-center pt-3">
            <a href="#" class="btn_sbmt btn btn-danger">Add donation</a>
        </div>
    </form>
</div>
