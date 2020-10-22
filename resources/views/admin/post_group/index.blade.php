@extends('layouts.admin')

@section('content')
    
<div id="admin_content" class="bg-gray-100 flex-auto h-screen">
    <div class="p-5 pb-8">
        <h1>Post groups:</h1>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
              <div class="flex">
                <div>
                  <p class="font-weight-bold">Success</p>
                  <p class="text-sm">{{ session('status') }}</p>
                </div>
              </div>
            </div>
        @endif

        <a href="{{ route('admin.post_group.create') }}">
          <button class="btn btn-success mt-3 mb-3" type="button" title="Create post">
            <i class="far fa-plus-square mr-2"></i>Create
          </button>
        </a>

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
                        <td class="border px-4 py-2">{{ $group->id }}</td>
                        <td class="border px-4 py-2">{{ $group->name }}</td>
                        <td class="border px-4 py-2">{{ $group->slug }}</td>
                        <td class="border px-4 py-2">{{ $group->created_at->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2 action_td">
                          <a href="{{ route('admin.post_group.edit', ['post_group' => $group->id]) }}">
                            <button class="btn btn-info action-btn" type="submit" title="Edit post">
                              <i class="fas fa-edit"></i>
                            </button>
                          </a>
                          <form method="post" action="{{ route('admin.post_group.destroy', ['post_group' => $group->id]) }}" style="display:inline-block">

                            @csrf
                            @method('DELETE')
    
                            <button class="btn btn-danger action-btn" type="submit" title="Delete post" onclick="return confirm('Are you sure want to delete?')">
                              <i class="fas fa-trash-alt"></i>
                            </button>
    
                        </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
          </table>
          {{ $pGroups->links() }}
    </div>
</div>

@endsection
