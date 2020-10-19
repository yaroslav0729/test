<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'title',
        'description',
        'keywords',
    ];

    public function groups()
    {
        return $this->belongsToMany('App\Models\PostGroup');
    }

    public function getGroupIdsAttribute()
    {
        return $this->groups->pluck('id')->toArray();
    }
}
