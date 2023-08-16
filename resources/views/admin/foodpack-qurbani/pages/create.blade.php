@extends('layouts.admin')

@section('content')

    <div id="admin_content" class="flex-auto">
        <div class="p-5 pb-8">
            <h1>Food Pack Qurbani Pages Create</h1>

            <a href="{{ route('admin.foodpack-qurbanies-pages.index') }}">
                <button class="btn btn-info mt-3 mb-3" type="button" title="Back">
                    <i class="fas fa-reply mr-2"></i>Back
                </button>
            </a>

            <form action="{{ route('admin.foodpack-qurbanies-pages.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <label for="name">Page Uri</label><br>
                <input id="price" name="page_url" class="form-control" placeholder="/example/url" type="text" value="{{ old('page_url') }}" /><br>

                <button class="btn btn-info" type="submit">
                    Submit
                </button>
            </form>

        </div>
    </div>

@endsection
