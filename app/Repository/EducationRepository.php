<?php
namespace App\Repository;

use App\Models\Education;
use App\Repository\IRepository;
use Illuminate\Database\Eloquent\Collection;

class EducationRepository implements IRepository
{
    public function all(): Collection
    {
        return  Education::orderBy('endDate', 'asc')->get();
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
        $Education = $this->find($id);
        if (!$Education) {
            return false;
        }
        return $Education->delete();
    }

    public function findWithProjects($id){
        return Education::with('proyect')->find($id);
    }

    public function whereType($type){
        return Education::where('type',$type)->orderBy('endDate', 'asc')->get();
    }

}