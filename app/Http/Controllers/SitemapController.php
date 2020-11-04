<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostContainer;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Builder;
/*
 *  
 *  https://packagist.org/packages/laravelium/sitemap
 *  Dynamic sitemap - https://github.com/Laravelium/laravel-sitemap/wiki/Dynamic-sitemap
 *
 */

class SitemapController extends Controller
{
    public function sitemap()
    {
        // create new sitemap object
	$sitemap = App::make('sitemap');

	// set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
	// by default cache is disabled
	$sitemap->setCache('laravel.sitemap', 60);

	// check if there is cached sitemap and build new only if is not
	if (!$sitemap->isCached()) {
		// add item to the sitemap (url, date, priority, freq)
		$sitemap->add(URL::to('/'), '2020-01-01T20:00:00+02:00', '1.0', 'daily');

        // add every post to the sitemap
        $posts = Post::where('actual', true)
                        ->whereHas('container', function(Builder $query) {
                            $query->where('status', PostContainer::POST_STATUS_PUBLICHED);   
                        })->get();

		foreach ($posts as $post) {
			$sitemap->add(URL::to('/' . $post->slug), $post->updated_at, '1.0', 'dayly');
		}
	}

	// show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
	return $sitemap->render('xml');
    }
}
