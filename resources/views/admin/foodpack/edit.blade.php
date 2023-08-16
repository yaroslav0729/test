@extends('layouts.admin')

@section('content')

    <div id="admin_content" class="flex-auto">
        <div class="p-5 pb-8">
            <h1>Food Pack Price Edit #{{ $foodpack->id }}</h1>

            <a href="{{ route('admin.foodpack.index') }}">
                <button class="btn btn-info mt-3 mb-3" type="button" title="Back">
                    <i class="fas fa-reply mr-2"></i>Back
                </button>
            </a>

            <form action="{{ route('admin.foodpack.update', $foodpack->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <label for="name">Price</label><br>
                <input id="price" name="price" class="form-control" type="text" value="{{ $foodpack->price }}" /><br>

                <label for="country_id">Country</label><br>
                <select name="country_id" class="form-control mb-3">
                    @foreach($countries as $country)
                        <option @if($foodpack->country_id == $country->id) selected @endif value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>

                <button class="btn btn-info" type="submit">
                    Submit
                </button>
            </form>

        </div>
    </div>

@endsection
