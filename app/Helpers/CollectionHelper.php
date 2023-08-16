<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;

class CollectionHelper
{
    public static function maxDepth(Collection $collection, string $field)
    {
        $max_depth = 1;

        foreach ($collection as $value) {
            if ($value->$field instanceof Collection && $value->$field->count()) {

                $depth = self::maxDepth($value->$field, $field) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    }
}