<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function donations()
    {
        return view('user_panel.donations', ['user' => auth()->user()]);
    }
}
