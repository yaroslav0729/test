@extends('layouts.admin')

@section('content')

    <div id="admin_content" class="flex-auto">
        <div class="p-5 pb-8">
            <h1>Food Pack Qurbani Price Create</h1>

            <a href="{{ route('admin.foodpack-qurbanies.index') }}">
                <button class="btn btn-info mt-3 mb-3" type="button" title="Back">
                    <i class="fas fa-reply mr-2"></i>Back
                </button>
            </a>

            <form action="{{ route('admin.foodpack-qurbanies.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <label for="country_id">Country</label><br>
                <select name="country_id" class="form-control mb-3">
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>

                @foreach($types as $type)
                    <label for="name">Price Of {{ $type->name }}</label><br>
                    <input type="hidden" name="types[]" value="{{ $type->id }}">
                    <input id="price" name="prices[]" required class="form-control" type="text" /><br>
                @endforeach

                <button class="btn btn-info" type="submit">
                    Submit
                </button>
            </form>

        </div>
    </div>

@endsection
