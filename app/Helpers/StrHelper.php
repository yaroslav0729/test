<?php


namespace App\Helpers;


use Illuminate\Support\Str;

class StrHelper
{
    /**
     * Modify string add span with class $className
     *
     * @param string $string
     * @param string $className
     * @return string
     */
    public static function addSpanWithClass(string $string, string $className)
    {
        if (!Str::containsAll($string, ['[', ']'])) {
            return $string;
        }
        $strBetween = "<span class={$className}>" . Str::between($string, '[', ']') . "</span>";

        return Str::before($string, '[') . $strBetween . Str::after($string, ']');
    }

    public static function lengthLimit($str, $limit)
    {
        if (strlen($str) > $limit) {
            return mb_substr($str, 0, $limit) . '...';
        } else {
            return $str;
        }
    }

    public static function deleteTrailingSlash($str)
    {
        $lastSym = substr($str, -1);

        if ($lastSym === '/') {
            $str = substr_replace($str, "", -1);
        }
        return $str;
    }

    public static function replaceSpecChars($str)
    {
        $str = str_replace('&#8217;', '’', $str);
        return $str;
    }

}
