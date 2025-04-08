<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'rol',
        'description',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function education() : BelongsToMany
    {
        return $this->belongsToMany(Education::class,'profiles_has_education');
    }
    public function works() : BelongsToMany
    {
        return $this->belongsToMany(Work::class,'profiles_has_works');
    }
    public function links() : BelongsToMany
    {
        return $this->belongsToMany(Link::class, 'profiles_has_links');
    }


}
