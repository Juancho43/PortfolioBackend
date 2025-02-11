<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tags;
use App\Models\Education;
use Illuminate\Http\Request;
use App\Repository\ProjectRepository;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectResourceCollection;

class ProyectController extends Controller
{


    protected $repository;


    public function __construct(ProjectRepository $repository, )
    {
        $this->repository = $repository;

    }

    public function index()
    {

        return new ProjectResourceCollection($this->repository->all());

    }

    public function show($id)
    {
        return new ProjectResource($this->repository->find($id));
    }

    public function showByTag($id)
    {
        $tag = Tags::find($id);

        // Obtener todos los proyectos asociados a la etiqueta
        $proyectos = $tag->proyectos()->with('tags')->get();

        return response()->json([
            'Proyect' => $proyectos
        ]);
    }
    public function showByEducation($id)
    {
        $educacion = Education::find($id);

        $proyectos = $educacion->proyect()->with('tags')->get();

        return response()->json([
            'Proyect' => $proyectos
        ]);
    }





    public function store(Request $request)
    {
        $Proyect = new Project;

        $Proyect->name = $request->input('name');
        $Proyect->description = $request->input('description');

        $Proyect->save();

   // Retrieve the tags from the request
        $tags = $request->input('tags');

        // Attach the tags to the project
        if ($tags) {
            $Proyect->tags()->sync($tags);
        }


        return response()->json([
            'message' => 'Proyect created successfully',
            'Proyect' => $Proyect
        ]);
    }

    public function update(Request $request, $id)
    {
        $Proyect = Project::with('tags:id,name')->find($id);

        $Proyect->name = $request->input('name');
        $Proyect->description = $request->input('description');

        $Proyect->save();

        return response()->json([
            'message' => 'Proyect created successfully',
            'Proyect' => $Proyect
        ]);
    }

    public function destroy($id)
    {
        $task = Project::find($id);

        $task->delete();

        return response()->json([
            'message' => 'Proyect deleted successfully'
        ]);
    }
}
