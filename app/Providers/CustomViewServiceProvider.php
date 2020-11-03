<?php

namespace App\Providers;

use Illuminate\View\FileViewFinder;
use Illuminate\View\ViewServiceProvider;
use Jenssegers\Agent\Agent;

class CustomViewServiceProvider extends  ViewServiceProvider
{
    public function registerViewFinder()
    {
        $this->app->bind('view.finder', function ($app) {

            $agent = new Agent();

            $views = $app['config']['view.paths'];
            if ($agent->isMobile()) {
                array_unshift($views, resource_path('views/mobile'));
            }

            return new FileViewFinder($app['files'], $views);
        });
    }
}