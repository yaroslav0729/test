@extends('layouts.admin')

@section('content')
    
<div id="admin_content" class="bg-gray-100 flex-auto h-screen">
    <div class="p-5 pb-8">
        <h1>Posts index page</h1>

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

        <a href="{{ route('admin.post.create') }}">
          <button class="btn btn-success" type="button" title="Create post">
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

                @foreach ($posts as $post)
                    <tr>
                        <td class="border px-4 py-2">{{ $post->id }}</td>
                        <td class="border px-4 py-2">{{ $post->name }}</td>
                        <td class="border px-4 py-2"><a href="{{ url($post->slug) }}" target="_blank">{{ $post->slug }}</a></td>
                        <td class="border px-4 py-2">{{ $post->created_at->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2 action_td">
                          <a href="{{ route('admin.post.edit', ['post' => $post->id]) }}">
                            <button class="btn btn-info action-btn" type="submit" title="Edit post">
                              <i class="fas fa-edit"></i>
                            </button>
                          </a>
                          <form method="post" action="{{ route('admin.post.destroy', ['post' => $post->id]) }}" style="display:inline-block">

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
          {{ $posts->links() }}
    </div>
</div>

@endsection
