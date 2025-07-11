<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class WorkResource extends JsonResource
{
    public static $wrap = 'work';
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
            'company' => $this->company,
            'position' => $this->position,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'responsibilities' => $this->responsibilities,
            'links' =>LinkResource::collection($this->links),
            'tags' => TagResource::collection($this->tags),
            'created_at' => $this->when($request->bearerToken(),$this->created_at, null),
            'updated_at' => $this->when($request->bearerToken(),$this->updated_at, null),
            'deleted_at' => $this->when($request->bearerToken(),$this->deleted_at, null)
        ];
    }
}
