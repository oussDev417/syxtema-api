<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coworking extends Model
{
    protected $fillable = [
        'id',
        'name',
        'images',
        'address',
        'description',
        'price',
        'capacity',
        'status',
    ];
}
