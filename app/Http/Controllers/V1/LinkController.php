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
 * Class LinkController
 * @package App\Http\Controllers\V1
 *
 * Controller to manage CRUD operations for links.
 */
class LinkController
{
    use ApiResponseTrait;


    /**
     * @var LinkRepository
     */
    protected LinkRepository $repository;

    /**
     * LinkController constructor.
     *
     * @param LinkRepository $linkRepository
     */
    public function __construct(LinkRepository $linkRepository)
    {
        $this->repository = $linkRepository;

    }

    /**
     * Displays a list of all links.
     *
     * @return JsonResponse
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
     * Displays the details of a specific link.
     *
     * @param int $id
     * @return JsonResponse
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
     * Stores a new link in the database.
     *
     * @param LinkRequest $request
     * @return JsonResponse
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
     * Updates a specific link in the database.
     *
     * @param LinkRequest $request
     * @return JsonResponse
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
     * Deletes a specific link from the database.
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
            return $this->errorResponse("Error deleting link data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
