<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Partner extends Model
{
    protected $fillable = [
        'url',
    ];

    protected $with = ['logo'];

    public function logo(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
