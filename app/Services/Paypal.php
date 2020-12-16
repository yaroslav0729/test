<?php

namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

class Paypal
{
    public static function createOrder($amount, $currencyCode, $referenceId)
    {
        $client = self::getClient();

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $referenceId,
                "amount" => [
                    "value" => $amount,
                    "currency_code" => $currencyCode,
                ],
            ]],
            "application_context" => [
                "cancel_url" => route('paypal.payment.cancel'),
                "return_url" => route('paypal.payment.success'),
            ],
        ];

        $response = $client->execute($request);

        return $response;
    }

    public static function getOrder($orderId)
    {
        $client = self::getClient();
        $response = $client->execute(new OrdersGetRequest($orderId));

        return $response;
    }

    protected static function getClient()
    {
        $clientId = config('paypal.PAYPAL_CLIENT_ID');
        $clientSecret = config('paypal.PAYPAL_CLIENT_SECRET');
        $environment = new SandboxEnvironment($clientId, $clientSecret);

        return new PayPalHttpClient($environment);
    }
}
