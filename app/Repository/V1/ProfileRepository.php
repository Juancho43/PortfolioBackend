<?php
namespace App\Repository\V1;

use App\Http\Controllers\V1\ApiResponseTrait;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProfileRepository implements IRepository
{
    use ApiResponseTrait;
    public function all(): Collection
    {
        return  User::with("profile")->get();
    }

    public function find(int $id) : Profile | JsonResponse
    {
        $Profile = Profile::where('id',$id)->with('links')->firstOrFail();
        if (!$Profile) {
            throw new Exception('Error al encontrar al recurso ID: ' . $id);
        }
        return $Profile;
    }

    public function create(FormRequest $data): Profile | JsonResponse
    {
        try{
            $data->validated();
            $profile = Profile::create($data);

            if ($data->has('links')) {
                $profile->links()->attach($data->links);
            }
            if ($data->has('education')) {
                $profile->education()->attach($data->education);
            }
            if ($data->has('works')) {
                $profile->works()->attach($data->works);
            }

            return $profile;

        }catch (Exception $e){
            return $this->errorResponse('Error al guardar el recurso', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(int $id, FormRequest $data) : Profile | JsonResponse
    {

        try{
            $data->validated();
            $profile = $this->find($id);
            $profile->update($data->all());

            if ($data->has('links')) {
                $profile->links()->sync($data->links);
            }

            if ($data->has('education')) {
                $profile->education()->sync($data->education);
            }

            if ($data->has('works')) {
                $profile->works()->sync($data->works);
            }

            return $profile->fresh();

        }catch (Exception $e){
            return $this->errorResponse('Error al actualizar el recurso', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function delete(int $id): bool | JsonResponse
    {
        try {
            return $this->find($id)->delete();
        }catch (Exception $e){
            return $this->errorResponse('Error al eliminar el recurso', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
