<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function getPopupOptions($id)
    {
        $projectOptions = \App\Models\Project::getProjectOptions($id);
        
        return response()->json([
            'message' => 'Success',
            'success' => true,
            'popup_options' => $projectOptions,
        ]);  
    }
}
