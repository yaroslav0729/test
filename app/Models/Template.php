<?php

namespace App\Models;

class Template
{
    const BLOG_PAGE = 1;
    const EVENT_PAGE = 2;
    const INDEX_PAGE = 3;
    const COMMON_CONTENT_PAGE = 4;
    const PROJECTS_PAGE = 5;
    const PROJECT_PAGE = 6;
    const CONTACT_PAGE = 7;
    const WHO_WE_ARE_PAGE = 8;
    const THANK_YOU_DONATE_PAGE = 9;
    const EVENTS_PAGE = 10;
    const VOLUNTEER_PAGE = 11;
    const MISSION_POSSIBLE = 12;
    const VOLUNTEER_START_PAGE = 13;
    const CALCULATOR_PAGE = 20;

    const TEST_PAGE = 100;


    const ALL_TEMPLATES = [
        self::BLOG_PAGE,
        self::EVENT_PAGE,
        self::INDEX_PAGE,
        self::COMMON_CONTENT_PAGE,
        self::TEST_PAGE,
        self::WHO_WE_ARE_PAGE,
        self::THANK_YOU_DONATE_PAGE,
        self::CONTACT_PAGE,
        self::PROJECTS_PAGE,
        self::PROJECT_PAGE,
        self::EVENTS_PAGE,
        self::CALCULATOR_PAGE,
        self::VOLUNTEER_PAGE,
        self::MISSION_POSSIBLE,
        self::VOLUNTEER_START_PAGE,

    ];

    public static function getLabel($type)
    {
        switch ($type) {
            case self::BLOG_PAGE:return "Blog page";
            case self::EVENT_PAGE:return "Event page";
            case self::INDEX_PAGE:return "Index page";
            case self::COMMON_CONTENT_PAGE:return "Common content page";
            case self::PROJECTS_PAGE: return "Projects page";
            case self::PROJECT_PAGE: return "Project page";
            case self::TEST_PAGE:return "Test page";
            case self::WHO_WE_ARE_PAGE:return "Who we are page";
            case self::THANK_YOU_DONATE_PAGE:return "Thank you your donation page";
            case self::CONTACT_PAGE:return "Contact page";
            case self::EVENTS_PAGE:return "Events page";
            case self::VOLUNTEER_PAGE:return "Volunteers page";
            case self::CALCULATOR_PAGE:return "Zakat calculator page";
            case self::MISSION_POSSIBLE:return "Mission possible page";
            case self::VOLUNTEER_START_PAGE:return "Volunteers get started page";

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
                    'parameters.preview_position' => 'required',
                    'parameters.event_type_participate' => 'required',
                    'parameters.event_start_date' => 'required|date',
                    'parameters.event_start_time' => 'required|date_format:H:i',
                    'parameters.event_end_date' => 'nullable|date|after_or_equal:parameters.event_start_date',
                    'parameters.event_end_time' => 'nullable|date_format:H:i|after:parameters.event_start_time',
                    'parameters.event_end_sale_date' => 'required|date|before:parameters.event_start_date',
                    'parameters.event_entry_price' => 'nullable|numeric|min:1',
                    'parameters.event_link' => 'required',
                    'parameters.event_details_entry' => 'required',
                    'parameters.event_details_organiser' => 'required',
                    //'parameters.event_details_speaker' => 'required',
                    'parameters.event_details_contact' => 'required',
                    //'parameters.information_title' => 'required',
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

                    'parameters.who_we_are_link_text' => 'required|max:125',
                    'parameters.who_we_are_title' => 'required',
                    'parameters.who_we_are_video' => 'required',
                    'parameters.who_we_are_link' => 'required',
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
                    'parameters.map_alt_image' => 'required',

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

                    'parameters.action_title_1' => 'required_if:parameters.action_active_1,1',
                    'parameters.action_title_2' => 'required_if:parameters.action_active_2,2',
                    'parameters.action_title_3' => 'required_if:parameters.action_active_3,3',
                    'parameters.action_title_4' => 'required_if:parameters.action_active_4,4',

                    'parameters.action_description_1' => 'required_if:parameters.action_active_1,1',
                    'parameters.action_description_2' => 'required_if:parameters.action_active_2,2',
                    'parameters.action_description_3' => 'required_if:parameters.action_active_3,3',
                    'parameters.action_description_4' => 'required_if:parameters.action_active_4,4',

                    'parameters.action_learn_more_link_1' => 'required_if:parameters.action_active_1,1',
                    'parameters.action_learn_more_link_2' => 'required_if:parameters.action_active_2,2',
                    'parameters.action_learn_more_link_3' => 'required_if:parameters.action_active_3,3',
                    'parameters.action_learn_more_link_4' => 'required_if:parameters.action_active_4,4',

                    'parameters.story_year_1' => 'required_if:parameters.story_active.0,1',
                    'parameters.story_year_2' => 'required_if:parameters.story_active.1,2',
                    'parameters.story_year_3' => 'required_if:parameters.story_active.2,3',
                    'parameters.story_year_4' => 'required_if:parameters.story_active.3,4',

                    'parameters.story_photo_1' => 'required_if:parameters.story_active.0,1',
                    'parameters.story_photo_2' => 'required_if:parameters.story_active.1,2',
                    'parameters.story_photo_3' => 'required_if:parameters.story_active.2,3',
                    'parameters.story_photo_4' => 'required_if:parameters.story_active.3,4',

                    'parameters.story_text_1' => 'required_if:parameters.story_active.0,1',
                    'parameters.story_text_2' => 'required_if:parameters.story_active.1,2',
                    'parameters.story_text_3' => 'required_if:parameters.story_active.2,3',
                    'parameters.story_text_4' => 'required_if:parameters.story_active.3,4',

                    'parameters.changing_block_title' => 'required',
                    'parameters.changing_block_text' => 'required',
                    'parameters.changing_block_text_mobile' => 'required|max:460',

                    'parameters.changing_block_photo_1' => 'required_if:parameters.changing_active.0,1',
                    'parameters.changing_block_photo_2' => 'required_if:parameters.changing_active.1,2',

                    'parameters.changing_block_phrase_1' => 'required_if:parameters.changing_active.0,1',
                    'parameters.changing_block_phrase_2' => 'required_if:parameters.changing_active.1,2',

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
                    'parameters.upper_phrase' => 'required',
                    'parameters.bottom_phrase' => 'required',
                    'parameters.background_image' => 'required',

                    'parameters.head_text' => 'required',

                    'parameters.head_office_title' => 'required',
                    'parameters.head_office_text' => 'required',
                    'parameters.foreign_office_title' => 'required',
                    'parameters.foreign_office_text' => 'required',

                    'parameters.contact_email_title' => 'required',
                    'parameters.contact_email' => 'email:rfc',
                    'parameters.instagram_link' => 'required',
                    'parameters.facebook_link' => 'required',
                    'parameters.youtube_link' => 'required',
                    'parameters.twitter_link' => 'required',
                ];

                break;
            }

            case self::EVENTS_PAGE: {

                $rules = [
                    'parameters.per_page' => 'numeric|min:1',
                ];

                break;
            }

            case self::CALCULATOR_PAGE: {

                $rules = [
                    'parameters.tab_calc_title' => 'required',
                    'parameters.tab_what_zakat_title' => 'required',
                    'parameters.calc_base_value_nisaab_title' => 'required',

                    'parameters.price_silver' => 'numeric|min:1',
                    'parameters.price_gold' => 'numeric|min:1',

                    'parameters.calc_below_title' => 'required',
                    'parameters.calc_your_assets_section_title' => 'required',
                    'parameters.calc_value_gold_title' => 'required',
                    'parameters.calc_value_gold_annotation' => 'required',
                    'parameters.calc_value_silver_title' => 'required',
                    'parameters.calc_value_silver_annotation' => 'required',

                    'parameters.calc_cash_hand_title' => 'required',
                    'parameters.calc_cash_hand_annotation' => 'required',
                    'parameters.calc_cash_deposited_title' => 'required',
                    'parameters.calc_cash_deposited_annotation' => 'required',

                    'parameters.calc_given_title' => 'required',
                    'parameters.calc_given_annotation' => 'required',
                    'parameters.calc_other_title' => 'required',
                    'parameters.calc_other_annotation' => 'required',

                    'parameters.calc_trade_goods_section_title' => 'required',
                    'parameters.calc_value_stock_title' => 'required',
                    'parameters.calc_value_stock_annotation' => 'required',

                    'parameters.calc_liabilities_section_title' => 'required',
                    'parameters.calc_borrowed_title' => 'required',
                    'parameters.calc_borrowed_annotation' => 'required',
                    'parameters.calc_wages_title' => 'required',
                    'parameters.calc_wages_annotation' => 'required',

                    'parameters.calc_taxes_title' => 'required',
                    'parameters.calc_taxes_annotation' => 'required',

                    'parameters.w_i_zakat_title' => 'required',
                    'parameters.w_i_zakat_text' => 'required',
                    'parameters.w_i_obligatory_title' => 'required',
                    'parameters.w_i_obligatory_text' => 'required',

                    'parameters.w_i_donate_title' => 'required',
                    'parameters.w_i_donate_text' => 'required',
                    'parameters.w_i_receive_title' => 'required',
                    'parameters.w_i_receive_text' => 'required',

                    'parameters.w_i_calc_title' => 'required',
                    'parameters.w_i_calc_text' => 'required',
                    'parameters.w_i_nisaab_title' => 'required',
                    'parameters.w_i_nisaab_text' => 'required',

                    'parameters.w_i_should_title' => 'required',
                    'parameters.w_i_should_text' => 'required',
                    'parameters.w_i_gold_title' => 'required',
                    'parameters.w_i_gold_text' => 'required',

                    'parameters.w_i_silver_title' => 'required',
                    'parameters.w_i_silver_text' => 'required',

                    'parameters.w_i_btn_title' => 'required',
                    'parameters.w_i_btn_link' => 'required',

                    'parameters.dropdown_title' => 'required',
                    'parameters.dropdown_text' => 'required',
                    'parameters.dropdown_link_title' => 'required',
                    'parameters.dropdown_link' => 'required',
                ];

                break;
            }

            case self::VOLUNTEER_PAGE: {

                $rules = [
                    'parameters.column1_text' => 'max:160',
                    'parameters.column2_text' => 'max:160',
                    'parameters.column3_text' => 'max:160',
                    'parameters.explore_proj_text' => 'max:210',
                    'parameters.preview_page_text2' => 'max:170',
                    'parameters.interested_text' => 'max:210',
                ];

                break;
            }

            case self::MISSION_POSSIBLE: {

                $rules = [
                    'parameters.so_what_text' => 'max:455',
                    'parameters.col_text1' => 'max:160',
                    'parameters.col_text2' => 'max:160',
                    'parameters.col_text3' => 'max:160',
                    'parameters.exp_quote' => 'max:160',
                    'parameters.our_latest_text2' => 'max:170',
                    'parameters.be_part_text' => 'max:210',
                ];

                break;
            }

            case self::PROJECT_PAGE: {

                $rules = [
                    'parameters.donate_text' => 'max:100',
                    'parameters.what_happens_text' => 'max:180',
                    'parameters.still_need_text1' => 'max:60',
                    'parameters.still_need_text2' => 'max:60',
                    'parameters.still_need_text3' => 'max:60',
                ];

                break;
            }
        }

        return $rules;
    }
}
