<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempStoreDonationData extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','donation_data']; 
}
