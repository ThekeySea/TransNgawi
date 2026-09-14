<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['location_id', 'name', 'address', 'is_important_point'])]
class StopPoint extends Model
{
    protected function casts(): array
    {
        return [
            'is_important_point' => 'boolean',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function tripsAsOrigin(): HasMany
    {
        return $this->hasMany(Trip::class, 'origin_stop_point_id');
    }

    public function tripsAsDestination(): HasMany
    {
        return $this->hasMany(Trip::class, 'destination_stop_point_id');
    }
}
