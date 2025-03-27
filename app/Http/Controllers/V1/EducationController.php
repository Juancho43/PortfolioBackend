<?php

namespace App\Http\Controllers\V1;

use App\Repository\V1\EducationRepository;
use App\Http\Requests\V1\EducationRequest;
use App\Http\Resources\V1\EducationResourceColletion;
use App\Http\Resources\V1\EducationResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Education Controller
 *
 * Handles HTTP requests related to education records including CRUD operations
 * and tag-based filtering.
 */
class EducationController extends Controller
{
    use ApiResponseTrait;

    /**
     * @var EducationRepository Repository for education data access
     */
    protected EducationRepository $repository;

    /**
     * Initialize controller with repository dependency
     *
     * @param EducationRepository $EducationRepository
     */
    public function __construct(EducationRepository $EducationRepository)
    {
        $this->repository = $EducationRepository;
    }

    /**
     * Get all education records
     *
     * @return JsonResponse Collection of education records
     * @throws Exception If error occurs retrieving data
     */
    public function index() : JsonResponse
    {
        try{
            return $this->successResponse(new EducationResourceColletion($this->repository->all()), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error retrieving data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get single education record by ID
     *
     * @param int $id Education record ID
     * @return JsonResponse Single education resource
     * @throws Exception If record not found or error occurs
     */
    public function show(int $id) : JsonResponse
    {
        try{
            return $this->successResponse(new EducationResource($this->repository->find($id)),null,Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error retrieving data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create new education record
     *
     * @param EducationRequest $request Validated education data
     * @return JsonResponse Created education resource
     * @throws Exception If creation fails
     */
    public function store(EducationRequest $request) : JsonResponse
    {
        try{
            $education = $this->repository->create($request);
            return $this->successResponse(new EducationResource($education),"Data stored successfully" , Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error storing data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update existing education record
     *
     * @param EducationRequest $request Validated education data
     * @return JsonResponse Updated education resource
     * @throws Exception If update fails
     */
    public function update(EducationRequest $request) : JsonResponse
    {
        try{
            $education = $this->repository->update($request->id,$request->validated());
            return $this->successResponse(new EducationResource($education),"Data updated successfully" , Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error updating data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete education record
     *
     * @param int $id Education record ID
     * @return JsonResponse Empty response on success
     * @throws Exception If deletion fails
     */
    public function destroy(int $id) : JsonResponse
    {
        try{
            $this->repository->delete($id);
            return $this->successResponse(null, null, Response::HTTP_NO_CONTENT);
        }catch(Exception $e){
            return $this->errorResponse("Error deleting data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get education records by tag ID
     *
     * @param int $id Tag ID to filter by
     * @return JsonResponse Collection of education records with given tag
     * @throws Exception If retrieval fails
     */
    public function getByTag(int $id) : JsonResponse
    {
        try {
            return $this->successResponse(new EducationResourceColletion($this->repository->getEducationByTag($id)),null,Response::HTTP_OK);
        }  catch (Exception $e) {
            return $this->errorResponse("Error retrieving data.",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
