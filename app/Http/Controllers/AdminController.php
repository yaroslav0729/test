<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        dd('admin panel');
    }

    // public function test()
    // {
    //     $user = User::where('id',1)->firstOrFail();
    //     $user->syncRoles([User::ROLE_SUPER_ADMIN]);

    //     dd('ok');
    // }
}
