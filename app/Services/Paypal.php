<?php

namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PaypalCheckoutSdk\Orders\OrdersAuthorizeRequest;

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

    public static function captureOrder($orderId)
    {
        $client = self::getClient();
        $request = new OrdersCaptureRequest($orderId);
        $request->prefer('return=representation');

        $response = $client->execute($request);
        return $response;
    }

    public static function authorizeOrder($orderId)
    {
        $client = self::getClient();
        $request = new OrdersAuthorizeRequest($orderId);
        $request->prefer('return=representation');

        $response = $client->execute($request);
        return $response;
    }

    protected static function getClient()
    {
        $clientId = config('paypal.PAYPAL_CLIENT_ID');
        $clientSecret = config('paypal.PAYPAL_CLIENT_SECRET');
        $environment = config('app.env') === 'production' ? new ProductionEnvironment($clientId, $clientSecret) : new SandboxEnvironment($clientId, $clientSecret);

        return new PayPalHttpClient($environment);
    }
}
