<?php
namespace App\Repository\V1;

use App\Http\Controllers\V1\ApiResponseTrait;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Js;
use Symfony\Component\HttpFoundation\Response;
/**
 * Class TagRepository
 *
 * Repository class for handling Tag model CRUD operations
 * Implements IRepository interface and uses ApiResponseTrait
 *
 * @package App\Repository\V1
 */
class TagRepository implements IRepository
{
    use ApiResponseTrait;

    /**
     * Get all tags
     *
     * @return Collection Collection of Tag models
     */
    public function all(): Collection
    {
        return  Tag::all();
    }

    /**
     * Find a tag by ID
     *
     * @param int $id Tag ID to find
     * @return Tag Found Tag model
     * @throws Exception When tag is not found
     */
    public function find(int $id)
    {
        $tag = Tag::where('id', $id)->first();
        if (!$tag) {
            throw new Exception('Error al encontrar al recurso tag con ID: ' . $id);
        }
        return $tag;
    }

    /**
     * Create a new tag
     *
     * @param FormRequest $data Request containing tag data
     * @return Tag Newly created Tag model
     */
    public function create(FormRequest $data) : Tag
    {
        $data->validated();
        $tag = Tag::create([
           'name' => $data->name,
        ]);

        return $tag;
    }

    /**
     * Update an existing tag
     *
     * @param int $id Tag ID to update
     * @param FormRequest $data Request containing updated tag data
     * @return Tag|JsonResponse Updated Tag model or error response
     */
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

    /**
     * Delete a tag
     *
     * @param int $id Tag ID to delete
     * @return bool|JsonResponse True if deleted successfully, error response otherwise
     */
    public function delete(int $id): bool|JsonResponse
    {
        try {
            return $this->find($id)->delete();
        }catch (Exception $e){
            return $this->errorResponse('Error al eliminar el recurso', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function allEducationTags() : Collection
    {
        $tags = Tag::whereHas('education')
            ->distinct()
            ->get();
        if ($tags->isEmpty()) {
            throw new Exception('No tags found for any education records');
        }
        return $tags;
    }
    public function allProjectsTags() : Collection
    {
        $tags = Tag::whereHas('projects')
            ->distinct()
            ->get();
        if ($tags->isEmpty()) {
            throw new Exception('No tags found for any project records');
        }
        return $tags;
    }
    public function allWorksTags() : Collection
    {
        $tags = Tag::whereHas('works')
            ->distinct()
            ->get();
        if ($tags->isEmpty()) {
            throw new Exception('No tags found for any project records');
        }
        return $tags;
    }




}
