<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FoodPackRequest;
use App\Http\Requests\FoodPackUpdateRequest;
use App\Models\Country;
use App\Models\FoodPackSettings;
use App\Services\FoodPackService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FoodPackController extends Controller
{
    private $foodPackService;
    private $settings;

    public function __construct(FoodPackService $foodPackService, FoodPackSettings $settings)
    {
        $this->settings = $settings;
        $this->foodPackService = $foodPackService;
    }

    public function index(Request $request)
    {
        return view('admin.foodpack.index', [
            'foodpacks' => $this->foodPackService->getWithPaginate($request),
            'settings' => $this->settings
        ]);
    }

    public function create()
    {
        return view('admin.foodpack.create', [
            'countries' => Country::query()->orderBy('name')->get(),
        ]);
    }

    public function store(FoodPackRequest $request)
    {
        if (!$this->foodPackService->createNewFoodPack($request))
        {
            abort(500);
        }

        return redirect()->back()->with('status', 'Success! Food pack price added!');
    }

    public function edit($id)
    {
        return view('admin.foodpack.edit', [
            'countries' => Country::query()->orderBy('name')->get(),
            'foodpack' => $this->foodPackService->getById($id),
            'categories' => \App\Models\CampaignCategory::all()
        ]);
    }

    public function update(FoodPackUpdateRequest $request, $id)
    {
        if (!$this->foodPackService->updateFoodPack($this->foodPackService->getById($id), $request))
        {
            abort(500);
        }

        return redirect()->back()->with('status', 'Success! Food pack price updated!');
    }

    public function updateSettings(Request $request)
    {
        $this->settings->update($request);

        return redirect()->back()->with('status', 'Success! Settings saved.');
    }

    public function destroy($id)
    {
        $this->foodPackService->destroy($id);

        return redirect()->back()->with('status', 'Success! Food pack price deleted!');
    }
}
