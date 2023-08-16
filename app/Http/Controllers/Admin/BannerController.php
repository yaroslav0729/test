<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerCreateEditRequest;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function createOrEdit()
    {
        $banner = Banner::find(["id" => 1])->first();

        return view('admin.banner.create_edit', compact('banner'));
    }

    public function store(BannerCreateEditRequest $request)
    {
        $banner = Banner::create($request->all());

        return redirect()->route('admin.banner.create_or_edit')->with('status', 'Banner created successfully');
    }

    public function update(BannerCreateEditRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $data = $request->all();
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        $banner->update($data);

        return redirect()->route('admin.banner.create_or_edit')->with('status', 'Banner updated!');
    }
}
