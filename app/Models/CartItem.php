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

    public function campaign()
    {
        return $this->hasOne('App\Models\Campaign');
    }

    public function campaign_category()
    {
        return $this->belongsTo('App\Models\CampaignCategory');
    }

    public static function getCart()
    {
        $cartItems = session()->get('cart');

        if (is_array($cartItems)) {
            
            return \App\Models\CartItem::whereIn('cart_item_id', $cartItems)->get();
        }
        
        return [];
    }

    public static function getCartSum()
    {
        $cartItems = session()->get('cart');

        if (is_array($cartItems)) {
            
            $items = \App\Models\CartItem::whereIn('cart_item_id', $cartItems)->get();
        
            $sum = 0;
            foreach ($items as $item) {
                $sum = $sum + $item->amount;    
            }

            return $sum;
        }
        
        return 0;
    }
}
