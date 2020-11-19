<?php

namespace App\Models;

class Template
{
    const BLOG_PAGE = 1;
    const EVENT_PAGE = 2;
    const INDEX_PAGE = 3;
    const MEDIA_CENTER_PAGE = 4;
    const PROJECTS_PAGE = 5;
    const PROJECT_PAGE = 6;
    const CONTACT_PAGE = 7;
    const WHO_WE_ARE_PAGE = 8;
    const THANK_YOU_DONATE_PAGE = 9;

    const TEST_PAGE = 100;


    const ALL_TEMPLATES = [
        self::BLOG_PAGE,
        self::EVENT_PAGE,
        self::INDEX_PAGE,
        self::MEDIA_CENTER_PAGE,
        self::TEST_PAGE,
        self::WHO_WE_ARE_PAGE,
        self::THANK_YOU_DONATE_PAGE,
        self::CONTACT_PAGE,
        self::PROJECTS_PAGE,
        self::PROJECT_PAGE,
        self::TEST_PAGE

    ];

    public static function getLabel($type)
    {
        switch ($type) {
            case self::BLOG_PAGE:return "Blog page";
            case self::EVENT_PAGE:return "Event page";
            case self::INDEX_PAGE:return "Index page";
            case self::MEDIA_CENTER_PAGE:return "Media center page";
            case self::PROJECTS_PAGE: return "projects page";
            case self::PROJECT_PAGE: return "Project page";
            case self::TEST_PAGE:return "Test page";
            case self::WHO_WE_ARE_PAGE:return "Who we are page";
            case self::THANK_YOU_DONATE_PAGE:return "Thank you your donation page";
            case self::CONTACT_PAGE:return "Contact page";

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

            case self::WHO_WE_ARE_PAGE: {

                $rules = [
                    'parameters.background_image' => 'required',
                    'parameters.our_mission_title' => 'required',
                    'parameters.our_values_description' => 'required',
                    'parameters.our_values_video' => 'required',
                    'parameters.map_image' => 'required',

                    'parameters.action_name_1' => 'required_if:parameters.action_active_1,1',
                    'parameters.action_name_2' => 'required_if:parameters.action_active_2,2',
                    'parameters.action_name_3' => 'required_if:parameters.action_active_3,3',
                    'parameters.action_name_4' => 'required_if:parameters.action_active_4,4',

                    'parameters.action_photo_1' => 'required_if:parameters.action_active_1,1',
                    'parameters.action_photo_2' => 'required_if:parameters.action_active_2,2',
                    'parameters.action_photo_3' => 'required_if:parameters.action_active_3,3',
                    'parameters.action_photo_4' => 'required_if:parameters.action_active_4,4',

                    'parameters.action_slogan_1' => 'required_if:parameters.action_active_1,1',
                    'parameters.action_slogan_2' => 'required_if:parameters.action_active_2,2',
                    'parameters.action_slogan_3' => 'required_if:parameters.action_active_3,3',
                    'parameters.action_slogan_4' => 'required_if:parameters.action_active_4,4',
                ];

                break;
            }

            case self::THANK_YOU_DONATE_PAGE: {

                $rules = [
                    'parameters.donation_text' => 'required|max:60',
                    'parameters.donation_video' => 'required',
                    'parameters.donation_link' => 'required',
                ];

                break;
            }

            case self::CONTACT_PAGE: {

                $rules = [
                    'parameters.background_image' => 'required',
                    'parameters.head_office_title' => 'required',
                    'parameters.foreign_office_title' => 'required',
                    'parameters.head_office_text' => 'required',
                    'parameters.contact_email' => 'email:rfc',
                    'parameters.instagram_link' => 'email:rfc',
                ];

                break;
            }
        }

        return $rules;
    }
}
