<?php

namespace App\Models;
use App\Models\NewsCategory;
use App\Models\Country;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'id',
        'news_category_id',
        'country_id',
        'title',
        'slug',
        'description',
        'image',
        'created_by',
        'status'
        
    ];
    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
