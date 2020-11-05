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
}
