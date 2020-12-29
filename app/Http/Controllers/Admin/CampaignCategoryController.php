<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CampaignCategory;
use App\Http\Requests\CampaignCategoryRequest;

class CampaignCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaignCategories = CampaignCategory::paginate(10);

        return view('admin.campaign_categories.index', compact('campaignCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.campaign_categories.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignCategoryRequest $request)
    {
        $campaignCategory = CampaignCategory::create($request->all());

        return redirect()->route('admin.campaign_categories.index')->with('status', 'Campaign category created successfully!');
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
        $campaignCategory = CampaignCategory::findOrFail($id);

        return view('admin.campaign_categories.create_edit', compact('campaignCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CampaignCategoryRequest $request, $id)
    {
        $campaignCategory = CampaignCategory::findOrFail($id);
        $campaignCategory->update($request->all());

        return redirect()->route('admin.campaign_categories.index')->with('status', 'Campaign category updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaignCategory = CampaignCategory::findOrFail($id);
        $campaignCategory->delete();

        return redirect()->route('admin.campaign_categories.index')->with('status', 'Campaign category deleted successfully!');
    }
}
