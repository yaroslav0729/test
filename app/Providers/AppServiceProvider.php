<?php

namespace App\Providers;

use App\Helpers\MenuHelper;
use App\Models\MenuItem;
use App\Models\PageInstance;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\CartItem;
use App\Services\Menu;
use Illuminate\Support\Facades\View;

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

        View::share([
            'headerMenuItem' => MenuHelper::groupByLevels(
                MenuItem::rootMenuByDestination(MenuItem::HEADER_MENU)
                    ->with('orderedSubMenus.orderedSubMenus')->get(), 
                3
            ),
            'additionalHeaderMenuItem' => MenuItem::rootMenuByDestination(MenuItem::ADDITIONAL_HEADER_MENU)->get(),
            'additionalFooterMenuItem' => MenuItem::rootMenuByDestination(MenuItem::ADDITIONAL_FOOTER_MENU)->get(),
            'footerMenuItem' => MenuItem::rootMenuByDestination(MenuItem::FOOTER_MENU)->with('orderedSubMenus')->get(),
            'socialMenu' => MenuItem::rootMenuByDestination(MenuItem::SOCIAL_MENU)->get(),
            'socialMenuIcons' => resolve(Menu::class)->getSocialIcons()
        ]);
    }
}
