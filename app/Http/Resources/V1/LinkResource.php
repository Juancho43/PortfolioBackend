<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'link' => $this->link,
            'created_at' => $this->when(Auth::check(),$this->created_at, null),
            'updated_at' => $this->when(Auth::check(),$this->updated_at, null),
            'deleted_at' => $this->when(Auth::check(),$this->deleted_at, null)
        ];
    }
}

