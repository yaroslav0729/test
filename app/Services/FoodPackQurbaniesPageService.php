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
        $pageUrl = trim($request->get('page_url', ''));
        if (empty($pageUrl)) {
            return false;
        }
        
        // Sanitize the URL to prevent SQL injection
        $pageUrl = filter_var($pageUrl, FILTER_SANITIZE_STRING);
        
        $this->create([
            'page_url' => $pageUrl,
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
        return $this->model->where('page_url', 'like', $pageUrl)->exists();
    }
}
