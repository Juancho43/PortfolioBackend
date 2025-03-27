<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\ProjectRequest;
use Illuminate\Http\JsonResponse;
use App\Repository\V1\ProjectRepository;
use App\Http\Resources\V1\ProjectResource;
use App\Http\Resources\V1\ProjectResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use Exception;

/**
 * Class ProjectController
 * @package App\Http\Controllers\V1
 *
 * Controller to manage CRUD operations for projects.
 */
class ProjectController extends Controller
{

    use ApiResponseTrait;

    /**
     * @var ProjectRepository
     */
    protected ProjectRepository $repository;


    /**
     * ProjectController constructor.
     *
     * @param ProjectRepository $repository
     */
    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Displays a list of all projects.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        try{
            return $this->successResponse(new ProjectResourceCollection($this->repository->all()), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error retrieving data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Displays the details of a specific project.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        try{
            return $this->successResponse(new ProjectResource($this->repository->find($id)), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error retrieving data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Stores a new project in the database.
     *
     * @param ProjectRequest $request
     * @return JsonResponse
     */
    public function store(ProjectRequest $request) : JsonResponse
    {
        try{
            $Project = $this->repository->create($request);
            return $this->successResponse(new ProjectResource($Project),"Project created successfully" , Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error storing data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a specific project in the database.
     *
     * @param ProjectRequest $request
     * @return JsonResponse
     */
    public function update(ProjectRequest $request) : JsonResponse
    {
        try{
            $proyecto = $this->repository->update($request->id,$request->validated());
            return $this->successResponse(new ProjectResource($proyecto),"Project updated successfully" , Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error updating data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a specific project from the database.
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
            return $this->errorResponse("Error deleting data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retrieves all projects associated with a specific tag.
     *
     * @param int $id ID of the tag to filter projects by
     * @return JsonResponse A JSON response containing:
     *                     - On success: A collection of projects with HTTP 200
     *                     - On failure: Error message with HTTP 500
     * @throws Exception When tag not found or error occurs during retrieval
     */
    public function getByTag(int $id) : JsonResponse
    {
        try{
            return $this->successResponse(new ProjectResourceCollection($this->repository->getProjectsByTag($id)),null,Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error retrieving data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retrieves all projects associated with a specific education record.
     *
     * @param int $id ID of the education record to filter projects by
     * @return JsonResponse A JSON response containing:
     *                     - On success: A collection of projects with HTTP 200
     *                     - On failure: Error message with HTTP 500
     * @throws Exception When education record not found or error occurs during retrieval
     */
    public function getByEducation(int $id) : JsonResponse
    {
        try{
            return $this->successResponse(new ProjectResourceCollection($this->repository->getProjectsByEducation($id)),null,Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error retrieving data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
