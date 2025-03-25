<?php
namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\ProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Link;
use App\Repository\V1\ProfileRepository;
use App\Http\Resources\V1\ProfileResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

use Exception;
class ProfileController extends Controller
{
    use ApiResponseTrait;
    protected ProfileRepository $repository;
    protected FileProcessor $fileProcessor;

    public function __construct(ProfileRepository $profileRepository, FileProcessor $fileProcessor)
    {
        $this->repository = $profileRepository;
        $this->fileProcessor = $fileProcessor;
    }

    public function index() : JsonResponse
    {
        try{
            return $this->successResponse($this->repository->all(), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de los perfiles",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    public function show($id) : JsonResponse
    {
        try{
            return $this->successResponse(new ProfileResource($this->repository->find((int)$id)), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos del perfil",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function store(ProfileRequest $request) :  JsonResponse
    {
        try{
            $user = $this->repository->create($request);
            return $this->successResponse(new ProfileResource($user),'Resource created successfully',Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error creating the profile",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function saveImg(Request $request, $id) : JsonResponse
    {
        try {
            $profile = $this->repository->find($id);

            if ($request->hasFile('photo_url')) {
                // Buscar si ya existe un link de imagen
                $imageLink = $profile->links()->where('name', 'photo_url')->first();
                $oldPath = $imageLink ? $imageLink->link : null;

                // Guardar el nuevo archivo
                $file = $this->fileProcessor->saveFile($request, 'images', 'photo_url');
                $fileUrl = Storage::url($file);

                if ($imageLink) {
                    $this->fileProcessor->deleteFile($oldPath);
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
                return $this->successResponse($fileUrl, "Post successfully", Response::HTTP_OK);
        }catch (Exception $e) {
            return $this->errorResponse("Error al cargar la imagen", $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    public function saveCv(Request $request, $id) : JsonResponse
    {
        $profile = $this->repository->find($id);
        if ($request->hasFile('cv')) {
            // Buscar si ya existe un link de CV
            $cvLink = $profile->links()->where('name', 'cv')->first();
            $oldPath = $cvLink ? $cvLink->link : null;
            // Guardar el nuevo archivo
            $file = $this->fileProcessor->saveFile($request, 'files', 'cv');
            $fileUrl = Storage::url($file);

            if ($cvLink) {
                // Actualizar el link existente
                $this->fileProcessor->deleteFile($oldPath);
                $cvLink->link = $fileUrl;
                $cvLink->save();

            } else {
                // Crear un nuevo link
                $newLink = Link::create([
                    'name' => 'cv',
                    'link' => $fileUrl
                ]);
                $profile->links()->attach($newLink->id);
            }
            return $this->successResponse($fileUrl, "Post successfully", Response::HTTP_OK);
        }
        return $this->errorResponse("Error al cargar el cv", 'No hay un archivo',Response::HTTP_BAD_REQUEST);

    }
    public function update(ProfileRequest $request) : Profile | JsonResponse
    {
        try{
            $user = $this->repository->update($request->id,$request);
            return $this->successResponse(new ProfileResource($user),'Resource updated successfully',Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error updating the profile",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function destroy($id) : JsonResponse
    {
        try{
            $this->repository->delete($id);
            return $this->successResponse(null, "Datos eliminados correctamente", Response::HTTP_NO_CONTENT);
        }catch(Exception $e){
            return $this->errorResponse("Error al eliminar los datos del perfil",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
