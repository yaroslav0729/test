<?php

namespace App\Console\Commands\Parts;

use App\Console\Commands\Parts\AbstractParser;
use App\Models\Page;
use App\Models\PageInstance;
use App\Models\Template;
use Illuminate\Support\Facades\Log;

/*
 *
 * php artisan parse:all_pages --parser=blog
 *
 */

class BlogParser extends AbstractParser
{
    const IMG_PATH = 'blog';

    public function parse()
    {
        $this->info('Parsing process started');

        $posts = $this->getBlogPosts();
        $this->info('count pages with type post: ' . count($posts));
        $this->processPosts($posts);

        $this->info('Parsing process complete!!!');
    }

    protected function processPosts($posts)
    {
        foreach ($posts as $pageKey => $post) {

            $page = Page::where('wp_id', $post->ID)->first();

            $slug = $this->getSlug($post);

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
                    'template' => Template::BLOG_PAGE,
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
                    'template' => Template::BLOG_PAGE,
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
        $content = $post->post_content;
        $content = $this->uploadImages($content);

        $parameters = [];

        $content = '<p>' . $content . '</p>';
        $content = $this->replaceWPTags($content);
        
        $parameters['article_html'] = $content;

        $parameters['min_read'] = $this->getOption($options, 'min_read');
        $parameters['written_by'] = 'KAMRAN AHMED';
        $parameters['hdr_video'] = $this->getOption($options, 'youtube_video_id');
        $parameters['hdr_text'] = $this->getOption($options, 'short_header_details');

        $instance->parameters = $parameters;

        $instance->description = $this->getOption($options, '_yoast_wpseo_metadesc');

        $page = $instance->page;
        $page->published_at = $post->post_date;
        $page->save();

        $instance->save();
    }

    protected function replaceWPTags($content)
    {
        $content = str_replace("&nbsp;\r\n", '</p><p>', $content); // close prev & open new paragraph
        
        return $content;
    }

    protected function getBlogPosts()
    {
        $posts = $this->wpConnection->table('wp_posts')
            ->join('wp_postmeta', 'wp_posts.id', '=', 'wp_postmeta.post_id')
            ->where('wp_posts.post_type', 'page')
            ->where('wp_posts.post_status', 'publish')
            ->orderBy('wp_posts.ID', 'ASC')
            ->where(function ($query) {
                $query->where('wp_postmeta.meta_key', '_wp_page_template');
                $query->where('wp_postmeta.meta_value', 'template/blog.php');
            })
            ->get();

        return $posts;
    }
}
