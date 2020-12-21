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
            'facebook' => 'fab fa-facebook-f',
            'instagram' => 'fab fa-instagram',
            'youtube' => 'fab fa-youtube',
            'twitter' => 'fab fa-twitter'
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