<?php

namespace App\Helpers;

class RegexHelper
{
    public static function isMatch(string $pattern, string $value)
    {
        return preg_match($pattern, $value);
    }

    public static function isEmail(string $value)
    {
        $emailPattern = '/^\S+@\S+\.\S+$/';

        return self::isMatch($emailPattern, $value);
    }

    public static function isTelephone(string $value)
    {
        $phonePattern = '/^(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/';
        
        return self::isMatch($phonePattern, $value);
    }
}