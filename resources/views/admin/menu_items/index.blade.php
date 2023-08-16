@extends('layouts.admin')

@section('content')

    <div class="mb-4">
        @include('templates.presentation.parts.back_btn')
    </div>

    <div class="flex-auto">
        <div class="p-5 pb-8">
            <ul class="nav">
                @foreach ($menuTypes as $slug => $name)
                    <li class="nav-item">
                        <a href="{{ route('admin.menu_items.show', $slug) }}" class="nav-link">{{ $name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection