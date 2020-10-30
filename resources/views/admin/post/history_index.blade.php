@extends('layouts.admin')

@section('content')
    
<div id="admin_content" class="bg-gray-100 flex-auto h-screen">
    <div class="p-5 pb-8">
        <h1>Post history:</h1>

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
                        <td class="border px-4 py-2">{{ $post->id }}@if($post->actual) <span class="text-success"> - current version</span> @endif</td>
                        <td class="border px-4 py-2">{{ $post->name }}</td>
                        <td class="border px-4 py-2">{{ $post->slug }}</td>
                        <td class="border px-4 py-2">{{ $post->created_at->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2 action_td">
                        <a href="{{ route('admin.post.show', ['post' => $post->id]) }}">
                            <button class="btn btn-outline-success action-btn" title="Watch this version">
                            <i class="far fa-eye"></i>
                            </button>
                        </a>
                        </form>
                        
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

@endsection
