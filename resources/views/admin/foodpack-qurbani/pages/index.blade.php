@extends('layouts.admin')

@section('content')
    <div id="admin_content" class="flex-auto px-0">
        <div class="p-5 pb-8">
            <h1 class="admin-page__title">Food Pack Qurbani Included Pages</h1>

            <a href="{{ route('admin.foodpack-qurbanies-pages.create') }}">
                <button class="btn btn-success mt-3 mb-3" type="button" title="Create foodpack">
                    <i class="far fa-plus-square mr-2"></i>Create
                </button>
            </a>

            <a href="{{ route('admin.foodpack-qurbanies.index') }}">
                <button class="btn btn-info mt-3 mb-3" type="button" title="Back">
                    <i class="fas fa-reply mr-2"></i>Back
                </button>
            </a>

            <div class="table-card">
                <div class="table-wrapper">
                    <table class="table-auto mb-3">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Id</th>
                            <th class="px-4 py-2">Page Url</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($foodPacksPages as $foodPacksPage)
                            <tr>
                                <td class="px-4">{{ $foodPacksPage->id }}</td>
                                <td class="px-4">{{ $foodPacksPage->page_url }}</td>
                                <td class="px-4">
                                    <form method="post"
                                          action="{{ route('admin.foodpack-qurbanies-pages.destroy', $foodPacksPage->id) }}"
                                          style="display:inline-block">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger action-btn" type="submit" title="Delete foodpack"
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
                {{ $foodPacksPages->links() }}
            </div>
        </div>
    </div>

@endsection
