<?php

namespace App\Models;

class Template
{
    const BLOG_PAGE = 1;
    const EVENT_PAGE = 2;
    const TEST_PAGE = 3;

    const ALL_TEMPLATES = [
        self::BLOG_PAGE,
        self::EVENT_PAGE,
        self::TEST_PAGE,
    ];

    public static function getLabel($type)
    {
        switch ($type) {
            case self::BLOG_PAGE:return "Blog page";
            case self::EVENT_PAGE:return "Event page";
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
            case self::TEST_PAGE: {

                $rules = [
                    'parameters.param3' => 'required',
                    'parameters.param4' => 'required',
                ];

                break;
            }
        }

        return $rules;
    }
}
