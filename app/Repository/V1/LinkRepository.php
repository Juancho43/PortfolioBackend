<?php
namespace App\Repository\V1;

use App\Models\Link;
use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
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

    public function create(FormRequest $data)
    {
        return Link::create($data);
    }

    public function update(int $id, FormRequest $data): bool
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
