<?php

namespace App\Services;

use App\Models\FoodPacksPrice;
use App\Models\FoodPacksQurbaniesPrice;
use App\Models\FoodPacksQurbaniesType;
use Database\Seeders\FoodPackQurbaniTypesSeeder;
use Illuminate\Http\Request;

class FoodPackQurbaniService extends AbstractModelService
{
    private $foodPacksQurbaniesType;

    public function __construct(FoodPacksQurbaniesPrice $foodPacksQurbaniesPrice, FoodPacksQurbaniesType $foodPacksQurbaniesType)
    {
        $this->model = $foodPacksQurbaniesPrice;
        $this->foodPacksQurbaniesType = $foodPacksQurbaniesType;
    }

    public function createNewFoodPack(Request $request): bool
    {
        $this->create([
            'country_id' => $request->get('country_id'),
            'campaign_name' => $request->get('campaign_name'),
            'project_name' => $request->get('project_name'),
            'program_name' => $request->get('program_name'),
            'campaign_category_id' => $request->get('campaign_category_id'),
        ]);

        if (!empty($this->model->id)) {
            foreach ($request->get('prices') as $key => $price)
            {
                $this->model->types()->attach($this->foodPacksQurbaniesType->getById($request->get('types')[$key]), ['price' => $price]);
            }

            return true;
        }else {
            return false;
        }
    }

    public function updateFoodPack(FoodPacksQurbaniesPrice $foodPacksPrice, Request $request): bool
    {
        $this->update($foodPacksPrice, [
            'country_id' => $request->get('country_id'),
            'campaign_name' => $request->get('campaign_name'),
            'project_name' => $request->get('project_name'),
            'program_name' => $request->get('program_name'),
            'campaign_category_id' => $request->get('campaign_category_id'),
        ]);

        if (!empty($this->model->id)) {
            $arr = [];

            foreach ($request->get('prices') as $key => $price)
            {
                $arr[$request->get('types')[$key]] = ['price' => $price];
            }

            $this->model->types()->sync($arr);

            return true;
        }else {
            return false;
        }
    }

    public function getList()
    {
        return $this->model->with(['country', 'types'])->get();
    }
}
