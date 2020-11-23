@extends('layouts.admin')

@section('content')

<h2>Settings:</h2>

<table class="table-auto mb-3">
    <thead>
      <tr>
        <th class="px-2 w-100 py-2">Page name</th>
        <th class="px-2 py-2">Action</th>
      </tr>
    </thead>
    <tbody>
        <tr>
            <td class="border px-2 py-2">Index page</td>
            <td class="border px-2 py-2">
                <a href="{{ route('admin.pages.edit', ['page' => $indexPage->page->id]) }}">
                    <button class="btn btn-info action-btn" type="submit" title="Edit page">
                        <i class="fas fa-edit"></i>
                    </button>
                </a>
            </td>
        </tr>
        <tr>
            <td class="border px-2 py-2">Projects page</td>
            <td class="border px-2 py-2">
                <a href="{{ route('admin.pages.edit', ['page' => $projectsPage->page->id]) }}">
                    <button class="btn btn-info action-btn" type="submit" title="Edit page">
                        <i class="fas fa-edit"></i>
                    </button>
                </a>
            </td>
        </tr>
    </tbody>
</table>

@endsection