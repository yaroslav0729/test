<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Http\Requests\Admin\CampaignCreateEditRequest;
use App\Models\CampaignPrice;
use Carbon\Carbon;

class CampaignsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $emergencyFilter = $request->get('emergency');
        $nameFilter = $request->get('search_name');

        $campaigns = Campaign::where('id', '<>', 0);

        if (isset($emergencyFilter) && ($emergencyFilter !== '0')) {
            $campaigns->where('is_emergency', $emergencyFilter);
        }

        if (!empty($nameFilter)) {
            $campaigns->where('name', 'like',  '%' . $nameFilter . '%');
        }

        $campaigns = $campaigns->paginate(25);

        return view('admin.campaign.index', [
            'campaigns' => $campaigns,
            'emergencyFilter' => $emergencyFilter,
            'nameFilter' => $nameFilter
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('admin.campaign.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(CampaignCreateEditRequest $request)
    {
        $campaign = Campaign::create($request->all());
        $campaign->updatePrices($request);

        $categories = $request->input('categories');
        $campaign->campaign_categories()->attach($categories);
        $campaign->save();

        return redirect()->route('admin.campaigns.index')->with('status', 'Campaign created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $campaign = Campaign::findOrFail($id);

        return view('admin.campaign.create_edit', ['campaign' => $campaign]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(CampaignCreateEditRequest $request, $id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->update($request->all());
        $campaign->updatePrices($request);

        $categories = $request->input('categories');
        $campaign->campaign_categories()->detach();
        $campaign->campaign_categories()->attach($categories);
        $campaign->save();

        return redirect()->route('admin.campaigns.index')->with('status', 'Campaign updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();

        return redirect()->route('admin.campaigns.index')->with('status', 'Campaign deleted successfully!');
    }

    /**
     * @param Campaign $campaign
     * 
     * @return [type]
     */
    public function duplicate(Campaign $campaign)
    {
        $newCampaign = $campaign->replicate()->fill(['created_at' => Carbon::now()]);
        $newCampaign->push();

        foreach ($campaign->campaign_prices as $price) {
            $newPrice = CampaignPrice::create($price->toArray());
            $newPrice->update(['campaign_id' => $newCampaign->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        }

        foreach ($campaign->campaign_categories as $category) {
            $newCampaign->campaign_categories()->attach($category);
        }

        return redirect()->route('admin.campaigns.index')->with('status', 'Campaign duplicated successfully!');
    }
}
