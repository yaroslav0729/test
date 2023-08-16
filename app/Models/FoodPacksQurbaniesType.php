<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodPacksQurbaniesType extends Model
{
    protected $fillable = [
        'name'
    ];

    public function getById(int $id)
    {
        return $this->whereId($id)->first();
    }
}
