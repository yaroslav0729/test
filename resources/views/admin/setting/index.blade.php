@extends('layouts.admin')

@section('content')

    <div class="mb-4">
        @include('templates.presentation.parts.back_btn')
    </div>

    <div id="admin_content" class="flex-auto h-screen">
        <div class="p-5 pb-8">

            <h1>Global Settings:</h1>
            <div class="col-12 col-lg-6 mt-lg-4">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-12 col-lg-6">
                            <label>{{ Setting::name(Setting::VIDEO_LINK_ON_MAIN_MENU) }}:</label>
                            <div class="input-group">
                                <input type="text" name="{{ Setting::nameShort(Setting::VIDEO_LINK_ON_MAIN_MENU) }}"
                                       class="form-control" placeholder="" value="{{ old(Setting::nameShort(Setting::VIDEO_LINK_ON_MAIN_MENU),
                            Setting::get(Setting::VIDEO_LINK_ON_MAIN_MENU)) }}">
                            </div>
                        </div>

                        <div class="form-group col-12 col-lg-6">
                            <label>{{ Setting::name(Setting::WRAPPER_FOR_VIDEO_ON_MAIN_MENU) }}:</label>
                            <div class="input-group">
                                <input type="text" name="{{ Setting::nameShort(Setting::WRAPPER_FOR_VIDEO_ON_MAIN_MENU) }}"
                                       class="form-control" placeholder="" value="{{ old(Setting::nameShort(Setting::WRAPPER_FOR_VIDEO_ON_MAIN_MENU),
                            Setting::get(Setting::WRAPPER_FOR_VIDEO_ON_MAIN_MENU)) }}">
                            </div>
                        </div>

                        <div class="form-group col-12">
                            <label>{{ Setting::name(Setting::VIDEO_ON_MAIN_MENU_TEXT) }}:</label>
                            <div class="input-group">
                                <input type="text" name="{{ Setting::nameShort(Setting::VIDEO_ON_MAIN_MENU_TEXT) }}"
                                       class="form-control" placeholder="" value="{{ old(Setting::nameShort(Setting::VIDEO_ON_MAIN_MENU_TEXT),
                            Setting::get(Setting::VIDEO_ON_MAIN_MENU_TEXT)) }}">
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label>{{ Setting::name(Setting::ZAKAT_FIT_CAMPAIGN_CATEGORY) }}:</label>
                        <select name="{{ Setting::nameShort(Setting::ZAKAT_FIT_CAMPAIGN_CATEGORY) }}"
                                class="form-control">
                            @foreach ($campaignCategories as $category)
                                <option value="{{ $category->id }}"
                                        @if((int)$zakat === $category->id) selected @endif > {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>{{ Setting::name(Setting::REGISTERED_CHARITY_NUMBER) }}:</label>
                        <div class="input-group">
                            <input type="text" name="{{ Setting::nameShort(Setting::REGISTERED_CHARITY_NUMBER) }}"
                                   class="form-control" placeholder="" value="{{ old(Setting::nameShort(Setting::REGISTERED_CHARITY_NUMBER),
                            Setting::get(Setting::REGISTERED_CHARITY_NUMBER)) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{ Setting::name(Setting::COMPANY_NUMBER) }}:</label>
                        <div class="input-group">
                            <input type="text" name="{{ Setting::nameShort(Setting::COMPANY_NUMBER) }}"
                                   class="form-control" placeholder="" value="{{ old(Setting::nameShort(Setting::COMPANY_NUMBER),
                            Setting::get(Setting::COMPANY_NUMBER)) }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-info">Submit</button>
                </form>
            </div>
        </div>
    </div>

@endsection
