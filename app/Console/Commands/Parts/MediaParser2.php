<?php

namespace App\Console\Commands\Parts;

use App\Console\Commands\Parts\AbstractParser;
use App\Models\Page;
use App\Models\PageInstance;

class MediaParser2 extends AbstractParser
{
    const IMG_PATH = 'media-center';

    public function parse()
    {
        $this->info('Parsing process started');

        $posts = $this->getMediaCenterPosts();

        foreach ($posts as $post) {

            $localPost = $this->getLocalPost($post->post_name);

            $pages = [];

            if (count($localPost) > 1) {

                foreach ($localPost as $locItem) {
                    $pages[] = $locItem->page->id;
                }

                $pages = array_unique($pages);

                if (count($pages) > 1) {
                    $this->info('WARNING:----------------------------------------------------------------------');
                    $this->info('pages with same slug: ids [' . implode(', ', $pages) . ']');
                }
            }

            if (count($localPost) > 0) {

                $options = $this->wpConnection->table('wp_postmeta')
                    ->where('post_id', $post->ID)
                    ->get();

                $img = $this->getOption($options, 'background');

                foreach ($localPost as $instance) {

                    $foundImg = $this->getWpImage($img);

                    if (!empty($foundImg)) {
                        $instance->preview_img = $foundImg;
                        $instance->save();

                        $this->info('Preview image saved: id[' . $instance->id . '], wp_id[' . $post->ID . ']');
                    }
                    
                }
            }
        }

        $this->info('Parsing process complete!!!');
    }

    public function updateWpIdMediaCenter()
    {
        $this->info('Update WP id part');

        $posts = $this->getMediaCenterPosts();

        foreach ($posts as $post) {

            $localPost = $this->getLocalPost($post->post_name);

            $pages = [];

            if (count($localPost) > 1) {

                foreach ($localPost as $locItem) {
                    $pages[] = $locItem->page->id;
                }

                $pages = array_unique($pages);

                if (count($pages) > 1) {
                    $this->info('WARNING:----------------------------------------------------------------------');
                    $this->info('pages with same slug: ids [' . implode(', ', $pages) . ']');
                }
            }

            if (count($localPost) > 0) {
                foreach ($localPost as $instance) {
                    if (empty($instance->page->wp_id)) {
                        $instance->page->wp_id = $post->ID;
                        $instance->page->save();
                        $this->info('Page WP_id updated - instance: ' . $instance->id . ', wp_id: ' . $post->ID . ']');
                    }
                }
            }
        }

        $posts = $this->getMediaCenterPosts();
    }

    protected function replaceLastSlash($str)
    {
        $lastSym = substr($str, -1);

        if ($lastSym === '/') {
            $str = substr_replace($str, "", -1);
        }
        return $str;
    }

    public function disablePagesWith301Redirect()
    {
        $posts = $this->wpConnection->table('wp_redirects')
            ->get();

        foreach ($posts as $post) {

            $urlFrom = $this->replaceLastSlash($post->url_from);

            $localPage = PageInstance::where('slug', $urlFrom)->first();

            if ($localPage) {
                
                if ($localPage->page->status === Page::PAGE_STATUS_PUBLISHED) {

                    $this->info('Found local post needs to redirect - id: ' . $localPage->id . ', slug: ' . $localPage->slug);

                    $localPage->page->status = Page::PAGE_STATUS_NOT_PUBLISHED;
                    $localPage->page->save();
                }
            }
        }
            
        
    }

    protected function getLocalPost($postName)
    {
        $items = PageInstance::where('slug', 'media-centre/news/' . $postName)->get();

        return $items;
    }

    protected function getMediaCenterPosts()
    {
        $posts = $this->wpConnection->table('wp_posts')
            ->where('wp_posts.post_type', 'media-centre')
            ->where('wp_posts.post_status', 'publish')
            ->get();

        return $posts;
    }

}
