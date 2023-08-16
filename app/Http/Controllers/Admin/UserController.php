<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $users = new User;

        if (!empty($keyword)) {
            $users = $users->where('email', 'like', '%' . $keyword . '%')
                ->orWhere('name', 'like', '%' . $keyword . '%')
                ->orWhere('last_name', 'like', '%' . $keyword . '%');
        }

        $users = $users->paginate(10);
        return view('admin.user.index', ['users' => $users, 'keyword' => $keyword]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = User::getRoles();
        return view('admin.user.edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        //$user->update($request->all());

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

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.show', compact('user'));
    }
}
