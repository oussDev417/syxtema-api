<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'id',
        'name',
        'code',
        'iso_code',
        'phone_code',
        'status',
    ];
}
