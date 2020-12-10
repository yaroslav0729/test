@extends('layouts.admin')

@section('content')

<h2>Email log id: {{ $emailLog->id }}</h2>

<p><b>Subject:</b> {{ $emailLog->subject }}</p>

<p><b>Email body:</b></p>

<a href="{{ route('admin.email_logs.show_email', ['email_log' => $emailLog->id]) }}" target="_blank">
Show email body
</a>

@endsection