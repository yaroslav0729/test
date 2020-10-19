@extends('layouts.admin')

@section('content')
    
<div id="admin_content" class="bg-gray-100 flex-auto h-screen">
    <div class="p-5 pb-8">
        <h1>Post groups index page</h1>

        @if (session('status'))
            <div class="mb-3 bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
              <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                  <p class="font-bold">Success</p>
                  <p class="text-sm">{{ session('status') }}</p>
                </div>
              </div>
            </div>
        @endif

        <a href="{{ route('admin.post_group.create') }}">
          <button class="bg-green-500 mb-3 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" type="button" title="Create post">
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
                        <td class="border px-4 py-2">
                          <a href="{{ route('admin.post_group.edit', ['post_group' => $group->id]) }}">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded" type="submit" title="Edit post">
                              <i class="fas fa-edit"></i>
                            </button>
                          </a>
                          <form method="post" action="{{ route('admin.post_group.destroy', ['post_group' => $group->id]) }}" style="display:inline-block">

                            @csrf
                            @method('DELETE')
    
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded" type="submit" title="Delete post" onclick="return confirm('Are you sure want to delete?')">
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
