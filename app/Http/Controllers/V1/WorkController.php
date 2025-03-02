<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\WorkRequest;
use App\Http\Resources\V1\WorkResourceCollection;
use App\Http\Resources\V1\WorkResource;
use App\Repository\V1\WorkRepository;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class WorkController
{

    use ApiResponseTrait;
    protected $repository;


    public function __construct(WorkRepository $repository)
    {
        $this->repository = $repository;

    }


    public function index()
    {
        try{
            return $this->successResponse(new WorkResourceCollection($this->repository->all()),null,Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de trabajos",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }


    public function store(WorkRequest $request)
    {
        try{
            $work = $this->repository->create($request);
            return $this->successResponse(new WorkResource($work),"Recurso creado correctamente",Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error guardar el trabajo",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function show(string $id)
    {
        try{
            return $this->successResponse(new WorkResource($this->repository->find($id)),null,Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de trabajo",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }




    public function update(WorkRequest $request, string $id)
    {
        try{
            $work = $this->repository->update($id,$request);
            return $this->successResponse(new WorkResource($work),'Recurso actualizado correctamente',Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error al actualizar el trabajo",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function destroy(string $id)
    {
        try{
            $this->repository->delete($id);
            return $this->successResponse(null, "Datos eliminados correctamente", Response::HTTP_NO_CONTENT);
        }catch(Exception $e){
            return $this->errorResponse("Error al eliminar los datos de trabajo",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
