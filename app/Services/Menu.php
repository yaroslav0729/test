<?php

namespace App\Services;

use App\Models\MenuItem;

class Menu
{
    public function isMenuAdditional($destination)
    {
        return in_array($destination, [
            MenuItem::ADDITIONAL_HEADER_MENU,
            MenuItem::ADDITIONAL_FOOTER_MENU,
            MenuItem::SOCIAL_MENU
        ]);
    }

    public function getSocialIcons()
    {
        return collect([
            'facebook' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.378 14.192 5 15.115 5H18V0h-3.808C10.596 0 9 1.583 9 4.615V8z"/></svg>',
            'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20"><path d="M352 0H160C71.648 0 0 71.648 0 160v192c0 88.352 71.648 160 160 160h192c88.352 0 160-71.648 160-160V160C512 71.648 440.352 0 352 0zm112 352c0 61.76-50.24 112-112 112H160c-61.76 0-112-50.24-112-112V160C48 98.24 98.24 48 160 48h192c61.76 0 112 50.24 112 112v192z"/><path d="M256 128c-70.688 0-128 57.312-128 128s57.312 128 128 128 128-57.312 128-128-57.312-128-128-128zm0 208c-44.096 0-80-35.904-80-80 0-44.128 35.904-80 80-80s80 35.872 80 80c0 44.096-35.904 80-80 80z"/><circle cx="393.6" cy="118.4" r="17.056"/></svg>',
            'youtube' => '<i class="fab fa-youtube"></i>',
            'twitter' => '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path d="M24 4.557a9.83 9.83 0 01-2.828.775 4.932 4.932 0 002.165-2.724 9.864 9.864 0 01-3.127 1.195 4.916 4.916 0 00-3.594-1.555c-3.179 0-5.515 2.966-4.797 6.045A13.978 13.978 0 011.671 3.149a4.93 4.93 0 001.523 6.574 4.903 4.903 0 01-2.229-.616c-.054 2.281 1.581 4.415 3.949 4.89a4.935 4.935 0 01-2.224.084 4.928 4.928 0 004.6 3.419A9.9 9.9 0 010 19.54a13.94 13.94 0 007.548 2.212c9.142 0 14.307-7.721 13.995-14.646A10.025 10.025 0 0024 4.557z"/></svg>'
        ]);
    }

    public function getPredefinedTextValuesList($destination)
    {
        switch ($destination) {
            case MenuItem::SOCIAL_MENU:
                return [
                    'facebook' => 'Facebook',
                    'instagram' => 'Instagram',
                    'youtube' => 'Youtube',
                    'twitter' => 'Twitter'
                ];
            default:
                return [];
        }
    }

    public function getSlug($destination) {
        return MenuItem::ALL_SLUG_MENU[$destination] ?? null;
    }

    public function getMenuDestination($slug)
    {
        return array_flip(MenuItem::ALL_SLUG_MENU)[$slug] ?? null;
    }

    public function getMenuName($destination)
    {
        return MenuItem::ALL_TYPES_MENU[$destination];
    }

    public function getMenuItemsByDestination($destination)
    {
        return MenuItem::ordered()->parentless()->destination($destination)->get();
    }

    public function getMenuItemsByParent($parentId)
    {
        return MenuItem::ordered()->parent($parentId)->with('parent')->get();
    }
}