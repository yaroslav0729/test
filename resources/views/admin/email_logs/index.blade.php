@extends('layouts.admin')

@section('content')

    <div id="admin_content" class="flex-auto">
        <div class="p-5 pb-8">
            <h1 class="admin-page__title">Email logs:</h1>

            <form action="{{ route('admin.email_logs.index') }}" method="get">
                <div class="row">
                    <div class="form-group col-6">
                        <label>Keyword:</label>
                        <input class="form-control" @if (!empty($keyword)) value="{{ $keyword }}" @endif name="keyword"
                            type="text" />
                    </div>
                    <div class="form-group col-6">
                        <label>Date:</label>
                        <input class="form-control" type="text" name="daterange" value="{{ $daterange }}" />
                    </div>
                </div>
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.email_logs.index') }}"><button class="btn btn-info" type="button">Clear all
                        filters</button></a>
            </form>

            <div class="table-card mt-3">
                <div class="table-wrapper">
                    <table class="table-auto mb-3">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Id</th>
                                <th class="px-4 py-2">Email to</th>
                                <th class="px-4 py-2">Subject</th>
                                <th class="px-4 py-2">Email from</th>
                                <th class="px-4 py-2">Created at</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($emailLogs as $log)
                                <tr>
                                    <td class="px-4">{{ $log->id }}</td>
                                    <td class="px-4">{{ $log->email_to }}</td>
                                    <td class="px-4">{{ $log->subject }}</td>
                                    <td class="px-4">{{ $log->email_from }}</td>
                                    <td class="px-4">{{ $log->created_at->format('d/m/Y h:i:s A') }}</td>
                                    <td class="px-4 action_td">
                                        <a href="{{ route('admin.email_logs.show', ['email_log' => $log->id]) }}">
                                            <button class="btn btn-info action-btn" type="submit" title="Show email log">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </a>
                                        <form method="post"
                                            action="{{ route('admin.email_logs.resend', ['email_log' => $log->id]) }}"
                                            style="display:inline-block">
                                            @csrf
                                            <button class="btn btn-success action-btn" type="submit" title="Resend email"
                                                onclick="return confirm('Are you sure want to resend email?')">
                                                <i class="fas fa-share-square"></i>
                                            </button>
                                        </form>
                                        <form method="post"
                                            action="{{ route('admin.email_logs.destroy', ['email_log' => $log->id]) }}"
                                            style="display:inline-block">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger action-btn" type="submit" title="Delete email log"
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
                {{ $emailLogs->links() }}
            </div>
        </div>
    </div>

@endsection
