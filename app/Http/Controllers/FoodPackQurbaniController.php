<?php

namespace App\Http\Controllers;

use App\Services\FoodPackQurbaniService;

class FoodPackQurbaniController extends Controller
{
    public function __construct(FoodPackQurbaniService $foodPackService)
    {
        $this->foodPackService = $foodPackService;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->foodPackService->getList());
    }
}
