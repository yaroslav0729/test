<?php


namespace App\Http\Controllers\Admin;

use App\Helpers\SettingHelper;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\CampaignCategory;
use Deployer\Collection\Collection;


class SettingController extends Collection
{
    public function index()
    {
        $campaignCategories = CampaignCategory::all();
        $zakat = SettingHelper::get(SettingHelper::ZAKAT_FIT_CAMPAIGN_CATEGORY);

        return view('admin.setting.index', compact('campaignCategories', 'zakat'));
    }


    public function update(SettingRequest $request)
    {
        $data = $request->except('_token');
        SettingHelper::saveSetting($data);

        return redirect()->route('admin.settings.index')->with('status', 'Setting updated!');
    }
}
