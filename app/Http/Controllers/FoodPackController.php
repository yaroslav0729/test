<?php

namespace App\Http\Controllers;

use App\Services\FoodPackPageService;
use App\Services\FoodPackService;

class FoodPackController extends Controller
{
    private $foodPackService;

    public function __construct(FoodPackService $foodPackService)
    {
        $this->foodPackService = $foodPackService;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->foodPackService->getList());
    }
}
