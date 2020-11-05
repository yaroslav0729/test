<?php

namespace App\Models;

use Config;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function pageInstances()
    {
        return $this->hasMany('App\Models\PageInstance');
    }

    public function getActualPageInstanceAttribute()
    {
        return $this->pageInstances()->where('actual', true)->first();
    }

    public function getStatusNameAttribute()
    {
        return self::POST_STATUS[$this->status];
    }

    public function removeOldHistory()
    {
        $limit = Config('app.POST_HISTORY_QUANTITY');
        $ids = PageInstance::where('page_id', $this->id)->orderBy('id', 'desc')->limit($limit)->pluck('id')->toArray();

        $actualId = $this->actual_page_instance->id;

        if (!in_array($actualId, $ids)) {
            array_push($ids, $actualId);
        }

        PageInstance::where('page_id', $this->id)
            ->whereNotIn('id', $ids)->delete();
    }
}
