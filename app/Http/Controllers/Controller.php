<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;

use App\Services\Paypal;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; 

    public function createOrder()
    {
        $response = Paypal::createOrder(100, "GBP", 'test order');

        dd($response);
    }

    public function getOrder($orderId)
    {
        $response = Paypal::getOrder($orderId);

        dd($response);
    }
}
