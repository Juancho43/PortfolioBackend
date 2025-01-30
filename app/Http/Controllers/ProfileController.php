<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Repository\ProfileRepository;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{

    protected $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }


    public function index()
    {
        $Profile = $this->profileRepository->all();
        // $Profile = Profile::all();
        return response()->json([
            'Profile' => $Profile
        ]);
    }

    public function show($id)
    {
        $Profile = $this->profileRepository->find($id);

        
        // $Profile = Profile::find($id);
        return response()->json([
            'Profile' => $Profile
        ]);
    }


    
    public function store(Request $request)
    {
        $Profile = new Profile;

        $Profile->name = $request->input('name');
        $Profile->rol = $request->input('rol');
        $Profile->description = $request->input('description');
        $Profile->github = $request->input('github');
        $Profile->linkedin = $request->input('linkedin');
        $Profile->publicMail = $request->input('publicMail');
        $Profile->user_id = 1;
        $Profile->photo_url = 'photo_url';
        $Profile->save();
        
        

        return response()->json([
            'message' => 'Profile created successfully',
            'Profile' => $Profile
        ]);
    }


    public function saveImg(Request $request, $id){
        $Profile = Profile::find($id);
        if($request->hasFile('photo_url')){
            $oldImagePath = $Profile->photo_url;

            // 2. Borrar la imagen antigua (si existe)
            if ($oldImagePath) {
                // Extraer la parte de la ruta relativa al disco publico, eliminando "storage/"
                $path_to_delete = str_replace(asset('storage/'), '', $oldImagePath);
                if (Storage::disk('public')->exists($path_to_delete)) {
                    Storage::disk('public')->delete($path_to_delete);
                } else {
                    // Log or report the error: the file does not exist
                    \Log::warning("Old image not found: " . $path_to_delete);
                }
            }
    
            // Guardar archivo en el directorio 'images'
            $name = 'profile_image_' . time() .'.'. $request->file('photo_url')->getClientOriginalExtension();
            $file = $request->file('photo_url')->storeAs('images',$name,'public');

            $Profile->photo_url = Storage::url($file);
            $Profile->save();    
        };

        return response()->json([
            'message' => 'Image created successfully',
            'IMG' => $file
        ]);
    }

    public function update(Request $request, $id)
    {



        $Profile = Profile::find($id);
        
        $Profile->update($request->validate([
            'name' => 'required|string', 
            'rol' => 'required|string',
            'description' => 'required|string',
            'github' => 'nullable|string', 
            'linkedin' => 'nullable|string', 
            'publicMail' => 'nullable|string', 
        ]));
    
        // 3. (Optional) Handle Image Upload 
        if ($request->hasFile('photo_url')) { 
            // ... (Your image upload logic here, as shown in previous examples) ...
        }
        
        
        // $Profile->save();
        // if($request->hasFile('photo_url')){
        //     $name = $Profile->id . '.' . $request->file('photo_url')->getClientOriginalExtension();
        //     $img = $request->file('photo_url')->storeAs('public/img/profile/',$name);
        //     $Profile->photo_url = "/img/".$name;
        //     // $Profile->save();    
        // }
        

        

        return response()->json([
            'message' => 'Profile edited successfully',
            'Profile' => $Profile
        ]);
    }

    public function destroy($id)
    {
        $task = Profile::find($id);

        $task->delete();

        return response()->json([
            'message' => 'Profile deleted successfully'
        ]);
    }
}
