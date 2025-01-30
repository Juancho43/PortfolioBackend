<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Add 'name' here
        'rol', 
        'description', 
        'github', 
        'linkedin', 
        'publicMail', 
        // Add other attributes as needed
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function education(): HasMany
    {
        return $this->hasMany(Education::class);
    }
}
