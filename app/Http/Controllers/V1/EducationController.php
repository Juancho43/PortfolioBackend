<?php

namespace App\Http\Controllers\V1;


use App\Http\Resources\V1\ProjectResourceCollection;
use App\Repository\V1\EducationRepository;
use App\Http\Requests\V1\EducationRequest;
use App\Http\Resources\V1\EducationResourceColletion;
use App\Http\Resources\V1\EducationResource;
use App\Http\Controllers\V1\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class EducationController extends Controller
{

    use ApiResponseTrait;
    protected EducationRepository $repository;

    public function __construct(EducationRepository $EducationRepository)
    {
        $this->repository = $EducationRepository;

    }


    public function index() : JsonResponse
    {
        try{
            return $this->successResponse(new EducationResourceColletion($this->repository->all()), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de education",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id) : JsonResponse
    {
        try{
            return $this->successResponse(new EducationResource($this->repository->find($id)),null,Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error retrieving tag data",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(EducationRequest $request) : JsonResponse
    {

        try{
            $education = $this->repository->create($request);
            return $this->successResponse(new EducationResource($education),"Educación cargada correctamente" , Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de education",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function update(EducationRequest $request) : JsonResponse
    {
        try{
            $education = $this->repository->update($request->id,$request->validated());
            return $this->successResponse(new EducationResource($education),"Educación actualizada correctamente" , Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de education",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function destroy($id) : JsonResponse
    {
        try{
            $this->repository->delete($id);
            return $this->successResponse(null, "Datos eliminados correctamente", Response::HTTP_NO_CONTENT);
        }catch(Exception $e){
            return $this->errorResponse("Error al eliminar los datos de education",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function getProjectsByEducation(int $educationId) : JsonResponse
    {
        try {
            return $this->successResponse(new ProjectResourceCollection($this->repository->getProjectsByEducation($educationId)),null,Response::HTTP_OK);
        }  catch (Exception $e) {
            return $this->errorResponse("Error retrieving data.",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
