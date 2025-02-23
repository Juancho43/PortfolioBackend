<?php

namespace App\Http\Resources;

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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'rol' => $this->rol,
            'description' => $this->description,
            'github' => $this->github,
            'linkedin' => $this->linkedin,
            'publicMail' => $this->publicMail,
            'photo_url' => $this->photo_url,
            'cv' => $this->cv,
        ];
    }
}
