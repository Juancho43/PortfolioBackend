<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{

    use HasFactory;

    protected $fillable=[
        'company',
        'position',
        'start_date',
        'end_date',
        'responsibilities',
    ];
    public function link()
    {
        return $this->belongsToMany(Link::class,'works_has_links');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'works_has_tags');
    }

    public function profile()
    {
        return $this->belongsToMany(Profile::class,'profile_has_works');
    }

}
