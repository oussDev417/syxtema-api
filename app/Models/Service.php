<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceCategory;
use App\Models\Departement;

class Service extends Model
{
    protected $fillable = [
        'id',
        'service_category_id',
        'departement_id',
        'name',
        'logo', 
        'secteur',
        'description',
        'status',
    ];

    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
