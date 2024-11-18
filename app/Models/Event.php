<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'id',
        'event_category_id',
        'country_id',
        'departement_id',
        'title',
        'slug',
        'thumbnail',
        'date',
        'location',
        'price',
        'number_of_ticket_left',
        'description',
        'status',
    ];
    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
