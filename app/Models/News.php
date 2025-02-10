<?php

namespace App\Models;
use App\Models\NewsCategory;
use App\Models\Country;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class News extends Model
{
    protected $fillable = [
        'country_id',
        'title',
        'slug',
        'description',
        // 'image',
        'created_by',
        'status'

    ];
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    protected $with = ['image'];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
