<?php

namespace App\Models;
use App\Models\News;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $fillable = [
        'tenant_id',
        'name',
        'slug',
        'status',
    ];

    public function news(){
        return $this->hasMany(News::class);
    }
}
