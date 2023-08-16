<?php

return [
    'public_key' => env('STRIPE_KEY'),
    'secret_key' => env('STRIPE_SECRET'),
    'endpoint_secret' => env('STRIPE_ENDPOINT_SECRET'),
    'stripe_webhook_key' => env('STRIPE_WEBHOOK_KEY'),
];
