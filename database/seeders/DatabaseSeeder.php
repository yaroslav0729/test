<?php

namespace Database\Seeders;

use Database\Seeders\UserRolesSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * php artisan db:seed
     * 
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            UserRolesSeeder::class,
            IndexPageSeeder::class,
            CountriesSeeder::class,
            ProjectsPageSeeder::class
        ]);
    }
}
