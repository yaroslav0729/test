@extends('layouts.admin')

@section('content')

<div id="admin_content" class="flex-auto h-screen">
    <div class="p-5 pb-8">
        <h1>Page history:</h1>

        <table class="table-auto mb-3">
            <thead>
              <tr>
                <th class="px-4 py-2">Id</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Url name</th>
                <th class="px-4 py-2">Created at</th>
                <th class="px-4 py-2">Action</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($pageInstances as $post)
                    <tr>
                        <td class="border px-4 py-2">{{ $post->id }}@if($post->actual) <span class="text-success"> - current version</span> @endif</td>
                        <td class="border px-4 py-2">{{ $post->name }}</td>
                        <td class="border px-4 py-2">{{ $post->slug }}</td>
                        <td class="border px-4 py-2">{{ $post->created_at->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2 action_td">
                        <a href="{{ route('admin.pages.show', ['page' => $post->id]) }}">
                            <button class="btn btn-outline-info action-btn" title="Version details">
                            <i class="fas fa-info-circle"></i>
                            </button>
                        </a>
                        <a href="{{ route('admin.pages.preview', ['id' => $post->id]) }}" target="_blank">
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
