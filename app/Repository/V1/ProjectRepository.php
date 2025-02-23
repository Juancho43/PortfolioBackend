<?php
namespace App\Repository\V1;

use App\Models\Project;
use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository implements IRepository
{
    public function all(): Collection
    {

        return Project::with('tags')->get();
    }

    public function find(int $id)
    {
        return Project::where('id', $id)->first();
    }

    public function create(array $data)
    {
        return Project::create($data);
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
