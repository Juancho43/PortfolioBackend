<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Education extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
    ];


    public function profile()
    {
        return $this->belongsToMany(Profile::class,'profiles_has_education');
    }
    public function project()
    {
        return $this->belongsToMany(Project::class,'education_has_projects');
    }
    public function tags()
    {
        return $this->belongsToMany(Tags::class,'education_has_tags');
    }


}
