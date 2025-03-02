<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\LinkRequest;
use App\Http\Resources\V1\LinkResource;
use App\Http\Resources\V1\LinkResourceCollection;
use App\Repository\V1\LinkRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;
class LinkController
{
    use ApiResponseTrait;
    protected $repository;
    public function __construct(LinkRepository $linkRepository)
    {
        $this->repository = $linkRepository;

    }

    public function index()
    {
        try{
            return $this->successResponse(new LinkResourceCollection($this->repository->all()), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de los links",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function show(int $id)
    {
        try{
            return $this->successResponse(new LinkResource($this->repository->find($id)), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos del link",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        try{
            $this->repository->delete($id);
            return $this->successResponse(null, "Datos eliminados correctamente", Response::HTTP_NO_CONTENT);
        }catch(Exception $e){
            return $this->errorResponse("Error al eliminar los datos del link",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
