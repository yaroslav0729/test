@extends('layouts.admin')

@section('content')
    <div id="admin_content" class="flex-auto px-0">
        <div class="p-5 pb-8">
            <h1 class="admin-page__title">Black List</h1>

            <a href="{{ route('admin.black-list.create') }}">
                <button class="btn btn-success mt-3 mb-3" type="button" title="Create foodpack">
                    <i class="far fa-plus-square mr-2"></i>Create
                </button>
            </a>

            <div class="table-card">
                <div class="table-wrapper">
                    <table class="table-auto mb-3">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Id</th>
                            <th class="px-4 py-2">Ip</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($blackLists as $blackList)
                            <tr>
                                <td class="px-4">{{ $blackList->id }}</td>
                                <td class="px-4">{{ $blackList->ip }}</td>
                                <td class="px-4">
                                    <form method="post"
                                          action="{{ route('admin.black-list.destroy', $blackList->id) }}"
                                          style="display:inline-block">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger action-btn" type="submit" title="Delete ip from black list"
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
                {{ $blackLists->links() }}
            </div>
        </div>
    </div>

@endsection
