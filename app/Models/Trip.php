<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['route_id', 'bus_id', 'departs_at', 'arrives_at'])]
class Trip extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'departs_at' => 'datetime',
            'arrives_at' => 'datetime',
        ];
    }

    /**
     * Route this trip operates on.
     */
    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    /**
     * Bus assigned to this trip.
     */
    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    /**
     * Fares applicable to this trip, one per class.
     */
    public function fares(): HasMany
    {
        return $this->hasMany(TripFare::class);
    }

    /**
     * Seat inventory for this trip.
     */
    public function seats(): HasMany
    {
        return $this->hasMany(TripSeat::class);
    }
}
