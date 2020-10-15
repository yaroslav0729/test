<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class=UserRolesSeeder
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => User::ROLE_SUPER_ADMIN]);
        Role::create(['name' => User::ROLE_ADMIN]);
        Role::create(['name' => User::ROLE_EDITOR]);
        //Role::create(['name' => User::ROLE_SUBSCRIBER]);
        //Role::create(['name' => User::ROLE_VISITOR]);
    }
}
