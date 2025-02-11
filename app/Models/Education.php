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
        'startDate',
        'endDate',
        'type',
        'profile_id'
    ];


    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function proyect()
    {
        return $this->hasMany(Project::class);
    }
}
