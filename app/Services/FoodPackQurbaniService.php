<?php

namespace App\Services;

use App\Models\FoodPacksPrice;
use App\Models\FoodPacksQurbaniesPrice;
use App\Models\FoodPacksQurbaniesType;
use Database\Seeders\FoodPackQurbaniTypesSeeder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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
            'project_name' => $request->get('project_name'),
            'program_name' => $request->get('program_name'),
            'campaign_category_id' => $request->get('campaign_category_id'),
            'feedback' => $request->get('feedback'),
            'order' => $request->get('order')
        ]);

        if (!empty($this->model->id)) {
            foreach ($request->get('prices') as $key => $price)
            {
                $this->model->types()->attach($this->foodPacksQurbaniesType->getById($request->get('types')[$key]), [
                    'price' => $price,
                    'campaign_id' => $request->get('campaign_id')
                ]);
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
            'project_name' => $request->get('project_name'),
            'program_name' => $request->get('program_name'),
            'campaign_category_id' => $request->get('campaign_category_id'),
            'feedback' => $request->get('feedback'),
            'order' => $request->get('order')
        ]);

        if (!empty($this->model->id)) {
            $arr = [];

            foreach ($request->get('prices') as $key => $price)
            {
                $arr[$request->get('types')[$key]] = [
                    'price' => $price,
                    'campaign_id' => $request->get('campaign_id')
                ];
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

    /**
     * Get records with pagination, ordered by the 'order' field.
     *
     * @param Request $request
     * @param int $perPage
     * @param int $currentPage
     * @return LengthAwarePaginator
     */
    public function getWithPaginate(Request $request, int $perPage = 10, int $currentPage = 0): LengthAwarePaginator
    {
        // The $currentPage parameter might be used by paginate if not null or 0, depending on Laravel version and implementation.
        // If $currentPage is 0, paginate typically defaults to page 1.
        // If AbstractModelService used $currentPage, we should honor it.
        // For now, let's assume $perPage is the primary concern for overriding.
        return $this->model->orderBy('order', 'asc')->paginate($perPage, ['*'], 'page', $currentPage == 0 ? null : $currentPage);
    }
}
