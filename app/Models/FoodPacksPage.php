<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodPacksPage extends Model
{
    protected $fillable = [
        'page_url',
        'active_at'
    ];

    protected $casts = [
        'active_at' => 'datetime'
    ];
}
