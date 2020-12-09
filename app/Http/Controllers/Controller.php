<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;

use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; 

    public function createOrder()
    {
        $client = $this->getClient();

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
                            "intent" => "CAPTURE",
                            "purchase_units" => [[
                                "reference_id" => "test_ref_id1",
                                "amount" => [
                                    "value" => "100.00",
                                    "currency_code" => "USD"
                                ]
                            ]],
                            "application_context" => [
                                "cancel_url" => "https://example.com/cancel",
                                "return_url" => "https://example.com/return"
                            ] 
                        ];

        $response = $client->execute($request);

        dd($response);
    }

    public function getOrder($orderId)
    {
        $client = $this->getClient();

        $response = $client->execute(new OrdersGetRequest($orderId));

        dd($response);
    }



    protected function getClient()
    {
        $clientId = "ARLMjR0yJKKjj14tm1TN7VahF-4_Ezn8XW0GoUeyHY2RPjgcPtjz8V6lIvgK4n4fC36i5oD-Q35BZPJo";
        $clientSecret = "EHjsP5VUDzPb6JGUkuh6aeTqbE4ze6h1nNZTVCBbiU-o2twwumAu_nALNkicRy8ickFkNqdenG_ZVkaO";

        $environment = new SandboxEnvironment($clientId, $clientSecret);
        return new PayPalHttpClient($environment);
    }
}
