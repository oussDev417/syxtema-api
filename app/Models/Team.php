<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'id',
        'nom',
        'profession',
        'avatar',
        'facebook_url',
        'linkedin_url',
    ];
}
