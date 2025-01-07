<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Temoignage extends Model
{
    protected $fillable = [
        'nom',
        'profession',
        'message',
        // 'avatar',
    ];

    protected $with = [
        'avatar',
    ];

    public function avatar(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
