<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodPacksQurbaniesPrice extends Model
{
    protected $fillable = [
        'country_id',
    ];

    public function types(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(FoodPacksQurbaniesType::class)->withPivot('price', 'campaign_id');
    }

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
