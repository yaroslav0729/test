<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GlobalPayController extends Controller
{
    public function result(Request $request)
    {
        dd($request->all());
    }
}
