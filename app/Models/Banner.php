<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'content',
        'is_active'
    ];

    protected $casts = [
        'name' => 'string',
        'color' => 'string',
        'content' => 'string',
        'is_active' => 'boolean'
    ];
}
