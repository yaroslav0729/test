@extends('layouts.admin')

@section('content')

    <div id="admin_content" class="flex-auto">
        <div class="p-5 pb-8">
            <h1 class="admin-page__title">Subscription:</h1>

            <div class="table-card">
                <div class="table-wrapper">
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
                                    <td class="px-4">{{ $subscription->id }}</td>
                                    <td class="px-4">{{ $subscription->email }}</td>
                                    <td class="px-4">{{ $subscription->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 action_td">
                                        <form method="post"
                                            action="{{ route('admin.subscription.destroy', ['subscription' => $subscription->id]) }}"
                                            style="display:inline-block">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger action-btn" type="submit"
                                                title="Delete subscription"
                                                onclick="return confirm('Are you sure want to delete?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $subscriptions->links() }}
            </div>
        </div>
    </div>

@endsection
