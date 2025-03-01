<?php

namespace App\Http\Controllers\V1;

use App\Models\Project;
use App\Models\Tags;
use App\Models\Education;
use Illuminate\Http\Request;
use App\Repository\V1\ProjectRepository;
use App\Http\Resources\V1\ProjectResource;
use App\Http\Resources\V1\ProjectResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use Exception;
class ProjectController extends Controller
{

    use ApiResponseTrait;
    protected $repository;


    public function __construct(ProjectRepository $repository, )
    {
        $this->repository = $repository;

    }

    public function index()
    {
        try{
            return $this->successResponse(new ProjectResourceCollection($this->repository->all()), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de projecto",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function show($id)
    {
        try{
            return $this->successResponse(new ProjectResource($this->repository->find($id)), null, Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de projecto",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function showByTag($id)
    {
        $tag = Tags::where('idTags',$id)->first();

        // Obtener todos los proyectos asociados a la etiqueta
        $proyectos = $tag;

        return response()->json([
            'Proyect' => $proyectos
        ]);
    }
    public function showByEducation($id)
    {
        $educacion = Education::find($id);

        $proyectos = $educacion->project()->with('tags')->get();

        return response()->json([
            'Proyect' => $proyectos
        ]);
    }

    public function store(Request $request)
    {
        try{
            $Project = $this->repository->create($request);
            return $this->successResponse(new ProjectResource($Project),"Proyecto cargado correctamente" , Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de proyecto",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $proyecto = $this->repository->update($id,$request->validated());
            return $this->successResponse(new ProjectResource($proyecto),"Proyecto actualizado correctamente" , Response::HTTP_CREATED);
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de proyecto",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
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
