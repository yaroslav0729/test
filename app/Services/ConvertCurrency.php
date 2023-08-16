<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class ConvertCurrency
{
    private Client $client;
    private const BASE_URL = 'https://api.apilayer.com/fixer/latest';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getRateUsdToGbp(): array
    {
        $response = $this->client->get(self::BASE_URL . '?base=USD&symbols=GBP', [
            'headers' => [
                'apiKey' => config('currency.api_key'),
            ],
        ]);

        if ($response->getStatusCode() === Response::HTTP_OK) {
            $body = $response->getBody();
            $content = $body->getContents();

            return json_decode($content, true)['rates'];
        }

        throw new \RuntimeException('error api currency converter');
    }
}
