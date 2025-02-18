<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Coworking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'title',
        'slug',
        'description',
        'map_url',
        'location',
        'price',
        'advantage',
        'capacity',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'capacity' => 'integer',
    ];

    // Relation avec les réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Relation avec l'image (utilisation de la table polymorphique images)
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    // Relation avec l'administrateur qui a créé l'espace
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
