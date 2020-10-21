@extends('layouts.admin')

@section('content')

<div id="admin_content" class="bg-gray-100 flex-auto h-screen">
    <div class="p-5 pb-8 lg:w-1/2">
        <h1>Edit user id: {{ $user->id }} page</h1>

        <form action="{{ route('admin.user.update', ['id' => $user->id]) }}" method="post">
            @csrf
            <input name="name" class="shadow appearance-none border rounded w-full  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $user->name }}" readonly /><br>
            <input name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $user->email }}" readonly /><br>

            @php
                $noChecked = true;
            @endphp

            @foreach ($roles as $keyRole => $role)

            @php

                if ($user->role_name === $role) {
                    $checked = true;
                    $noChecked = false;
                } else {
                    $checked = false; 
                }    

            @endphp
                <input name="role" id="role_{{ $keyRole }}" type="radio" value="{{ $keyRole }}"  @if($checked) checked='checked' @endif />
                <label for="role_{{ $keyRole }}">{{ $role }}</label><br>
            @endforeach

            <input name="role" id="role_user" type="radio" value="user"  @if($noChecked) checked='checked' @endif />
            <label for="role_user">User</label><br>

            <button class="btn btn-info" type="submit">
                Submit
            </button>

        </form>

    </div>
</div>

@endsection