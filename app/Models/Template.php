<?php

namespace App\Models;

class Template
{
    const BLOG_PAGE = 1;
    const EVENT_PAGE = 2;
    const INDEX_PAGE = 3;
    const MEDIA_CENTER_PAGE = 4;
    const TEST_PAGE = 100;


    const ALL_TEMPLATES = [
        self::BLOG_PAGE,
        self::EVENT_PAGE,
        self::INDEX_PAGE,
        self::MEDIA_CENTER_PAGE,
        self::TEST_PAGE
    ];

    public static function getLabel($type)
    {
        switch ($type) {
            case self::BLOG_PAGE:return "Blog page";
            case self::EVENT_PAGE:return "Event page";
            case self::INDEX_PAGE:return "Index page";
            case self::MEDIA_CENTER_PAGE:return "Media center page";
            case self::TEST_PAGE:return "Test page";

            default:return "Unknown template type";
        }
    }

    public static function getValidationRules($template)
    {
        $rules = [];

        switch ($template) {
            case self::BLOG_PAGE: {

                $rules = [
                    'parameters.min_read' => 'required',
                    'parameters.hdr_text' => 'required',
                    'parameters.written_by' => 'required',
                    'parameters.hdr_video' => 'required',
                    'parameters.preview_page_title' => 'required',
                    'parameters.preview_page_text1' => 'required',
                    'parameters.preview_page_text2' => 'required',
                    'parameters.preview_page_link' => 'required',
                    'parameters.preview_page_image' => 'required',
                ];

                break;
            }
            case self::EVENT_PAGE: {

                $rules = [
                    'parameters.preview_text' => 'required',
                    'parameters.preview_position' => 'required',
                    'parameters.preview_image' => 'required',
                    'parameters.event_date_text' => 'required',
                    'parameters.event_time_text' => 'required',
                    'parameters.event_link' => 'required',
                    'parameters.event_details_entry' => 'required',
                    'parameters.event_details_organiser' => 'required',
                    'parameters.event_details_speaker' => 'required',
                    'parameters.event_details_contact' => 'required',
                    'parameters.information_title' => 'required',
                    'parameters.information_text' => 'required',
                ];

                break;
            }
            case self::INDEX_PAGE: {

                $rules = [
                    'parameters.hdr_link_text_1' => 'required_if:parameters.hdr_type_active_1,1',
                    'parameters.hdr_link_text_2' => 'required_if:parameters.hdr_type_active_2,2',
                    'parameters.hdr_link_text_3' => 'required_if:parameters.hdr_type_active_3,3',
                    'parameters.hdr_link_text_4' => 'required_if:parameters.hdr_type_active_4,4',

                    'parameters.hdr_learn_more_link_1' => 'required_if:parameters.hdr_type_active_1,1',
                    'parameters.hdr_learn_more_link_2' => 'required_if:parameters.hdr_type_active_2,2',
                    'parameters.hdr_learn_more_link_3' => 'required_if:parameters.hdr_type_active_3,3',
                    'parameters.hdr_learn_more_link_4' => 'required_if:parameters.hdr_type_active_4,4',

                    'parameters.hdr_title_1' => 'required_if:parameters.hdr_type_active_1,1',
                    'parameters.hdr_title_2' => 'required_if:parameters.hdr_type_active_2,2',
                    'parameters.hdr_title_3' => 'required_if:parameters.hdr_type_active_3,3',
                    'parameters.hdr_title_4' => 'required_if:parameters.hdr_type_active_4,4',

                    'parameters.hdr_text_1' => 'required_if:parameters.hdr_type_active_1,1',
                    'parameters.hdr_text_2' => 'required_if:parameters.hdr_type_active_2,2',
                    'parameters.hdr_text_3' => 'required_if:parameters.hdr_type_active_3,3',
                    'parameters.hdr_text_4' => 'required_if:parameters.hdr_type_active_4,4',

                    'parameters.hdr_bg_image_1' => 'required_if:parameters.hdr_type_active_1,1',
                    'parameters.hdr_bg_image_2' => 'required_if:parameters.hdr_type_active_2,2',
                    'parameters.hdr_bg_image_3' => 'required_if:parameters.hdr_type_active_3,3',
                    'parameters.hdr_bg_image_4' => 'required_if:parameters.hdr_type_active_4,4',
                ];

                break;
            }
        }

        return $rules;
    }
}
