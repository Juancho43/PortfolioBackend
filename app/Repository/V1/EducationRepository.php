<?php
namespace App\Repository\V1;

use App\Models\Education;
use App\Models\Tag;
use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

class EducationRepository implements IRepository
{

   private TagRepository $tagRepository;
   public function __construct(TagRepository $tagRepository){
    $this->tagRepository = $tagRepository;
   }

    public function all(): Collection
    {

        return  Education::orderBy('end_date', 'asc')->get();
    }

    public function find(int $id)
    {

        $education = Education::where('id', $id)->first();
        if (!$education) {
            throw new Exception('Error al encontrar al recurso education con ID: ' . $id);
        }
        return $education;
    }

    public function create(FormRequest $data)
    {
        $data->validated();
        // Crear el registro Education
        $education = Education::create([
            'name' => $data->name,
            'description' => $data->description,
            'start_date' => $data->start_date,
            'end_date' => $data->end_date,
        ]);


        // Asociar los tags si se proporcionan
        if ($data->has('tags') && is_array($data->tags)) {
            $education->tags()->attach($data->tags);
        }

        return $education;
    }

    public function update(int $id, FormRequest $data): bool
    {
        return $this->find($id)->update($data->all());
    }

    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }


    public function findWhereTag($id)
    {
        $tag = $this->tagRepository->find($id);
        $educations = Education::whereHas('tags', function ($query) use ($tag) {
            $query->where('name', $tag->name);
        })->with('tags')->orderBy('start_date', 'asc')->get();
        
        if ($educations->isEmpty()) {
            throw new Exception("No educations found for tag: " . $tag->name);
        }

        return $educations;
    }

}
