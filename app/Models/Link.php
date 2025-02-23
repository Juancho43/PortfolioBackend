<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    public function profile()
    {
        return $this->belongsToMany(Profile::class,'profiles_has_links');
    }
    public function project()
    {
        return $this->belongsToMany(Project::class,'projects_has_links');
    }
    public function work()
    {
        return $this->belongsToMany(Works::class,'works_has_links');
    }

}
