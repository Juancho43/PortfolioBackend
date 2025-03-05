<?php
namespace App\Repository\V1;

use App\Models\Work;

use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Exception;
/**
 * Class WorkRepository
 * @package App\Repository\V1
 *
 * Repositorio para gestionar las operaciones CRUD de los trabajos.
 */
class WorkRepository implements IRepository
{
    /**
     * Obtiene todos los trabajos.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return  Work::all();
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
        $Work = Work::where('id', $id)->first();
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
            'responsabilities' => $data->responsabilities,
        ]);

        return $work;
    }
    /**
     * Actualiza un trabajo existente.
     *
     * @param int $id
     * @param FormRequest $data
     * @return bool
     */
    public function update(int $id, FormRequest $data): bool
    {
        return $this->find($id)->update($data->all());
    }
    /**
     * Elimina un trabajo por su ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }


}
