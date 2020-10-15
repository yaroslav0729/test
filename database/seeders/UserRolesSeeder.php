<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

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
        foreach (User::ROLES_LABEL as $roleKey => $role) {
            $roleExists = DB::table('roles')->where('name', $roleKey)->get();
            
            if (!count($roleExists)) {
                Role::create(['name' => $roleKey]);
            }
        }
        
        //Role::create(['name' => User::ROLE_SUPER_ADMIN]);
        //Role::create(['name' => User::ROLE_ADMIN]);
        //Role::create(['name' => User::ROLE_EDITOR]);
        //Role::create(['name' => User::ROLE_SUBSCRIBER]);
        //Role::create(['name' => User::ROLE_VISITOR]);
    }
}
