<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'id',
        'short_name',
       'country_name',
       'flag',
        'slug',
        'phonecode',
        'continent',
        'status',
    ];
}
