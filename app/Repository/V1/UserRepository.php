<?php
namespace App\Repository\V1;

use App\Models\Education;
use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
class UserRepository implements IRepository
{
    public function all(): Collection
    {

        return  Education::orderBy('endDate', 'asc')->get();
    }

    public function find(int $id)
    {
        return Education::where('id', $id)->first();
    }

    public function create(FormRequest $data)
    {
        return Education::create($data);
    }

    public function update(int $id, FormRequest $data): bool
    {
        $Education = $this->find($id);
        if (!$Education) {
            return false;
        }
        return $Education->update($data->all());
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
