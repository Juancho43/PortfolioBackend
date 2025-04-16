<?php
namespace App\Repository\V1;

use App\Http\Controllers\V1\ApiResponseTrait;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProjectRepository implements IRepository
{
    use ApiResponseTrait;


    private TagRepository $tagRepository;
    private EducationRepository $educationRepository;

    public function __construct(TagRepository $tagRepository, EducationRepository $educationRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->educationRepository = $educationRepository;
    }
    public function all(): Collection
    {

        return Project::with(['tags','links'])->get();
    }

    public function find(int $id)
    {

        $Project = Project::where('id', $id)->first();
        if (!$Project) {
            throw new Exception('Error al encontrar al recurso ID: ' . $id);
        }
        return $Project;

    }

    public function create(FormRequest $data)
    {
        $data->validated();
        $project = Project::create([
            'name' => $data->name,
            'description' => $data->description,
        ]);

        if ($data->has('tags')) {
            $project->tags()->attach($data->tags);
        }
        if ($data->has('links')) {
            $project->links()->attach($data->links);
        }
        return $project;
    }

    public function update(int $id, FormRequest $data): Project | JsonResponse
    {
        try{
            $data->validated();
            $project = $this->find($id);
            $project->update($data->all());

            if ($data->has('links')) {
                $project->links()->sync($data->links);
            }

            if ($data->has('tags')) {
                $project->tags()->sync($data->tags);
            }

            return $project->fresh();
        }catch (Exception $e){
            return $this->errorResponse('Error al actualizar el recurso', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $id): bool | JsonResponse
    {
        try {
            return $this->find($id)->delete();
        }catch (Exception $e){
            return $this->errorResponse('Error al eliminar el recurso', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getProjectsByEducation(string $slug) : Collection | JsonResponse
    {
        try {
            return $this->educationRepository->getEducationBySlug($slug)->projects()->get();
        }catch (Exception $e){
            return $this->errorResponse('Repository error.', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function getProjectsByTag(string $name) : Collection|JsonResponse
    {
        try {
            return $this->tagRepository->findByName($name)->projects()->get();
        }catch (Exception $e){
            return $this->errorResponse('Repository error.', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function getProjectBySlug(string $slug) : Project | JsonResponse
    {
        try {
            return Project::where('slug', $slug)->firstOrFail();
        }catch (Exception $e){
            return $this->errorResponse('Repository error.', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
