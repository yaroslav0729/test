<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    use HasFactory;

    const TYPE_301 = 301;
    const TYPE_302 = 302;

    const TYPES = [
        self::TYPE_301 => '301 - permanently redirect',
        self::TYPE_302 => '302 - temporary redirect'   
    ];

    protected $fillable = [
        'url_from',
        'url_to',
        'type'
    ];
}
