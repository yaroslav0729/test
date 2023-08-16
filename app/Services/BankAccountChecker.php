<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BankAccountChecker
{
    private $url;
    private $key;
    private $pass;
    private $type;


    public function __construct()
    {
        $this->url = config('bank-account-checker.url');
        $this->key = config('bank-account-checker.key');
        $this->pass = config('bank-account-checker.pass');
        $this->type = config('bank-account-checker.type');
    }

    public function isCardValid($accountNumber, $sortCode)
    {
        $data = [
            'key' => $this->key,
            'password' => $this->pass,
            'output' => 'json',
            'type' => $this->type,
            'bankaccount' => $accountNumber,
            'sortcode' => $sortCode
        ];
        $response = Http::withOptions(['curl' => [
            CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1'
        ]]);
        $body = $response->get($this->url . http_build_query($data))->json();

        return [$body['resultCode'] == '01', $body['resultDescription']];
    }
}
