<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'coworking_id',
        'event_id',
        'message',
        'datestart',
        'dateend',
        'status'
    ];

    protected $casts = [
        'datestart' => 'datetime',
        'dateend' => 'datetime',
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec l'espace de coworking
    public function coworking()
    {
        return $this->belongsTo(Coworking::class);
    }

    // Relation avec l'événement (si applicable)
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Scope pour les réservations en attente
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope pour les réservations approuvées
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope pour les réservations rejetées
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
} 