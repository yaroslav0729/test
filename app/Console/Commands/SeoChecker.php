<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DB;
use App\Models\Page;

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

    protected $allLinks;
    protected $allCou;
    protected $errorItems;

    protected $wpConnection;

    const SITEMAPS = [
        'posts' => 'https://www.islamichelp.org.uk/post-sitemap.xml',
        'pages' => 'https://www.islamichelp.org.uk/page-sitemap.xml',
        // 'media-center' => 'https://www.islamichelp.org.uk/media-centre-sitemap.xml',
        // 'events' => 'https://www.islamichelp.org.uk/events-sitemap.xml',
        // 'ihelp' => 'https://www.islamichelp.org.uk/ihelp-give-sitemap.xml',
        // 'emergencies' => 'https://www.islamichelp.org.uk/emergencies-sitemap.xml',
        // 'categories' => 'https://www.islamichelp.org.uk/category-sitemap.xml',
        // 'media-categories' => 'https://www.islamichelp.org.uk/media-categories-sitemap.xml',
        // 'author' => 'https://www.islamichelp.org.uk/author-sitemap.xml',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->wpConnection = DB::connection('wp');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Seo checker started');

        $this->allLinks = [];
        $this->allCou = 0;

        $this->errorItems = [];

        foreach (self::SITEMAPS as $sitemapKey => $sitemap) {
            $response = Http::get($sitemap);

            $links = $this->getLinksFromXml($response->body());

            foreach ($links as $linkKey => $link) {
                $slug = $this->getSlugFromLink($link);
                $localUrl = url($slug);
                $links[$linkKey] = [
                    'link' => $link,
                    'slug' => $slug,
                    'local_url' => $localUrl,
                ];
                $this->allCou++;
            }

            $this->allLinks[$sitemapKey] = $links;
        }

        $this->seoCheck();

        dump($this->errorItems);

        $this->report();

        $this->info('Seo checker complete');  
    }

    protected function seoCheck()
    {
        $linkKey = 1;

        foreach ($this->allLinks as $sitemapName => $links) {

            $this->info('Sitemap ' . $sitemapName . ' --------------------------');

            foreach ($links as $link) {

                $response = Http::get($link['local_url']);

                $info = '';

                if ($response->successful()) {
                    $info = $linkKey . ' from ' . $this->allCou . ' -> Success: slug: ' . $link['local_url'];
                } else if ($response->clientError()) {
                    $info = $linkKey . ' from ' . $this->allCou . ' -> CLIENT ERROR: slug: ' . $link['local_url'];
                    $this->getLinkErrorData($link);
                
                } else {
                    $info = $linkKey . ' from ' . $this->allCou . ' -> UNKNOWN ERROR: slug: ' . $link['local_url'];
                }

                $linkKey++;

                $this->info($info);
                Log::channel('seo_checker')->info($info);
            }
        }
    }

    protected function report()
    {
        $wpIdFound = 0;
        $idFound = 0;

        $idsExists = [];

        foreach ($this->errorItems as $item) {
            if (!empty($item['id'])) {
                $idFound++;
                $idsExists[] = $item;
            }
            if (!empty($item['wp_id'])) $wpIdFound++;
        }

        $info = 'Items: ' . count($this->errorItems) . ', wp_ids: ' . $wpIdFound . ', ids: ' . $idFound;
        
        dump($idsExists);

        $this->info($info);
        Log::channel('seo_checker')->info($info);
    }

    protected function getLinkErrorData($link)
    {
        $postName = $this->getPostName($link['slug']);
        $wpId = null;
        $id = null;
        
        if (!empty($postName)) {
            $post = $this->wpConnection->table('wp_posts')
                ->where('wp_posts.post_name', $postName)
                ->first();

            if (!empty($post)) {

                $wpId = $post->ID;

                $localPost = Page::where('wp_id', $wpId)->first();
                
                if (!empty($localPost)) {
                    $id = $localPost->id;    
                }
            }
        }

        $this->errorItems[] = [
            'link' => $link['link'],
            'wp_id' => $wpId,
            'id' => $id
        ];

        //$info = 'Error data -> post id: ' . $id . ', wp_id: ' . $wpId;
        //$this->info($info);
        //Log::channel('seo_checker')->info($info);
    }

    protected function getPostName($link)
    {
        $arr = explode('/', $link);
        $len = count($arr);

        if ($len > 0) return $arr[$len - 1];
        else return null;
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
