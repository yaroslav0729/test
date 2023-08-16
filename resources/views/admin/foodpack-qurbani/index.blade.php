@extends('layouts.admin')

@section('content')
    <div id="admin_content" class="flex-auto px-0">
        <div class="p-5 pb-8">
            <h1 class="admin-page__title">Food Pack Qurbani Price</h1>

            <a href="{{ route('admin.foodpack-qurbanies.create') }}">
                <button class="btn btn-success mt-3 mb-3" type="button" title="Create foodpack">
                    <i class="far fa-plus-square mr-2"></i>Create
                </button>
            </a>

            <a href="{{ route('admin.foodpack-qurbanies-pages.index') }}">
                <button class="btn btn-info mt-3 mb-3" type="button" title="Create foodpack">
                    <i class="fas fa-file-alt mr-2"></i>Pages
                </button>
            </a>

            <div class="table-card">
                <div class="table-wrapper">
                    <table class="table-auto mb-3">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Id</th>
                            <th class="px-4 py-2">Country</th>
                            @foreach($types as $type)
                                <th class="px-4 py-2">{{ $type->name }} Price</th>
                            @endforeach
                            <th class="px-4 py-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($foodpacks as $foodpack)
                            <tr>
                                <td class="px-4">{{ $foodpack->id }}</td>
                                <td class="px-4">{{ $foodpack->country->name }}</td>
                                @foreach($foodpack->types as $type)
                                    <td class="px-4">{{ $type->pivot->price }}</td>
                                @endforeach
                                <td class="px-4">
                                    <a href="{{ route('admin.foodpack-qurbanies.edit', $foodpack->id) }}">
                                        <button class="btn btn-info action-btn" type="submit" title="Edit foodpack">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </a>
                                    <form method="post"
                                          action="{{ route('admin.foodpack-qurbanies.destroy', $foodpack->id) }}"
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
                {{ $foodpacks->links() }}
            </div>
        </div>
    </div>

@endsection
