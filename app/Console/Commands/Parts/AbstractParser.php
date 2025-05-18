<?php

namespace App\Console\Commands\Parts;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;
use voku\helper\HtmlDomParser;

abstract class AbstractParser
{
    const IMG_PATH = 'path';

    protected $wpConnection;

    public function __construct($wpConnection)
    {
        $this->wpConnection = $wpConnection;
    }

    public function parse()
    {
    }

    public function info($str)
    {
        echo $str . PHP_EOL;
    }

    protected function searchMonthYear($imageUrl)
    {
        $month = '';
        $year = '';

        $pos = -1;

        $arr = explode('/', $imageUrl);

        foreach ($arr as $key => $item) {
            if ($item === 'uploads') {
                $pos = $key;
                break;
            }
        }

        if (isset($arr[$pos + 1])) {
            $year = $arr[$pos + 1];
        }

        if (isset($arr[$pos + 2])) {
            $month = $arr[$pos + 2];
        }

        return [$month, $year];
    }

    protected function getWpImage($wpImageId)
    {
        $img = $this->wpConnection->table('wp_postmeta')
            ->where('post_id', $wpImageId)
            ->where('meta_key', '_wp_attached_file')->first();

        $imageUrl = 'https://www.islamichelp.org.uk/wp-content/uploads/';

        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;

        if (isset($img)) {
            $imageUrl = $imageUrl . $img->meta_value;

            list($linkMonth, $linkYear) = $this->searchMonthYear($imageUrl);

            if (($linkMonth !== '') && ($linkYear !== '')) {
                $year = $linkYear;
                $month = $linkMonth;
            }

            $name = substr($imageUrl, strrpos($imageUrl, '/') + 1);
            $path = $this::IMG_PATH . '/' . $year . '/' . $month . '/' . $name;

            $exists = Storage::disk('public')->exists($path);

            if ((!$exists) && ($imageUrl !== "")) {
                try {
                    // Validate URL is from our trusted domain
                    if (!filter_var($imageUrl, FILTER_VALIDATE_URL) || 
                        !preg_match('/^https:\/\/www\.islamichelp\.org\.uk\//', $imageUrl)) {
                        throw new Exception('Invalid image URL');
                    }
                    
                    // Set a timeout for the request
                    $context = stream_context_create([
                        'http' => [
                            'timeout' => 5,
                            'header' => [
                                'User-Agent: IslamicHelp/1.0'
                            ]
                        ]
                    ]);
                    
                    $contents = file_get_contents($imageUrl, false, $context);
                    if ($contents === false) {
                        throw new Exception('Failed to download image');
                    }
                    
                    // Validate the content is actually an image
                    if (!getimagesizefromstring($contents)) {
                        throw new Exception('Invalid image content');
                    }
                    
                    Storage::disk('public')->put($path, $contents);
                } catch (Exception $e) {
                    $this->info('WARNING: file not found: ' . $imageUrl . ' - ' . $e->getMessage());
                }
            }

            return Storage::url($path);
        }

        return "";
    }

    protected function getOption($options, $optName)
    {
        foreach ($options as $option) {
            if ($option->meta_key === $optName) {
                return $option->meta_value;
            }
        }

        return "";
    }

    protected function getSlug($post)
    {
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

    private function findAllImages($el)
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
                $srcsets[] = $image->getAttribute('src');
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

    protected function uploadImages($content)
    {
        $document = new HtmlDomParser($content);

        $images = $this->findAllImages($document);
        $this->info('====== Page Images ======');
        foreach ($images as $image) {
            $this->info($image);
        }
        $this->info('====== END ======');
        $images = $this->uploadAll($images);
        $content = $this->replaceImagesLinks($content, $images);

        return $content;
    }

    private function uploadAll($images)
    {
        $imagesLinks = [];

        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;

        if ($images !== []) {
            foreach ($images as $imageUrl) {
                list($linkMonth, $linkYear) = $this->searchMonthYear($imageUrl);

                if (($linkMonth !== '') && ($linkYear !== '')) {
                    $year = $linkYear;
                    $month = $linkMonth;
                }

                $name = substr($imageUrl, strrpos($imageUrl, '/') + 1);
                $path = $this::IMG_PATH . '/' . $year . '/' . $month . '/' . $name;

                $exists = Storage::disk('public')->exists($path);

                if ((!$exists) && ($imageUrl !== "")) {
                    try {
                        // Validate URL is from our trusted domain
                        if (!filter_var($imageUrl, FILTER_VALIDATE_URL) || 
                            !preg_match('/^https:\/\/www\.islamichelp\.org\.uk\//', $imageUrl)) {
                            throw new Exception('Invalid image URL');
                        }
                        
                        // Set a timeout for the request
                        $context = stream_context_create([
                            'http' => [
                                'timeout' => 5,
                                'header' => [
                                    'User-Agent: IslamicHelp/1.0'
                                ]
                            ]
                        ]);
                        
                        $contents = file_get_contents($imageUrl, false, $context);
                        if ($contents === false) {
                            throw new Exception('Failed to download image');
                        }
                        
                        // Validate the content is actually an image
                        if (!getimagesizefromstring($contents)) {
                            throw new Exception('Invalid image content');
                        }
                        
                        Storage::disk('public')->put($path, $contents);
                    } catch (Exception $e) {
                        $this->info('WARNING: file not found: ' . $imageUrl . ' - ' . $e->getMessage());
                    }
                }

                if ($imageUrl !== "") {
                    $imagesLinks[] = [
                        'remote_image' => $imageUrl,
                        'local_image' => Storage::url($path),
                    ];
                }
            }
        }

        return $imagesLinks;
    }

    private function replaceImagesLinks($html, $images)
    {
        foreach ($images as $image) {
            $html = str_replace($image['remote_image'], $image['local_image'], $html);
        }

        return $html;
    }

    protected function removeArtifacts($content)
    {
        $str = str_replace('вЂ', '', $content);

        return $str;
    }

    protected function getImageByUrl($url)
    {
        list($linkMonth, $linkYear) = $this->searchMonthYear(($url));
        if (($linkMonth !== '') && ($linkYear !== '')) {
            $year = $linkYear;
            $month = $linkMonth;
        }
        $name = substr($url, strrpos($url, '/') + 1);
        $path = $this::IMG_PATH . '/' . $year . '/' . $month . '/' . $name;

        $exists = Storage::disk('public')->exists($path);
        if ((!$exists) && ($url !== "")) {
            try {
                // Validate URL is from our trusted domain
                if (!filter_var($url, FILTER_VALIDATE_URL) || 
                    !preg_match('/^https:\/\/www\.islamichelp\.org\.uk\//', $url)) {
                    throw new Exception('Invalid image URL');
                }
                
                // Set a timeout for the request
                $context = stream_context_create([
                    'http' => [
                        'timeout' => 5,
                        'header' => [
                            'User-Agent: IslamicHelp/1.0'
                        ]
                    ]
                ]);
                
                $contents = file_get_contents($url, false, $context);
                if ($contents === false) {
                    throw new Exception('Failed to download image');
                }
                
                // Validate the content is actually an image
                if (!getimagesizefromstring($contents)) {
                    throw new Exception('Invalid image content');
                }
                
                Storage::disk('public')->put($path, $contents);
            } catch (Exception $e) {
                $this->info('WARNING: file not found: ' . $url . ' - ' . $e->getMessage());
            }
        }

        return $path;
    }
}
