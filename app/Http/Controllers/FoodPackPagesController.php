<?php

namespace App\Http\Controllers;

use App\Http\Requests\FoodPackPagesRequest;
use App\Services\FoodPackPageService;

class FoodPackPagesController extends Controller
{
    private $foodPackPageService;

    public function __construct(FoodPackPageService $foodPackPageService)
    {
        $this->foodPackPageService = $foodPackPageService;
    }

    public function show(FoodPackPagesRequest $foodPackPagesRequest): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'show' => $this->foodPackPageService->showWidget($foodPackPagesRequest->get('page_url'))
        ]);
    }
}
