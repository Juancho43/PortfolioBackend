<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public static $wrap = 'profile';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'idProfile' => $this->resource->idProfile,
            'name' => $this->resource->name,
            'rol' => $this->resource->rol,
            'description' => $this->resource->description,
            'links' => new LinkResourceCollection($this->resource->links)
        ];
    }
}
