<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FoodPackPagesRequest;
use App\Services\FoodPackPageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FoodPackPagesController extends Controller
{
    private $foodPackPageService;

    public function __construct(FoodPackPageService $foodPackPageService)
    {
        $this->foodPackPageService = $foodPackPageService;
    }

    public function index(Request $request)
    {
        return view('admin.foodpack.pages.index', [
            'foodPacksPages' => $this->foodPackPageService->getWithPaginate($request)
        ]);
    }

    public function create()
    {
        return view('admin.foodpack.pages.create');
    }

    public function store(FoodPackPagesRequest $request)
    {
        if (!$this->foodPackPageService->createNewPage($request))
        {
            abort(500);
        }

        return redirect()->back()->with('status', 'Success! Food pack price added!');
    }

    public function destroy($id)
    {
        $this->foodPackPageService->destroy($id);

        return redirect()->back()->with('status', 'Success! Food pack price deleted!');
    }
}
