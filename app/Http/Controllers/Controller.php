<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;

use App\Models\CartItem;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; 

    public function test()
    {
        dd('ok');
    }
}
