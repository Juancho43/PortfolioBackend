<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rol', 
        'description', 
        'github', 
        'linkedin', 
        'publicMail', 
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }
    public function professional()
    {
        return $this->hasMany(Professional::class);
    }
}
