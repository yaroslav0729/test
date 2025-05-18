<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateMedia
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $file = $request->file('file');
        
        // Check file size (max 10MB)
        if ($file->getSize() > 10 * 1024 * 1024) {
            return response()->json(['error' => 'File size exceeds 10MB limit'], 400);
        }

        // Check file type
        $allowedMimes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        if (!in_array($file->getMimeType(), $allowedMimes)) {
            return response()->json(['error' => 'Invalid file type'], 400);
        }

        // For images, validate content
        if (strpos($file->getMimeType(), 'image/') === 0) {
            $imageInfo = getimagesize($file->getPathname());
            if ($imageInfo === false) {
                return response()->json(['error' => 'Invalid image file'], 400);
            }
        }

        return $next($request);
    }
} 