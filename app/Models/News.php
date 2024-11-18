<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'news_category_id',
        'country_id',
        'title',
        'description',
        'image',
        'status',
        
    ];
}
