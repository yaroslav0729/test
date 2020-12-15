<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SeoChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan seo:check
     *
     * @var string
     */
    protected $signature = 'seo:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    const SITEMAPS = [
        'posts' => 'https://www.islamichelp.org.uk/post-sitemap.xml',
        'pages' => 'https://www.islamichelp.org.uk/page-sitemap.xml',
        'media-center' => 'https://www.islamichelp.org.uk/media-centre-sitemap.xml',
        'events' => 'https://www.islamichelp.org.uk/events-sitemap.xml',
        'ihelp' => 'https://www.islamichelp.org.uk/ihelp-give-sitemap.xml',
        'emergencies' => 'https://www.islamichelp.org.uk/emergencies-sitemap.xml',
        'categories' => 'https://www.islamichelp.org.uk/category-sitemap.xml',
        'media-categories' => 'https://www.islamichelp.org.uk/media-categories-sitemap.xml',
        'author' => 'https://www.islamichelp.org.uk/author-sitemap.xml',
    ];

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
        $this->info('Seo checker started');

        $allLinks = [];

        foreach (self::SITEMAPS as $sitemapKey => $sitemap) {
            $response = Http::get($sitemap);

            $links = $this->getLinksFromXml($response->body());

            foreach ($links as $linkKey => $link) {
                $link = $this->getSlugFromLink($link);
                $link = url($link);
                $links[$linkKey] = $link;
            }

            $allLinks[$sitemapKey] = $links;
        }

        $this->seoCheck($allLinks);

        $this->info('Seo checker complete');
    }

    protected function seoCheck($allLinks)
    {
        foreach ($allLinks as $sitemapName => $links) {

            $this->info('Sitemap ' . $sitemapName . ' --------------------------');

            foreach ($links as $linkKey => $link) {

                $response = Http::get($link);

                $info = '';

                if ($response->successful()) {
                    $info = $linkKey . ' Success: slug: ' . $link;
                } else if ($response->clientError()) {
                    $info = $linkKey . ' CLIENT ERROR: slug: ' . $link;
                } else {
                    $info = $linkKey . ' UNKNOWN ERROR: slug: ' . $link;
                }

                $this->info($info);
                Log::channel('seo_checker')->info($info);
            }
        }
    }

    protected function getSlugFromLink($link)
    {
        $domain = 'https://www.islamichelp.org.uk/';
        $slug = str_replace($domain, '', $link);

        $lastSym = substr($slug, strlen($slug) - 1, 1);

        if ($lastSym === '/') {
            $slug = substr($slug, 0, -1);
        }

        return $slug;
    }

    protected function getLinksFromXml($html)
    {
        $regexp = '#<loc>(.+?)</loc>#su';
        preg_match_all($regexp, $html, $links);
        $links = $links[1];

        return $links;
    }
}
