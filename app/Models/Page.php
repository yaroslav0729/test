<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use Config;

class Page extends Model
{
    use HasFactory;

    const POST_STATUS_MOVED_TO_TRASH = 0;
    const POST_STATUS_EDITED = 1;
    const POST_STATUS_PUBLICHED = 2;
    const POST_STATUS_NOT_PUBLICHED = 3;

    const POST_STATUS = [
        self::POST_STATUS_MOVED_TO_TRASH => 'Moved to trash',
        self::POST_STATUS_EDITED => 'Edited',
        self::POST_STATUS_PUBLICHED => 'Published',
        self::POST_STATUS_NOT_PUBLICHED => 'Not published',
    ];

    public function page_instances()
    {
        return $this->hasMany('App\Models\PageInstance');
    }

    public function getActualPageInstanceAttribute()
    {
        return $this->page_instances()->where('actual', true)->first();
    }

    public function getStatusNameAttribute()
    {
        return self::POST_STATUS[$this->status];
    }

    public function removeOldPosts()
    {
        $limit = Config('app.POST_HISTORY_QUANTITY');
        $ids = PageInstance::where('page_id', $this->id)->orderBy('id', 'desc')->limit($limit)->pluck('id')->toArray();
        
        $actualPostId = $this->actual_page_instance->id;

        if (!in_array($actualPostId, $ids))
            array_push($ids, $actualPostId);

            PageInstance::where('page_id', $this->id)
                ->whereNotIn('id', $ids)->delete();
    }
}
