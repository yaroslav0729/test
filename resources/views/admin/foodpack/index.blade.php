@extends('layouts.admin')

@section('content')
    <div id="admin_content" class="flex-auto px-0">
        <div class="p-5 pb-8">
            <h1 class="admin-page__title">Food Pack Price</h1>

            <a href="{{ route('admin.foodpack.create') }}">
                <button class="btn btn-success mt-3 mb-3" type="button" title="Create foodpack">
                    <i class="far fa-plus-square mr-2"></i>Create
                </button>
            </a>

            <a href="{{ route('admin.foodpack-pages.index') }}">
                <button class="btn btn-info mt-3 mb-3" type="button" title="Create foodpack">
                    <i class="fas fa-file-alt mr-2"></i>Pages
                </button>
            </a>

            <div class="row">
                <div class="form-group col-md-4 col-12">
                    <label>Widget status:</label>
                    <form method="post"
                          action="{{ route('admin.foodpack.settings') }}">
                        @csrf
                        <div class="input-group">
                            <select class="custom-select" name="status" id="inputGroupSelect04">
                                <option value="1" @if ($settings->status == 1) selected @endif>On</option>
                                <option value="0" @if ($settings->status == 0) selected @endif>Off</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-inline btn-outline-primary" type="submit"><i
                                        class="far fa-save"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-card">
                <div class="table-wrapper">
                    <table class="table-auto mb-3">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Id</th>
                            <th class="px-4 py-2">Country</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($foodpacks as $foodpack)
                            <tr>
                                <td class="px-4">{{ $foodpack->id }}</td>
                                <td class="px-4">{{ $foodpack->country->name }}</td>
                                <td class="px-4">{{ $foodpack->price }}</td>
                                <td class="px-4">
                                    <a href="{{ route('admin.foodpack.edit', $foodpack->id) }}">
                                        <button class="btn btn-info action-btn" type="submit" title="Edit foodpack">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </a>
                                    <form method="post"
                                          action="{{ route('admin.foodpack.destroy', $foodpack->id) }}"
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
