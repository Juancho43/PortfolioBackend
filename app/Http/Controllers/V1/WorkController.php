<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\WorkRequest;
use App\Http\Resources\V1\WorkResourceCollection;
use App\Http\Resources\V1\WorkResource;
use App\Repository\V1\WorkRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class WorkController
 * @package App\Http\Controllers\V1
 *
 * Controller to manage CRUD operations for works.
 */
class WorkController
{

    use ApiResponseTrait;
    /**
     * @var WorkRepository
     */
    protected WorkRepository $repository;


    /**
     * WorkController constructor.
     *
     * @param WorkRepository $repository
     */
    public function __construct(WorkRepository $repository)
    {
        $this->repository = $repository;

    }

    /**
     * Displays a list of all works.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        try{
            return $this->successResponse(new WorkResourceCollection($this->repository->all()),null,Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error retrieving work data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Displays the details of a specific work.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        try{
            return $this->successResponse(new WorkResource($this->repository->find($id)),null,Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error retrieving work data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Stores a new work in the database.
     *
     * @param WorkRequest $request
     * @return JsonResponse
     */
    public function store(WorkRequest $request) : JsonResponse
    {
        try{
            $work = $this->repository->create($request);
            return $this->successResponse(new WorkResource($work),"Resource created successfully",Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error saving the work data.",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a specific work in the database.
     *
     * @param WorkRequest $request
     * @return JsonResponse
     */
    public function update(WorkRequest $request) : JsonResponse
    {
        try{
            $work = $this->repository->update($request->id,$request);
            return $this->successResponse(new WorkResource($work),'Resource updated successfully',Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error updating the work",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a specific work from the database.
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
            return $this->errorResponse("Error deleting the work data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get works by tag ID
     *
     * Retrieves a collection of works that are associated with the specified tag.
     * Returns the works wrapped in a WorkResourceCollection as a JSON response.
     *
     * @param int $id The ID of the tag to filter works by
     * @return JsonResponse Returns a JSON response containing:
     *                      - On success: Collection of works with HTTP 200
     *                      - On failure: Error message with HTTP 500
     * @throws Exception When tag not found or error occurs during retrieval
     */
    public function getByTag(int $id) : JsonResponse
    {
        try{
            return $this->successResponse(new WorkResourceCollection($this->repository->getWorksByTag($id)),null,Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error retrieving work data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
