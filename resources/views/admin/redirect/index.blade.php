@extends('layouts.admin')

@section('content')

    <div id="admin_content" class="flex-auto">
        <div class="p-5 pb-8">
            <h1>Redirects:</h1>

            <a href="{{ route('admin.redirects.create') }}">
                <button class="btn btn-success mt-3 mb-3" type="button" title="Create redirect">
                    <i class="far fa-plus-square mr-2"></i>Create
                </button>
            </a>

            <div class="table-card">
                <div class="table-wrapper">
                    <table class="table-auto mb-3">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Id</th>
                                <th class="px-4 py-2">Url from</th>
                                <th class="px-4 py-2">Url to</th>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Created at</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($redirects as $redirect)
                                <tr>
                                    <td class="px-4">{{ $redirect->id }}</td>
                                    <td class="px-4">{{ $redirect->url_from }}</td>
                                    <td class="px-4"><a href="{{ url($redirect->url_to) }}"
                                            target="_blank">{{ $redirect->url_to }}</a></td>
                                    <td class="px-4">{{ $redirect->type }}</td>
                                    <td class="px-4">{{ $redirect->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 action_td">
                                        <a href="{{ route('admin.redirects.edit', ['redirect' => $redirect->id]) }}">
                                            <button class="btn btn-info action-btn" type="submit" title="Edit redirect">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </a>
                                        <form method="post"
                                            action="{{ route('admin.redirects.destroy', ['redirect' => $redirect->id]) }}"
                                            style="display:inline-block">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger action-btn" type="submit" title="Delete redirect"
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
                {{ $redirects->links() }}
            </div>
        </div>
    </div>

@endsection
