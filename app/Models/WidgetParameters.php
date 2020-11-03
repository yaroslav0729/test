<?php

namespace App\Models;
use App\Models\Widget;

class WidgetParameters
{
    const PARAM_HTML = 100;
    const PARAM_GROUP = 200;
    const PARAM_ELEMENTS_QUANT = 300;
    const PARAM_PAGES_QUANT = 400;
    const PARAM_MAIN_TEXT = 500;
    const PARAM_BG_IMAGE = 600;
    const PARAM_ADDITIONAL_TEXT = 700;
    const PARAM_LINK = 800;
    const PARAM_TITLE = 900;
    const PARAM_READ_STRING = 1000;
    const PARAM_VIDEO_LINKS = 1100;

    const PARAM_LABELS = [
        self::PARAM_HTML => 'Html',
        self::PARAM_GROUP => 'Group',
        self::PARAM_ELEMENTS_QUANT => 'Elements quantity',
        self::PARAM_PAGES_QUANT => 'Pages quantity',
        self::PARAM_MAIN_TEXT => 'Opening text',
        self::PARAM_BG_IMAGE => 'Background image',
        self::PARAM_ADDITIONAL_TEXT => 'Reference',
        self::PARAM_LINK => 'link',
        self::PARAM_TITLE => 'Title',
        self::PARAM_READ_STRING => 'Read additional text',
        self::PARAM_VIDEO_LINKS => 'Video links',
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
                    self::PARAM_READ_STRING,
                    self::PARAM_MAIN_TEXT,
                    self::PARAM_BG_IMAGE
                ];
            }
            case Widget::WIDGET_QUOTE: {
                return [
                    self::PARAM_MAIN_TEXT,
                    self::PARAM_ADDITIONAL_TEXT
                ];
            }
            case Widget::WIDGET_PREVIEW_PAGE: {
                return [
                    self::PARAM_TITLE,
                    self::PARAM_MAIN_TEXT,
                    self::PARAM_ADDITIONAL_TEXT,
                    self::PARAM_BG_IMAGE,
                    self::PARAM_LINK
                ];  
            }
            case Widget::WIDGET_JOIN_CAUSE: {
                return [
                ];  
            }
            case Widget::WIDGET_DISCOVER: {
                return [
                ];  
            }
            case Widget::WIDGET_BACK_LINK: {
                return [
                ];  
            }
            case Widget::WIDGET_VIDEO_CAROUSEL: {
                return [
                    self::PARAM_VIDEO_LINKS    
                ];  
            }
        }
    }
}
