<?php

namespace App\Http\Resources;

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
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'type' => $this->type,

            'created_at' => $this->when(Auth::check(),$this->created_at, null),
            'updated_at' => $this->when(Auth::check(),$this->created_at, null)
        ];
    }
}
