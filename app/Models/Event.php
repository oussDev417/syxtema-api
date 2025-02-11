<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EventCategory;
use App\Models\Country;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Event extends Model
{
    protected $fillable = [
        'event_category_id',
        'country_id',
        'departement_id',
        'title',
        'type',
        'slug',
        // 'thumbnail',
        'start_date',
        'end_date',
        'location',
        'price',
        'number_of_ticket',
        'number_of_ticket_left',
        'description',
        'created_by',
        'status',
    ];
    protected $with = ['thumbnail'];
    public function thumbnail(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }
}
