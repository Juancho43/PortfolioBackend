<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{

    use HasFactory;

    protected $fillable=[
        'name',
        'description',
        'slug'
    ];

    public function tags() : BelongsToMany
    {
        return $this->belongsToMany(Tag::class,'projects_has_tags');
    }

    public function links() : BelongsToMany
    {
        return $this->belongsToMany(Link::class,'projects_has_links');
    }

    public function education() : BelongsToMany
    {
        return $this->belongsToMany(Education::class,'education_has_projects');
    }
}
