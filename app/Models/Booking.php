<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'user_id', 'trip_id', 'status', 'passenger_name', 'passenger_email', 'passenger_phone', 'subtotal', 'total', 'hold_expires_at', 'paid_at', 'payment_proof', 'payment_note'])]
class Booking extends Model
{
    protected function casts(): array
    {
        return [
            'subtotal' => 'integer',
            'total' => 'integer',
            'hold_expires_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(BookingSeat::class);
    }

    /**
     * Generate a unique booking code.
     */
    public static function generateCode(): string
    {
        do {
            $code = 'TN' . strtoupper(bin2hex(random_bytes(3)));
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
