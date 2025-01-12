<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HasMany;

class Education extends Model
{
    /** @use HasFactory<\Database\Factories\EducationFactory> */
    use HasFactory;
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function proyect()
    {
        return $this->hasMany(Proyect::class);
    }
}
