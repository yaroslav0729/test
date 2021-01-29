<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PageInstance;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GlobalPayController extends Controller
{
    public function result(Request $request)
    {
        Log::info('Global pay request: ' . $request);

        return view('pages.global_pay_result');
    }

    public function statusUpdate(Request $request)
    {
        Log::info('Global pay status update: ' . $request);

        return response()->json([
            'message' => 'Success Global pay status update page',
            'success' => true,
            'request' => $request->all(),
        ]);
    }
}
