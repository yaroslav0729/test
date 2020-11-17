<?php

namespace Database\Seeders;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class=CountriesSeeder
     * 
     * @return void
     */
    public function run()
    {
        foreach (Country::All_COUNTRIES as $countryKey => $country) {
            $countryExists = DB::table('countries')->where('name', $country)->get();
            
            if (!count($countryExists)) {
                Country::create(['name' => $country]);
            }
        }
    }
}
