<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ideas extends Model
{
    protected $fillable = [
        'id',
        'ideas_category_id',
        'title',
        'description',
        'slug',
        'status',
        'created_by',
        'image'
    ];
}
