@extends('layouts.admin')

@section('content')
@php
if ($donation->campaign)
{
    $campaign = $donation->campaign->name;
}elseif(isset($donation->foodpackqurbani)) {
    $campaign = $donation->foodpackqurbani->country->name. " Qurbani (" . $donation->foodpackqurbanitype->name . ")";
}elseif(isset($donation->foodpack)) {
    $campaign = "FoodPack " . $donation->foodpack->country->name;
} elseif($donation->upsell) {
    $campaign = $donation->name ?? 'Provide Rice This Eid';
}else {
    $campaign = 'no campaign';
}
@endphp

    <div id="admin_content" class="flex-auto">
        <div class="p-5 pb-8">
            <a href="{{ url()->previous() }}" class="btn-back mb-3"><i class="moon-icons-arrow-left"></i> BACK</a>
            <h1 class="mt-3">Donation id: {{ $donation->id }}</h1>
            <b>Islamic Help ID:</b> {{ 'IH' . sprintf('%07d', $donation->order_id) }}<br>
            <b>Value:</b> {{ $donation->currrency_sign }}{{ $donation->value }}<br>
            <b>Type:</b> {{ $donation->type_name }}<br>
            @if($donation->is_recurring)
                <b>Is Recurring:</b> {{ $donation->is_recurring ? 'Yes' : 'No' }}<br>
            @endif
            <b>Category:</b> {{ $donation->campaign_category ? $donation->campaign_category->name : 'no category' }}<br>
            <b>Campaign:</b> {{ $campaign }}<br>
            <b>Qurbani Name:</b> {{ $donation->qurbani_name }}<br>
            <b>Plaque Name:</b> {{ $donation->note }}<br>
            <b>User:</b> {{ $donation->user ? $donation->user->name : 'no user' }}<br>
            <b>Email:</b> {{ $donation->email }}<br>
            <b>Date:</b> {{ $donation->created_at->format('d/m/Y') }} <br>
            <b>IP:</b> {{ $donation->ip }} <br>
            <b>Help This Donations 100%:</b> {{ !empty($donation->commission) ? 'Yes' : 'No' }} <br>
            <hr>
            <b>Note:</b><br>
            <form action="{{ route('admin.donations.update', ['donation' => $donation->id]) }}" method="POST">
                @csrf
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Title:</label>
                            <select class="form-control" required name="title">
                                <option value="mr" @if($donation->order->title === 'mr') selected @endif>Mr</option>
                                <option value="mrs" @if($donation->order->title === 'mrs') selected @endif>Mrs</option>
                                <option value="miss" @if($donation->order->title === 'miss') selected @endif>Miss</option>
                                <option value="ms" @if($donation->order->title === 'ms') selected @endif>Ms</option>
                                <option value="dr" @if($donation->order->title === 'dr') selected @endif>Dr</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>First Name:</label>
                            <input class="form-control" required name="first_name" value="{{ $donation->order->first_name }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Last Name:</label>
                            <input class="form-control" required name="last_name" value="{{ $donation->order->last_name }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Email:</label>
                            <input class="form-control" required name="email" value="{{ $donation->order->email }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Note:</label>
                            <textarea class="form-control" name="note" value="{{ $donation->note }}"
                                rows="5">{{ $donation->note }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <button class="btn btn-info" type="submit">
                            Save
                        </button>
                    </div>
                </div>
            </form>
            <br>
            <hr>
            @isset($donation->order)
                <h3>Order data:</h3>
                <b>Title:</b> {{ $donation->order->title }}<br>
                <b>First name:</b> {{ $donation->order->first_name }}<br>
                <b>Last name:</b> {{ $donation->order->last_name }}<br>
                <b>Post code:</b> {{ $donation->order->post_code }}<br>
                <b>Address 1:</b> {{ $donation->order->address_1 }}<br>
                <b>Address 2:</b> {{ $donation->order->address_2 }}<br>
                <b>Address 3:</b> {{ $donation->order->address_3 }}<br>
                <b>City:</b> {{ $donation->order->city }}<br>
                <b>State:</b> {{ $donation->order->state }}<br>
                <b>Country:</b> {{ $donation->order->country }}<br>
                <b>Phone:</b> {{ $donation->order->phone }}<br>
                <b>Email:</b> {{ $donation->order->email }}<br>
                <b>Notes:</b> {{ $donation->order->notes }}<br>
                <b>Gift aid:</b> {{ $donation->order->gift_aid ? 'yes' : 'no' }}<br>
                <b>Do calls:</b> {{ $donation->order->do_calls ? 'yes' : 'no' }}<br>
                <b>Do sms:</b> {{ $donation->order->do_sms ? 'yes' : 'no' }}<br>
                <b>Do email:</b> {{ $donation->order->do_email ? 'yes' : 'no' }}<br>
                <b>Do post:</b> {{ $donation->order->do_post ? 'yes' : 'no' }}<br>
                <b>Pay with:</b> {{ $donation->order->pay_with }}<br>
                <b>Order id:</b> {{ $donation->order->order_id }}<br>
                @isset($donation->order->subscription_id)
                    <b>Subscription id:</b> {{ $donation->order->subscription_id }}<br>
                    @if($donation->order->is_subscription_active === true)
                        <form method="post"
                              action="{{ route('admin.donation.cancel-subscription', ['subscriptionId' => $donation->order->subscription_id]) }}"
                              style="display:inline-block">

                            @csrf

                            <button class="btn btn-danger mt-2" onclick="return confirm('Are you sure want to cancel subscription?')">Cancel Subscription</button>

                        </form>
                    @endif
                @endisset
            @endisset

        </div>
    </div>

@endsection
