<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $fillable = [
        'id',
        'title',
        'vision',
        'goal',
        'youtube_url',
        'description',
        'image',
        ];
}
