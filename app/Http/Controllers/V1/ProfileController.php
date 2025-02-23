<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Repository\V1\ProfileRepository;
use App\Http\Controllers\V1\FileProcessor;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    protected $profileRepository;
    protected $fileProcessor;

    public function __construct(ProfileRepository $profileRepository, FileProcessor $fileProcessor)
    {
        $this->profileRepository = $profileRepository;
        $this->fileProcessor = $fileProcessor;
    }


    public function index()
    {
        $Profile = $this->profileRepository->all();

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
        $Profile->save();

        return response()->json([
            'message' => 'Profile created successfully',
            'Profile' => $Profile
        ]);
    }


    public function saveImg(Request $request, $id){
        echo $request->hasFile('photo_url');
        $Profile = Profile::find($id);
        if($request->hasFile('photo_url')){
            $file = $this->fileProcessor->saveFile($request, 'images', $Profile->photo_url, 'photo_url');
            $Profile->photo_url = Storage::url($file);
            $Profile->save();
        }

        return response()->json([
            'message' => 'Image created successfully',
            'IMG' => $file
        ]);
    }


    public function saveCv(Request $request, $id){
        $Profile = Profile::find($id);
        if($request->hasFile('cv')){
            $file = $this->fileProcessor->saveFile($request, 'files', $Profile->cv, 'cv');
            $Profile->cv = Storage::url($file);
            $Profile->save();
        }

        return response()->json([
            'message' => 'Cv saved successfully',
            'CV' => $file
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
