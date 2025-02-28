<?php
namespace App\Repository\V1;

use App\Models\Profile;
use App\Models\User;
use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
class ProfileRepository implements IRepository
{
    public function all(): Collection
    {
        return  User::with("profile")->get();
    }

    public function find(int $id)
    {

        return Profile::where('idProfile',$id)->with(['links'])->firstOrFail();
    }

    public function create(FormRequest $data)
    {
        return Profile::create($data);
    }

    public function update(int $id, FormRequest $data): bool
    {
        $Profile = $this->find($id);
        if (!$Profile) {
            return false;
        }
        return $Profile->update($data->all());
    }

    public function delete(int $id): bool
    {
        $Profile = $this->find($id);
        if (!$Profile) {
            return false;
        }
        return $Profile->delete();
    }


    public function attachLinkToProfile(int $profile_id, int $link_id)
    {
        // $profile = $this->find($profile_id);
        // $profile->links()->t($link_id);
    }
}
