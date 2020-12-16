<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

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
