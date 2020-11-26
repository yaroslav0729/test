<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    const CURRENCY_EUR = 1;
    const CURRENCY_GBP = 2;
    const CURRENCY_USD = 3;

    public static function getAllCurrencies()
    {
        return [
            self::CURRENCY_EUR => [
                'name' => 'Euro',
                'code' => 'EUR',
                'sign' => '€'
            ],
            self::CURRENCY_GBP => [
                'name' => 'Great Britain Pound',
                'code' => 'GBP',
                'sign' => '£'
            ],
            self::CURRENCY_USD => [
                'name' => 'united states dollar',
                'code' => 'USD',
                'sign' => '$'
            ]
        ];
    }
}
