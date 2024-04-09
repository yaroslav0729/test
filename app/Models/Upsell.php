<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upsell extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'active'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'price' => 'float',
        'active' => 'boolean'
    ];
}
