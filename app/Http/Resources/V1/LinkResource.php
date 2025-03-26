<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class LinkResource extends JsonResource
{
    public static $wrap = 'link';
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
            'link' => $this->link,
            'created_at' => $this->when($request->bearerToken(),$this->created_at, null),
            'updated_at' => $this->when($request->bearerToken(),$this->updated_at, null),
            'deleted_at' => $this->when($request->bearerToken(),$this->deleted_at, null)
        ];
    }
}

