<?php

namespace App\Http\Controllers\Admin;

use ctf0\MediaManager\App\Controllers\MediaController as MC;
use ctf0\MediaManager\App\Events\MediaFileOpsNotifications;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Locked;

class MediaController extends MC
{
    /**
     * Override getFiles method to add error handling
     */
    // public function getFiles(Request $request)
    // {
    //     try {
    //         $path = $request->path == '/' ? '' : $request->path;
    //         return response()->json([
    //             'locked' => Locked::pluck('path'),
    //             'files' => [
    //                 'path'  => $path,
    //                 'items' => $this->paginate($this->getData($path), config('mediaManager.pagination_amount', 50)),
    //             ],
    //         ]);
        
    //     } catch (Exception $e) {
    //         // Log the error for debugging
    //         Log::error('MediaManager getFiles error: ' . $e->getMessage(), [
    //             'exception' => $e,
    //             'path' => $request->path ?? '/'
    //         ]);
            
    //         // Return a user-friendly error response
    //         return response()->json([
    //             'error' => 'An error occurred while retrieving media files. Please check the logs for details.',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    /**
     * Override upload method to add error handling
     */
    public function upload(Request $request)
    {
        try {
            $upload_path = $request->upload_path;
            $random_name = filter_var($request->random_names, FILTER_VALIDATE_BOOLEAN);
            $result = [];
            $broadcast = false;
            $custom_attr = collect(json_decode($request->custom_attrs));

            foreach ($request->file as $one) {
                try {
                    if ($this->allowUpload($one)) {
                        $one = $this->optimizeUpload($one);
                        $orig_name = $one->getClientOriginalName();
                        $name_only = pathinfo($orig_name, PATHINFO_FILENAME);
                        $ext_only = pathinfo($orig_name, PATHINFO_EXTENSION);
                        $final_name = $random_name
                        ? $this->getRandomString() . ".$ext_only"
                        : $this->cleanName($name_only) . ".$ext_only";

                        $file_options = optional($custom_attr->firstWhere('name', $orig_name))->options;
                        $file_type = $one->getMimeType();
                        $destination = !$upload_path ? $final_name : $this->clearDblSlash("$upload_path/$final_name");

                        try {
                            // check for mime type
                            if (Str::contains($file_type, $this->unallowedMimes)) {
                                throw new Exception(
                                    trans('MediaManager::messages.not_allowed_file_ext', ['attr' => $file_type])
                                );
                            }

                            // check existence
                            if ($this->storageDisk->exists($destination)) {
                                throw new Exception(
                                    trans('MediaManager::messages.error.already_exists')
                                );
                            }

                            // save file
                            $full_path = $this->storeFile($one, $upload_path, $final_name);

                            // fire event
                            event('MMFileUploaded', [
                                'file_path' => $full_path,
                                'mime_type' => $file_type,
                                'options' => $file_options,
                            ]);

                            $broadcast = true;
                            $fileUrl = '';
                            // Use try/catch for URL generation to avoid potential errors
                            try {
                                $fileUrl = Storage::disk('public')->url($final_name);
                            } catch (Exception $e) {
                                Log::warning('Failed to generate URL for file: ' . $final_name, ['exception' => $e]);
                                $fileUrl = '/storage/' . $final_name; // Fallback URL
                            }
                            
                            $result[] = [
                                'success' => true,
                                'file_name' => $final_name,
                                'location' => $fileUrl,
                            ];
                        } catch (Exception $e) {
                            $result[] = [
                                'success' => false,
                                'message' => "\"$final_name\" " . $e->getMessage(),
                            ];
                        }
                    } else {
                        $result[] = [
                            'success' => false,
                            'message' => trans('MediaManager::messages.error.cant_upload'),
                        ];
                    }
                } catch (Exception $e) {
                    Log::error('Error processing upload file: ' . $e->getMessage(), ['exception' => $e]);
                    $result[] = [
                        'success' => false,
                        'message' => 'Error processing file: ' . $e->getMessage(),
                    ];
                }
            }

            // broadcast
            if ($broadcast) {
                try {
                    broadcast(new MediaFileOpsNotifications([
                        'op' => 'upload',
                        'path' => $upload_path,
                    ]))->toOthers();
                } catch (Exception $e) {
                    Log::warning('Broadcasting error: ' . $e->getMessage(), ['exception' => $e]);
                    // Continue execution even if broadcasting fails
                }
            }

            return response()->json($result, 200);
        } catch (Exception $e) {
            Log::error('MediaManager upload error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'error' => 'An error occurred while uploading files. Please check the logs for details.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
