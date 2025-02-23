<?php
namespace App\Repository;

use App\Models\Works;
use App\Repository\IRepository;
use Illuminate\Database\Eloquent\Collection;

class WorkRepository implements IRepository
{
    public function all(): Collection
    {

        return  Works::all();
    }

    public function find(int $id)
    {
        return Works::where('idWorks', $id)->first();
    }

    public function create(array $data)
    {
        return Works::create($data);
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


}
