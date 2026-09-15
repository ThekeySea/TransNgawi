<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['booking_id', 'trip_id', 'refund_amount', 'refund_percentage', 'reason', 'type'])]
class Refund extends Model
{
    protected function casts(): array
    {
        return [
            'refund_amount' => 'integer',
            'refund_percentage' => 'integer',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
