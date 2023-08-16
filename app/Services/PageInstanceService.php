<?php

namespace App\Services;

use App\Models\PageInstance;
use Illuminate\Database\Eloquent\Builder;

class PageInstanceService
{
    public function actualPublishedBySlugQuery(string $slug)
    {
        return PageInstance::where('slug', $slug)
            ->where('actual', true)
            ->whereHas('page', function(Builder $queryPage) {
                $queryPage->published();
            });
    }
}