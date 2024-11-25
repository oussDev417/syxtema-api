<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'id',
        'language',
        'iso_code',
        'flag_id',
        'rtl',
        'status',
        'default',
    ];
}
