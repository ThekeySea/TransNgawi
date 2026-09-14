<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['booking_id', 'trip_seat_id', 'seat_code', 'class_name', 'fare_amount'])]
class BookingSeat extends Model
{
    protected function casts(): array
    {
        return [
            'fare_amount' => 'integer',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function tripSeat(): BelongsTo
    {
        return $this->belongsTo(TripSeat::class);
    }
}
