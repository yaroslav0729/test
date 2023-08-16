<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodPacksPrice extends Model
{
    protected $with = [
        'country'
    ];

    protected $fillable = [
        'country_id',
        'price'
    ];

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
