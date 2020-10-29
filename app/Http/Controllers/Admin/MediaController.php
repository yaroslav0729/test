<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use ctf0\MediaManager\App\Controllers\MediaController as MC;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use ctf0\MediaManager\App\Events\MediaFileOpsNotifications;

class MediaController extends MC
{
    public function showForm()
    {
        return view('test');
    }
}
