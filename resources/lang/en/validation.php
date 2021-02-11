<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'parameters.amount' => [
            'amount_text' => 'Amount donation text lenght error - max 60 charters',
        ],
        'parameters' => [
            'amount_limit_items' => 'Single & Monthly tabs should have only 3 or 5 items of amounts'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        /*--------------------- Zakat Calculator ------------------------*/
        'parameters.tab_calc_title' => 'Tab Calculate Title',
        'parameters.tab_what_zakat_title' => 'Tab What is Zakat Title',
        'parameters.calc_base_value_nisaab_title' => 'Base Value of Nisaab title',
        'parameters.price_silver' => 'Price Silver',
        'parameters.price_gold' => 'Price Gold',
        'parameters.calc_below_title' => 'Enter below, your total assets text',

        'parameters.calc_your_assets_section_title' => 'Your assets section title',
        'parameters.calc_value_gold_title' => 'Value of Gold title',
        'parameters.calc_value_gold_annotation' => 'Value of Gold annotation',
        'parameters.calc_value_silver_title' => 'Value of Silver title',
        'parameters.calc_value_silver_annotation' => 'Value of Silver annotation',

        'parameters.calc_cash_hand_title' => 'Cash in hand/in bank accounts title',
        'parameters.calc_cash_hand_annotation' => 'Cash in hand/in bank accounts annotation',
        'parameters.calc_cash_deposited_title' => 'Cash deposited for future purpose title',
        'parameters.calc_cash_deposited_annotation' => 'Cash deposited for future purpose annotation',

        'parameters.calc_given_title' => 'Given out in loans title',
        'parameters.calc_given_annotation' => 'Given out in loans annotation',
        'parameters.calc_other_title' => 'Other investments title',
        'parameters.calc_other_annotation' => 'Other investments annotation',

        'parameters.calc_trade_goods_section_title' => 'Trade goods section title',
        'parameters.calc_value_stock_title' => 'Value of stock title',
        'parameters.calc_value_stock_annotation' => 'Value of stock annotation',

        'parameters.calc_liabilities_section_title' => 'Liabilities section title',
        'parameters.calc_borrowed_title' => 'Borrowed money/items bought on credit title',
        'parameters.calc_borrowed_annotation' => 'Borrowed money/items bought on credit annotation',
        'parameters.calc_wages_title' => 'Wages due to employees title',
        'parameters.calc_wages_annotation' => 'Wages due to employees annotation',

        'parameters.calc_taxes_title' => 'Taxes/Rent/Utility bills due immediately title',
        'parameters.calc_taxes_annotation' => 'Taxes/Rent/Utility bills due immediately annotation',

        'parameters.w_i_zakat_title' => 'What is Zakat title',
        'parameters.w_i_zakat_text' => 'What is Zakat text',
        'parameters.w_i_obligatory_title' => 'Zakat obligatory title',
        'parameters.w_i_obligatory_text' => 'Zakat obligatory text',

        'parameters.w_i_donate_title' => 'Why do we donate Zakat title',
        'parameters.w_i_donate_text' => 'Why do we donate Zakat text',
        'parameters.w_i_when_donate_title' => 'When should we donate Zakat title',
        'parameters.w_i_when_donate_text' => 'When should we donate Zakat text',
        'parameters.w_i_receive_title' => 'Who can receive Zakat title',
        'parameters.w_i_receive_text' => 'Who can receive Zakat text',

        'parameters.w_i_calc_title' => 'How is Zakat calculated title',
        'parameters.w_i_calc_text' => 'How is Zakat calculated text',
        'parameters.w_i_nisaab_title' => 'How is Nisaab measured title',
        'parameters.w_i_nisaab_text' => 'How is Nisaab measured text',

        'parameters.w_i_should_title' => 'Should I use gold/silver to calculate Nisaab title',
        'parameters.w_i_should_text' => 'Should I use gold/silver to calculate Nisaab text',
        'parameters.w_i_gold_title' => 'Gold title',
        'parameters.w_i_gold_text' => 'Gold text',

        'parameters.w_i_silver_title' => 'Silver title',
        'parameters.w_i_silver_text' => 'Silver text',
        'parameters.w_i_btn_title' => 'Calculate Zakat button Title',
        'parameters.w_i_btn_link' => 'Calculate Zakat button link',

        'parameters.dropdown_title' => 'What do I need title',
        'parameters.dropdown_text' => 'What do I need text',
        'parameters.dropdown_link_title' => 'Link title',
        'parameters.dropdown_link' => 'Link',

        'parameters.donate_to_title' => 'Donate to project title',
        'parameters.donate_to_title_mobile' => 'Donate to project title(mobile)',
        'parameters.donate_to_text' => 'Donate to project text',


        /*--------------------- End Zakat Calculator ------------------------*/

        /*--------------------- Who we are ------------------------*/
        'parameters.background_image' => 'Background image path',
        'parameters.our_mission_title' => 'Our mission title',
        'parameters.our_values_description' => 'Our values description',
        'parameters.our_values_video' => 'Our values video',
        'parameters.map_image' => 'Map image path',
        'parameters.map_alt_image' => 'Map alternative image path',

        'parameters.our_values_action_description' => 'Our values in action description (for mobile)',

        'parameters.action_active_1' => 'Active slide',
        'parameters.action_active_2' => 'Active slide',
        'parameters.action_active_3' => 'Active slide',
        'parameters.action_active_4' => 'Active slide',

        'parameters.action_name_1' => 'Name',
        'parameters.action_name_2' => 'Name',
        'parameters.action_name_3' => 'Name',
        'parameters.action_name_4' => 'Name',

        'parameters.action_photo_1' => 'Photo',
        'parameters.action_photo_2' => 'Photo',
        'parameters.action_photo_3' => 'Photo',
        'parameters.action_photo_4' => 'Photo',

        'parameters.action_slogan_1' => 'Slogan',
        'parameters.action_slogan_2' => 'Slogan',
        'parameters.action_slogan_3' => 'Slogan',
        'parameters.action_slogan_4' => 'Slogan',

        'parameters.action_title_1' => 'Title',
        'parameters.action_title_2' => 'Title',
        'parameters.action_title_3' => 'Title',
        'parameters.action_title_4' => 'Title',

        'parameters.action_description_1' => 'Description',
        'parameters.action_description_2' => 'Description',
        'parameters.action_description_3' => 'Description',
        'parameters.action_description_4' => 'Description',

        'parameters.action_learn_more_link_1' => 'Learn more link',
        'parameters.action_learn_more_link_2' => 'Learn more link',
        'parameters.action_learn_more_link_3' => 'Learn more link',
        'parameters.action_learn_more_link_4' => 'Learn more link',

        'parameters.story_active.0' => 'Active slide',
        'parameters.story_active.1' => 'Active slide',
        'parameters.story_active.2' => 'Active slide',
        'parameters.story_active.3' => 'Active slide',

        'parameters.story_year_1' => 'Year',
        'parameters.story_year_2' => 'Year',
        'parameters.story_year_3' => 'Year',
        'parameters.story_year_4' => 'Year',

        'parameters.story_photo_1' => 'Photo',
        'parameters.story_photo_2' => 'Photo',
        'parameters.story_photo_3' => 'Photo',
        'parameters.story_photo_4' => 'Photo',

        'parameters.story_text_1' => 'Text',
        'parameters.story_text_2' => 'Text',
        'parameters.story_text_3' => 'Text',
        'parameters.story_text_4' => 'Text',

        'parameters.changing_block_title' => 'Life changing support title',
        'parameters.changing_block_text' => 'Life changing support text',
        'parameters.changing_block_text_mobile' => 'Life changing support text for mobile',

        'parameters.changing_active.0' => 'Active slide',
        'parameters.changing_active.1' => 'Active slide',

        'parameters.changing_block_photo_1' => 'Photo',
        'parameters.changing_block_photo_2' => 'Photo',
        'parameters.changing_block_phrase_1' => 'Phrase',
        'parameters.changing_block_phrase_3' => 'Phrase',

        /*--------------------- End Who we are ------------------------*/

        /*--------------------- Contact ------------------------*/
        'parameters.upper_phrase' => 'Upper Phrase',
        'parameters.bottom_phrase' => 'Bottom Phrase',

        'parameters.head_text' => 'Head text',

        'parameters.head_office_title' => 'Head office title',
        'parameters.head_office_text' => 'Head office text',
        'parameters.foreign_office_title' => 'Foreign office title',
        'parameters.foreign_office_text' => 'Foreign office text',

        'parameters.contact_email_title' => 'Email title',
        'parameters.contact_email' => 'Email',

        'parameters.instagram_link' => 'Instagram link',
        'parameters.facebook_link' => 'Facebook link',
        'parameters.youtube_link' => 'Youtube link',
        'parameters.twitter_link' => 'Twitter link',

        /*--------------------- End Contact ------------------------*/

        /*--------------------- Thank you for donation --------------*/
        'parameters.donation_text' => 'Thank you your donation text',
        'parameters.donation_article_title' => 'Article title',
        'parameters.donation_video' => 'Youtube video link',
        'parameters.donation_link_title' => 'View story link title',
        'parameters.donation_link_title_mobile' => 'View story link title (mobile)',
        'parameters.donation_link' => 'View story link',

        /*--------------------- End Thank you for donation ------------------------*/

        /*--------------------- Event --------------*/
        'parameters.event_title' => 'Event title',
        'parameters.event_description' => 'Event description',
        'parameters.event_type_participate' => 'Event details entry',
        'parameters.preview_position' => 'Preview position',
        'parameters.event_link_text' => 'Event link text',
        'parameters.event_link' => 'Event link',

        'parameters.event_start_date' => 'Event start date',
        'parameters.event_start_time' => 'Event start time',
        'parameters.event_end_date' => 'Event end date',
        'parameters.event_end_time' => 'Event end time',
        'parameters.event_end_sale_date' => 'Event sales end on',

        'parameters.event_details_entry' => 'Event details entry',
        'parameters.event_entry_price' => 'Event price',
        'parameters.event_details_organiser' => 'Event details organiser',
        'parameters.event_details_speaker' => 'Event details speaker',
        'parameters.event_details_contact' => 'Event details contact',

        'parameters.information_title' => 'Information title',
        'parameters.information_text' => 'Information text',

        /*--------------------- End Event ------------------------*/

        /*--------------------- Events --------------*/
        'parameters.per_page' => 'Number events per page',

        'parameters.need_title' => 'Islamic Help needs module Title',
        'parameters.need_text' => 'Islamic Help needs module Text',
        'parameters.need_link_text' => 'Islamic Help needs module Link text',
        'parameters.need_link' => 'Islamic Help needs module Link',

        /*--------------------- End Events ------------------------*/
    ],

];

