@extends('layouts.admin')

@section('content')
    
<div id="admin_content" class="bg-gray-100 flex-auto h-screen">
    <div class="p-5 pb-8">
        <h1>Subscription:</h1>

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
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Created at</th>
                <th class="px-4 py-2">Action</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($subscriptions as $subscription)
                    <tr>
                        <td class="border px-4 py-2">{{ $subscription->id }}</td>
                        <td class="border px-4 py-2">{{ $subscription->email }}</td>
                        <td class="border px-4 py-2">{{ $subscription->created_at->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2">
                          <form method="post" action="{{ route('admin.subscription.destroy', ['subscription' => $subscription->id]) }}" style="display:inline-block">

                            @csrf
                            @method('DELETE')
    
                            <button class="btn btn-danger action-btn" type="submit" title="Delete subscription" onclick="return confirm('Are you sure want to delete?')">
                              <i class="fas fa-trash-alt"></i>
                            </button>
    
                        </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
          </table>
          {{ $subscriptions->links() }}
    </div>
</div>

@endsection
