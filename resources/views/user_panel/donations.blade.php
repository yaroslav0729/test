@extends('layouts.user')

@section('content')

<div id="admin_content" class="flex-auto h-screen">
    <div class="p-5 pb-8">
        <p><b>Name:</b> {{ $user->name }}</p>
        <p><b>Last name:</b> {{ $user->last_name }}</p>
        <p><b>Email:</b> {{ $user->email }}</p>

        <h3 class="pt-3 pb-2">My donations:</h3>

        <table class="table-auto mb-3">
            <thead>
              <tr>
                <th class="px-4 py-2">Id</th>
                <th class="px-4 py-2">Amount</th>
                <th class="px-4 py-2">Period</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Date</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($user->donations as $donation)
                    <tr>
                        <td class="border px-4 py-2">{{ $donation->id }}</td>
                        <td class="border px-4 py-2">£ {{ $donation->value }}</td>
                        <td class="border px-4 py-2">{{ $donation->type_name }}</td>
                        <td class="border px-4 py-2">{{ $donation->status_name }}</td>
                        <td class="border px-4 py-2">{{ $donation->email }}</td>
                        <td class="border px-4 py-2">{{ $user->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach

            </tbody>
          </table>

    </div>
</div>

@endsection
