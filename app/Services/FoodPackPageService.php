<?php

namespace App\Services;

use App\Models\FoodPacksPage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FoodPackPageService extends AbstractModelService
{
    public function __construct(FoodPacksPage $foodPacksPage)
    {
        $this->model = $foodPacksPage;
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

    public function updateStatus(FoodPacksPage $foodPacksPage, Request $request): bool
    {
        $this->update($foodPacksPage, [
            'active_at' => Carbon::parse($foodPacksPage->active_at)->isValid() ? null : now(),
        ]);

        if (!empty($this->model->id)) {
            return true;
        }else {
            return false;
        }
    }

    public function showWidget(string $pageUrl): bool
    {
        return !$this->model->whereRaw("'{$pageUrl}' like `page_url`")->whereNotNull('active_at')->exists();
    }
}
