<?php
namespace App\Repository;

use App\Models\Link;
use App\Repository\IRepository;
use Illuminate\Database\Eloquent\Collection;

class LinkRepository implements IRepository
{
    public function all(): Collection
    {

        return  Link::all();
    }

    public function find(int $id)
    {
        return Link::where('idLinks', $id)->first();
    }

    public function create(array $data)
    {
        return Link::create($data);
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
