<?php

namespace App\Console\Commands\Parts;
use App\Models\Page;
use App\Models\PageInstance;
use App\Models\Template;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;

class EventsParser
{
    protected $wpConnection;

    const IMAGE_PATH = 'events';

    public function __construct($wpConnection)
    {
        $this->wpConnection = $wpConnection;
    }

    public function info($str)
    {
        echo $str . PHP_EOL;
    }

    public function parseEvents()
    {
        $events = $this->wpConnection->table('wp_posts')
        ->where('wp_posts.id', 10734)
        ->where('wp_posts.post_type', 'events')
        ->get();

       foreach ($events as $pageKey => $event) {
            $copyEvent = Page::where('wp_id', $event->ID)->first();

            $eventOptions = $this->wpConnection->table('wp_postmeta')
                ->where('post_id', $event->ID)
                ->get();

            if ($copyEvent) {

                $copyEvent->update([
                    'status' => $event->post_status === 'publish' ? Page::PAGE_STATUS_PUBLICHED : Page::PAGE_STATUS_NOT_PUBLICHED,
                ]);

                $instance = $copyEvent->actual_page_instance;

                if ($instance === null) {
                    dd($copyEvent->id);
                }

                $instance->update([
                    'name' => $event->post_title,
                    'slug' => 'events/' . $event->post_name,
                    'title' => $event->post_title,
                    'description' => 'parsed event page wp_id: ' . $event->ID,
                    'template' => Template::EVENT_PAGE,
                ]);

                $infoString = $pageKey . ': Event updated => id: ' . $copyEvent->id . ', wp_id: ' . $copyEvent->wp_id;

            } else {

                $copyEvent = Page::create([
                    'wp_id' => $event->ID,
                    'status' => $event->post_status === 'publish' ? Page::PAGE_STATUS_PUBLICHED : Page::PAGE_STATUS_NOT_PUBLICHED,
                ]);

                $instance = PageInstance::create([
                    'name' => $event->post_title,
                    'slug' => 'events/' . $event->post_name,
                    'title' => $event->post_title,
                    'description' => 'parsed event page wp_id: ' . $event->ID,
                    'page_id' => $copyEvent->id,
                    'template' => Template::EVENT_PAGE,
                ]);

                $instance->actual = true;
                $instance->save();

                $infoString = $pageKey . ': Event created => id: ' . $copyEvent->id . ', wp_id: ' . $copyEvent->wp_id;
            }

            $this->updateTemplateParams($instance, $eventOptions, $event);
            $this->createOrUpdateEvent($instance);

            $this->info($infoString);
            Log::channel('parser')->info($infoString);
       }

       $this->info('count events:' . count($events));
    }

    protected function createOrUpdateEvent($instance)
    {
        $data = [];
        $data['name'] = $instance->name;
        $data['page_id'] = $instance->page->id;
        $data['parameters'] = $instance->parameters;

        $event = Event::updateOrCreate(['page_id'=> $instance->page->id], $data);
    }

    protected function updateTemplateParams($instance, $options, $event)
    {
        $parameters = $instance->parameters;

        $evType = $this->getOption($options, 'eventType');

        switch ($evType) {
            case 'Paid': $evType = Event::ENTRY_PAID;
            default: $evType = Event::ENTRY_FREE;
        }

        $parameters['event_details_entry'] = $evType;
        
        $typeParticipate = $this->getOption($options, 'liveEvents');

        switch ($typeParticipate) {
            case 'Webinars': $typeParticipate = Event::EVENT_ONLINE;
            case 'Live events': $typeParticipate = Event::EVENT_LIVE;
            case 'Fundraising efforts': $typeParticipate = Event::EVENT_FUNDRAISING;
            default: $typeParticipate = Event::EVENT_ONLINE;
        }

        $eventsDate = $this->getOption($options, 'events_date');
        $eventsDate = $this->getDate($eventsDate);
        $parameters['event_start_date'] = $eventsDate;

        $eventsDate = $this->getOption($options, 'events_close_date');
        $eventsDate = $this->getDate($eventsDate);
        $parameters['event_end_date'] = $eventsDate;

        $eventsDate = $this->getOption($options, 'events_date');
        $eventsDate = $this->getDateBefore($eventsDate);
        $parameters['event_end_sale_date'] = $eventsDate;

        $eventsTime = $this->getOption($options, 'events_date_time');
        $eventsTime = $this->getTime($eventsTime);
        $parameters['event_start_time'] = $eventsTime;

        $eventsTime = $this->getOption($options, 'events_close_time');
        $eventsTime = $this->getTime($eventsTime);
        $parameters['event_end_time'] = $eventsTime;

        
        $parameters['event_details_organiser'] = $this->getOption($options, 'events_sidebar_info_2_events_value');
        $parameters['event_details_contact'] = $this->getOption($options, 'events_sidebar_info_3_events_value');
        $parameters['important_title'] = $this->getOption($options, 'cta_heading');
        $parameters['important_text'] = $this->getOption($options, 'cta_detail_text');
        $parameters['event_link_text'] = $this->getOption($options, 'events_address_text');
        $parameters['event_link'] = 'https://maps.google.com/?daddr=' . $parameters['event_link_text'];

        $price = $this->getOption($options, 'event_reg_price');
        $price = $this->getPrice($price);
        $parameters['event_entry_price'] = $price;

        $parameters['event_type_participate'] = $typeParticipate;

        $parameters['information_text'] = $event->post_content;
        $parameters['preview_position'] = $this->getOption($options, 'event_city');

        $img = $this->getOption($options, 'background');
        $instance->preview_img = $this->getWpImage($img);
        $instance->preview_text = $this->getOption($options, 'events_description');
        $instance->parameters = $parameters;
        //$instance->title = $this->getOption($options, '_yoast_wpseo_title');
        $instance->description = $this->getOption($options, '_yoast_wpseo_metadesc');
        $instance->save();
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
            $path = self::IMAGE_PATH . '/' . $year . '/' . $month . '/' . $name;

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

    protected function getPrice($str)
    {
        $price = substr($str, 2);

        return $price;
    }

    protected function getTime($str)
    {
        $hou = substr($str, 0, 2);
        $min = substr($str, 3, 2);

        return $hou . ':' . $min;
    }

    protected function getDate($str)
    {
        $year = substr($str, 0, 4);
        $month = substr($str, 4, 2);
        $day = substr($str, 6, 2);

        return Carbon::createFromDate($year, $month, $day)->toDateString('');
    }

    protected function getDateBefore($str)
    {
        $year = substr($str, 0, 4);
        $month = substr($str, 4, 2);
        $day = substr($str, 6, 2);

        return Carbon::createFromDate($year, $month, $day)->subDays(1)->toDateString('');
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

}