<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/admin/media/*',
        '/stripe/*',
        '/globalpay/payment_result',
        '/globalpay/payment_status_update',
        '/test-email-receipt'
    ];
}
