@extends('layouts.user')

@section('content')

    <div id="admin_content" class="flex-auto h-screen">
        <div class="p-5 pb-8">
            <p><b>Name:</b> {{ $user->name }}</p>
            <p><b>Last name:</b> {{ $user->last_name }}</p>
            <p><b>Email:</b> {{ $user->email }}</p>

            <h3 class="pt-3 pb-2">My donations:</h3>

            <div class="table-card">
                <table class="table-auto mb-3">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Id</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Period</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($user->donations as $donation)
                            <tr>
                                <td class="px-4">{{ $donation->id }}</td>
                                <td class="px-4">£ {{ $donation->value }}</td>
                                <td class="px-4">{{ $donation->type_name }}</td>
                                <td class="px-4">{{ $donation->status_name }}</td>
                                <td class="px-4">{{ $donation->email }}</td>
                                <td class="px-4">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 action_td">
                                    @if(isset($donation->order->subscription_id) && $donation->order->is_subscription_active === true)
                                        <form method="post"
                                              action="{{ route('user.cancel-subscription', ['subscriptionId' => $donation->order->subscription_id]) }}"
                                              style="display:inline-block">
                                            @csrf
                                            <button class="btn btn-danger action-btn" type="submit" title="Cancel subscription"
                                                    onclick="return confirm('Are you sure want to cancel subscription?')">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
