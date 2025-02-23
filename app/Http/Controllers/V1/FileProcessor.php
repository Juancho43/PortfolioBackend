<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;    
class FileProcessor 
{
    public function saveFile(Request $request, $path, $oldPath, $attribute)
    {
        
        if ($oldPath) {
            // Extraer la parte de la ruta relativa al disco publico, eliminando "storage/"
            $path_to_delete = str_replace(asset('storage/'), '', $oldPath);
            if (Storage::disk('public')->exists($path_to_delete)) {
                Storage::disk('public')->delete($path_to_delete);
            } else {
                // Log or report the error: the file does not exist
                Log::warning("Old image not found: " . $path_to_delete);
            }
        }
        $name = 'file_' . time() .'.'. $request->file($attribute)->getClientOriginalExtension();
        
        $file = $request->file($attribute)->storeAs($path,$name,'public');

        return $file;
        
    }
}