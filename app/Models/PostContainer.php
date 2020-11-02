<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use Config;

class PostContainer extends Model
{
    use HasFactory;

    const POST_STATUS_MOVED_TO_TRASH = 0;
    const POST_STATUS_PUBLICHED = 1;
    const POST_STATUS_NOT_PUBLICHED = 2;

    const POST_STATUS = [
        self::POST_STATUS_MOVED_TO_TRASH => 'Moved to trash',
        self::POST_STATUS_PUBLICHED => 'Published',
        self::POST_STATUS_NOT_PUBLICHED => 'Not published',
    ];

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

        // self::deleting(function($model){
        //     $model->posts()->delete();
        // });
    }

    public function getStatusNameAttribute()
    {
        return self::POST_STATUS[$this->status];
    }


    public function removeOldPosts()
    {
        $limit = Config('app.POST_HISTORY_QUANTITY');
        $ids = Post::where('post_container_id', $this->id)->orderBy('id', 'desc')->limit($limit)->pluck('id')->toArray();
        
        $actualPostId = $this->actual_post->id;

        if (!in_array($actualPostId, $ids))
            array_push($ids, $actualPostId);

        Post::where('post_container_id', $this->id)
                ->whereNotIn('id', $ids)->delete();
    }
}
