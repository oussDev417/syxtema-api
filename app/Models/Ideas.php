<?php

namespace App\Models;
use App\Models\IdeasCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Ideas extends Model
{
    protected $fillable = [
        'tenant_id',
        'ideas_category_id',
        'title',
        'description',
        'slug',
        'status',
        'created_by',
        'image'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category(){
        return $this->belongsTo(IdeasCategory::class, 'ideas_category_id');
    }
}
