<?php
namespace App\Repository\V1;

use App\Http\Controllers\V1\ApiResponseTrait;
use App\Models\Work;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
/**
 *
 * Class WorkRepository
 * @package App\Repository\V1
 *
 * Repositorio para gestionar las operaciones CRUD de los trabajos.
 */
class WorkRepository implements IRepository
{
    use ApiResponseTrait;

    private TagRepository $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Obtiene todos los trabajos.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Work::with(['links', 'tags'])->get();
    }
    /**
     * Encuentra un trabajo por su ID.
     *
     * @param int $id
     * @return Work
     * @throws Exception
     */
    public function find(int $id)
    {
        $Work = Work::with(['links', 'tags'])->where('id', $id)->first();
        if (!$Work) {
            throw new Exception('Error al encontrar al recurso ID: ' . $id);
        }
        return $Work;
    }
    /**
     * Crea un nuevo trabajo.
     *
     * @param FormRequest $data
     * @return Work
     */
    public function create(FormRequest $data)
    {
        $data->validated();
        $work = Work::create([
            'company' => $data->company,
            'position' => $data->position,
            'start_date' => $data->start_date,
            'end_date' => $data->end_date,
            'responsibilities' => $data->responsibilities,
        ]);
        if ($data->has('links')) {
            $work->links()->sync($data->links);
        }

        if ($data->has('tags')) {
            $work->tags()->sync($data->tags);
        }
        return $work;
    }
    /**
     * Actualiza un trabajo existente.
     *
     * @param int $id
     * @param FormRequest $data
     * @return Work
     */
    public function update(int $id, FormRequest $data): Work | JsonResponse
    {

        try {
            $work = $this->find($id);
            $work->update($data->all());

            if ($data->has('links')) {
                $work->links()->sync($data->links);
            }

            if ($data->has('tags')) {
                $work->tags()->sync($data->tags);
            }

            return $work->fresh();

        }catch (Exception $e){
            return $this->errorResponse('Error al actualizar el recurso', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Elimina un trabajo por su ID.
     *
     * @param int $id
     * @return bool|JsonResponse
     */
    public function delete(int $id): bool|JsonResponse
    {
        try {
            return $this->find($id)->delete();
        }catch (Exception $e){
            return $this->errorResponse('Error al eliminar el recurso', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getWorksByTag(int $id) : Collection|JsonResponse
    {
        try {
            return $this->tagRepository->find($id)->works()->get();
        }catch (Exception $e){
            return $this->errorResponse('Repository error.', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
