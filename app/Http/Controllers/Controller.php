<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use voku\helper\HtmlDomParser;

use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const PARSING_LINK = 'https://www.islamichelp.org.uk/media-centre-sitemap.xml';

    public function test()
    {
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

            echo "link: <a href='$link' target='_blank'>$link</a><br>";
            echo "category: $category<br>";
            echo "slug: $slug<br>";
            echo "<br>";
            echo "title: $title<br>";
            echo "description: $description<br>";
            echo "<br>";
            echo "h1: $h1<br>";
            echo "h2: $h2<br>";
            echo "<br>";

            if ($key === 3) dd('stop');
        }

        dd($links);
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
