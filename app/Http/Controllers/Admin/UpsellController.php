<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpsellCreateEditRequest;
use App\Models\Upsell;
use App\Models\CampaignCategory;
use Illuminate\Http\Request;

class UpsellController extends Controller
{
    public function createOrEdit()
    {
        $upsell = Upsell::find(["id" => 1])->first();
        $categories = CampaignCategory::all();

        return view('admin.upsell.create_edit', compact('upsell', 'categories'));
    }

    public function store(UpsellCreateEditRequest $request)
    {
        $upsell = Upsell::create($request->all());

        return redirect()->route('admin.upsells.create_or_edit')->with('status', 'Upsell item created successfully');
    }

    public function update(UpsellCreateEditRequest $request, $id)
    {
        $upsell = Upsell::findOrFail($id);
        $data = $request->all();
        if (!isset($data['active'])) {
            $data['active'] = false;
        }
        $upsell->update($data);

        return redirect()->route('admin.upsells.create_or_edit')->with('status', 'Upsell item updated!');
    }
}
