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
    const NEWSROOM_PAGE = 14;
    const CALCULATOR_PAGE = 20;

    const TEST_PAGE = 100;


    const ALL_TEMPLATES = [
        self::INDEX_PAGE,
        self::BLOG_PAGE,
        self::COMMON_CONTENT_PAGE,
        self::PROJECTS_PAGE,
        self::PROJECT_PAGE,
        self::EVENT_PAGE,
        self::EVENTS_PAGE,
        self::WHO_WE_ARE_PAGE,
        self::THANK_YOU_DONATE_PAGE,
        self::CONTACT_PAGE,
        self::CALCULATOR_PAGE,
        self::VOLUNTEER_PAGE,
        self::VOLUNTEER_START_PAGE,
        self::MISSION_POSSIBLE,
        self::NEWSROOM_PAGE,
        //self::TEST_PAGE,
    ];

    public static function getLabel($type)
    {
        switch ($type) {
            case self::BLOG_PAGE:return "Blog page";
            case self::EVENT_PAGE:return "Event page";
            case self::INDEX_PAGE:return "Index page";
            case self::COMMON_CONTENT_PAGE:return "General content page";
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
            case self::NEWSROOM_PAGE:return "Newsroom page";

            default:return "Unknown template type";
        }
    }

    const CONFIGURE_TEMPLATES = [
        self::INDEX_PAGE => [
            'headerClassName' => 'white',
            'footerClassName' => 'bg-primary',
            'headerType' => 'parts.header',
        ],
        self::CALCULATOR_PAGE => [
            'headerClassName' => 'white',
            'headerMobileClassName' => 'bg-white',
            'footerClassName' => 'bg-primary-light',
            'headerType' => 'parts.header',
        ],
        self::PROJECTS_PAGE => [
            'headerClassName' => 'blue',
            'footerClassName' => 'bg-primary-light',
            'headerType' => 'parts.header',
        ],
        self::WHO_WE_ARE_PAGE => [
            'headerClassName' => 'white',
            'footerClassName' => 'bg-primary',
            'headerType' => 'parts.header',
        ],
        self::EVENT_PAGE => [
            'headerClassName' => 'white',
            'headerMobileClassName' => 'bg-primary-light',
            'footerClassName' => 'bg-primary',
            'headerType' => 'parts.header',
        ],
        self::EVENTS_PAGE => [
            'headerClassName' => 'white',
            'headerMobileClassName' => 'bg-primary-light',
            'footerClassName' => 'bg-primary',
            'headerType' => 'parts.header',
        ],
        self::CONTACT_PAGE => [
            'headerClassName' => 'white',
            'footerClassName' => 'bg-primary',
            'headerType' => 'parts.header',
        ],

        self::PROJECT_PAGE => [
            'headerClassName' => 'blue',
            'footerClassName' => 'bg-info',
            'headerType' => 'parts.header',
        ],

        self::MISSION_POSSIBLE => [
            'headerClassName' => 'white',
            'footerClassName' => 'bg-info',
            'headerType' => 'parts.header',
        ],

        self::VOLUNTEER_PAGE => [
            'headerClassName' => 'white',
            'footerClassName' => 'bg-info-red',
            'headerType' => 'parts.header',
        ],

        self::VOLUNTEER_START_PAGE => [
            'headerClassName' => 'white',
            'footerClassName' => 'bg-info-red',
            'headerType' => 'parts.header',
        ],

        self::NEWSROOM_PAGE => [
            'headerClassName' => '',
            'footerClassName' => 'bg-info',
            'headerType' => 'parts.header_newsroom',
            'headerAlwaysPurple' => true
        ],

        self::THANK_YOU_DONATE_PAGE => [
            'headerClassName' => 'white',
            'footerClassName' => 'bg-info-yellow',
            'headerType' => 'parts.header',
        ],

    ];


    public static function getConfigureTemplate(int $type)
    {
        if (array_key_exists($type, self::CONFIGURE_TEMPLATES)) {
            return self::CONFIGURE_TEMPLATES[$type];
        }

        return [
            'headerClassName' => 'blue',
            'footerClassName' => 'bg-primary',
            'headerType' => 'parts.header',
        ];
    }

    public static function getValidationRules($template)
    {
        $rules = [];

        switch ($template) {
            case self::NEWSROOM_PAGE: {

                $rules = [

                ];

                break;
            }

            case self::BLOG_PAGE: {

                $rules = [
                    'parameters.min_read' => 'required',
                    'parameters.hdr_text' => 'required',
                    'parameters.written_by' => 'required',
                    'parameters.hdr_video' => 'required',
                    // 'parameters.preview_page_title' => 'required',
                    // 'parameters.preview_page_text1' => 'required',
                    // 'parameters.preview_page_text2' => 'required',
                    // 'parameters.preview_page_link' => 'required',
                    // 'parameters.preview_page_image' => 'required',
                ];

                break;
            }
            case self::EVENT_PAGE: {

                $rules = [
                    'parameters.event_title' => 'required|max:60',
                    'parameters.event_description' => 'required|max:150',
                    'parameters.event_type_participate' => 'required',
                    'parameters.preview_position' => 'required',
                    'parameters.event_link_text' => 'required',
                    'parameters.event_link' => 'required',

                    'parameters.event_start_date' => 'required|date',
                    'parameters.event_start_time' => 'required|date_format:H:i',
                    'parameters.event_end_date' => 'nullable|date|after_or_equal:parameters.event_start_date',
                    'parameters.event_end_time' => 'nullable|date_format:H:i|after:parameters.event_start_time',
                    'parameters.event_end_sale_date' => 'required|date|before:parameters.event_start_date',

                    'parameters.event_details_entry' => 'required',
                    'parameters.event_entry_price' => 'nullable|numeric|min:1',
                    'parameters.event_details_organiser' => 'required',
                    'parameters.event_details_speaker' => 'nullable',
                    'parameters.event_details_contact' => 'required',

                    'parameters.information_title' => 'nullable',
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

                    'parameters.who_we_are_link_text' => 'required|max:255',
                    'parameters.who_we_are_title' => 'required',
                    'parameters.who_we_are_video' => 'required',
                    'parameters.who_we_are_link' => 'required',
                    'parameters.who_we_are_text' => 'required|max:200',

                    'parameters.slide_text_0' => 'max:125',
                    'parameters.slide_text_1' => 'max:125',
                    'parameters.slide_text_2' => 'max:125',
                    'parameters.slide_text_3' => 'max:125',

                    'parameters.our_work_block_title' => 'required',
                    'parameters.our_work_block_link' => 'required',

                    'parameters.our_work_longterm_title' => 'required',
                    'parameters.our_work_longterm_text' => 'required|max:340',
                    'parameters.our_work_longterm_video' => 'required',

                    'parameters.our_work_emergency_title' => 'required',
                    'parameters.our_work_emergency_text' => 'required|max:340',
                    'parameters.our_work_emergency_video' => 'required',

                    'parameters.our_work_volunteering_title' => 'required',
                    'parameters.our_work_volunteering_text' => 'required|max:340',
                    'parameters.our_work_volunteering_video' => 'required',

                    'parameters.our_work_sadiqah_title' => 'required',
                    'parameters.our_work_sadiqah_text' => 'required|max:340',
                    'parameters.our_work_sadiqah_video' => 'required',

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

                    'parameters.our_values_action_description' => 'required',

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
                    'parameters.donation_text' => 'required',
                    'parameters.donation_article_title' => 'required|max:60',
                    'parameters.donation_video' => 'required',
                    'parameters.donation_link_title' => 'required',
                    'parameters.donation_link_title_mobile' => 'required',
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
                    'parameters.w_i_when_donate_title' => 'required',
                    'parameters.w_i_when_donate_text' => 'required',
                    'parameters.w_i_receive_title' => 'required',
                    'parameters.w_i_receive_text' => 'required',

                    'parameters.w_i_calc_title' => 'required',
                    'parameters.w_i_calc_text' => 'required',
                    'parameters.w_i_nisaab_title' => 'required',
                    'parameters.w_i_nisaab_text' => 'required',

                    'parameters.w_i_should_title' => 'required',
                    'parameters.w_i_should_text' => 'required',
                    'parameters.w_i_gold_title' => 'required',
                    'parameters.w_i_gold_text' => 'required|max:460',

                    'parameters.w_i_silver_title' => 'required',
                    'parameters.w_i_silver_text' => 'required|max:460',

                    'parameters.w_i_btn_title' => 'required',
                    'parameters.w_i_btn_link' => 'required',

                    'parameters.dropdown_title' => 'required',
                    'parameters.dropdown_text' => 'required',
                    'parameters.dropdown_link_title' => 'required',
                    'parameters.dropdown_link' => 'required',

                    'parameters.donate_to_title' => 'required',
                    'parameters.donate_to_title_mobile' => 'required',
                    'parameters.donate_to_text' => 'required|max:100',

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
                    'parameters' => 'amount_limit_items',
                    'parameters.proj_heading' => 'max:100', //'max:30',
                    'parameters.proj_par1' => 'max:460',
                    'parameters.proj_par2' => 'max:460',
                    'parameters.proj_par3' => 'max:460',
                    'parameters.amount' => 'amount_text',
                    'parameters.donate_text' => 'max:100',
                    'parameters.what_happens_text' => 'max:180',
                    'parameters.still_need_text1' => 'max:60',
                    'parameters.still_need_text2' => 'max:60',
                    'parameters.still_need_text3' => 'max:60',
                ];

                break;
            }

            case self::PROJECTS_PAGE: {
                $rules = [
                    'parameters' => 'amount_limit_items'
                ];

                break;
            }
        }

        return $rules;
    }
}
