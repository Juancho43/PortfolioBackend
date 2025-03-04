<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Link;
use App\Repository\V1\ProfileRepository;
use App\Http\Controllers\V1\FileProcessor;
use App\Http\Resources\V1\ProfileResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

use Exception;
class ProfileController extends Controller
{
    use ApiResponseTrait;
    protected $repository;
    protected $fileProcessor;

    public function __construct(ProfileRepository $profileRepository, FileProcessor $fileProcessor)
    {
        $this->repository = $profileRepository;
        $this->fileProcessor = $fileProcessor;
    }


    public function index()
    {
        try{
            return $this->successResponse($this->repository->all(), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de los perfiles",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    public function show($id)
    {
        try{
            return $this->successResponse(new ProfileResource($this->repository->find($id)), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos del perfil",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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


    public function saveImg(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        if ($request->hasFile('photo_url')) {
            // Buscar si ya existe un link de imagen
            $imageLink = $profile->links()->where('name', 'photo_url')->first();
            $oldPath = $imageLink ? $imageLink->link : null;

            // Guardar el nuevo archivo
            $file = $this->fileProcessor->saveFile($request, 'images', 'photo_url');
            $fileUrl = Storage::url($file);

            if ($imageLink) {
                // Actualizar el link existente
                $imageLink->link = $fileUrl;
                $imageLink->save();
            } else {
                // Crear un nuevo link
                $newLink = Link::create([
                    'name' => 'photo_url',
                    'link' => $fileUrl
                ]);
                $profile->links()->attach($newLink->id);
            }
        }

        return response()->json([
            'message' => 'Image created successfully',
            'IMG' => $imageLink->link ?? $fileUrl ?? null
        ]);
    }

    /**
     * Guardar o actualizar el CV del perfil
     */
    public function saveCv(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        if ($request->hasFile('cv')) {
            // Buscar si ya existe un link de CV
            $cvLink = $profile->links()->where('name', 'cv')->first();

            // Guardar el nuevo archivo
            $file = $this->fileProcessor->saveFile($request, 'files', 'cv');
            $fileUrl = Storage::url($file);

            if ($cvLink) {
                // Actualizar el link existente
                dump($cvLink->link);
                $this->fileProcessor->deleteFile($cvLink->link);

                $cvLink->link = $fileUrl;
                dump($cvLink->link);
                $cvLink->save();
            } else {
                // Crear un nuevo link
                $newLink = Link::create([
                    'name' => 'cv',
                    'link' => $fileUrl
                ]);
                $profile->links()->attach($newLink->id);
            }
        }

        return response()->json([
            'message' => 'Cv saved successfully',
            'CV' => $cvLink->link ?? $fileUrl ?? null
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
        try{
            $this->repository->delete($id);
            return $this->successResponse(null, "Datos eliminados correctamente", Response::HTTP_NO_CONTENT);
        }catch(Exception $e){
            return $this->errorResponse("Error al eliminar los datos del perfil",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
