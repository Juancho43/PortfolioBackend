<?php
namespace App\Repository\V1;

use App\Http\Controllers\V1\ApiResponseTrait;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TagRepository implements IRepository
{
    use ApiResponseTrait;
    public function all(): Collection
    {
        return  Tag::all();
    }

    public function find(int $id)
    {
        $tag = Tag::where('id', $id)->first();
        if (!$tag) {
            throw new Exception('Error al encontrar al recurso tag con ID: ' . $id);
        }
        return $tag;
    }

    public function create(FormRequest $data) : Tag
    {
        $data->validated();
        $tag = Tag::create([
           'name' => $data->name,
        ]);

        return $tag;
    }

    public function update(int $id, FormRequest $data) : Tag|JsonResponse
    {
        try {
            $tag = $this->find($id);
            $tag->update($data->all());
            return $tag->fresh();
        }catch (Exception $e){
         return $this->errorResponse('Error al actualizar el recurso', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $id): bool|JsonResponse
    {

        try {
            return $this->find($id)->delete();
        }catch (Exception $e){
            return $this->errorResponse('Error al eliminar el recurso', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getProjectsByTag(int $id) : Collection|JsonResponse
    {
        try {
            return $this->find($id)->projects()->get();
        }catch (Exception $e){
            return $this->errorResponse('Repository error.', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getWorksByTag(int $id) : Collection|JsonResponse
    {
        try {
            return $this->find($id)->works()->get();
        }catch (Exception $e){
            return $this->errorResponse('Repository error.', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEducationByTag(int $id) : Collection|JsonResponse
    {
        try {
            return $this->find($id)->education()->get();
        }catch (Exception $e){
            return $this->errorResponse('Repository error.', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
