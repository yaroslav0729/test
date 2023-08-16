<?php

namespace Database\Seeders;

use App\Models\CampaignCategory;
use App\Models\FoodPacksQurbaniesType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodPackQurbaniTypesSeeder extends Seeder
{
    const ALL_TYPES = [
        'Cow' => '',
        'Goat' => '',
    ];

    public function run()
    {
        foreach (self::ALL_TYPES as $name => $icon) {
            $typeExists = DB::table('food_packs_qurbanies_types')->where('name', $name)->get();

            if (!count($typeExists)) {
                FoodPacksQurbaniesType::create(['name' => $name, 'icon' => $icon]);
            }
        }
    }
}
