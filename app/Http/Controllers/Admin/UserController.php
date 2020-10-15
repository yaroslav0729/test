<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.index', ['users' => $users]);
    }

    public function edit($id)
    {
        $users = User::paginate(10);
        dd('user '. $id);
    }


    // public function test()
    // {
    //     $user = User::where('id',1)->firstOrFail();
    //     $user->syncRoles([User::ROLE_SUPER_ADMIN]);

    //     dd('ok');
    // }
}
