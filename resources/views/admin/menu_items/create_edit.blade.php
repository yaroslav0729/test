@php

    $isChecked = '';
    $isDisabled = '';

    if(old('is_group')) {
        $isChecked = 'checked';
    }

    if(isset($menuItem)) {
        $isChecked = $menuItem->is_group ? 'checked' : '';
        $isDisabled = 'disabled';
    }

    $isMenuAdditional = false;
    if (isset($menuSlug)) {
         $isMenuAdditional = \App\Models\MenuItem::getMenuDestination($menuSlug) === \App\Models\MenuItem::ADDITIONAL_HEADER_MENU;
    }

    if (old('slug')) {
        $isMenuAdditional = \App\Models\MenuItem::getMenuDestination(old('slug')) === \App\Models\MenuItem::ADDITIONAL_HEADER_MENU;
    }

@endphp

@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        @include('templates.presentation.parts.back_btn')
    </div>

    <div id="admin_content" class="bg-gray-100 flex-auto h-screen">
        <div class="p-5 pb-8 lg:w-1/2">
            <h1>
                @if(isset($menuItem))
                    Update
                @else
                    Create
                @endif
                {{ ucfirst($menuSlug) }} menu
            </h1>

            <form id="create-menu-item"
                  @if (isset($menuItem))
                  action="{{ route('admin.menu_items.update', ['menuSlug' => old('slug') ?? $menuSlug, 'id' => $menuItem->id]) }}"
                  @else
                  action="{{ route('admin.menu_items.store', ['menuSlug' => old('slug') ?? $menuSlug]) }}"
                  @endif
                  method="post">
                @csrf

                @isset($menuItem)
                    @method('PUT')
                @endisset

                <input type="hidden" name="destination"
                       value="{{ old('destination') ?? $menuDestination ?? $menuItem->destination ?? '' }}">
                <input type="hidden" name="parent_id"
                       value="{{ old('parent_id') ?? $parentId ?? $menuItem->parent_id ?? '' }}">
                <input type="hidden" name="slug" value="{{ old('slug') ?? $menuSlug }}">
                <div class="form-group">
                    <label for="text">Text</label><br>
                    <input id="text" name="text" class="form-control" type="text"
                           value="{{ old('text') ?? $menuItem->text ?? '' }}"/>
                </div>
                    @if(!$isMenuAdditional)
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_group" name="is_group"
                                    {{ $isChecked }} {{ $isDisabled }} >
                                <input type="hidden"
                                       @isset($menuItem)
                                       @if($menuItem->is_group)
                                       name="is_group"
                                       @endif
                                       @endisset
                                       checked="checked" value="on">
                                <label class="form-check-label" for="is_group">Is group</label>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="link">Link</label><br>
                        <input id="link" name="link" class="form-control"
                               value="{{ old('link') ?? $menuItem->link ?? '' }}"
                               @if(old('is_group')) disabled @endif

                               @isset($menuItem)
                               @if($menuItem->is_group) disabled @endif
                            @endisset
                        />
                    </div>
                    <button class="btn btn-info" type="submit">
                        Submit
                    </button>
            </form>
        </div>
    </div>

@endsection
