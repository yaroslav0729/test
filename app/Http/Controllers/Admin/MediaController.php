<?php

namespace App\Http\Controllers\Admin;

use ctf0\MediaManager\App\Controllers\MediaController as MC;
use ctf0\MediaManager\App\Events\MediaFileOpsNotifications;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends MC
{

    public function upload(Request $request)
    {
        $upload_path = $request->upload_path;
        $random_name = filter_var($request->random_names, FILTER_VALIDATE_BOOLEAN);
        $result = [];
        $broadcast = false;
        $custom_attr = collect(json_decode($request->custom_attrs));

        foreach ($request->file as $one) {

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
                    $result[] = [
                        'success' => true,
                        'file_name' => $final_name,
                        'location' => Storage::disk('public')->url($final_name),
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
        }

        // broadcast
        if ($broadcast) {
            broadcast(new MediaFileOpsNotifications([
                'op' => 'upload',
                'path' => $upload_path,
            ]))->toOthers();
        }

        return response()->json($result, 200);
    }
}
