@extends('layouts.user')

@section('content')

<div class="p-3">
<h2>User dashboard</h2>

<div>Name: {{ Auth::user()->name }}</div>
<div>Email: {{ Auth::user()->email }}</div>

</div>

@endsection
