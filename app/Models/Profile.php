<?php

namespace App\Models;

use Illuminate\Console\View\Components\Warn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rol',
        'description',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function education(){
        return $this->belongsToMany(Education::class,'profiles_has_education');
    }
    public function works(){
        return $this->belongsToMany(Works::class,'profiles_has_works');
    }
    public function links()
    {
        return $this->belongsToMany(Link::class, 'profiles_has_links');
    }


}
