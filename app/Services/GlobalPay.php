<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GlobalPay
{
    // const MERCHANT_ID = config('globalpay.merchant_id'); //
    // const SHARED_SECRET = 'IyquPverj6'; //

    public $amount;
    public $currency;
    public $dateString;
    public $orderId;
    public $data;

    protected $merchantId;
    protected $sharedSecret;

    public function __construct($amount, $currencyCode, $data)
    {
        $this->amount = $amount;
        $this->currency = $currencyCode;
        $this->data = $data;
        $this->dateString = $this->getTimestamp();
        $this->orderId = $this->dateString . '-' . Str::random(10);
        $this->merchantId = config('globalpay.merchant_id');
        $this->sharedSecret = config('globalpay.shared_secret');
    }

    public function getPayLink()
    {
        $paymentUrl = config('app.env') === 'production' ? 'https://pay.realexpayments.com/pay' : 'https://pay.sandbox.realexpayments.com/pay';
        $response = Http::withHeaders([
            'Content-type' => 'application/json',
        ])->post($paymentUrl, [
            "SHA1HASH" => $this->getSha1(),
            "TIMESTAMP" => $this->dateString,
            "MERCHANT_ID" => $this->merchantId,
            "ORDER_ID" => $this->orderId,
            "AMOUNT" => $this->amount,
            "CURRENCY" => $this->currency,
            "AUTO_SETTLE_FLAG" => "1",
            "HPP_VERSION" => "2",
            "HPP_LANG" => "en",
            "HPP_CUSTOMER_EMAIL" => $this->data['email'],
            "HPP_CUSTOMER_PHONENUMBER_MOBILE" => $this->data['phone'],
            "HPP_BILLING_STREET1" => $this->data['address_1'],
            "HPP_BILLING_STREET2" => $this->data['address_2'],
            // "HPP_BILLING_STREET3" => "Unit 4",
            // "HPP_BILLING_CITY" => "Halifax",
            "HPP_BILLING_POSTALCODE" => $this->data['post_code'],
            //"HPP_BILLING_COUNTRY" => "",
            // "HPP_SHIPPING_STREET1" => "Apartment 852",
            // "HPP_SHIPPING_STREET2" => "Complex 741",
            // "HPP_SHIPPING_STREET3" => "House 963",
            // "HPP_SHIPPING_CITY" => "Chicago",
            // "HPP_SHIPPING_STATE" => "IL",
            // "HPP_SHIPPING_POSTALCODE" => "50001",
            // "HPP_SHIPPING_COUNTRY" => "840",
            // "HPP_ADDRESS_MATCH_INDICATOR" => "FALSE",
            // "HPP_CHALLENGE_REQUEST_INDICATOR" => "NO_PREFERENCE",
            // "BILLING_CODE" => "59|123",
            // "BILLING_CO" => "GB",
            // "SHIPPING_CODE" => "50001|Apartment 852",
            // "SHIPPING_CO" => "US",
            // "CUST_NUM" => "6e027928-c477-4689-a45f-4e138a1f208a",
            // "VAR_REF" => "Acme Corporation",
            // "PROD_ID" => "SKU1000054",
            //"STATUS_UPDATE_URL" => route('globalpay.status_update'),
            "MERCHANT_RESPONSE_URL" => route('globalpay.result'), //'https://webhook.site/e198adb9-d5fd-4d9d-a9da-bc3b302724f6',
            "SUPPLEMENTARY_DATA" => "Custom Value"
        ]);

        return $response->json();
    }

    protected function getSha1()
    {
        $string = $this->dateString . "." .  $this->merchantId . "." . $this->orderId . "." . intval($this->amount) . "." . $this->currency;
        $string = hash('sha1', $string);
        $string = $string .  "." . $this->sharedSecret;
        $string = hash('sha1', $string);

        return $string;
    }

    protected function getTimestamp()
    {
        return date('YmdHis');
    }
}
