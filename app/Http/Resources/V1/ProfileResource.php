<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'rol' => $this->resource->rol,
            'description' => $this->resource->description,
            'links' => new LinkResourceCollection($this->resource->links),

            'created_at' => $this->when($request->bearerToken(),$this->created_at, null),
            'updated_at' => $this->when($request->bearerToken(),$this->updated_at, null),
            'deleted_at' => $this->when($request->bearerToken(),$this->deleted_at, null)
        ];
    }
}
