@extends('layouts.admin')

@section('content')
    
<div id="admin_content" class="bg-gray-100 flex-auto h-screen">
    <div class="p-5 pb-8">
        <h1>Donations:</h1>

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
                <th class="px-4 py-2">Value</th>
                <th class="px-4 py-2">Type</th>
                <th class="px-4 py-2">Campaign</th>
                <th class="px-4 py-2">User / Email</th>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Action</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($donations as $donation)
                    <tr>
                        <td class="border px-4 py-2">{{ $donation->id }}</td>
                        <td class="border px-4 py-2">{{ $donation->currrency_sign }}{{ $donation->value }}</td>
                        <td class="border px-4 py-2">{{ $donation->type_name }}</td>
                        <td class="border px-4 py-2">{{ $donation->campaign ? $donation->campaign->name : 'no campaign' }}</td>
                        <td class="border px-4 py-2">
                          @if (isset($donation->user))
                            {{ $donation->user->name }}
                          @elseif (isset($donation->email))
                            {{ $donation->email }}
                          @else
                            no user
                          @endif
                        </td>
                        <td class="border px-4 py-2">{{ $donation->created_at->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2">
                          <a href="{{ route('admin.donations.show', ['donation' => $donation->id]) }}">
                            <button class="btn btn-info action-btn" type="submit" title="Show donation">
                              <i class="fas fa-eye"></i>
                            </button>
                          </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
          </table>
          {{ $donations->links() }}
    </div>
</div>

@endsection
