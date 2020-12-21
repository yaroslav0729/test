@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        @include('templates.presentation.parts.back_btn')
    </div>

    <div id="admin_content" class="bg-gray-100 flex-auto h-screen">
        <div class="p-5 pb-8 lg:w-1/2">
            <h1>
                Update {{ $menuName }}
            </h1>

            <form 
                id="create-menu-item"
                action="{{ route('admin.menu_items.update', $menuId) }}"
                method="post"
            >
                @method('PUT')
                @include('admin.menu_items.form')
            </form>
        </div>
    </div>

@endsection