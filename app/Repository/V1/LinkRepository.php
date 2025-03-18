<?php
namespace App\Repository\V1;

use App\Http\Controllers\V1\ApiResponseTrait;
use App\Models\Link;
use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LinkRepository implements IRepository
{
    use ApiResponseTrait;
    public function all(): Collection
    {
        return  Link::all();
    }

    public function find(int $id)
    {
        $link = Link::where('id', $id)->first();
        if (!$link) {
            throw new Exception('Error al encontrar al recurso ID: ' . $id);
        }
        return $link;
    }

    public function create(FormRequest $data)
    {
        $data->validated();
        $link = Link::create([
            'name' => $data->name,
            'link' => $data->link,
        ]);

        return $link;
    }

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

    public function delete(int $id): bool | JsonResponse
    {
        try {
            return $this->find($id)->delete();
        }catch (Exception $e){
            return $this->errorResponse('Error al eliminar el recurso', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
