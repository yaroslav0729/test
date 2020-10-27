<?php

namespace App\Models;
use App\Models\Widget;

class WidgetParameters
{
    const PARAM_HTML = 100;
    const PARAM_GROUP = 200;
    const PARAM_ELEMENTS_QUANT = 300;
    const PARAM_PAGES_QUANT = 400;

    const PARAM_LABELS = [
        self::PARAM_HTML => 'html',
        self::PARAM_GROUP => 'group',
        self::PARAM_ELEMENTS_QUANT => 'elements quantity',
        self::PARAM_PAGES_QUANT => 'pages quantity',
    ];

    const AVAILABLE_PARAMETERS = [
        Widget::WIDGET_RICH_TEXT => [
            self::PARAM_HTML    
        ],
        Widget::WIDGET_GROUP_TILES => [
            self::PARAM_GROUP,
            self::PARAM_ELEMENTS_QUANT,
            self::PARAM_PAGES_QUANT    
        ]
    ];
}
