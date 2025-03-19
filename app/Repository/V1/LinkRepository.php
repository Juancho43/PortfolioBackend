<?php
namespace App\Repository\V1;

use App\Http\Controllers\V1\ApiResponseTrait;
use App\Models\Link;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LinkRepository
 *
 * Repository class for handling Link model CRUD operations
 * Implements IRepository interface and uses ApiResponseTrait
 */
class LinkRepository implements IRepository
{
    use ApiResponseTrait;
    /**
     * Get all links
     *
     * @return Collection Collection of Link models
     */
    public function all(): Collection
    {
        return  Link::all();
    }

    /**
     * Find a link by ID
     *
     * @param int $id Link ID to find
     * @return Link|JsonResponse Found Link model or error response
     * @throws Exception When link is not found
     */
    public function find(int $id) : Link | JsonResponse
    {
        $link = Link::where('id', $id)->first();
        if (!$link) {
            throw new Exception('Error al encontrar al recurso ID: ' . $id);
        }
        return $link;
    }

    /**
     * Create a new link
     *
     * @param FormRequest $data Request containing link data
     * @return Link Newly created Link model
     */
    public function create(FormRequest $data) : Link
    {
        $data->validated();
        $link = Link::create([
            'name' => $data->name,
            'link' => $data->link,
        ]);

        return $link;
    }

    /**
     * Update an existing link
     *
     * @param int $id Link ID to update
     * @param FormRequest $data Request containing updated link data
     * @return Link|JsonResponse Updated Link model or error response
     */
    public function update(int $id, FormRequest $data):Link | JsonResponse
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
     * Delete a link
     *
     * @param int $id Link ID to delete
     * @return bool|JsonResponse True if deleted successfully, error response otherwise
     */
    public function delete(int $id): bool | JsonResponse
    {
        try {
            return $this->find($id)->delete();
        }catch (Exception $e){
            return $this->errorResponse('Error al eliminar el recurso', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
