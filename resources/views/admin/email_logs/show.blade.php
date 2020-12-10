@extends('layouts.admin')

@section('content')

<h2>Email log id: {{ $emailLog->id }}</h2>

<p><b>Subject:</b> {{ $emailLog->subject }}</p>

<p><b>Email body:</b></p>
{!! $emailLog->body !!}

@endsection