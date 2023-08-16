<?php

namespace Database\Seeders;

use App\Models\CampaignCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class=CampaignCategoriesSeeder
     *
     * @return void
     */

    const All_CATEGORIES = [
        'Donation',
        'Sadaqa',
        'Fitrana',
        'Zakat',
        'Fidya',
        'Kaffara',
        'Interest',
        'Qurbani',
        'Sadaqa Qurbani',
        'Aqeeqa',
        'Lillah',
    ];

    public function run()
    {
        foreach (self::All_CATEGORIES as $key => $category) {
            $categExists = DB::table('campaign_categories')->where('name', $category)->get();

            if (!count($categExists)) {
                CampaignCategory::create(['name' => $category]);
            }
        }
    }
}
