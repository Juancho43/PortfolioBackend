<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class,'projects_has_tags');
    }
    public function education()
    {
        return $this->belongsToMany(Education::class,'education_has_tags');
    }
    public function works()
    {
        return $this->belongsToMany(Work::class,'works_has_tags');
    }
}
