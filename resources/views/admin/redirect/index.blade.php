@extends('layouts.admin')

@section('content')

<div id="admin_content" class="bg-gray-100 flex-auto">
    <div class="p-5 pb-8">
        <h1>Redirects:</h1>

        <a href="{{ route('admin.redirects.create') }}">
          <button class="btn btn-success mt-3 mb-3" type="button" title="Create redirect">
            <i class="far fa-plus-square mr-2"></i>Create
          </button>
        </a>

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
                        <td class="border px-4 py-2">{{ $redirect->id }}</td>
                        <td class="border px-4 py-2">{{ $redirect->url_from }}</td>
                        <td class="border px-4 py-2">{{ $redirect->url_to }}</td>
                        <td class="border px-4 py-2">{{ $redirect->type }}</td>
                        <td class="border px-4 py-2">{{ $redirect->created_at->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2 action_td">
                          <a href="{{ route('admin.redirects.edit', ['redirect' => $redirect->id]) }}">
                            <button class="btn btn-info action-btn" type="submit" title="Edit redirect">
                              <i class="fas fa-edit"></i>
                            </button>
                          </a>
                          <form method="post" action="{{ route('admin.redirects.destroy', ['redirect' => $redirect->id]) }}" style="display:inline-block">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger action-btn" type="submit" title="Delete redirect" onclick="return confirm('Are you sure want to delete?')">
                              <i class="fas fa-trash-alt"></i>
                            </button>

                        </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
          </table>
          {{ $redirects->links() }}
    </div>
</div>

@endsection
