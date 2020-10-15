<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', ['users' => $users]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = User::getRoles();
        return view('admin.users.edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        if ($request->input('role') !== 'user') {
            $user->syncRoles([$request->input('role')]);
        } else {
            $user->syncRoles([]);
        }

        return redirect()->route('admin.index')->with('status', 'Profile updated!');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.index')->with('status', 'User deleted!');
    }

    // public function test()
    // {
    //     $user = User::where('id',1)->firstOrFail();
    //     $user->syncRoles([User::ROLE_SUPER_ADMIN]);

    //     dd('ok');
    // }
}
