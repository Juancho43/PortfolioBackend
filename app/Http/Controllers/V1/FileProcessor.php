<?php

namespace App\Http\Controllers\V1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class FileProcessor
{
    public function saveFile(Request $request, $path, $attribute)
    {
        $file = null;
        try {
            if (!$request->hasFile($attribute)) {
                throw new Exception("No file uploaded with attribute: " . $attribute);
            }

            $name = 'file_' . time() . '.' . $request->file($attribute)->getClientOriginalExtension();
            $file = $request->file($attribute)->storeAs($path, $name, 'public');

            if (!$file) {
                throw new Exception("Failed to store file: " . $name);
            }

        } catch (Exception $e) {
            Log::error("File save error: " . $e->getMessage());
        }
        return $file;
    }

    public function deleteFile($oldPath)
    {
        $flag = false;
        try {
            $path_to_delete = str_replace('storage/', '', $oldPath);

            if (!Storage::disk('public')->exists($path_to_delete)) {
                throw new Exception("Failed to find file: " . $oldPath);
            }else{
                $flag =Storage::disk('public')->delete($path_to_delete);
            }

        } catch (Exception $e) {
            Log::error("File delete error: " . $e->getMessage());
        }

        return $flag;

    }
}
