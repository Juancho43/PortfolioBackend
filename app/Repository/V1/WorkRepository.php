<?php
namespace App\Repository\V1;

use App\Models\Work;

use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Exception;
class WorkRepository implements IRepository
{
    public function all(): Collection
    {

        return  Work::all();
    }

    public function find(int $id)
    {
        $Work = Work::where('id', $id)->first();
        if (!$Work) {
            throw new Exception('Error al encontrar al recurso ID: ' . $id);
        }
        return $Work;
    }

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

    public function update(int $id, FormRequest $data): bool
    {
        return $this->find($id)->update($data->all());
    }

    public function delete(int $id): bool
    {

        return $this->find($id)->delete();
    }


}
