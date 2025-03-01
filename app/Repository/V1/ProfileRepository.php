<?php
namespace App\Repository\V1;

use App\Models\Profile;
use App\Models\User;
use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Exception;

class ProfileRepository implements IRepository
{
    public function all(): Collection
    {
        return  User::with("profile")->get();
    }

    public function find(int $id)
    {
        $Profile = Profile::where('id',$id)->with(['links'])->firstOrFail();
        if (!$Profile) {
            throw new Exception('Error al encontrar al recurso ID: ' . $id);
        }
        return $Profile;
    }

    public function create(FormRequest $data)
    {
        return Profile::create($data);
    }

    public function update(int $id, FormRequest $data): bool
    {
        return $this->find($id)->update($data->all());
    }

    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }


    public function attachLinkToProfile(int $profile_id, int $link_id)
    {
        // $profile = $this->find($profile_id);
        // $profile->links()->t($link_id);
    }
}
