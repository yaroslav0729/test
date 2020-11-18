@extends('layouts.admin')

@section('content')

<h2>Settings:</h2>

<ul>
    <li><a href="{{ route('admin.pages.edit', ['page' => $indexPage->page->id]) }}">Index page (Home)</a></li>
    <li><a href="{{ route('admin.pages.edit', ['page' => $projectsPage->page->id]) }}">Projects page</a></li>
</ul>

@endsection