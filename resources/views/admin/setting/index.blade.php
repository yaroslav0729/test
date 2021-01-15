@extends('layouts.admin')

@section('content')

    <div class="mb-4">
        @include('templates.presentation.parts.back_btn')
    </div>

    <div id="admin_content" class="flex-auto h-screen">
        <div class="p-5 pb-8">

            <h1>Global Settings:</h1>
            <div class="col-12 col-lg-6">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>{{ Setting::name(Setting::VIDEO_LINK_ON_MAIN_MENU) }}:</label>
                        <div class="input-group">
                            <input type="text" name="{{ Setting::nameShort(Setting::VIDEO_LINK_ON_MAIN_MENU) }}" class="form-control" placeholder="" value="{{ old(Setting::nameShort(Setting::VIDEO_LINK_ON_MAIN_MENU),
                            Setting::get(Setting::VIDEO_LINK_ON_MAIN_MENU)) }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info">Submit</button>
                </form>
            </div>
        </div>
    </div>

@endsection
