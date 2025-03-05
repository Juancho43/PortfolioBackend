<?php
namespace App\Repository\V1;

use App\Models\User;
use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Exception;
class UserRepository implements IRepository
{
    public function all(): Collection
    {

        return  User::all();
    }

    public function find(int $id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            throw new Exception('Error al encontrar al recurso user ID: ' . $id);
        }
        return $user;
    }

    public function create(FormRequest $data)
    {
        return User::create($data);
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
