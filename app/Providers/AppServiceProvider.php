<?php

namespace App\Providers;

use App\Models\PageInstance;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\CartItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        Validator::extend('page_slug', function ($value, $parameters) {
            $query = PageInstance::query()->where('slug', $value)
                ->where('actual', true);

            if (isset($parameters[0])) {
                $query->where('page_id', '<>', $parameters[0]);
            }

            return !$query->count();
        });
    }
}
