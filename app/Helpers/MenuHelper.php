<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;

class MenuHelper
{
    public static function groupByLevels(Collection $menuItems, int $maxLevel, $level = 0, array &$result = [], &$parent = null)
    {
        if ($level >= $maxLevel) {
            return $result;
        }

        foreach ($menuItems as $item)
        {
            if ($parent) {
                $result[$level][$parent->id]['items'][] = $item;
            } else {
                $result[$level][] = $item;
            }

            if ($item->orderedSubMenus->count()) {
                
                $result[$level + 1][$item->id] = [
                    'parent_text' => $item->text,
                    'max_depth' => $item->max_depth,
                    'items' => []
                ];
                
                self::groupByLevels($item->orderedSubMenus, $maxLevel, $level + 1, $result, $item);
            }
        }

        return $result;
    }
}