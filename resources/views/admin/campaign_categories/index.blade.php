@extends('layouts.admin')

@section('content')

    <div id="admin_content" class="flex-auto">
        <div class="p-5 pb-8">
            <h1 class="admin-page__title">Campaign categories:</h1>

            <a href="{{ route('admin.campaign_categories.create') }}">
                <button class="btn btn-success mt-3 mb-3" type="button" title="Create campaign">
                    <i class="far fa-plus-square mr-2"></i>Create
                </button>
            </a>

            <div class="table-card">
                <div class="table-wrapper">
                    <table class="table-auto mb-3">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Id</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($campaignCategories as $campaignCategory)
                                <tr>
                                    <td class="px-4">{{ $campaignCategory->id }}</td>
                                    <td class="px-4">{{ $campaignCategory->name }}</td>
                                    <td class="px-4 action_td">
                                        <a
                                            href="{{ route('admin.campaign_categories.edit', ['campaign_category' => $campaignCategory->id]) }}">
                                            <button class="btn btn-info action-btn" type="submit"
                                                title="Edit campaign category">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </a>
                                        <form method="post"
                                            action="{{ route('admin.campaign_categories.destroy', ['campaign_category' => $campaignCategory->id]) }}"
                                            style="display:inline-block">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger action-btn" type="submit"
                                                title="Delete campaign category"
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
                {{ $campaignCategories->links() }}
            </div>
        </div>
    </div>

@endsection
