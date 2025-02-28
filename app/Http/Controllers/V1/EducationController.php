<?php

namespace App\Http\Controllers\V1;


use App\Repository\V1\EducationRepository;
use App\Http\Requests\V1\EducationRequest;
use App\Http\Resources\V1\EducationResourceColletion;
use App\Http\Resources\V1\EducationResource;
use App\Http\Controllers\V1\ApiResponseTrait;
use Exception;
use Symfony\Component\HttpFoundation\Response;


class EducationController extends Controller
{

    use ApiResponseTrait;
    protected $EducationRepository;


    public function __construct(EducationRepository $EducationRepository, )
    {
        $this->EducationRepository = $EducationRepository;

    }


    public function index()
    {
        try{
            return $this->successResponse(new EducationResourceColletion($this->EducationRepository->all()), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de education",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try{
            return $this->successResponse(new EducationResource($this->EducationRepository->find($id)), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de education",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function AllEducation($id)
    {

        $data = $this->EducationRepository->findWithProjects($id);
        return response()->json([
            'Data' => $data
        ]);
    }

    public function showByType($type)
    {
        try{
            return $this->successResponse(new EducationResourceColletion( $this->EducationRepository->whereType($type)), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de education",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(EducationRequest $request)
    {

        try{
            $education = $this->EducationRepository->create($request);
            return $this->successResponse(new EducationResource($education),"Educación cargada correctamente" , Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de education",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function update(EducationRequest $request, $id)
    {
        try{
            $education = $this->EducationRepository->update($id,$request->validated());
            return $this->successResponse(new EducationResource($education),"Educación actualizada correctamente" , Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de education",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function destroy($id)
    {
        try{
            $this->EducationRepository->delete($id);
            return $this->successResponse(null, "Datos eliminados correctamente", Response::HTTP_NO_CONTENT);
        }catch(Exception $e){
            return $this->errorResponse("Error al eliminar los datos de education",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
