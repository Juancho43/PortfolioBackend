<?php
namespace App\Repository\V1;

use App\Models\Tag;
use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
class TagRepository implements IRepository
{
    public function all(): Collection
    {
        return  Tag::all();
    }

    public function find(int $id)
    {
        return Tag::find($id);
    }

    public function create(FormRequest $data)
    {
        return Tag::create($data);
    }

    public function update(int $id, FormRequest $data): bool
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
