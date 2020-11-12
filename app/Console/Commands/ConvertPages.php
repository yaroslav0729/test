<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

use voku\helper\HtmlDomParser;
use App\Models\Category;
use App\Models\Page;
use App\Models\PageInstance;
use App\Models\Template;

class ConvertPages extends Command
{
    const PARSING_LINK = 'https://www.islamichelp.org.uk/media-centre-sitemap.xml';

    /**
     * The name and signature of the console command.
     *
     * 
     * php artisan convert:media-center
     * 
     * @var string
     */
    protected $signature = 'convert:media-center';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pages parser';

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
        $this->info('Parsing process started');

        $response = Http::get(self::PARSING_LINK);
        $regexp = '#<loc>(.+?)</loc>#su';
        preg_match_all($regexp, $response->body(), $links);
        $links = $links[1];

        foreach ($links as $key => $link) {

            if ($key === 0) continue;

            $arr = explode('/', $link);
            $category = $arr[count($arr) - 3];
            $slug = $arr[count($arr) - 2];
            $html = Http::get($link)->body();

            $document = new HtmlDomParser($html);

            $title = $this->searchTitle($html);
            $description = $this->searchDescription($html);
            $keywords = $this->searchKeywords($html);

            $h1 = $document->findOneOrFalse('h1')->text();
            $h2 = $document->findOneOrFalse('h2.title_post')->text();
            $date = $document->findOneOrFalse('div.date')->text();
            
            foreach ($document->find('h2.title_post') as $tag) {
                $tag->outertext = '';
            }

            foreach ($document->find('div.date') as $tag) {
                $tag->outertext = '';
            }

            foreach ($document->find('div.archive-news-sidebar') as $tag) {
                $tag->outertext = '';
            }

            $newsHtml = $document->findOneOrFalse('div#tpl-single-news')->html();

            $category = Category::firstOrCreate([
                'slug' => $category,
                'name' => $category
            ]);

            $parameters = [];
            $parameters['main_html'] = $newsHtml;

            $pageInstance = PageInstance::where('slug', $slug)->where('actual', true)->first();
            
            if (!isset($pageInstance)) {
                $page = Page::create([
                    'status' => Page::PAGE_STATUS_PUBLICHED
                ]);
                $pageInstance = PageInstance::create([
                    'page_id' => $page->id,
                    'slug' => $slug,
                    'title' => $title,
                    'name' => $h1,
                    'preview_text' => $h2,
                    'description' => $description,
                    'keywords' => $keywords,
                    'template' => Template::MEDIA_CENTER_PAGE,
                    'parameters' => $parameters,
                ]);

                $pageInstance->actual = true;
                $pageInstance->save();

                $this->info('New page created: slug ' . $pageInstance->slug);

            } else {
                $pageInstance->update([
                    'title' => $title,
                    'name' => $h1,
                    'preview_text' => $h2,
                    'description' => $description,
                    'keywords' => $keywords,
                    'template' => Template::MEDIA_CENTER_PAGE,
                    'parameters' => $parameters,
                ]);

                $this->info('Page updated: slug ' . $pageInstance->slug);
            }

            if ($key === 3) break;
        }

        $this->info('Parsing process complete!!!');
    }

    protected function searchTitle($html)
    {
        preg_match_all('#<title>(.+?)</title>#su', $html, $res);

        if (isset($res[1][0])) return $res[1][0];
        else return "";
    }

    protected function searchDescription($html)
    {
        preg_match_all('#<meta property="og:description" content="(.+?)/>#su', $html, $res);

        if (isset($res[1][0])) return $res[1][0];
        else return "";    
    }

    protected function searchKeywords($html)
    {
        preg_match_all('#<meta name="keywords" content="(.+?)/>#su', $html, $res);

        if (isset($res[1][0])) return $res[1][0];
        else return "";  
    }

    protected function findAllImages($document)
    {
        $images = [];
        $imagesOrFalse = $document->findMultiOrFalse('img');

        if ($imagesOrFalse !== false) {
            foreach ($imagesOrFalse as $image) {
                $images[] = $image->getAttribute('src');
            }
        }

        return $images;
    }
}
