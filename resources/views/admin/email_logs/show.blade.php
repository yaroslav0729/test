@extends('layouts.admin')

@section('content')

<h2>Email log id: {{ $emailLog->id }}</h2>

<p><b>Email to:</b> {{ $emailLog->email_to }}</p>
<p><b>Email from:</b> {{ $emailLog->email_from }}</p>
<p><b>Subject:</b> {{ $emailLog->subject }}</p>


<a href="{{ route('admin.email_logs.show_email', ['email_log' => $emailLog->id]) }}" target="_blank">
Show email body
</a>

<div class="container-fluid">
    <iframe src="{{ route('admin.email_logs.show_email', ['email_log' => $emailLog->id]) }}"
        width="100%" height="800">
    </iframe>
</div>

@endsection