@extends('layouts.admin')

@section('content')

    <div id="admin_content" class="flex-auto">
        <div class="p-5 pb-8">
            <h1>Black List Create</h1>

            <a href="{{ route('admin.black-list.index') }}">
                <button class="btn btn-info mt-3 mb-3" type="button" title="Back">
                    <i class="fas fa-reply mr-2"></i>Back
                </button>
            </a>

            <form action="{{ route('admin.black-list.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <label for="name">Ip</label><br>
                <input id="price" name="ip" class="form-control" placeholder="127.0.0.1" type="text" value="{{ old('ip') }}" /><br>

                <button class="btn btn-info" type="submit">
                    Submit
                </button>
            </form>

        </div>
    </div>

@endsection
