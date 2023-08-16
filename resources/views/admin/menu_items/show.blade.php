@extends('layouts.admin')

@section('content')

    <div class="mb-4">
        @include('templates.presentation.parts.back_btn')
    </div>

    <div class="flex-auto">
        <div class="p-5 pb-8">
            
            <h1>{{ $menuName }}:</h1>

            @isset($parent)
                @if($parent->isHeaderMenu() && $parent->depth > 2)
                    <div class="alert alert-info" role="alert">
                        {{ __('messages.header_menu_nesting_level_warning') }}
                    </div>
                @endif

                @if($parent->isFooterMenu() && $parent->depth > 1)
                    <div class="alert alert-info" role="alert">
                        {{ __('messages.footer_menu_nesting_level_warning') }}
                    </div>
                @endif
            @endisset

            <a class="btn btn-success mt-3 mb-3" title="Create submenu" href="{{ $createLink }}">
                <i class="far fa-plus-square mr-2"></i>Create
            </a>

            <table class="table-auto mb-3">
                <thead>
                <tr>
                    <th class="px-4 py-2">Text</th>
                    <th class="px-4 py-2">Is group</th>
                    <th class="px-4 py-2">Link</th>
                    <th class="px-4 py-2">Ordering</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($menuItems as $item)
                    <tr>
                        <td class="border px-4 py-2">
                            @if($item->subMenus->count())
                                <a href="{{ route('admin.menu_items.show_submenu', ['parent' => $item->id]) }}"> {{ $item->text }}</a>
                            @else
                                {{ $item->text }}
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-success">
                            @if($item->is_group)  <i class="fas fa-check"></i> @endif
                        </td>

                        <td class="border px-4 py-2">{{ $item->link }}</td>
                        <td class="border px-4 py-2 action_td text-right">

                            @if (!$loop->first)
                                <form 
                                    method="get"
                                    action="{{ route('admin.menu_items.move_up', $item) }}"
                                    style="display:inline-block"
                                >
                                    <button class="btn btn-info action-btn" type="submit">
                                        <i class="far fa-arrow-up"></i>
                                    </button>
                                </form>
                            @endif

                            @if (!$loop->last)
                                <form 
                                    method="get"
                                    action="{{ route('admin.menu_items.move_down', $item) }}"
                                    style="display:inline-block"
                                >
                                    <button class="btn btn-info action-btn" type="submit">
                                        <i class="far fa-arrow-down"></i>
                                    </button>
                                </form>
                            @endif
                        </td>

                        <td class="border px-4 py-2 action_td text-right">

                            @if($item->is_group)
                                <form method="get"
                                      action="{{ route('admin.menu_items.create_submenu', ['parent' => $item->id]) }}"
                                      style="display:inline-block">
                                    <button class="btn btn-success action-btn" type="submit" title="Create submenu item">
                                        <i class="far fa-plus-square"></i>
                                    </button>
                                </form>
                            @endif

                            <form method="get"
                                  action="{{ route('admin.menu_items.edit', $item->id) }}"
                                  style="display:inline-block">
                                <button class="btn btn-info action-btn" type="submit" title="Edit menu item">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </form>

                            <form method="post"
                                  action="{{ route('admin.menu_items.destroy', $item->id) }}"
                                  style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger action-btn" type="submit" title="Delete menu item"
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
