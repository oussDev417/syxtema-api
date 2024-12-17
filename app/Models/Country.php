<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Country extends Model
{
    protected $fillable = [
        'short_name',
        'country_name',
        'slug',
        'location_map_url',
        'phonecode',
        'continent',
        'status',
    ];

    public function flag(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    protected $with = ['flag'];
}
