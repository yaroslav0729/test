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
        ]);

        if (!empty($this->model->id)) {
            return true;
        }else {
            return false;
        }
    }

    public function updateFoodPack(FoodPacksPrice $foodPacksPrice, Request $request): bool
    {
        $this->update($foodPacksPrice, [
            'country_id' => $request->get('country_id'),
            'price' => $request->get('price'),
        ]);

        if (!empty($this->model->id)) {
            return true;
        }else {
            return false;
        }
    }

    public function getList()
    {
        return $this->model->without('country')->join('countries', 'food_packs_prices.country_id', '=', 'countries.id')->select('food_packs_prices.price','countries.name', 'food_packs_prices.id')->get();
    }
}
