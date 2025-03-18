<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\TagRequest;
use App\Http\Resources\V1\TagResource;
use App\Http\Resources\V1\TagResourceCollection;
use App\Repository\V1\TagRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Exception;

/**
 * Class TagsController
 * @package App\Http\Controllers\V1
 *
 * Controller to manage CRUD operations for tags.
 */
class TagsController extends Controller
{
    use ApiResponseTrait;

    /**
     * @var TagRepository
     */
    protected TagRepository $repository;

    /**
     * TagsController constructor.
     *
     * @param TagRepository $repository
     */
    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;

    }

    /**
     * Displays a list of all tags.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        try{
            return $this->successResponse(new TagResourceCollection($this->repository->all()),null,Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error retrieving tag data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Displays the details of a specific tag.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        try{
            return $this->successResponse(new TagResource($this->repository->find($id)),null,Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error retrieving tag data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Stores a new tag in the database.
     *
     * @param TagRequest $request
     * @return JsonResponse
     */
    public function store(TagRequest $request) : JsonResponse
    {
        try{
            $tag = $this->repository->create($request);
            return $this->successResponse(new TagResource($tag),"Resource created successfully",Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error saving the tag data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Updates a specific tag in the database.
     *
     * @param TagRequest $request
     * @return JsonResponse
     */
    public function update(TagRequest $request) : JsonResponse
    {
        try{
            $tag = $this->repository->update($request->id,$request);
            return $this->successResponse(new TagResource($tag),'Resource updated successfully',Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error updating the tag data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Deletes a specific tag from the database.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id) : JsonResponse
    {
        try{
            $this->repository->delete($id);
            return $this->successResponse(null, "Data deleted successfully", Response::HTTP_NO_CONTENT);
        }catch(Exception $e){
            return $this->errorResponse("Error deleting tag data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
