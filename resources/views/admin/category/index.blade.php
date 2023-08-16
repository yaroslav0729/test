@extends('layouts.admin')

@section('content')

    <div id="admin_content" class="flex-auto px-0">
        <div class="p-5 pb-8">
            <h1 class="admin-page__title">Categories:</h1>

            <a href="{{ route('admin.category.create') }}">
                <button class="btn btn-success mt-3 mb-3" type="button" title="Create category">
                    <i class="far fa-plus-square mr-2"></i>Create
                </button>
            </a>

            <div class="table-card">
                <div class="table-wrapper">
                    <table class="table-auto mb-3">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Id</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Slug</th>
                                <th class="px-4 py-2">Created at</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($pGroups as $group)
                                <tr>
                                    <td class="px-4">{{ $group->id }}</td>
                                    <td class="px-4">{{ $group->name }}</td>
                                    <td class="px-4">{{ $group->slug }}</td>
                                    <td class="px-4">{{ $group->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 action_td">
                                        <a href="{{ route('admin.category.edit', ['category' => $group->id]) }}">
                                            <button class="btn btn-info action-btn" type="submit" title="Edit post">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </a>
                                        <form method="post"
                                            action="{{ route('admin.category.destroy', ['category' => $group->id]) }}"
                                            style="display:inline-block">

                                            @csrf
                                            @method('DELETE')

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
                {{ $pGroups->links() }}
            </div>
        </div>
    </div>

@endsection
