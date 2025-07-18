<?php

namespace App\Http\Resources\V1;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{

    public static $wrap = 'education';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'projects' => $this->when(
                isset($this->projects) && $this->projects !== null &&  !$this->projects->isEmpty(),
                ProjectResource::collection($this->projects)
            ),
            'tags' => $this->when(
                isset($this->tags)&& $this->tags !== null && !$this->tags->isEmpty(),
                TagResource::collection($this->tags)
            ),
            'links' => $this->when(
                isset($this->links) && $this->links !== null  && !$this->links->isEmpty(),
                LinkResource::collection($this->links)
            ),
            'created_at' => $this->when($request->bearerToken(),$this->created_at, null),
            'updated_at' => $this->when($request->bearerToken(),$this->updated_at, null),
            'deleted_at' => $this->when($request->bearerToken(),$this->deleted_at, null)
        ];
    }
}
