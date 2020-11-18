<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\PageInstance;

class SettingsController extends Controller
{
    public function index()
    {
        $indexPage = PageInstance::where('template', Template::INDEX_PAGE)->actual()->first();
        $projectsPage = PageInstance::where('template', Template::PROJECTS_PAGE)->actual()->first();

        return view('admin.settings.index', [
            'indexPage' => $indexPage,
            'projectsPage' => $projectsPage
        ]);
    }
}
