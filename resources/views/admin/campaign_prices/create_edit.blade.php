@php
    if (isset($campaignPrice)) {
        $pageTitle = 'Edit campaign price id: ' . $campaignPrice->id;
        $actionRoute = route('admin.campaign_prices.update', ['campaign_price' => $campaignPrice->id]);
        
        $value = $campaignPrice->value;
        $type = $campaignPrice->type;

    } else {
        $pageTitle = 'Create campaign price:';
        $actionRoute = route('admin.campaign_prices.store');
        $value = old('value');
        $type = old('type');
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

            @isset($campaignPrice)
                @method('PUT')
            @endisset

            <div class="form-group">
                <label for="value">Value</label><br>
                <input id="value" required name="value" class="form-control" type="number" value="{{ $value }}" /><br>
            </div>

            <div class="form-group">
                <label for="type">Type</label><br>
                <select name="type" class="form-control">
                    <option value="">Not selected</option>
                    @foreach (\App\Models\CampaignPrice::ALL_TYPES as $typeId => $label)
                      <option value="{{ $typeId }}"
                      @if($type === $typeId) selected @endif
                      >{{ $label }}</option>
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