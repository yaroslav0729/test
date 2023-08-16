<?php

namespace App\Http\Controllers;

use App\Http\Requests\FoodPackPagesRequest;
use App\Services\FoodPackQurbaniesPageService;

class FoodPackQurbaniPagesController extends Controller
{
    private $foodPackQurbaniesPageService;

    public function __construct(FoodPackQurbaniesPageService $foodPackQurbaniesPageService)
    {
        $this->foodPackQurbaniesPageService = $foodPackQurbaniesPageService;
    }

    public function show(FoodPackPagesRequest $foodPackPagesRequest): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'show' => $this->foodPackQurbaniesPageService->showWidget($foodPackPagesRequest->get('page_url'))
        ]);
    }
}
