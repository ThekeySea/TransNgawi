<?php

namespace App\Models;

use App\Enums\TripSeatStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['trip_id', 'seat_code', 'class_name', 'status', 'hold_expires_at', 'held_by_booking_id'])]
class TripSeat extends Model
{
    protected function casts(): array
    {
        return [
            'status' => TripSeatStatus::class,
            'hold_expires_at' => 'datetime',
        ];
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function heldByBooking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'held_by_booking_id');
    }

    /**
     * Check if this seat's hold has expired.
     */
    public function isHoldExpired(): bool
    {
        return $this->status === TripSeatStatus::HELD
            && $this->hold_expires_at !== null
            && $this->hold_expires_at->isPast();
    }
}
