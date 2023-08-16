<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlackListRequest;
use App\Services\BlackListService;
use Illuminate\Http\Request;

class BlackListController extends Controller
{
    private BlackListService $blackListService;

    public function __construct(BlackListService $blackListService)
    {
        $this->blackListService = $blackListService;
    }

    public function index(Request $request)
    {
        return view('admin.black-list.index', [
            'blackLists' => $this->blackListService->getWithPaginate($request)
        ]);
    }

    public function create()
    {
        return view('admin.black-list.create');
    }

    public function store(BlackListRequest $request)
    {
        if (!$this->blackListService->addIp($request))
        {
            abort(500);
        }

        return redirect()->back()->with('status', 'Success! Ip added to black list!');

    }

    public function destroy($id)
    {
        $this->blackListService->destroy($id);

        return redirect()->back()->with('status', 'Success! Ip deleted!');
    }
}
