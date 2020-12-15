<?php

namespace App\Console\Commands\Parts;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;

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
                    $contents = file_get_contents($imageUrl);
                    Storage::disk('public')->put($path, $contents);

                } catch (Exception $e) {
                    $this->info('WARNING: file not found: ' . $imageUrl);
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
                        $contents = file_get_contents($imageUrl);
                        Storage::disk('public')->put($path, $contents);

                    } catch (Exception $e) {
                        $this->info('WARNING: file not found: ' . $imageUrl);
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

    protected function replaceImagesLinks($html, $images)
    {
        foreach ($images as $image) {
            $html = str_replace($image['remote_image'], $image['local_image'], $html);
        }

        return $html;
    }
}
