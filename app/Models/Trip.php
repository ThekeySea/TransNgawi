<?php

namespace App\Models;

use App\Enums\TripStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'trip_code', 'route_id', 'bus_id', 'status', 'departs_at', 'arrives_at',
    'amenities', 'exterior_photos', 'interior_photos', 'facility_photos',
    'origin_stop_point_id', 'destination_stop_point_id',
    'origin_address', 'destination_address',
    'rest_stop_name', 'rest_stop_address',
    'policy',
])]
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
            'amenities' => 'array',
            'exterior_photos' => 'array',
            'interior_photos' => 'array',
            'facility_photos' => 'array',
            'status' => TripStatus::class,
        ];
    }

    /**
     * Prevent trip_code from being updated after creation.
     */
    protected static function booted(): void
    {
        static::creating(function (Trip $trip) {
            if (empty($trip->trip_code)) {
                $trip->trip_code = self::generateCode();
            }
        });

        static::updating(function (Trip $trip) {
            if ($trip->isDirty('trip_code') && $trip->getOriginal('trip_code')) {
                $trip->trip_code = $trip->getOriginal('trip_code');
            }
        });
    }

    /**
     * Generate a unique trip code (e.g., TRIP-20260914-X89A).
     */
    public static function generateCode(): string
    {
        do {
            $code = 'TRIP-' . now()->format('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
        } while (self::where('trip_code', $code)->exists());

        return $code;
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

    /**
     * Bookings for this trip.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Refunds generated from this trip.
     */
    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }

    /**
     * Origin stop point / titik berangkat.
     */
    public function originStopPoint(): BelongsTo
    {
        return $this->belongsTo(StopPoint::class, 'origin_stop_point_id');
    }

    /**
     * Destination stop point / titik destinasi.
     */
    public function destinationStopPoint(): BelongsTo
    {
        return $this->belongsTo(StopPoint::class, 'destination_stop_point_id');
    }
}
