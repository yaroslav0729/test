<?php

namespace App\Models;

use App\Models\PageInstance;

class Module
{
    public static function getRelatedPages($categoryId)
    {
        $pages = PageInstance::where('actual', true)
            ->published()
            ->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            })->limit(3)->get();

        return $pages;
    }
}
