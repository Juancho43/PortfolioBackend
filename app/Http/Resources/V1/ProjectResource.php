<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProjectResource extends JsonResource
{

    public static $wrap = 'project';
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
            'description' => $this->name,
            'tags' => TagResource::collection($this->tags),
            'links' => LinkResource::collection($this->links),
            'created_at' => $this->when(Auth::check(),$this->created_at, null),
            'updated_at' => $this->when(Auth::check(),$this->updated_at, null),
            'deleted_at' => $this->when(Auth::check(),$this->deleted_at, null)
        ];
    }
}
