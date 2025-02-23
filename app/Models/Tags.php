<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{

    use HasFactory;

    public function project()
    {
        return $this->belongsToMany(Project::class,'projects_has_tags');
    }
    public function education()
    {
        return $this->belongsToMany(Education::class,'education_has_tags');
    }
    public function work()
    {
        return $this->belongsToMany(Works::class,'works_has_tags');
    }
}
