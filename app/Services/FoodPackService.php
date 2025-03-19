<?php

namespace App\Services;

use App\Models\FoodPacksPrice;
use Illuminate\Http\Request;

class FoodPackService extends AbstractModelService
{
    public function __construct(FoodPacksPrice $foodPacksPrice)
    {
        $this->model = $foodPacksPrice;
    }

    public function createNewFoodPack(Request $request): bool
    {
        $this->create([
            'country_id' => $request->get('country_id'),
            'price' => $request->get('price'),
            'campaign_name' => $request->get('campaign_name'),
            'project_name' => $request->get('project_name'),
            'program_name' => $request->get('program_name'),
            'campaign_category_id' => $request->get('campaign_category_id'),
        ]);

        if (!empty($this->model->id)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateFoodPack(FoodPacksPrice $foodPacksPrice, Request $request): bool
    {
        $this->update($foodPacksPrice, [
            'country_id' => $request->get('country_id'),
            'price' => $request->get('price'),
            'campaign_name' => $request->get('campaign_name'),
            'project_name' => $request->get('project_name'),
            'program_name' => $request->get('program_name'),
            'campaign_category_id' => $request->get('campaign_category_id'),
        ]);

        if (!empty($this->model->id)) {
            return true;
        } else {
            return false;
        }
    }

    public function getList()
    {
        return $this->model->without('country')
            ->join('countries', 'food_packs_prices.country_id', '=', 'countries.id')
            ->leftJoin('campaign_categories', 'food_packs_prices.campaign_category_id', '=', 'campaign_categories.id')
            ->select(
                'food_packs_prices.price',
                'food_packs_prices.campaign_name',
                'food_packs_prices.project_name',
                'food_packs_prices.program_name',
                'countries.name',
                'campaign_categories.name as category_name',
                'food_packs_prices.id'
            )->get();
    }

    public function getById($id)
    {
        return $this->model->with(['country', 'campaign_category'])->findOrFail($id);
    }
}
