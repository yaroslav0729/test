<?php

namespace App\Models;

use App\Models\PageInstance;
use Illuminate\Database\Eloquent\Builder;

class Module
{
    public static function getRelatedPages($categoryId)
    {
        $pages = PageInstance::where('actual', true)
            ->whereHas('page', function(Builder $queryPage) {
                $queryPage->published();
            })
            ->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            })->limit(3)->get();

        if (count($pages) === 0) { /* for test template view */
            $pages = PageInstance::where('actual', true)
            ->whereHas('page', function(Builder $queryPage) {
                $queryPage->published();
            })
            ->where('slug', 'like', 'media-centre' . '%')
            ->where('preview_img', '<>', null)
            ->where('preview_img', '<>', '')
            ->limit(3)->get();
        }

        return $pages;
    }
}
