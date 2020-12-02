<?php

namespace App\Models;

use App\Models\Template;
use Config;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CampaignPrice;

class Page extends Model
{
    use HasFactory;

    const TYPE_INDEX_PAGE = 1;
    const TYPE_PROJECTS_PAGE = 2;

    const PAGE_STATUS_MOVED_TO_TRASH = 0;
    const PAGE_STATUS_EDITED = 1;
    const PAGE_STATUS_PUBLICHED = 2;
    const PAGE_STATUS_NOT_PUBLICHED = 3;

    const POST_STATUS = [
        self::PAGE_STATUS_MOVED_TO_TRASH => 'Moved to trash',
        self::PAGE_STATUS_EDITED => 'Edited',
        self::PAGE_STATUS_PUBLICHED => 'Published',
        self::PAGE_STATUS_NOT_PUBLICHED => 'Not published',
    ];

    protected $fillable = [
        'status', 'type', 'wp_id'
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

    public function scopeIndex($query)
    {
        return $query->where('type', self::TYPE_INDEX_PAGE);
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

    public static function getProjectsUrl()
    {
        $page = Page::where('type', self::TYPE_PROJECTS_PAGE)->first();

        if ($page) {
            $slug = $page->actual_page_instance->slug;
        } else {
            $slug = "";
        }

        return url($slug);
    }

    public static function getAllProjects()
    {
        $pages = Page::whereHas('pageInstances', function (Builder $query) {
            $query->where('template', Template::PROJECT_PAGE);
        })->get();

        return $pages;
    }

    public static function getAllEvents()
    {
        $pages = Page::whereHas('pageInstances', function (Builder $query) {
            $query->where(['template'=> Template::EVENT_PAGE, 'actual' => 1]);
        });

        return $pages;
    }

    /**
     * Get the Event for the Page.
     */
    public function event()
    {
        return $this->hasOne('App\Models\Event');
    }
}
