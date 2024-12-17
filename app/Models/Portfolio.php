<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Departement;

class Portfolio extends Model
{
    protected $fillable = [
        'departement_id',
        'name',
        'slug',
        'description',
        'client',
        'url',
        'location',
        // 'image',
    ];

    protected $with = ['image'];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
}
