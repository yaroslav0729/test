<?php

namespace App\Models;

class WidgetParameters
{
    const PARAM_ENABLED = 'enabled';
    const PARAM_COLOR = 'color';
    const PARAM_DATA = 'data';
    const PARAM_WIDTH = 'width';
    const PARAM_HEIGHT = 'height';

    const PARAM_TYPE_DROPDOWN = 'dropdown';
    const PARAM_TYPE_INPUT_STRING = 'input string';
    const PARAM_TYPE_TEXT = 'text';
    const PARAM_TYPE_BOOLEAN = 'boolean';
    const PARAM_TYPE_DIGIT = 'digit';

    const PARAMS = [
        self::PARAM_ENABLED => [
            'name' => self::PARAM_ENABLED,
            'type' => self::PARAM_TYPE_BOOLEAN,
        ],
        self::PARAM_COLOR => [
            'name' => self::PARAM_COLOR,
            'type' => self::PARAM_TYPE_INPUT_STRING,
        ],
        self::PARAM_DATA => [
            'name' => self::PARAM_DATA,
            'type' => self::PARAM_TYPE_TEXT,
        ],
        self::PARAM_WIDTH => [
            'name' => self::PARAM_WIDTH,
            'type' => self::PARAM_TYPE_DIGIT,
        ],
        self::PARAM_HEIGHT => [
            'name' => self::PARAM_HEIGHT,
            'type' => self::PARAM_TYPE_DIGIT,
        ],
    ];
}
