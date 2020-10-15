@extends('layouts.admin')

@section('content')

<div id="admin_content" class="bg-gray-100 flex-auto h-screen">
    <div class="p-5 pb-8 md:w-1/3">
        <h1>Edit user id: {{ $user->id }} page</h1>

        <form action="{{ route('admin.user.update', ['id' => $user->id]) }}" method="post">
            @csrf
            <input name="name" class="shadow appearance-none border rounded w-full  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $user->name }}" /><br>
            <input name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $user->email }}" /><br>

            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Submit
            </button>

        </form>

    </div>
</div>

@endsection