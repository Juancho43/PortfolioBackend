<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Professional extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'company_url',
        'position',
        'start_date',
        'end_date',
        'responsibilities',
        'department',
        'location',
    ];


    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }


}
