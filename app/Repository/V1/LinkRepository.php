<?php
namespace App\Repository\V1;

use App\Models\Link;
use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Exception;

class LinkRepository implements IRepository
{
    public function all(): Collection
    {

        return  Link::all();
    }

    public function find(int $id)
    {
        $link = Link::where('id', $id)->first();
        if (!$link) {
            throw new Exception('Error al encontrar al recurso ID: ' . $id);
        }
        return $link;
    }

    public function create(FormRequest $data)
    {
        $data->validated();
        $link = Link::create([
            'name' => $data->name,
            'link' => $data->link,
        ]);

        return $link;
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
