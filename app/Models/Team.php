<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Team extends Model
{
    protected $fillable = [
        'nom',
        'profession',
        'facebook_url',
        'linkedin_url',
    ];

    public function avatar(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
