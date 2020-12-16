<?php

namespace App\Console\Commands\Parts;

use App\Console\Commands\Parts\AbstractParser;
use App\Models\Page;
use App\Models\PageInstance;
use App\Models\Template;
use Illuminate\Support\Facades\Log;

class DefaultTemplateParser extends AbstractParser
{
    const IMG_PATH = 'pages';

    public function parse()
    {
        $posts = $this->wpConnection->table('wp_posts')
            ->join('wp_postmeta', 'wp_posts.id', '=', 'wp_postmeta.post_id')
            ->where('wp_posts.post_type', 'page')
            ->where('wp_posts.post_status', 'publish')
            ->orderBy('wp_posts.ID', 'ASC')
            ->where(function ($query) {
                $query->where('wp_postmeta.meta_value', 'default');
            })
            ->get();

        $this->info('count posts:' . count($posts));
        $this->processPosts($posts);

        $posts = $this->wpConnection->table('wp_posts')
            ->join('wp_postmeta', 'wp_posts.id', '=', 'wp_postmeta.post_id')
            ->where('wp_posts.post_type', 'post')
            ->where('wp_posts.post_status', 'publish')
            ->orderBy('wp_posts.ID', 'ASC')
            ->where(function ($query) {
                $query->where('wp_postmeta.meta_key', '_wp_page_template');
                $query->where('wp_postmeta.meta_value', 'default');
            })
            ->get();


        $this->info('count posts:' . count($posts));
        $this->processPosts($posts);
    }

    protected function processPosts($posts)
    {
        foreach ($posts as $pageKey => $post) {

            $page = Page::where('wp_id', $post->ID)->first();

            if ($page) {

                $instance = $page->actual_page_instance;

                $instance->update([
                    'name' => $post->post_title,
                    'slug' => $post->post_name,
                    'title' => $post->post_title,
                    'description' => 'parsed project page wp_id: ' . $post->ID,
                    'template' => Template::COMMON_CONTENT_PAGE,
                ]);

                $infoString = $pageKey . ': Page updated => id: ' . $page->id . ', wp_id: ' . $page->wp_id;

            } else {

                $page = Page::create([
                    'wp_id' => $post->ID,
                    'status' => Page::PAGE_STATUS_PUBLISHED,
                ]);

                $instance = PageInstance::create([
                    'name' => $post->post_title,
                    'slug' => $post->post_name,
                    'title' => $post->post_title,
                    'description' => '',
                    'page_id' => $page->id,
                    'template' => Template::COMMON_CONTENT_PAGE,
                ]);

                $instance->actual = true;
                $instance->save();

                $infoString = $pageKey . ': Page created => id: ' . $page->id . ', wp_id: ' . $page->wp_id;
            }

            $content = $post->post_content;
            $content = $this->uploadImages($content);

            $parameters = [];
            $parameters['main_html'] = $content;
            $instance->parameters = $parameters;
            $instance->save();

            $this->info($infoString);
            Log::channel('parser')->info($infoString);
        }
    }
}
