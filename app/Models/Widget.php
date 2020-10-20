<?php

namespace App\Models;

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
}
