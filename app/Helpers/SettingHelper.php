<?php


namespace App\Helpers;


use App\Models\SettingRecord;
use Illuminate\Support\Facades\Schema;

class SettingHelper
{
    const VIDEO_LINK_ON_MAIN_MENU = 100;
    const ZAKAT_FIT_CAMPAIGN_CATEGORY = 101;
    const REGISTERED_CHARITY_NUMBER = 102;
    const COMPANY_NUMBER = 103;
    const WRAPPER_FOR_VIDEO_ON_MAIN_MENU = 104;
    const VIDEO_ON_MAIN_MENU_TEXT = 105;


    /**
     * @return string[]
     */
    public static function listArray(): array
    {
        return [
            self::VIDEO_LINK_ON_MAIN_MENU => 'Link to a video for the Main menu',
            self::WRAPPER_FOR_VIDEO_ON_MAIN_MENU => 'Picture for facade on the video',
            self::VIDEO_ON_MAIN_MENU_TEXT => 'Text on the youtube video block',
            self::ZAKAT_FIT_CAMPAIGN_CATEGORY => 'Which Campaign category fit Zakat',
            self::REGISTERED_CHARITY_NUMBER => 'Register Charity Number',
            self::COMPANY_NUMBER => 'Company Number',
        ];
    }

    /**
     * @return string[]
     */
    public static function namesArray(): array
    {
        return [
            self::VIDEO_LINK_ON_MAIN_MENU => 'videoLinks',
            self::WRAPPER_FOR_VIDEO_ON_MAIN_MENU => 'wrapperVideo',
            self::VIDEO_ON_MAIN_MENU_TEXT => 'textYouTubeVideo',
            self::ZAKAT_FIT_CAMPAIGN_CATEGORY => 'whichCategoryFitZakat',
            self::REGISTERED_CHARITY_NUMBER => 'registerNumber',
            self::COMPANY_NUMBER => 'companyNumber',
        ];
    }

    /**
     * @param int $type
     * @param mixed $value
     * @return bool
     */
    public static function set(int $type, $value)
    {
        if (!$setting = SettingRecord::where('type', $type)->first()) {
            $setting = new SettingRecord();
            $setting->type = $type;
        }
        $setting->value = $value;

        return $setting->save();
    }


    /**
     * @param int $type
     * @return string|null
     */
    public static function get(int $type): ?string
    {
        if (!Schema::hasTable('setting_records')) {
            return null;
        }

        if ($setting = SettingRecord::where('type', $type)->first()) {
            return $setting->value;
        }

        return null;
    }


    /**
     * @param string $name
     * @return int|null
     */
    public static function getTypeByName(string $name): ?int
    {
        if (in_array($name, self::namesArray())) {
            return array_search($name, self::namesArray());
        }

        return null;
    }

    /**
     * @param int $type
     * @return string|null
     */
    public static function name(int $type): ?string
    {
        return self::listArray()[$type] ?? null;
    }

    /**
     * @param int $type
     * @return string|null
     */
    public static function nameShort(int $type): ?string
    {
        return self::namesArray()[$type] ?? null;
    }

    public static function saveSetting(array $data)
    {
        foreach ($data as $settingName => $newValue) {
            if ($type = self::getTypeByName($settingName)) {
                $setting = SettingRecord::firstOrCreate(['type' => $type]);
                $setting->value = $newValue;
                $setting->type = $type;
                $setting->save();
            }
        }
    }
}
