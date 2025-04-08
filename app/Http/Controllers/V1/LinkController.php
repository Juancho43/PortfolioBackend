<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\LinkRequest;
use App\Http\Resources\V1\LinkResource;
use App\Http\Resources\V1\LinkResourceCollection;
use App\Http\Resources\V1\WorkResource;
use App\Repository\V1\LinkRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Component\HttpFoundation\Response;
use Exception;

/**
 * Link Controller
 *
 * Handles HTTP requests related to link management including basic CRUD operations.
 * Provides endpoints for creating, reading, updating and deleting links.
 */
class LinkController
{
    use ApiResponseTrait;

    /**
     * @var LinkRepository Repository for link data access
     */
    protected LinkRepository $repository;

    /**
     * Initialize controller with repository dependency
     *
     * @param LinkRepository $linkRepository Repository for link operations
     */
    public function __construct(LinkRepository $linkRepository)
    {
        $this->repository = $linkRepository;
    }

    /**
     * Get all links
     *
     * @return JsonResponse Collection of all links with HTTP 200 on success,
     *                     error message with HTTP 500 on failure
     * @throws Exception If error occurs retrieving data
     */
    public function index() : JsonResponse
    {
        try{
            return $this->successResponse(new LinkResourceCollection($this->repository->all()), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error retrieving link data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get single link by ID
     *
     * @param int $id Link ID to retrieve
     * @return JsonResponse Single link resource with HTTP 200 on success,
     *                     error message with HTTP 500 on failure
     * @throws Exception If link not found or error occurs
     */
    public function show(int $id) : JsonResponse
    {
        try{
            return $this->successResponse(new LinkResource($this->repository->find($id)), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error retrieving link data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create new link
     *
     * @param LinkRequest $request Validated link data
     * @return JsonResponse Created link resource with HTTP 201 on success,
     *                     error message with HTTP 500 on failure
     * @throws Exception If creation fails
     */
    public function store(LinkRequest $request) : JsonResponse
    {
        try{
            $link = $this->repository->create($request);
            return $this->successResponse(new LinkResource($link),"Resource created successfully",Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error saving the link data.",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update existing link
     *
     * @param LinkRequest $request Validated link data with ID
     * @return JsonResponse Updated link resource with HTTP 200 on success,
     *                     error message with HTTP 500 on failure
     * @throws Exception If update fails
     */
    public function update(LinkRequest $request) : JsonResponse
    {
        try{
            $link = $this->repository->update($request->id,$request);
            return $this->successResponse(new LinkResource($link),'Resource updated successfully',Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error updating the link",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete link
     *
     * @param int $id Link ID to delete
     * @return JsonResponse Empty response with HTTP 204 on success,
     *                     error message with HTTP 500 on failure
     * @throws Exception If deletion fails
     */
    public function destroy(int $id) : JsonResponse
    {
        try{
            $this->repository->delete($id);
            return $this->successResponse(null, "Data deleted successfully", Response::HTTP_NO_CONTENT);
        }catch(Exception $e){
            return $this->errorResponse("Error deleting link data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
