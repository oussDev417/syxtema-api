<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Location\app\Models\Country;
class Recruitment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'country_id',
        'title',
        'description',
        'file_pdf',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Check if the recruitment is expired
     */
    public function isExpired(): bool
    {
        return $this->deadline->isPast();
    }
}
