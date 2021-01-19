<?php

namespace App\Console\Commands;

use App\Helpers\StrHelper;
use App\Models\Redirect;
use DB;
use Illuminate\Console\Command;

class ParseRedirects extends Command
{
    protected $wpConnection;
    /**
     * The name and signature of the console command.
     *
     * php artisan parse_redirects
     *
     * @var string
     */
    protected $signature = 'parse_redirects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Command started');

        $this->wpConnection = DB::connection('wp');

        $redirects = $this->getWpRedirects();
        $this->setupLocalRedirects($redirects);

        $this->info('Complete successfully!');
    }

    protected function getWpRedirects()
    {
        $redirects = $this->wpConnection->table('wp_redirects')
            ->get();

        return $redirects;
    }

    protected function setupLocalRedirects($redirects)
    {
        foreach ($redirects as $redirect) {
            $locRedirect = Redirect::where('url_from', StrHelper::deleteTrailingSlash($redirect->url_from))->first();

            if (!$locRedirect) {
                $locRedirect = Redirect::create([
                    'url_from' => StrHelper::deleteTrailingSlash($redirect->url_from),
                    'url_to', $this->findPostSlug($redirect->url_to),
                    'type' => $redirect->status,
                ]);
            } else {
                $locRedirect->url_to = $this->findPostSlug($redirect->url_to);
                $locRedirect->type = $redirect->status;
                $locRedirect->save();
            }

            $this->info('Redirect found: ' . $locRedirect->url_from);
        }
    }

    protected function findPostSlug($url)
    {
        $wpId = (int) $url;

        if ($wpId === 0) {
            return $this->removeDomainFromUrl($url);
        } else {
            $url = $this->getFullSlug($url);
        }

        return $url;
    }

    protected function removeDomainFromUrl($url)
    {
        return str_replace('https://www.islamichelp.org.uk/', '', $url);
    }

    protected function getFullSlug($id)
    {
        $post = $this->wpConnection->table('wp_posts')
            ->where('wp_posts.ID', $id)
            ->first();

        if (!$post) {
            $this->info('WARNING: Post ID: ' . $id . ' not found in WP database');
            return '';
        }

        $seoSlug = null;

        if ($seoSlug !== null) {
            return $seoSlug;
        }

        $slug = $post->post_name;

        $lastParentPost = $post->post_parent;

        while ($lastParentPost !== 0) {
            $parPost = $this->wpConnection->table('wp_posts')
                ->where('wp_posts.ID', $lastParentPost)
                ->first();

            if (!empty($parPost)) {
                $lastParentPost = $parPost->post_parent;
                $slug = $parPost->post_name . '/' . $slug;
            } else {
                $lastParentPost = 0;
            }
        }

        return $slug;
    }
}
