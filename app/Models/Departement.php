<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Departement extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function logo(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    protected $with = ['logo'];
}
