<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProyectFactory> */
    use HasFactory;

    public function tags()
    {
        return $this->belongsToMany(Tags::class,'project_tags');
    }

    public function education(): BelongsTo
    {
        return $this->belongsTo(Education::class);
    }
}
