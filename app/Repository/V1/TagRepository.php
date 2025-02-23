<?php
namespace App\Repository;

use App\Models\Tags;
use App\Repository\IRepository;
use Illuminate\Database\Eloquent\Collection;

class TagRepository implements IRepository
{
    public function all(): Collection
    {
        return  Tags::all();
    }

    public function find(int $id)
    {
        return Tags::find($id);
    }

    public function create(array $data)
    {
        return Tags::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $tag = $this->find($id);
        if (!$tag) {
            return false;
        }
        return $tag->update($data);
    }

    public function delete(int $id): bool
    {
        $tag = $this->find($id);
        if (!$tag) {
            return false;
        }
        return $tag->delete();
    }


}
