@extends('layouts.admin')

@section('content')
    
<div id="admin_content" class="bg-gray-100 flex-auto h-screen">
    <div class="p-5 pb-8">
    <h1>Donation id: {{ $donation->id }}</h1>

    <b>Value:</b> {{ $donation->currrency_sign }}{{ $donation->value }}<br>
    <b>Type:</b> {{ $donation->type_name }}<br>
    <b>Campaign:</b> {{ $donation->campaign ? $donation->campaign->name : 'no campaign' }}<br>
    <b>User:</b> {{ $donation->campaign ? $donation->user->name : 'no user' }}<br>
    <b>Email:</b> {{ $donation->email }}<br>
    <b>Date:</b> {{ $donation->created_at->format('d/m/Y') }} <br>
    <hr>
    <b>Note:</b><br>
    {{ $donation->note }}
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
        <b>Do calls:</b> {{ $donation->order->do_calls ? 'yes' : 'no' }}<br>
        <b>Do sms:</b> {{ $donation->order->do_sms ? 'yes' : 'no' }}<br>
        <b>Do email:</b> {{ $donation->order->do_email ? 'yes' : 'no' }}<br>
        <b>Pay with:</b> {{ $donation->order->pay_with }}<br>
        <b>Order id:</b> {{ $donation->order->order_id }}<br>
    @endisset
        
    </div>
</div>

@endsection
