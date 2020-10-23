<?php

namespace App\Models;

use App\Models\WidgetParameters;

class Widget
{
    const WIDGET_RICH_TEXT = 100;
    const WIDGET_GROUP_TILES = 200;

    const WIDGET_LABELS = [
        self::WIDGET_RICH_TEXT => 'Rich text',
        self::WIDGET_GROUP_TILES => 'Group tiles',
    ];

    static public function renderId($id) {
        return view('widgets.' . $id, ['parameters' => []]);
    }

    const AVAILABLE_PARAMETERS = [
        self::WIDGET_RICH_TEXT => [
            WidgetParameters::PARAM_ENABLED,
            WidgetParameters::PARAM_DATA
        ],
        self::WIDGET_GROUP_TILES => [
            WidgetParameters::PARAM_COLOR    
        ]
    ];
}
