@extends('layouts.admin')

@section('content')
    
<div id="admin_content" class="flex-auto h-screen">
    <div class="p-5 pb-8">
        <h1>Users:</h1>

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
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Role</th>
                <th class="px-4 py-2">Registration date</th>
                <th class="px-4 py-2">Action</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($users as $user)
                    <tr>
                        <td class="border px-4 py-2">{{ $user->id }}</td>
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                        <td class="border px-4 py-2">{{ $user->role_name }}</td>
                        <td class="border px-4 py-2">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2 action_td">
                          <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}">
                            <button class="btn btn-info action-btn" type="submit" title="Edit user">
                              <i class="fas fa-edit"></i>
                            </button>
                          </a>
                          <form method="post" action="{{ route('admin.user.delete', ['id' => $user->id]) }}" style="display:inline-block">

                            @csrf
                            @method('DELETE')
    
                            <button class="btn btn-danger action-btn" type="submit" title="Delete user" onclick="return confirm('Are you sure want to delete?')">
                              <i class="fas fa-trash-alt"></i>
                            </button>
    
                        </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
          </table>
          {{ $users->links() }}
    </div>
</div>

@endsection
