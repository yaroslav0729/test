<?php

namespace App\Models;
use App\Models\Widget;

class WidgetParameters
{
    const PARAM_EMPTY = 0;
    const PARAM_HTML = 100;
    const PARAM_GROUP = 200;
    const PARAM_ELEMENTS_QUANT = 300;
    const PARAM_PAGES_QUANT = 400;
    const PARAM_OPEN_TEXT = 500;
    const PARAM_BG_IMAGE = 600;
    const PARAM_REFERENCE = 700;

    const PARAM_LABELS = [
        self::PARAM_EMPTY => 'No parameters',
        self::PARAM_HTML => 'Html',
        self::PARAM_GROUP => 'Group',
        self::PARAM_ELEMENTS_QUANT => 'Elements quantity',
        self::PARAM_PAGES_QUANT => 'Pages quantity',
        self::PARAM_OPEN_TEXT => 'Opening text',
        self::PARAM_BG_IMAGE => 'Background image',
        self::PARAM_REFERENCE => 'Reference'
    ];

    static public function getAvailableParameters($widget)
    {
        switch ($widget) {
            case Widget::WIDGET_RICH_TEXT: {
                return [
                    self::PARAM_HTML    
                ];
            }
            case Widget::WIDGET_GROUP_TILES: {
                return [
                    self::PARAM_GROUP,
                    self::PARAM_ELEMENTS_QUANT,
                    self::PARAM_PAGES_QUANT
                ];
            }
            case Widget::WIDGET_BLOG_ARTICLE_HEADER: {
                return [
                    self::PARAM_OPEN_TEXT,
                    self::PARAM_BG_IMAGE
                ];
            }
            case Widget::WIDGET_QUOTE: {
                return [
                    self::PARAM_OPEN_TEXT,
                    self::PARAM_REFERENCE
                ];
            }
        }
    }
}
