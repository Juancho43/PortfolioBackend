<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\TagRequest;
use App\Http\Resources\V1\TagResource;
use App\Http\Resources\V1\TagResourceCollection;
use App\Repository\V1\TagRepository;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class TagsController extends Controller
{
    use ApiResponseTrait;
    protected $repository;


    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;

    }

    public function index()
    {

        try{
            return $this->successResponse(new TagResourceCollection($this->repository->all()),null,Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de tags",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }


    }

    public function show($id)
    {
        try{
            return $this->successResponse(new TagResource($this->repository->find($id)),null,Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de tags",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(TagRequest $request)
    {
        try{
            $tag = $this->repository->create($request);
            return $this->successResponse(new TagResource($tag),"Recurso creado correctamente",Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error guardar la tag",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(TagRequest $request, $id)
    {
        try{
            $tag = $this->repository->update($id,$request);
            return $this->successResponse(new TagResource($tag),'Recurso actualizado correctamente',Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error al actualizar la tag",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try{
            $this->repository->delete($id);
            return $this->successResponse(null, "Datos eliminados correctamente", Response::HTTP_NO_CONTENT);
        }catch(Exception $e){
            return $this->errorResponse("Error al eliminar los datos de projecto",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
