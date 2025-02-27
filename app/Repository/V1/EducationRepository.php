<?php
namespace App\Repository\V1;

use App\Models\Education;
use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Exception;
class EducationRepository implements IRepository
{
    public function all(): Collection
    {

        return  Education::orderBy('end_date', 'asc')->get();
    }

    public function find(int $id)
    {
        return Education::where('id', $id)->first();
    }

    public function create(array $data)
    {
        return Education::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $Education = $this->find($id);
        if (!$Education) {
            return false;
        }
        return $Education->update($data);
    }

    public function delete(int $id): bool
    {
        if (!$this->find($id)) {
            throw new Exception('Error al encontrar el recurso');
        }
        return $this->find($id)->delete();
    }

    public function findWithProjects($id){
        return Education::with('proyect')->find($id);
    }

    public function whereType($type){
        return Education::where('type',$type)->orderBy('end_date', 'asc')->get();
    }

}
