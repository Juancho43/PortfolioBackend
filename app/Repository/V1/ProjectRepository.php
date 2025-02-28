<?php
namespace App\Repository\V1;

use App\Models\Project;
use App\Repository\V1\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Exception;
class ProjectRepository implements IRepository
{
    public function all(): Collection
    {

        return Project::with(['tags','link'])->get();
    }

    public function find(int $id)
    {

        $Project = Project::where('id', $id)->first();
        if (!$Project) {
            throw new Exception('Error al encontrar al recurso ID: ' . $id);
        }
        return $Project;

    }

    public function create(FormRequest $data)
    {
        $data->validated();
        $project = Project::create([
            'name' => $data->name,
            'description' => $data->description,
        ]);

        if ($data->has('tags') && is_array($data->tags)) {
            $project->tags()->attach($data->tags);
        }
        if ($data->has('link')) {
            $project->link()->attach($data->link);
        }
        return $project;
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
