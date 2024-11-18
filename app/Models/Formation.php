<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = [
        'id',
        'formation_category_id',
        'instructor_id',
        'country_id',
        'departement_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'price',
        'status',
        'level',
        'url',
    ];
    public function category()
    {
        return $this->belongsTo(FormationCategory::class, 'formation_category_id');
    }
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}
