<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateEditPriceRequest;
use App\Models\CampaignPrice;

class CampaignPricesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaignPrices = CampaignPrice::paginate(20);

        return view('admin.campaign_prices.index', compact('campaignPrices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.campaign_prices.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEditPriceRequest $request)
    {
        $campaign = CampaignPrice::create($request->all());

        return redirect()->route('admin.campaign_prices.index')->with('status', 'Campaign price created successfully!');
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $campaignPrice = CampaignPrice::findOrFail($id);

        return view('admin.campaign_prices.create_edit', compact('campaignPrice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateEditPriceRequest $request, $id)
    {
        $campaignPrice = CampaignPrice::findOrFail($id);
        $campaignPrice->update($request->all());

        return redirect()->route('admin.campaign_prices.index')->with('status', 'Campaign price updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaignPrice = CampaignPrice::findOrFail($id);
        $campaignPrice->delete();

        return redirect()->route('admin.campaign_prices.index')->with('status', 'Campaign price deleted successfully!');
    }
}
