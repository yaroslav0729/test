<?php

namespace App\Console\Commands\Parts;

use Exception;
use App\Console\Commands\Parts\AbstractParser;
use App\Helpers\StrHelper;
use App\Models\Page;
use App\Models\PageInstance;
use App\Models\Template;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use voku\helper\HtmlDomParser;

/*
 *
 * php artisan parse:all_pages --parser=homepage
 *
 */

class HomepageParser extends AbstractParser
{
    const IMG_PATH = 'homepage';

    public function parse()
    {
        $this->info('Parsing process started');

        $homepage = $this->getHomepage();
        $pageArray = json_decode(json_encode($homepage));

        foreach ($pageArray as $key => $value) {
            $this->info($key . ': ' . $value);
        }

        $this->processPage($homepage);

        $this->info('Parsing process complete');
    }

    protected function processPage($post)
    {
        $page = Page::where('wp_id', $post->ID)->first();
        $slug = $this->getSlug($post);
        $options = $this->wpConnection->table('wp_postmeta')
            ->where('post_id', $post->ID)
            ->get();

        if ($page) {
            $page->update(['type' => Page::TYPE_INDEX_PAGE]);
            $instance = $page->actual_page_instance;
            $instance->update([
                'name' => $post->post_title,
                'slug' => $slug,
                'title' => $post->post_title,
                'description' => '',
                'template' => Template::INDEX_PAGE,
            ]);

            $infoString = 'Homepage updated => ID: ' . $page->id . ', wp_id: ' . $page->wp_id;
        } else {
            $page = Page::create([
                'wp_id' => $post->ID,
                'status' => Page::PAGE_STATUS_PUBLISHED,
                'type' => Page::TYPE_INDEX_PAGE,
            ]);

            $instance = PageInstance::create([
                'name' => $post->post_title,
                'slug' => $slug,
                'title' => $post->post_title,
                'description' => '',
                'page_id' => $page->id,
                'template' => Template::INDEX_PAGE,
            ]);

            $instance->actual = true;
            $instance->save();

            $infoString = 'Homepage created => ID: ' . $page->id . ', wp_id: ' . $page->wp_id;
        }

        $this->updateTemplateParams($instance, $options, $post);
        $this->info($infoString);
    }

    protected function updateTemplateParams($instance, $options, $post)
    {
        $parameters = $instance->parameters;
        $content = '';

        $instance->update($this->parseHead($post, $options));

        $html = Http::get($post->guid)->body();
        $html = StrHelper::replaceSpecChars($html);
        $document = new HtmlDomParser($html);

        $homepageSlider = $document->findOne('div.slider_homepage');
        $this->parseHeaderSlider($homepageSlider, $parameters);
        $this->parseWhoWeAreBlock($document, $parameters);
        $this->parseOurWorkBlock($document, $parameters);
        $this->parseCurrentProjectsBlock($document, $parameters);
        $this->getWhatsNewImages($document);

        $instance->update(['parameters' => $parameters]);
        $this->info('Template parameters are set');
    }

    protected function parseHead($post, $options)
    {
        $head = [];
        $head['name'] = $post->post_title;
        $head['slug'] = 'index';
        $head['title'] = $this->getOption($options, '_yoast_wpseo_title');
        $head['preview_text'] = $this->getOption($options, '_yoast_wpseo_metadesc');
        $head['description'] = $this->getOption($options, '_yoast_wpseo_metadesc');

        return $head;
    }

    protected function getHomepage()
    {
        $wpOption = $this->wpConnection->table('wp_options')->where('option_name', 'page_on_front')->first();
        $homepage = $this->wpConnection->table('wp_posts')
            ->join('wp_postmeta', 'wp_posts.id', '=', 'wp_postmeta.post_id')
            ->where('wp_posts.id', $wpOption->option_value)
            ->where('wp_postmeta.meta_key', '_wp_page_template')->first();

        return $homepage;
    }

    protected function parseHeaderSlider($slider, &$parameters)
    {
        $slides = $slider->findMulti('.item');
        foreach ($slides as $index => $slide) {
            $parameters['hdr_color_type'] =
                strpos($slide->getAttribute('class'), 'danger') !== false ? 'red' : 'blue';
            $parameters['hdr_link_text_' . ($index + 1)] = $slide->findOne('.learn')->text();
            $parameters['hdr_learn_more_link_' . ($index + 1)] = $this->getRelativePath($slide->findOne('.learn')->getAttribute('href'));
            $parameters['hdr_type_active_' . ($index + 1)] = ($index + 1);
            $parameters['hdr_title_' . ($index + 1)] = str_replace('<br>', '', $slide->findOne('p')->innerHtml());
            $parameters['hdr_text_' . ($index + 1)] = $slide->findOne('font')->text();
            $parameters['hdr_bg_image_' . ($index + 1)] = $this->getSlideImage($slide);
            $parameters['hdr_donate_link_' . ($index + 1)] = $this->getRelativePath($slide->findOne('#donate_now')->getAttribute('href'));
            $parameters['hdr_tag_' . ($index + 1)] = $slide->findOne('tag')->text();
        }
    }

    protected function getSlideImage($slide)
    {
        $bgStyles = $slide->findOne('.bg-image div')->getAttribute('style');
        $urlRegex = '#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#';
        preg_match_all($urlRegex, $bgStyles, $match);
        $urlMatch = $match[0][0];

        $path = $this->getImageByUrl($urlMatch);

        return Storage::url($path);
    }

    protected function parseWhoWeAreBlock($document, &$parameters)
    {
        $this->info('Start parsing "Who we are" block...');
        $block = $document->findOne('.mainWhoweare');

        $video = explode('/', $block->findOne('iframe')->getAttribute('src'));
        $whoWeAreText = $block->findOne('.wwr_details a')->text();
        $whoWeAreLink = $this->getRelativePath($block->findOne('.wwr_details a')->getAttribute('href'));
        $whoWeAreTitle = $block->findOne('.wwr_details font')->text();
        $whoWeAreDescr = $block->findOne('.wwr_details .textDerails')->text();
        $whoWeAre1 = $block->findOne('.counterbox .helpbox .digit')->text();
        $whoWeAre1Text = $block->findOne('.counterbox .helpbox b')->text();
        $whoWeAre2 = $block->findOne('.counterbox .countrybox .digit')->text();
        $whoWeAre2Text = $block->findOne('.counterbox .countrybox b')->text();
        $whoWeAre3 = $block->findOne('.counterbox .volunteersbox .digit')->text();
        $whoWeAre3Text = $block->findOne('.counterbox .volunteersbox b')->text();

        $parameters['who_we_are_video'] = $video[count($video) - 1];
        $parameters['who_we_are_link'] = $whoWeAreLink;
        $parameters['who_we_are_link_text'] = $whoWeAreText;
        $parameters['who_we_are_title'] = $whoWeAreTitle;
        $parameters['who_we_are_text'] = $whoWeAreDescr;
        $parameters['who_we_are_block_1_title'] = $whoWeAre1;
        $parameters['who_we_are_block_2_title'] = $whoWeAre2;
        $parameters['who_we_are_block_3_title'] = $whoWeAre3;
        $parameters['who_we_are_block_1_text'] = $whoWeAre1Text;
        $parameters['who_we_are_block_2_text'] = $whoWeAre2Text;
        $parameters['who_we_are_block_3_text'] = $whoWeAre3Text;
        $this->info('End of parsing "Who we are".');
    }

    protected function parseOurWorkBlock($document, &$parameters)
    {
        $this->info('Start parsing "Our work" block...');

        $block = $document->findOne('.ourworkBoxes');

        $parameters['our_work_block_title'] = $document->findOne('.ourwork2020 a.bold.underline')->text();
        $parameters['our_work_block_link'] = $this->getRelativePath($document->findOne('.ourwork2020 a.bold.underline')->getAttribute('href'));
        $params = ['longterm', 'emergency', 'volunteering', 'sadiqah'];

        for ($i = 0; $i < 4; $i++) {
            $parameters['our_work_' . $params[$i] . '_title'] = $block->findOne('#ourworkBox' . ($i + 1) . ' span')->text();
        }

        $this->info('End of parsing "Our work".');
    }

    protected function parseCurrentProjectsBlock($document, &$parameters)
    {
        $this->info('Start parsing "Current projects" block...');

        $block = $document->findOne('.currentprojects2020 .page_slider');
        $slides = $block->findMulti('.f');
        $buttonParams = ['read_more_link_', 'donate_now_link_'];

        foreach ($slides as $i => $slide) {
            $parameters['slide_title_' . $i] = $slide->findOne('.bg--white h3')->text();
            $parameters['slide_text_' . $i] = $slide->findOne('.bg--white span')->text();
            $parameters['slide_img_' . $i] = $this->getImageByUrl($slide->findOne('.bg--image img')->getAttribute('src'));
            $button = $slide->findOne('.buttons a');
            foreach ($buttonParams as $j => $param) {
                $parameters[$param . $i] = $button->getAttribute('href');
            }
        }

        $this->info('End of parsing "Current projects".');
    }

    // protected function parseLetsJoinBlock($document, &$parameters)
    // {
    //     $this->info('Start parsing "Lets join" block...');

    //     $block = $document->findOne('.letsJoin2020');

    //     $parameters['lets_title1'] = '';
    //     $parameters['lets_title2'] = '';
    //     $parameters['lets_text1'] = '';
    //     $parameters['lets_text2'] = '';
    //     $parameters['lets_img1'] = '';
    //     $parameters['lets_img2'] = '';
    //     $parameters['lets_video1'] = '';
    //     $parameters['lets_video2'] = '';
    //     $parameters['lets_link1'] = '';
    //     $parameters['lets_link2'] = '';
    //     $parameters['lets_link_text1'] = '';
    //     $parameters['lets_link_text2'] = '';
    //     $parameters['lets_link_text3'] = '';
    //     $parameters['lets_link3'] = '';
    //     $parameters['lets_btn_title3'] = '';

    //     $this->info('End of parsing "Lets join".');
    // }

    protected function getWhatsNewImages($document)
    {
        $block = $document->findOne('.whatsnew2020');

        $images = $block->findMulti('.postImgWhatsnew');

        foreach ($images as $image) {
            $bgStyles = $image->getAttribute('style');
            $urlRegex = '#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#';
            preg_match_all($urlRegex, $bgStyles, $match);
            $urlMatch = $match[0][0];

            $path = $this->getImageByUrl($urlMatch);
        }

    }

    protected function getRelativePath($href)
    {
        $parts = explode('www.islamichelp.org.uk/', $href);
        return $parts[count($parts) - 1];
    }
}
