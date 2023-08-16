<?php

namespace App\Models;

use App\Helpers\CollectionHelper;
use App\Helpers\MenuHelper;
use App\Helpers\RegexHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class MenuItem extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    const HEADER_MENU = 10;
    const ADDITIONAL_HEADER_MENU = 15;
    const FOOTER_MENU = 20;
    const ADDITIONAL_FOOTER_MENU = 25;
    const SOCIAL_MENU = 30;

    const DROPDOWN_MENU_TYPES = [ self::SOCIAL_MENU ];

    const SOCIAL_MENU_LIST = [
        'facebook' => [
            'title' => 'Facebook',
            'icon' => 'fab fa-facebook-f'
        ],
        'instagram' => [
            'title' => 'Instagram',
            'icon' => 'fab fa-instagram'
        ],
        'youtube' => [
            'title' => 'Youtube',
            'icon' => 'fab fa-youtube'
        ],
        'twitter' => [
            'title' => 'Twitter',
            'icon' => 'fab fa-twitter'
        ]
    ];

    const ALL_TYPES_MENU = [
        self::HEADER_MENU => 'Header menu',
        self::ADDITIONAL_HEADER_MENU => 'Additional header menu',
        self::FOOTER_MENU => 'Footer menu',
        self::ADDITIONAL_FOOTER_MENU => 'Additional footer menu',
        self::SOCIAL_MENU => 'Social Menu'
    ];

    const ALL_SLUG_MENU = [
        self::HEADER_MENU => 'header',
        self::ADDITIONAL_HEADER_MENU => 'additional-header',
        self::FOOTER_MENU => 'footer',
        self::ADDITIONAL_FOOTER_MENU => 'additional-footer',
        self::SOCIAL_MENU => 'social'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'destination',
        'text',
        'is_group',
        'link',
        'parent_id',
        'ordering',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_group' => 'boolean'
    ];

    public $sortable = [
        'order_column_name' => 'ordering',
        'sort_when_creating' => true,
    ];

    public function buildSortQuery()
    {
        return static::query()->where([
            'parent_id' => $this->parent_id,
            'destination' => $this->destination
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subMenus()
    {
        return $this->hasMany('App\Models\MenuItem', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\MenuItem', 'parent_id')->with('parent');
    }

    public function orderedSubMenus()
    {
        return $this->subMenus()->ordered();
    }

    public function scopeRootMenu($query)
    {
        return $query->ordered()->parentless();
    }

    public function scopeRootMenuByDestination($query, string $destination)
    {
        return $query->rootMenu()->destination($destination);
    }

    public function scopeDestination($query, string $destination)
    {
        return $query->whereDestination($destination);
    }

    public function scopeParentless($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeParent($query, $parent = null)
    {
        return $query->where('parent_id', $parent);
    }

    public function isHeaderMenu()
    {
        return $this->destination === self::HEADER_MENU;
    }

    public function isFooterMenu()
    {
        return $this->destination === self::FOOTER_MENU;
    }

    public function getMaxDepthAttribute()
    {
        return CollectionHelper::maxDepth($this->orderedSubMenus, "orderedSubMenus");
    }

    public function getDepthAttribute()
    {
        return MenuHelper::getDepth($this);
    }

    public function getFormattedLinkAttribute()
    {
        if ($this->link) {
            if (RegexHelper::isTelephone($this->link)) {
                return "tel:" . $this->link;
            } elseif (RegexHelper::isEmail($this->link)) {
                return "mailto:" . $this->link;
            }
        }

        return $this->link;
    }
}
