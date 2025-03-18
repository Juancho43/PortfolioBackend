<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Education extends Model
{

    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
    ];


    public function profile() : BelongsToMany
    {
        return $this->belongsToMany(Profile::class,'profiles_has_education');
    }
    public function projects() : BelongsToMany
    {
        return $this->belongsToMany(Project::class,'education_has_projects');
    }
    public function tags() : BelongsToMany
    {
        return $this->belongsToMany(Tag::class,'education_has_tags');
    }
    public function links() : BelongsToMany
    {
        return $this->belongsToMany(Link::class,'education_has_links');
    }

}
