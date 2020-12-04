@extends('layouts.admin')

@section('content')

<div id="admin_content" class="bg-gray-100 flex-auto h-screen">
    <div class="p-5 pb-8">
        <h1>Campaigns:</h1>

        <a href="{{ route('admin.campaigns.create') }}">
          <button class="btn btn-success mt-3 mb-3" type="button" title="Create campaign">
            <i class="far fa-plus-square mr-2"></i>Create
          </button>
        </a>

        <table class="table-auto mb-3">
            <thead>
              <tr>
                <th class="px-4 py-2">Id</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Country</th>
                <th class="px-4 py-2">Created at</th>
                <th class="px-4 py-2">Action</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($campaigns as $campaign)
                    <tr>
                        <td class="border px-4 py-2">{{ $campaign->id }}</td>
                        <td class="border px-4 py-2">{{ $campaign->name }}</td>
                        <td class="border px-4 py-2">{{ $campaign->description }}</td>
                        <td class="border px-4 py-2">{{ $campaign->status }}</td>
                        <td class="border px-4 py-2">{{ $campaign->country_name }}</td>
                        <td class="border px-4 py-2">{{ $campaign->created_at->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2 action_td">
                          <a href="{{ route('admin.campaigns.edit', ['campaign' => $campaign->id]) }}">
                            <button class="btn btn-info action-btn" type="submit" title="Edit campaign">
                              <i class="fas fa-edit"></i>
                            </button>
                          </a>
                          <form method="post" action="{{ route('admin.campaigns.destroy', ['campaign' => $campaign->id]) }}" style="display:inline-block">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger action-btn" type="submit" title="Delete campaign" onclick="return confirm('Are you sure want to delete?')">
                              <i class="fas fa-trash-alt"></i>
                            </button>

                        </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
          </table>
          {{ $campaigns->links() }}
    </div>
</div>

@endsection
