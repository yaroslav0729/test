<?php

namespace App\Models;

use App\Helpers\CollectionHelper;
use App\Helpers\RegexHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    const HEADER_MENU = 10;
    const ADDITIONAL_HEADER_MENU = 15;
    const FOOTER_MENU = 20;
    const ADDITIONAL_FOOTER_MENU = 25;

    const ALL_TYPES_MENU = [
        self::HEADER_MENU => 'Header menu',
        self::ADDITIONAL_HEADER_MENU => 'Additional header menu',
        self::FOOTER_MENU => 'Footer menu',
        self::ADDITIONAL_FOOTER_MENU => 'Additional footer menu',
    ];

    const ALL_SLUG_MENU = [
        self::HEADER_MENU => 'header',
        self::ADDITIONAL_HEADER_MENU => 'additional-header',
        self::FOOTER_MENU => 'footer',
        self::ADDITIONAL_FOOTER_MENU => 'additional-footer',
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
        'is_group' => 'boolean',
    ];

    public function setIsGroupAttribute($value)
    {
        $this->attributes['is_group'] = ($value == 'on') ? 1 : 0;
    }

    /**
     * @param string $menuSlug
     * @return array
     */
    public static function getMenuItems(string $menuSlug)
    {
        $menuDestination = self::getMenuDestination($menuSlug);

        if ($menuDestination) {
            return self::where('destination', $menuDestination);
        }

        return [];
    }

    /**
     * @param string $menuSlug
     * @return int|null
     */
    public static function getMenuDestination(string $menuSlug): ?int
    {
        foreach (self::ALL_SLUG_MENU as $key => $value) {
            if ($value === $menuSlug) {
                return $key;
            }
        }

        return null;
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
        return $this->belongsTo('App\Models\MenuItem', 'parent_id');
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

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordering');
    }   

    public function scopeParentless($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * @param int $id
     * @return int|mixed
     */
    public static function arrayDepth(int $id)
    {
        $depth = 1;
        $menuItem = self::find($id);

        if (!is_null($menuItem->parent_id)) {
            $depth += self::arrayDepth($menuItem->parent_id);
        }

        return $depth;
    }

    public function getMaxDepthAttribute()
    {
        return CollectionHelper::maxDepth($this->orderedSubMenus, "orderedSubMenus");
    }

    public function getFormattedLinkAttribute()
    {
        if (RegexHelper::isTelephone($this->link)) {
            return "tel:" . $this->link;
        } elseif (RegexHelper::isEmail($this->link)) {
            return "mailto:" . $this->link;
        }

        return $this->link;
    }

    /**
     * @return mixed
     */
/*    public static function getAdditionalHeaderMenu()
    {
        return self::whereDestination(self::ADDITIONAL_HEADER_MENU)->whereNull('parent_id')->get();
    }*/


/*    public static function getFooterMenu()
    {
        return self::whereDestination(self::FOOTER_MENU)->whereNull('parent_id')->get();
    }*/

/*    public static function getHeaderMenu()
    {
        return self::whereDestination(self::HEADER_MENU)->whereNull('parent_id')->get();
    }*/

    public static function getMenu(int $destination)
    {
        if (array_key_exists($destination, self::ALL_TYPES_MENU)){
            return self::whereDestination($destination)->parentless()->get();
        }

        return collect();
    }


}
