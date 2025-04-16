<?php
namespace App\Repository\V1;

use App\Http\Controllers\V1\ApiResponseTrait;
use App\Models\Education;
use Illuminate\Database\Eloquent\Collection;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EducationRepository implements IRepository
{
    use ApiResponseTrait;

    private TagRepository $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function all(): Collection
    {
        return  Education::with(['tags', 'links'])->orderBy('end_date', 'asc')->get();
    }

    /**
     * @throws Exception
     */
    public function find(int $id) : Education | JsonResponse
    {
        $tag = Education::where('id', $id)->first();
        if (!$tag) {
            throw new Exception('Error al encontrar al recurso education con ID: ' . $id);
        }
        return $tag;
    }

    public function create(FormRequest $data)
    {
        $data->validated();
        $education = Education::create([
            'name' => $data->name,
            'description' => $data->description,
            'start_date' => $data->start_date,
            'end_date' => $data->end_date,
        ]);


        if ($data->has('tags')) {
            $education->tags()->attach($data->tags);
        }
        if ($data->has('links')) {
            $education->tags()->attach($data->links);
        }
        if ($data->has('projects')) {
            $education->tags()->attach($data->projects);
        }
        return $education;
    }

    public function update(int $id, FormRequest $data): Education | JsonResponse
    {
        try {
            $data->validated();
            $education = $this->find($id);
            $education->update($data->all());

            if ($data->has('tags')) {
                $education->tags()->sync($data->tags);
            }
            if ($data->has('links')) {
                $education->links()->sync($data->links);
            }
            if ($data->has('projects')) {
                $education->projects()->sync($data->projects);
            }

            return $education->fresh();

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



    public function getEducationByTag(string $name) : Education|JsonResponse
    {
        try {
            return $this->tagRepository->findByName($name)->education()->get();
        }catch (Exception $e){
            return $this->errorResponse('Repository error.', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEducationBySlug(string $slug) : Education|JsonResponse
    {
        try {
            return Education::where('slug', $slug)->firstOrFail();
        }catch (Exception $e){
            return $this->errorResponse('Repository error.', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
