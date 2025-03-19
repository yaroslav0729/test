<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FoodPackQurbaniRequest;
use App\Http\Requests\FoodPackQurbaniUpdateRequest;
use App\Http\Requests\FoodPackRequest;
use App\Http\Requests\FoodPackUpdateRequest;
use App\Models\Country;
use App\Models\FoodPackSettings;
use App\Models\FoodPacksQurbaniesType;
use App\Services\FoodPackQurbaniService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FoodPackQurbaniController extends Controller
{
    private $foodPackService;
    private $types;
    private $settings;

    public function __construct(
        FoodPackQurbaniService $foodPackService,
        FoodPacksQurbaniesType $foodPacksQurbaniesType,
        FoodPackSettings $settings
    ) {
        $this->foodPackService = $foodPackService;
        $this->types = $foodPacksQurbaniesType;
        $this->settings = $settings;
    }

    public function index(Request $request)
    {
        return view('admin.foodpack-qurbani.index', [
            'foodpacks' => $this->foodPackService->getWithPaginate($request),
            'types' => $this->types->get(),
        ]);
    }

    public function create()
    {
        return view('admin.foodpack-qurbani.create', [
            'countries' => Country::query()->orderBy('name')->get(),
            'types' => $this->types->get(),
            'categories' => \App\Models\CampaignCategory::all()
        ]);
    }

    public function store(FoodPackQurbaniRequest $request)
    {
        if (!$this->foodPackService->createNewFoodPack($request))
        {
            abort(500);
        }

        return redirect()->back()->with('status', 'Success! Food pack price added!');
    }

    public function edit($id)
    {
        return view('admin.foodpack-qurbani.edit', [
            'countries' => Country::query()->orderBy('name')->get(),
            'foodpack' => $this->foodPackService->getById($id),
            'categories' => \App\Models\CampaignCategory::all()
        ]);
    }

    public function update(FoodPackQurbaniUpdateRequest $request, $id)
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
