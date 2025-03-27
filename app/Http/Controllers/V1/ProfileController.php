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

/**
 * Profile Controller
 *
 * Handles HTTP requests related to user profiles including CRUD operations
 * and file management (profile images and CV documents).
 */
class ProfileController extends Controller
{
    use ApiResponseTrait;

    /**
     * @var ProfileRepository Repository for profile data access
     */
    protected ProfileRepository $repository;

    /**
     * @var FileProcessor Service for handling file uploads and storage
     */
    protected FileProcessor $fileProcessor;

    /**
     * Initialize controller with required dependencies
     *
     * @param ProfileRepository $profileRepository Repository for profile operations
     * @param FileProcessor $fileProcessor Service for file handling
     */
    public function __construct(ProfileRepository $profileRepository, FileProcessor $fileProcessor)
    {
        $this->repository = $profileRepository;
        $this->fileProcessor = $fileProcessor;
    }

    /**
     * Get all profiles
     *
     * @return JsonResponse Collection of all profiles
     * @throws Exception If error occurs retrieving data
     */
    public function index() : JsonResponse
    {
        try{
            return $this->successResponse($this->repository->all(), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de los perfiles",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get single profile by ID
     *
     * @param mixed $id Profile ID
     * @return JsonResponse Single profile resource
     * @throws Exception If profile not found or error occurs
     */
    public function show(int $id) : JsonResponse
    {
        try{
            return $this->successResponse(new ProfileResource($this->repository->find((int)$id)), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos del perfil",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create new profile
     *
     * @param ProfileRequest $request Validated profile data
     * @return JsonResponse Created profile resource
     * @throws Exception If creation fails
     */
    public function store(ProfileRequest $request) :  JsonResponse
    {
        try{
            $user = $this->repository->create($request);
            return $this->successResponse(new ProfileResource($user),'Resource created successfully',Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error creating the profile",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Save profile image
     *
     * Handles upload of profile photo, manages existing image links,
     * and stores new image in storage.
     *
     * @param Request $request Request containing photo file
     * @param int $id Profile ID
     * @return JsonResponse URL of saved image or error details
     * @throws Exception If image upload/processing fails
     */
    public function saveImg(Request $request, $id) : JsonResponse
    {
        try {
            $profile = $this->repository->find($id);

            if ($request->hasFile('photo_url')) {
                $imageLink = $profile->links()->where('name', 'photo_url')->first();
                $oldPath = $imageLink ? $imageLink->link : null;

                $file = $this->fileProcessor->saveFile($request, 'images', 'photo_url');
                $fileUrl = Storage::url($file);

                if ($imageLink) {
                    $this->fileProcessor->deleteFile($oldPath);
                    $imageLink->link = $fileUrl;
                    $imageLink->save();
                } else {
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

    /**
     * Save CV document
     *
     * Handles upload of CV file, manages existing CV links,
     * and stores new document in storage.
     *
     * @param Request $request Request containing CV file
     * @param int $id Profile ID
     * @return JsonResponse URL of saved CV or error details
     */
    public function saveCv(Request $request,int $id) : JsonResponse
    {
        $profile = $this->repository->find($id);
        if ($request->hasFile('cv')) {
            $cvLink = $profile->links()->where('name', 'cv')->first();
            $oldPath = $cvLink ? $cvLink->link : null;

            $file = $this->fileProcessor->saveFile($request, 'files', 'cv');
            $fileUrl = Storage::url($file);

            if ($cvLink) {
                $this->fileProcessor->deleteFile($oldPath);
                $cvLink->link = $fileUrl;
                $cvLink->save();
            } else {
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

    /**
     * Update existing profile
     *
     * @param ProfileRequest $request Validated profile data
     * @return Profile|JsonResponse Updated profile or error response
     * @throws Exception If update fails
     */
    public function update(ProfileRequest $request) : Profile | JsonResponse
    {
        try{
            $user = $this->repository->update($request->id,$request);
            return $this->successResponse(new ProfileResource($user),'Resource updated successfully',Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error updating the profile",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete profile
     *
     * @param int $id Profile ID to delete
     * @return JsonResponse Empty response on success
     * @throws Exception If deletion fails
     */
    public function destroy(int $id) : JsonResponse
    {
        try{
            $this->repository->delete($id);
            return $this->successResponse(null, "Datos eliminados correctamente", Response::HTTP_NO_CONTENT);
        }catch(Exception $e){
            return $this->errorResponse("Error al eliminar los datos del perfil",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
