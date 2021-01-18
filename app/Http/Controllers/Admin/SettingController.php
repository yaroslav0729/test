<?php


namespace App\Http\Controllers\Admin;

use App\Helpers\SettingHelper;
use App\Http\Requests\Admin\SettingRequest;


class SettingController
{
    public function index()
    {
        return view('admin.setting.index');
    }


    public function update(SettingRequest $request)
    {
        $data = $request->except('_token');
        SettingHelper::saveSetting($data);

        return redirect()->route('admin.settings.index')->with('status', 'Setting updated!');
    }
}
