<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Project extends Model
{

    use HasFactory;

    protected $fillable=[
        'name',
        'description'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tags::class,'projects_has_tags');
    }

    public function link()
    {
        return $this->belongsToMany(Link::class,'projects_has_links');
    }

    public function education()
    {
        return $this->belongsToMany(Education::class,'education_has_projects');
    }
}
