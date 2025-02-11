<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProfessionalResource extends JsonResource
{
    public static $wrap = 'professional';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company' => $this->company,
            'company_url' => $this->company_url,
            'position' => $this->position,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'responsibilities' => $this->responsibilities,
            'department' => $this->department,
            'location' => $this->location,

            'created_at' => $this->when(Auth::check(),$this->created_at, null),
            'updated_at' => $this->when(Auth::check(),$this->created_at, null)
        ];
    }
}
