<?php

namespace App\Models;

class Widget
{
    const WIDGET_QUOTE = 1;
    const WIDGET_VIDEO_CAROUSEL = 2;

    const ALL_WIDGETS = [
        self::WIDGET_QUOTE,
        self::WIDGET_VIDEO_CAROUSEL,
    ];

    public static function getWidgetName($widget)
    {
        switch ($widget) {
            case self::WIDGET_QUOTE:return 'quote';
            case self::WIDGET_VIDEO_CAROUSEL:return 'video-carousel';
        }
    }

    public static function replaceMonikers($html)
    {
        $widgets = self::findAllWidgets($html);

        foreach ($widgets as $widget) {
            $html = str_replace($widget['code'], $widget['html'], $html);
        }

        return $html;
    }

    private static function findAllWidgets($html)
    {
        $htmlParts = explode('}', $html);
        $widgets = [];

        foreach (self::ALL_WIDGETS as $widgetId) {

            $widgetName = self::getWidgetName($widgetId);
            $widgetStart = "{" . $widgetName . "|";

            foreach ($htmlParts as $part) {
                $pos = strpos($part, $widgetStart);

                if ($pos !== false) {
                    $paramStr = substr($part, $pos + strlen($widgetStart));
                    $widgetParameters = explode('|', $paramStr);
                    $widgetCode = substr($part, $pos) . "}";

                    $widgetHtml = view('widgets.' . $widgetId, [
                        'parameters' => $widgetParameters,
                    ])->render();

                    $widgets[] = [
                        'id' => $widgetId,
                        'code' => $widgetCode,
                        'parameters' => $widgetParameters,
                        'html' => $widgetHtml,
                    ];
                }
            }
        }

        return $widgets;
    }
}
