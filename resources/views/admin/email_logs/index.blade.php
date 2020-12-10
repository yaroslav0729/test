@extends('layouts.admin')

@section('content')

<div id="admin_content" class="bg-gray-100 flex-auto h-screen">
    <div class="p-5 pb-8">
        <h1>Email logs:</h1>

        <table class="table-auto mb-3">
            <thead>
              <tr>
                <th class="px-4 py-2">Id</th>
                <th class="px-4 py-2">Email to</th>
                <th class="px-4 py-2">Subject</th>
                <th class="px-4 py-2">Created at</th>
                <th class="px-4 py-2">Action</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($emailLogs as $log)
                    <tr>
                        <td class="border px-4 py-2">{{ $log->id }}</td>
                        <td class="border px-4 py-2">{{ $log->email_to }}</td>
                        <td class="border px-4 py-2">{{ $log->subject }}</td>
                        <td class="border px-4 py-2">{{ $log->created_at->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2">
                          <a href="{{ route('admin.email_logs.show', ['email_log' => $log->id]) }}">
                            <button class="btn btn-info action-btn" type="submit" title="Show email log">
                              <i class="fas fa-eye"></i>
                            </button>
                          </a>
                          <form method="post" action="{{ route('admin.email_logs.destroy', ['email_log' => $log->id]) }}" style="display:inline-block">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger action-btn" type="submit" title="Delete email log" onclick="return confirm('Are you sure want to delete?')">
                              <i class="fas fa-trash-alt"></i>
                            </button>

                        </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
          </table>
          {{ $emailLogs->links() }}
    </div>
</div>

@endsection
