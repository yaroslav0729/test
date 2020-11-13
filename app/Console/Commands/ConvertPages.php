<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Page;
use App\Models\PageInstance; // https://github.com/voku/simple_html_dom
use App\Models\Template;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use voku\helper\HtmlDomParser;

class ConvertPages extends Command
{
    const PARSING_LINK = 'https://www.islamichelp.org.uk/media-centre-sitemap.xml';
    const MEDIA_CENTER_IMAGE_STORAGE_PATH = 'media-center';

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
        $links = $this->getLinksFromXml($response->body());

        foreach ($links as $key => $link) {

            if ($key === 0) {
                continue;
            }

            $html = Http::get($link)->body();
            $document = new HtmlDomParser($html);

            $category = $this->getCategoryFromLink($link);
            $slug = $this->getSlugFromLink($link);
            $title = $this->searchTitle($html);
            $description = $this->searchDescription($html);
            $keywords = $this->searchKeywords($html);
            $h1 = $document->findOneOrFalse('h1')->text();
            $h2 = $document->findOneOrFalse('h2.title_post')->text();
            $date = $document->findOneOrFalse('div.date')->text();
            $date = $this->toNeedfulFormat($date);

            $this->removeElementFromDoc('h2.title_post', $document);
            $this->removeElementFromDoc('div.date', $document);
            $this->removeElementFromDoc('div.archive-news-sidebar', $document);

            $newsBlock = $document->findOneOrFalse('div#tpl-single-news');
            $newsHtml = $newsBlock->html();

            $images = $this->findAllImages($newsBlock);
            $images = $this->uploadAll($images);
            $newsHtml = $this->replaceImagesLinks($newsHtml, $images);

            //~~~ replace all images in srcset attribute ~~~
            $images = $this->findAllImagesSrcset($newsBlock);
            $images = $this->uploadAll($images);
            $newsHtml = $this->replaceImagesLinks($newsHtml, $images);

            $category = Category::firstOrCreate([
                'slug' => $category,
                'name' => $category,
            ]);

            $parameters = [];
            $parameters['main_html'] = $newsHtml;

            $pageInstance = PageInstance::where('slug', $slug)->where('actual', true)->first();

            if (!isset($pageInstance)) {
                $page = Page::create([
                    'status' => Page::PAGE_STATUS_PUBLICHED,
                    'published_at' => $date,
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
                    'html' => $link, // save old link
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
                    'html' => $link, // save old link
                ]);

                $page = $pageInstance->page;
                $page->published_at = $date;
                $page->save();

                $this->info('Page updated: slug ' . $pageInstance->slug);
            }

            if ($key === 3) {
                break;
            }

        }

        $this->info('Parsing process complete!!!');
    }

    protected function toNeedfulFormat($date)
    {
        $date = str_replace('th', '', $date);
        $date = str_replace(',', '', $date);
        $date = Carbon::createFromTimestamp(strtotime($date));

        return $date;
    }

    protected function removeElementFromDoc($element, $document)
    {
        foreach ($document->find($element) as $tag) {
            $tag->outertext = '';
        }
    }

    protected function getCategoryFromLink($link)
    {
        $arr = explode('/', $link);
        $category = $arr[count($arr) - 3];

        return $category;
    }

    protected function getSlugFromLink($link)
    {
        $arr = explode('/', $link);
        $slug = $arr[count($arr) - 2];

        return $slug;
    }

    protected function getLinksFromXml($html)
    {
        $regexp = '#<loc>(.+?)</loc>#su';
        preg_match_all($regexp, $html, $links);
        $links = $links[1];

        return $links;
    }

    protected function searchTitle($html)
    {
        preg_match_all('#<title>(.+?)</title>#su', $html, $res);

        if (isset($res[1][0])) {
            return $res[1][0];
        } else {
            return "";
        }
    }

    protected function searchDescription($html)
    {
        preg_match_all('#<meta property="og:description" content="(.+?)/>#su', $html, $res);

        if (isset($res[1][0])) {
            return $res[1][0];
        } else {
            return "";
        }
    }

    protected function searchKeywords($html)
    {
        preg_match_all('#<meta name="keywords" content="(.+?)/>#su', $html, $res);

        if (isset($res[1][0])) {
            return $res[1][0];
        } else {
            return "";
        }
    }

    protected function findAllImages($el)
    {
        $images = [];
        $imagesOrFalse = $el->findMultiOrFalse('img');

        if ($imagesOrFalse !== false) {
            foreach ($imagesOrFalse as $image) {
                $images[] = $image->getAttribute('src');
            }
        }

        return $images;
    }

    protected function findAllImagesSrcset($el)
    {
        $images = [];
        $srcsets = [];

        $imagesOrFalse = $el->findMultiOrFalse('img');

        if ($imagesOrFalse !== false) {
            foreach ($imagesOrFalse as $image) {
                $srcsets[] = $image->getAttribute('srcset');
            }
        }

        foreach ($srcsets as $key => $srcset) {
            $links = explode(', ', $srcset);

            foreach ($links as $linkKey => $link) {
                $arr = explode(' ', $link);

                if (isset($arr[0])) {
                    $images[] = $arr[0];
                }
            }
        }

        return $images;
    }

    protected function uploadAll($images)
    {
        $imagesLinks = [];

        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;

        if ($images !== []) {
            foreach ($images as $imageUrl) {
                $contents = file_get_contents($imageUrl);
                $name = substr($imageUrl, strrpos($imageUrl, '/') + 1);
                $path = self::MEDIA_CENTER_IMAGE_STORAGE_PATH . '/' . $year . '/' . $month . '/' . $name;
                Storage::disk('public')->put($path, $contents);

                $imagesLinks[] = [
                    'remote_image' => $imageUrl,
                    'local_image' => Storage::url($path),
                ];
            }
        }

        return $imagesLinks;
    }

    protected function replaceImagesLinks($html, $images)
    {
        foreach ($images as $image) {
            $html = str_replace($image['remote_image'], $image['local_image'], $html);
        }

        return $html;
    }
}
