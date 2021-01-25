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
        $posts = $this->getPostsWithDefaultTemplate();
        $this->info('count posts with default template: ' . count($posts));
        $this->processPosts($posts);

        $posts = $this->getPostsWithTypePost();
        $this->info('count pages with type post: ' . count($posts));
        $this->processPosts($posts);

        $posts = $this->getEmergencies();
        $this->info('count of emergencies:' . count($posts));
        $this->processPosts($posts);

        $posts = $this->getPostsWithoutAnyTemplate();
        $this->info('count posts without template: ' . count($posts));
        $this->processPosts($posts);
    }

    protected function isPostInThisGroup($posts, $postId)
    {
        foreach ($posts as $post) {
            if ($post->ID === $postId) return true;
        }

        return false;
    }

    protected function getEmergencies()
    {
        $posts = $this->wpConnection->table('wp_posts')
            ->where('wp_posts.post_type', 'emergencies')
            ->where('wp_posts.post_status', 'publish')
            ->get();

        return $posts;
    }

    protected function getPostsWithoutAnyTemplate()
    {
        $postsWithTemplate = $this->wpConnection->table('wp_posts')
            ->join('wp_postmeta', 'wp_posts.id', '=', 'wp_postmeta.post_id')
            ->where('wp_posts.post_type', 'page')
            ->where('wp_posts.post_status', 'publish')
            ->orderBy('wp_posts.ID', 'ASC')
            ->where(function ($query) {
                $query->where('wp_postmeta.meta_key', '_wp_page_template')
                    ->where('wp_postmeta.meta_value', '<>', '');
            })
            ->get();

        $allPosts = $this->wpConnection->table('wp_posts')
            ->where('wp_posts.post_type', 'page')
            ->where('wp_posts.post_status', 'publish')
            ->orderBy('wp_posts.ID', 'ASC')
            ->get();

        $postsWithTemplateIds = [];
        foreach ($postsWithTemplate as $item) {
            $postsWithTemplateIds[] = $item->ID;
        }

        $allPostsIds = [];
        foreach ($allPosts as $item) {
            $allPostsIds[] = $item->ID;
        }

        $postsWhithoutTemplate = array_diff($allPostsIds, $postsWithTemplateIds);
        
        $posts = $this->wpConnection->table('wp_posts')
            ->where('wp_posts.post_type', 'page')
            ->where('wp_posts.post_status', 'publish')
            ->whereIn('wp_posts.ID', $postsWhithoutTemplate)
            ->orderBy('wp_posts.ID', 'ASC')
            ->get();

        return $posts;    
    }

    protected function getPostsWithTypePost() 
    {
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

            return $posts;
    }

    protected function getPostsWithDefaultTemplate()
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

        return $posts;
    }

    protected function processPosts($posts)
    {
        foreach ($posts as $pageKey => $post) {

            $page = Page::where('wp_id', $post->ID)->first();

            $slug = '';

            if ($post->post_type === 'emergencies') $slug = 'emergencies/';
            $slug = $slug . $this->getSlug($post);

            $options = $this->wpConnection->table('wp_postmeta')
                ->where('post_id', $post->ID)
                ->get();

            if ($page) {

                $instance = $page->actual_page_instance;

                $instance->update([
                    'name' => $post->post_title,
                    'slug' => $slug,
                    'title' => $post->post_title,
                    'description' => '',
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
                    'slug' => $slug,
                    'title' => $post->post_title,
                    'description' => '',
                    'page_id' => $page->id,
                    'template' => Template::COMMON_CONTENT_PAGE,
                ]);

                $instance->actual = true;
                $instance->save();

                $infoString = $pageKey . ': Page created => id: ' . $page->id . ', wp_id: ' . $page->wp_id;
            }

            $this->updateTemplateParams($instance, $options, $post);

            $this->info($infoString);
            Log::channel('parser')->info($infoString);
        }
    }

    protected function updateTemplateParams($instance, $options, $post)
    {
        $img = $this->getOption($options, 'background');
        $instance->preview_img = $this->getWpImage($img);
        $instance->preview_text = $this->getOption($options, 'head_content');

        $content = $post->post_content;
        $content = $this->uploadImages($content);

        $parameters = [];
        $parameters['main_html'] = $content;
        $instance->parameters = $parameters;

        $instance->description = $this->getOption($options, '_yoast_wpseo_metadesc');

        $page = $instance->page;
        $page->published_at = $post->post_date;
        $page->save();

        $instance->save();
    }
}
