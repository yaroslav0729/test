<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostContainer extends Model
{
    use HasFactory;

    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    public function getActualPostAttribute()
    {
        return $this->posts()->where('actual', true)->first();
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function($model){
            // $post = $model->actual_post;
            // $post->actual = false;
            // $post->save();

            $model->posts()->delete();
        });
    }
}
