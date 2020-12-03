@php

$isSubMenu = '';

if (request('submenu')) {
    if(\App\Models\MenuItem::find(request('submenu'))) {
         $isSubMenu = request('submenu');
    }
}

@endphp

@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        @include('templates.presentation.parts.back_btn')
    </div>

    <div class="bg-gray-100 flex-auto">
        <div class="p-5 pb-8">
            <h1>{{ \App\Models\MenuItem::ALL_TYPES_MENU[$menuDestination] }}:</h1>

            @if($isSubMenu)
                @if(\App\Models\MenuItem::getMenuDestination($menuSlug) === \App\Models\MenuItem::HEADER_MENU && \App\Models\MenuItem::arrayDepth($isSubMenu) > 2)
                    <div class="alert alert-info" role="alert">
                        For this type of menu, only two nesting levels matter. More than two levels are non-sence, because only two of them can be displayed.
                    </div>
                @endif

                @if(\App\Models\MenuItem::getMenuDestination($menuSlug) === \App\Models\MenuItem::FOOTER_MENU && \App\Models\MenuItem::arrayDepth($isSubMenu) > 1)
                    <div class="alert alert-info" role="alert">
                        For this type of menu, only one nesting level matters. More than one level is non-sence, because only one of them can be displayed.
                    </div>
                @endif
            @endif

            <form method="post" action="{{ route('admin.menu_items.create', ['menuSlug' => $menuSlug]) }}"
                  style="display:inline-block">
                @csrf
                <input type="hidden" name="destination" value="{{ $menuDestination }}">
                @if($isSubMenu)
                    <input type="hidden" name="parent_id" value="{{ $isSubMenu }}">
                @endif
                <input type="hidden" name="slug" value="{{ $menuSlug }}">
                <button class="btn btn-success mt-3 mb-3" type="submit" title="Create submenu">
                    <i class="far fa-plus-square mr-2"></i>Create
                </button>
            </form>

            <table class="table-auto mb-3">
                <thead>
                <tr>
                    <th class="px-4 py-2">Text</th>
                    <th class="px-4 py-2">Is group</th>
                    <th class="px-4 py-2">Link</th>
                    <th class="px-4 py-2">Ordering</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($menuItems as $item)
                    <tr>
                        <td class="border px-4 py-2">
                            @if($item->subMenus->count())
                                <a href="{{ route('admin.menu_items.index', ['menuSlug' => $menuSlug, 'submenu' => $item->id]) }}"> {{ $item->text }}</a>
                            @else
                                {{ $item->text }}
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-success">
                            @if($item->is_group)  <i class="fas fa-check"></i> @endif
                        </td>

                        <td class="border px-4 py-2">{{ $item->link }}</td>
                        <td class="border px-4 py-2 action_td text-right">
                            @if($item->is_group)
                                <form method="post"
                                      action="{{ route('admin.menu_items.create', ['menuSlug' => $menuSlug]) }}"
                                      style="display:inline-block">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $item->id }}">
                                    <input type="hidden" name="destination"
                                           value="{{ $menuDestination }}">
                                    <input type="hidden" name="slug" value="{{ $menuSlug }}">
                                    <button class="btn btn-success action-btn" type="submit" title="Create submenu">
                                        <i class="far fa-plus-square"></i>
                                    </button>

                                </form>
                            @endif

                            <form method="post"
                                  action="{{ route('admin.menu_items.edit', ['menuSlug'=> $menuSlug, 'id' => $item->id] ) }}"
                                  style="display:inline-block">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $item->id }}">
                                <input type="hidden" name="destination" value="{{ \App\Models\MenuItem::HEADER_MENU }}">
                                <button class="btn btn-info action-btn" type="submit" title="Create submenu">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </form>

                            <form method="post"
                                  action="{{ route('admin.menu_items.destroy', ['menuSlug'=> $menuSlug, 'id' => $item->id]) }}"
                                  style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="slug" value="{{ $menuSlug }}">
                                <button class="btn btn-danger action-btn" type="submit" title="Delete post"
                                        onclick="return confirm('Are you sure want to delete?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
