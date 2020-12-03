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
    

        
    </div>
</div>

@endsection
