<?php

namespace App\Console\Commands\Parts;

use App\Console\Commands\Parts\AbstractParser;
use App\Models\Category;
use App\Models\Page; // https://github.com/voku/simple_html_dom
use App\Models\PageInstance;
use App\Models\Template;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use voku\helper\HtmlDomParser;

class MediaParser extends AbstractParser
{
    const PARSING_LINK = 'https://www.islamichelp.org.uk/media-centre-sitemap.xml';
    const IMG_PATH = 'media-center';

    public function __construct()
    {

    }

    public function parse()
    {
        $this->info('Parsing process started');

        $response = Http::get(self::PARSING_LINK);
        $links = $this->getLinksFromXml($response->body());

        $allCou = count($links);

        foreach ($links as $key => $link) {

            if ($key === 0) {
                continue;
            }

            $this->info('parsing link ' . $key . ' from ' . $allCou);

            $html = Http::get($link)->body();
            $document = new HtmlDomParser($html);

            $category = $this->getCategoryFromLink($link);
            $slug = $this->getSlugFromLink($link);

            $title = $this->searchTitle($html);
            $description = $this->searchDescription($html);
            $keywords = $this->searchKeywords($html);

            $h1 = "";
            $h2 = "";
            $date = "";

            $el = $document->findOneOrFalse('h1');

            if ($el) {
                $h1 = $el->text();
            }

            $el = $document->findOneOrFalse('h2.title_post');

            if ($el) {
                $h2 = $el->text();
            }

            $el = $document->findOneOrFalse('div.date');

            if ($el) {
                $date = $el->text();
            }

            $date = $this->toNeedfulFormat($date);

            $this->removeElementFromDoc('h2.title_post', $document);
            $this->removeElementFromDoc('div.date', $document);
            $this->removeElementFromDoc('div.archive-news-sidebar', $document);

            $this->removeDomainFromLinks($document);

            $newsBlock = $document->findOneOrFalse('div#tpl-single-news');

            $newsHtml = "";

            if ($newsBlock) {
                $newsHtml = $newsBlock->html();

                $newsHtml = $this->uploadImages($newsHtml);
            }

            $category = Category::firstOrCreate([
                'slug' => $category,
                'name' => $category,
            ]);

            $parameters = [];
            $parameters['main_html'] = $newsHtml;

            $pageInstance = PageInstance::where('slug', $slug)->where('actual', true)->first();

            if (!isset($pageInstance)) {
                $page = Page::create([
                    'status' => Page::PAGE_STATUS_PUBLISHED,
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
                    'template' => Template::COMMON_CONTENT_PAGE,
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
                    'template' => Template::COMMON_CONTENT_PAGE,
                    'parameters' => $parameters,
                    'html' => $link, // save old link
                ]);

                $page = $pageInstance->page;
                $page->published_at = $date;
                $page->save();

                $this->info('Page updated: slug ' . $pageInstance->slug);
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

    protected function removeDomainFromLinks($document)
    {
        $domain = "https://www.islamichelp.org.uk";
        $links = $document->findMulti('a');

        foreach ($links as $link) {
            $href = $link->href;

            if (strpos($href, $domain) !== false) {
                $href = str_replace($domain, '', $href);
                $link->href = $href;
            }
        }
    }

    protected function getSlugFromLink($link)
    {
        $domain = 'https://www.islamichelp.org.uk' . '/';
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
}
