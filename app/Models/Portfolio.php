<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'client',
        'url',
        'location',
        'image',
        ];
}
