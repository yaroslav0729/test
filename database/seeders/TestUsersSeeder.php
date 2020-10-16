<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class=TestUsersSeeder
     * 
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i< 20; $i++) {

            $user = new User;
            $user->name = Str::random(10);
            $user->email = Str::random(10).'@gmail.com';
            $user->password = Hash::make('password');
            $user->save();
        }
    }
}
