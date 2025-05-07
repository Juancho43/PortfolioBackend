<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{

    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'company',
        'position',
        'slug',
        'start_date',
        'end_date',
        'responsibilities',
    ];
    public function links() : BelongsToMany
    {
        return $this->belongsToMany(Link::class,'works_has_links');
    }

    public function tags() : BelongsToMany
    {
        return $this->belongsToMany(Tag::class,'works_has_tags');
    }

    public function profile() : BelongsToMany
    {
        return $this->belongsToMany(Profile::class,'profile_has_works');
    }

}
