<?php

namespace App\Models;

class Widget
{
    const WIDGET_RICH_TEXT = 100;
    const WIDGET_GROUP_TILES = 200;
    const WIDGET_BLOG_ARTICLE_HEADER = 300;
    const WIDGET_QUOTE = 400;
    const WIDGET_PREVIEW_PAGE = 500;
    const WIDGET_JOIN_CAUSE = 600;
    const WIDGET_DISCOVER = 700;
    const WIDGET_BACK_LINK = 800;
    const WIDGET_VIDEO_CAROUSEL = 900;

    const WIDGET_LABELS = [
        self::WIDGET_RICH_TEXT => 'Rich text',
        self::WIDGET_GROUP_TILES => 'Group tiles',
        self::WIDGET_BLOG_ARTICLE_HEADER => 'Blog article header',
        self::WIDGET_QUOTE => 'Quote',
        self::WIDGET_PREVIEW_PAGE => 'Preview page',
        self::WIDGET_JOIN_CAUSE => 'Join the cause',
        self::WIDGET_DISCOVER => 'Discover more',
        self::WIDGET_BACK_LINK => 'Back link',
        self::WIDGET_VIDEO_CAROUSEL => 'Video carousel',
    ];
}
