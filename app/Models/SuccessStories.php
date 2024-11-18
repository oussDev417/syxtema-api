<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuccessStories extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'thumbnail',
        'body',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
