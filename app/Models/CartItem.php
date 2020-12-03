<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CartItem extends Model
{
    use HasFactory;

    protected $guarded = ['cart_item_id'];

    public static function boot()
    {
        parent::boot();

        $randomStr = Carbon::now()->timestamp;
        $randomStr = $randomStr . '_' . Str::random(20);

        self::creating(function($model) use ($randomStr) {
            $model->cart_item_id = $randomStr;
        });    
    }
}
