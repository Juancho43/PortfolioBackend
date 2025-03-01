<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->when($request->user(),$this->created_at, null),
            'updated_at' => $this->when($request->user(),$this->updated_at, null),
            'deleted_at' => $this->when($request->user(),$this->deleted_at, null)
        ];
    }
}
