<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'title', 'email', 'phone', 'address_1', 'address_2', 
        'city', 'country', 'post_code', 'gift_aid', 'comment', 'pay_with', 'order_id', 
        'is_subscription_active', 'pay_day', 'account_number', 'sort_code', 
        'stripe_payment_intent_id', 'stripe_subscription_id'
    ];

    protected $casts = [
        'gift_aid' => 'boolean',
        'is_subscription_active' => 'boolean',
    ];

    public function donations()
    {
        return $this->hasMany('App\Models\Donation');
    }

    public function getSumAttribute()
    {
        $sum = 0;

        if (isset($this->donations)) {
            foreach ($this->donations as $donation) {
                $sum = $sum + $donation->value;
            }
        }

        return $sum;
    }


}
