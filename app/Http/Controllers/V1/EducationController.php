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
        $education = $this->EducationRepository->create($request->validated());

        // $education->name = $request->input('name');
        // $education->description = $request->input('description');
        // $education->startDate = $request->input('startDate');
        // $education->endDate = $request->input('endDate');
        // $education->type = $request->input('type');
        // $education->profile_id = $request->input('profile_id');
        // $education->save();



        return response()->json([
            'message' => 'Education created successfully',
            'education' => $education
        ]);
    }

    public function update(EducationRequest $request, $id)
    {

        $education = $this->EducationRepository->update($id,$request->validated());

        // $education->name = $request->input('name');
        // $education->description = $request->input('description');
        // $education->startDate = $request->input('startDate');
        // $education->endDate = $request->input('endDate');
        // $education->type = $request->input('type');
        // $education->save();

        return response()->json([
            'message' => 'Education updated successfully',
            'education' => $education
        ]);
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
