<?php
namespace App\Repository\V1;

use App\Models\Tag;
use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Exception;
class TagRepository implements IRepository
{
    public function all(): Collection
    {
        return  Tag::all();
    }

    public function find(int $id)
    {
        $tag = Tag::where('id', $id)->first();
        if (!$tag) {
            throw new Exception('Error al encontrar al recurso tag con ID: ' . $id);
        }
        return $tag;
    }

    public function create(FormRequest $data)
    {
        return Tag::create($data);
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
