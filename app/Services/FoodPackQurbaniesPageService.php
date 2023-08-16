<?php

namespace App\Services;

use App\Models\FoodPacksPage;
use App\Models\FoodPacksQurbaniesPage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FoodPackQurbaniesPageService extends AbstractModelService
{
    public function __construct(FoodPacksQurbaniesPage $foodPacksQurbaniesPage)
    {
        $this->model = $foodPacksQurbaniesPage;
    }

    public function createNewPage(Request $request): bool
    {
        $this->create([
            'page_url' => $request->get('page_url'),
            'active_at' => now(),
        ]);

        if (!empty($this->model->id)) {
            return true;
        }else {
            return false;
        }
    }

    public function updateStatus(FoodPacksQurbaniesPage $foodPacksQurbaniesPage, Request $request): bool
    {
        $this->update($foodPacksQurbaniesPage, [
            'active_at' => Carbon::parse($foodPacksQurbaniesPage->active_at)->isValid() ? null : now(),
        ]);

        if (!empty($this->model->id)) {
            return true;
        }else {
            return false;
        }
    }

    public function showWidget(string $pageUrl): bool
    {
        return $this->model->whereRaw("'{$pageUrl}' like `page_url`")->exists();
    }
}
